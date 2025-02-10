<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\TopSellingProduct;

class TopSellingProductController extends Controller
{
    // Store selected products for a user and shop
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'shop_id' => 'required|integer|exists:shops,id',
            'products' => 'required|array|min:6',
            'products.*' => 'integer|exists:products,id',
        ]);

        // Remove old selections
        TopSellingProduct::where('user_id', $request->user_id)
            ->where('shop_id', $request->shop_id)
            ->delete();

        // Add new selections
        foreach ($request->products as $productId) {
            TopSellingProduct::create([
                'user_id' => $request->user_id,
                'shop_id' => $request->shop_id,
                'product_id' => $productId,
            ]);
        }

        return response()->json(['message' => 'Products saved successfully!'], 200);
    }

    public function getSelectedProducts(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'shop_id' => 'required|integer|exists:shops,id',
        ]);

        // Fetch selected products for the given user_id and shop_id
        $products = TopSellingProduct::where('user_id', $request->user_id)
            ->where('shop_id', $request->shop_id)
            ->get();

        // Fetch images for each product based on product_id
        $productsWithImages = $products->map(function ($item) {
            $product = $item->product; // Access the product

            // Fetch images based on product_id
            $images = ProductImage::where('product_id', $product->id)->get();

            // Check if images exist, otherwise use default image
            $image = $images->isNotEmpty() ? asset($images->first()->image_path) : '/default-product.png';

            return [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $image, // Return the first image URL or default
            ];
        });

        return response()->json(['products' => $productsWithImages], 200);
    }





    // Delete a selected product for a user and shop
    public function delete(Request $request, $productId)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'shop_id' => 'required|integer|exists:shops,id',
        ]);

        $product = TopSellingProduct::where('user_id', $request->user_id)
            ->where('shop_id', $request->shop_id)
            ->where('product_id', $productId)
            ->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found!'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product removed successfully!'], 200);
    }
}
