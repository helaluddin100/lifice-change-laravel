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
    ];




    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryCharges()
    {
        return $this->hasMany(DeliveryCharge::class);
    }
}
