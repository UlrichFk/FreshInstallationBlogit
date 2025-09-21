<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MembershipPlan;

class MembershipPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Plan Mensuel',
                'description' => 'Accès complet à tous les articles premium pendant 1 mois',
                'price' => 9.99,
                'currency' => 'USD',
                'billing_cycle' => 'monthly',
                'duration_days' => 30,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
                'features' => [
                    'Accès à tous les articles premium',
                    'Pas de publicités',
                    'Support prioritaire',
                    'Contenu exclusif'
                ],
                'stripe_price_id' => null, // À configurer dans Stripe
                'paypal_plan_id' => null   // À configurer dans PayPal
            ],
            [
                'name' => 'Plan Annuel',
                'description' => 'Accès complet à tous les articles premium pendant 1 an (2 mois gratuits)',
                'price' => 99.99,
                'currency' => 'USD',
                'billing_cycle' => 'yearly',
                'duration_days' => 365,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'features' => [
                    'Accès à tous les articles premium',
                    'Pas de publicités',
                    'Support prioritaire',
                    'Contenu exclusif',
                    '2 mois gratuits',
                    'Accès anticipé aux nouvelles fonctionnalités'
                ],
                'stripe_price_id' => null, // À configurer dans Stripe
                'paypal_plan_id' => null   // À configurer dans PayPal
            ],
            [
                'name' => 'Plan à Vie',
                'description' => 'Accès permanent à tous les articles premium',
                'price' => 299.99,
                'currency' => 'USD',
                'billing_cycle' => 'lifetime',
                'duration_days' => 36500, // 100 ans
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'features' => [
                    'Accès permanent à tous les articles premium',
                    'Pas de publicités',
                    'Support prioritaire',
                    'Contenu exclusif',
                    'Accès anticipé aux nouvelles fonctionnalités',
                    'Accès aux archives complètes'
                ],
                'stripe_price_id' => null, // À configurer dans Stripe
                'paypal_plan_id' => null   // À configurer dans PayPal
            ]
        ];

        foreach ($plans as $plan) {
            MembershipPlan::create($plan);
        }
    }
} 