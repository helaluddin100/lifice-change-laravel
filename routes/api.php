<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\Auth\VerificationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ColorController;

use App\Models\District;

// Public routes (no authentication required)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])->name('verification.verify');
Route::post('/auth/verify', [AuthController::class, 'verify']);

// Protected routes (authentication required)



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/user-shop', function (Request $request) {
        $shop = \App\Models\Shop::where('user_id', $request->user()->id)->first();
        return response()->json($shop);
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



//category api
Route::post('category/store', [CategoryController::class, 'store']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'edit']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy']);


//Product
Route::post('/product-create', [ProductController::class, 'store']);




//district
Route::get('district', [DistrictController::class, 'index']);

//color
Route::post('/color', [ColorController::class, 'store']);
Route::get('/colors', [ColorController::class, 'index']);
