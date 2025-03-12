<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubscriptionController extends Controller
{

    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:packages,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|in:bKash,Nagad,CreditCard,BankTransfer,Paypal,Strip',
            'transaction_id' => 'required|string',
            'plan' => 'required|string',
            'status' => 'required|in:pending,completed,failed',
            'package_time' => 'required|numeric',
        ]);

        // Check if the user has any pending payment
        $pendingPayment = Payment::where('user_id', $validatedData['user_id'])
            ->where('status', 'pending')
            ->exists();

        if ($pendingPayment) {
            return response()->json(['error' => 'You have a pending payment. Please complete it before making a new subscription.'], 400);
        }

        // Proceed with the subscription and payment creation if no pending payment exists
        DB::beginTransaction();

        try {
            // Proceed to create subscription and payment as usual
            $packageTimeInMonths = $validatedData['package_time'];
            $startDate = Carbon::now();
            $endDate = $startDate->copy()->addMonths($packageTimeInMonths);

            // Create Subscription
            $subscription = Subscription::create([
                'user_id' => $validatedData['user_id'],
                'package_id' => $validatedData['package_id'],
                'amount' => $validatedData['amount'],
                'payment_method' => $validatedData['payment_method'],
                'plan' => $validatedData['plan'],
                'transaction_id' => $validatedData['transaction_id'],
                'status' => $validatedData['status'],
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);

            // Create Payment
            Payment::create([
                'user_id' => $validatedData['user_id'],
                'subscription_id' => $subscription->id,
                'package_id' => $validatedData['package_id'],
                'amount' => $validatedData['amount'],
                'payment_method' => $validatedData['payment_method'],
                'transaction_id' => $validatedData['transaction_id'],
                'status' => $validatedData['status'],
                'payment_date' => Carbon::now(),
            ]);

            DB::commit();
            return response()->json(['message' => 'Payment and Subscription successfully created.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create payment and subscription. ' . $e->getMessage()], 500);
        }
    }
}
