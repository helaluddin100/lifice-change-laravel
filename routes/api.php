<?php

use App\Http\Controllers\Api\AboutUsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\Auth\VerificationController;
use App\Http\Controllers\Api\CancellationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\SizeController;
use App\Http\Controllers\Api\ShopManageController;
use App\Http\Controllers\Api\HomeSliderController;
use App\Http\Controllers\Api\PrivacyPolicyController;
use App\Http\Controllers\Api\TermController;
use App\Http\Controllers\Api\TopCategoryController;
use App\Http\Controllers\Api\TodaySellProductController;
use App\Http\Controllers\Api\NewArrivalsController;
use App\Http\Controllers\Api\TopSellingProductController;








// Public routes (no authentication required)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])->name('verification.verify');
Route::post('/auth/verify', [AuthController::class, 'verify']);

// Protected routes (authentication required)



// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/user', function (Request $request) {
//         return $request->user();
//     });

//     Route::get('/user-shop', function (Request $request) {
//         $shop = \App\Models\Shop::where('user_id', $request->user()->id)->first();
//         return response()->json($shop);
//     });

//     Route::post('/update/user', [UserController::class, 'updateUser']);
//     Route::post('/logout', [AuthController::class, 'logout']);
// });

Route::get('/user-shop', function (Request $request) {
    $userId = $request->query('user_id'); // Get user_id from query params

    if (!$userId) {
        return response()->json(['error' => 'User ID is required'], 400);
    }

    $shop = \App\Models\Shop::where('user_id', $userId)->first();

    if (!$shop) {
        return response()->json(['error' => 'Shop not found'], 404);
    }

    return response()->json($shop);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/update/user', [UserController::class, 'updateUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
});



// Business types route
Route::get('country', [ShopController::class, 'countries']);
Route::get('/countries/{id}/districts', [ShopController::class, 'districts']);

Route::get('business-type', [ShopController::class, 'businessTypes']);
Route::post('create-shop', [ShopController::class, 'store']);
Route::get('/user/{userId}/shops', [ShopController::class, 'getUserShops']);
Route::post('/update-shop/{shop}', [ShopController::class, 'update']);
Route::get('/shop/{id}', [ShopController::class, 'edit']);
Route::delete('/shops/{id}', [ShopController::class, 'destroy']);



//category api
Route::post('category/store', [CategoryController::class, 'store']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'edit']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy']);

//get category by user
Route::get('/all-categories/{id}', [CategoryController::class, 'getCategoriesByUser']);

//Product
Route::post('/product-create', [ProductController::class, 'store']);




//district
Route::get('district', [DistrictController::class, 'index']);

//color
Route::post('/color', [ColorController::class, 'store']);
Route::get('/colors', [ColorController::class, 'index']);
Route::post('color/store', [ColorController::class, 'store']);
Route::get('/color/{id}', [ColorController::class, 'edit']);
Route::put('/colors/{id}', [ColorController::class, 'update']);
Route::delete('/color/delete/{id}', [ColorController::class, 'destroy']);

//get color by shop and user
Route::get('/color/shop/{id}', [ColorController::class, 'getColorByShop']);

//Size
Route::post('/size', [SizeController::class, 'store']);
Route::get('/sizes', [SizeController::class, 'index']);
Route::post('size/store', [SizeController::class, 'store']);
Route::get('/size/{id}', [SizeController::class, 'edit']);
Route::put('/sizes/{id}', [SizeController::class, 'update']);
Route::delete('/size/delete/{id}', [SizeController::class, 'destroy']);
Route::get('/size/shop/{id}', [SizeController::class, 'getSizeByShop']);


//get product by shop and user
Route::get('/categories/user/{id}', [ProductController::class, 'getCategoriesByUser']);
Route::get('/products/user/{id}', [ProductController::class, 'show']);
Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::post('/products/{id}', [ProductController::class, 'update'])->name('product.update');


//view shop
Route::get('/view-shop/{shop_url}', [ShopController::class, 'showShopWithTemplate']);
Route::get('/shop-category/{id}', [ShopManageController::class, 'categoryShow']);


//color
Route::get('/shop-sizes/{id}', [ShopManageController::class, 'sizesShow']);
Route::get('/shop-colors/{id}', [ShopManageController::class, 'colorsShow']);

//About
Route::post('/abouts', [AboutUsController::class, 'store']);
Route::get('/abouts', [AboutUsController::class, 'index']);
Route::post('about/store', [AboutUsController::class, 'store']);
Route::get('/abouts/{id}', [AboutUsController::class, 'edit']);
Route::put('/abouts/{id}', [AboutUsController::class, 'update']);
Route::delete('/abouts/{id}', [AboutUsController::class, 'destroy']);
// Route::get('/abouts/{id}', [ShopManageController::class, 'aboutShow']);

// Privacy Policy
Route::post('/privacy', [PrivacyPolicyController::class, 'store']);
Route::get('/privacy', [PrivacyPolicyController::class, 'index']);
Route::post('privacy/store', [PrivacyPolicyController::class, 'store']);
Route::get('/privacy/{id}', [PrivacyPolicyController::class, 'edit']);
Route::put('/privacy/{id}', [PrivacyPolicyController::class, 'update']);
Route::delete('/privacy/{id}', [PrivacyPolicyController::class, 'destroy']);
// Route::get('/privacy/{id}', [ShopManageController::class, 'aboutShow']);

// Terms and Conditions
Route::post('/term', [TermController::class, 'store']);
Route::get('/term', [TermController::class, 'index']);
Route::post('term/store', [TermController::class, 'store']);
Route::get('/term/{id}', [TermController::class, 'edit']);
Route::put('/term/{id}', [TermController::class, 'update']);
Route::delete('/term/{id}', [TermController::class, 'destroy']);
// Route::get('/privacy/{id}', [ShopManageController::class, 'aboutShow']);

// Return and Cancellation Policy
Route::post('/cancellation', [CancellationController::class, 'store']);
Route::get('/cancellation', [CancellationController::class, 'index']);
Route::post('cancellation/store', [CancellationController::class, 'store']);
Route::get('/cancellation/{id}', [CancellationController::class, 'edit']);
Route::put('/cancellation/{id}', [CancellationController::class, 'update']);
Route::delete('/cancellation/{id}', [CancellationController::class, 'destroy']);
// Route::get('/cancellation/{id}', [ShopManageController::class, 'aboutShow']);



Route::get('products', [ProductController::class, 'index']);


// Home slider
Route::get('/sliders/{shop_id}', [HomeSliderController::class, 'index']);  // Get all sliders for a shop
Route::post('/sliders', [HomeSliderController::class, 'store']);            // Create a new slider
Route::post('/sliders/{id}', [HomeSliderController::class, 'update']);        // Update slider
Route::delete('/sliders/{id}', [HomeSliderController::class, 'destroy']);
Route::delete('/sliders/{id}', [HomeSliderController::class, 'destroy']);

//Top category
Route::post('/store-top-categories', [TopCategoryController::class, 'store']);
Route::get('/get-top-categories', [TopCategoryController::class, 'getTopCategories']);
Route::delete('/delete-top-category/{categoryId}', [TopCategoryController::class, 'deleteTopCategory']);

// Today sell products

Route::get('/products', [ProductController::class, 'getProductsForUserAndShop']);

Route::post('/store-today-sell-products', [TodaySellProductController::class, 'store']);
Route::get('/get-today-sell-products', [TodaySellProductController::class, 'getSelectedProducts']);
Route::delete('/delete-today-sell-product/{productId}', [TodaySellProductController::class, 'delete']);


// New Arrivals product

Route::post('/store-new-arrivals', [NewArrivalsController::class, 'store']);
Route::get('/get-new-arrivals', [NewArrivalsController::class, 'getSelectedProducts']);
Route::delete('/delete-new-arrivals/{productId}', [NewArrivalsController::class, 'delete']);


// Top Selling product

Route::post('/store-top-selling', [TopSellingProductController::class, 'store']);
Route::get('/get-top-selling', [TopSellingProductController::class, 'getSelectedProducts']);
Route::delete('/delete-top-selling/{productId}', [TopSellingProductController::class, 'delete']);
