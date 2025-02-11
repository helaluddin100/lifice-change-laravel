<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HomeSlider;
use App\Models\NewArrival;
use App\Models\TopCategory;

class ShopManageController extends Controller
{

    public function todayNewArrivalByShop($shop_id)
    {
        // Fetch the new arrivals with the product and the related product images
        $newarrival = NewArrival::where('shop_id', $shop_id)
            ->with(['product', 'product.images'])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $newarrival
        ]);
    }


    public function getSlidersByShop($shop_id)
    {
        $sliders = HomeSlider::where('shop_id', $shop_id)
            ->where('status', true) // Only fetch active sliders
            ->get();

        return response()->json([
            'success' => true,
            'data' => $sliders
        ]);
    }

    public function getTopCategoryByShop($shop_id)
    {
        $categories = TopCategory::where('shop_id', $shop_id)
            ->with('category')
            ->get();
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }



    public function categoryShow($userId)
    {
        // Find the user by ID (you could use validation or authorization as well)
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Fetch categories related to the user
        $categories = $user->categories;  // Assuming you have a 'categories' relationship defined in the User model

        if ($categories->isEmpty()) {
            return response()->json(['message' => 'No categories found for this user'], 404);
        }

        // Return the categories
        return response()->json($categories);
    }



    public function sizesShow($userId)
    {
        // Find the user by ID (you could use validation or authorization as well)
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Fetch sizes related to the user
        $sizes = $user->sizes;  // Assuming you have a 'sizes' relationship defined in the User model

        if (is_null($sizes) || $sizes->isEmpty()) {
            return response()->json(['message' => 'No sizes found for this user'], 404);
        }

        // Return the sizes
        return response()->json($sizes);
    }




    public function colorsShow($userId)
    {
        // Find the user by ID (you could use validation or authorization as well)
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Fetch colors related to the user
        $colors = $user->colors;  // Assuming you have a 'colors' relationship defined in the User model

        if (is_null($colors) || $colors->isEmpty()) {
            return response()->json(['message' => 'No colors found for this user'], 404);
        }

        // Return the colors
        return response()->json($colors);
    }
}
