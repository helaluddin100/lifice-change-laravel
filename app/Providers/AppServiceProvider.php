<?php

namespace App\Providers;

use App\Models\Shop;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Fetch all domains from the shops table
        $shop_domains = array_filter(Shop::pluck('shop_domain')->toArray(), function ($value) {
            return !is_null($value) && $value !== ''; // Remove null or empty values
        });

        // Add "https://" if the domain does not already have it
        $shop_domains = array_map(function ($domain) {
            // Check if the domain already has http:// or https://
            if (strpos($domain, 'http://') === false && strpos($domain, 'https://') === false) {
                // Add https:// if it doesn't
                return 'http://' . $domain;
            }
            return $domain;
        }, $shop_domains);


        // Update CORS configuration dynamically

        $allowedOrigins = array_merge($shop_domains, [env('FRONTEND_URL', 'http://localhost:3000')]);

        // Set the allowed origins dynamically
        Config::set('cors.allowed_origins', $allowedOrigins);

        // Update Sanctum stateful domains dynamically
        $statefulDomains = array_merge($shop_domains, explode(',', env('SANCTUM_STATEFUL_DOMAINS', '')));
        Config::set('sanctum.stateful', $statefulDomains);
    }
}
