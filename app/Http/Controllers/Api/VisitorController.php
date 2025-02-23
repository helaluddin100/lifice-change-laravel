<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\VisitorData;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function store(Request $request)
    {
        // Validation for incoming data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'shop_id' => 'required|exists:shops,id',
            'ip_address' => 'required|string',
            'browser' => 'required|string',
            'device_type' => 'required|string',
            'screen_width' => 'required|integer',
            'screen_height' => 'required|integer',
            'country' => 'required|string',
            'city' => 'required|string',
            'referrer' => 'nullable|string',
            'current_url' => 'required|string',
            'region' => 'nullable|string',
            'loc' => 'nullable|string',
            'postal' => 'nullable|string',
            'timezone' => 'nullable|string',
            'isp_name' => 'nullable|string',
            'isp_domain' => 'nullable|string',
            'isp_type' => 'nullable|string',
            'abuse_address' => 'nullable|string',
            'vpn' => 'nullable|boolean',
        ]);

        // // Check if visitor data exists in the last 24 hours
        // $lastVisit = VisitorData::where('user_id', $request->user_id)
        //                         ->where('shop_id', $request->shop_id)
        //                         ->latest()
        //                         ->first();

        // if ($lastVisit && $lastVisit->created_at->diffInHours(now()) < 24) {
        //     return response()->json(['message' => 'Visitor data already submitted within the last 24 hours'], 400);
        // }

        // Store visitor data
        VisitorData::create($request->all());

        return response()->json(['message' => 'Visitor data saved successfully!'], 201);
    }


}
