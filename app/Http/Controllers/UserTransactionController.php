<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class UserTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->all();
        
        $transactions = Transaction::with(['subscription.membershipPlan', 'donation'])
            ->where('user_id', $user->id)
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
            ->paginate(15);

        // Statistiques de l'utilisateur
        $stats = Transaction::getStats($user->id);
        
        // Filtres
        $types = ['subscription' => 'Abonnement', 'donation' => 'Donation', 'refund' => 'Remboursement'];
        $statuses = ['pending' => 'En attente', 'completed' => 'Complété', 'failed' => 'Échoué', 'cancelled' => 'Annulé', 'refunded' => 'Remboursé'];
        $paymentMethods = ['stripe' => 'Stripe', 'paypal' => 'PayPal'];

        return view('site.transactions.index', compact('transactions', 'stats', 'types', 'statuses', 'paymentMethods', 'search'));
    }

    public function show($id)
    {
        $user = auth()->user();
        $transaction = Transaction::with(['subscription.membershipPlan', 'donation'])
            ->where('user_id', $user->id)
            ->findOrFail($id);

        return view('site.transactions.show', compact('transaction'));
    }

    public function downloadInvoice($id)
    {
        $user = auth()->user();
        $transaction = Transaction::with(['subscription.membershipPlan', 'donation'])
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->findOrFail($id);

        // Générer une facture PDF
        $pdf = \PDF::loadView('site.transactions.invoice', compact('transaction'));
        
        $filename = 'facture_' . $transaction->id . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    public function getStats(Request $request)
    {
        $user = auth()->user();
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

        $stats = Transaction::getStats($user->id, $dateRange);

        return response()->json($stats);
    }
} 