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
        'vat_tax',
        'payment_message',
        'facebook',
        'instagram',
        'linkedin',
        'youtube',
        'tiktok',
        'telegram',
        'whatsapp',
        'discord',
        'color',
        'logo',
        'default_delivery_charge',
        'specific_delivery_charges',
        'delivery_charge_note',
        'stock_management',
        'show_product_sold_count',
        'shop_domain',
        'subdomain_id',
        'shop_domain_name',
        'shop_subdomain_name',
        'gtm_id',
        'facebook_pixel_id',
        'facebook_pixel_event',
        'facebook_pixel_access_token',
        'whatsapp_chat',
        'live_chat_whatsapp',
        'slider',
        'today_sell',
        'new_arrival',
        'new_arrival_banner',
        'offer_product',
        'hot_deal',
        'flash_deal',
        'top_rated',
        'top_selling',
        'top_category',
        'related_product',
        'customer_benefit',
        'template_type',
    ];


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function colors()
    {
        return $this->hasMany(Color::class);
    }


    public function aboutUs()
    {
        return $this->hasOne(AboutUs::class);
    }
    public function privacyPolicies()

    {
        return $this->hasOne(PrivacyPolicy::class);
    }
    public function terms()

    {
        return $this->hasOne(Term::class);
    }
    public function cancellations()
    {
        return $this->hasOne(Cancellation::class);
    }


    public function template()
    {
        return $this->hasOne(Template::class, 'id', 'template_type'); // Adjust the column names
    }


    public function homeSliders()
    {
        return $this->hasMany(HomeSlider::class);
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


    public function newArrivalBanner()
    {
        return $this->hasMany(NewArrivalBanner::class);
    }


    // Relationship with VisitorData
    public function visitorData()
    {
        return $this->hasMany(VisitorData::class);
    }
}
