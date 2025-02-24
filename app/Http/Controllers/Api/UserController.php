<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use File;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
class UserController extends Controller
{
    public function updateUser(Request $request, $id)
{
    // Check if the user is authenticated
    if (!$id) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Validate the incoming request data
    $request->validate([
        'name' => 'required|string',
        'address' => 'required|string',
        'phone' => 'required|string',
        'about' => 'nullable|string',
        'city' => 'nullable|string',
        'Region' => 'nullable|string',
        'country' => 'nullable|string',
        'ip' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
    ]);

    // Find the authenticated user
    $user = User::findOrFail($id);
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // Update user data
    $user->name = $request->input('name');
    $user->address = $request->input('address');
    $user->phone = $request->input('phone');
    $user->about = $request->input('about');
    $user->city = $request->input('city');
    $user->Region = $request->input('Region');
    $user->country = $request->input('country');
    $user->ip = $request->input('ip');
    $user->save();

    // Handle image upload
    if ($request->hasFile('image')) {
        // Generate a unique image name
        $imageName = md5(uniqid()) . '.webp';

        // Open the uploaded image and convert it to WEBP format
        $image = $request->file('image');
        $img = Image::make($image);

        // Convert the image to WebP format and reduce file size
        $img->encode('webp', 80); // 80 is the quality level, adjust as needed

        // Save the image in the public directory
        $img->save(public_path('assets/images/user/' . $imageName));

        // Delete the existing image file, if any
        if (!empty($user->image) && File::exists(public_path($user->image))) {
            File::delete(public_path($user->image));
        }

        // Update the user's image attribute in the database
        $user->update(['image' => 'assets/images/user/' . $imageName]);
    }

    return response()->json(['message' => 'User profile updated successfully']);
}


}
