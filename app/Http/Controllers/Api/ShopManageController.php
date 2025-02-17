<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Product;
use App\Models\Upazila;
use App\Models\District;
use App\Models\Division;
use App\Models\HomeSlider;
use App\Models\NewArrival;
use App\Models\TopCategory;
use Illuminate\Http\Request;
use App\Models\TopSellingProduct;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;

class ShopManageController extends Controller
{


    public function getDashboardData($shopId, $userId)
    {
        // Today sales data
        $todaySales = Order::where('shop_id', $shopId)
            ->where('user_id', $userId)
            ->whereDate('created_at', today())
            ->sum('total_price'); // Assuming the column for the total order amount is 'total_price'

        // Monthly sales data
        $monthlySales = Order::where('shop_id', $shopId)
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        // Most sold items using OrderItem and Order tables (top 10)
        $mostSoldItems = OrderItem::select('products.name', DB::raw('COUNT(order_items.product_id) as product_count'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id') // Join with orders table using order_id
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.shop_id', $shopId)
            ->where('orders.user_id', $userId)
            ->whereMonth('orders.created_at', now()->month)
            ->groupBy('products.name')
            ->orderByDesc('product_count')
            ->take(10) // Get top 10 most sold products
            ->get(); // Get the results as an array

        $lowStock = Product::where('user_id', $userId)
            ->where('shop_id', $shopId)
            ->where('quantity', '<', 10)
            ->get();


        return response()->json([
            'today_sales' => $todaySales,
            'monthly_sales' => $monthlySales,
            'most_sold_items' => $mostSoldItems,
            'low_stock' => $lowStock,
        ]);
    }


    // Controller: ShopManageController.php

    public function divisions($id)
    {
        $divisions = Division::where('country_id', $id)->get(['id', 'name']);
        return response()->json([
            'success' => true,
            'data' => $divisions
        ]);
    }

    public function districts(Request $request)
    {
        $divisionId = $request->input('division'); // Fetch division id, not name
        $districts = District::where('division_id', $divisionId)->get(['id', 'name']); // Fetch districts by division id

        return response()->json($districts); // Return the districts
    }

    // Add this function to your ShopManageController

    public function upazilas(Request $request)
    {
        $districtId = $request->input('district'); // Get district id from the query parameter
        $upazilas = Upazila::where('district_id', $districtId)->get(['id', 'name']); // Fetch upazilas by district_id

        return response()->json($upazilas); // Return the upazilas
    }


    public function topSellingProductByShop($shop_id)
    {
        // Fetch the top selling products with the product and the related product images
        $topselling = TopSellingProduct::where('shop_id', $shop_id)
            ->with(['product', 'product.images'])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $topselling
        ]);
    }

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
