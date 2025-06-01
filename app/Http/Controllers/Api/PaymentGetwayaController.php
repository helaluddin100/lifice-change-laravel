<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\PaymentGetwaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class PaymentGetwayaController extends Controller
{
    public function getUserGateways($id)
    {
        $gateways = PaymentGetwaya::where('user_id', $id)
            ->where('status', 1)
            ->get();


        return response()->json([
            'data' => $gateways,
        ], 200);
    }



    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'getwaya_id' => 'required|string',
            'type' => 'nullable|string',
            'account_number' => 'nullable|string',
            'getwaya_instruction' => 'nullable|string',
            'qr_code_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'api_mood' => 'nullable|string',
            'store_id' => 'nullable|string',
            'store_password' => 'nullable|string',
            'api_key' => 'nullable|string',
            'api_secret' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $validated['user_id'] = $id;

        // ✅ যদি স্ট্যাটাস true হয় তাহলে আগের সবগুলোর status 0 করে দাও
        if (!empty($validated['status']) && $validated['status'] == 1) {
            PaymentGetwaya::where('user_id', $id)
                ->where('getwaya_id', $validated['getwaya_id'])
                ->update(['status' => 0]);
        }

        // QR কোড ইমেজ প্রসেসিং
        if ($request->hasFile('qr_code_image')) {
            $image = $request->file('qr_code_image');
            $directory = public_path('storage/qr_codes');

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true, true);
            }

            $filename = time() . '_' . uniqid() . '.webp';

            $img = Image::make($image)->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 80);

            $img->save($directory . '/' . $filename);

            $validated['qr_code_image'] = '/storage/qr_codes/' . $filename;
        }

        // Update or Create
        $gateway = PaymentGetwaya::updateOrCreate(
            [
                'user_id' => $id,
                'getwaya_id' => $validated['getwaya_id'],
                'type' => $validated['type'],
            ],
            $validated
        );

        return response()->json([
            'message' => 'Payment gateway stored/updated successfully.',
            'data' => $gateway,
        ], 200);
    }




    public function getGateway($user_id, $getwaya_id, $type)
    {
        $gateway = PaymentGetwaya::where('user_id', $user_id)
            ->where('getwaya_id', $getwaya_id)
            ->where('type', $type)
            ->first();

        if (!$gateway) {
            return response()->json([
                'message' => 'No matching payment gateway found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'message' => 'Payment gateway fetched successfully.',
            'data' => $gateway,
        ], 200);
    }
}
