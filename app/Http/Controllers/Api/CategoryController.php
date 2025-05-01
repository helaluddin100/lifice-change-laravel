<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->query('user_id');

        $categories = Category::where('user_id', $userId)
            ->withCount('products')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'image' => $category->image_url,
                    'product_count' => $category->products_count,
                ];
            });

        return response()->json([
            'status' => 200,
            'categories' => $categories,
        ]);
    }




    public function getCategoriesByUser($id)
    {
        $categories = Category::where('user_id', $id)
            ->where('status', 1)
            ->orderBy('id', 'desc')->get();

        $brands = Brand::where('user_id', $id)
            ->where('status', 1)
            ->orderBy('id', 'desc')->get();


        return response()->json([
            'status' => 200,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

    public function store(Request $request)
    {

        // Validate incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required',
            'status' => 'required|boolean',
        ]);
        $userId = $request->input('user_id');

        // Create a new category instance
        $category = new Category();
        $category->name = $validatedData['name'];
        $category->user_id = $userId;
        $category->status = $request->status;

        // Handle image upload and convert to WebP format
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = md5(uniqid()) . '.webp'; // WEBP format

            // Open the uploaded image and convert it to WEBP format
            $img = Image::make($image);

            // Convert the image to WebP format and reduce file size
            $img->encode('webp', 80); // 80 is the quality level, adjust as needed

            // Save the image in the public directory (category_images folder)
            $img->save(public_path('category_images/' . $imageName));

            // Assign the image name to the category
            $category->image = $imageName;
        }

        // Save the category
        $category->save();

        return response()->json([
            'status' => 200,
            'message' => 'Category created successfully',
            'category' => $category, // Optionally return the created category data
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'category not found'], 404);
        }

        return response()->json(['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate incoming request
            $validatedData = $request->validate([
                'name' => 'required|string',
                'image' => 'nullable|image', // Image validation for different types
                'status' => 'required|boolean',
            ]);

            // Find the category by ID
            $category = Category::findOrFail($id);
            $category->name = $validatedData['name'];
            $category->status = $validatedData['status'];

            // Check if an image was uploaded
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($category->image && file_exists(public_path('category_images/' . $category->image))) {
                    unlink(public_path('category_images/' . $category->image));
                }

                // Handle new image upload and conversion to WebP
                $image = $request->file('image');
                $imageName = md5(uniqid()) . '.webp'; // Generate a unique name with .webp extension

                // Open the uploaded image and convert it to WebP format
                $img = Image::make($image);
                $img->encode('webp', 80); // 80 is the quality level, adjust as needed

                // Save the image to the public directory
                $img->save(public_path('category_images/' . $imageName));

                // Assign the new image name to the category
                $category->image =  $imageName;
            }

            // Save the updated category
            $category->save();

            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Category updated successfully',
                'category' => $category,
            ]);
        } catch (ValidationException $e) {
            // Return validation errors
            return response()->json(['status' => 422, 'errors' => $e->errors()]);
        } catch (\Throwable $e) {
            // Handle other errors
            return response()->json(['status' => 500, 'error' => 'An error occurred. Please try again later.'], 500);
        }
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // Find the category by ID
            $category = Category::findOrFail($id);

            // Check if category has an image and delete it from storage
            if ($category->image) {
                $imagePath = public_path('category_images/' . $category->image);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // Delete the category from the database
            $category->delete();

            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Category deleted successfully',
            ]);
        } catch (\Throwable $e) {
            // Log and handle errors
            Log::error('Error deleting category', ['error' => $e->getMessage()]);
            return response()->json(['status' => 500, 'error' => 'An error occurred. Please try again later.'], 500);
        }
    }
}
