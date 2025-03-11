<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function landingPages()
    {
        return $this->hasMany(LandingPage::class, 'country_id');
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}
