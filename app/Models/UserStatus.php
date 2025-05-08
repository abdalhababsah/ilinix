<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    use HasFactory;
    
    protected $table = 'user_status';
    
    protected $fillable = ['user_id', 'status', 'last_activity'];
    
    protected $dates = ['last_activity'];
    
    /**
     * Get the user this status belongs to
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Check if the user is online
     */
    public function isOnline()
    {
        return $this->status === 'online';
    }
    
    /**
     * Update the user status
     */
    public static function updateStatus($userId, $status)
    {
        return self::updateOrCreate(
            ['user_id' => $userId],
            ['status' => $status, 'last_activity' => now()]
        );
    }
}