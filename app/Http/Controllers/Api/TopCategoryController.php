<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\TopCategory;
use Illuminate\Http\Request;

class TopCategoryController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTopCategories(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'shop_id' => 'required|integer|exists:shops,id',
        ]);

        $categories = TopCategory::where('user_id', $request->user_id)
            ->where('shop_id', $request->shop_id)
            ->with('category') // Fetch related category details
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->category->id,
                    'name' => $item->category->name,
                    'image' => $item->category->image ?? '/default-category.png', // Provide default image if null
                ];
            });

        return response()->json(['categories' => $categories], 200);
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
            'user_id' => 'required|integer|exists:users,id',
            'shop_id' => 'required|integer|exists:shops,id',
            'categories' => 'required|array|min:6',
            'categories.*' => 'integer|exists:categories,id',
        ]);

        $userId = $request->user_id;
        $shopId = $request->shop_id;
        $categories = $request->categories;

        // Get existing top categories for this user and shop
        $existingCategories = TopCategory::where('user_id', $userId)
            ->where('shop_id', $shopId)
            ->pluck('category_id')
            ->toArray();

        // Filter out duplicates before inserting new categories
        $newCategories = array_diff($categories, $existingCategories);

        if (empty($newCategories)) {
            return response()->json(['message' => 'No new categories to add.'], 400);
        }

        // Insert new unique top categories
        foreach ($newCategories as $index => $categoryId) {
            TopCategory::create([
                'user_id' => $userId,
                'shop_id' => $shopId,
                'category_id' => $categoryId,
                'position' => $index + 1, // Assigning position order
            ]);
        }

        return response()->json(['message' => 'Top categories saved successfully!'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TopCategory  $topCategory
     * @return \Illuminate\Http\Response
     */
    public function show(TopCategory $topCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TopCategory  $topCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(TopCategory $topCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TopCategory  $topCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TopCategory $topCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TopCategory  $topCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(TopCategory $topCategory)
    {
        //
    }
}
