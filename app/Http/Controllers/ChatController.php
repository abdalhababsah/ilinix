<?php

namespace App\Http\Controllers;

use App\Events\MessagesRead;
use App\Events\NewMessage;
use App\Events\UserStatusChanged;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageAttachment;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    /**
     * Display the chat interface
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get all conversations for this user
        $conversations = $user->conversations()
            ->with(['participants' => function($query) use ($user) {
                $query->where('users.id', '!=', $user->id);
            }])
            ->with('latestMessage')
            ->get();
        
        // Find active conversation if any
        $activeConversation = null;
        if (session()->has('active_conversation')) {
            $activeConversation = $user->conversations()
                ->with(['participants' => function($query) use ($user) {
                    $query->where('users.id', '!=', $user->id);
                }])
                ->find(session('active_conversation'));
        }
        
        // Get contacts this user can chat with based on role
        $contacts = [];
        if ($user->isAdmin()) {
            // Admin can chat with mentors
            $contacts = User::where('role_id', 2)->get();
        } elseif ($user->isMentor()) {
            // Mentor can chat with their interns and admin
            $interns = $user->interns;
            $admins = User::where('role_id', 1)->get();
            $contacts = $interns->merge($admins);
        } elseif ($user->isIntern()) {
            // Intern can only chat with their mentor
            if ($user->mentor) {
                $contacts = collect([$user->mentor]);
            }
        }
        
        // Set user as online
        UserStatus::updateStatus($user->id, 'online');
        
        // dd($contacts);
        return view('chat.index', compact('conversations', 'contacts', 'activeConversation'));
    }
    
    /**
     * Get messages for a conversation
     */
    public function getMessages($id)
    {
        $user = Auth::user();
        
        // Check if user is part of this conversation
        $conversation = $user->conversations()
            ->with(['participants' => function($query) use ($user) {
                $query->where('users.id', '!=', $user->id);
            }])
            ->findOrFail($id);
            
        // Get messages for this conversation with desired formatting
        $messages = $conversation->messages()
            ->with(['sender', 'attachments'])
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'conversation_id' => $message->conversation_id,
                    'message' => $message->message,
                    'created_at' => $message->created_at->format('Y-m-d H:i:s'),
                    'formatted_time' => $message->created_at->format('g:i A'),
                    'formatted_date' => $message->created_at->format('M d, Y'),
                    'sender' => [
                        'id' => $message->sender->id,
                        'name' => $message->sender->first_name ." ". $message->sender->last_name,
                        'role_id' => $message->sender->role_id,
                    ],
                    'attachments' => $message->attachments->map(function($attachment) {
                        return [
                            'id' => $attachment->id,
                            'file_name' => $attachment->file_name,
                            'url' => $attachment->url,
                            'file_type' => $attachment->file_type,
                            'file_size' => $attachment->formatted_size,
                            'is_image' => $attachment->isImage(),
                        ];
                    })
                ];
            });
        
        // Mark all unread messages from others as read
        $conversation->messages()
            ->where('user_id', '!=', $user->id)
            ->where('is_read', false)
            ->each(function ($message) {
                $message->markAsRead();
            });
        
        // Update last read timestamp
        $conversation->participants()
            ->where('user_id', $user->id)
            ->update(['last_read_at' => now()]);
            
        // Broadcast that messages were read
        broadcast(new MessagesRead($user, $conversation))->toOthers();
        
        // Save active conversation in session
        session(['active_conversation' => $conversation->id]);
        
        // Load other participant info
        $otherParticipant = $conversation->participants->first();
        
        return response()->json([
            'conversation' => [
                'id' => $conversation->id,
                'type' => $conversation->type,
                'name' => $otherParticipant ? $otherParticipant->full_name : 'Unnamed Conversation',
                'other_participant' => $otherParticipant,
            ],
            'messages' => $messages
        ]);
    }
    
    /**
     * Create a new conversation or get existing one
     */
    public function getOrCreateConversation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $currentUser = Auth::user();
        $otherUser = User::findOrFail($request->user_id);
        
        // Determine conversation type based on user roles
        $type = 'intern_mentor';
        if (
            ($currentUser->isAdmin() && $otherUser->isMentor()) || 
            ($currentUser->isMentor() && $otherUser->isAdmin())
        ) {
            $type = 'mentor_admin';
        }
        
        // Check if conversation exists
        $conversation = Conversation::whereHas('participants', function($query) use ($currentUser) {
                $query->where('users.id', $currentUser->id);
            })
            ->whereHas('participants', function($query) use ($otherUser) {
                $query->where('users.id', $otherUser->id);
            })
            ->where('type', $type)
            ->first();
        
        // Create new conversation if it doesn't exist
        if (!$conversation) {
            $conversation = new Conversation();
            $conversation->type = $type;
            $conversation->save();
            
            // Add participants
            $conversation->participants()->attach([
                $currentUser->id => ['last_read_at' => now()],
                $otherUser->id => ['last_read_at' => null]
            ]);
        }
        
        // Set active conversation in session
        session(['active_conversation' => $conversation->id]);
        
        return response()->json([
            'conversation_id' => $conversation->id
        ]);
    }
    
    /**
     * Send a message
     */
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required_without:attachments|nullable|string',
            'attachments.*' => 'nullable|file|max:10240', // 10MB max per file
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $user = Auth::user();
        $conversationId = $request->conversation_id;
        
        // Check if user is part of this conversation
        $conversation = $user->conversations()->findOrFail($conversationId);
        
        // Create the message
        $message = new Message();
        $message->conversation_id = $conversationId;
        $message->user_id = $user->id;
        $message->message = $request->message;
        $message->is_read = false;
        $message->save();
        
        // Handle file attachments if any
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // Generate safe filename
                $fileName = $file->getClientOriginalName();
                $safeFileName = pathinfo($fileName, PATHINFO_FILENAME);
                $safeFileName = Str::slug($safeFileName, '-');
                $extension = $file->getClientOriginalExtension();
                $finalFileName = $safeFileName . '-' . time() . '.' . $extension;
                
                // Store the file
                $path = $file->storeAs(
                    'chat_attachments/' . $conversationId,
                    $finalFileName,
                    'public'
                );
                
                // Create attachment record
                $attachment = new MessageAttachment([
                    'message_id' => $message->id,
                    'file_name' => $fileName,
                    'file_path' => $path,
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize()
                ]);
                $attachment->save();
            }
        }
        
        // Reload message with relationships for the response
        $message = Message::with(['sender', 'attachments'])->find($message->id);
        
        // Broadcast the new message event
        broadcast(new NewMessage($message))->toOthers();
        
        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
    
    /**
     * Download an attachment
     */
    public function downloadAttachment($id)
    {
        $user = Auth::user();
        $attachment = MessageAttachment::findOrFail($id);
        
        // Security check - verify user has access to this attachment
        $hasAccess = Message::where('id', $attachment->message_id)
            ->whereHas('conversation.participants', function($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->exists();
            
        if (!$hasAccess) {
            abort(403, 'You do not have permission to access this file.');
        }
        
        // Return file for download
        return Storage::disk('public')->download(
            $attachment->file_path,
            $attachment->file_name
        );
    }
    
    /**
     * Mark messages as read
     */
    public function markAsRead(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required|exists:conversations,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $user = Auth::user();
        $conversationId = $request->conversation_id;
        
        // Check if user is part of this conversation
        $conversation = $user->conversations()->findOrFail($conversationId);
        
        // Mark all unread messages from others as read
        $conversation->messages()
            ->where('user_id', '!=', $user->id)
            ->where('is_read', false)
            ->each(function($message) {
                $message->markAsRead();
            });
        
        // Update last read timestamp
        $conversation->participants()
            ->where('user_id', $user->id)
            ->update(['last_read_at' => now()]);
            
        // Broadcast that messages were read
        broadcast(new MessagesRead($user, $conversation))->toOthers();
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Delete a message
     */
    public function deleteMessage(Request $request, $id)
    {
        $user = Auth::user();
        $message = Message::findOrFail($id);
        
        // Security check - only message sender can delete
        if ($message->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You can only delete your own messages'
            ], 403);
        }
        
        // Check if message is older than 1 hour (optional restriction)
        if ($message->created_at->diffInHours(now()) > 1) {
            return response()->json([
                'success' => false,
                'message' => 'Messages can only be deleted within 1 hour of sending'
            ], 403);
        }
        
        // Soft delete the message
        $message->delete();
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Update user status
     */
    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:online,offline,away',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $user = Auth::user();
        
        // Update status
        UserStatus::updateStatus($user->id, $request->status);
        
        // Broadcast status change
        broadcast(new UserStatusChanged($user, $request->status))->toOthers();
        
        return response()->json(['success' => true]);
    }
}