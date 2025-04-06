<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get subscriptions along with their latest payment (order payments by date)
        $subscriptions = Subscription::with(['payments' => function ($query) {
            $query->latest(); // Order payments by latest date
        }])->orderBy('created_at', 'DESC')->get();

        return view('admin.subscriptions.index', compact('subscriptions'));
    }


    // public function reject($id)
    // {
    //     DB::beginTransaction();

    //     try {
    //         // Find the subscription
    //         $subscription = Subscription::find($id);

    //         // Check if subscription exists
    //         if (!$subscription) {
    //             return redirect()->back()->with('error', 'Subscription not found.');
    //         }

    //         // Reject the subscription
    //         $subscription->status = 'rejected';
    //         $subscription->save();

    //         // Update the last payment status to 'rejected'
    //         $lastPayment = $subscription->payments->last(); // Get the last payment
    //         if ($lastPayment) {
    //             $lastPayment->status = 'failed';
    //             $lastPayment->save();
    //         }

    //         // Update the user status to 2 (rejected)
    //         $user = $subscription->user;
    //         if ($user) {
    //             $user->status = 2; // 2 means rejected
    //             $user->save();
    //         }

    //         // Update the shop's shop_id to 2 (rejected shop)
    //         $shop = $subscription->user->shop; // Assuming the user has a related shop
    //         if ($shop) {
    //             $shop->status = 2; // Set the shop_id to 2
    //             $shop->save();
    //         }

    //         DB::commit();
    //         return redirect()->back()->with('success', 'Subscription rejected successfully');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Failed to reject subscription. ' . $e->getMessage());
    //     }
    // }




    public function edit($id)
    {
        $subscription = Subscription::with('payments')->find($id);

        return view('admin.subscriptions.edit', compact('subscription'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $subscription = Subscription::find($id);

            if (!$subscription) {
                return redirect()->back()->with('error', 'Subscription not found.');
            }

            $status = $request->subscription_status;
            $validStatuses = ['pending', 'active', 'rejected'];

            if (!in_array($status, $validStatuses)) {
                return redirect()->back()->with('error', 'Invalid status.');
            }

            $subscription->status = $status;
            $subscription->save();

            $lastPayment = $subscription->payments->last();
            if ($lastPayment) {
                if ($status == 'pending') {
                    $lastPayment->status = 'pending';
                } elseif ($status == 'active') {
                    $lastPayment->status = 'completed';
                } elseif ($status == 'rejected') {
                    $lastPayment->status = 'failed';
                }
                $lastPayment->save();
            }

            $user = $subscription->user;
            if ($user) {
                if ($status == 'pending' || $status == 'rejected') {
                    $user->status = 2;
                } elseif ($status == 'active') {
                    $user->status = 1;
                }
                $user->save();

                // Shop status update
                foreach ($user->shops as $shop) {
                    $shop->status = ($status == 'active') ? 1 : 2;
                    $shop->save();
                }

                // ✅ Commission System
                if ($status == 'active' && $user->referred_by) {
                    $referrer = User::find($user->referred_by);
                    if ($referrer) {
                        // ধরো 75% কমিশন দিচ্ছো
                        $commissionPercent = 75;

                        // Subscription amount ধরলাম
                        $amount = $lastPayment ? $lastPayment->amount : 0;
                        $commission = ($amount * $commissionPercent) / 100;

                        // রেফারারের commission বাড়িয়ে দাও
                        $referrer->commission += $commission;
                        $referrer->save();

                        // রেফারারকে মেইল / নোটিফিকেশন পাঠাও
                        $referrer->notify(new \App\Notifications\ReferralCommissionEarned($user->name, $commission));
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Subscription updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update subscription. ' . $e->getMessage());
        }
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
