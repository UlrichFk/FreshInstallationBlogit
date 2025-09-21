<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
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
            ->when(isset($search['period']), function($query) use ($search) {
                switch($search['period']) {
                    case 'today':
                        $query->whereDate('created_at', Carbon::today());
                        break;
                    case 'week':
                        $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                        break;
                    case 'month':
                        $query->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                        break;
                    case 'year':
                        $query->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
                        break;
                }
            })
            ->when(isset($search['amount_range']), function($query) use ($search) {
                switch($search['amount_range']) {
                    case '0-10':
                        $query->whereBetween('amount', [0, 10]);
                        break;
                    case '10-50':
                        $query->whereBetween('amount', [10, 50]);
                        break;
                    case '50-100':
                        $query->whereBetween('amount', [50, 100]);
                        break;
                    case '100+':
                        $query->where('amount', '>', 100);
                        break;
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Statistiques pour la vue
        $stats = Transaction::getStats($user->id);
        
        return view('site.transactions.index', compact('transactions', 'stats'));
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
        $pdf = Pdf::loadView('site.transactions.invoice', compact('transaction'));
        
        $filename = 'facture_' . $transaction->id . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    public function exportSingle(Request $request, $id)
    {
        $user = auth()->user();
        $transaction = Transaction::with(['subscription.membershipPlan', 'donation'])
            ->where('user_id', $user->id)
            ->findOrFail($id);

        $format = $request->get('format', 'pdf');

        if ($format === 'csv') {
            return $this->exportSingleCsv($transaction);
        } else {
            return $this->exportSinglePdf($transaction);
        }
    }

    private function exportSingleCsv($transaction)
    {
        $filename = 'transaction_' . $transaction->id . '_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function() use ($transaction) {
            $handle = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV headers
            fputcsv($handle, [
                'Champ',
                'Valeur'
            ]);

            // CSV data
            $data = [
                ['ID Transaction', $transaction->id],
                ['Type', $transaction->type_label ?? ucfirst($transaction->type)],
                ['Description', $transaction->description],
                ['Montant', '€' . number_format($transaction->amount, 2)],
                ['Statut', $transaction->status_label ?? ucfirst($transaction->status)],
                ['Méthode de Paiement', $transaction->payment_method_label ?? ucfirst($transaction->payment_method)],
                ['Date de Création', $transaction->created_at->format('d/m/Y H:i')],
                ['Date de Traitement', $transaction->processed_at ? $transaction->processed_at->format('d/m/Y H:i') : 'Non traité']
            ];

            foreach ($data as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        }, 200, $headers);
    }

    private function exportSinglePdf($transaction)
    {
        $data = [
            'transaction' => $transaction,
            'export_date' => now()->format('d/m/Y à H:i')
        ];
        $pdf = Pdf::loadView('site.transactions.single-export-pdf', $data);
        
        $filename = 'transaction_' . $transaction->id . '_' . date('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }

    public function analytics(Request $request)
    {
        try {
            $user = auth()->user();
            $period = $request->get('period', 30); // 7, 30, 90, 365 jours
            
            $startDate = Carbon::now()->subDays($period);
            $endDate = Carbon::now();
            
            // Statistiques de base
            $stats = Transaction::getStats($user->id, [
                'start' => $startDate,
                'end' => $endDate
            ]);
            
            // Données pour les graphiques
            $charts = [
                'spending_trend' => $this->getSpendingTrend($user->id, $startDate, $endDate),
                'types' => $this->getTransactionTypes($user->id, $startDate, $endDate),
                'payment_methods' => $this->getPaymentMethods($user->id, $startDate, $endDate),
                'monthly' => $this->getMonthlyBreakdown($user->id, $startDate, $endDate)
            ];
            
            // Insights
            $insights = $this->generateInsights($user->id, $stats, $charts);
            
            return view('site.transactions.analytics', compact('stats', 'charts', 'insights', 'period'));
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une vue avec des données par défaut
            $stats = [
                'total_transactions' => 0,
                'total_amount' => 0,
                'completed_transactions' => 0,
                'pending_transactions' => 0,
                'subscriptions_count' => 0,
                'donations_count' => 0,
                'this_month_transactions' => 0,
                'this_week_transactions' => 0,
                'average_amount' => 0,
                'success_rate' => 0
            ];
            
            $charts = [
                'spending_trend' => ['labels' => [], 'data' => []],
                'types' => ['labels' => [], 'data' => []],
                'payment_methods' => ['labels' => [], 'data' => []],
                'monthly' => ['labels' => [], 'data' => []]
            ];
            
            $insights = [];
            $period = 30;
            
            return view('site.transactions.analytics', compact('stats', 'charts', 'insights', 'period'));
        }
    }

    public function dashboard()
    {
        try {
            $user = auth()->user();
            
            // Statistiques de base
            $stats = Transaction::getStats($user->id);
            
            // Transactions récentes
            $recentTransactions = Transaction::with(['subscription.membershipPlan', 'donation'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
            
            // Statistiques par type
            $stats['subscription_count'] = Transaction::where('user_id', $user->id)
                ->where('type', 'subscription')
                ->count();
            $stats['subscription_amount'] = Transaction::where('user_id', $user->id)
                ->where('type', 'subscription')
                ->sum('amount');
                
            $stats['donation_count'] = Transaction::where('user_id', $user->id)
                ->where('type', 'donation')
                ->count();
            $stats['donation_amount'] = Transaction::where('user_id', $user->id)
                ->where('type', 'donation')
                ->sum('amount');
                
            $stats['refund_count'] = Transaction::where('user_id', $user->id)
                ->where('type', 'refund')
                ->count();
            $stats['refund_amount'] = Transaction::where('user_id', $user->id)
                ->where('type', 'refund')
                ->sum('amount');
            
            $recent_transactions = $recentTransactions;
            return view('site.transactions.dashboard', compact('stats', 'recent_transactions'));
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une vue avec des données par défaut
            $stats = [
                'total_transactions' => 0,
                'total_amount' => 0,
                'completed_transactions' => 0,
                'pending_transactions' => 0,
                'subscriptions_count' => 0,
                'donations_count' => 0,
                'this_month_transactions' => 0,
                'this_week_transactions' => 0,
                'average_amount' => 0,
                'success_rate' => 0,
                'subscription_count' => 0,
                'subscription_amount' => 0,
                'donation_count' => 0,
                'donation_amount' => 0,
                'refund_count' => 0,
                'refund_amount' => 0
            ];
            
            $recent_transactions = collect();
            
            return view('site.transactions.dashboard', compact('stats', 'recent_transactions'));
        }
    }

    private function getSpendingTrend($userId, $startDate, $endDate)
    {
        $transactions = Transaction::where('user_id', $userId)
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        $labels = [];
        $data = [];
        
        $current = $startDate->copy();
        while ($current <= $endDate) {
            $dateStr = $current->format('Y-m-d');
            $labels[] = $current->format('d/m');
            $data[] = $transactions->where('date', $dateStr)->first()->total ?? 0;
            $current->addDay();
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    private function getTransactionTypes($userId, $startDate, $endDate)
    {
        $types = Transaction::where('user_id', $userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->get();
        
        $labels = [];
        $data = [];
        
        // Mapping des types vers leurs labels
        $typeLabels = [
            'subscription' => 'Abonnement',
            'donation' => 'Donation',
            'refund' => 'Remboursement'
        ];
        
        foreach ($types as $type) {
            $labels[] = $typeLabels[$type->type] ?? ucfirst($type->type);
            $data[] = $type->count;
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    private function getPaymentMethods($userId, $startDate, $endDate)
    {
        $methods = Transaction::where('user_id', $userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('payment_method, COUNT(*) as count')
            ->groupBy('payment_method')
            ->get();
        
        $labels = [];
        $data = [];
        
        // Mapping des méthodes de paiement vers leurs labels
        $methodLabels = [
            'stripe' => 'Stripe',
            'paypal' => 'PayPal'
        ];
        
        foreach ($methods as $method) {
            $labels[] = $methodLabels[$method->payment_method] ?? ucfirst($method->payment_method);
            $data[] = $method->count;
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    private function getMonthlyBreakdown($userId, $startDate, $endDate)
    {
        $months = Transaction::where('user_id', $userId)
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        $labels = [];
        $data = [];
        
        foreach ($months as $month) {
            $labels[] = Carbon::createFromFormat('Y-m', $month->month)->format('M Y');
            $data[] = $month->total;
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    private function generateInsights($userId, $stats, $charts)
    {
        $insights = [];
        
        // Insight sur le montant total
        if ($stats['total_amount'] > 0) {
            $insights[] = [
                'type' => 'success',
                'icon' => 'ti-trending-up',
                'title' => 'Dépenses actives',
                'description' => 'Vous avez dépensé €' . number_format($stats['total_amount'], 2) . ' au total.'
            ];
        }
        
        // Insight sur le taux de réussite
        if ($stats['success_rate'] > 80) {
            $insights[] = [
                'type' => 'success',
                'icon' => 'ti-check-circle',
                'title' => 'Excellent taux de réussite',
                'description' => 'Vos transactions ont un taux de réussite de ' . number_format($stats['success_rate'], 1) . '%.'
            ];
        } elseif ($stats['success_rate'] < 50) {
            $insights[] = [
                'type' => 'warning',
                'icon' => 'ti-alert-triangle',
                'title' => 'Taux de réussite faible',
                'description' => 'Votre taux de réussite est de ' . number_format($stats['success_rate'], 1) . '%. Vérifiez vos méthodes de paiement.'
            ];
        }
        
        // Insight sur les types de transactions
        if (isset($charts['types']['data']) && count($charts['types']['data']) > 0) {
            $maxTypeIndex = array_search(max($charts['types']['data']), $charts['types']['data']);
            $maxType = $charts['types']['labels'][$maxTypeIndex];
            
            $insights[] = [
                'type' => 'info',
                'icon' => 'ti-chart-pie',
                'title' => 'Type préféré',
                'description' => 'Vos transactions sont principalement des ' . strtolower($maxType) . '.'
            ];
        }
        
        return $insights;
    }

    public function export(Request $request)
    {
        $user = auth()->user();
        $search = $request->all();
        $format = $request->get('format', 'csv'); // csv or pdf
        
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
            ->when(isset($search['period']), function($query) use ($search) {
                switch($search['period']) {
                    case 'today':
                        $query->whereDate('created_at', Carbon::today());
                        break;
                    case 'week':
                        $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                        break;
                    case 'month':
                        $query->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                        break;
                    case 'year':
                        $query->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
                        break;
                }
            })
            ->when(isset($search['amount_range']), function($query) use ($search) {
                switch($search['amount_range']) {
                    case '0-10':
                        $query->whereBetween('amount', [0, 10]);
                        break;
                    case '10-50':
                        $query->whereBetween('amount', [10, 50]);
                        break;
                    case '50-100':
                        $query->whereBetween('amount', [50, 100]);
                        break;
                    case '100+':
                        $query->where('amount', '>', 100);
                        break;
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();

        if ($format === 'pdf') {
            return $this->exportPdf($transactions, $user);
        } else {
            return $this->exportCsv($transactions, $user);
        }
    }

    private function exportCsv($transactions, $user)
    {
        $filename = 'transactions_' . $user->id . '_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function() use ($transactions) {
            $handle = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV headers
            fputcsv($handle, [
                'ID',
                'Type',
                'Description',
                'Montant',
                'Statut',
                'Méthode de Paiement',
                'Date de Création',
                'Date de Traitement'
            ]);

            // CSV data
            foreach ($transactions as $transaction) {
                fputcsv($handle, [
                    $transaction->id,
                    $transaction->type_label ?? ucfirst($transaction->type),
                    $transaction->description,
                    '€' . number_format($transaction->amount, 2),
                    $transaction->status_label ?? ucfirst($transaction->status),
                    $transaction->payment_method_label ?? ucfirst($transaction->payment_method),
                    $transaction->created_at->format('d/m/Y H:i'),
                    $transaction->processed_at ? $transaction->processed_at->format('d/m/Y H:i') : 'Non traité'
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    private function exportPdf($transactions, $user)
    {
        $data = [
            'transactions' => $transactions,
            'user' => $user,
            'export_date' => now()->format('d/m/Y à H:i')
        ];

        $pdf = Pdf::loadView('site.transactions.export-pdf', $data);
        
        $filename = 'transactions_' . $user->id . '_' . date('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }
}
