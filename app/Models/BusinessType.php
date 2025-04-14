<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status', 'creator', 'slug'];



    public function user()
    {
        return $this->belongsTo(User::class, 'creator');
    }

    public function products()
    {
        return $this->hasMany(DemoProduct::class);
    }

    public function categories()
    {
        return $this->hasMany(DemoCategory::class);
    }

    public function colors()
    {
        return $this->hasMany(DemoColor::class);
    }

    public function sizes()
    {
        return $this->hasMany(DemoSize::class);
    }
}
