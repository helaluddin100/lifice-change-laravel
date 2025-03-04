<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'template_id',
        'category_id',
        'product_id',
        'title',
        'slug',
        'phone',
        'email',
        'country_id',
        'settings',
        'seo_settings',
        'hero_setting',
        'social_media',
        'partner',
        'testimonial',
        'feature',
        'feature_details',
        'feature_details_b',
        'faq',
        'brand_logo',
        'video_settings',
        'domain',
        'published',
        'delivery_charge',
    ];

    protected $casts = [
        'settings' => 'array',
        'seo_settings' => 'array',
        'hero_setting' => 'array',
        'social_media' => 'array',
        'partner' => 'array',
        'testimonial' => 'array',
        'feature' => 'array',
        'feature_details' => 'array',
        'feature_details_b' => 'array',
        'faq' => 'array',
        'video_settings' => 'array'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
