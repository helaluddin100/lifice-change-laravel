<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\PaymentGetwaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // QR Code Image Upload
        if ($request->hasFile('qr_code_image')) {
            $image = $request->file('qr_code_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('qr_codes', $imageName, 'public');
            $validated['qr_code_image'] = '/storage/' . $imagePath;
        }

        // Update if exists or create new
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




    public function update(Request $request, $id)
    {
        $gateway = PaymentGetwaya::where('user_id', Auth::id())->findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|string',
            'getwaya_id' => 'sometimes|string',
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

        if ($request->hasFile('qr_code_image')) {
            $image = $request->file('qr_code_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('qr_codes', $imageName, 'public');
            $data['qr_code_image'] = '/storage/' . $imagePath;
        }

        $gateway->update($data);

        return response()->json(['message' => 'Payment gateway updated successfully.', 'data' => $gateway]);
    }
}
