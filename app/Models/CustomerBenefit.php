<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBenefit extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'shop_id',
        'image',
        'name',
        'short_description',
        'status',
    ];

    // Each slider belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Each slider belongs to a shop
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}