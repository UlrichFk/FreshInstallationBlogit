@extends('site/layout/site-app')

@section('title', __('lang.site_my_transactions'))

@section('content')

<style>
.transactions-page {
    margin-top: 100px;
    padding: 2rem 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.03) 0%, rgba(83, 52, 131, 0.03) 100%);
    min-height: 100vh;
}

/* Hero Section - Cohérent avec show.blade.php */
.transactions-hero {
    background: var(--gradient-hero);
    border-radius: var(--radius-2xl);
    overflow: hidden;
    margin-bottom: 3rem;
    box-shadow: var(--shadow-xl);
    position: relative;
    border: 1px solid var(--border-color);
    padding: var(--space-8);
}

.transactions-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="transactionIndexPattern" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23transactionIndexPattern)"/></svg>');
    opacity: 0.3;
}

.transactions-hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 900px;
    margin: 0 auto;
}

.transactions-hero-content h1 {
    font-size: 3.5rem;
    font-weight: 900;
    color: var(--text-primary);
    margin-bottom: var(--space-4);
    font-family: var(--font-display);
}

.transactions-hero-content .highlight {
    background: var(--gradient-accent);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.transactions-hero-content p {
    font-size: 1.15rem;
    color: var(--text-secondary);
    line-height: 1.8;
    margin: 0 auto var(--space-8);
}

/* Statistics Section - Cohérent avec show.blade.php */
.stats-section {
    margin-bottom: var(--space-8);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--space-6);
}

.stat-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    box-shadow: var(--shadow-md);
    text-align: center;
    transition: var(--transition-normal);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--gradient-accent);
}

.stat-card:hover {
    transform: translateY(-4px);
    border-color: var(--accent-color);
    box-shadow: var(--shadow-lg);
}

.stat-card > * {
    position: relative;
    z-index: 2;
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: var(--accent-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto var(--space-4);
    color: white;
    font-size: 1.5rem;
    box-shadow: var(--shadow-sm);
}

.stat-value {
    font-size: 2rem;
    font-weight: 900;
    color: var(--accent-color);
    font-family: var(--font-display);
    margin-bottom: var(--space-2);
}

.stat-label {
    color: var(--text-secondary);
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 600;
}

/* Filters Section - Cohérent avec show.blade.php */
.filters-section {
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    margin-bottom: var(--space-8);
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
}

.filters-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--gradient-accent);
}

.filters-section > * {
    position: relative;
    z-index: 2;
}

.filters-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: var(--space-6);
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.filters-title i {
    color: var(--accent-color);
}

.filters-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-4);
    margin-bottom: var(--space-6);
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
}

.filter-label {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.9rem;
}

.filter-select {
    padding: var(--space-3);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    background: var(--card-bg-light);
    color: var(--text-primary);
    font-size: 0.9rem;
    transition: var(--transition-normal);
}

.filter-select:focus {
    border-color: var(--accent-color);
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    outline: none;
}

.filter-actions {
    display: flex;
    gap: var(--space-3);
    justify-content: flex-end;
}

.filter-btn {
    padding: var(--space-3) var(--space-6);
    border-radius: var(--radius-lg);
    border: none;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: var(--space-2);
    text-decoration: none;
    transition: var(--transition-normal);
}

.filter-btn:not(.secondary) {
    background: var(--gradient-accent);
    color: var(--text-primary);
    border: 1px solid var(--accent-color);
}

.filter-btn.secondary {
    background: var(--card-bg-light);
    color: var(--text-secondary);
    border: 1px solid var(--border-color);
}

.filter-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.filter-btn:not(.secondary):hover {
    background: linear-gradient(135deg, #2c80b6, #2471a3);
}

.filter-btn.secondary:hover {
    background: var(--accent-color);
    color: var(--text-primary);
    border-color: var(--accent-color);
}

/* Transactions Table Section - Cohérent avec show.blade.php */
.transactions-table-section {
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
}

.transactions-table-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--gradient-accent);
}

.transactions-table-section > * {
    position: relative;
    z-index: 2;
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-6);
    padding-bottom: var(--space-4);
    border-bottom: 1px solid var(--border-color);
}

.table-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.table-title i {
    color: var(--accent-color);
}

.table-actions {
    display: flex;
    gap: var(--space-3);
}

.action-btn1 {
    padding: var(--space-3) var(--space-5);
    border-radius: var(--radius-lg);
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: var(--space-2);
    transition: var(--transition-normal);
    border: 1px solid var(--border-color);
}

.action-btn1.outline {
    background: var(--card-bg-light);
    color: var(--text-secondary);
    border-color: var(--border-color);
}

.action-btn1.outline:hover {
    background: var(--accent-color);
    color: var(--text-primary);
    border-color: var(--accent-color);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Transaction Cards - Cohérent avec show.blade.php */
.transactions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: var(--space-6);
}

.transaction-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    cursor: pointer;
    transition: var(--transition-normal);
    box-shadow: var(--shadow-sm);
    position: relative;
    overflow: hidden;
}

.transaction-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--gradient-accent);
    opacity: 0;
    transition: var(--transition-normal);
}

.transaction-card:hover::before {
    opacity: 1;
}

.transaction-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: var(--accent-color);
}

.transaction-card > * {
    position: relative;
    z-index: 2;
}

.transaction-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-4);
}

.transaction-id-badge {
    background: var(--card-bg-light);
    color: var(--text-secondary);
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-full);
    font-size: 0.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: var(--space-2);
    border: 1px solid var(--border-color);
    font-family: 'Courier New', monospace;
}

.transaction-id-badge i {
    color: var(--accent-color);
}

.transaction-type-badge {
    padding: var(--space-2) var(--space-4);
    border-radius: var(--radius-full);
    font-size: 0.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: var(--space-2);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.transaction-type-badge.subscription {
    background: linear-gradient(135deg, rgba(243, 156, 18, 0.15), rgba(230, 126, 34, 0.15));
    color: #f39c12;
    border: 1px solid rgba(243, 156, 18, 0.3);
}

.transaction-type-badge.donation {
    background: linear-gradient(135deg, rgba(231, 76, 60, 0.15), rgba(192, 57, 43, 0.15));
    color: #e74c3c;
    border: 1px solid rgba(231, 76, 60, 0.3);
}

.transaction-type-badge.refund {
    background: linear-gradient(135deg, rgba(52, 152, 219, 0.15), rgba(44, 128, 182, 0.15));
    color: var(--accent-color);
    border: 1px solid rgba(52, 152, 219, 0.3);
}

.transaction-content {
    margin-bottom: var(--space-4);
}

.transaction-main-info {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: var(--space-4);
}

.transaction-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
    flex: 1;
    margin-right: var(--space-4);
    line-height: 1.4;
}

.transaction-amount {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--accent-color);
    font-family: var(--font-display);
    white-space: nowrap;
}

.transaction-meta {
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
}

.meta-item {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    font-size: 0.9rem;
    color: var(--text-secondary);
}

.meta-item i {
    color: var(--accent-color);
    width: 16px;
    text-align: center;
}

.status-badge {
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-full);
    font-size: 0.8rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: var(--space-2);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: var(--shadow-sm);
}

.meta-item .status-badge i {
    color: var(--text-primary);
}

.meta-item .payment-method-text i {
    color: var(--text-primary);
}

.status-badge.completed {
    background: linear-gradient(135deg, #27ae60, #229954);
    color: white;
}

.status-badge.pending {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
}

.status-badge.failed {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
}

.status-badge.cancelled {
    background: linear-gradient(135deg, #95a5a6, #7f8c8d);
    color: white;
}

.status-badge.refunded {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
}

.payment-method-text {
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.transaction-footer {
    border-top: 1px solid var(--border-color);
    padding-top: var(--space-4);
}

.transaction-actions {
    display: flex;
    gap: var(--space-2);
    flex-wrap: wrap;
}

.transaction-btn {
    padding: var(--space-3) var(--space-4);
    border-radius: var(--radius-lg);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: var(--space-2);
    transition: var(--transition-normal);
    border: 1px solid var(--border-color);
    cursor: pointer;
}

.transaction-btn.primary {
    background: var(--gradient-accent);
    color: var(--text-primary);
    border-color: var(--accent-color);
}

.transaction-btn.secondary {
    background: var(--card-bg-light);
    color: var(--text-secondary);
    border-color: var(--border-color);
}

.transaction-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.transaction-btn.primary:hover {
    background: linear-gradient(135deg, #2c80b6, #2471a3);
}

.transaction-btn.secondary:hover {
    background: var(--accent-color);
    color: var(--text-primary);
    border-color: var(--accent-color);
}

/* Export Dropdown - Cohérent avec show.blade.php */
.export-dropdown {
    position: relative;
}

.export-menu {
    position: absolute;
    bottom: 100%;
    left: 0;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-xl);
    min-width: 200px;
    z-index: 10;
    display: none;
    backdrop-filter: blur(20px);
}

.export-menu.show {
    display: block;
}

.export-option {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-3);
    text-decoration: none;
    color: var(--text-primary);
    transition: var(--transition-normal);
}

.export-option:hover {
    background: var(--card-bg-light);
    transform: translateX(5px);
}

.export-option i {
    color: var(--accent-color);
}

.export-info {
    display: flex;
    flex-direction: column;
}

.export-title {
    font-weight: 600;
    font-size: 0.9rem;
}

.export-desc {
    font-size: 0.8rem;
    color: var(--text-secondary);
}

/* Empty State - Cohérent avec show.blade.php */
.empty-state {
    text-align: center;
    padding: var(--space-8);
    color: var(--text-secondary);
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: var(--space-4);
    color: var(--accent-color);
}

.empty-state h3 {
    font-size: 1.5rem;
    margin-bottom: var(--space-2);
    color: var(--text-primary);
    font-weight: 700;
}

.empty-state p {
    margin-bottom: var(--space-6);
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
}

.empty-actions {
    display: flex;
    gap: var(--space-4);
    justify-content: center;
    flex-wrap: wrap;
}

.btn-primary, .btn-secondary {
    padding: var(--space-3) var(--space-6);
    border-radius: var(--radius-lg);
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: var(--space-2);
    transition: var(--transition-normal);
    border: 1px solid var(--border-color);
}

.btn-primary {
    background: var(--gradient-accent);
    color: var(--text-primary);
    border-color: var(--accent-color);
}

.btn-secondary {
    background: var(--card-bg-light);
    color: var(--text-secondary);
    border-color: var(--border-color);
}

.btn-primary:hover, .btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2c80b6, #2471a3);
}

.btn-secondary:hover {
    background: var(--accent-color);
    color: var(--text-primary);
    border-color: var(--accent-color);
}

/* Pagination - Cohérent avec show.blade.php */
.pagination-wrapper {
    margin-top: var(--space-8);
    display: flex;
    justify-content: center;
}

/* Responsive Design - Cohérent avec show.blade.php */
@media (max-width: 1024px) {
    .transactions-page {
        margin-top: 80px;
    }
}

@media (max-width: 768px) {
    .transactions-hero-content h1 {
        font-size: 2.25rem;
    }
    
    .transactions-grid {
        grid-template-columns: 1fr;
    }
    
    .filters-grid {
        grid-template-columns: 1fr;
    }
    
    .filter-actions {
        justify-content: center;
    }
    
    .table-header {
        flex-direction: column;
        gap: var(--space-4);
        align-items: stretch;
    }
    
    .table-actions {
        justify-content: center;
    }
    
    .transaction-main-info {
        flex-direction: column;
        gap: var(--space-2);
    }
    
    .transaction-amount {
        text-align: center;
    }
    
    .empty-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .transactions-hero {
        padding: var(--space-6);
    }
}

@media (max-width: 480px) {
    .transactions-hero-content h1 {
        font-size: 1.75rem;
    }
    
    .transaction-actions {
        flex-direction: column;
    }
    
    .transaction-btn {
        justify-content: center;
    }
}
</style>

<div class="transactions-page">
    <div class="container">
        <!-- Hero Section -->
        <div class="transactions-hero">
            <div class="transactions-hero-content">
                <h1>{!! __('lang.site_transactions_hero_title') !!}</h1>
                <p>
                    {{ __('lang.site_transactions_hero_subtitle') }}
                </p>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <div class="filters-title">
                <i class="fas fa-filter"></i>
                {{ __('lang.site_filter_transactions') }}
            </div>
            
            <form method="GET" action="{{ route('transactions.index') }}" id="filtersForm">
                <div class="filters-grid">
                    <div class="filter-group">
                        <label class="filter-label">{{ __('lang.admin_type') }}</label>
                        <select name="type" class="filter-select">
                            <option value="">{{ __('lang.site_all_types') }}</option>
                            <option value="subscription" {{ request('type') == 'subscription' ? 'selected' : '' }}>{{ __('lang.site_subscriptions') }}</option>
                            <option value="donation" {{ request('type') == 'donation' ? 'selected' : '' }}>{{ __('lang.site_donations') }}</option>
                            <option value="refund" {{ request('type') == 'refund' ? 'selected' : '' }}>{{ __('lang.site_refunds') }}</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">{{ __('lang.site_status') }}</label>
                        <select name="status" class="filter-select">
                            <option value="">{{ __('lang.site_all_statuses') }}</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('lang.site_completed') }}</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('lang.site_pending') }}</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>{{ __('lang.site_failed') }}</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('lang.site_cancelled') }}</option>
                            <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>{{ __('lang.site_refunded') }}</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">{{ __('lang.admin_date_range') }}</label>
                        <select name="period" class="filter-select">
                            <option value="">{{ __('lang.site_all_periods') }}</option>
                            <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>{{ __('lang.site_today') }}</option>
                            <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>{{ __('lang.site_this_week') }}</option>
                            <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>{{ __('lang.site_this_month') }}</option>
                            <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>{{ __('lang.site_this_year') }}</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">{{ __('lang.site_amount') }}</label>
                        <select name="amount_range" class="filter-select">
                            <option value="">{{ __('lang.site_all_amounts') }}</option>
                            <option value="0-10" {{ request('amount_range') == '0-10' ? 'selected' : '' }}>{{ __("lang.site_amount_0_10") }}</option>
                            <option value="10-50" {{ request('amount_range') == '10-50' ? 'selected' : '' }}>{{ __("lang.site_amount_10_50") }}</option>
                            <option value="50-100" {{ request('amount_range') == '50-100' ? 'selected' : '' }}>{{ __("lang.site_amount_50_100") }}</option>
                            <option value="100+" {{ request('amount_range') == '100+' ? 'selected' : '' }}>{{ __("lang.site_amount_100_plus") }}</option>
                        </select>
                    </div>
                </div>
                
                <div class="filter-actions">
                    <button type="submit" class="filter-btn">
                        <i class="fas fa-search"></i>
                        {{ __('lang.site_apply_filters') }}
                    </button>
                    <a href="{{ route('transactions.index') }}" class="filter-btn secondary">
                        <i class="fas fa-times"></i>
                        {{ __('lang.site_clear') }}
                    </a>
                </div>
            </form>
        </div>

        <!-- Transactions Table -->
        <div class="transactions-table-section">
            <div class="table-header">
                <h2 class="table-title">
                    <i class="fas fa-list"></i>
                    {{ __('lang.site_transaction_history') }}
                </h2>
            </div>

            @if(isset($transactions) && count($transactions))
                <!-- Transaction Cards Grid -->
                <div class="transactions-grid">
                    @foreach($transactions as $transaction)
                        <div class="transaction-card" onclick="window.location.href='{{ route('transactions.show', $transaction->id) }}'">
                            <div class="transaction-header">
                                <div class="transaction-id-badge">
                                    <i class="fas fa-hashtag"></i>
                                    #{{ $transaction->id }}
                                </div>
                                <div class="transaction-type-badge {{ $transaction->type }}">
                                    @if($transaction->type === 'subscription')
                                        <i class="fas fa-crown"></i>
                                    @elseif($transaction->type === 'donation')
                                        <i class="fas fa-heart"></i>
                                    @else
                                        <i class="fas fa-undo"></i>
                                    @endif
                                    {{ $transaction->type_label }}
                                </div>
                            </div>
                            
                            <div class="transaction-content">
                                <div class="transaction-main-info">
                                    <h3 class="transaction-title">{{ $transaction->description }}</h3>
                                    <div class="transaction-amount">
                                        €{{ number_format($transaction->amount, 2) }}
                                    </div>
                                </div>
                                
                                <div class="transaction-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-info-circle"></i>
                                        <span class="status-badge {{ $transaction->status }}">
                                            @if($transaction->status === 'completed')
                                                <i class="fas fa-check"></i>
                                            @elseif($transaction->status === 'pending')
                                                <i class="fas fa-clock"></i>
                                            @elseif($transaction->status === 'failed')
                                                <i class="fas fa-times"></i>
                                            @elseif($transaction->status === 'cancelled')
                                                <i class="fas fa-ban"></i>
                                            @else
                                                <i class="fas fa-undo"></i>
                                            @endif
                                            {{ $transaction->status_label }}
                                        </span>
                                    </div>
                                    
                                    <div class="meta-item">
                                        <i class="fas fa-credit-card"></i>
                                        <span class="payment-method-text">
                                            @if($transaction->payment_method === 'stripe')
                                                <i class="fab fa-cc-stripe"></i>
                                            @elseif($transaction->payment_method === 'paypal')
                                                <i class="fab fa-paypal"></i>
                                            @else
                                                <i class="fas fa-credit-card"></i>
                                            @endif
                                            {{ $transaction->payment_method_label }}
                                        </span>
                                    </div>
                                    
                                    <div class="meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>{{ $transaction->created_at->format('d/m/Y à H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="transaction-footer">
                                <div class="transaction-actions">
                                    <a href="{{ route('transactions.show', $transaction->id) }}" 
                                       class="transaction-btn primary"
                                       onclick="event.stopPropagation();">
                                        <i class="fas fa-eye"></i>
                                        {{ __('lang.site_view_details') }}
                                    </a>
                                    @if($transaction->status === 'completed')
                                    <a href="{{ route('transactions.invoice', $transaction->id) }}" 
                                       class="transaction-btn secondary"
                                       onclick="event.stopPropagation();">
                                        <i class="fas fa-file-pdf"></i>
                                        {{ __('lang.site_invoice_pdf') }}
                                    </a>
                                    @endif
                                    <div class="export-dropdown" onclick="event.stopPropagation();">
                                        <button onclick="toggleExportDropdown({{ $transaction->id }})" class="transaction-btn secondary">
                                            <i class="fas fa-download"></i>
                                            {{ __('lang.site_export') }}
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                        <div class="export-menu" id="exportMenu{{ $transaction->id }}">
                                            <a href="{{ route('transactions.export.single', ['id' => $transaction->id, 'format' => 'csv']) }}" 
                                               class="export-option">
                                                <i class="fas fa-file-csv"></i>
                                                <div class="export-info">
                                                    <span class="export-title">{{ __('lang.site_export_csv') }}</span>
                                                </div>
                                            </a>
                                            <a href="{{ route('transactions.export.single', ['id' => $transaction->id, 'format' => 'pdf']) }}" 
                                               class="export-option">
                                                <i class="fas fa-file-pdf"></i>
                                                <div class="export-info">
                                                    <span class="export-title">{{ __('lang.site_export_pdf') }}</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if(method_exists($transactions, 'hasPages') && $transactions->hasPages())
                    <div class="pagination-wrapper">
                        {{ $transactions->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <h3>{{ __('lang.site_no_transaction_found') }}</h3>
                    <p>
                        {{ __('lang.site_no_transaction_message') }}
                    </p>
                    <div class="empty-actions">
                        <a href="{{ url('membership/plans') }}" class="btn-primary">
                            <i class="fas fa-crown"></i>
                            {{ __('lang.site_view_subscriptions') }}
                        </a>
                        <a href="{{ url('donation') }}" class="btn-secondary">
                            <i class="fas fa-heart"></i>
                            {{ __('lang.site_make_donation') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when filters change
    const filterSelects = document.querySelectorAll('.filter-select');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filtersForm').submit();
        });
    });
    
    // Export dropdown functionality for individual transactions
    window.toggleExportDropdown = function(transactionId) {
        const exportMenu = document.getElementById('exportMenu' + transactionId);
        
        // Close all other export menus first
        document.querySelectorAll('.export-menu.show').forEach(menu => {
            if (menu.id !== 'exportMenu' + transactionId) {
                menu.classList.remove('show');
            }
        });
        
        exportMenu.classList.toggle('show');
    };
    
    // Enhanced card interactions
    const transactionCards = document.querySelectorAll('.transaction-card');
    transactionCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Close export dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const exportDropdowns = document.querySelectorAll('.export-dropdown');
        const exportMenus = document.querySelectorAll('.export-menu');
        
        let clickedInside = false;
        exportDropdowns.forEach(dropdown => {
            if (dropdown.contains(event.target)) {
                clickedInside = true;
            }
        });
        
        if (!clickedInside) {
            exportMenus.forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });
});
</script>

@endsection
