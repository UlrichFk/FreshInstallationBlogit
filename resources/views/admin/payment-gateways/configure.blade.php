@extends('admin/layout/app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-12">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title text-primary">Configuration {{ strtoupper($gateway->display_name) }}</h5>
                                    <p class="mb-4">{{ $gateway->description }}</p>
                                </div>
                                <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-outline-secondary">
                                    <i class="ti ti-arrow-left me-1"></i> Retour
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">{{ strtoupper($gateway->display_name) }}</h6>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_enabled" name="is_enabled" 
                                   {{ $gateway->is_enabled ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_enabled">
                                {{ $gateway->is_enabled ? 'ON' : 'OFF' }}
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.payment-gateways.update', $gateway->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Logo Section -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                @if($gateway->logo_path)
                                    <img src="{{ $gateway->getLogoUrl() }}" alt="{{ $gateway->display_name }}" 
                                         class="img-fluid rounded" style="max-width: 200px;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 200px; height: 120px;">
                                        <i class="ti ti-credit-card text-muted" style="font-size: 3rem;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Choisir Logo</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="logo" accept="image/*">
                                    <button class="btn btn-outline-secondary" type="button" onclick="document.querySelector('input[name=logo]').click()">
                                        Choisir Fichier
                                    </button>
                                </div>
                                <small class="form-text text-muted">Format: JPG, PNG, GIF, SVG. Taille max: 2MB</small>
                                @if($gateway->logo_path)
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="removeLogo({{ $gateway->id }})">
                                            <i class="ti ti-trash me-1"></i> Supprimer le logo
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Environment -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Environnement *</label>
                                <select class="form-select" name="environment" required>
                                    @foreach($environments as $key => $label)
                                        <option value="{{ $key }}" {{ $gateway->environment === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Utilisez Sandbox pour les tests, Live pour la production</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Devise *</label>
                                <select class="form-select" name="currency" required>
                                    @foreach($currencies as $key => $label)
                                        <option value="{{ $key }}" {{ $gateway->currency === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- API Configuration -->
                        @if($gateway->name === 'stripe')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Clé Publique *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control {{ $gateway->published_key ? 'is-valid' : 'is-invalid' }}" 
                                               name="published_key" 
                                               placeholder="pk_test_..." 
                                               value="{{ $gateway->published_key }}">
                                        <span class="input-group-text">
                                            @if($gateway->published_key)
                                                <i class="ti ti-check text-success"></i>
                                            @else
                                                <i class="ti ti-x text-danger"></i>
                                            @endif
                                        </span>
                                    </div>
                                    <small class="form-text text-muted">Clé publique Stripe (commence par pk_test_ ou pk_live_)</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Clé Secrète *</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control {{ $gateway->secret_key ? 'is-valid' : 'is-invalid' }}" 
                                               name="secret_key" 
                                               placeholder="sk_test_..." 
                                               value="{{ $gateway->secret_key }}">
                                        <span class="input-group-text">
                                            @if($gateway->secret_key)
                                                <i class="ti ti-check text-success"></i>
                                            @else
                                                <i class="ti ti-x text-danger"></i>
                                            @endif
                                        </span>
                                    </div>
                                    <small class="form-text text-muted">Clé secrète Stripe (commence par sk_test_ ou sk_live_)</small>
                                </div>
                            </div>
                        @elseif($gateway->name === 'paypal')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Client ID *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control {{ $gateway->api_key ? 'is-valid' : 'is-invalid' }}" 
                                               name="api_key" 
                                               placeholder="Client ID PayPal" 
                                               value="{{ $gateway->api_key }}">
                                        <span class="input-group-text">
                                            @if($gateway->api_key)
                                                <i class="ti ti-check text-success"></i>
                                            @else
                                                <i class="ti ti-x text-danger"></i>
                                            @endif
                                        </span>
                                    </div>
                                    <small class="form-text text-muted">Client ID de votre application PayPal</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Client Secret *</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control {{ $gateway->secret_key ? 'is-valid' : 'is-invalid' }}" 
                                               name="secret_key" 
                                               placeholder="Client Secret PayPal" 
                                               value="{{ $gateway->secret_key }}">
                                        <span class="input-group-text">
                                            @if($gateway->secret_key)
                                                <i class="ti ti-check text-success"></i>
                                            @else
                                                <i class="ti ti-x text-danger"></i>
                                            @endif
                                        </span>
                                    </div>
                                    <small class="form-text text-muted">Secret de votre application PayPal</small>
                                </div>
                            </div>
                        @endif

                        <!-- Webhook Configuration -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Secret Webhook</label>
                                <input type="password" class="form-control" name="webhook_secret" 
                                       placeholder="Secret du webhook" 
                                       value="{{ $gateway->webhook_secret }}">
                                <small class="form-text text-muted">Secret du webhook (optionnel)</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">URL Webhook</label>
                                <input type="url" class="form-control" name="webhook_url" 
                                       value="{{ $gateway->webhook_url }}" readonly>
                                <small class="form-text text-muted">URL du webhook (configurée automatiquement)</small>
                            </div>
                        </div>

                        <!-- Gateway Title -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Titre du Gateway de Paiement</label>
                                <input type="text" class="form-control" name="gateway_title" 
                                       placeholder="{{ $gateway->display_name }}" 
                                       value="{{ $gateway->gateway_title }}">
                                <small class="form-text text-muted">Titre personnalisé pour ce moyen de paiement</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ordre de Tri</label>
                                <input type="number" class="form-control" name="sort_order" 
                                       value="{{ $gateway->sort_order }}" min="0">
                                <small class="form-text text-muted">Ordre d'affichage (0 = premier)</small>
                            </div>
                        </div>

                        <!-- Description and Instructions -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3">{{ $gateway->description }}</textarea>
                                <small class="form-text text-muted">Description du moyen de paiement</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Instructions</label>
                                <textarea class="form-control" name="instructions" rows="3">{{ $gateway->instructions }}</textarea>
                                <small class="form-text text-muted">Instructions pour la configuration</small>
                            </div>
                        </div>

                        <!-- Default Gateway -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_default" 
                                           id="is_default" {{ $gateway->is_default ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_default">
                                        Définir comme gateway par défaut
                                    </label>
                                </div>
                                <small class="form-text text-muted">Ce gateway sera utilisé par défaut pour les paiements</small>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="row">
                            <div class="col-12 d-flex justify-content-between">
                                <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-outline-secondary">
                                    <i class="ti ti-arrow-left me-1"></i> Annuler
                                </a>
                                <div class="d-flex gap-2">
                                    @if($gateway->isConfigured())
                                        <button type="button" class="btn btn-outline-info" onclick="testConnection('{{ $gateway->name }}')">
                                            <i class="ti ti-check me-1"></i> Tester la Connexion
                                        </button>
                                    @endif
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti ti-device-floppy me-1"></i> Enregistrer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar with Help -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Aide et Informations</h6>
                </div>
                <div class="card-body">
                    @if($gateway->name === 'stripe')
                        <h6>Configuration Stripe</h6>
                        <ul class="list-unstyled">
                            <li><i class="ti ti-info-circle text-info me-1"></i> Créez un compte sur <a href="https://stripe.com" target="_blank">stripe.com</a></li>
                            <li><i class="ti ti-info-circle text-info me-1"></i> Récupérez vos clés API dans le dashboard</li>
                            <li><i class="ti ti-info-circle text-info me-1"></i> Utilisez les clés de test pour le développement</li>
                            <li><i class="ti ti-info-circle text-info me-1"></i> Configurez les webhooks pour les notifications</li>
                        </ul>
                    @elseif($gateway->name === 'paypal')
                        <h6>Configuration PayPal</h6>
                        <ul class="list-unstyled">
                            <li><i class="ti ti-info-circle text-info me-1"></i> Créez une application sur <a href="https://developer.paypal.com" target="_blank">developer.paypal.com</a></li>
                            <li><i class="ti ti-info-circle text-info me-1"></i> Récupérez votre Client ID et Secret</li>
                            <li><i class="ti ti-info-circle text-info me-1"></i> Utilisez l'environnement Sandbox pour les tests</li>
                            <li><i class="ti ti-info-circle text-info me-1"></i> Configurez les webhooks pour les notifications</li>
                        </ul>
                    @endif

                    <hr>

                    <h6>Informations importantes</h6>
                    <div class="alert alert-warning">
                        <ul class="mb-0">
                            <li>Ne partagez jamais vos clés secrètes</li>
                            <li>Utilisez toujours HTTPS en production</li>
                            <li>Testez d'abord en mode Sandbox</li>
                            <li>Configurez les webhooks pour la sécurité</li>
                        </ul>
                    </div>

                    <div class="alert alert-info">
                        <strong>URL Webhook:</strong><br>
                        <code>{{ $gateway->webhook_url }}</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function testConnection(gatewayName) {
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.innerHTML = '<i class="ti ti-loader ti-spin me-1"></i> Test en cours...';
    button.disabled = true;
    
    const url = gatewayName === 'stripe' 
        ? '/admin/payment-gateways/test-stripe-connection'
        : '/admin/payment-gateways/test-paypal-connection';
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Succès!',
                text: data.message,
                confirmButtonText: 'OK'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Erreur!',
                text: data.error,
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Erreur!',
            text: 'Erreur de connexion: ' + error.message,
            confirmButtonText: 'OK'
        });
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

function removeLogo(gatewayId) {
    Swal.fire({
        title: 'Êtes-vous sûr?',
        text: "Le logo sera supprimé définitivement.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/payment-gateways/${gatewayId}/remove-logo`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès!',
                        text: data.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur!',
                        text: data.error,
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur!',
                    text: 'Erreur de connexion: ' + error.message,
                    confirmButtonText: 'OK'
                });
            });
        }
    });
}
</script>
@endsection 