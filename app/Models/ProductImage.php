<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;
    protected $table = 'product_images';


    protected $fillable = ['product_id', 'image_path', 'demo_product_id'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function demoProduct()
    {
        return $this->belongsTo(DemoProduct::class, 'demo_product_id');
    }
}
