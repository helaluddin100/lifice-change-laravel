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

        // Function to mask email with the first 2 and last 2 characters visible
        $maskEmail = function ($email) {
            $emailParts = explode('@', $email);
            $localPart = $emailParts[0];
            $domain = $emailParts[1];

            // Mask the email: show first 2 and last 2 characters, replace the middle part with ***
            $maskedLocalPart = substr($localPart, 0, 2) . '*****' . substr($localPart, -2);

            return $maskedLocalPart . '@' . $domain;
        };

        return response()->json([
            'total_invited' => $totalInvited,
            'monthly_invited' => $monthlyInvited,
            'total_sales' => $totalSales,
            'invited_users' => $invitedUsers->map(function ($user) use ($maskEmail) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $maskEmail($user->email), // Mask email
                    'created_at' => $user->created_at->toDateTimeString(),
                ];
            }),
            'sales' => $sales->map(function ($sale) use ($maskEmail) {
                return [
                    'id' => $sale->id,
                    'referrer_id' => $sale->referrer_id,
                    'referred_user_name' => $sale->referredUser->name, // Include referred user name
                    'referred_user_email' => $maskEmail($sale->referredUser->email), // Mask referred user email
                    'amount' => $sale->amount,
                    'created_at' => $sale->created_at->toDateTimeString(),
                ];
            }),
        ]);
    }
}
