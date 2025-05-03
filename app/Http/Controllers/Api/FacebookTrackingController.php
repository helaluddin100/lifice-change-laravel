<?php

namespace App\Http\Controllers\Api;

use App\Models\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class FacebookTrackingController extends Controller
{
    public static function sendEventToFacebook($shop_id, $event_name, $custom_data = [])
    {
        $shop = Shop::find($shop_id);

        // Ensure Facebook Pixel ID and Access Token are set
        $pixel_id = $shop->facebook_pixel_id;
        $access_token = $shop->facebook_pixel_access_token;

        // Prepare location and value for PageView
        $location = isset($custom_data['location']) ? $custom_data['location'] : null;
        $value = isset($custom_data['value']) ? $custom_data['value'] : null;

        // Prepare Facebook Event Data
        $data = [
            'data' => [
                [
                    'event_name' => $event_name,
                    'event_time' => time(),
                    'custom_data' => array_merge([
                        'currency' => 'USD',
                        'value' => $value, // Transaction value or page view value
                        'location' => $location, // Location (example: Division, District)
                    ], $custom_data),
                ]
            ],
            'access_token' => $access_token,
        ];

        // API URL for sending event
        $api_url = 'https://graph.facebook.com/v12.0/' . $pixel_id . '/events';

        // Send the data to Facebook via API
        $response = Http::post($api_url, $data);

        return $response->json();
    }
}
