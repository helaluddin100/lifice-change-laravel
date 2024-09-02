<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
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

    public function store(Request $request)
    {

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'shop_id' => 'required|exists:shops,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'item_name' => 'nullable|string|max:255',
            'current_price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'buy_price' => 'nullable|numeric',
            'product_code' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'warranty' => 'nullable|string|max:255',
            'product_details' => 'nullable|array',
            'product_details.*.detail_type' => 'nullable|string|max:255',
            'product_details.*.detail_description' => 'nullable|string',
            'product_variant' => 'nullable|array',
            'product_variant.*.option' => 'nullable|string|max:255',
            'product_variant.*.cost' => 'nullable|numeric',
            'images' => 'nullable|array',
            'images.*' => 'file|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'status' => 'nullable',
        ]);


        // Ensure 'status' is treated as a boolean
        $status = filter_var($validated['status'] ?? false, FILTER_VALIDATE_BOOLEAN);

        // Handle file uploads
        $imagesPaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                $imagesPaths[] = $path;
            }
        }

        // Create the product
        $product = Product::create([
            'user_id' => $validated['user_id'],
            'shop_id' => $validated['shop_id'],
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'item_name' => $validated['item_name'] ?? null,
            'current_price' => $validated['current_price'],
            'old_price' => $validated['old_price'] ?? null,
            'buy_price' => $validated['buy_price'] ?? null,
            'product_code' => $validated['product_code'],
            'quantity' => $validated['quantity'],
            'warranty' => $validated['warranty'] ?? null,
            'product_details' => $validated['product_details'] ?? [],
            'product_variant' => $validated['product_variant'] ?? [],
            'images' => $imagesPaths,
            'video' => $validated['video'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
            'status' => $status,
        ]);

        // Return response
        return response()->json([
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }





    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
