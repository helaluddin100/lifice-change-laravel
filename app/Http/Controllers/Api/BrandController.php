<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        // Fetch all brands for a particular user_id
        $brands = Brand::where('user_id', $user_id)->get();

        if ($brands->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No brands found for this user.',
            ]);
        }

        return response()->json([
            'status' => 200,
            'data' => $brands,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg,webp|max:5120', // Changed max size to 5120 KB (5MB)
            'status' => 'required|boolean',
            'user_id' => 'required|integer|exists:users,id',
            'shop_id' => 'required|integer|exists:shops,id',
        ]);



        $brand = new Brand();
        $brand->name = $request->name;
        $brand->status = $request->status;
        $brand->user_id = $request->user_id;
        $brand->shop_id = $request->shop_id;

        // Handle image upload and convert to WebP format
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = md5(uniqid()) . '.webp'; // WEBP format

            // Ensure brand_image folder exists, if not, create it
            $imageDirectory = public_path('brand_image');
            if (!File::exists($imageDirectory)) {
                File::makeDirectory($imageDirectory, 0755, true); // Create folder if not exists
            }

            // Open the uploaded image and convert it to WEBP format
            $img = Image::make($image);

            // Convert the image to WebP format and reduce file size
            $img->encode('webp', 80);

            // Save the image in the public directory (brand_image folder)
            $img->save($imageDirectory . '/' . $imageName);

            // Assign the image name to the brand
            $brand->image = 'brand_image/' . $imageName;
        }

        // Save the brand data to the database
        $brand->save();

        return response()->json([
            'status' => 200,
            'message' => 'Brand created successfully!',
        ]);
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find the brand by ID
        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json([
                'status' => 404,
                'message' => 'Brand not found.',
            ]);
        }

        return response()->json([
            'status' => 200,
            'data' => $brand,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Update the specified brand
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg,webp|max:5120',
        ]);

        // Find the brand by ID
        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json([
                'status' => 404,
                'message' => 'Brand not found.',
            ]);
        }

        // Update the brand name and status
        $brand->name = $request->name;
        $brand->status = $request->status;

        // Handle image upload and convert to WebP format if a new image is uploaded
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($brand->image) {
                $oldImagePath = public_path($brand->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');
            $imageName = md5(uniqid()) . '.webp'; // WEBP format

            // Open the uploaded image and convert it to WEBP format
            $img = Image::make($image);
            $img->encode('webp', 80);
            $img->save(public_path('brand_image/' . $imageName));

            // Update the image name in the database
            $brand->image = 'brand_image/' . $imageName;
        }

        // Save the updated brand details
        $brand->save();

        return response()->json([
            'status' => 200,
            'message' => 'Brand updated successfully!',
            'data' => $brand,
        ]);
    }

    // Delete the specified brand
    public function destroy($id)
    {
        // Find the brand by ID
        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json([
                'status' => 404,
                'message' => 'Brand not found.',
            ]);
        }

        // Delete the brand's image file from the storage
        if ($brand->image) {
            $imagePath = public_path($brand->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete the brand record from the database
        $brand->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Brand deleted successfully!',
        ]);
    }
}
