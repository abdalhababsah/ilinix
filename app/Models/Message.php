<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['conversation_id', 'user_id', 'message', 'is_read', 'read_at'];
    
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'read_at'];
    
    protected $appends = ['formatted_time', 'formatted_date'];

    /**
     * Get the conversation this message belongs to
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
    
    /**
     * Get the user who sent this message
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Get the attachments for this message
     */
    public function attachments()
    {
        return $this->hasMany(MessageAttachment::class);
    }
    
    /**
     * Check if this message has attachments
     */
    public function hasAttachments()
    {
        return $this->attachments()->count() > 0;
    }
    
    /**
     * Mark this message as read
     */
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->is_read = true;
            $this->read_at = now();
            $this->save();
        }
    }


public function getFormattedTimeAttribute()
{
    return $this->created_at->format('g:i A');
}
public function getFormattedDateAttribute()
{
    return $this->created_at->toDateString();
}
protected $with = ['sender', 'attachments']; 
}