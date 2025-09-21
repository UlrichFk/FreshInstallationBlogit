<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembershipPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'currency',
        'billing_cycle',
        'duration_days',
        'is_featured',
        'stripe_price_id',
        'paypal_plan_id',
        'features',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'features' => 'array',
        'status' => 'boolean'
    ];

    // Relations
    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'required_plan_id');
    }

    public function activeSubscriptions()
    {
        return $this->subscriptions()->where('status', 'active');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('price', 'asc');
    }

    // Accesseurs
    public function getFormattedPriceAttribute()
    {
        return $this->currency . ' ' . number_format($this->price, 2);
    }

    public function getDurationTextAttribute()
    {
        if ($this->duration_days == 30) {
            return 'Mensuel';
        } elseif ($this->duration_days == 365) {
            return 'Annuel';
        } else {
            return $this->duration_days . ' jours';
        }
    }

    public function getMonthlyPriceAttribute()
    {
        if ($this->duration_days == 30) {
            return $this->price;
        } elseif ($this->duration_days == 365) {
            return round($this->price / 12, 2);
        } else {
            return round($this->price / ($this->duration_days / 30), 2);
        }
    }

    public function getSavingsPercentageAttribute()
    {
        if ($this->duration_days == 365) {
            $monthlyPrice = $this->price / 12;
            $regularMonthlyPrice = $this->price;
            return round((($regularMonthlyPrice - $monthlyPrice) / $regularMonthlyPrice) * 100);
        }
        return 0;
    }

    /**
     * Méthode de compatibilité pour l'admin
     */
    public static function getLists($search)
    {
        try {
            $obj = new self;
            $pagination = (isset($search['perpage'])) ? $search['perpage'] : config('constant.pagination');
            
            if (isset($search['search']) && !empty($search['search'])) {
                $keyword = $search['search'];
                $obj = $obj->where(function($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%')
                      ->orWhere('description', 'like', '%' . $keyword . '%');
                });
            }
            
            if (isset($search['billing_cycle']) && $search['billing_cycle'] != '') {
                $obj = $obj->where('billing_cycle', $search['billing_cycle']);
            }
            
            if (isset($search['status']) && $search['status'] != '') {
                $obj = $obj->where('status', $search['status']);
            }

            $data = $obj->ordered()->paginate($pagination)->appends('perpage', $pagination);
            return $data;
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
        }
    }
} 