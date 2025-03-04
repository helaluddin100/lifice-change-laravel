<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'image', 'description', 'status'];


    // A template can be used by many shops
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }


    public function landingPages()
    {
        return $this->hasMany(LandingPage::class);
    }
}
