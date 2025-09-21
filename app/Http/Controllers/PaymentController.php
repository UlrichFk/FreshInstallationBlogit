<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembershipPlan;
use App\Models\UserSubscription;
use App\Models\Donation;
use App\Models\User;
use App\Models\Transaction;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Customer;
use Stripe\Subscription as StripeSubscription;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Illuminate\Support\Facades\Schema;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Configuration Stripe - seulement si configuré et si la classe existe
        $stripeSecret = \App\Models\Setting::where('key', 'stripe_secret')->value('value');
        if ($stripeSecret && class_exists('Stripe\Stripe')) {
            Stripe::setApiKey($stripeSecret);
        }
    }

    // Méthodes pour les abonnements
    public function showMembershipPlans()
    {
        // Si la colonne 'status' n'existe pas (bases anciennes), utiliser un fallback
        if (!Schema::hasColumn('membership_plans', 'status')) {
            $plans = MembershipPlan::query()->ordered()->get();
        } else {
            $plans = MembershipPlan::active()->ordered()->get();
        }
        
        // Si aucun plan n'existe, créer des plans de démonstration
        if ($plans->isEmpty()) {
            $demoPlans = collect([
                (object) [
                    'id' => 1,
                    'name' => 'Basic Plan',
                    'description' => 'Perfect for casual readers',
                    'price' => 9.99,
                    'currency' => 'USD',
                    'billing_cycle' => 'monthly',
                    'duration_days' => 30,
                    'is_featured' => false,
                    'features' => [
                        'Access to premium articles',
                        'Ad-free experience',
                        'Email support'
                    ]
                ],
                (object) [
                    'id' => 2,
                    'name' => 'Premium Plan',
                    'description' => 'Best value for serious readers',
                    'price' => 19.99,
                    'currency' => 'USD',
                    'billing_cycle' => 'monthly',
                    'duration_days' => 30,
                    'is_featured' => true,
                    'features' => [
                        'All Basic features',
                        'Exclusive content',
                        'Priority support',
                        'Early access to new features'
                    ]
                ],
                (object) [
                    'id' => 3,
                    'name' => 'Annual Plan',
                    'description' => 'Save 40% with annual billing',
                    'price' => 119.99,
                    'currency' => 'USD',
                    'billing_cycle' => 'yearly',
                    'duration_days' => 365,
                    'is_featured' => false,
                    'features' => [
                        'All Premium features',
                        '40% discount',
                        'Free premium content',
                        'VIP support'
                    ]
                ]
            ]);
            
            return view('site.membership.plans', compact('demoPlans'));
        }
        
        return view('site.membership.plans', compact('plans'));
    }

    public function subscribe(Request $request, $planId)
    {
        $plan = MembershipPlan::findOrFail($planId);
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour souscrire à un abonnement.');
        }

        return view('site.membership.subscribe', compact('plan', 'user'));
    }

    public function processStripeSubscription(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:membership_plans,id',
            'payment_method_id' => 'required|string'
        ]);

        $plan = MembershipPlan::findOrFail($request->plan_id);
        $user = auth()->user();

        // Vérifier que le plan a un stripe_price_id configuré
        if (!$plan->stripe_price_id) {
            return response()->json([
                'success' => false,
                'message' => 'Ce plan d\'abonnement n\'est pas configuré pour les paiements Stripe. Veuillez contacter l\'administrateur.'
            ], 400);
        }

        try {
            // Créer ou récupérer le client Stripe
            $customer = $this->getOrCreateStripeCustomer($user);

            // Créer l'abonnement Stripe
            $subscription = StripeSubscription::create([
                'customer' => $customer->id,
                'items' => [['price' => $plan->stripe_price_id]],
                'payment_behavior' => 'default_incomplete',
                'payment_settings' => ['save_default_payment_method' => 'on_subscription'],
                'expand' => ['latest_invoice.payment_intent'],
                'default_payment_method' => $request->payment_method_id,
            ]);

            // Créer l'abonnement en base
            $userSubscription = UserSubscription::create([
                'user_id' => $user->id,
                'membership_plan_id' => $plan->id,
                'subscription_id' => $subscription->id,
                'status' => 'pending',
                'start_date' => now(),
                'end_date' => now()->addDays($plan->duration_days),
                'amount_paid' => $plan->price,
                'currency' => $plan->currency,
                'payment_method' => 'stripe',
                'payment_details' => [
                    'stripe_subscription_id' => $subscription->id,
                    'payment_intent_id' => $subscription->latest_invoice->payment_intent->id
                ]
            ]);

            // Créer la transaction
            Transaction::createFromSubscription($userSubscription);

            return response()->json([
                'success' => true,
                'subscription_id' => $subscription->id,
                'client_secret' => $subscription->latest_invoice->payment_intent->client_secret
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du traitement du paiement: ' . $e->getMessage()
            ], 500);
        }
    }

    public function processPayPalSubscription(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:membership_plans,id',
            'order_id' => 'required|string'
        ]);

        $plan = MembershipPlan::findOrFail($request->plan_id);
        $user = auth()->user();

        // Vérifier que le plan a un paypal_plan_id configuré
        if (!$plan->paypal_plan_id) {
            return response()->json([
                'success' => false,
                'message' => 'Ce plan d\'abonnement n\'est pas configuré pour les paiements PayPal. Veuillez contacter l\'administrateur.'
            ], 400);
        }

        try {
            // Capturer le paiement PayPal
            $client = $this->getPayPalClient();
            $request = new OrdersCaptureRequest($request->order_id);
            $response = $client->execute($request);

            if ($response->result->status === 'COMPLETED') {
                // Créer l'abonnement en base
                $userSubscription = UserSubscription::create([
                    'user_id' => $user->id,
                    'membership_plan_id' => $plan->id,
                    'subscription_id' => $request->order_id,
                    'status' => 'active',
                    'start_date' => now(),
                    'end_date' => now()->addDays($plan->duration_days),
                    'amount_paid' => $plan->price,
                    'currency' => $plan->currency,
                    'payment_method' => 'paypal',
                    'payment_details' => [
                        'paypal_order_id' => $request->order_id,
                        'paypal_plan_id' => $plan->paypal_plan_id
                    ]
                ]);

                // Créer la transaction
                $transaction = Transaction::createFromSubscription($userSubscription);
                $transaction->markAsCompleted($request->order_id);

                return response()->json([
                    'success' => true,
                    'subscription_id' => $userSubscription->id
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Le paiement PayPal n\'a pas été complété'
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du traitement du paiement PayPal: ' . $e->getMessage()
            ], 500);
        }
    }

    // Méthodes pour les donations
    public function showDonationForm()
    {
        return view('site.donation.index');
    }

    public function processStripeDonation(Request $request)
    {
        $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email',
            'amount' => 'required|numeric|min:1',
            'message' => 'nullable|string',
            'is_anonymous' => 'boolean',
            'is_recurring' => 'boolean',
            'recurring_interval' => 'required_if:is_recurring,true|in:monthly,yearly'
        ]);

        try {
            $donation = Donation::create([
                'user_id' => auth()->id() ?? null, // Peut être null pour les guests
                'donor_name' => $request->donor_name,
                'donor_email' => $request->donor_email,
                'message' => $request->message,
                'amount' => $request->amount,
                'currency' => 'USD',
                'status' => 'pending',
                'payment_method' => 'stripe',
                'is_anonymous' => $request->has('is_anonymous'),
                'is_recurring' => $request->has('is_recurring'),
                'recurring_interval' => $request->recurring_interval
            ]);

            // Créer la transaction
            Transaction::createFromDonation($donation);

            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100, // Stripe utilise les centimes
                'currency' => 'usd',
                'metadata' => [
                    'donation_id' => $donation->id,
                    'donor_name' => $request->donor_name,
                    'donor_email' => $request->donor_email
                ]
            ]);

            return response()->json([
                'success' => true,
                'client_secret' => $paymentIntent->client_secret,
                'donation_id' => $donation->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function processPayPalDonation(Request $request)
    {
        $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email',
            'amount' => 'required|numeric|min:1',
            'message' => 'nullable|string',
            'is_anonymous' => 'boolean',
            'is_recurring' => 'boolean',
            'recurring_interval' => 'required_if:is_recurring,true|in:monthly,yearly'
        ]);

        try {
            $donation = Donation::create([
                'user_id' => auth()->id() ?? null, // Peut être null pour les guests
                'donor_name' => $request->donor_name,
                'donor_email' => $request->donor_email,
                'message' => $request->message,
                'amount' => $request->amount,
                'currency' => 'USD',
                'status' => 'pending',
                'payment_method' => 'paypal',
                'is_anonymous' => $request->has('is_anonymous'),
                'is_recurring' => $request->has('is_recurring'),
                'recurring_interval' => $request->recurring_interval
            ]);

            // Créer la transaction
            Transaction::createFromDonation($donation);

            $client = $this->getPayPalClient();
            $request = new OrdersCreateRequest();
            $request->prefer('return=representation');
            $request->body = [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'reference_id' => 'donation_' . $donation->id,
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => number_format($request->amount, 2, '.', '')
                    ],
                    'description' => 'Donation - ' . $request->donor_name
                ]],
                'application_context' => [
                    'cancel_url' => route('donation.cancel'),
                    'return_url' => route('donation.success')
                ]
            ];

            $response = $client->execute($request);

            return response()->json([
                'success' => true,
                'order_id' => $response->result->id,
                'approval_url' => $response->result->links[1]->href,
                'donation_id' => $donation->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Webhooks
    public function stripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\Exception $e) {
            \Log::error('Stripe Webhook Signature Error: ' . $e->getMessage(), [
                'payload_length' => strlen($payload),
                'signature_header' => $sigHeader,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        try {
            switch ($event->type) {
                case 'invoice.payment_succeeded':
                    $this->handleStripePaymentSucceeded($event->data->object);
                    break;
                case 'invoice.payment_failed':
                    $this->handleStripePaymentFailed($event->data->object);
                    break;
                case 'customer.subscription.deleted':
                    $this->handleStripeSubscriptionCancelled($event->data->object);
                    break;
                case 'payment_intent.succeeded':
                    $this->handleStripePaymentIntentSucceeded($event->data->object);
                    break;
                case 'payment_intent.payment_failed':
                    $this->handleStripePaymentIntentFailed($event->data->object);
                    break;
                default:
                    \Log::info('Unhandled Stripe event: ' . $event->type);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            \Log::error('Stripe Webhook Processing Error: ' . $e->getMessage(), [
                'event_type' => $event->type,
                'event_id' => $event->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json(['error' => 'Processing error'], 500);
        }
    }

    public function paypalWebhook(Request $request)
    {
        $payload = $request->all();
        
        try {
            // Vérifier la signature du webhook PayPal
            $this->verifyPayPalWebhook($request);
            
            // Traiter les événements PayPal
            switch ($payload['event_type']) {
                case 'PAYMENT.CAPTURE.COMPLETED':
                    $this->handlePayPalPaymentCompleted($payload['resource']);
                    break;
                case 'PAYMENT.CAPTURE.DENIED':
                    $this->handlePayPalPaymentDenied($payload['resource']);
                    break;
                case 'BILLING.SUBSCRIPTION.ACTIVATED':
                    $this->handlePayPalSubscriptionActivated($payload['resource']);
                    break;
                case 'BILLING.SUBSCRIPTION.CANCELLED':
                    $this->handlePayPalSubscriptionCancelled($payload['resource']);
                    break;
            }
            
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            \Log::error('PayPal Webhook Error: ' . $e->getMessage(), [
                'payload' => $payload,
                'error' => $e->getMessage()
            ]);
            
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // Méthodes privées
    private function getOrCreateStripeCustomer($user)
    {
        if ($user->stripe_customer_id) {
            return Customer::retrieve($user->stripe_customer_id);
        }

        $customer = Customer::create([
            'email' => $user->email,
            'name' => $user->name,
            'metadata' => [
                'user_id' => $user->id
            ]
        ]);

        $user->update(['stripe_customer_id' => $customer->id]);
        return $customer;
    }

    private function getPayPalClient()
    {
        $clientId = \App\Models\Setting::where('key', 'paypal_client_id')->value('value');
        $secret = \App\Models\Setting::where('key', 'paypal_secret')->value('value');
        $mode = \App\Models\Setting::where('key', 'paypal_mode')->value('value') ?: 'sandbox';

        if ($mode === 'sandbox') {
            $environment = new SandboxEnvironment($clientId, $secret);
        } else {
            $environment = new ProductionEnvironment($clientId, $secret);
        }

        return new PayPalHttpClient($environment);
    }

    private function handleStripePaymentSucceeded($invoice)
    {
        $subscription = UserSubscription::where('subscription_id', $invoice->subscription)->first();
        
        if ($subscription) {
            $subscription->update([
                'status' => 'active',
                'payment_details' => array_merge($subscription->payment_details ?? [], [
                    'last_payment_intent' => $invoice->payment_intent
                ])
            ]);

            // Mettre à jour la transaction
            $transaction = Transaction::where('related_model', 'UserSubscription')
                                    ->where('related_id', $subscription->id)
                                    ->first();
            if ($transaction) {
                $transaction->markAsCompleted($invoice->payment_intent);
            }
        }
    }

    private function handleStripePaymentFailed($invoice)
    {
        $subscription = UserSubscription::where('subscription_id', $invoice->subscription)->first();
        
        if ($subscription) {
            $subscription->update(['status' => 'failed']);

            // Mettre à jour la transaction
            $transaction = Transaction::where('related_model', 'UserSubscription')
                                    ->where('related_id', $subscription->id)
                                    ->first();
            if ($transaction) {
                $transaction->markAsFailed();
            }
        }
    }

    private function handleStripeSubscriptionCancelled($subscription)
    {
        $userSubscription = UserSubscription::where('subscription_id', $subscription->id)->first();
        
        if ($userSubscription) {
            $userSubscription->cancel();
        }
    }

    private function handleStripePaymentIntentSucceeded($paymentIntent)
    {
        // Gérer les donations via Payment Intent
        if (isset($paymentIntent->metadata->donation_id)) {
            $donation = Donation::find($paymentIntent->metadata->donation_id);
            
            if ($donation) {
                $donation->markAsCompleted($paymentIntent->id, $paymentIntent->toArray());
                
                // Mettre à jour la transaction
                $transaction = Transaction::where('related_model', 'Donation')
                                        ->where('related_id', $donation->id)
                                        ->first();
                if ($transaction) {
                    $transaction->markAsCompleted($paymentIntent->id);
                }
            }
        }
    }

    private function handleStripePaymentIntentFailed($paymentIntent)
    {
        // Gérer les échecs de donations via Payment Intent
        if (isset($paymentIntent->metadata->donation_id)) {
            $donation = Donation::find($paymentIntent->metadata->donation_id);
            
            if ($donation) {
                $donation->markAsFailed($paymentIntent->toArray());
                
                // Mettre à jour la transaction
                $transaction = Transaction::where('related_model', 'Donation')
                                        ->where('related_id', $donation->id)
                                        ->first();
                if ($transaction) {
                    $transaction->markAsFailed();
                }
            }
        }
    }

    // Méthodes de gestion PayPal
    private function verifyPayPalWebhook($request)
    {
        // Vérification de la signature du webhook PayPal
        // Cette méthode devrait implémenter la vérification selon la documentation PayPal
        // Pour l'instant, on accepte tous les webhooks (à améliorer en production)
        return true;
    }

    private function handlePayPalPaymentCompleted($resource)
    {
        $donation = Donation::where('transaction_id', $resource['id'])->first();
        
        if ($donation) {
            $donation->markAsCompleted($resource['id'], $resource);
            
            // Mettre à jour la transaction
            $transaction = Transaction::where('related_model', 'Donation')
                                    ->where('related_id', $donation->id)
                                    ->first();
            if ($transaction) {
                $transaction->markAsCompleted($resource['id']);
            }
        }
    }

    private function handlePayPalPaymentDenied($resource)
    {
        $donation = Donation::where('transaction_id', $resource['id'])->first();
        
        if ($donation) {
            $donation->markAsFailed($resource);
            
            // Mettre à jour la transaction
            $transaction = Transaction::where('related_model', 'Donation')
                                    ->where('related_id', $donation->id)
                                    ->first();
            if ($transaction) {
                $transaction->markAsFailed();
            }
        }
    }

    private function handlePayPalSubscriptionActivated($resource)
    {
        $subscription = UserSubscription::where('subscription_id', $resource['id'])->first();
        
        if ($subscription) {
            $subscription->update(['status' => 'active']);
            
            // Mettre à jour la transaction
            $transaction = Transaction::where('related_model', 'UserSubscription')
                                    ->where('related_id', $subscription->id)
                                    ->first();
            if ($transaction) {
                $transaction->markAsCompleted($resource['id']);
            }
        }
    }

    private function handlePayPalSubscriptionCancelled($resource)
    {
        $subscription = UserSubscription::where('subscription_id', $resource['id'])->first();
        
        if ($subscription) {
            $subscription->cancel();
        }
    }

    // Méthodes existantes pour la compatibilité
    private function getPaypalApiContext()
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('services.paypal.client_id'),
                config('services.paypal.secret')
            )
        );

        $apiContext->setConfig([
            'mode' => config('services.paypal.sandbox') ? 'sandbox' : 'live',
            'log.LogEnabled' => true,
            'log.FileName' => storage_path('logs/paypal.log'),
            'log.LogLevel' => 'INFO'
        ]);

        return $apiContext;
    }

    public function payMembership(Request $request)
    {
        // Méthode existante pour la compatibilité
        return $this->subscribe($request, $request->plan_id);
    }

    public function donate(Request $request)
    {
        // Méthode existante pour la compatibilité
        return $this->showDonationForm();
    }
}