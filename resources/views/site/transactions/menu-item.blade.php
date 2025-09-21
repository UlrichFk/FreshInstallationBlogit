<!-- Transaction Menu Item Component -->
@auth
<li class="nav-item has-dropdown">
    <a href="#" class="nav-link" onclick="toggleTransactionsDropdown(event)">
        <div class="nav-icon">
            <i class="fas fa-receipt"></i>
        </div>
        <span class="nav-text">{{ __("lang.site_my_transactions") }}</span>
        @if(auth()->user()->transactions()->pending()->count() > 0)
        <span class="nav-notification">{{ auth()->user()->transactions()->pending()->count() }}</span>
        @endif
        <i class="fas fa-chevron-down dropdown-icon"></i>
        <div class="nav-underline"></div>
    </a>
    <div class="dropdown-menu transactions-dropdown" id="transactionsDropdown">
        <div class="dropdown-header">
            <div class="dropdown-title">
                <i class="fas fa-receipt"></i>
                <h4>{{ __("lang.site_my_transactions") }}</h4>
            </div>
            <div class="dropdown-stats">
                <span class="stat-item">
                    <i class="fas fa-euro-sign"></i>
                    €{{ number_format(auth()->user()->transactions()->completed()->sum('amount'), 2) }}
                </span>
            </div>
        </div>
        <div class="dropdown-content">
            <a href="{{ route('transactions.dashboard') }}" 
               class="dropdown-item {{ request()->routeIs('transactions.dashboard') ? 'active' : '' }}">
                <div class="dropdown-item-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="dropdown-item-content">
                    <span class="item-name">{{ __("lang.site_dashboard") }}</span>
                    <span class="item-description">{{ __("lang.site_overview_analytics") }}</span>
                </div>
                <div class="dropdown-item-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            
            <a href="{{ route('transactions.index') }}" 
               class="dropdown-item {{ request()->routeIs('transactions.index') ? 'active' : '' }}">
                <div class="dropdown-item-icon">
                    <i class="fas fa-list"></i>
                </div>
                <div class="dropdown-item-content">
                    <span class="item-name">{{ __("lang.site_all_transactions") }}</span>
                    <span class="item-description">{{ __("lang.site_full_history") }}</span>
                </div>
                <div class="dropdown-item-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            
            <a href="{{ route('transactions.analytics') }}" 
               class="dropdown-item {{ request()->routeIs('transactions.analytics') ? 'active' : '' }}">
                <div class="dropdown-item-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="dropdown-item-content">
                    <span class="item-name">{{ __("lang.site_analytics") }}</span>
                    <span class="item-description">{{ __("lang.site_trends_statistics") }}</span>
                </div>
                <div class="dropdown-item-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            
            @if(auth()->user()->transactions()->completed()->count() > 0)
            <div class="dropdown-divider"></div>
            <a href="{{ route('transactions.index', ['status' => 'completed']) }}" class="dropdown-item">
                <div class="dropdown-item-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="dropdown-item-content">
                    <span class="item-name">{{ __("lang.site_completed_transactions") }}</span>
                    <span class="item-badge success">{{ auth()->user()->transactions()->completed()->count() }}</span>
                </div>
                <div class="dropdown-item-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            @endif
            
            @if(auth()->user()->transactions()->pending()->count() > 0)
            <a href="{{ route('transactions.index', ['status' => 'pending']) }}" class="dropdown-item">
                <div class="dropdown-item-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="dropdown-item-content">
                    <span class="item-name">{{ __("lang.site_pending") }}</span>
                    <span class="item-badge warning">{{ auth()->user()->transactions()->pending()->count() }}</span>
                </div>
                <div class="dropdown-item-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </a>
            @endif
        </div>
    </div>
</li>

<style>
/* Transaction Dropdown Specific Styles */
.nav-notification {
    position: absolute;
    top: -5px;
    right: -5px;
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 0.25rem 0.5rem;
    border-radius: var(--radius-full);
    min-width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(243, 156, 18, 0.7);
    }
    50% {
        transform: scale(1.1);
        box-shadow: 0 0 0 4px rgba(243, 156, 18, 0);
    }
}

.transactions-dropdown {
    min-width: 400px;
    max-width: 450px;
}

.dropdown-header {
    padding: var(--space-5);
    border-bottom: 1px solid var(--border-color);
    background: var(--card-bg-light);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.dropdown-title {
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.dropdown-title i {
    color: var(--accent-color);
    font-size: 1.2rem;
}

.dropdown-title h4 {
    margin: 0;
    font-size: 1.1rem;
    color: var(--text-primary);
    font-weight: 700;
}

.dropdown-stats {
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.stat-item {
    background: rgba(52, 152, 219, 0.1);
    color: var(--accent-color);
    padding: var(--space-1) var(--space-3);
    border-radius: var(--radius-full);
    font-size: 0.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: var(--space-1);
}

.dropdown-content {
    padding: var(--space-3);
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    padding: var(--space-4);
    color: var(--accent-color);
    text-decoration: none;
    border-radius: var(--radius-lg);
    transition: var(--transition-normal);
    margin-bottom: var(--space-2);
    position: relative;
    overflow: hidden;
}

.dropdown-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(52, 152, 219, 0.1), transparent);
    transition: var(--transition-normal);
}

.dropdown-item:hover::before {
    left: 100%;
}

.dropdown-item:hover {
    background: var(--card-bg-light);
    color: var(--text-primary);
    transform: translateX(8px);
    box-shadow: var(--shadow-md);
    text-decoration: none;
}

.dropdown-item.active {
    background: linear-gradient(135deg, rgba(52, 152, 219, 0.1), rgba(44, 128, 182, 0.1));
    color: var(--accent-color);
    border-left: 3px solid var(--accent-color);
}

.dropdown-item-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 35px;
    height: 35px;
    background: rgba(52, 152, 219, 0.1);
    border-radius: var(--radius-lg);
    transition: var(--transition-normal);
    flex-shrink: 0;
}

.dropdown-item:hover .dropdown-item-icon,
.dropdown-item.active .dropdown-item-icon {
    background: var(--accent-color);
    color: var(--text-primary);
    transform: scale(1.1) rotate(5deg);
}

.dropdown-item-icon i {
    color: var(--accent-color);
    font-size: 1rem;
    transition: var(--transition-normal);
}

.dropdown-item:hover .dropdown-item-icon i,
.dropdown-item.active .dropdown-item-icon i {
    color: var(--text-primary);
}

.dropdown-item-icon.success {
    background: rgba(39, 174, 96, 0.1);
}

.dropdown-item-icon.success i {
    color: #27ae60;
}

.dropdown-item-icon.warning {
    background: rgba(243, 156, 18, 0.1);
}

.dropdown-item-icon.warning i {
    color: #f39c12;
}

.dropdown-item:hover .dropdown-item-icon.success {
    background: #27ae60;
}

.dropdown-item:hover .dropdown-item-icon.warning {
    background: #f39c12;
}

.dropdown-item-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: var(--space-1);
    min-width: 0;
}

.item-name {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.95rem;
}

.item-description {
    color: var(--text-secondary);
    font-size: 0.8rem;
    opacity: 0.8;
}

.item-badge {
    background: var(--accent-color);
    color: var(--text-primary);
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    border-radius: var(--radius-full);
    font-weight: 700;
    min-width: 18px;
    text-align: center;
    margin-left: auto;
}

.item-badge.success {
    background: linear-gradient(135deg, #27ae60, #229954);
}

.item-badge.warning {
    background: linear-gradient(135deg, #f39c12, #e67e22);
}

.dropdown-item-arrow {
    margin-left: auto;
    opacity: 0;
    transform: translateX(-10px);
    transition: var(--transition-normal);
    color: var(--text-muted);
    font-size: 0.8rem;
}

.dropdown-item:hover .dropdown-item-arrow,
.dropdown-item.active .dropdown-item-arrow {
    opacity: 1;
    transform: translateX(0);
    color: var(--accent-color);
}

.dropdown-divider {
    border: none;
    height: 1px;
    background: var(--border-color);
    margin: var(--space-2) 0;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .transactions-dropdown {
        min-width: 300px;
        max-width: 350px;
    }
    
    .dropdown-header {
        padding: var(--space-4);
    }
    
    .dropdown-title h4 {
        font-size: 1rem;
    }
    
    .dropdown-item {
        padding: var(--space-3);
        gap: var(--space-3);
    }
    
    .dropdown-item-icon {
        width: 30px;
        height: 30px;
        font-size: 0.9rem;
    }
    
    .item-name {
        font-size: 0.9rem;
    }
    
    .item-description {
        font-size: 0.75rem;
    }
}
</style>

<script>
// Toggle transactions dropdown
function toggleTransactionsDropdown(event) {
    event.preventDefault();
    event.stopPropagation();

    const transactionsDropdown = document.getElementById('transactionsDropdown');
    const navLink = event.currentTarget;
    const dropdownIcon = navLink.querySelector('.dropdown-icon');

    // Close other dropdowns first
    document.querySelectorAll('.dropdown-menu.show').forEach(dropdown => {
        if (dropdown !== transactionsDropdown) {
            dropdown.classList.remove('show');
        }
    });

    transactionsDropdown.classList.toggle('show');
    navLink.classList.toggle('active');

    if (dropdownIcon) {
        dropdownIcon.style.transform = transactionsDropdown.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const navLink = document.querySelector('.nav-item.has-dropdown > .nav-link');
    const transactionsDropdown = document.getElementById('transactionsDropdown');

    if (!transactionsDropdown) return;
    if (transactionsDropdown.contains(event.target) || (navLink && navLink.contains(event.target))) {
        return;
    }

    transactionsDropdown.classList.remove('show');
    if (navLink) navLink.classList.remove('active');
});
</script>
@endauth
