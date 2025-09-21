@extends('admin/layout/app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-12">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Configuration des Moyens de Paiement</h5>
                            <p class="mb-4">Gérez vos gateways de paiement et configurez les paramètres de chaque service.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($gateways as $gateway)
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        @if($gateway->logo_path)
                            <img src="{{ $gateway->getLogoUrl() }}" alt="{{ $gateway->display_name }}" class="me-3" style="width: 40px; height: 40px; object-fit: contain;">
                        @else
                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="ti ti-credit-card text-muted"></i>
                            </div>
                        @endif
                        <div>
                            <h6 class="mb-0">{{ strtoupper($gateway->display_name) }}</h6>
                            <small class="text-muted">{{ $gateway->description }}</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="form-check form-switch me-3">
                            <input class="form-check-input" type="checkbox" 
                                   {{ $gateway->is_enabled ? 'checked' : '' }}
                                   onchange="toggleGatewayStatus({{ $gateway->id }}, this.checked)">
                            <label class="form-check-label" for="gateway-{{ $gateway->id }}">
                                {{ $gateway->is_enabled ? 'ON' : 'OFF' }}
                            </label>
                        </div>
                        @if($gateway->is_default)
                            <span class="badge bg-success">Par défaut</span>
                        @endif
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">Environnement</small>
                            <p class="mb-0">
                                <span class="badge bg-{{ $gateway->environment === 'live' ? 'success' : 'warning' }}">
                                    {{ ucfirst($gateway->environment) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Devise</small>
                            <p class="mb-0">{{ $gateway->currency }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Configuration</small>
                        <div class="mt-1">
                            @if($gateway->isConfigured())
                                <span class="badge bg-success">
                                    <i class="ti ti-check me-1"></i> Configuré
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="ti ti-x me-1"></i> Non configuré
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.payment-gateways.configure', $gateway->id) }}" 
                           class="btn btn-primary btn-sm">
                            <i class="ti ti-settings me-1"></i> Configurer
                        </a>
                        
                        @if($gateway->isConfigured())
                            <button type="button" class="btn btn-outline-info btn-sm" 
                                    onclick="testConnection('{{ $gateway->name }}')">
                                <i class="ti ti-check me-1"></i> Tester
                            </button>
                        @endif
                        
                        @if(!$gateway->is_default)
                            <button type="button" class="btn btn-outline-success btn-sm" 
                                    onclick="setDefault({{ $gateway->id }})">
                                <i class="ti ti-star me-1"></i> Définir par défaut
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
function toggleGatewayStatus(gatewayId, isEnabled) {
    fetch(`/admin/payment-gateways/${gatewayId}/toggle-status`, {
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

function setDefault(gatewayId) {
    Swal.fire({
        title: 'Êtes-vous sûr?',
        text: "Ce gateway sera défini comme moyen de paiement par défaut.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, définir par défaut',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/payment-gateways/${gatewayId}/set-default`, {
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