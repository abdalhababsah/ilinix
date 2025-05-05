<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Voucher extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', 'provider', 'issued_to_id',
        'issued_at', 'used', 'used_at', 'notes'
    ];

    public function issuedTo(){
        return $this->belongsTo(User::class);
    }
}