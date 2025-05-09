<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'package_id',
        'amount',
        'payment_method',
        'transaction_id',
        'status',
        'payment_date',
        'payment_id',
        'ragular_amount',
        'discount_amount',
        'tax_amount',
        'total_amount',
    ];


    // A payment belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A payment belongs to a subscription
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    // A payment belongs to a package
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
