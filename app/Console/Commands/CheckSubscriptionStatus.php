<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use Carbon\Carbon;

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

        // Update status to 'expired'
        foreach ($subscriptions as $subscription) {
            $subscription->status = 'expired';
            $subscription->save();
            $this->info('Subscription expired: ' . $subscription->id);  // Log for debugging
        }

        $this->info('All subscriptions checked and updated.');
    }
}
