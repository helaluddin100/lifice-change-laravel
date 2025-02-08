<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'image',
        'link',
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
