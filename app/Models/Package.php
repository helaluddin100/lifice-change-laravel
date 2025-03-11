<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = [
        'country',
        'name',
        'product_limit',
        'page_limit',
        'email_marketing',
        'card',
        'price',
        'offer_price',
        'features',
        'description',
        'status'
    ];

    // Cast features to array
    protected $casts = [
        'features' => 'array',
    ];
    // A package has many subscriptions
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // A package has many payments (through subscription)
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Subscription::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
