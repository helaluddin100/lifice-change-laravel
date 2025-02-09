<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\TodaySellProduct;

class TodaySellProductController extends Controller
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
        TodaySellProduct::where('user_id', $request->user_id)
            ->where('shop_id', $request->shop_id)
            ->delete();

        // Add new selections
        foreach ($request->products as $productId) {
            TodaySellProduct::create([
                'user_id' => $request->user_id,
                'shop_id' => $request->shop_id,
                'product_id' => $productId,
            ]);
        }

        return response()->json(['message' => 'Products saved successfully!'], 200);
    }

    // Get selected products for a user and shop
    public function getSelectedProducts(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'shop_id' => 'required|integer|exists:shops,id',
        ]);

        $products = TodaySellProduct::where('user_id', $request->user_id)
            ->where('shop_id', $request->shop_id)
            ->with('product') // Eager load related product
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'image' => $item->product->image ?? '/default-product.png', // Provide default image if null
                ];
            });

        return response()->json(['products' => $products], 200);
    }


    // Delete a selected product for a user and shop
    public function delete(Request $request, $productId)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'shop_id' => 'required|integer|exists:shops,id',
        ]);

        $product = TodaySellProduct::where('user_id', $request->user_id)
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