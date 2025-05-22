<?php

namespace App\Http\Controllers\Admin;

use App\Models\DemoCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
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
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
            $destinationPath = public_path('category_images');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $img = Image::make($image)->encode('webp', 90); // 90 is the quality (0-100)
            $img->save($destinationPath . '/' . $imageName);

            $imagePath = 'category_images/' . $imageName;
        }

        // Create a new category instance
        $category = new DemoCategory();
        $category->name = $validatedData['name'];
        $category->business_type_id = $validatedData['business_type_id'];
        $category->description = $validatedData['description'];
        $category->image = $imagePath;
        $category->status = $request->status;
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

        $imagePath = $category->image;

        // Handle image upload if new file is provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
            $destinationPath = public_path('category_images');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $img = Image::make($image)->encode('webp', 90);
            $img->save($destinationPath . '/' . $imageName);

            $imagePath = 'category_images/' . $imageName;

            // Optional: delete old image if needed
            if (File::exists(public_path($category->image))) {
                File::delete(public_path($category->image));
            }
        }
        // Update the category properties
        $category->name = $validatedData['name'];
        $category->business_type_id = $validatedData['business_type_id'];
        $category->description = $validatedData['description'];
        $category->image = $imagePath;
        $category->status = $request->has('status') ? 1 : 0;
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
