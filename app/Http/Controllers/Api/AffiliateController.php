<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\CommissionLog;
use App\Http\Controllers\Controller;

class AffiliateController extends Controller
{


    public function stats($user_id)
    {
        // 1. Get all users invited by this referrer
        $invitedUsers = User::where('referred_by', $user_id)->get();

        // 2. Total invited users
        $totalInvited = $invitedUsers->count();

        // 3. Monthly invited users (this month)
        $monthlyInvited = User::where('referred_by', $user_id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // 4. Get all sales from the commission_logs table where the user is invited by the referrer
        $sales = CommissionLog::where('referrer_id', $user_id)
            ->with('referredUser') // Eager load referred user
            ->get();

        // 5. Count total sales
        $totalSales = $sales->count();

        return response()->json([
            'total_invited' => $totalInvited,
            'monthly_invited' => $monthlyInvited,
            'total_sales' => $totalSales,
            'invited_users' => $invitedUsers->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at->toDateTimeString(),
                ];
            }),
            'sales' => $sales->map(function ($sale) {
                return [
                    'id' => $sale->id,
                    'referrer_id' => $sale->referrer_id,
                    'referred_user_name' => $sale->referredUser->name, // Include referred user name
                    'referred_user_email' => $sale->referredUser->email, // Include referred user email
                    'amount' => $sale->amount,
                    'created_at' => $sale->created_at->toDateTimeString(),
                ];
            }),
        ]);
    }
}
