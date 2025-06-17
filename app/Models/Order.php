<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'name',
        'email',
        'phone',
        'address',
        'division',
        'district',
        'upazila',
        'promo_code',
        'total_price',
        'delivery_charge',
        'payment_method',
        'order_status',
        'order_id',
        'consignment_id',
        'delivery_by',
        'payment_number',
        'payment_transation_id',
        'pay_amount',
        'payment_status',
        'payment_gateway',

    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
