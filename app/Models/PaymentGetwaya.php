<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGetwaya extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'getwaya_id',
        'type',
        'account_number',
        'getwaya_instruction',
        'qr_code_image',
        'api_mood',
        'store_id',
        'store_password',
        'api_key',
        'api_secret',
        'status',
    ];
    protected $casts = [
        'status' => 'boolean',
    ];
}
