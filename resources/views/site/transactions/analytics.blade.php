@extends('site/layout/site-app')

@section('title', '{{ __("lang.admin_analytics") }} {{ __("lang.admin_transactions") }}')

@section('content')

<style>
.analytics-page {
    margin-top: 100px;
    padding: 2rem 0;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.03) 0%, rgba(83, 52, 131, 0.03) 100%);
    min-height: 100vh;
}

/* Hero Section */
.analytics-hero {
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

.analytics-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="analyticsPattern" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="2" fill="rgba(255,255,255,0.05)"/><circle cx="75" cy="75" r="2" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23analyticsPattern)"/></svg>');
    opacity: 0.25;
}

.analytics-hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 900px;
    margin: 0 auto;
    padding: 0 var(--space-4);
}

.analytics-hero h1 {
    font-size: 3.5rem;
    font-weight: 900;
    color: var(--text-primary);
    margin-bottom: var(--space-4);
    font-family: var(--font-display);
}

.analytics-hero .highlight {
    background: var(--gradient-accent);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.analytics-hero p {
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

/* Controls Section */
.controls-section {
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    margin-bottom: var(--space-8);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
}

.controls-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
}

.controls-section > * {
    position: relative;
    z-index: 2;
}

.controls-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-6);
}

.controls-title {
    color: var(--text-primary);
    font-size: 1.3rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.controls-title i {
    color: var(--accent-color);
}

.controls-actions {
    display: flex;
    gap: var(--space-3);
    align-items: center;
}

.period-select {
    background: var(--primary-color);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    padding: var(--space-2) var(--space-4);
    border-radius: var(--radius-lg);
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition-fast);
}

.period-select:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
}

.refresh-btn {
    background: var(--gradient-accent);
    color: var(--text-primary);
    border: none;
    padding: var(--space-2) var(--space-4);
    border-radius: var(--radius-lg);
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition-normal);
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.refresh-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Stats Overview */
.stats-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--space-6);
    margin-bottom: var(--space-8);
}

.overview-card {
    background: linear-gradient(135deg, var(--card-bg) 0%, rgba(255, 255, 255, 0.02) 100%);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    position: relative;
    overflow: hidden;
    transition: var(--transition-normal);
}

.overview-card::before {
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

.overview-card:hover::before {
    opacity: 1;
}

.overview-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-xl);
    border-color: var(--accent-color);
}

.overview-card > * {
    position: relative;
    z-index: 2;
}

.overview-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-4);
}

.overview-icon {
    width: 50px;
    height: 50px;
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.3rem;
    transition: var(--transition-normal);
}

.overview-card:hover .overview-icon {
    transform: scale(1.1) rotate(5deg);
}

.overview-card:nth-child(1) .overview-icon {
    background: linear-gradient(135deg, #3498db, #2980b9);
}

.overview-card:nth-child(2) .overview-icon {
    background: linear-gradient(135deg, #27ae60, #229954);
}

.overview-card:nth-child(3) .overview-icon {
    background: linear-gradient(135deg, #f39c12, #e67e22);
}

.overview-card:nth-child(4) .overview-icon {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
}

.overview-title {
    color: var(--text-muted);
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: var(--space-1);
}

.overview-value {
    color: var(--text-primary);
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: var(--space-2);
    font-family: var(--font-display);
}

.overview-change {
    font-size: 0.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: var(--space-1);
}

.overview-change.positive {
    color: #27ae60;
}

.overview-change.negative {
    color: #e74c3c;
}

.overview-change.neutral {
    color: var(--text-muted);
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
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--card-bg-light);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    position: relative;
}

.chart-placeholder {
    text-align: center;
    color: var(--text-muted);
}

.chart-placeholder i {
    font-size: 4rem;
    color: var(--accent-color);
    margin-bottom: var(--space-3);
}

.chart-placeholder h4 {
    color: var(--text-primary);
    font-weight: 700;
    margin-bottom: var(--space-2);
}

/* Breakdown Section */
.breakdown-section {
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
    margin-bottom: var(--space-8);
}

.breakdown-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
}

.breakdown-section > * {
    position: relative;
    z-index: 2;
}

.breakdown-title {
    color: var(--text-primary);
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: var(--space-6);
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.breakdown-title i {
    color: var(--accent-color);
}

.breakdown-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-4);
}

.breakdown-item {
    background: var(--card-bg-light);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: var(--space-5);
    text-align: center;
    transition: var(--transition-normal);
    position: relative;
    overflow: hidden;
}

.breakdown-item::before {
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

.breakdown-item:hover::before {
    opacity: 1;
}

.breakdown-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
    border-color: var(--accent-color);
}

.breakdown-item > * {
    position: relative;
    z-index: 2;
}

.breakdown-icon {
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

.breakdown-item:hover .breakdown-icon {
    transform: scale(1.1) rotate(5deg);
}

.breakdown-item:nth-child(1) .breakdown-icon {
    background: linear-gradient(135deg, #f39c12, #e67e22);
}

.breakdown-item:nth-child(2) .breakdown-icon {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
}

.breakdown-item:nth-child(3) .breakdown-icon {
    background: linear-gradient(135deg, #3498db, #2980b9);
}

.breakdown-value {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: var(--space-1);
    font-family: var(--font-display);
}

.breakdown-label {
    color: var(--text-secondary);
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Trends Section */
.trends-section {
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
}

.trends-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
}

.trends-section > * {
    position: relative;
    z-index: 2;
}

.trends-title {
    color: var(--text-primary);
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: var(--space-6);
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.trends-title i {
    color: var(--accent-color);
}

.trends-list {
    display: flex;
    flex-direction: column;
    gap: var(--space-4);
}

.trend-item {
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

.trend-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(52, 152, 219, 0.05), transparent);
    transition: var(--transition-normal);
}

.trend-item:hover::before {
    left: 100%;
}

.trend-item:hover {
    transform: translateX(8px);
    border-color: var(--accent-color);
    box-shadow: var(--shadow-md);
}

.trend-item > * {
    position: relative;
    z-index: 2;
}

.trend-icon {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-full);
    background: var(--gradient-accent);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-primary);
    font-size: 1rem;
    flex-shrink: 0;
    transition: var(--transition-normal);
}

.trend-item:hover .trend-icon {
    transform: scale(1.1) rotate(5deg);
}

.trend-content {
    flex: 1;
    min-width: 0;
}

.trend-label {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: var(--space-1);
}

.trend-description {
    color: var(--text-secondary);
    font-size: 0.85rem;
}

.trend-value {
    color: var(--accent-color);
    font-weight: 700;
    font-size: 1.1rem;
    font-family: var(--font-display);
}

/* Period Selector */
.period-selector {
    display: flex;
    gap: var(--space-2);
    background: var(--card-bg-light);
    padding: var(--space-2);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
}

.period-option {
    background: transparent;
    color: var(--text-secondary);
    border: none;
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-md);
    cursor: pointer;
    transition: var(--transition-fast);
    font-weight: 600;
    font-size: 0.9rem;
}

.period-option:hover {
    background: var(--primary-color);
    color: var(--text-primary);
}

.period-option.active {
    background: var(--accent-color);
    color: var(--text-primary);
    box-shadow: var(--shadow-sm);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .charts-section {
        grid-template-columns: 1fr;
        gap: var(--space-6);
    }
    
    .analytics-page {
        margin-top: 80px;
    }
}

@media (max-width: 768px) {
    .analytics-hero {
        min-height: 40vh;
        margin-bottom: 2rem;
    }
    
    .analytics-hero h1 {
        font-size: 2.5rem;
    }
    
    .stats-overview {
        grid-template-columns: repeat(2, 1fr);
        gap: var(--space-4);
    }
    
    .breakdown-grid {
        grid-template-columns: 1fr;
    }
    
    .controls-header {
        flex-direction: column;
        gap: var(--space-4);
        text-align: center;
    }
    
    .controls-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .period-select {
        width: 100%;
    }
    
    .hero-badges {
        flex-direction: column;
        align-items: center;
        gap: var(--space-2);
    }
}

@media (max-width: 480px) {
    .analytics-hero h1 {
        font-size: 2rem;
    }
    
    .analytics-hero p {
        font-size: 1rem;
    }
    
    .stats-overview {
        grid-template-columns: 1fr;
    }
    
    .period-selector {
        flex-direction: column;
    }
}
</style>

<div class="analytics-page">
    <div class="container">
        <!-- Hero Section -->
        <div class="analytics-hero">
            <div class="analytics-hero-content">
                <div class="hero-badges">
                    <span class="hero-badge">
                        <i class="fas fa-chart-line"></i> 
                        {{ __("lang.admin_analytics") }}
                    </span>
                    <span class="hero-badge">
                        <i class="fas fa-calculator"></i> 
                        Calculs précis
                    </span>
                    <span class="hero-badge">
                        <i class="fas fa-trending-up"></i> 
                        Tendances détaillées
                    </span>
                </div>
                <h1><span class="highlight">{{ __("lang.admin_analytics") }}</span> des {{ __("lang.admin_transactions") }}</h1>
                <p>
                    Visualisez vos habitudes de dépenses, suivez vos tendances et obtenez des insights détaillés 
                    sur votre activité financière avec nos outils d'analyse avancés.
                </p>
            </div>
        </div>

        <!-- Controls Section -->
        <div class="controls-section">
            <div class="controls-header">
                <h2 class="controls-title">
                    <i class="fas fa-sliders-h"></i>
                    Paramètres d'Analyse
                </h2>
                <div class="controls-actions">
                    <select class="period-select" id="periodSelect">
                        <option value="7">7 derniers jours</option>
                        <option value="30" selected>30 derniers jours</option>
                        <option value="90">3 derniers mois</option>
                        <option value="365">12 derniers mois</option>
                    </select>
                    <button class="refresh-btn" onclick="refreshAnalytics()">
                        <i class="fas fa-sync-alt"></i>
                        Actualiser
                    </button>
                </div>
            </div>
        </div>

        <!-- Overview Stats -->
        <div class="stats-overview">
            <div class="overview-card">
                <div class="overview-header">
                    <div class="overview-icon">
                        <i class="fas fa-euro-sign"></i>
                    </div>
                </div>
                <div class="overview-title">Total Dépensé</div>
                <div class="overview-value" id="totalSpent">€0.00</div>
                <div class="overview-change positive" id="totalSpentChange">
                    <i class="fas fa-arrow-up"></i>
                    +0%
                </div>
            </div>
            
            <div class="overview-card">
                <div class="overview-header">
                    <div class="overview-icon">
                        <i class="fas fa-receipt"></i>
                    </div>
                </div>
                <div class="overview-title">{{ __("lang.admin_transactions") }}</div>
                <div class="overview-value" id="total{{ __("lang.admin_transactions") }}">0</div>
                <div class="overview-change positive" id="total{{ __("lang.admin_transactions") }}Change">
                    <i class="fas fa-arrow-up"></i>
                    +0%
                </div>
            </div>
            
            <div class="overview-card">
                <div class="overview-header">
                    <div class="overview-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                </div>
                <div class="overview-title">Moyenne</div>
                <div class="overview-value" id="averageAmount">€0.00</div>
                <div class="overview-change neutral" id="averageAmountChange">
                    <i class="fas fa-minus"></i>
                    0%
                </div>
            </div>
            
            <div class="overview-card">
                <div class="overview-header">
                    <div class="overview-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="overview-title">Taux de Réussite</div>
                <div class="overview-value" id="successRate">0%</div>
                <div class="overview-change positive" id="successRateChange">
                    <i class="fas fa-arrow-up"></i>
                    +0%
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-section">
            <div class="chart-card">
                <h3 class="chart-title">
                    <i class="fas fa-chart-area"></i>
                    Évolution des {{ __("lang.admin_transactions") }}
                </h3>
                <div class="chart-container" id="transactionChart">
                    <div class="chart-placeholder">
                        <i class="fas fa-chart-line"></i>
                        <h4>Graphique des {{ __("lang.admin_transactions") }}</h4>
                        <p>{{ __("lang.site_transactions_hero_subtitle") }}</p>
                    </div>
                </div>
            </div>

            <div class="chart-card">
                <h3 class="chart-title">
                    <i class="fas fa-chart-pie"></i>
                    Répartition par Type
                </h3>
                <div class="chart-container" id="typeChart">
                    <div class="chart-placeholder">
                        <i class="fas fa-chart-pie"></i>
                        <h4>Graphique en Secteurs</h4>
                        <p>{{ __("lang.site_transactions_hero_subtitle") }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Breakdown Analysis -->
        <div class="breakdown-section">
            <h3 class="breakdown-title">
                <i class="fas fa-analytics"></i>
                Analyse Détaillée
            </h3>
            <div class="breakdown-grid">
                <div class="breakdown-item">
                    <div class="breakdown-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div class="breakdown-value" id="subscriptionTotal">€0.00</div>
                    <div class="breakdown-label">{{ __('lang.site_subscription') }}s</div>
                </div>
                
                <div class="breakdown-item">
                    <div class="breakdown-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="breakdown-value" id="donationTotal">€0.00</div>
                    <div class="breakdown-label">Dons</div>
                </div>
                
                <div class="breakdown-item">
                    <div class="breakdown-icon">
                        <i class="fas fa-undo"></i>
                    </div>
                    <div class="breakdown-value" id="refundTotal">€0.00</div>
                    <div class="breakdown-label">Remboursements</div>
                </div>
                
                <div class="breakdown-item">
                    <div class="breakdown-icon">
                        <i class="fas fa-calendar-month"></i>
                    </div>
                    <div class="breakdown-value" id="monthlyAverage">€0.00</div>
                    <div class="breakdown-label">Moyenne Mensuelle</div>
                </div>
            </div>
        </div>

        <!-- Trends Analysis -->
        <div class="trends-section">
            <h3 class="trends-title">
                <i class="fas fa-trending-up"></i>
                Tendances et Insights
            </h3>
            <div class="trends-list">
                <div class="trend-item">
                    <div class="trend-icon">
                        <i class="fas fa-arrow-trend-up"></i>
                    </div>
                    <div class="trend-content">
                        <div class="trend-label">Croissance des Dépenses</div>
                        <div class="trend-description">Évolution de vos dépenses par rapport à la période précédente</div>
                    </div>
                    <div class="trend-value" id="spendingGrowth">+0%</div>
                </div>
                
                <div class="trend-item">
                    <div class="trend-icon">
                        <i class="fas fa-frequency"></i>
                    </div>
                    <div class="trend-content">
                        <div class="trend-label">Fréquence des {{ __("lang.admin_transactions") }}</div>
                        <div class="trend-description">{{ __("lang.site_transactions_hero_subtitle") }}</div>
                    </div>
                    <div class="trend-value" id="transactionFrequency">0</div>
                </div>
                
                <div class="trend-item">
                    <div class="trend-icon">
                        <i class="fas fa-target"></i>
                    </div>
                    <div class="trend-content">
                        <div class="trend-label">Efficacité des Paiements</div>
                        <div class="trend-description">{{ __("lang.site_transactions_hero_subtitle") }}</div>
                    </div>
                    <div class="trend-value" id="paymentEfficiency">0%</div>
                </div>
                
                <div class="trend-item">
                    <div class="trend-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="trend-content">
                        <div class="trend-label">Transaction la Plus Importante</div>
                        <div class="trend-description">Montant de votre plus grosse transaction</div>
                    </div>
                    <div class="trend-value" id="largestTransaction">€0.00</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Period selector functionality
    const periodSelect = document.getElementById('periodSelect');
    if (periodSelect) {
        periodSelect.addEventListener('change', function() {
            updateAnalytics(this.value);
        });
    }
    
    // Refresh analytics functionality
    window.refreshAnalytics = function() {
        const refreshBtn = document.querySelector('.refresh-btn');
        const originalText = refreshBtn.innerHTML;
        refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualisation...';
        refreshBtn.disabled = true;
        
        // Simulate refresh (replace with actual implementation)
        setTimeout(() => {
            location.reload();
        }, 1000);
    };
    
    // Update analytics based on period
    function updateAnalytics(period) {
        // Add loading states
        const valueElements = document.querySelectorAll('.overview-value, .breakdown-value, .trend-value');
        valueElements.forEach(el => {
            el.style.opacity = '0.5';
        });
        
        // Simulate API call (replace with actual implementation)
        setTimeout(() => {
            // Mock data update based on period
            const mockData = getMockData(period);
            updateUI(mockData);
            
            valueElements.forEach(el => {
                el.style.opacity = '1';
            });
        }, 500);
    }
    
    // Mock data generator
    function getMockData(period) {
        const multiplier = period / 30; // Base on 30 days
        return {
            totalSpent: (Math.random() * 500 * multiplier).toFixed(2),
            total{{ __("lang.admin_transactions") }}: Math.floor(Math.random() * 20 * multiplier),
            averageAmount: (Math.random() * 100).toFixed(2),
            successRate: (85 + Math.random() * 10).toFixed(1),
            subscriptionTotal: (Math.random() * 300 * multiplier).toFixed(2),
            donationTotal: (Math.random() * 200 * multiplier).toFixed(2),
            refundTotal: (Math.random() * 50 * multiplier).toFixed(2),
            monthlyAverage: (Math.random() * 150).toFixed(2),
            spendingGrowth: ((Math.random() - 0.5) * 40).toFixed(1),
            transactionFrequency: Math.floor(Math.random() * 10 + 1),
            paymentEfficiency: (85 + Math.random() * 10).toFixed(1),
            largestTransaction: (Math.random() * 200 + 50).toFixed(2)
        };
    }
    
    // Update UI with new data
    function updateUI(data) {
        document.getElementById('totalSpent').textContent = `€${data.totalSpent}`;
        document.getElementById('total{{ __("lang.admin_transactions") }}').textContent = data.total{{ __("lang.admin_transactions") }};
        document.getElementById('averageAmount').textContent = `€${data.averageAmount}`;
        document.getElementById('successRate').textContent = `${data.successRate}%`;
        document.getElementById('subscriptionTotal').textContent = `€${data.subscriptionTotal}`;
        document.getElementById('donationTotal').textContent = `€${data.donationTotal}`;
        document.getElementById('refundTotal').textContent = `€${data.refundTotal}`;
        document.getElementById('monthlyAverage').textContent = `€${data.monthlyAverage}`;
        document.getElementById('spendingGrowth').textContent = `${data.spendingGrowth > 0 ? '+' : ''}${data.spendingGrowth}%`;
        document.getElementById('transactionFrequency').textContent = data.transactionFrequency;
        document.getElementById('paymentEfficiency').textContent = `${data.paymentEfficiency}%`;
        document.getElementById('largestTransaction').textContent = `€${data.largestTransaction}`;
        
        // Update change indicators
        const changes = document.querySelectorAll('.overview-change');
        changes.forEach(change => {
            const value = parseFloat(change.textContent.replace(/[^-\d.]/g, ''));
            change.className = `overview-change ${value > 0 ? 'positive' : value < 0 ? 'negative' : 'neutral'}`;
            
            const icon = change.querySelector('i');
            if (value > 0) {
                icon.className = 'fas fa-arrow-up';
            } else if (value < 0) {
                icon.className = 'fas fa-arrow-down';
            } else {
                icon.className = 'fas fa-minus';
            }
        });
    }
    
    // Initialize with default period
    updateAnalytics(30);
});
</script>

@endsection
