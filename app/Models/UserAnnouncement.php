<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAnnouncement extends Model
{
    protected $fillable = ['announcement_id', 'intern_id', 'read_at'];
    public $timestamps = false;
}