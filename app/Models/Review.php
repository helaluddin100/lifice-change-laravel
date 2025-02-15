<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'shop_id',
        'name',
        'rating',
        'review',
        'status',
        'parent_id'
    ];

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship with Shop
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // Self-relationship for Review Replies
    public function replies()
    {
        return $this->hasMany(Review::class, 'parent_id')->with('replies');
    }
}