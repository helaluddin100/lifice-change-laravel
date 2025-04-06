<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'password',
        'verification_code',
        'email',
        'address',
        'phone',
        'about',
        'city',
        'Region',
        'country',
        'ip',
        'image',
        'status',
        'referred_by',
        'affiliate_code',
        'commission',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];



    protected static function booted()
    {
        static::creating(function ($user) {
            $user->affiliate_code = self::generateUniqueCode();
        });
    }

    public static function generateUniqueCode()
    {
        do {
            $code = strtoupper(Str::random(8)); // eg: 8-letter random uppercase
        } while (self::where('affiliate_code', $code)->exists());

        return $code;
    }


    public function referredUsers()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
    //shop table relationship
    public function shops()
    {
        return $this->hasMany(Shop::class);
    }

    public function businesses()
    {
        return $this->hasMany(BusinessType::class);
    }



    public function colors()
    {
        return $this->hasMany(Color::class);
    }

    public function aboutUs()
    {
        return $this->hasOne(AboutUs::class);
    }
    public function privacyPolicies()
    {
        return $this->hasOne(PrivacyPolicy::class);
    }
    public function terms()
    {
        return $this->hasOne(Term::class);
    }
    public function cancellations()
    {
        return $this->hasOne(Cancellation::class);
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }



    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function sizes()
    {
        return $this->hasMany(Size::class, 'user_id', 'id');
    }



    public function homeSliders(): HasMany
    {
        return $this->hasMany(HomeSlider::class);
    }

    public function todaySellProducts()
    {
        return $this->hasMany(TodaySellProduct::class);
    }


    public function newArrival()
    {
        return $this->hasMany(NewArrival::class);
    }

    public function topSellingProducts()
    {
        return $this->hasMany(TopSellingProduct::class);
    }

    public function newArrivalBanner()
    {
        return $this->hasMany(NewArrivalBanner::class);
    }


    // Relationship with VisitorData
    public function visitorData()
    {
        return $this->hasMany(VisitorData::class);
    }


    public function landingPages()
    {
        return $this->hasMany(LandingPage::class);
    }



    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function subscriptionPackages()
    {
        return $this->hasManyThrough(Package::class, Subscription::class);
    }
}
