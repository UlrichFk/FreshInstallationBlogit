<!-- {{ __("lang.admin_transactions") }} Navigation Component -->
<div class="transactions-nav">
    <div class="nav-header">
        <h5 class="nav-title">
            <i class="fas fa-receipt me-2"></i>
            {{ __("lang.site_my_transactions") }}
        </h5>
    </div>
    
    <div class="nav-links">
        <a href="{{ route('transactions.index') }}" class="nav-link {{ request()->routeIs('transactions.index') ? 'active' : '' }}">
            <div class="nav-link-icon">
                <i class="fas fa-list"></i>
            </div>
            <div class="nav-link-content">
                <span class="nav-link-text">{{ __("lang.site_transaction_history") }}</span>
                <span class="nav-badge">{{ auth()->user()->transactions()->count() }}</span>
            </div>
            <div class="nav-link-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>
        
        <a href="{{ route('transactions.dashboard') }}" class="nav-link {{ request()->routeIs('transactions.dashboard') ? 'active' : '' }}">
            <div class="nav-link-icon">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="nav-link-content">
                <span class="nav-link-text">Tableau de Bord</span>
            </div>
            <div class="nav-link-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>
        
        <a href="{{ route('transactions.analytics') }}" class="nav-link {{ request()->routeIs('transactions.analytics') ? 'active' : '' }}">
            <div class="nav-link-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="nav-link-content">
                <span class="nav-link-text">Analyses</span>
            </div>
            <div class="nav-link-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>
        
        @if(auth()->user()->transactions()->completed()->count() > 0)
        <a href="{{ route('transactions.index', ['status' => 'completed']) }}" class="nav-link">
            <div class="nav-link-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="nav-link-content">
                <span class="nav-link-text">{{ __("lang.site_completed") }} {{ __("lang.admin_transactions") }}</span>
                <span class="nav-badge success">{{ auth()->user()->transactions()->completed()->count() }}</span>
            </div>
            <div class="nav-link-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>
        @endif
        
        @if(auth()->user()->transactions()->pending()->count() > 0)
        <a href="{{ route('transactions.index', ['status' => 'pending']) }}" class="nav-link">
            <div class="nav-link-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="nav-link-content">
                <span class="nav-link-text">En Attente</span>
                <span class="nav-badge warning">{{ auth()->user()->transactions()->pending()->count() }}</span>
            </div>
            <div class="nav-link-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>
        @endif
    </div>
    
    <div class="nav-footer">
        <div class="quick-stats">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-euro-sign"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">€{{ number_format(auth()->user()->transactions()->completed()->sum('amount'), 2) }}</div>
                    <div class="stat-label">Total Dépensé</div>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-receipt"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ auth()->user()->transactions()->completed()->count() }}</div>
                    <div class="stat-label">{{ __("lang.admin_transactions") }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.transactions-nav {
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--border-color);
    overflow: hidden;
    position: relative;
}

.transactions-nav::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
}

.nav-header {
    background: linear-gradient(135deg, var(--gradient-accent) 0%, rgba(15, 52, 96, 0.1) 100%);
    color: var(--text-primary);
    padding: var(--space-6);
    text-align: center;
    position: relative;
    z-index: 2;
}

.nav-title {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-2);
}

.nav-links {
    padding: var(--space-3);
    position: relative;
    z-index: 2;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    padding: var(--space-4);
    color: var(--text-secondary);
    text-decoration: none;
    border-radius: var(--radius-lg);
    transition: var(--transition-normal);
    margin-bottom: var(--space-2);
    position: relative;
    overflow: hidden;
}

.nav-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(52, 152, 219, 0.1), transparent);
    transition: var(--transition-normal);
}

.nav-link:hover::before {
    left: 100%;
}

.nav-link:hover {
    background: var(--card-bg-light);
    color: var(--text-primary);
    transform: translateX(8px);
    box-shadow: var(--shadow-md);
    text-decoration: none;
}

.nav-link.active {
    background: linear-gradient(135deg, rgba(52, 152, 219, 0.1), rgba(44, 128, 182, 0.1));
    color: var(--accent-color);
    border-left: 4px solid var(--accent-color);
    transform: translateX(5px);
    box-shadow: var(--shadow-md);
}

.nav-link-icon {
    width: 40px;
    height: 40px;
    background: rgba(52, 152, 219, 0.1);
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--accent-color);
    font-size: 1.1rem;
    flex-shrink: 0;
    transition: var(--transition-normal);
}

.nav-link:hover .nav-link-icon,
.nav-link.active .nav-link-icon {
    background: var(--accent-color);
    color: var(--text-primary);
    transform: scale(1.1) rotate(5deg);
}

.nav-link-content {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-width: 0;
}

.nav-link-text {
    font-weight: 600;
    font-size: 0.95rem;
}

.nav-badge {
    background: var(--accent-color);
    color: var(--text-primary);
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: var(--radius-full);
    font-weight: 700;
    min-width: 20px;
    text-align: center;
}

.nav-badge.success {
    background: linear-gradient(135deg, #27ae60, #229954);
}

.nav-badge.warning {
    background: linear-gradient(135deg, #f39c12, #e67e22);
}

.nav-link-arrow {
    color: var(--text-muted);
    font-size: 0.8rem;
    opacity: 0;
    transform: translateX(-10px);
    transition: var(--transition-normal);
}

.nav-link:hover .nav-link-arrow,
.nav-link.active .nav-link-arrow {
    opacity: 1;
    transform: translateX(0);
    color: var(--accent-color);
}

.nav-footer {
    background: var(--card-bg-light);
    padding: var(--space-6);
    border-top: 1px solid var(--border-color);
    position: relative;
    z-index: 2;
}

.quick-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-4);
}

.stat-item {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-3);
    background: var(--primary-color);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    transition: var(--transition-normal);
}

.stat-item:hover {
    border-color: var(--accent-color);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.stat-icon {
    width: 35px;
    height: 35px;
    background: var(--gradient-accent);
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-primary);
    font-size: 1rem;
    flex-shrink: 0;
}

.stat-content {
    flex: 1;
    text-align: left;
}

.stat-value {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
    font-family: var(--font-display);
}

.stat-label {
    font-size: 0.75rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}

/* Responsive Design */
@media (max-width: 768px) {
    .transactions-nav {
        margin-bottom: var(--space-6);
    }
    
    .nav-header {
        padding: var(--space-4);
    }
    
    .nav-title {
        font-size: 1.1rem;
    }
    
    .nav-link {
        padding: var(--space-3);
        gap: var(--space-3);
    }
    
    .nav-link-icon {
        width: 35px;
        height: 35px;
        font-size: 1rem;
    }
    
    .nav-link-text {
        font-size: 0.9rem;
    }
    
    .quick-stats {
        grid-template-columns: 1fr;
        gap: var(--space-3);
    }
    
    .stat-item {
        padding: var(--space-2);
    }
    
    .stat-icon {
        width: 30px;
        height: 30px;
        font-size: 0.9rem;
    }
    
    .stat-value {
        font-size: 1rem;
    }
    
    .stat-label {
        font-size: 0.7rem;
    }
}

/* Animation for nav items */
.nav-link {
    animation: navSlideIn 0.6s ease-out;
    animation-fill-mode: both;
}

.nav-link:nth-child(1) { animation-delay: 0.1s; }
.nav-link:nth-child(2) { animation-delay: 0.2s; }
.nav-link:nth-child(3) { animation-delay: 0.3s; }
.nav-link:nth-child(4) { animation-delay: 0.4s; }

@keyframes navSlideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
</style>
