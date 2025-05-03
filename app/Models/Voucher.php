<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code', 'provider', 'issued_to_id',
        'issued_at', 'used', 'used_at', 'notes'
    ];
}