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
        'order_id'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
