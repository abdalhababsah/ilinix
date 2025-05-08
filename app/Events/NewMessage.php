<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
        // Load relationships
        $this->message->load(['sender', 'attachments']);
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->message->conversation_id),
        ];
    }
    
    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'new.message';
    }
    
    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'conversation_id' => $this->message->conversation_id,
            'message' => $this->message->message,
            'created_at' => $this->message->created_at->format('Y-m-d H:i:s'),
            'formatted_time' => $this->message->created_at->format('g:i A'),
            'formatted_date' => $this->message->created_at->format('M d, Y'),
            'sender' => [
                'id' => $this->message->sender->id,
                'name' => $this->message->sender->first_name .' '. $this->message->sender->last_name,
                'role_id' => $this->message->sender->role_id,
            ],
            'attachments' => $this->message->attachments->map(function($attachment) {
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
    }
}