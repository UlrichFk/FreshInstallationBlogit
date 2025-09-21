@extends('site/layout/site-app')

@section('title', __('lang.site_transaction_details'))

@section('content')

<style>
.transaction-detail-page {
    margin-top: 100px;
    padding: 2rem 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.03) 0%, rgba(83, 52, 131, 0.03) 100%);
    min-height: 100vh;
}

/* Hero Section */
.transaction-hero {
    background: var(--gradient-hero);
    border-radius: var(--radius-2xl);
    overflow: hidden;
    margin-bottom: 3rem;
    box-shadow: var(--shadow-xl);
    position: relative;
    border: 1px solid var(--border-color);
    padding: var(--space-8);
}

.transaction-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="transactionDetailPattern" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23transactionDetailPattern)"/></svg>');
    opacity: 0.3;
}

.hero-content {
    position: relative;
    z-index: 2;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: var(--space-6);
}

.hero-info {
    flex: 1;
    min-width: 300px;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 900;
    color: var(--text-primary);
    margin-bottom: var(--space-2);
    font-family: var(--font-display);
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.hero-title i {
    color: var(--accent-color);
    font-size: 2rem;
}

.hero-subtitle {
    color: var(--text-secondary);
    font-size: 1.1rem;
    margin-bottom: var(--space-4);
}

.transaction-id-display {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    color: var(--text-primary);
    padding: var(--space-2) var(--space-4);
    border-radius: var(--radius-full);
    font-weight: 600;
    font-family: 'Courier New', monospace;
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
}

.transaction-id-display i {
    color: var(--accent-color);
}

.hero-actions {
    display: flex;
    gap: var(--space-3);
    flex-wrap: wrap;
}

.hero-btn {
    background: rgba(255, 255, 255, 0.15);
    color: var(--text-primary);
    border: 1px solid rgba(255, 255, 255, 0.3);
    padding: var(--space-3) var(--space-5);
    border-radius: var(--radius-xl);
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition-normal);
    display: flex;
    align-items: center;
    gap: var(--space-2);
    backdrop-filter: blur(10px);
}

.hero-btn:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    color: var(--text-primary);
}

.hero-btn.primary {
    background: var(--gradient-accent);
    border-color: var(--accent-color);
}

.hero-btn.primary:hover {
    background: linear-gradient(135deg, #2c80b6, #2471a3);
    border-color: #2c80b6;
}

/* Main Content */
.transaction-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: var(--space-8);
}

.transaction-details {
    background: var(--card-bg);
    border-radius: var(--radius-2xl);
    padding: var(--space-8);
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
}

.transaction-details::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
}

.section-title {
    color: var(--text-primary);
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: var(--space-6);
    display: flex;
    align-items: center;
    gap: var(--space-3);
    position: relative;
    z-index: 2;
}

.section-title i {
    color: var(--accent-color);
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--space-6);
    position: relative;
    z-index: 2;
}

.detail-item {
    background: var(--card-bg-light);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: var(--space-5);
    transition: var(--transition-normal);
    position: relative;
    overflow: hidden;
}

.detail-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(52, 152, 219, 0.05), transparent);
    transition: var(--transition-normal);
}

.detail-item:hover::before {
    left: 100%;
}

.detail-item:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    border-color: var(--accent-color);
}

.detail-item > * {
    position: relative;
    z-index: 2;
}

.detail-label {
    color: var(--text-muted);
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: var(--space-2);
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.detail-label i {
    color: var(--accent-color);
    font-size: 0.9rem;
}

.detail-value {
    color: var(--text-primary);
    gap: var(--space-2);
    font-size: 1.1rem;
    font-weight: 600;
    line-height: 1.4;
}

.detail-value.large {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--accent-color);
    font-family: var(--font-display);
}

.detail-value.code {
    font-family: 'Courier New', monospace;
    background: var(--primary-color);
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-md);
    border: 1px solid var(--border-color);
    font-size: 0.9rem;
}

/* Sidebar */
.transaction-sidebar {
    display: flex;
    flex-direction: column;
    gap: var(--space-6);
}

.sidebar-card {
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-md);
    position: relative;
    overflow: hidden;
}

.sidebar-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--gradient-accent);
}

.sidebar-card > * {
    position: relative;
    z-index: 2;
}

.sidebar-title {
    color: var(--text-primary);
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: var(--space-4);
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.sidebar-title i {
    color: var(--accent-color);
}

/* Timeline */
.timeline {
    position: relative;
    padding-left: var(--space-6);
}

.timeline::before {
    content: '';
    position: absolute;
    left: var(--space-3);
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--border-color);
}

.timeline-item {
    position: relative;
    margin-bottom: var(--space-5);
    padding: var(--space-4);
    background: var(--card-bg-light);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    transition: var(--transition-normal);
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -1.5rem;
    top: 1.25rem;
    width: 12px;
    height: 12px;
    background: var(--accent-color);
    border-radius: var(--radius-full);
    border: 3px solid var(--card-bg);
    box-shadow: 0 0 0 2px var(--border-color);
}

.timeline-item:hover {
    transform: translateX(5px);
    border-color: var(--accent-color);
}

.timeline-title {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: var(--space-1);
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.timeline-title i {
    color: var(--accent-color);
    font-size: 0.9rem;
}

.timeline-date {
    color: var(--text-muted);
    font-size: 0.85rem;
    margin: 0;
}

/* Quick Actions */
.quick-actions {
    display: flex;
    flex-direction: column;
    gap: var(--space-3);
}

.quick-action-btn {
    background: transparent;
    color: var(--text-secondary);
    border: 1px solid var(--border-color);
    padding: var(--space-3) var(--space-4);
    border-radius: var(--radius-lg);
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition-normal);
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.quick-action-btn:hover {
    background: var(--accent-color);
    color: var(--text-primary);
    border-color: var(--accent-color);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.quick-action-btn i {
    width: 20px;
    text-align: center;
}

.quick-action-btn.primary {
    background: var(--gradient-accent);
    color: var(--text-primary);
    border-color: var(--accent-color);
}

.quick-action-btn.primary:hover {
    background: linear-gradient(135deg, #2c80b6, #2471a3);
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

/* Related Information Cards */
.related-card {
    background: linear-gradient(135deg, var(--card-bg-light) 0%, rgba(255, 255, 255, 0.02) 100%);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    margin-top: var(--space-6);
    position: relative;
    overflow: hidden;
}

.related-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--gradient-accent);
}

.related-card > * {
    position: relative;
    z-index: 2;
}

.related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-4);
}

.related-item {
    background: var(--primary-color);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: var(--space-4);
    transition: var(--transition-normal);
}

.related-item:hover {
    background: var(--card-bg-light);
    border-color: var(--accent-color);
    transform: translateY(-2px);
}

.related-label {
    color: var(--text-muted);
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: var(--space-1);
}

.related-value {
    color: var(--text-primary);
    font-weight: 600;
    font-size: 1rem;
}

/* Support Card */
.support-card {
    background: linear-gradient(135deg, rgba(52, 152, 219, 0.08), rgba(44, 128, 182, 0.08));
    border: 1px solid rgba(52, 152, 219, 0.2);
}

.support-card .sidebar-title {
    color: var(--accent-color);
}

.support-text {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: var(--space-4);
}

.support-actions {
    display: flex;
    flex-direction: column;
    gap: var(--space-3);
}

/* Status Indicators */
.status-indicator {
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-full);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: var(--shadow-sm);
}

.status-indicator.completed {
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
}

.status-indicator.pending {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
}

.status-indicator.failed {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
}

.status-indicator.cancelled {
    background: linear-gradient(135deg, #95a5a6, #7f8c8d);
    color: white;
}

.status-indicator.refunded {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
}

/* Type Indicators */
.type-indicator {
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-2) var(--space-4);
    border-radius: var(--radius-full);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.9rem;
}

.type-indicator.subscription {
    background: linear-gradient(135deg, rgba(243, 156, 18, 0.15), rgba(230, 126, 34, 0.15));
    color: #f39c12;
    border: 1px solid rgba(243, 156, 18, 0.3);
}

.type-indicator.donation {
    background: linear-gradient(135deg, rgba(231, 76, 60, 0.15), rgba(192, 57, 43, 0.15));
    color: #e74c3c;
    border: 1px solid rgba(231, 76, 60, 0.3);
}

.type-indicator.refund {
    background: linear-gradient(135deg, rgba(52, 152, 219, 0.15), rgba(44, 128, 182, 0.15));
    color: var(--accent-color);
    border: 1px solid rgba(52, 152, 219, 0.3);
}

/* Amount Display */
.amount-hero {
    font-size: 3rem;
    font-weight: 900;
    color: var(--text-primary);
    font-family: var(--font-display);
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.amount-hero.success {
    background: linear-gradient(135deg, #27ae60, #229954);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .transaction-content {
        grid-template-columns: 1fr;
        gap: var(--space-6);
    }
    
    .transaction-detail-page {
        margin-top: 80px;
    }
}

@media (max-width: 768px) {
    .hero-content {
        flex-direction: column;
        text-align: center;
    }
    
    .hero-title {
        font-size: 2rem;
        justify-content: center;
    }
    
    .hero-actions {
        justify-content: center;
    }
    
    .details-grid {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .related-grid {
        grid-template-columns: 1fr;
    }
    
    .transaction-hero {
        padding: var(--space-6);
    }
    
    .transaction-details {
        padding: var(--space-6);
    }
    
    .sidebar-card {
        padding: var(--space-5);
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 1.75rem;
    }
    
    .amount-hero {
        font-size: 2.25rem;
    }
    
    .hero-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .hero-btn {
        justify-content: center;
    }
}
</style>

<div class="transaction-detail-page">
    <div class="container">
        <!-- Hero Section -->
        <div class="transaction-hero">
            <div class="hero-content">
                <div class="hero-info">
                    <h1 class="hero-title">
                        <i class="fas fa-receipt"></i>
                        {{ __('lang.site_transaction_details') }}
                    </h1>
                    <p class="hero-subtitle">
                        {{ __('lang.site_transaction_information') }}
                    </p>
                    <div class="transaction-id-display">
                        <i class="fas fa-hashtag"></i>
                        {{ __('lang.admin_transaction_id') }} #{{ $transaction->id }}
                    </div>
                </div>
                <div class="hero-actions">
                    <a href="{{ route('transactions.index') }}" class="hero-btn">
                        <i class="fas fa-arrow-left"></i>
                        {{ __('lang.site_back_to_list') }}
                    </a>
                    @if($transaction->status === 'completed')
                    <a href="{{ route('transactions.invoice', $transaction->id) }}" class="hero-btn primary">
                        <i class="fas fa-download"></i>
                        {{ __('lang.site_download_invoice') }}
                    </a>
                    @endif
            </div>
        </div>
    </div>

        <div class="transaction-content">
            <!-- Main Details -->
            <div class="transaction-details">
                <h2 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    {{ __('lang.site_transaction_information') }}
                </h2>
                
                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-tag"></i>
                            {{ __('lang.site_transaction_type') }}
                </div>
                        <div class="detail-value">
                            <span class="type-indicator {{ $transaction->type }}">
                                        @if($transaction->type === 'subscription')
                                    <i class="fas fa-crown"></i>
                                        @elseif($transaction->type === 'donation')
                                    <i class="fas fa-heart"></i>
                                        @else
                                    <i class="fas fa-undo"></i>
                                        @endif
                                        {{ $transaction->type_label }}
                                    </span>
                                </div>
                            </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-info-circle"></i>
                            {{ __('lang.site_status') }}
                        </div>
                        <div class="detail-value">
                            <span class="status-indicator {{ $transaction->status }}">
                                        @if($transaction->status === 'pending')
                                    <i class="fas fa-clock"></i>{{ __('lang.site_pending') }}
                                        @elseif($transaction->status === 'completed')
                                    <i class="fas fa-check"></i>{{ __('lang.site_completed') }}
                                        @elseif($transaction->status === 'failed')
                                    <i class="fas fa-times"></i>{{ __('lang.site_failed') }}
                                        @elseif($transaction->status === 'cancelled')
                                    <i class="fas fa-ban"></i>{{ __('lang.site_cancelled') }}
                                        @else
                                    <i class="fas fa-undo"></i>{{ __('lang.site_refunded') }}
                                        @endif
                                    </span>
                                </div>
                            </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-euro-sign"></i>
                            {{ __('lang.site_amount') }}
                        </div>
                        <div class="detail-value large success">
                            €{{ number_format($transaction->amount, 2) }}
                                </div>
                            </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-credit-card"></i>
                            {{ __('lang.site_payment_method') }}
                        </div>
                        <div class="detail-value">
                                        @if($transaction->payment_method === 'stripe')
                                <i class="fab fa-cc-stripe me-2"></i>{{ __('lang.admin_stripe') }}
                                        @elseif($transaction->payment_method === 'paypal')
                                <i class="fab fa-paypal me-2"></i>{{ __('lang.admin_paypal') }}
                                        @else
                                            {{ $transaction->payment_method_label }}
                                        @endif
                                </div>
                            </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-calendar-plus"></i>
                            {{ __('lang.site_creation_date') }}
                        </div>
                        <div class="detail-value">
                                    {{ $transaction->created_at->format('d/m/Y à H:i') }}
                                </div>
                            </div>

                    @if($transaction->processed_at)
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-check-circle"></i>
                            {{ __('lang.site_processing_date') }}
                        </div>
                        <div class="detail-value">
                                    {{ $transaction->processed_at->format('d/m/Y à H:i') }}
                                </div>
                            </div>
                    @endif

                    @if($transaction->transaction_id)
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-external-link-alt"></i>
                            {{ __('lang.site_external_transaction_id') }}
                        </div>
                        <div class="detail-value code">
                            {{ $transaction->transaction_id }}
                                </div>
                            </div>
                    @endif

                    <div class="detail-item" style="grid-column: 1 / -1;">
                        <div class="detail-label">
                            <i class="fas fa-align-left"></i>
                            {{ __('lang.site_description') }}
                        </div>
                        <div class="detail-value">
                                    {{ $transaction->description }}
                    </div>
                </div>
            </div>

            <!-- Related Information -->
            @if($transaction->subscription)
                <div class="related-card">
                    <h3 class="section-title">
                        <i class="fas fa-crown"></i>
                        {{ __('lang.site_subscription_details') }}
                    </h3>
                    <div class="related-grid">
                        <div class="related-item">
                            <div class="related-label">{{ __('lang.site_subscription_plan') }}</div>
                            <div class="related-value">{{ $transaction->subscription->membershipPlan->name }}</div>
                        </div>
                        <div class="related-item">
                            <div class="related-label">{{ __('lang.site_period') }}</div>
                            <div class="related-value">
                                {{ $transaction->subscription->start_date->format('d/m/Y') }} - 
                                {{ $transaction->subscription->end_date->format('d/m/Y') }}
                            </div>
                        </div>
                        <div class="related-item">
                            <div class="related-label">{{ __('lang.site_subscription_status') }}</div>
                            <div class="related-value">
                                <span class="status-indicator {{ $transaction->subscription->is_active ? 'completed' : 'cancelled' }}">
                                    @if($transaction->subscription->is_active)
                                        <i class="fas fa-check"></i>{{ __('lang.site_active') }}
                                    @else
                                        <i class="fas fa-times"></i>{{ __('lang.site_inactive') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="related-item">
                            <div class="related-label">{{ __('lang.site_amount_paid') }}</div>
                            <div class="related-value">€{{ number_format($transaction->subscription->amount_paid, 2) }}</div>
                    </div>
                </div>
            </div>
            @endif

            @if($transaction->donation)
                <div class="related-card">
                    <h3 class="section-title">
                        <i class="fas fa-heart"></i>
                        {{ __('lang.site_donation_details') }}
                    </h3>
                    <div class="related-grid">
                        <div class="related-item">
                            <div class="related-label">{{ __('lang.site_donor') }}</div>
                            <div class="related-value">
                                {{ $transaction->donation->is_anonymous ? __('lang.site_anonymous') : $transaction->donation->donor_name }}
                            </div>
                        </div>
                        <div class="related-item">
                            <div class="related-label">{{ __('lang.site_donation_type') }}</div>
                            <div class="related-value">
                                {{ $transaction->donation->is_recurring ? __('lang.site_recurring') : __('lang.site_one_time') }}
                                @if($transaction->donation->is_recurring)
                                    ({{ ucfirst($transaction->donation->recurring_interval) }})
                                @endif
                            </div>
                        </div>
                        <div class="related-item">
                            <div class="related-label">{{ __('lang.site_amount') }}</div>
                            <div class="related-value">€{{ number_format($transaction->donation->amount, 2) }}</div>
                        </div>
                        <div class="related-item">
                            <div class="related-label">{{ __('lang.site_message') }}</div>
                            <div class="related-value">
                                {{ $transaction->donation->message ?: __('lang.site_no_message') }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
        </div>

        <!-- Sidebar -->
            <div class="transaction-sidebar">
                <!-- Timeline -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">
                        <i class="fas fa-history"></i>
                        {{ __('lang.site_history') }}
                    </h3>
                    <div class="timeline">
                        <div class="timeline-item">
                            <h4 class="timeline-title">
                                <i class="fas fa-plus-circle"></i>
                                {{ __('lang.site_transaction_created') }}
                            </h4>
                            <p class="timeline-date">{{ $transaction->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        @if($transaction->processed_at)
                        <div class="timeline-item">
                            <h4 class="timeline-title">
                                <i class="fas fa-check-circle"></i>
                                {{ __('lang.site_transaction_processed') }}
                            </h4>
                            <p class="timeline-date">{{ $transaction->processed_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        @endif
                        @if($transaction->refunded_at)
                        <div class="timeline-item">
                            <h4 class="timeline-title">
                                <i class="fas fa-undo"></i>
                                {{ __('lang.site_transaction_refunded') }}
                            </h4>
                            <p class="timeline-date">{{ $transaction->refunded_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        @endif
                </div>
            </div>

            <!-- Quick Actions -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">
                        <i class="fas fa-bolt"></i>
                        {{ __('lang.site_quick_actions') }}
                    </h3>
                    <div class="quick-actions">
                        @if($transaction->status === 'completed')
                        <a href="{{ route('transactions.invoice', $transaction->id) }}" class="quick-action-btn primary">
                            <i class="fas fa-file-pdf"></i>
                            <span>{{ __('lang.site_invoice_pdf') }}</span>
                        </a>
                        @endif
                        <a href="{{ route('transactions.export.single', ['id' => $transaction->id, 'format' => 'csv']) }}" class="quick-action-btn">
                            <i class="fas fa-file-csv"></i>
                            <span>{{ __('lang.site_export_csv') }}</span>
                        </a>
                        <a href="{{ route('transactions.export.single', ['id' => $transaction->id, 'format' => 'pdf']) }}" class="quick-action-btn">
                            <i class="fas fa-file-export"></i>
                            <span>{{ __('lang.site_export_pdf') }}</span>
                        </a>
                        <a href="{{ route('transactions.index') }}" class="quick-action-btn">
                            <i class="fas fa-list"></i>
                            <span>{{ __('lang.site_all_transactions') }}</span>
                        </a>
                        @if($transaction->type === 'subscription' && $transaction->subscription)
                        <a href="{{ url('membership/plans') }}" class="quick-action-btn">
                            <i class="fas fa-crown"></i>
                            <span>{{ __('lang.site_manage_subscription') }}</span>
                        </a>
                        @endif
                        @if($transaction->type === 'donation')
                        <a href="{{ url('donation') }}" class="quick-action-btn">
                            <i class="fas fa-heart"></i>
                            <span>{{ __('lang.site_make_new_donation') }}</span>
                        </a>
                        @endif
                </div>
            </div>

            <!-- Support -->
                <div class="sidebar-card support-card">
                    <h3 class="sidebar-title">
                        <i class="fas fa-life-ring"></i>
                        {{ __('lang.site_need_help') }}
                    </h3>
                    <p class="support-text">
                        {{ __('lang.site_help_message') }}
                    </p>
                    <div class="support-actions">
                        <a href="{{ url('contact-us') }}" class="quick-action-btn">
                            <i class="fas fa-envelope"></i>
                            <span>{{ __('lang.site_contact_us') }}</span>
                        </a>
                        <a href="{{ url('about-us') }}" class="quick-action-btn">
                            <i class="fas fa-info-circle"></i>
                            <span>{{ __('lang.site_learn_more') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
