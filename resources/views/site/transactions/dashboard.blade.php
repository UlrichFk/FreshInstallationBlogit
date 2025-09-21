@extends('site/layout/site-app')

@section('title', '{{ __("lang.site_my_transactions") }} {{ __("lang.app_dashboard") }}')

@section('content')

<style>
.dashboard-page {
    margin-top: 100px;
    padding: 2rem 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.03) 0%, rgba(83, 52, 131, 0.03) 100%);
    min-height: 100vh;
}

/* Hero Section */
.dashboard-hero {
    background: var(--gradient-hero);
    min-height: 50vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
    margin-bottom: 3rem;
    border-radius: var(--radius-2xl);
    box-shadow: var(--shadow-2xl);
    border: 1px solid var(--border-color);
}

.dashboard-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dashboardPattern" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="2" fill="rgba(255,255,255,0.05)"/><circle cx="75" cy="75" r="2" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23dashboardPattern)"/></svg>');
    opacity: 0.25;
}

.dashboard-hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 900px;
    margin: 0 auto;
    padding: 0 var(--space-4);
}

.dashboard-hero h1 {
    font-size: 3.5rem;
    font-weight: 900;
    color: var(--text-primary);
    margin-bottom: var(--space-4);
    font-family: var(--font-display);
}

.dashboard-hero .highlight {
    background: var(--gradient-accent);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.dashboard-hero p {
    font-size: 1.15rem;
    color: var(--text-secondary);
    line-height: 1.8;
    margin: 0 auto var(--space-8);
}

.hero-badges {
    display: flex;
    justify-content: center;
    gap: var(--space-3);
    flex-wrap: wrap;
}

.hero-badge {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    color: var(--text-primary);
    padding: .5rem 1rem;
    border-radius: 999px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: .5rem;
}

.hero-badge i { color: var(--accent-color); }

/* Stats Section */
.stats-section {
    background: var(--card-bg);
    border-radius: var(--radius-2xl);
    padding: var(--space-8);
    margin-bottom: var(--space-8);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
}

.stats-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--space-6);
}

.stat-card {
    background: linear-gradient(135deg, var(--card-bg-light) 0%, rgba(255, 255, 255, 0.02) 100%);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
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
    bottom: 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.02) 0%, rgba(83, 52, 131, 0.02) 100%);
    opacity: 0;
    transition: var(--transition-normal);
}

.stat-card:hover::before {
    opacity: 1;
}

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
    border-color: var(--accent-color);
}

.stat-card > * {
    position: relative;
    z-index: 2;
}

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto var(--space-4);
    color: white;
    font-size: 1.8rem;
    box-shadow: var(--shadow-lg);
    transition: var(--transition-normal);
}

.stat-card:hover .stat-icon {
    transform: scale(1.1) rotate(5deg);
    box-shadow: var(--shadow-xl);
}

.stat-card:nth-child(1) .stat-icon {
    background: linear-gradient(135deg, #3498db, #2980b9);
}

.stat-card:nth-child(2) .stat-icon {
    background: linear-gradient(135deg, #27ae60, #229954);
}

.stat-card:nth-child(3) .stat-icon {
    background: linear-gradient(135deg, #f39c12, #e67e22);
}

.stat-card:nth-child(4) .stat-icon {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: var(--space-2);
    font-family: var(--font-display);
}

.stat-label {
    color: var(--text-secondary);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.9rem;
}

/* Charts Section */
.charts-section {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: var(--space-8);
    margin-bottom: var(--space-8);
}

.chart-card {
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    padding: var(--space-8);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
}

.chart-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
}

.chart-card > * {
    position: relative;
    z-index: 2;
}

.chart-title {
    color: var(--text-primary);
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: var(--space-6);
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.chart-title i {
    color: var(--accent-color);
}

.chart-container {
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--card-bg-light);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
}

.chart-placeholder {
    text-align: center;
    color: var(--text-muted);
}

.chart-placeholder i {
    font-size: 3rem;
    color: var(--accent-color);
    margin-bottom: var(--space-3);
}

/* Recent {{ __("lang.admin_transactions") }} */
.recent-transactions {
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
}

.recent-transactions::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
}

.recent-transactions > * {
    position: relative;
    z-index: 2;
}

.recent-title {
    color: var(--text-primary);
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: var(--space-6);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.recent-title .title-content {
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.recent-title i {
    color: var(--accent-color);
}

.view-all-link {
    color: var(--accent-color);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-lg);
    transition: var(--transition-fast);
}

.view-all-link:hover {
    background: var(--accent-color);
    color: var(--text-primary);
    transform: translateX(3px);
}

.recent-list {
    display: flex;
    flex-direction: column;
    gap: var(--space-4);
}

.recent-item {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    padding: var(--space-4);
    background: var(--card-bg-light);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    transition: var(--transition-normal);
    position: relative;
    overflow: hidden;
}

.recent-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(52, 152, 219, 0.05), transparent);
    transition: var(--transition-normal);
}

.recent-item:hover::before {
    left: 100%;
}

.recent-item:hover {
    transform: translateX(8px);
    border-color: var(--accent-color);
    box-shadow: var(--shadow-md);
}

.recent-item > * {
    position: relative;
    z-index: 2;
}

.recent-icon {
    width: 45px;
    height: 45px;
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
    transition: var(--transition-normal);
}

.recent-item:hover .recent-icon {
    transform: scale(1.1) rotate(5deg);
}

.recent-icon.subscription {
    background: linear-gradient(135deg, #f39c12, #e67e22);
}

.recent-icon.donation {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
}

.recent-icon.refund {
    background: linear-gradient(135deg, #3498db, #2980b9);
}

.recent-details {
    flex: 1;
    min-width: 0;
}

.recent-title-text {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: var(--space-1);
    font-size: 1rem;
}

.recent-meta {
    color: var(--text-muted);
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.recent-meta span {
    display: flex;
    align-items: center;
    gap: var(--space-1);
}

.recent-amount {
    color: var(--accent-color);
    font-weight: 700;
    font-size: 1.1rem;
    font-family: var(--font-display);
}

.recent-status {
    padding: var(--space-1) var(--space-2);
    border-radius: var(--radius-full);
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-left: auto;
}

.recent-status.completed {
    background: linear-gradient(135deg, rgba(39, 174, 96, 0.15), rgba(34, 153, 84, 0.15));
    color: #27ae60;
    border: 1px solid rgba(39, 174, 96, 0.3);
}

.recent-status.pending {
    background: linear-gradient(135deg, rgba(243, 156, 18, 0.15), rgba(230, 126, 34, 0.15));
    color: #f39c12;
    border: 1px solid rgba(243, 156, 18, 0.3);
}

.recent-status.failed {
    background: linear-gradient(135deg, rgba(231, 76, 60, 0.15), rgba(192, 57, 43, 0.15));
    color: #e74c3c;
    border: 1px solid rgba(231, 76, 60, 0.3);
}

/* Quick Actions */
.quick-actions-section {
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
}

.quick-actions-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
}

.quick-actions-section > * {
    position: relative;
    z-index: 2;
}

.quick-actions-title {
    color: var(--text-primary);
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: var(--space-6);
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.quick-actions-title i {
    color: var(--accent-color);
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-4);
}

.action-card {
    background: var(--card-bg-light);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: var(--space-5);
    text-align: center;
    transition: var(--transition-normal);
    position: relative;
    overflow: hidden;
}

.action-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.02) 0%, rgba(83, 52, 131, 0.02) 100%);
    opacity: 0;
    transition: var(--transition-normal);
}

.action-card:hover::before {
    opacity: 1;
}

.action-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
    border-color: var(--accent-color);
}

.action-card > * {
    position: relative;
    z-index: 2;
}

.action-icon {
    width: 60px;
    height: 60px;
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto var(--space-3);
    color: white;
    font-size: 1.5rem;
    transition: var(--transition-normal);
}

.action-card:hover .action-icon {
    transform: scale(1.1) rotate(5deg);
}

.action-card:nth-child(1) .action-icon {
    background: linear-gradient(135deg, #3498db, #2980b9);
}

.action-card:nth-child(2) .action-icon {
    background: linear-gradient(135deg, #f39c12, #e67e22);
}

.action-card:nth-child(3) .action-icon {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
}

.action-card:nth-child(4) .action-icon {
    background: linear-gradient(135deg, #27ae60, #229954);
}

.action-title {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: var(--space-2);
    font-size: 1rem;
}

.action-description {
    color: var(--text-secondary);
    font-size: 0.85rem;
    line-height: 1.5;
    margin-bottom: var(--space-3);
}

.action-link {
    color: var(--accent-color);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-lg);
    transition: var(--transition-fast);
}

.action-link:hover {
    background: var(--accent-color);
    color: var(--text-primary);
    transform: translateX(3px);
}

/* Analytics Section */
.analytics-section {
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
    margin-bottom: var(--space-8);
}

.analytics-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
}

.analytics-section > * {
    position: relative;
    z-index: 2;
}

.analytics-title {
    color: var(--text-primary);
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: var(--space-6);
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.analytics-title i {
    color: var(--accent-color);
}

.analytics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: var(--space-4);
}

.analytics-item {
    text-align: center;
    padding: var(--space-4);
    background: var(--card-bg-light);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    transition: var(--transition-normal);
}

.analytics-item:hover {
    transform: translateY(-3px);
    border-color: var(--accent-color);
    box-shadow: var(--shadow-md);
}

.analytics-number {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--accent-color);
    margin-bottom: var(--space-1);
    font-family: var(--font-display);
}

.analytics-label {
    color: var(--text-secondary);
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .charts-section {
        grid-template-columns: 1fr;
        gap: var(--space-6);
    }
    
    .dashboard-page {
        margin-top: 80px;
    }
}

@media (max-width: 768px) {
    .dashboard-hero {
        min-height: 40vh;
        margin-bottom: 2rem;
    }
    
    .dashboard-hero h1 {
        font-size: 2.5rem;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: var(--space-4);
    }
    
    .actions-grid {
        grid-template-columns: 1fr;
    }
    
    .analytics-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .hero-badges {
        flex-direction: column;
        align-items: center;
        gap: var(--space-2);
    }
}

@media (max-width: 480px) {
    .dashboard-hero h1 {
        font-size: 2rem;
    }
    
    .dashboard-hero p {
        font-size: 1rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .analytics-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="dashboard-page">
    <div class="container">
        <!-- Hero Section -->
        <div class="dashboard-hero">
            <div class="dashboard-hero-content">
                <div class="hero-badges">
                    <span class="hero-badge">
                        <i class="fas fa-chart-line"></i> 
                        Analyses en temps réel
                    </span>
                    <span class="hero-badge">
                        <i class="fas fa-shield-check"></i> 
                        Données sécurisées
                    </span>
                    <span class="hero-badge">
                        <i class="fas fa-eye"></i> 
                        Vue d'ensemble
                    </span>
                </div>
                <h1>Tableau de <span class="highlight">Bord</span></h1>
                <p>
                    {{ __("lang.site_transactions_hero_subtitle") }} 
                    {{ __('lang.site_track_expenses_manage_subscriptions') }}
                </p>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-euro-sign"></i>
                    </div>
                    <div class="stat-value">€{{ number_format($stats['total_amount'], 2) }}</div>
                    <div class="stat-label">Total Dépensé</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div class="stat-value">{{ $stats['total_transactions'] }}</div>
                    <div class="stat-label">{{ __("lang.admin_transactions") }}</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-value">{{ $stats['completed_transactions'] }}</div>
                    <div class="stat-label">Complétées</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-value">{{ $stats['pending_transactions'] }}</div>
                    <div class="stat-label">En Attente</div>
                </div>
            </div>
        </div>

        <!-- Charts and Analytics -->
        <div class="charts-section">
            <div class="chart-card">
                <h3 class="chart-title">
                    <i class="fas fa-chart-area"></i>
                    Évolution des {{ __("lang.admin_transactions") }}
                </h3>
                <div class="chart-container">
                    <div class="chart-placeholder">
                        <i class="fas fa-chart-line"></i>
                        <h4>Graphique des {{ __("lang.admin_transactions") }}</h4>
                        <p>{{ __("lang.site_transactions_hero_subtitle") }}</p>
                    </div>
                </div>
            </div>

            <div class="analytics-section">
                <h3 class="analytics-title">
                    <i class="fas fa-analytics"></i>
                    Analyses Rapides
                </h3>
                <div class="analytics-grid">
                    <div class="analytics-item">
                        <div class="analytics-number">{{ $stats['this_month_transactions'] ?? 0 }}</div>
                        <div class="analytics-label">Ce Mois</div>
                    </div>
                    <div class="analytics-item">
                        <div class="analytics-number">{{ $stats['this_week_transactions'] ?? 0 }}</div>
                        <div class="analytics-label">Cette Semaine</div>
                    </div>
                    <div class="analytics-item">
                        <div class="analytics-number">€{{ number_format($stats['average_amount'] ?? 0, 0) }}</div>
                        <div class="analytics-label">Montant Moyen</div>
                    </div>
                    <div class="analytics-item">
                        <div class="analytics-number">{{ $stats['success_rate'] ?? 0 }}%</div>
                        <div class="analytics-label">Taux de Succès</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent {{ __("lang.admin_transactions") }} -->
        <div class="recent-transactions">
            <h3 class="recent-title">
                <div class="title-content">
                    <i class="fas fa-clock"></i>
                    {{ __("lang.admin_transactions") }} Récentes
                </div>
                <a href="{{ route('transactions.index') }}" class="view-all-link">
                    Voir tout
                    <i class="fas fa-arrow-right"></i>
                </a>
            </h3>
            
            @if(isset($recent_transactions) && count($recent_transactions))
                <div class="recent-list">
                    @foreach($recent_transactions as $transaction)
                        <div class="recent-item">
                            <div class="recent-icon {{ $transaction->type }}">
                                @if($transaction->type === 'subscription')
                                    <i class="fas fa-crown"></i>
                                @elseif($transaction->type === 'donation')
                                    <i class="fas fa-heart"></i>
                                @else
                                    <i class="fas fa-undo"></i>
                                @endif
                            </div>
                            
                            <div class="recent-details">
                                <h4 class="recent-title-text">{{ $transaction->description }}</h4>
                                <div class="recent-meta">
                                    <span>
                                        <i class="fas fa-hashtag"></i>
                                        #{{ $transaction->id }}
                                    </span>
                                    <span>
                                        <i class="fas fa-calendar"></i>
                                        {{ $transaction->created_at->format('d/m/Y') }}
                                    </span>
                                    <span>
                                        <i class="fas fa-credit-card"></i>
                                        {{ $transaction->payment_method_label }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="recent-amount">
                                €{{ number_format($transaction->amount, 2) }}
                            </div>
                            
                            <div class="recent-status {{ $transaction->status }}">
                                {{ $transaction->status_label }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state" style="padding: var(--space-12) var(--space-4);">
                    <div class="empty-icon" style="width: 80px; height: 80px; font-size: 2rem; margin-bottom: var(--space-4);">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <h4>{{ __("lang.site_no_recent_transactions") }}</h4>
                    <p>Commencez par effectuer votre première transaction.</p>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions-section">
            <h3 class="quick-actions-title">
                <i class="fas fa-bolt"></i>
                Actions Rapides
            </h3>
            <div class="actions-grid">
                <div class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <h4 class="action-title">Voir Toutes les {{ __("lang.admin_transactions") }}</h4>
                    <p class="action-description">{{ __("lang.site_transactions_hero_subtitle") }}</p>
                    <a href="{{ route('transactions.index') }}" class="action-link">
                        Accéder
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <h4 class="action-title">Gérer l{{ __('lang.site_subscription') }}</h4>
                    <p class="action-description">Modifiez ou renouvelez votre plan premium</p>
                    <a href="{{ url('membership/plans') }}" class="action-link">
                        Gérer
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h4 class="action-title">Faire un Don</h4>
                    <p class="action-description">Soutenez notre mission avec un nouveau don</p>
                    <a href="{{ url('donation') }}" class="action-link">
                        Donner
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-download"></i>
                    </div>
                    <h4 class="action-title">Télécharger Factures</h4>
                    <p class="action-description">Accédez à toutes vos factures et reçus</p>
                    <a href="{{ route('transactions.index') }}?status=completed" class="action-link">
                        Télécharger
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Refresh dashboard functionality
    window.refreshDashboard = function() {
        // Add loading state
        const refreshBtn = document.querySelector('button[onclick="refreshDashboard()"]');
        const originalText = refreshBtn.innerHTML;
        refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Actualisation...';
        refreshBtn.disabled = true;
        
        // Simulate refresh (replace with actual implementation)
        setTimeout(() => {
            location.reload();
        }, 1000);
    };
    
    // Enhanced card interactions
    const actionCards = document.querySelectorAll('.action-card');
    actionCards.forEach(card => {
        card.addEventListener('click', function(e) {
            if (!e.target.closest('a')) {
                const link = this.querySelector('.action-link');
                if (link) {
                    window.location.href = link.href;
                }
            }
        });
        
        card.style.cursor = 'pointer';
    });
    
    // Recent transaction click handling
    const recentItems = document.querySelectorAll('.recent-item');
    recentItems.forEach(item => {
        item.addEventListener('click', function() {
            const transactionId = this.dataset.transactionId;
            if (transactionId) {
                window.location.href = `{{ url('transactions') }}/${transactionId}`;
            }
        });
        
        item.style.cursor = 'pointer';
    });
});
</script>

@endsection
