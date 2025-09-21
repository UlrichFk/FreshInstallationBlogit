<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserSubscription;
use Carbon\Carbon;

class CheckExpiredSubscriptions extends Command
{
    protected $signature = 'subscriptions:check-expired';
    protected $description = 'Check and update expired subscriptions';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Checking for expired subscriptions...');

        $expiredSubscriptions = UserSubscription::where('status', 'active')
                                               ->where('end_date', '<=', now())
                                               ->get();

        $count = 0;
        foreach ($expiredSubscriptions as $subscription) {
            $subscription->update([
                'status' => 'expired',
                'updated_at' => now()
            ]);
            
            $this->line("Expired subscription ID: {$subscription->id} for user: {$subscription->user_id}");
            $count++;
        }

        $this->info("Updated {$count} expired subscriptions.");

        // Optionnel : Envoyer des notifications aux utilisateurs
        if ($count > 0) {
            $this->info('Consider sending renewal notifications to users.');
        }

        return Command::SUCCESS;
    }
} 