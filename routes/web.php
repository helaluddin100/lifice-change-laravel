<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DistrictController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\ShopController;

use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\DemoProductController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/clear-cache', function () {
    // Clear route cache
    Artisan::call('route:clear');

    // Optimize class loading
    Artisan::call('optimize');

    // Optimize configuration loading
    Artisan::call('config:cache');

    // Optimize views loading
    Artisan::call('view:cache');

    // Additional optimizations you may want to run

    return "Cache cleared and optimizations done successfully.";
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::namespace('App\Http\Controllers')->group(
    function () {
        Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
            Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

            Route::resource('/business', 'BusinessTypeController');
            Route::resource('/country', 'CountryController');
            Route::resource('/district', 'DistrictController');

            Route::resource('templates', TemplateController::class);

            Route::resource('/users', 'UserController');
            Route::resource('/shop', 'ShopController');

            Route::resource('/packages', 'PackageController');
            Route::resource('/subscription', 'SubscriptionController');
            Route::resource('/courier', 'CourierController');
            Route::resource('/client-review', 'ClientReviewController');
            Route::resource('/contact', 'AdminContactUsController');

            Route::resource('/courierUser', 'CourierUserController');

            Route::resource('/category', 'DemoCategoryController');
            Route::resource('/color', 'DemoColorController');
            Route::resource('/size', 'DemoSizeController');
            Route::resource('/brand', 'DemoBrandController');
            Route::resource('/product', 'DemoProductController');

            Route::post('/product/remove-image', [DemoProductController::class, 'removeImage'])->name('product.removeImage');

            Route::get('/product/get-options/{business_type_id}', [DemoProductController::class, 'getOptions'])->name('product.getOptions');
        });
    }
);
