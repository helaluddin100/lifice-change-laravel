<?php

namespace App\Http\Controllers\Api;

use App\Models\Courier;
use Illuminate\Http\Request;
use App\Models\CourierSetting;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class CourierSettingController extends Controller
{

    public function getCourierByUser($id)
    {
        $couriers = CourierSetting::where('user_id', $id)->get();

        return response()->json($couriers);
    }



    public function editData($id)
    {
        // Fix: Correct the spelling of "find"
        $courier = CourierSetting::find($id);

        // Check if courier exists
        if ($courier) {
            return response()->json([
                'status' => 200,
                'data' => $courier,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Courier not found',
            ], 404);
        }
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'courier_id' => 'required|integer',
            'courier_name' => 'required|string',
            'client_id' => 'required|string',
            'client_secret' => 'required|string',

            'store_id' => $request->courier_type == 1 ? 'required' : 'nullable',
            'username' => $request->courier_type == 1 ? 'required' : 'nullable',
            'password' => $request->courier_type == 1 ? 'required' : 'nullable',
            'grant_type' => 'nullable|string'
        ]);

        $courierSetting = CourierSetting::updateOrCreate(
            ['user_id' => $request->user_id, 'courier_id' => $request->courier_id],
            $data
        );

        return response()->json([
            'status' => 200,
            'courier_setting' => $courierSetting,
            'message' => 'Courier settings saved!',
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate incoming data
        $data = $request->validate([
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'store_id' => $request->courier_type == 1 ? 'required' : 'nullable',
            'username' => $request->courier_type == 1 ? 'required' : 'nullable',
            'password' => $request->courier_type == 1 ? 'required' : 'nullable',
            'grant_type' => 'nullable|string'
        ]);

        // Find the existing courier setting by its ID
        $courierSetting = CourierSetting::find($id);

        if (!$courierSetting) {
            return response()->json([
                'status' => 404,
                'message' => 'Courier setting not found!',
            ], 404);
        }

        // Update the courier setting with the validated data
        $courierSetting->update($data);

        // Return a response indicating success
        return response()->json([
            'status' => 200,
            'courier_setting' => $courierSetting,
            'message' => 'Courier settings updated successfully!',
        ]);
    }


    public function index()
    {
        $couriers = Courier::all()->where('status', 1);
        return response()->json($couriers);
    }

    public function show($user_id)
    {
        $courierSettings = CourierSetting::where('user_id', $user_id)->first();

        if (!$courierSettings) {
            return response()->json(['error' => 'Courier settings not found for the user.'], 404);
        }

        return response()->json($courierSettings);
    }




    public function getAccessToken($user_id)
    {
        // CourierSetting মডেল থেকে ইউজারের credential নিয়ে আসা
        // $credentials = CourierSetting::where('user_id', $user_id )->first();
        $credentials = CourierSetting::where('user_id', $user_id)
            ->where('courier_id', 1)
            ->first();

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

    public function destroy($id)
    {
        $courierSetting = CourierSetting::find($id);

        if (!$courierSetting) {
            return response()->json([
                'status' => 404,
                'message' => 'Courier setting not found!',
            ], 404);
        }

        $courierSetting->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Courier setting deleted successfully!',
        ]);
    }

}
