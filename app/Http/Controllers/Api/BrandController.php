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
    public function index()
    {
        //
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

        // Slug creation
        $slug = Str::slug($request->name);
        $count = Brand::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->status = $request->status;
        $brand->slug = $slug;
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
            $brand->image = $imageName;
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
