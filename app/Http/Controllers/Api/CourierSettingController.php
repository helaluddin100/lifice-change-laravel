<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourierSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CourierSettingController extends Controller
{

    public function show($user_id)
    {
        $courierSettings = CourierSetting::where('user_id', $user_id)->first();

        if (!$courierSettings) {
            return response()->json(['error' => 'Courier settings not found for the user.'], 404);
        }

        return response()->json($courierSettings);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'courier_name' => 'required|string',
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
            'base_url' => 'required|url'
        ]);

        $courierSetting = CourierSetting::updateOrCreate(
            ['user_id' => $request->user()->id],
            $data
        );

        return response()->json(['message' => 'Courier settings saved!', 'courier_setting' => $courierSetting]);
    }


    public function getAccessToken($user_id)
    {
        // CourierSetting মডেল থেকে ইউজারের credential নিয়ে আসা
        $credentials = CourierSetting::where('user_id', $user_id)->first();

        if (!$credentials) {
            return response()->json(['error' => 'User credentials not found'], 404);
        }

        $client_id = $credentials->client_id;
        $client_secret = $credentials->client_secret;
        $username = $credentials->username;  // তোমার ইমেল এখানে
        $password = $credentials->password;  // তোমার পাসওয়ার্ড এখানে

        // Pathao API তে Access Token নিয়ে আসা
        $response = Http::post('https://api-hermes.pathao.com/aladdin/api/v1/issue-token', [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'grant_type' => 'password',
            'username' => $username,
            'password' => $password,
        ]);

        $data = $response->json();

        if ($response->successful() && isset($data['access_token'])) {
            return $data['access_token'];
        }

        return response()->json(['error' => 'Failed to get access token'], 500);
    }

    public function getCities($user_id)
    {
        // Access Token নিয়ে আসা
        $accessToken = $this->getAccessToken($user_id);

        if (isset($accessToken['error'])) {
            return response()->json(['error' => 'Unable to get access token'], 500);
        }

        // সিটি লিস্ট পেতে Pathao API তে কল
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken
        ])->get('https://api-hermes.pathao.com/aladdin/api/v1/city-list');

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Failed to fetch city list'], 500);
    }



    public function getZones($user_id, $city_id)
    {
        // CourierSetting মডেল থেকে ইউজারের credential নিয়ে আসা
        $credentials = CourierSetting::where('user_id', $user_id)->first();

        if (!$credentials) {
            return response()->json(['error' => 'User credentials not found'], 404);
        }

        $accessToken = $this->getAccessToken($user_id);

        if (isset($accessToken['error'])) {
            return response()->json(['error' => 'Unable to get access token'], 500);
        }

        // সিটি ভিত্তিক জোন লিস্ট পেতে Pathao API তে কল
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken
        ])->get("https://api-hermes.pathao.com/aladdin/api/v1/cities/{$city_id}/zone-list");

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Failed to fetch zone list'], 500);
    }


    public function getAreas($user_id, $zone_id)
    {
        // CourierSetting মডেল থেকে ইউজারের credential নিয়ে আসা
        $credentials = CourierSetting::where('user_id', $user_id)->first();

        if (!$credentials) {
            return response()->json(['error' => 'User credentials not found'], 404);
        }

        $accessToken = $this->getAccessToken($user_id);

        if (isset($accessToken['error'])) {
            return response()->json(['error' => 'Unable to get access token'], 500);
        }

        // জোন ভিত্তিক এরিয়া লিস্ট পেতে Pathao API তে কল
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken
        ])->get("https://api-hermes.pathao.com/aladdin/api/v1/zones/{$zone_id}/area-list");

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Failed to fetch area list'], 500);
    }
}
