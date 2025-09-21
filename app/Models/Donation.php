<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'donor_name',
        'donor_email',
        'message',
        'amount',
        'currency',
        'status',
        'payment_method',
        'transaction_id',
        'is_anonymous',
        'is_recurring',
        'recurring_interval',
        'payment_details'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_anonymous' => 'boolean',
        'is_recurring' => 'boolean',
        'payment_details' => 'array'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'related_id')
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

    public function scopeRecurring($query)
    {
        return $query->where('is_recurring', true);
    }

    // Accesseurs
    public function getFormattedAmountAttribute()
    {
        return $this->currency . ' ' . number_format($this->amount, 2);
    }

    public function getDisplayNameAttribute()
    {
        if ($this->is_anonymous) {
            return 'Donateur anonyme';
        }
        return $this->donor_name;
    }

    // Méthodes
    public function markAsCompleted($transactionId = null, $paymentDetails = null)
    {
        $this->update([
            'status' => 'completed',
            'transaction_id' => $transactionId,
            'payment_details' => $paymentDetails,
            'updated_at' => now()
        ]);
    }

    public function markAsFailed($paymentDetails = null)
    {
        $this->update([
            'status' => 'failed',
            'payment_details' => $paymentDetails,
            'updated_at' => now()
        ]);
    }
} 