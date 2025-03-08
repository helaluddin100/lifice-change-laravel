<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\HomeSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

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

        // Handle image uploads and store in storage
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Generate a unique image name
            $imageName = md5(uniqid()) . '.webp';

            // Open the uploaded image
            $img = Image::make($image);

            // Convert the image to WebP format and reduce file size (80 quality)
            $img->encode('webp', 80);

            // Store the image in storage/app/public/sliders
            $img->save(storage_path('app/public/sliders/' . $imageName));

            // Set the image path to be stored in the database
            $imagePath = 'sliders/' . $imageName;
        }

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

            // Handle new image upload
            $image = $request->file('image');

            // Generate a unique image name
            $imageName = md5(uniqid()) . '.webp';

            // Open the uploaded image
            $img = Image::make($image);

            // Convert the image to WebP format and reduce file size (80 quality)
            $img->encode('webp', 80);

            // Save the new image in storage/public/sliders
            $img->save(storage_path('app/public/sliders/' . $imageName));

            // Set the new image path
            $slider->image = 'sliders/' . $imageName;
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
