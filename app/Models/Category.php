<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getImageUrlAttribute()
    {
        return asset('category_images/' . $this->image);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function landingPages()
    {
        return $this->hasMany(LandingPage::class);
    }
}
