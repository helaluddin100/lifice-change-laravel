<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $shop_id = $request->get('shop_id');
        if (!$shop_id) {
            return response()->json(['error' => 'Shop ID is required'], 400);
        }

        // Start querying the Product model with eager loading for images
        $query = Product::where('shop_id', $shop_id)->with('images');

        // Apply category filter if provided
        if ($request->has('categories') && !empty($request->categories)) {
            $query->whereIn('category_id', $request->categories);
        }

        // Apply size filter if provided
        if ($request->has('sizes') && !empty($request->sizes)) {
            foreach ($request->sizes as $size) {
                $query->whereJsonContains('product_sizes', ['size' => $size]);
            }
        }

        // Apply color filter if provided
        if ($request->has('color') && !empty($request->color)) {
            foreach ($request->color as $color) {
                $query->whereJsonContains('product_colors', ['color' => $color]);
            }
        }

        // Apply price range filter if provided
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('current_price', [$request->min_price, $request->max_price]);
        }

        // Fetch filtered products along with their images
        $products = $query->get();

        return response()->json($products);
    }





    public function store(Request $request)
    {
        // Validate incoming request data
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


            'product_colors' => 'nullable|array', // Validate colors array
            'product_colors.*.color' => 'required|string|max:255', // Each color must have a value
            'product_colors.*.price' => 'required|numeric', // Each color must have a price
            'product_sizes' => 'nullable|array', // Validate sizes array
            'product_sizes.*.size' => 'required|string|max:255', // Each size must have a value
            'product_sizes.*.price' => 'required|numeric', // Each size must have a price
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
            'has_variant' => 'nullable',
            'has_details' => 'nullable',
            'variant_name' => 'nullable|string|max:255',
            'description' => 'nullable',

        ]);

        // Ensure 'status' and 'has_variant' are treated as booleans
        $status = filter_var($validated['status'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $has_variant = filter_var($validated['has_variant'] ?? false, FILTER_VALIDATE_BOOLEAN);



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
            'product_colors' => $validated['product_colors'] ?? [],
            'product_sizes' => $validated['product_sizes'] ?? [],
            'video' => $validated['video'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
            'status' => $status,
            'has_variant' => $has_variant,
            'has_details' => filter_var($validated['has_details'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'variant_name' => $validated['variant_name'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);
        // Handle image uploads and store in product_images table
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = md5(uniqid()) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('product_images'), $imageName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'product_images/' . $imageName
                ]);
            }
        }


        // Return response indicating the product was created successfully
        return response()->json([
            'status' => 200, // Add the status field
            'message' => 'Product created successfully',
            'data' => $product,
        ], 200);
    }


    public function getCategoriesByUser($id)
    {
        $categories = Category::where('user_id', $id)->get();
        return response()->json($categories);
    }





    public function show($userId, Request $request)
    {
        $query = Product::where('user_id', $userId)->with('images'); // Include images

        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $products = $query->get();

        return response()->json($products);
    }





    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);

        return response()->json([
            'status' => 200,
            'product' => $product,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        // Validate incoming request data
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

            'product_colors' => 'nullable|array',
            'product_colors.*.color' => 'required|string|max:255',
            'product_colors.*.price' => 'required|numeric',
            'product_sizes' => 'nullable|array',
            'product_sizes.*.size' => 'required|string|max:255',
            'product_sizes.*.price' => 'required|numeric',
            'product_details' => 'nullable|array',
            'product_details.*.detail_type' => 'nullable|string|max:255',
            'product_details.*.detail_description' => 'nullable|string',

            'product_variant' => 'nullable|array',
            'product_variant.*.option' => 'nullable|string|max:255',
            'product_variant.*.cost' => 'nullable|numeric',

            'images' => 'nullable|array',
            'images.*' => 'nullable',

            'removed_images' => 'nullable|array',
            'removed_images.*' => 'exists:product_images,id', // Ensure valid image IDs are provided

            'video' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'status' => 'nullable',
            'has_variant' => 'nullable',
            'has_details' => 'nullable',
            'variant_name' => 'nullable|string|max:255',
            'description' => 'nullable',
        ]);

        // Convert boolean values
        $status = filter_var($validated['status'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $has_variant = filter_var($validated['has_variant'] ?? false, FILTER_VALIDATE_BOOLEAN);

        // Find the product
        $product = Product::findOrFail($id);

        // Update product details
        $product->update([
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
            'product_colors' => $validated['product_colors'] ?? [],
            'product_sizes' => $validated['product_sizes'] ?? [],
            'video' => $validated['video'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
            'status' => $status,
            'has_variant' => $has_variant,
            'has_details' => filter_var($validated['has_details'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'variant_name' => $validated['variant_name'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);


        // Step 1: Remove images
        if (!empty($validated['removed_images'])) {
            foreach ($validated['removed_images'] as $imageId) {
                $productImage = ProductImage::find($imageId);
                if ($productImage) {
                    $imagePath = public_path($productImage->image_path);

                    if (file_exists($imagePath)) {
                        unlink($imagePath); // Delete the image from storage
                    }
                    $productImage->delete(); // Remove the record from the database
                }
            }
        }

        // Step 2: Upload and store new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $imageName = md5(uniqid()) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('product_images'), $imageName);

                    // Save new image in the database
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'product_images/' . $imageName
                    ]);
                }
            }
        }

        // Return response
        return response()->json([
            'status' => 200,
            'message' => 'Product updated successfully',
            'data' => $product->load('images'), // Load images in response
        ], 200);
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
