<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_type_id',
        'name',
        'image',
        'description',
        'status'
    ];
    public function businessType()
    {
        return $this->belongsTo(BusinessType::class, 'business_type_id');
    }

    public function products()
    {
        return $this->hasMany(DemoProduct::class);
    }
}
