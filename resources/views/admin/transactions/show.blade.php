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
                                    <h5 class="card-title text-primary">Détails de la Transaction #{{ $transaction->id }}</h5>
                                    <p class="mb-4">Informations complètes sur cette transaction</p>
                                </div>
                                <div>
                                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
                                        <i class="ti ti-arrow-left me-1"></i> Retour
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Informations principales -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Informations de la Transaction</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">ID Transaction</label>
                                <p class="form-control-static">{{ $transaction->id }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Type</label>
                                <p class="form-control-static">
                                    <span class="badge bg-label-primary">{{ $transaction->type_label }}</span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Montant</label>
                                <p class="form-control-static">
                                    <strong class="text-success fs-4">{{ $transaction->formatted_amount }}</strong>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Statut</label>
                                <p class="form-control-static">
                                    <span class="badge bg-label-{{ $transaction->status_badge }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Méthode de paiement</label>
                                <p class="form-control-static">
                                    <span class="badge bg-label-info">{{ $transaction->payment_method_label }}</span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">ID Transaction externe</label>
                                <p class="form-control-static">{{ $transaction->transaction_id ?: 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Date de création</label>
                                <p class="form-control-static">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Date de traitement</label>
                                <p class="form-control-static">
                                    {{ $transaction->processed_at ? $transaction->processed_at->format('d/m/Y H:i:s') : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <p class="form-control-static">{{ $transaction->description ?: 'Aucune description' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Métadonnées -->
            @if($transaction->metadata)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Métadonnées du Paiement</h5>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded">{{ json_encode($transaction->metadata, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
            @endif
        </div>

        <!-- Informations utilisateur et actions -->
        <div class="col-lg-4">
            <!-- Informations utilisateur -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Informations Utilisateur</h5>
                </div>
                <div class="card-body">
                    @if($transaction->user)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nom</label>
                            <p class="form-control-static">{{ $transaction->user->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <p class="form-control-static">{{ $transaction->user->email }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">ID Utilisateur</label>
                            <p class="form-control-static">{{ $transaction->user->id }}</p>
                        </div>
                        <div class="mb-3">
                            <a href="{{ route('admin.users.show', $transaction->user->id) }}" class="btn btn-primary btn-sm">
                                <i class="ti ti-user me-1"></i> Voir le profil
                            </a>
                        </div>
                    @else
                        <p class="text-muted">Transaction anonyme</p>
                    @endif
                </div>
            </div>

            <!-- Informations liées -->
            @if($transaction->subscription)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Abonnement Lié</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Plan</label>
                        <p class="form-control-static">{{ $transaction->subscription->membershipPlan->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Statut</label>
                        <p class="form-control-static">
                            <span class="badge bg-label-{{ $transaction->subscription->status === 'active' ? 'success' : 'warning' }}">
                                {{ ucfirst($transaction->subscription->status) }}
                            </span>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Date de fin</label>
                        <p class="form-control-static">{{ $transaction->subscription->end_date->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if($transaction->donation)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Donation Liée</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Donateur</label>
                        <p class="form-control-static">{{ $transaction->donation->display_name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <p class="form-control-static">{{ $transaction->donation->donor_email }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Anonyme</label>
                        <p class="form-control-static">
                            <span class="badge bg-label-{{ $transaction->donation->is_anonymous ? 'warning' : 'success' }}">
                                {{ $transaction->donation->is_anonymous ? 'Oui' : 'Non' }}
                            </span>
                        </p>
                    </div>
                    @if($transaction->donation->message)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Message</label>
                        <p class="form-control-static">{{ $transaction->donation->message }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Actions</h5>
                </div>
                <div class="card-body">
                    @if($transaction->isCompleted())
                        <div class="d-grid">
                            <a href="{{ route('admin.transactions.refund', $transaction->id) }}" 
                               class="btn btn-warning"
                               onclick="return confirm('Êtes-vous sûr de vouloir rembourser cette transaction ?')">
                                <i class="ti ti-refund me-1"></i> Rembourser
                            </a>
                        </div>
                    @elseif($transaction->isPending())
                        <div class="alert alert-warning">
                            <i class="ti ti-clock me-1"></i>
                            Cette transaction est en attente de traitement
                        </div>
                    @elseif($transaction->isFailed())
                        <div class="alert alert-danger">
                            <i class="ti ti-x me-1"></i>
                            Cette transaction a échoué
                        </div>
                    @elseif($transaction->isRefunded())
                        <div class="alert alert-info">
                            <i class="ti ti-refund me-1"></i>
                            Cette transaction a été remboursée le {{ $transaction->refunded_at->format('d/m/Y H:i') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 