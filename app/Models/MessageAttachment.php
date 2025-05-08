<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MessageAttachment extends Model
{
    use HasFactory;
    
    protected $fillable = ['message_id', 'file_name', 'file_path', 'file_type', 'file_size'];
    
    /**
     * Get the message this attachment belongs to
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }
    
    /**
     * Get the full URL for this attachment
     */
    public function getUrlAttribute()
    {
        return Storage::disk('public')->url($this->file_path);
    }
    
    /**
     * Check if this attachment is an image
     */
    public function isImage()
    {
        return strpos($this->file_type, 'image/') === 0;
    }
    
    /**
     * Format file size for display
     */
    public function getFormattedSizeAttribute()
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unit = 0;
        
        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }
        
        return round($size, 2) . ' ' . $units[$unit];
    }
    
    /**
     * Delete the file when the model is deleted
     */
    public function delete()
    {
        Storage::disk('public')->delete($this->file_path);
        return parent::delete();
    }
}