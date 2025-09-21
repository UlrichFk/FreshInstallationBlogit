<form method="POST" action="{{url('admin/update-setting')}}" enctype="multipart/form-data">
    <input type="hidden" name="page_name" value="payment-setting">
    @csrf
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ti ti-credit-card me-2"></i>Configuration des Moyens de Paiement
                    </h5>
                    <p class="text-muted mb-0">Configurez Stripe et PayPal pour accepter les paiements d'abonnements et de donations</p>
                </div>
                <div class="card-body">
                    
                    <!-- Configuration Générale -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="ti ti-settings me-1"></i>Configuration Générale
                            </h6>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Devise Principale</label>
                            <select class="form-select" name="payment_currency">
                                <option value="USD" {{ \Helpers::getPaymentSetting('payment_currency', 'USD') == 'USD' ? 'selected' : '' }}>USD - Dollar américain</option>
                                <option value="EUR" {{ \Helpers::getPaymentSetting('payment_currency') == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                <option value="GBP" {{ \Helpers::getPaymentSetting('payment_currency') == 'GBP' ? 'selected' : '' }}>GBP - Livre sterling</option>
                                <option value="CAD" {{ \Helpers::getPaymentSetting('payment_currency') == 'CAD' ? 'selected' : '' }}>CAD - Dollar canadien</option>
                                <option value="AUD" {{ \Helpers::getPaymentSetting('payment_currency') == 'AUD' ? 'selected' : '' }}>AUD - Dollar australien</option>
                            </select>
                            <small class="text-muted">Devise utilisée pour tous les paiements</small>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Mode Test</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="payment_test_mode" value="1" 
                                       {{ \Helpers::isPaymentTestMode() ? 'checked' : '' }}>
                                <label class="form-check-label">Activer le mode test</label>
                            </div>
                            <small class="text-muted">Utilisez le mode test pendant le développement</small>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Méthodes de Paiement Actives</label>
                            <div class="d-flex gap-3">
                                <span class="badge {{ \Helpers::isStripeEnabled() ? 'bg-success' : 'bg-secondary' }}">
                                    <i class="ti ti-brand-stripe me-1"></i>Stripe
                                </span>
                                <span class="badge {{ \Helpers::isPayPalEnabled() ? 'bg-success' : 'bg-secondary' }}">
                                    <i class="ti ti-brand-paypal me-1"></i>PayPal
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Configuration Stripe -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="ti ti-brand-stripe me-1"></i>Configuration Stripe
                                <small class="text-muted ms-2">- Paiements par carte bancaire</small>
                            </h6>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Activer Stripe</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="stripe_enabled" value="1" 
                                       {{ \Helpers::isStripeEnabled() ? 'checked' : '' }}>
                                <label class="form-check-label">Activer les paiements Stripe</label>
                            </div>
                            <small class="text-muted">Permet les paiements par carte bancaire via Stripe</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Devise Stripe</label>
                            <select class="form-select" name="stripe_currency">
                                <option value="USD" {{ \Helpers::getPaymentSetting('stripe_currency', 'USD') == 'USD' ? 'selected' : '' }}>USD</option>
                                <option value="EUR" {{ \Helpers::getPaymentSetting('stripe_currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                <option value="GBP" {{ \Helpers::getPaymentSetting('stripe_currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                                <option value="CAD" {{ \Helpers::getPaymentSetting('stripe_currency') == 'CAD' ? 'selected' : '' }}>CAD</option>
                                <option value="AUD" {{ \Helpers::getPaymentSetting('stripe_currency') == 'AUD' ? 'selected' : '' }}>AUD</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Clé Publique Stripe <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="stripe_key" 
                                   value="{{ \Helpers::getPaymentSetting('stripe_key') }}" 
                                   placeholder="pk_test_... ou pk_live_...">
                            <small class="text-muted">Commence par pk_test_ (test) ou pk_live_ (production)</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Clé Secrète Stripe <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="stripe_secret" 
                                   value="{{ \Helpers::getPaymentSetting('stripe_secret') ? '••••••••••••••••' : '' }}" 
                                   placeholder="sk_test_... ou sk_live_...">
                            <small class="text-muted">Commence par sk_test_ (test) ou sk_live_ (production)</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Secret Webhook Stripe</label>
                            <input type="password" class="form-control" name="stripe_webhook_secret" 
                                   value="{{ \Helpers::getPaymentSetting('stripe_webhook_secret') ? '••••••••••••••••' : '' }}" 
                                   placeholder="whsec_...">
                            <small class="text-muted">Pour vérifier les webhooks Stripe (optionnel)</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">URL Webhook Stripe</label>
                            <div class="input-group">
                                <input type="text" class="form-control" readonly 
                                       value="{{ url('/webhooks/stripe') }}">
                                <button type="button" class="btn btn-outline-secondary" onclick="copyToClipboard('{{ url('/webhooks/stripe') }}')">
                                    <i class="ti ti-copy"></i>
                                </button>
                            </div>
                            <small class="text-muted">URL à configurer dans votre dashboard Stripe</small>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <button type="button" class="btn btn-outline-primary" onclick="testStripeConnection()">
                                <i class="ti ti-test-pipe me-1"></i>Tester la Connexion Stripe
                            </button>
                            <div id="stripe-test-result" class="mt-2"></div>
                        </div>
                        
                        <div class="col-12">
                            <div class="alert alert-info">
                                <h6><i class="ti ti-info-circle me-1"></i>Configuration Stripe :</h6>
                                <ol class="mb-0">
                                    <li>Créez un compte sur <a href="https://stripe.com" target="_blank">stripe.com</a></li>
                                    <li>Récupérez vos clés API dans <strong>Developers > API keys</strong></li>
                                    <li>Configurez un webhook sur <strong>{{ url('/webhooks/stripe') }}</strong></li>
                                    <li>Événements à écouter : <code>payment_intent.succeeded</code>, <code>invoice.payment_succeeded</code>, <code>customer.subscription.updated</code></li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Configuration PayPal -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="ti ti-brand-paypal me-1"></i>Configuration PayPal
                                <small class="text-muted ms-2">- Paiements via compte PayPal</small>
                            </h6>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Activer PayPal</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="paypal_enabled" value="1" 
                                       {{ \Helpers::isPayPalEnabled() ? 'checked' : '' }}>
                                <label class="form-check-label">Activer les paiements PayPal</label>
                            </div>
                            <small class="text-muted">Permet les paiements via compte PayPal</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mode PayPal</label>
                            <select class="form-select" name="paypal_mode">
                                <option value="sandbox" {{ \Helpers::getPaymentSetting('paypal_mode', 'sandbox') == 'sandbox' ? 'selected' : '' }}>
                                    Sandbox (Test)
                                </option>
                                <option value="live" {{ \Helpers::getPaymentSetting('paypal_mode') == 'live' ? 'selected' : '' }}>
                                    Live (Production)
                                </option>
                            </select>
                            <small class="text-muted">Utilisez Sandbox pour les tests</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Client ID PayPal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="paypal_client_id" 
                                   value="{{ \Helpers::getPaymentSetting('paypal_client_id') }}" 
                                   placeholder="Votre Client ID PayPal">
                            <small class="text-muted">Client ID de votre application PayPal</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Secret PayPal <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="paypal_secret" 
                                   value="{{ \Helpers::getPaymentSetting('paypal_secret') ? '••••••••••••••••' : '' }}" 
                                   placeholder="Votre Secret PayPal">
                            <small class="text-muted">Secret de votre application PayPal</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Devise PayPal</label>
                            <select class="form-select" name="paypal_currency">
                                <option value="USD" {{ \Helpers::getPaymentSetting('paypal_currency', 'USD') == 'USD' ? 'selected' : '' }}>USD</option>
                                <option value="EUR" {{ \Helpers::getPaymentSetting('paypal_currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                <option value="GBP" {{ \Helpers::getPaymentSetting('paypal_currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                                <option value="CAD" {{ \Helpers::getPaymentSetting('paypal_currency') == 'CAD' ? 'selected' : '' }}>CAD</option>
                                <option value="AUD" {{ \Helpers::getPaymentSetting('paypal_currency') == 'AUD' ? 'selected' : '' }}>AUD</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">URL Webhook PayPal</label>
                            <div class="input-group">
                                <input type="text" class="form-control" readonly 
                                       value="{{ url('/webhooks/paypal') }}">
                                <button type="button" class="btn btn-outline-secondary" onclick="copyToClipboard('{{ url('/webhooks/paypal') }}')">
                                    <i class="ti ti-copy"></i>
                                </button>
                            </div>
                            <small class="text-muted">URL à configurer dans votre dashboard PayPal</small>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <button type="button" class="btn btn-outline-primary" onclick="testPayPalConnection()">
                                <i class="ti ti-test-pipe me-1"></i>Tester la Connexion PayPal
                            </button>
                            <div id="paypal-test-result" class="mt-2"></div>
                        </div>
                        
                        <div class="col-12">
                            <div class="alert alert-info">
                                <h6><i class="ti ti-info-circle me-1"></i>Configuration PayPal :</h6>
                                <ol class="mb-0">
                                    <li>Créez un compte sur <a href="https://developer.paypal.com" target="_blank">developer.paypal.com</a></li>
                                    <li>Créez une application dans <strong>My Apps & Credentials</strong></li>
                                    <li>Récupérez le Client ID et Secret</li>
                                    <li>Configurez un webhook sur <strong>{{ url('/webhooks/paypal') }}</strong></li>
                                    <li>Événements à écouter : <code>PAYMENT.CAPTURE.COMPLETED</code>, <code>BILLING.SUBSCRIPTION.ACTIVATED</code></li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- URLs de Redirection -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="ti ti-link me-1"></i>URLs de Redirection
                            </h6>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">URL de Succès</label>
                            <input type="url" class="form-control" name="payment_success_url" 
                                   value="{{ \Helpers::getPaymentSetting('payment_success_url', url('/payment/success')) }}" 
                                   placeholder="https://votre-site.com/payment/success">
                            <small class="text-muted">Page affichée après un paiement réussi</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">URL d'Annulation</label>
                            <input type="url" class="form-control" name="payment_cancel_url" 
                                   value="{{ \Helpers::getPaymentSetting('payment_cancel_url', url('/payment/cancel')) }}" 
                                   placeholder="https://votre-site.com/payment/cancel">
                            <small class="text-muted">Page affichée après annulation d'un paiement</small>
                        </div>
                    </div>

                    <!-- Dépendances -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="ti ti-package me-1"></i>Dépendances Requises
                            </h6>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6>SDK Stripe</h6>
                                    <code>composer require stripe/stripe-php</code>
                                    <div class="mt-2">
                                        <span class="badge {{ class_exists('Stripe\Stripe') ? 'bg-success' : 'bg-danger' }}">
                                            {{ class_exists('Stripe\Stripe') ? 'Installé' : 'Non installé' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6>SDK PayPal</h6>
                                    <code>composer require paypal/rest-api-sdk-php</code>
                                    <div class="mt-2">
                                        <span class="badge {{ class_exists('PayPalCheckoutSdk\Core\PayPalHttpClient') ? 'bg-success' : 'bg-danger' }}">
                                            {{ class_exists('PayPalCheckoutSdk\Core\PayPalHttpClient') ? 'Installé' : 'Non installé' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="row">
                        <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                            <button type="submit" class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1">
                                <i class="ti ti-device-floppy me-1"></i>Sauvegarder les Modifications
                            </button>
                            <a href="{{ url('admin/dashboard') }}" class="btn btn-outline-secondary">
                                <i class="ti ti-arrow-left me-1"></i>Retour au Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Vous pouvez ajouter une notification ici
        console.log('URL copiée dans le presse-papiers');
    });
}

function testStripeConnection() {
    const resultDiv = document.getElementById('stripe-test-result');
    resultDiv.innerHTML = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>Test en cours...';
    
    fetch('{{ url("admin/test-stripe-connection") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            stripe_key: document.querySelector('input[name="stripe_key"]').value,
            stripe_secret: document.querySelector('input[name="stripe_secret"]').value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.innerHTML = '<div class="alert alert-success py-2 mb-0"><i class="ti ti-check me-1"></i>' + data.message + '</div>';
        } else {
            resultDiv.innerHTML = '<div class="alert alert-danger py-2 mb-0"><i class="ti ti-x me-1"></i>' + data.message + '</div>';
        }
    })
    .catch(error => {
        resultDiv.innerHTML = '<div class="alert alert-danger py-2 mb-0"><i class="ti ti-x me-1"></i>Erreur de connexion</div>';
    });
}

function testPayPalConnection() {
    const resultDiv = document.getElementById('paypal-test-result');
    resultDiv.innerHTML = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>Test en cours...';
    
    fetch('{{ url("admin/test-paypal-connection") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            paypal_client_id: document.querySelector('input[name="paypal_client_id"]').value,
            paypal_secret: document.querySelector('input[name="paypal_secret"]').value,
            paypal_mode: document.querySelector('select[name="paypal_mode"]').value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.innerHTML = '<div class="alert alert-success py-2 mb-0"><i class="ti ti-check me-1"></i>' + data.message + '</div>';
        } else {
            resultDiv.innerHTML = '<div class="alert alert-danger py-2 mb-0"><i class="ti ti-x me-1"></i>' + data.message + '</div>';
        }
    })
    .catch(error => {
        resultDiv.innerHTML = '<div class="alert alert-danger py-2 mb-0"><i class="ti ti-x me-1"></i>Erreur de connexion</div>';
    });
}
</script> 