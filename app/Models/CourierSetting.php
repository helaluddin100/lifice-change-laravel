<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'courier_name',
        'courier_id',
        'store_id',
        'client_id',
        'client_secret',
        'username',
        'password',
        'base_url',
        'grant_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
