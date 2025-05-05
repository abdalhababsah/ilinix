<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'message', 'read'];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }
    public function scopeRead($query)
    {
        return $query->where('read', true);
    }
    public function markAsRead()
    {
        $this->update(['read' => true]);
    }
    public function markAsUnread()
    {
        $this->update(['read' => false]);
    }
    public function getIsReadAttribute()
    {
        return $this->read;
    }
    public function getIsUnreadAttribute()
    {
        return !$this->read;
    }
}