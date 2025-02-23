<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'ip_address',
        'browser',
        'device_type',
        'screen_width',
        'screen_height',
        'country',
        'city',
        'referrer',
        'current_url',
        'region',
        'loc',
        'postal',
        'timezone',
        'isp_name',
        'isp_domain',
        'isp_type',
        'abuse_address',
        'vpn',
    ];
    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Shop
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}