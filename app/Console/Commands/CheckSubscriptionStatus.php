<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Shop;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Console\Command;

class CheckSubscriptionStatus extends Command
{
    // The name and signature of the console command
    protected $signature = 'subscription:check-status';

    // The console command description
    protected $description = 'Check subscriptions and mark expired if end_date is today';

    public function __construct()
    {
        parent::__construct();
    }

    // Execute the console command
    public function handle()
    {
        // Get today’s date
        $today = Carbon::today();

        // Fetch all subscriptions where end_date is today and status is not already 'expired'
        $subscriptions = Subscription::where('end_date', $today)
            ->where('status', '!=', 'expired')
            ->get();

        // Update status to 'expired' and update user status to 2
        foreach ($subscriptions as $subscription) {
            // Update subscription status to 'expired'
            $subscription->status = 'expired';
            $subscription->save();

            // Now update the user's status to 2 (for expired subscription)
            $user = User::where('id', $subscription->user_id)->first();

            if ($user) {
                $user->status = 2;  // Set the status to 2 (inactive)
                $user->save();
            }

            // Also update the shop's status to 2 (inactive) when subscription expires
            $shop = Shop::where('user_id', $subscription->user_id)->first();

            if ($shop) {
                $shop->status = 2;  // Set the shop's status to 2 (inactive)
                $shop->save();
            }

            $this->info('Subscription expired, user and shop status updated to 2 for user: ' . $subscription->user_id);
        }

        // Now handle free trial users who have been created for more than 15 days
        // Check if user has no active subscription
        $freeTrialUsers = Shop::whereDate('created_at', '<', $today->subDays(15)) // If created more than 15 days ago
            ->get();

        foreach ($freeTrialUsers as $shop) {
            // Check if the user has an active subscription
            $subscription = Subscription::where('user_id', $shop->user_id)
                ->where('status', 'active') // Check if the user has an active subscription
                ->first();

            if (!$subscription) {
                // If no active subscription, set both user and shop status to 2 (inactive)
                $user = User::where('id', $shop->user_id)->first();
                if ($user) {
                    $user->status = 2;  // Set the user status to 2 (inactive)
                    $user->save();
                }

                // Set shop status to 2 (inactive)
                $shop->status = 2;
                $shop->save();

                $this->info('User with free trial expired and no active subscription, user and shop status updated to 2: ' . $shop->user_id);
            }
        }

        $this->info('All subscriptions and free trial users checked and updated.');
    }
}
