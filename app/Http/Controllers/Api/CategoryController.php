<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        return response()->json([
            'status' => 200,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        try {
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
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = md5(uniqid()) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('category_images'), $imageName);
                $category->image = $imageName;
            }


            $category->save();

            return response()->json([
                'status' => 200,
                'message' => 'Category created successfully',
                'category' => $category, // Optionally return the created category data
            ]);
        } catch (\Throwable $e) {
            // Log and handle any errors
            Log::error('Error creating Shop', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'error' => 'An error occurred. Please try again later.',
            ], 500);
        }
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
                'image' => 'required',
                'status' => 'required|boolean',
            ]);

            // Find the category by ID
            $category = Category::findOrFail($id);
            $category->name = $validatedData['name'];
            $category->status = $validatedData['status'];
            if ($request->hasFile('image')) {
                // Delete the old image
                if ($category->image && file_exists(public_path('category_images/' . $category->image))) {
                    unlink(public_path('category_images/' . $category->image));
                }

                // Upload new image
                $image = $request->file('image');
                $imageName = md5(uniqid()) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('category_images'), $imageName);
                $category->image = $imageName;
            }

            // Save updated category
            $category->save();

            // Log success message
            Log::info('Category updated successfully', ['id' => $category->id]);

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
            // Log and handle other errors
            Log::error('Error updating category', ['error' => $e->getMessage()]);
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
