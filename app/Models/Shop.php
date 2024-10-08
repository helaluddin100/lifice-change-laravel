<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id ',
        'shop_type',
        'email',
        'number',
        'country',
        'address',
        'details',
        'shop_url',
        'vat_tax',
        'payment_message',
        'facebook',
        'instagram',
        'linkedin',
        'youtube',
        'tiktok',
        'telegram',
        'whatsapp',
        'discord',
        'color',
        'logo',
        'default_delivery_charge',
        'specific_delivery_charges',
        'delivery_charge_note',
        'stock_management',
        'show_product_sold_count',
        'shop_domain',
        'subdomain_id',
        'shop_domain_name',
        'shop_subdomain_name',
        'gtm_id',
        'facebook_pixel_id',
        'facebook_pixel_event',
        'facebook_pixel_access_token',
        'whatsapp_chat',
        'live_chat_whatsapp'
    ];





    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function colors()
    {
        return $this->hasMany(Color::class);
    }
}
