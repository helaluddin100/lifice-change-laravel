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
            'ragularPrice' => 'required|numeric',
            'discount_amount' => 'nullable|numeric',
        ]);

        $pendingPayment = Payment::where('user_id', $validatedData['user_id'])
            ->where('status', 'pending')
            ->exists();

        if ($pendingPayment) {
            return response()->json(['error' => 'You have a pending payment. Please complete it before making a new subscription.'], 400);
        }

        $paymentId = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);

        DB::beginTransaction();

        try {
            $existingSubscription = Subscription::where('user_id', $validatedData['user_id'])->first();

            if ($existingSubscription) {
                $packageTimeInMonths = $validatedData['package_time'];
                $startDate = Carbon::now();
                $endDate = $startDate->copy()->addMonths($packageTimeInMonths);

                $existingSubscription->update([
                    'end_date' => $endDate,
                    'status' => 'pending',
                ]);
            } else {
                $startDate = Carbon::now();
                $endDate = $startDate->copy()->addMonths($validatedData['package_time']);

                $existingSubscription = Subscription::create([
                    'user_id' => $validatedData['user_id'],
                    'package_id' => $validatedData['package_id'],
                    'amount' => $validatedData['amount'],
                    'ragular_amount' => $validatedData['ragularPrice'],
                    'payment_method' => $validatedData['payment_method'],
                    'discount_amount' => $validatedData['discount_amount'],
                    'plan' => $validatedData['plan'],
                    'transaction_id' => $validatedData['transaction_id'],
                    'status' => $validatedData['status'],
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);
            }

            // Create Payment with generated payment_id
            Payment::create([
                'user_id' => $validatedData['user_id'],
                'subscription_id' => $existingSubscription->id,
                'package_id' => $validatedData['package_id'],
                'amount' => $validatedData['amount'],
                'ragular_amount' => $validatedData['ragularPrice'],
                'discount_amount' => $validatedData['discount_amount'],
                'payment_method' => $validatedData['payment_method'],
                'transaction_id' => $validatedData['transaction_id'],
                'payment_id' => $paymentId,
                'status' => $validatedData['status'],
                'payment_date' => Carbon::now(),
            ]);

            DB::commit();
            return response()->json(['message' => 'Payment and Subscription successfully created or renewed.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create or renew payment and subscription. ' . $e->getMessage()], 500);
        }
    }
}
