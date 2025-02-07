<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetupShopPage extends Model
{
    use HasFactory;
    protected $fillable = [
        'about_us', 'privacy_policy', 'terms_con', 'return_can', 'user_id', 'shop_id', 'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}