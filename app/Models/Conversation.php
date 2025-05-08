<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'type'];
    
    /**
     * Get the participants in this conversation
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
                    ->withPivot('last_read_at')
                    ->withTimestamps();
    }
    
    /**
     * Get all messages in this conversation
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
    /**
     * Get the latest message in this conversation
     */
    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }
    
    /**
     * Check if this is an intern-mentor conversation
     */
    public function isInternMentorConversation()
    {
        return $this->type === 'intern_mentor';
    }
    
    /**
     * Check if this is a mentor-admin conversation
     */
    public function isMentorAdminConversation()
    {
        return $this->type === 'mentor_admin';
    }
    
    /**
     * Get unread messages count for a specific user
     */
    public function unreadMessagesCount($userId)
    {
        return $this->messages()
            ->where('user_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }
}