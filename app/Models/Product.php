<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'shop_id',
        'category_id',
        'name',
        'category',
        'current_price',
        'old_price',
        'buy_price',
        'product_code',
        'quantity',
        'warranty',
        'sold_count',
        'product_details',
        'product_info_list',
        'has_variant',
        'product_variant',
        'has_delivery_charge',
        'delivery_charge',
        'images',
        'video',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status'
    ];

    protected $casts = [
        'product_details' => 'array',
        'product_info_list' => 'array',
        'product_variant' => 'array',
        'images' => 'array',
        'has_variant' => 'boolean',
        'has_delivery_charge' => 'boolean',
    ];
}
