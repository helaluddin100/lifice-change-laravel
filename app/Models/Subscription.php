<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'package_id',
        'amount',
        'payment_method',
        'plan',
        'transaction_id',
        'status',
        'start_date',
        'end_date',
    ];
    // A subscription belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A subscription belongs to a package
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // A subscription has many payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
