<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class PaymentSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Stripe Configuration
            ['key' => 'stripe_enabled', 'value' => '0', 'type' => 'payment'],
            ['key' => 'stripe_key', 'value' => '', 'type' => 'payment'],
            ['key' => 'stripe_secret', 'value' => '', 'type' => 'payment'],
            ['key' => 'stripe_webhook_secret', 'value' => '', 'type' => 'payment'],
            ['key' => 'stripe_currency', 'value' => 'usd', 'type' => 'payment'],
            
            // PayPal Configuration
            ['key' => 'paypal_enabled', 'value' => '0', 'type' => 'payment'],
            ['key' => 'paypal_client_id', 'value' => '', 'type' => 'payment'],
            ['key' => 'paypal_secret', 'value' => '', 'type' => 'payment'],
            ['key' => 'paypal_mode', 'value' => 'sandbox', 'type' => 'payment'],
            ['key' => 'paypal_webhook_id', 'value' => '', 'type' => 'payment'],
            ['key' => 'paypal_currency', 'value' => 'USD', 'type' => 'payment'],
            
            // General Payment Configuration
            ['key' => 'payment_currency', 'value' => 'USD', 'type' => 'payment'],
            ['key' => 'payment_success_url', 'value' => '', 'type' => 'payment'],
            ['key' => 'payment_cancel_url', 'value' => '', 'type' => 'payment'],
            ['key' => 'payment_webhook_url', 'value' => '', 'type' => 'payment'],
            ['key' => 'payment_test_mode', 'value' => '1', 'type' => 'payment'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type']
                ]
            );
        }
    }
} 