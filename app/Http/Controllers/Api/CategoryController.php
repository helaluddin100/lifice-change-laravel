<?php

namespace App\Http\Controllers\Api;

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
        // Get the user ID from the request
        $userId = $request->query('user_id');

        // Fetch categories for the specified user
        $categories = Category::where('user_id', $userId)->get();

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
            ]);
            $userId = $request->input('user_id');
            // Create a new category instance
            $category = new Category();
            $category->name = $validatedData['name'];
            $category->user_id = $userId;
            // Set any other attributes as needed
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
            ]);

            // Find the category by ID
            $category = Category::findOrFail($id);

            // Update category attributes
            $category->update($validatedData);

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
            // Find the category by ID and delete it
            $category = Category::findOrFail($id);
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
