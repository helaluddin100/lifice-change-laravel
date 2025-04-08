<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id',
        'referred_user_id',
        'amount',
    ];

    public function referredUser()
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }
}
