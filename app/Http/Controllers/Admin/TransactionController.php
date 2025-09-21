<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->all();
        $transactions = Transaction::with(['user', 'subscription.membershipPlan', 'donation'])
            ->when(isset($search['user_id']) && $search['user_id'], function($query) use ($search) {
                $query->where('user_id', $search['user_id']);
            })
            ->when(isset($search['type']) && $search['type'], function($query) use ($search) {
                $query->where('type', $search['type']);
            })
            ->when(isset($search['status']) && $search['status'], function($query) use ($search) {
                $query->where('status', $search['status']);
            })
            ->when(isset($search['payment_method']) && $search['payment_method'], function($query) use ($search) {
                $query->where('payment_method', $search['payment_method']);
            })
            ->when(isset($search['date_range']) && $search['date_range'], function($query) use ($search) {
                $dates = explode(' to ', $search['date_range']);
                if (count($dates) == 2) {
                    $startDate = Carbon::parse(trim($dates[0]))->startOfDay();
                    $endDate = Carbon::parse(trim($dates[1]))->endOfDay();
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Statistiques
        $stats = Transaction::getStats();
        
        // Filtres pour la vue
        $users = User::where('type', 'user')->orderBy('name')->get();
        $types = ['subscription' => 'Abonnement', 'donation' => 'Donation', 'refund' => 'Remboursement'];
        $statuses = ['pending' => 'En attente', 'completed' => 'Complété', 'failed' => 'Échoué', 'cancelled' => 'Annulé', 'refunded' => 'Remboursé'];
        $paymentMethods = ['stripe' => 'Stripe', 'paypal' => 'PayPal'];

        return view('admin.transactions.index', compact('transactions', 'stats', 'users', 'types', 'statuses', 'paymentMethods', 'search'));
    }

    public function show($id)
    {
        $transaction = Transaction::with(['user', 'subscription.membershipPlan', 'donation'])
            ->findOrFail($id);

        return view('admin.transactions.show', compact('transaction'));
    }

    public function userTransactions($userId)
    {
        $user = User::findOrFail($userId);
        $transactions = Transaction::with(['subscription.membershipPlan', 'donation'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = Transaction::getStats($userId);

        return view('admin.transactions.user', compact('user', 'transactions', 'stats'));
    }

    public function export(Request $request)
    {
        $search = $request->all();
        $transactions = Transaction::with(['user', 'subscription.membershipPlan', 'donation'])
            ->when(isset($search['user_id']) && $search['user_id'], function($query) use ($search) {
                $query->where('user_id', $search['user_id']);
            })
            ->when(isset($search['type']) && $search['type'], function($query) use ($search) {
                $query->where('type', $search['type']);
            })
            ->when(isset($search['status']) && $search['status'], function($query) use ($search) {
                $query->where('status', $search['status']);
            })
            ->when(isset($search['payment_method']) && $search['payment_method'], function($query) use ($search) {
                $query->where('payment_method', $search['payment_method']);
            })
            ->when(isset($search['date_range']) && $search['date_range'], function($query) use ($search) {
                $dates = explode(' to ', $search['date_range']);
                if (count($dates) == 2) {
                    $startDate = Carbon::parse(trim($dates[0]))->startOfDay();
                    $endDate = Carbon::parse(trim($dates[1]))->endOfDay();
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'transactions_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID',
                'Utilisateur',
                'Type',
                'Montant',
                'Devise',
                'Statut',
                'Méthode de paiement',
                'ID Transaction',
                'Description',
                'Date de création',
                'Date de traitement'
            ]);

            // Données
            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->id,
                    $transaction->user ? $transaction->user->name : 'Anonyme',
                    $transaction->type_label,
                    $transaction->amount,
                    $transaction->currency,
                    $transaction->status,
                    $transaction->payment_method_label,
                    $transaction->transaction_id,
                    $transaction->description,
                    $transaction->created_at->format('Y-m-d H:i:s'),
                    $transaction->processed_at ? $transaction->processed_at->format('Y-m-d H:i:s') : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function refund($id)
    {
        $transaction = Transaction::findOrFail($id);
        
        if (!$transaction->isCompleted()) {
            return redirect()->back()->with('error', 'Seules les transactions complétées peuvent être remboursées.');
        }

        try {
            // Logique de remboursement selon la méthode de paiement
            if ($transaction->payment_method === 'stripe') {
                $this->processStripeRefund($transaction);
            } elseif ($transaction->payment_method === 'paypal') {
                $this->processPayPalRefund($transaction);
            }

            $transaction->markAsRefunded();
            
            return redirect()->back()->with('success', 'Remboursement traité avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du remboursement: ' . $e->getMessage());
        }
    }

    private function processStripeRefund($transaction)
    {
        // Implémenter la logique de remboursement Stripe
        // Utiliser l'API Stripe pour créer un remboursement
    }

    private function processPayPalRefund($transaction)
    {
        // Implémenter la logique de remboursement PayPal
        // Utiliser l'API PayPal pour créer un remboursement
    }

    public function getStats(Request $request)
    {
        $dateRange = null;
        if ($request->has('date_range') && $request->date_range) {
            $dates = explode(' to ', $request->date_range);
            if (count($dates) == 2) {
                $dateRange = [
                    'start' => Carbon::parse(trim($dates[0]))->startOfDay(),
                    'end' => Carbon::parse(trim($dates[1]))->endOfDay()
                ];
            }
        }

        $stats = Transaction::getStats(null, $dateRange);

        return response()->json($stats);
    }
} 