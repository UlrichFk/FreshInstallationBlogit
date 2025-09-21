<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionAPIController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth:api');
    }

    public function getUserTransactions(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => false,
                'message' => 'Utilisateur non authentifié'
            ], 401);
        }

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

        return response()->json([
            'status' => true,
            'data' => $transactions
        ]);
    }

    public function getTransactionDetails(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => false,
                'message' => 'Utilisateur non authentifié'
            ], 401);
        }

        $user = auth()->user();
        $transaction = Transaction::with(['subscription.membershipPlan', 'donation'])
            ->where('user_id', $user->id)
            ->find($id);

        if (!$transaction) {
            return response()->json([
                'status' => false,
                'message' => 'Transaction non trouvée'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $transaction
        ]);
    }

    public function getUserTransactionStats(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => false,
                'message' => 'Utilisateur non authentifié'
            ], 401);
        }

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

        return response()->json([
            'status' => true,
            'data' => $stats
        ]);
    }

    public function getRecentTransactions(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => false,
                'message' => 'Utilisateur non authentifié'
            ], 401);
        }

        $user = auth()->user();
        $limit = $request->get('limit', 5);

        $transactions = Transaction::with(['subscription.membershipPlan', 'donation'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $transactions
        ]);
    }
} 