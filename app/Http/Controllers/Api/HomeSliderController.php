<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\HomeSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeSliderController extends Controller
{
    public function index($shop_id)
    {
        $sliders = HomeSlider::with(['user', 'shop'])
            ->where('shop_id', $shop_id)
            ->where('status', true)
            ->get();

        return response()->json($sliders, 200);
    }

    // Create a new slider
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'shop_id' => 'required|exists:shops,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Check if the user already has 5 sliders for the shop
        $sliderCount = HomeSlider::where('user_id', $request->user_id)
            ->where('shop_id', $request->shop_id)
            ->count();

        if ($sliderCount >= 5) {
            return response()->json([
                'error' => 'You can only create a maximum of 5 sliders for this shop.'
            ], 400);
        }

        // Upload the image
        $imagePath = $request->file('image')->store('sliders', 'public');

        // Create the new slider
        $slider = HomeSlider::create([
            'user_id' => $request->user_id,
            'shop_id' => $request->shop_id,
            'image' => $imagePath,
            'link' => $request->link,
            'status' => true,
        ]);

        return response()->json([
            'message' => 'Slider added successfully',
            'slider' => $slider->load('user', 'shop'),
        ], 201);
    }



    // Update a slider
    public function update(Request $request, $id)
    {
        $slider = HomeSlider::find($id);
        if (!$slider) {
            return response()->json(['error' => 'Slider not found'], 404);
        }

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Check if a new image is being uploaded
        if ($request->hasFile('image')) {
            // Delete the old image from storage if it exists
            if ($slider->image && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }

            // Store the new image and update the slider's image field
            $slider->image = $request->file('image')->store('sliders', 'public');
        }

        // Update other fields (link and status) if provided
        $slider->link = $request->link ?? $slider->link;
        $slider->status = $request->status ?? $slider->status;

        // Save the updated slider
        $slider->save();

        // Return a response with the updated slider
        return response()->json(['message' => 'Slider updated successfully', 'slider' => $slider], 200);
    }


    // Delete a slider
    public function destroy($id)
    {
        $slider = HomeSlider::find($id);
        if (!$slider) {
            return response()->json(['error' => 'Slider not found'], 404);
        }

        // Delete image from storage
        Storage::disk('public')->delete($slider->image);

        $slider->delete();
        return response()->json(['message' => 'Slider deleted successfully'], 200);
    }
}
