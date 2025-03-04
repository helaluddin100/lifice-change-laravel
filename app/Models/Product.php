<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'product_colors',  // Added for storing colors
        'product_sizes',
        'status',
        'has_details',
        'variant_name',
        'description',
        'slug',
    ];

    protected $casts = [
        'product_details' => 'array',
        'product_info_list' => 'array',
        'product_variant' => 'array',
        'product_colors' => 'array',
        'product_sizes' => 'array',
        'images' => 'array',
        'has_variant' => 'boolean',
        'has_delivery_charge' => 'boolean',
    ];



    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }


    public function todaySellProducts()
    {
        return $this->hasMany(TodaySellProduct::class);
    }

    public function newArrival()
    {
        return $this->hasMany(NewArrival::class);
    }

    public function topSellingProducts()
    {
        return $this->hasMany(TopSellingProduct::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id'); // 'category_id' is the foreign key
    }

    public function reviews()
    {
        return $this->hasMany(Review::class); // Assuming Review model is related to Product
    }


    public function landingPages()
    {
        return $this->belongsToMany(LandingPage::class, 'landing_page_product');
    }
}
