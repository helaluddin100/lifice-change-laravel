<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodaySellProduct extends Model
{
    use HasFactory;


    protected $fillable = ['user_id', 'shop_id', 'product_id'];

    // Define the relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with Shop model
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // Define the relationship with Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}