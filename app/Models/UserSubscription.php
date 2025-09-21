<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class UserSubscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'membership_plan_id',
        'subscription_id',
        'status',
        'start_date',
        'end_date',
        'amount_paid',
        'currency',
        'payment_method',
        'payment_details',
        'cancelled_at',
        'renewed_at',
        'auto_renew' // Ajout pour compatibilité
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'amount_paid' => 'decimal:2',
        'payment_details' => 'array',
        'cancelled_at' => 'datetime',
        'renewed_at' => 'datetime',
        'auto_renew' => 'boolean' // Ajout pour compatibilité
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function membershipPlan()
    {
        return $this->belongsTo(MembershipPlan::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'related_id')
                    ->where('related_model', 'UserSubscription');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('end_date', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'active')
                    ->where('end_date', '<=', now());
    }

    // Accesseurs
    public function getIsActiveAttribute()
    {
        return $this->status === 'active' && $this->end_date > now();
    }

    public function getIsExpiredAttribute()
    {
        return $this->end_date <= now();
    }

    public function getDaysRemainingAttribute()
    {
        if ($this->isExpired) {
            return 0;
        }
        return $this->end_date->diffInDays(now());
    }

    public function getFormattedAmountAttribute()
    {
        return $this->currency . ' ' . number_format($this->amount_paid, 2);
    }

    // Méthodes
    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now()
        ]);
    }

    public function renew()
    {
        if ($this->membershipPlan) {
            $this->update([
                'start_date' => now(),
                'end_date' => now()->addDays($this->membershipPlan->duration_days),
                'status' => 'active',
                'renewed_at' => now()
            ]);
        }
    }

    public function isActive()
    {
        return $this->status === 'active' && $this->end_date > now();
    }

    public function isExpired()
    {
        return $this->end_date <= now();
    }

    
} 