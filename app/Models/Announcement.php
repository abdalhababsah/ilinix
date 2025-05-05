<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Announcement extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'message'];
    public $timestamps = false;
}