<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {

        $today = Carbon::today();
        $newUsersCount = User::whereDate('created_at', $today)->count();
        $user = User::all()->count();

        $allOrders = Order::count();
        $newOrder = Order::whereDate('created_at', $today)->count();

        $allProducts = Product::count();
        $newProducts = Product::whereDate('created_at', $today)->count();

        // Today all subscriptions
        $pendingSubscriptions = Subscription::where('status', "pending")->get();
        $allSubscriptions = Subscription::all();


        return view('dashboard', compact('user', 'allSubscriptions', 'pendingSubscriptions', 'newUsersCount', 'allOrders', 'newOrder', 'allProducts', 'newProducts',));
    }
}
