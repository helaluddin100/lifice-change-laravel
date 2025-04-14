<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DemoProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_types',
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
        'product_colors',
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

    // Relationship with ProductImage
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    // Relationship with Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(DemoCategory::class);
    }

    // Relationship with BusinessType
    public function businessType(): BelongsTo
    {
        return $this->belongsTo(BusinessType::class, 'business_types');
    }

    // Additional methods for specific functionality can be added here, e.g., for handling image uploads or custom logic
}
