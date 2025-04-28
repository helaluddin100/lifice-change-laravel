<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoBrand extends Model
{
    use HasFactory;
    protected $fillable = [
        'business_type_id',
        'brand',
        'status'
    ];
    public function businessType()
    {
        return $this->belongsTo(BusinessType::class, 'business_type_id');
    }
}
