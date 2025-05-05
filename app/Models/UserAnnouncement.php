<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UserAnnouncement extends Model
{
    use HasFactory;
    protected $fillable = ['announcement_id', 'intern_id', 'read_at'];
    public $timestamps = false;
}