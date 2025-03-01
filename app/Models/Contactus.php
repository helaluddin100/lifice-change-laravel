<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{
    use HasFactory;


    protected $table = 'contactus';

    protected $fillable = [
        'shop_id', 'name', 'email', 'phone', 'subject', 'message', 'reply','status'
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}