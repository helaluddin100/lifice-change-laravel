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
use App\Http\Controllers\Api\CustomerBenefitController;
use App\Http\Controllers\Api\FlashDealProductController;
use App\Http\Controllers\Api\SizeController;
use App\Http\Controllers\Api\ShopManageController;
use App\Http\Controllers\Api\HomeSliderController;
use App\Http\Controllers\Api\HotDealProductController;
use App\Http\Controllers\Api\PrivacyPolicyController;
use App\Http\Controllers\Api\TermController;
use App\Http\Controllers\Api\TopCategoryController;
use App\Http\Controllers\Api\TodaySellProductController;
use App\Http\Controllers\Api\NewArrivalsController;
use App\Http\Controllers\Api\TopSellingProductController;
use App\Http\Controllers\Api\NewArrivalBannerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\VisitorController;
use App\Http\Controllers\Api\OfferProductController;
use App\Http\Controllers\Api\TopRatedProductController;
use App\Models\User;
use App\Models\Shop;
use App\Http\Controllers\Api\ContactusController;

use App\Http\Controllers\Api\TemplateController;
use App\Http\Controllers\Api\LandingPageController;

use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Models\Subscription;
use App\Http\Controllers\Api\CourierSettingController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        $user = $request->user();

        $userShop = Shop::where('user_id', $user->id)->first();

        $subscription = Subscription::where('user_id', $user->id)->first();

        // Default subscription data
        $subscriptionData = null;
        $subscriptionStatus = null;

        // Check if subscription exists and user status is not 2 or 0
        if ($user->status != 2 && $user->status != 0 && $subscription) {
            $subscriptionData = $subscription->end_date;
            $subscriptionStatus = $subscription->status; // Assuming 'status' field exists in the Subscription model
        }

        return response()->json([
            'user' => array_merge($user->toArray(), [
                'hasShop' => $userShop ? true : false,
                'subscription' => $subscriptionData,
                'subscriptionStatus' => $subscriptionStatus, // Add subscription status to the response
            ]),
        ]);
    });



    Route::post('/logout', [AuthController::class, 'logout']);
});



Route::post('/update/user/{id}', [UserController::class, 'updateUser']);

// Public routes (no authentication required)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])->name('verification.verify');
Route::post('/auth/verify', [AuthController::class, 'verify']);
Route::post('/auth/resend-verification', [AuthController::class, 'resendVerificationEmail']);
Route::post('/reset-password', [AuthController::class, 'reset']);

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
Route::post('/categories/{id}', [CategoryController::class, 'update']);
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



// Route::get('/products/user/{id}', [ProductController::class, 'show']);

Route::get('products/search/filter', [ProductController::class, 'show']);

Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::post('/products/{id}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{id}', [ProductController::class, 'destroy']);

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
Route::get('/abouts/{id}', [ShopManageController::class, 'aboutShow']);

// Privacy Policy
Route::post('/privacy', [PrivacyPolicyController::class, 'store']);
Route::get('/privacy', [PrivacyPolicyController::class, 'index']);
Route::post('privacy/store', [PrivacyPolicyController::class, 'store']);
Route::get('/privacy/{id}', [PrivacyPolicyController::class, 'edit']);
Route::put('/privacy/{id}', [PrivacyPolicyController::class, 'update']);
Route::delete('/privacy/{id}', [PrivacyPolicyController::class, 'destroy']);
Route::get('/privacy/{id}', [ShopManageController::class, 'privacyShow']);

// Terms and Conditions
Route::post('/term', [TermController::class, 'store']);
Route::get('/term', [TermController::class, 'index']);
Route::post('term/store', [TermController::class, 'store']);
Route::get('/term/{id}', [TermController::class, 'edit']);
Route::put('/term/{id}', [TermController::class, 'update']);
Route::delete('/term/{id}', [TermController::class, 'destroy']);
Route::get('/term/{id}', [ShopManageController::class, 'termShow']);

// Return and Cancellation Policy
Route::post('/cancellation', [CancellationController::class, 'store']);
Route::get('/cancellation', [CancellationController::class, 'index']);
Route::post('cancellation/store', [CancellationController::class, 'store']);
Route::get('/cancellation/{id}', [CancellationController::class, 'edit']);
Route::put('/cancellation/{id}', [CancellationController::class, 'update']);
Route::delete('/cancellation/{id}', [CancellationController::class, 'destroy']);
Route::get('/cancellation/{id}', [ShopManageController::class, 'cancellationShow']);



Route::get('products/with-filter', [ProductController::class, 'index']);


// Home slider
Route::get('/sliders/{shop_id}', [HomeSliderController::class, 'index']);  // Get all sliders for a shop
Route::post('/sliders', [HomeSliderController::class, 'store']);            // Create a new slider
Route::post('/sliders/{id}', [HomeSliderController::class, 'update']);        // Update slider
Route::delete('/sliders/{id}', [HomeSliderController::class, 'destroy']);
Route::get('/home-sliders/{shop_id}', [ShopManageController::class, 'getSlidersByShop']);

//Top category
Route::post('/store-top-categories', [TopCategoryController::class, 'store']);
Route::get('/get-top-categories', [TopCategoryController::class, 'getTopCategories']);
Route::delete('/delete-top-category/{categoryId}', [TopCategoryController::class, 'deleteTopCategory']);
Route::get('/top-category/{shop_id}', [ShopManageController::class, 'getTopCategoryByShop']);

// Today sell products

Route::get('/products', [ProductController::class, 'getProductsForUserAndShop']);

Route::post('/store-today-sell-products', [TodaySellProductController::class, 'store']);
Route::get('/get-today-sell-products', [TodaySellProductController::class, 'getSelectedProducts']);
Route::delete('/delete-today-sell-product/{productId}', [TodaySellProductController::class, 'delete']);
Route::get('/today-sell/{shop_id}', [ShopManageController::class, 'todaySellByShop']);

// New Arrivals product
Route::post('/store-new-arrivals', [NewArrivalsController::class, 'store']);
Route::get('/get-new-arrivals', [NewArrivalsController::class, 'getSelectedProducts']);
Route::delete('/delete-new-arrivals/{productId}', [NewArrivalsController::class, 'delete']);
Route::get('/today-new-arrrival/{shop_id}', [ShopManageController::class, 'todayNewArrivalByShop']);


// Top Selling product

Route::post('/store-top-selling', [TopSellingProductController::class, 'store']);
Route::get('/get-top-selling', [TopSellingProductController::class, 'getSelectedProducts']);
Route::delete('/delete-top-selling/{productId}', [TopSellingProductController::class, 'delete']);
Route::get('/top-selling-product/{shop_id}', [ShopManageController::class, 'topSellingProductByShop']);

// New Arrival Banner
Route::get('/new-arrival/{shop_id}', [NewArrivalBannerController::class, 'index']);  // Get all new-arrival for a shop
Route::post('/new-arrival', [NewArrivalBannerController::class, 'store']);            // Create a new slider
Route::post('/new-arrival/{id}', [NewArrivalBannerController::class, 'update']);        // Update slider
Route::delete('/new-arrival/{id}', [NewArrivalBannerController::class, 'destroy']);
Route::get('/new-arrival-banners/{shop_id}', [ShopManageController::class, 'getArrivalBannersByShop']);

// Offer Product
Route::post('/store-offer-product', [OfferProductController::class, 'store']);
Route::get('/get-offer-product', [OfferProductController::class, 'getSelectedProducts']);
Route::delete('/delete-offer-product/{productId}', [OfferProductController::class, 'delete']);
Route::get('/offer-product/{shop_id}', [ShopManageController::class, 'offerProductByShop']);

// Hot Deal Product
Route::post('/store-hot-deal-product', [HotDealProductController::class, 'store']);
Route::get('/get-hot-deal-product', [HotDealProductController::class, 'getSelectedProducts']);
Route::delete('/delete-hot-deal-product/{productId}', [HotDealProductController::class, 'delete']);
Route::get('/hot-deal-product/{shop_id}', [ShopManageController::class, 'hotDealProductByShop']);

// Hot Deal Product
Route::post('/store-flash-deal-product', [FlashDealProductController::class, 'store']);
Route::get('/get-flash-deal-product', [FlashDealProductController::class, 'getSelectedProducts']);
Route::delete('/delete-flash-deal-product/{productId}', [FlashDealProductController::class, 'delete']);
Route::get('/flash-deal-product/{shop_id}', [ShopManageController::class, 'flashDealProductByShop']);

// Hot Deal Product
Route::post('/store-top-rated-product', [TopRatedProductController::class, 'store']);
Route::get('/get-top-rated-product', [TopRatedProductController::class, 'getSelectedProducts']);
Route::delete('/delete-top-rated-product/{productId}', [TopRatedProductController::class, 'delete']);
Route::get('/top-rated-product/{shop_id}', [ShopManageController::class, 'topRatedProductByShop']);

//  Customer Benefit
Route::get('/customer-benefit/{shop_id}', [CustomerBenefitController::class, 'index']);
Route::post('/customer-benefit', [CustomerBenefitController::class, 'store']);
Route::post('/customer-benefit/{id}', [CustomerBenefitController::class, 'update']);
Route::delete('/customer-benefit/{id}', [CustomerBenefitController::class, 'destroy']);
Route::get('/customer-benefit-banners/{shop_id}', [ShopManageController::class, 'getCustomerBenefitByShop']);



// Product Details
Route::get('products/{slug}', [ProductController::class, 'productDetails']);


// Checkout page api
// Routes in routes/api.php
Route::get('/divisions/{id}', [ShopManageController::class, 'divisions']);
Route::get('/districts', [ShopManageController::class, 'districts']);
Route::get('/upazilas', [ShopManageController::class, 'upazilas']);



// Order api

Route::post('/orders', [OrderController::class, 'store']);  // Place an order (No authentication required)
Route::get('/orders', [OrderController::class, 'index']);   // Get all orders
Route::get('/orders/{id}', [OrderController::class, 'show']);  // Get a single order
Route::put('/orders/{id}', [OrderController::class, 'update']);  // Update order status
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);  // Delete an order

// Related Product

Route::get('/products/related/{category_id}/{exclude_product_id}', [ProductController::class, 'relatedProducts']);




// product review route
Route::get('/reviews/{product_id}', [ReviewController::class, 'getReviews']);
Route::post('/reviews/add', [ReviewController::class, 'addReview']);
Route::post('/reviews/reply', [ReviewController::class, 'replyReview']);
Route::post('/reviews/approve/{review_id}', [ReviewController::class, 'approveReview']); // Admin approval
Route::get('/reviews/shop/{id}', [ReviewController::class, 'showAllReviews']);
Route::get('/show/review/{id}', [ReviewController::class, 'show']);


// category by product show
Route::get('/products/category/{category}', [ProductController::class, 'getProductsByCategory']);


Route::get('/dashboard-data/{shopId}/{userId}', [ShopManageController::class, 'getDashboardData']);
Route::get('/my-orders/{shopId}/{userId}/{status?}', [OrderController::class, 'getOrders']);

// single order view page
Route::get('/order/{orderId}', [OrderController::class, 'getSingleOrder']);
Route::post('/order/{id}/status', [OrderController::class, 'updateStatus']);
Route::get('/order/{id}/invoice', [OrderController::class, 'generateInvoice']);


Route::post('/visitor-data', [VisitorController::class, 'store']);
Route::get('/all-visitor-data', [VisitorController::class, 'getVisitorData']);

// Contact Us

Route::post('/contactus', [ContactusController::class, 'store']);
Route::get('/contactus/{shop_id}', [ContactusController::class, 'index']);
Route::get('/contactus/email/{id}', [ContactusController::class, 'show']);

Route::delete('/contactus/{id}', [ContactusController::class, 'destroy']);

Route::get('/get-template', [TemplateController::class, 'index']);

// Landing Page
Route::post('/landing-pages', [LandingPageController::class, 'store']);
Route::get('/landing-pages/{id}', [LandingPageController::class, 'show']);


Route::post('/landing-pages/update/{id}', [LandingPageController::class, 'update']);
Route::get('/search/products', [ProductController::class, 'search']);


// Pricing Plan
Route::get('/pricing-plan', [PackageController::class, 'pricingPlan']);
Route::get('/pricing-plan-details/{id}', [PackageController::class, 'show']);


// Subscription
Route::post('/subscribe', [SubscriptionController::class, 'store']);

// Courier Get in frontend
Route::get('/courier', [CourierSettingController::class, 'index']);
// Courier Settings
Route::post('/courier-store', [CourierSettingController::class, 'store']);

Route::get('/courier-settings/{id}', [CourierSettingController::class, 'show']);

// Pathao API
Route::get('/get-pathao-cities/{user_id}', [CourierSettingController::class, 'getCities']);
Route::get('/get-pathao-zones/{user_id}/{city_id}', [CourierSettingController::class, 'getZones']);
Route::get('/get-pathao-areas/{user_id}/{zone_id}', [CourierSettingController::class, 'getAreas']);

Route::get('/get-pathao-orders/{user_id}', [CourierSettingController::class, 'fetchOrdersFromPathao']);
