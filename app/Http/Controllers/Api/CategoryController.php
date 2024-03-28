<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
