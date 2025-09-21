<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class PaymentGateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'is_enabled',
        'environment', // 'live', 'sandbox', 'test'
        'api_key',
        'secret_key',
        'published_key',
        'webhook_secret',
        'webhook_url',
        'logo_path',
        'gateway_title',
        'currency',
        'description',
        'instructions',
        'sort_order',
        'is_default'
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'is_default' => 'boolean',
        'sort_order' => 'integer'
    ];

    protected $hidden = [
        'api_key',
        'secret_key',
        'webhook_secret'
    ];

    /**
     * Scope pour les gateways actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_enabled', true);
    }

    /**
     * Scope pour les gateways par environnement
     */
    public function scopeEnvironment($query, $environment)
    {
        return $query->where('environment', $environment);
    }

    /**
     * Obtenir le gateway par défaut
     */
    public static function getDefault()
    {
        return self::where('is_default', true)->where('is_enabled', true)->first();
    }

    /**
     * Obtenir tous les gateways actifs
     */
    public static function getActiveGateways()
    {
        return self::active()->orderBy('sort_order')->get();
    }

    /**
     * Obtenir les configurations par nom
     */
    public static function getByName($name)
    {
        return self::where('name', $name)->where('is_enabled', true)->first();
    }

    /**
     * Vérifier si un gateway est configuré
     */
    public function isConfigured()
    {
        switch ($this->name) {
            case 'stripe':
                return !empty($this->api_key) && !empty($this->secret_key);
            case 'paypal':
                return !empty($this->api_key) && !empty($this->secret_key);
            default:
                return !empty($this->api_key);
        }
    }

    /**
     * Obtenir l'URL du logo
     */
    public function getLogoUrl()
    {
        if ($this->logo_path) {
            return Storage::disk('public')->url('payment-gateways/' . $this->logo_path);
        }
        return null;
    }

    /**
     * Obtenir les configurations masquées pour l'affichage
     */
    public function getMaskedConfig()
    {
        $config = $this->toArray();
        
        // Masquer les clés sensibles
        if ($this->api_key) {
            $config['api_key'] = $this->maskApiKey($this->api_key);
        }
        if ($this->secret_key) {
            $config['secret_key'] = $this->maskApiKey($this->secret_key);
        }
        if ($this->published_key) {
            $config['published_key'] = $this->maskApiKey($this->published_key);
        }
        if ($this->webhook_secret) {
            $config['webhook_secret'] = $this->maskApiKey($this->webhook_secret);
        }
        
        return $config;
    }

    /**
     * Masquer une clé API pour l'affichage
     */
    private function maskApiKey($key)
    {
        if (strlen($key) <= 8) {
            return str_repeat('*', strlen($key));
        }
        
        return substr($key, 0, 4) . str_repeat('*', strlen($key) - 8) . substr($key, -4);
    }

    /**
     * Obtenir les environnements disponibles
     */
    public static function getEnvironments()
    {
        return config('payment.environments', [
            'sandbox' => 'Sandbox (Test)',
            'live' => 'Live (Production)',
            'test' => 'Test'
        ]);
    }

    /**
     * Obtenir les devises disponibles
     */
    public static function getCurrencies()
    {
        return config('payment.currencies', [
            'USD' => 'USD - Dollar américain',
            'EUR' => 'EUR - Euro',
            'GBP' => 'GBP - Livre sterling',
            'CAD' => 'CAD - Dollar canadien',
            'AUD' => 'AUD - Dollar australien',
            'JPY' => 'JPY - Yen japonais',
            'CHF' => 'CHF - Franc suisse',
            'SEK' => 'SEK - Couronne suédoise',
            'NOK' => 'NOK - Couronne norvégienne',
            'DKK' => 'DKK - Couronne danoise'
        ]);
    }

    /**
     * Boot du modèle
     */
    protected static function boot()
    {
        parent::boot();

        // Quand un gateway est défini comme défaut, désactiver les autres
        static::saving(function ($gateway) {
            if ($gateway->is_default) {
                static::where('id', '!=', $gateway->id)
                      ->update(['is_default' => false]);
            }
        });
    }
} 