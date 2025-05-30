<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\PaymentGetwaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class PaymentGetwayaController extends Controller
{
    public function index()
    {
        $gateways = PaymentGetwaya::where('user_id', Auth::id())->get();
        return response()->json($gateways);
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

        // Find existing gateway if updating
        $existing = PaymentGetwaya::where('getwaya_id', $validated['getwaya_id'])
            ->where('type', $validated['type'])
            ->first();

        // Handle and optimize QR image
        if ($request->hasFile('qr_code_image')) {
            $image = $request->file('qr_code_image');

            // Directory path
            $directory = public_path('storage/qr_codes');

            // Create directory if not exists
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true, true);
            }

            // Delete old image if exists
            if ($existing && $existing->qr_code_image) {
                $oldImagePath = public_path($existing->qr_code_image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            // Create unique filename
            $filename = time() . '_' . uniqid() . '.webp';

            // Convert and optimize
            $img = Image::make($image)->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 80);

            // Save image
            $img->save($directory . '/' . $filename);

            $validated['qr_code_image'] = '/storage/qr_codes/' . $filename;
        }

        // Update or Create
        $gateway = PaymentGetwaya::updateOrCreate(
            [
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
