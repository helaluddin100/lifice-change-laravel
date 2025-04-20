<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'shop_id',
        'slug',
        'image',
        'status',
    ];
    protected $casts = [
        'status' => 'boolean',
    ];
    protected $table = 'brands';


    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
