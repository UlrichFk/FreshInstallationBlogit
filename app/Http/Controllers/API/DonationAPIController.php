<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Validator;

class DonationAPIController extends Controller
{
    private $language;
    
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
        $this->language = $request->header('language-code') && $request->header('language-code') != '' ? $request->header('language-code') : 'en';
    }

    public function getDonationStats(Request $request)
    {
        try {
            $totalDonations = Donation::completed()->sum('amount');
            $totalDonors = Donation::completed()->distinct('donor_email')->count();
            $monthlyDonations = Donation::completed()
                                      ->whereMonth('created_at', now()->month)
                                      ->sum('amount');
            $recurringDonations = Donation::completed()->recurring()->count();

            $stats = [
                'total_donations' => number_format($totalDonations, 2),
                'total_donors' => $totalDonors,
                'monthly_donations' => number_format($monthlyDonations, 2),
                'recurring_donations' => $recurringDonations,
                'currency' => 'USD'
            ];

            return $this->sendResponse($stats, __('lang.message_data_retrived_successfully'));
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    public function getUserDonations(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => false,
                'message' => 'Utilisateur non authentifié'
            ], 401);
        }

        $user = auth()->user();
        $donations = Donation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $donations
        ]);
    }

    public function createDonation(Request $request)
    {
        $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email',
            'amount' => 'required|numeric|min:1',
            'message' => 'nullable|string|max:1000',
            'is_anonymous' => 'boolean',
            'is_recurring' => 'boolean',
            'recurring_interval' => 'required_if:is_recurring,true|in:monthly,yearly',
            'payment_method' => 'required|in:stripe,paypal'
        ]);

        $donation = Donation::create([
            'user_id' => auth()->id(), // Peut être null pour les guests
            'donor_name' => $request->donor_name,
            'donor_email' => $request->donor_email,
            'message' => $request->message,
            'amount' => $request->amount,
            'currency' => 'USD',
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'is_anonymous' => $request->has('is_anonymous'),
            'is_recurring' => $request->has('is_recurring'),
            'recurring_interval' => $request->recurring_interval
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Donation créée avec succès',
            'data' => $donation
        ]);
    }

    public function confirmDonation(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'donation_id' => 'required|exists:donations,id',
                'transaction_id' => 'required|string',
                'payment_details' => 'nullable|array'
            ]);

            if ($validator->fails()) {
                return $this->sendError(__('lang.message_required_message'), $validator->errors());
            }

            $donation = Donation::findOrFail($request->donation_id);
            
            if ($donation->status !== 'pending') {
                return $this->sendError('Cette donation a déjà été traitée.');
            }

            $donation->markAsCompleted($request->transaction_id, $request->payment_details);

            return $this->sendResponse([
                'donation_id' => $donation->id,
                'status' => $donation->status,
                'amount' => $donation->formatted_amount
            ], 'Donation confirmée avec succès. Merci pour votre générosité !');
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    public function getRecentDonations(Request $request)
    {
        try {
            $limit = $request->get('limit', 10);
            
            $donations = Donation::completed()
                                ->where('is_anonymous', false)
                                ->orderBy('created_at', 'DESC')
                                ->limit($limit)
                                ->get();

            foreach ($donations as $donation) {
                $donation->formatted_amount = $donation->formatted_amount;
                $donation->display_name = $donation->display_name;
                $donation->formatted_date = $donation->created_at->format('d/m/Y');
            }

            return $this->sendResponse($donations, __('lang.message_data_retrived_successfully'));
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    public function getDonationGoals(Request $request)
    {
        try {
            // Exemple de buts de donation - à adapter selon vos besoins
            $goals = [
                [
                    'title' => 'Serveur mensuel',
                    'target' => 500.00,
                    'current' => 350.00,
                    'description' => 'Aide à couvrir les coûts de serveur mensuels'
                ],
                [
                    'title' => 'Développement de nouvelles fonctionnalités',
                    'target' => 2000.00,
                    'current' => 1200.00,
                    'description' => 'Financement du développement de nouvelles fonctionnalités'
                ],
                [
                    'title' => 'Support technique',
                    'target' => 1000.00,
                    'current' => 750.00,
                    'description' => 'Amélioration du support technique'
                ]
            ];

            foreach ($goals as &$goal) {
                $goal['percentage'] = round(($goal['current'] / $goal['target']) * 100, 1);
                $goal['remaining'] = $goal['target'] - $goal['current'];
                $goal['formatted_current'] = number_format($goal['current'], 2);
                $goal['formatted_target'] = number_format($goal['target'], 2);
                $goal['formatted_remaining'] = number_format($goal['remaining'], 2);
            }

            return $this->sendResponse($goals, __('lang.message_data_retrived_successfully'));
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }
} 