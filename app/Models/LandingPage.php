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
        'title',
        'slug',
        'phone',
        'email',
        'country',
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
        'published'
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

    // এক ল্যান্ডিং পেজের একজন মালিক থাকবে
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // এক ল্যান্ডিং পেজ একটি নির্দিষ্ট টেমপ্লেট ব্যবহার করতে পারে
    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    // এক ল্যান্ডিং পেজ একটি ক্যাটাগরির অন্তর্ভুক্ত হতে পারে
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // এক ল্যান্ডিং পেজ একাধিক প্রোডাক্টের সাথে যুক্ত হতে পারে (Many-to-Many)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'landing_page_product');
    }
}
