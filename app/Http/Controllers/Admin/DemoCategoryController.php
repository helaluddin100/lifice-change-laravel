<?php

namespace App\Http\Controllers\Admin;

use App\Models\DemoCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class DemoCategoryController extends Controller
{
    public function index()
    {
        $categories = DemoCategory::all();
        return view('admin.category.index', compact('categories'));
    }
    public function create()
    {
        return view('admin.category.create');
    }


    public function store(Request $request)
    {

        // Validate incoming request
        $validatedData = $request->validate([
            'business_type_id' => 'required|exists:business_types,id',
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif ',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        // Create a new category instance
        $category = new DemoCategory();
        $category->name = $validatedData['name'];
        $category->business_type_id = $validatedData['business_type_id'];
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

        return redirect()->route('admin.category.index')->with('success', 'Category created successfully.');
    }





    public function edit(DemoCategory $category)
    {
        return view('admin.category.edit', compact('category'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DemoCategory  $demoCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'business_type_id' => 'required|exists:business_types,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif ',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean', // Make sure this is a boolean
        ]);

        // Find the existing category
        $category = DemoCategory::findOrFail($id);

        // Update the category properties
        $category->name = $validatedData['name'];
        $category->business_type_id = $validatedData['business_type_id'];
        $category->description = $validatedData['description'] ?? $category->description;

        // Ensure status is set to 0 if unchecked, or 1 if checked
        $category->status = $request->has('status') ? 1 : 0;

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the old image from the server
            if ($category->image && file_exists(public_path('category_images/' . $category->image))) {
                unlink(public_path('category_images/' . $category->image));
            }

            // Upload the new image
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

        // Save the updated category
        $category->save();

        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully.');
    }




    public function destroy($id)
    {
        // Find the category to be deleted
        $category = DemoCategory::findOrFail($id);

        // Delete the associated image from the server if it exists
        if ($category->image && file_exists(public_path('category_images/' . $category->image))) {
            unlink(public_path('category_images/' . $category->image));
        }

        // Delete the category from the database
        $category->delete();

        // Redirect with success message
        return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully.');
    }
}
