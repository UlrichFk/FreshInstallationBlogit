<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'type', // 'subscription', 'donation', 'refund'
        'amount',
        'currency',
        'status', // 'pending', 'completed', 'failed', 'cancelled', 'refunded'
        'payment_method', // 'stripe', 'paypal'
        'transaction_id', // ID externe (Stripe, PayPal)
        'description',
        'metadata',
        'related_model', // 'UserSubscription', 'Donation'
        'related_id', // ID du modèle lié
        'processed_at',
        'refunded_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'processed_at' => 'datetime',
        'refunded_at' => 'datetime'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(UserSubscription::class, 'related_id')
                    ->where('related_model', 'UserSubscription');
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class, 'related_id')
                    ->where('related_model', 'Donation');
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeRefunded($query)
    {
        return $query->where('status', 'refunded');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByPaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    // Accesseurs
    public function getFormattedAmountAttribute()
    {
        return $this->currency . ' ' . number_format($this->amount, 2);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'completed' => 'success',
            'failed' => 'danger',
            'cancelled' => 'secondary',
            'refunded' => 'info'
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function getTypeLabelAttribute()
    {
        $labels = [
            'subscription' => 'Abonnement',
            'donation' => 'Donation',
            'refund' => 'Remboursement'
        ];

        return $labels[$this->type] ?? $this->type;
    }

    public function getPaymentMethodLabelAttribute()
    {
        $labels = [
            'stripe' => 'Stripe',
            'paypal' => 'PayPal'
        ];

        return $labels[$this->payment_method] ?? $this->payment_method;
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'En attente',
            'completed' => 'Complété',
            'failed' => 'Échoué',
            'cancelled' => 'Annulé',
            'refunded' => 'Remboursé'
        ];

        return $labels[$this->status] ?? $this->status;
    }

    // Méthodes
    public function markAsCompleted($transactionId = null, $metadata = null)
    {
        $this->update([
            'status' => 'completed',
            'transaction_id' => $transactionId,
            'metadata' => $metadata,
            'processed_at' => now()
        ]);
    }

    public function markAsFailed($metadata = null)
    {
        $this->update([
            'status' => 'failed',
            'metadata' => $metadata
        ]);
    }

    public function markAsRefunded($metadata = null)
    {
        $this->update([
            'status' => 'refunded',
            'metadata' => $metadata,
            'refunded_at' => now()
        ]);
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isFailed()
    {
        return $this->status === 'failed';
    }

    public function isRefunded()
    {
        return $this->status === 'refunded';
    }

    // Méthodes statiques
    public static function createFromSubscription($subscription)
    {
        return self::create([
            'user_id' => $subscription->user_id,
            'type' => 'subscription',
            'amount' => $subscription->amount_paid,
            'currency' => $subscription->currency,
            'status' => 'pending',
            'payment_method' => $subscription->payment_method,
            'transaction_id' => $subscription->subscription_id,
            'description' => 'Abonnement: ' . $subscription->membershipPlan->name,
            'metadata' => $subscription->payment_details,
            'related_model' => 'UserSubscription',
            'related_id' => $subscription->id
        ]);
    }

    public static function createFromDonation($donation)
    {
        return self::create([
            'user_id' => $donation->user_id,
            'type' => 'donation',
            'amount' => $donation->amount,
            'currency' => $donation->currency,
            'status' => 'pending',
            'payment_method' => $donation->payment_method,
            'transaction_id' => $donation->transaction_id,
            'description' => 'Donation: ' . $donation->donor_name,
            'metadata' => $donation->payment_details,
            'related_model' => 'Donation',
            'related_id' => $donation->id
        ]);
    }

    public static function getStats($userId = null, $dateRange = null)
    {
        $query = self::query();
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        if ($dateRange) {
            $query->whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
        }
        
        $totalTransactions = $query->count();
        $totalAmount = $query->sum('amount');
        $completedTransactions = $query->where('status', 'completed')->count();
        $pendingTransactions = $query->where('status', 'pending')->count();
        
        $subscriptionsCount = $query->where('type', 'subscription')->count();
        $donationsCount = $query->where('type', 'donation')->count();
        $thisMonthTransactions = self::query()
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->count();
        $thisWeekTransactions = self::query()
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        return [
            'total_transactions' => $totalTransactions,
            'total_amount' => $totalAmount,
            'completed_transactions' => $completedTransactions,
            'pending_transactions' => $pendingTransactions,
            'subscriptions_count' => $subscriptionsCount,
            'donations_count' => $donationsCount,
            'this_month_transactions' => $thisMonthTransactions,
            'this_week_transactions' => $thisWeekTransactions,
            'average_amount' => $totalTransactions > 0 ? $totalAmount / $totalTransactions : 0,
            'success_rate' => $totalTransactions > 0 ? ($completedTransactions / $totalTransactions) * 100 : 0
        ];
    }
}
