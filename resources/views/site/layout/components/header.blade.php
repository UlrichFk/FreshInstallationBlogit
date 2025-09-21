@php
    $categories_header = \Helpers::getCategoryForSite(0);
@endphp

<header class="site-header">
    <div class="header-container">
        <!-- Header Top Bar -->
        <div class="header-topbar">
            <div class="container">
                <div class="topbar-content">
                    <div class="topbar-left">
                        <div class="topbar-info">
                            <div class="info-item">
                                <i class="fas fa-clock"></i>
                                <span>{{ now()->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-globe"></i>
                                <span>{{ __('lang.website_window_to_democracy') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="topbar-right">
                        <div class="topbar-actions">
                            <div class="header-search">
                                <button class="search-toggle" onclick="openSearch()" aria-label="{{ __("lang.site_search") }}">
                                    <i class="fas fa-search"></i>
                                    <span>{{ __("lang.site_search") }}</span>
                                </button>
                            </div>
                            <div class="header-social">
                                <a href="#" class="social-link" aria-label="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="social-link" aria-label="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="social-link" aria-label="LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                            <div class="header-auth">
                                @auth
                                    <div class="user-profile-mini" onclick="toggleUserDropdown()">
                                        <div class="user-avatar-wrapper">
                                            @if(Auth::user()->profile_image)
                                                <img src="{{ url('uploads/user/'.Auth::user()->profile_image) }}" 
                                                     alt="{{ Auth::user()->name }}" 
                                                     class="user-avatar-mini">
                                            @else
                                                <div class="user-avatar-placeholder">
                                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div class="online-indicator"></div>
                                            @if(Auth::user()->hasActiveSubscription())
                                                <div class="premium-indicator">
                                                    <i class="fas fa-crown"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="user-info-mini">
                                            <span class="user-name">{{ Str::limit(Auth::user()->name, 12) }}</span>
                                            <span class="user-status">
                                                @if(Auth::user()->hasActiveSubscription())
                                                    <i class="fas fa-crown"></i> {{ __('lang.website_premium') }}
                                                @else
                                                    <i class="fas fa-user"></i> {{ __('lang.website_member') }}
                                                @endif
                                            </span>
                                        </div>
                                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                                        
                                        <!-- User Dropdown Menu -->
                                        <div class="user-dropdown-menu" id="userDropdownMenu">
                                            <div class="dropdown-header">
                                                <div class="user-info">
                                                    @if(Auth::user()->profile_image)
                                                        <img src="{{ url('uploads/user/'.Auth::user()->profile_image) }}" 
                                                             alt="{{ Auth::user()->name }}" 
                                                             class="dropdown-avatar">
                                                    @else
                                                        <div class="dropdown-avatar-placeholder">
                                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                    <div class="user-details">
                                                        <h6>{{ Auth::user()->name }}</h6>
                                                        <p>{{ Auth::user()->email }}</p>
                                                        @if(Auth::user()->hasActiveSubscription())
                                                            <span class="premium-badge">
                                                                <i class="fas fa-crown"></i> {{ __('lang.website_member_premium') }}
                                                            </span>
                                                        @else
                                                            <span class="member-badge">
                                                                <i class="fas fa-user"></i> {{ __('lang.website_member_free') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="dropdown-content">
                                                <a href="{{ url('profile') }}" class="dropdown-item">
                                                    <i class="fas fa-user"></i>
                                                    <span>{{ __('lang.website_my_profile') }}</span>
                                                </a>
                                                <a href="{{ url('saved-stories') }}" class="dropdown-item">
                                                    <i class="fas fa-bookmark"></i>
                                                    <span>{{ __('lang.website_saved_stories') }}</span>
                                                </a>
                                                @if(Auth::user()->hasActiveSubscription())
                                                    <a href="{{ url('membership/subscription') }}" class="dropdown-item premium-item">
                                                        <i class="fas fa-crown"></i>
                                                        <span>{{__('lang.website_my_subscription')}}</span>
                                                    </a>
                                                @else
                                                    <a href="{{ url('membership/plans') }}" class="dropdown-item upgrade-item">
                                                        <i class="fas fa-star"></i>
                                                        <span>{{__('lang.website_pass_premium')}}</span>
                                                    </a>
                                                @endif
                                                <a href="{{ route('transactions.index') }}" class="dropdown-item">
                                                    <i class="fas fa-receipt"></i>
                                                    <span>{{__('lang.website_my_transactions')}}</span>
                                                </a>
                                                
                                                <div class="dropdown-divider"></div>
                                                
                                                <a href="{{ url('logout') }}" class="dropdown-item logout-item">
                                                    <i class="fas fa-sign-out-alt"></i>
                                                    <span>{{ __('lang.website_logout') }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="auth-buttons">
                                        <a href="{{ url('login') }}" class="auth-link login">
                                            <i class="fas fa-sign-in-alt"></i>
                                            <span>{{ __('lang.website_login') }}</span>
                                        </a>
                                        <a href="{{ url('signup') }}" class="auth-link signup">
                                            <i class="fas fa-user-plus"></i>
                                            <span>{{ __('lang.website_signup') }}</span>
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Header -->
        <div class="header-main">
            <div class="container">
                <nav class="main-navigation">
                    <!-- Enhanced Brand Logo -->
                    <div class="navbar-brand">
                        <a href="{{ url('/') }}" class="brand-link">
                            <div class="brand-logo-container">
                                <img src="{{ setting('site_logo') ? url('uploads/setting/'.setting('site_logo')) : asset('uploads/no-favicon.png') }}" 
                                     alt="{{ setting('site_name') }}" 
                                     class="brand-logo"
                                     onerror="this.onerror=null;this.src='{{ asset('uploads/no-favicon.png') }}'">
                                <div class="brand-glow"></div>
                            </div>
                            <div class="brand-info">
                                <h3 class="brand-title">{{setting('site_name')}}</h3>
                            </div>
                        </a>
                    </div>

                    <!-- Enhanced Main Navigation Menu -->
                    <div class="navbar-menu">
                        <ul class="nav-list">
                            <li class="nav-item">
                                <a href="{{ url('/') }}" 
                                   class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                                    <div class="nav-icon">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <span class="nav-text">{{ __('lang.website_home') }}</span>
                                    <div class="nav-underline"></div>
                                </a>
                            </li>

                            <!-- Categories Dropdown -->
                            @if($categories_header && count($categories_header))
                                <li class="nav-item has-dropdown">
                                    <a href="#" class="nav-link" onclick="toggleCategoriesDropdown(event)">
                                        <div class="nav-icon">
                                            <i class="fas fa-th-large"></i>
                                        </div>
                                        <span class="nav-text">{{__('lang.website_categories')}}</span>
                                        <i class="fas fa-chevron-down dropdown-icon"></i>
                                        <div class="nav-underline"></div>
                                    </a>
                                    <div class="dropdown-menu categories-dropdown" id="categoriesDropdown">
                                        {{-- <div class="dropdown-header">
                                            <div class="dropdown-title">
                                                <i class="fas fa-th-large"></i>
                                                <h4>Explorez nos catégories</h4>
                                            </div>
                                            <a href="{{ url('all-blogs') }}" class="view-all">
                                                {{ __("lang.site_see_all") }} <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div> --}}
                                        <div class="dropdown-content">
                                            @foreach($categories_header as $category)
                                                <a href="{{ url('category/'.$category->slug) }}" 
                                                   class="dropdown-item {{ Request::is('category/'.$category->slug.'*') ? 'active' : '' }}">
                                                    <div class="dropdown-item-icon">
                                                        <i class="fas fa-folder"></i>
                                                    </div>
                                                    <div class="dropdown-item-content">
                                                        <span class="category-name">{{ $category->name }}</span>
                                                        @if($category->sub_category && count($category->sub_category))
                                                            <div class="subcategories">
                                                                @foreach($category->sub_category->take(3) as $sub_category)
                                                                    <a href="{{ url('category/'.$category->slug.'/'.$sub_category->slug) }}" 
                                                                       class="subcategory-link">
                                                                        {{ $sub_category->name }}
                                                                    </a>
                                                                @endforeach
                                                                @if(count($category->sub_category) > 3)
                                                                    <span class="more-subcategories">+{{ count($category->sub_category) - 3 }} {{__('lang.website_others')}}</span>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="dropdown-item-arrow">
                                                        <i class="fas fa-chevron-right"></i>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                            @endif

                            <!-- About Us -->
                            <li class="nav-item">
                                <a href="{{ url('about-us') }}" 
                                   class="nav-link {{ Request::is('about-us*') ? 'active' : '' }}">
                                    <div class="nav-icon">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <span class="nav-text">{{__('lang.website_about_us')}}</span>
                                    <div class="nav-underline"></div>
                                </a>
                            </li>

                            <!-- Contact Us -->
                            <li class="nav-item">
                                <a href="{{ url('contact-us') }}" 
                                   class="nav-link {{ Request::is('contact-us*') ? 'active' : '' }}">
                                    <div class="nav-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <span class="nav-text">{{__('lang.website_contact')}}</span>
                                    <div class="nav-underline"></div>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Enhanced Action Buttons -->
                    <div class="navbar-actions">
                        <a href="{{ url('membership/plans') }}" class="action-btn premium-btn">
                            <div class="btn-icon">
                                <i class="fas fa-crown"></i>
                            </div>
                            <span>{{__('lang.website_premium')}}</span>
                            <div class="btn-glow"></div>
                        </a>
                        <a href="{{ url('donation') }}" class="action-btn donate-btn">
                            <div class="btn-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <span>{{__('lang.website_support')}}</span>
                            <div class="btn-glow"></div>
                        </a>
                    </div>

                    <!-- Enhanced Mobile Menu Toggle -->
                    <button class="mobile-toggle" onclick="toggleMobileMenu()" aria-label="Menu mobile">
                        <div class="hamburger-container">
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                        </div>
                    </button>
                </nav>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Navigation -->
<div class="mobile-nav" id="mobile-nav">
    <div class="mobile-nav-overlay" onclick="toggleMobileMenu()"></div>
    <div class="mobile-nav-panel">
        <div class="mobile-nav-header">
            <a href="{{ url('/') }}" class="mobile-brand">
                <img src="{{ setting('site_logo') ? url('uploads/setting/'.setting('site_logo')) : asset('uploads/no-favicon.png') }}" 
                     alt="{{ setting('site_name') }}"
                     onerror="this.onerror=null;this.src='{{ asset('uploads/no-favicon.png') }}'">
                <span>{{ setting('site_name') }}</span>
            </a>
            <button class="mobile-close" onclick="toggleMobileMenu()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="mobile-nav-content">
            <ul class="mobile-nav-menu">
                <li>
                    <a href="{{ url('/') }}" class="mobile-nav-link">
                        <i class="fas fa-home"></i>
                        <span>{{ __('lang.website_home') }}</span>
                    </a>
                </li>
                
                <!-- Categories Section -->
                @if($categories_header && count($categories_header))
                    <li class="mobile-nav-item">
                        <div class="mobile-nav-expandable">
                            <a href="#" class="mobile-nav-link">
                                <i class="fas fa-th-large"></i>
                                <span>{{__('lang.website_categories')}}</span>
                            </a>
                            <button class="mobile-expand-btn" onclick="toggleMobileSubmenu(this)">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <ul class="mobile-submenu">
                            @foreach($categories_header as $category)
                                <li>
                                    <a href="{{ url('category/'.$category->slug) }}" 
                                       class="mobile-submenu-link {{ Request::is('category/'.$category->slug.'*') ? 'active' : '' }}">
                                        <i class="fas fa-folder"></i>
                                        <span>{{ $category->name }}</span>
                                        @if($category->sub_category && count($category->sub_category))
                                            <span class="subcategory-count">({{ count($category->sub_category) }})</span>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
                
                <li>
                    <a href="{{ url('all-blogs') }}" class="mobile-nav-link">
                        <i class="fas fa-newspaper"></i>
                        <span>{{ __('lang.website_all_blogs') }}</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ url('about-us') }}" class="mobile-nav-link">
                        <i class="fas fa-info-circle"></i>
                        <span>{{__('lang.website_about_us')}}</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ url('contact-us') }}" class="mobile-nav-link">
                        <i class="fas fa-envelope"></i>
                        <span>{{__('lang.website_contact')}}</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ url('membership/plans') }}" class="mobile-nav-link premium-mobile">
                        <i class="fas fa-crown"></i>
                        <span>{{__('lang.website_pass_premium')}}</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ url('donation') }}" class="mobile-nav-link donate-mobile">
                        <i class="fas fa-heart"></i>
                        <span>{{__('lang.website_support')}}</span>
                    </a>
                </li>
            </ul>
            
            <div class="mobile-nav-footer">
                @auth
                    <div class="mobile-user-card">
                        @if(Auth::user()->profile_image)
                            <img src="{{ url('uploads/user/'.Auth::user()->profile_image) }}" 
                                 alt="{{ Auth::user()->name }}" 
                                 class="mobile-user-avatar">
                        @else
                            <div class="mobile-user-avatar-placeholder">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="mobile-user-info">
                            <h6>{{ Auth::user()->name }}</h6>
                            <span>{{ Auth::user()->email }}</span>
                            @if(Auth::user()->hasActiveSubscription())
                                <span class="mobile-premium-badge">
                                    <i class="fas fa-crown"></i> <span>{{__('lang.website_premium')}}</span>
                                </span>
                            @else
                                <span class="mobile-member-badge">
                                    <i class="fas fa-user"></i> <span>{{__('lang.website_member')}}</span>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="mobile-user-actions">
                        <a href="{{ url('profile') }}" class="mobile-action-btn">
                            <i class="fas fa-user"></i>
                            {{__('lang.website_my_profile')}}
                        </a>
                        <a href="{{ url('logout') }}" class="mobile-action-btn logout">
                            <i class="fas fa-sign-out-alt"></i>
                            {{__('lang.website_logout')}}
                        </a>
                    </div>
                @else
                    <div class="mobile-auth-actions">
                        <a href="{{ url('login') }}" class="mobile-action-btn primary">
                            <i class="fas fa-sign-in-alt"></i>
                            {{__('lang.website_login')}}
                        </a>
                        <a href="{{ url('signup') }}" class="mobile-action-btn outline">
                            <i class="fas fa-user-plus"></i>
                            {{__('lang.website_signup')}}
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>

<style>
/* ==============================================
   MODERN HEADER STYLES
   ============================================== */
   
/* Container for header */
.site-header .container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 var(--space-4);
}   

/* Body padding to compensate fixed header */
body {
    padding-top: 40px; /* 60px (topbar) + 80px (main header) */
}

body.header-main-only {
    padding-top: 80px; /* Only main header */
}

body.header-scrolled {
    padding-top: 0; /* No header visible */
}

.site-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background: white;
    box-shadow: var(--shadow-lg);
    /*border-bottom: 1px solid var(--border-color);*/
    transition: transform 0.3s ease;
}

.site-header.header-scrolled {
    transform: translateY(-100%);
}

.site-header.header-main-only {
    transform: translateY(-60px); /* Hauteur de la topbar */
}

/* Mobile adjustments for header states */
@media (max-width: 768px) {
    .site-header.header-main-only {
        transform: translateY(-50px); /* Mobile topbar height */
    }
}

@media (max-width: 480px) {
    .site-header.header-main-only {
        transform: translateY(-45px); /* Small mobile topbar height */
    }
}

/* Header Top Bar */
.header-topbar {
    background: linear-gradient(135deg, #2c3e50, #34495e);
    color: white;
    padding: var(--space-3) 0;
    font-size: 0.9rem;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1002;
    /*border-bottom: 1px solid rgba(255, 255, 255, 0.1);*/
    height: 60px;
    display: flex;
    align-items: center;
}

.topbar-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.topbar-left .topbar-info {
    display: flex;
    align-items: center;
    gap: var(--space-6);
}

.info-item {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.85rem;
    padding: var(--space-1) var(--space-3);
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--radius-lg);
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: var(--transition-fast);
}

.info-item:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.2);
    transform: translateY(-1px);
}

.info-item i {
    color: var(--accent-color);
    font-size: 0.9rem;
}

.topbar-right .topbar-actions {
    display: flex;
    align-items: center;
    gap: var(--space-4);
}

.header-search .search-toggle {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-lg);
    cursor: pointer;
    transition: var(--transition-fast);
    font-weight: 500;
}

.search-toggle:hover {
    background: var(--accent-color);
    border-color: var(--accent-color);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(32, 148, 239, 0.3);
}

.header-social {
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    border-radius: var(--radius-full);
    text-decoration: none;
    transition: var(--transition-fast);
}

.social-link:hover {
    background: var(--accent-color);
    border-color: var(--accent-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(32, 148, 239, 0.3);
}

.header-auth .auth-buttons {
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.auth-link {
    color: white;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-lg);
    font-weight: 500;
    transition: var(--transition-fast);
    border: 1px solid transparent;
}

.auth-link.login {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.2);
}

.auth-link.signup {
    background: var(--accent-color);
    border-color: var(--accent-color);
}

.auth-link:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.auth-link.login:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
}

.auth-link.signup:hover {
    background: var(--accent-secondary);
    border-color: var(--accent-secondary);
}

.user-profile-mini {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-2) var(--space-3);
    transition: var(--transition-fast);
    cursor: pointer;
    position: relative;
}

.user-profile-mini:hover {
    transform: translateY(-1px);
}

.user-avatar-wrapper {
    position: relative;
}

.user-avatar-mini {
    width: 45px;
    height: 45px;
    border-radius: var(--radius-full);
    border: 2px solid rgba(255, 255, 255, 0.3);
    object-fit: cover;
}

.user-avatar-placeholder {
    width: 45px;
    height: 45px;
    border-radius: var(--radius-full);
    border: 2px solid rgba(255, 255, 255, 0.3);
    background: var(--gradient-accent);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    font-weight: 700;
    text-transform: uppercase;
}

.online-indicator {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 10px;
    height: 10px;
    background: #27ae60;
    border: 2px solid white;
    border-radius: var(--radius-full);
}

.premium-indicator {
    position: absolute;
    top: -2px;
    left: -2px;
    width: 20px;
    height: 20px;
    background: linear-gradient(135deg, #f39c12, #e67e22);
    border: 2px solid white;
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.7rem;
    animation: premiumPulse 2s infinite;
}

@keyframes premiumPulse {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(243, 156, 18, 0.7);
    }
    50% {
        transform: scale(1.1);
        box-shadow: 0 0 0 4px rgba(243, 156, 18, 0);
    }
}

.user-info-mini {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.user-name {
    font-weight: 600;
    color: white;
    font-size: 0.9rem;
}

.user-status {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.dropdown-arrow {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.8rem;
    transition: var(--transition-fast);
}

.user-profile-mini.active .dropdown-arrow {
    transform: rotate(180deg);
    color: var(--accent-color);
}

/* Main Header */
.header-main {
    background: white;
    padding: var(--space-3) 0;
    position: fixed;
    top: 60px;         /* exactly below the top-bar */
    left: 0;
    right: 0;
    z-index: 1001;
    height: 80px;
    display: flex;
    align-items: center;
}

.main-navigation {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: var(--space-6);
    position: relative;
}

/* Enhanced Brand */
.navbar-brand {
    flex-shrink: 0;
    min-width: 200px;
}

.navbar-brand .brand-link {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    text-decoration: none;
    color: var(--text-primary);
    transition: var(--transition-normal);
    padding: var(--space-2);
    border-radius: var(--radius-lg);
    position: relative;
    overflow: hidden;
}

.navbar-brand .brand-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(52, 152, 219, 0.1), transparent);
    transition: var(--transition-normal);
}

.navbar-brand .brand-link:hover::before {
    left: 100%;
}

.navbar-brand .brand-link:hover {
    transform: translateY(-2px);
}

.brand-logo-container {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.brand-logo {
    height: 55px;
    width: auto;
    border-radius: var(--radius-lg);
    transition: var(--transition-normal);
    position: relative;
    z-index: 2;
}

.brand-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 60px;
    height: 60px;
    background: radial-gradient(circle, rgba(52, 152, 219, 0.3) 0%, transparent 70%);
    border-radius: var(--radius-full);
    transform: translate(-50%, -50%);
    opacity: 0;
    transition: var(--transition-normal);
    animation: brandGlow 3s ease-in-out infinite;
}

@keyframes brandGlow {
    0%, 100% { opacity: 0; transform: translate(-50%, -50%) scale(0.8); }
    50% { opacity: 1; transform: translate(-50%, -50%) scale(1.2); }
}

.navbar-brand .brand-link:hover .brand-glow {
    opacity: 1;
    animation-play-state: running;
}

.brand-info {
    display: flex;
    flex-direction: column;
    gap: var(--space-1);
}

.brand-title {
    font-size: 1.6rem;
    font-weight: 800;
    color: var(--text-primary);
    margin: 0;
    line-height: 1.2;
    background: var(--gradient-accent);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    transition: var(--transition-normal);
}

.brand-subtitle {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-weight: 500;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    opacity: 0.8;
    transition: var(--transition-normal);
}

.navbar-brand .brand-link:hover .brand-title {
    transform: scale(1.05);
}

.navbar-brand .brand-link:hover .brand-subtitle {
    color: var(--accent-color);
    opacity: 1;
}

/* User Dropdown Menu */
.user-dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    min-width: 320px;
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-xl);
    border: 1px solid var(--border-color);
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: var(--transition-normal);
    z-index: 1000;
    margin-top: var(--space-2);
}

.user-dropdown-menu.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
    animation: dropdownSlideIn 0.3s ease-out;
}

@keyframes dropdownSlideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.dropdown-header {
    padding: var(--space-5);
    border-bottom: 1px solid var(--border-color);
    background: var(--bg-light);
    border-radius: var(--radius-lg) var(--radius-lg) 0 0;
}

.dropdown-header .user-info {
    display: flex;
    align-items: center;
    gap: var(--space-4);
}

.dropdown-avatar {
    width: 60px;
    height: 60px;
    border-radius: var(--radius-full);
    border: 3px solid var(--accent-color);
    object-fit: cover;
}

.dropdown-avatar-placeholder {
    width: 60px;
    height: 60px;
    border-radius: var(--radius-full);
    border: 3px solid var(--accent-color);
    background: var(--gradient-accent);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.8rem;
    font-weight: 700;
    text-transform: uppercase;
}

.user-details h6 {
    margin: 0 0 var(--space-1);
    color: var(--text-primary);
    font-weight: 600;
    font-size: 1.1rem;
}

.user-details p {
    margin: 0 0 var(--space-2);
    color: var(--text-muted);
    font-size: 0.9rem;
}

.premium-badge {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: var(--radius-full);
    font-size: 0.75rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.member-badge {
    background: linear-gradient(135deg, #95a5a6, #7f8c8d);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: var(--radius-full);
    font-size: 0.75rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.dropdown-content {
    padding: var(--space-2);
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-3) var(--space-4);
    color: var(--text-secondary);
    text-decoration: none;
    border-radius: var(--radius-md);
    transition: var(--transition-fast);
    font-size: 0.9rem;
}

.dropdown-item:hover {
    background: var(--bg-light);
    color: var(--text-primary);
    transform: translateX(5px);
}

.dropdown-item i {
    width: 16px;
    text-align: center;
    opacity: 0.7;
}

.dropdown-divider {
    border: none;
    height: 1px;
    background: var(--border-color);
    margin: var(--space-2) 0;
}

.premium-item {
    background: linear-gradient(135deg, rgba(243, 156, 18, 0.1), rgba(230, 126, 34, 0.1));
    border-left: 3px solid #f39c12;
}

.upgrade-item {
    background: linear-gradient(135deg, rgba(52, 152, 219, 0.1), rgba(44, 128, 182, 0.1));
    border-left: 3px solid var(--accent-color);
}

.logout-item {
    color: var(--danger-color);
}

.logout-item:hover {
    background: rgba(231, 76, 60, 0.1);
    color: var(--danger-color);
}

/*.brand-info h3 {*/
/*    color: black !important;*/
/*}*/

.brand-subtitle {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-weight: 500;
}

/* Enhanced Navigation Menu - Centered between brand and actions */
.navbar-menu {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    justify-content: center;
    z-index: 10;
}

.nav-list {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-item {
    position: relative;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-3) var(--space-4);
    color: var(--accent-color);
    text-decoration: none;
    font-weight: 600;
    border-radius: var(--radius-lg);
    transition: var(--transition-normal);
    white-space: nowrap;
    position: relative;
    overflow: hidden;
    background: transparent;
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

.nav-link:hover,
.nav-link.active {
    background: var(--accent-color);
    color: white;
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.nav-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    border-radius: var(--radius-md);
    background: rgba(52, 152, 219, 0.1);
    transition: var(--transition-normal);
}

.nav-link:hover .nav-icon,
.nav-link.active .nav-icon {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.1) rotate(5deg);
}

.nav-icon i {
    font-size: 0.9rem;
    color: var(--accent-color);
    transition: var(--transition-normal);
}

.nav-link:hover .nav-icon i,
.nav-link.active .nav-icon i {
    color: white;
}

.nav-text {
    font-size: 0.9rem;
    font-weight: 600;
    letter-spacing: 0.3px;
    transition: var(--transition-normal);
}

.nav-underline {
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 3px;
    background: var(--accent-color);
    border-radius: var(--radius-full);
    transform: translateX(-50%);
    transition: var(--transition-normal);
}

.nav-link:hover .nav-underline,
.nav-link.active .nav-underline {
    width: 80%;
}

.dropdown-icon {
    font-size: 0.7rem;
    transition: var(--transition-normal);
    margin-left: var(--space-1);
}

.has-dropdown:hover .dropdown-icon {
    transform: rotate(180deg);
    color: var(--accent-color);
}

/* Enhanced Dropdown Menu */
.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    min-width: 320px;
    background: var(--card-bg);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-2xl);
    border: 1px solid var(--border-color);
    opacity: 0;
    visibility: hidden;
    transform: translateY(15px) scale(0.95);
    transition: var(--transition-normal);
    z-index: 1000;
    backdrop-filter: blur(20px);
    overflow: hidden;
}

/* Categories Dropdown Specific Styles */
.categories-dropdown {
    min-width: 450px;
    max-width: 500px;
}

.categories-dropdown .dropdown-content {
    max-height: 400px;
    overflow-y: auto;
    padding: var(--space-3);
}

.categories-dropdown .dropdown-item {
    padding: var(--space-4);
    border-radius: var(--radius-lg);
    margin-bottom: var(--space-2);
    transition: var(--transition-normal);
    position: relative;
    overflow: hidden;
}

.categories-dropdown .dropdown-item:hover {
    background: var(--card-bg-light);
    transform: translateX(8px);
    box-shadow: var(--shadow-md);
}

.categories-dropdown .dropdown-item.active {
    background: linear-gradient(135deg, rgba(52, 152, 219, 0.1), rgba(44, 128, 182, 0.1));
    border-left: 3px solid var(--accent-color);
}

.dropdown-item-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
}

.category-name {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 1rem;
}

.subcategories {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-2);
    margin-top: var(--space-1);
}

.subcategory-link {
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.8rem;
    padding: var(--space-1) var(--space-2);
    background: var(--bg-light);
    border-radius: var(--radius-md);
    transition: var(--transition-fast);
    border: 1px solid var(--border-color);
}

.subcategory-link:hover {
    background: var(--accent-color);
    color: white;
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}

.more-subcategories {
    color: var(--text-muted);
    font-size: 0.75rem;
    font-style: italic;
    padding: var(--space-1) var(--space-2);
    background: var(--bg-light);
    border-radius: var(--radius-md);
    border: 1px dashed var(--border-color);
}

.dropdown-menu::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--gradient-accent);
}

.has-dropdown:hover .dropdown-menu:not(.show) {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
}

/* Make JS-toggled dropdowns visible */
.dropdown-menu.show {
    opacity: 1 !important;
    visibility: visible !important;
    transform: translateY(0) scale(1) !important;
    display: block !important;
}

/* Force dropdown visibility when show class is present */
.categories-dropdown.show {
    opacity: 1 !important;
    visibility: visible !important;
    transform: translateY(0) scale(1) !important;
    pointer-events: auto !important;
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

.dropdown-header h4 {
    margin: 0;
    font-size: 1.2rem;
    color: var(--text-primary);
    font-weight: 700;
}

.view-all {
    color: var(--accent-color);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-lg);
    transition: var(--transition-normal);
    background: rgba(52, 152, 219, 0.1);
}

.view-all:hover {
    background: var(--accent-color);
    color: white;
    transform: translateX(3px);
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
}

.dropdown-item-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: rgba(52, 152, 219, 0.1);
    border-radius: var(--radius-md);
    transition: var(--transition-normal);
}

.dropdown-item:hover .dropdown-item-icon {
    background: var(--accent-color);
    transform: scale(1.1) rotate(5deg);
}

.dropdown-item-icon i {
    color: var(--accent-color);
    font-size: 0.9rem;
    transition: var(--transition-normal);
}

.dropdown-item:hover .dropdown-item-icon i {
    color: white;
}

.dropdown-item-arrow {
    margin-left: auto;
    opacity: 0;
    transform: translateX(-10px);
    transition: var(--transition-normal);
}

.dropdown-item:hover .dropdown-item-arrow {
    opacity: 1;
    transform: translateX(0);
}

.dropdown-item-arrow i {
    color: var(--text-muted);
    font-size: 0.8rem;
    transition: var(--transition-fast);
}

.dropdown-item:hover .dropdown-item-arrow i {
    color: var(--accent-color);
    transform: translateX(3px);
}

/* Enhanced Action Buttons */
.navbar-actions {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    flex-shrink: 0;
    min-width: 200px;
    justify-content: flex-end;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-3) var(--space-5);
    border-radius: var(--radius-xl);
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9rem;
    transition: var(--transition-normal);
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-md);
    border: 2px solid transparent;
}

.action-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: var(--transition-normal);
}

.action-btn:hover::before {
    left: 100%;
}

.btn-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: var(--radius-md);
    background: rgba(255, 255, 255, 0.2);
    transition: var(--transition-normal);
    position: relative;
    z-index: 2;
}

.action-btn:hover .btn-icon {
    transform: scale(1.2) rotate(10deg);
    background: rgba(255, 255, 255, 0.3);
}

.btn-icon i {
    font-size: 1rem;
    color: white;
    transition: var(--transition-normal);
}

.btn-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
    border-radius: var(--radius-full);
    transform: translate(-50%, -50%);
    transition: var(--transition-normal);
    opacity: 0;
}

.action-btn:hover .btn-glow {
    width: 100px;
    height: 100px;
    opacity: 1;
}

.premium-btn {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    border-color: #f39c12;
}

.premium-btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(243, 156, 18, 0.4);
    border-color: #e67e22;
    color: white;
}

.donate-btn {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    border-color: #e74c3c;
}

.donate-btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(231, 76, 60, 0.4);
    border-color: #c0392b;
    color: white;
}

.login-btn {
    background: var(--accent-color);
    color: white;
}

.login-btn:hover {
    background: var(--accent-secondary);
}

/* User Menu */
.user-menu {
    position: relative;
}

.user-toggle {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    background: transparent;
    border: 2px solid var(--border-color);
    padding: var(--space-2);
    border-radius: var(--radius-lg);
    cursor: pointer;
    transition: var(--transition-fast);
}

.user-toggle:hover {
    border-color: var(--accent-color);
}

.user-avatar {
    width: 35px;
    height: 35px;
    border-radius: var(--radius-full);
}

.user-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    min-width: 320px;
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-xl);
    border: 1px solid var(--border-color);
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: var(--transition-normal);
    z-index: 100;
}

.user-menu:hover .user-dropdown {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

/* Make JS-toggled user dropdown visible */
.user-dropdown.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.user-dropdown-header {
    padding: var(--space-5);
    border-bottom: 1px solid var(--border-light);
    display: flex;
    align-items: center;
    gap: var(--space-4);
    background: var(--bg-light);
    border-radius: var(--radius-lg) var(--radius-lg) 0 0;
}

.user-avatar-large {
    width: 60px;
    height: 60px;
    border-radius: var(--radius-full);
    border: 3px solid var(--accent-color);
}

.user-info h5 {
    margin: 0 0 var(--space-1);
    color: var(--text-primary);
    font-weight: 600;
}

.user-info p {
    margin: 0 0 var(--space-2);
    color: var(--text-muted);
    font-size: 0.9rem;
}

.premium-badge {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: var(--radius-full);
    font-size: 0.75rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.user-dropdown-menu {
    padding: var(--space-2);
}

.dropdown-divider {
    border: none;
    height: 1px;
    background: var(--border-light);
    margin: var(--space-2) 0;
}

.premium-item {
    background: linear-gradient(135deg, rgba(243, 156, 18, 0.1), rgba(230, 126, 34, 0.1));
    border-left: 3px solid #f39c12;
}

.upgrade-item {
    background: linear-gradient(135deg, rgba(52, 152, 219, 0.1), rgba(44, 128, 182, 0.1));
    border-left: 3px solid var(--accent-color);
}

.logout-item {
    color: var(--danger-color);
}

.logout-item:hover {
    background: rgba(231, 76, 60, 0.1);
    color: var(--danger-color);
}

/* Enhanced Mobile Toggle */
.mobile-toggle {
    display: none;
    justify-content: center;
    align-items: center;
    width: 50px;
    height: 50px;
    background: var(--card-bg);
    border: 2px solid var(--border-color);
    border-radius: var(--radius-xl);
    cursor: pointer;
    transition: var(--transition-normal);
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-md);
}

.mobile-toggle::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(52, 152, 219, 0.1), transparent);
    transition: var(--transition-normal);
}

.mobile-toggle:hover::before {
    left: 100%;
}

.mobile-toggle:hover {
    border-color: var(--accent-color);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.hamburger-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 4px;
    transition: var(--transition-normal);
}

.hamburger-line {
    width: 22px;
    height: 3px;
    background: var(--text-secondary);
    border-radius: var(--radius-full);
    transition: var(--transition-normal);
    position: relative;
}

.hamburger-line::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--accent-color);
    border-radius: var(--radius-full);
    transform: scaleX(0);
    transition: var(--transition-normal);
    transform-origin: left;
}

.mobile-toggle:hover .hamburger-line::before {
    transform: scaleX(1);
}

.mobile-toggle.active {
    background: var(--accent-color);
    border-color: var(--accent-color);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
}

.mobile-toggle.active .hamburger-line {
    background: white;
}

.mobile-toggle.active .hamburger-line:nth-child(1) {
    transform: rotate(45deg) translate(6px, 6px);
}

.mobile-toggle.active .hamburger-line:nth-child(2) {
    opacity: 0;
    transform: translateX(-20px);
}

.mobile-toggle.active .hamburger-line:nth-child(3) {
    transform: rotate(-45deg) translate(6px, -6px);
}

/* ==============================================
   MOBILE NAVIGATION
   ============================================== */

.mobile-nav {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    z-index: 2000;
    opacity: 0;
    visibility: hidden;
    transition: var(--transition-normal);
}

.mobile-nav.active {
    opacity: 1;
    visibility: visible;
}

.mobile-nav-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
}

.mobile-nav-panel {
    position: absolute;
    top: 0;
    right: 0;
    width: 350px;
    height: 100%;
    background: white;
    transform: translateX(100%);
    transition: var(--transition-normal);
    overflow-y: auto;
}

.mobile-nav.active .mobile-nav-panel {
    transform: translateX(0);
}

.mobile-nav-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: var(--space-4) var(--space-5);
    border-bottom: 1px solid var(--border-color);
    background: #16213e;
}

.mobile-nav-header > a > span {
    color: white;
}

.mobile-brand {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    text-decoration: none;
    color: var(--accent-color);
    font-weight: 700;
}

.mobile-brand img {
    height: 35px;
    border-radius: var(--radius-md);
}

.mobile-close {
    width: 40px;
    height: 40px;
    background: var(--danger-color);
    color: white;
    border: none;
    border-radius: var(--radius-full);
    cursor: pointer;
    transition: var(--transition-fast);
}

.mobile-close:hover {
    background: #c0392b;
    transform: scale(1.1);
}

.mobile-nav-content {
    display: flex;
    flex-direction: column;
    height: calc(100% - 65px);
}

.mobile-nav-menu {
    flex: 1;
    list-style: none;
    margin: 0;
    padding: var(--space-4) 0;
}

.mobile-nav-item {
    margin-bottom: var(--space-2);
}

.mobile-nav-expandable {
    display: flex;
    align-items: center;
}

.mobile-nav-expandable .mobile-nav-link {
    flex: 1;
}

.mobile-expand-btn {
    width: 40px;
    height: 40px;
    background: transparent;
    border: none;
    color: var(--text-muted);
    cursor: pointer;
    transition: var(--transition-fast);
}

.mobile-expand-btn:hover {
    color: var(--accent-color);
}

.mobile-nav-link {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-3) var(--space-5);
    color: var(--accent-color);
    text-decoration: none;
    transition: var(--transition-fast);
}

.mobile-nav-link:hover {
    background: var(--accent-color);
    color: var(--text-primary);
    transform: translateX(5px);
}

.mobile-nav-link i {
    width: 20px;
    text-align: center;
    opacity: 0.8;
}

.mobile-submenu {
    list-style: none;
    margin: 0;
    padding: 0;
    background: var(--bg-light);
    border-left: 3px solid var(--accent-color);
    margin-left: var(--space-5);
    margin-right: var(--space-3);
    border-radius: 0 var(--radius-md) var(--radius-md) 0;
    max-height: 0;
    overflow: hidden;
    transition: var(--transition-normal);
}

.mobile-submenu.active {
    max-height: 500px;
    padding: var(--space-2) 0;
}

.mobile-submenu-link {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-2) var(--space-4);
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.9rem;
    transition: var(--transition-fast);
}

.mobile-submenu-link:hover {
    background: white;
    color: var(--text-primary);
}

.mobile-submenu-link.active {
    background: var(--accent-color);
    color: white;
}

.subcategory-count {
    color: var(--text-muted);
    font-size: 0.8rem;
    margin-left: auto;
}

.mobile-submenu-link.active .subcategory-count {
    color: rgba(255, 255, 255, 0.8);
}

.premium-mobile {
    background: linear-gradient(135deg, rgba(243, 156, 18, 0.1), rgba(230, 126, 34, 0.1)) !important;
    border-left: 3px solid #f39c12 !important;
    color: #f39c12 !important;
}

.donate-mobile {
    background: linear-gradient(135deg, rgba(231, 76, 60, 0.1), rgba(192, 57, 43, 0.1)) !important;
    border-left: 3px solid var(--danger-color) !important;
    color: var(--danger-color) !important;
}

.mobile-nav-footer {
    padding: var(--space-5);
    border-top: 1px solid var(--border-color);
    background: #16213e;
}

.mobile-user-card {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    margin-bottom: var(--space-4);
}

.mobile-user-avatar {
    width: 50px;
    height: 50px;
    border-radius: var(--radius-full);
    border: 2px solid var(--accent-color);
}

.mobile-user-avatar-placeholder {
    width: 50px;
    height: 50px;
    border-radius: var(--radius-full);
    border: 2px solid var(--accent-color);
    background: var(--gradient-accent);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
    text-transform: uppercase;
}

.mobile-premium-badge {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: var(--radius-full);
    font-size: 0.7rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    margin-top: 0.25rem;
}

.mobile-member-badge {
    background: linear-gradient(135deg, #95a5a6, #7f8c8d);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: var(--radius-full);
    font-size: 0.7rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    margin-top: 0.25rem;
}

.mobile-user-info h6 {
    margin: 0 0 var(--space-1);
    color: var(--text-primary);
    font-weight: 600;
}

.mobile-user-info span {
    color: var(--text-muted);
    font-size: 0.9rem;
}

.mobile-user-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-3);
}

.mobile-auth-actions {
    display: grid;
    gap: var(--space-3);
}

.mobile-action-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-2);
    padding: var(--space-3);
    border-radius: var(--radius-lg);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: var(--transition-fast);
    text-align: center;
}

.mobile-action-btn.primary {
    background: var(--accent-color);
    color: white;
}

.mobile-action-btn.outline {
    background: transparent;
    color: var(--accent-color);
    border: 2px solid var(--accent-color);
}

.mobile-action-btn.logout {
    background: var(--danger-color);
    color: white;
}

.mobile-action-btn:not(.primary):not(.outline):not(.logout) {
    background: var(--bg-secondary);
    color: var(--text-secondary);
}

.mobile-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* ==============================================
   RESPONSIVE DESIGN
   ============================================== */

@media (max-width: 1200px) {
    .site-header .container {
        max-width: 95%;
    }
    
    .topbar-info {
        gap: var(--space-4);
    }
    
    .info-item span:last-child {
        display: none;
    }
    
    .navbar-menu {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .nav-link span {
        display: none;
    }
    
    .nav-link i {
        font-size: 1.1rem;
    }
    
    .categories-dropdown {
        min-width: 350px;
        max-width: 450px;
    }
    
    .categories-dropdown .dropdown-item {
        padding: var(--space-3);
    }
    
    .subcategories {
        gap: var(--space-1);
    }
    
    .subcategory-link {
        font-size: 0.75rem;
        padding: var(--space-1);
    }
}

@media (max-width: 992px) {
    .navbar-menu,
    .navbar-actions {
        display: none;
    }
    
    .mobile-toggle {
        display: flex;
    }
    
    .main-navigation {
        gap: var(--space-4);
    }
    
    .navbar-brand {
        min-width: 150px;
    }
}

@media (max-width: 768px) {
    .site-header .container {
        padding: 0 var(--space-3);
    }
    
    body {
        padding-top: 60px; /* Reduced padding for mobile */
    }
    
    body.header-top-hidden,
    body.header-main-only {
        padding-top: 60px; /* Only main header on mobile */
    }

    .header-topbar {
        display: none;/* Even smaller height on small mobile */
    }
    
    .header-main {
        position: fixed;
        top: 0;         /* exactly below the top-bar */
        left: 0;
        right: 0;
        height: 65px; /* Even smaller height on small mobile */
    }
    
    .topbar-content {
        flex-direction: column;
        gap: var(--space-3);
    }
    
    .topbar-info {
        justify-content: center;
        gap: var(--space-3);
    }
    
    .topbar-actions {
        justify-content: center;
        gap: var(--space-3);
    }
    
    .header-social {
        display: none;
    }
    
    .auth-buttons {
        gap: var(--space-2);
    }
    
    .auth-link span {
        display: none;
    }
    
    .user-profile-mini {
        padding: var(--space-1) var(--space-2);
    }
    
    .user-info-mini {
        display: none;
    }
    
    .dropdown-arrow {
        display: none;
    }
    
    .user-dropdown-menu {
        min-width: 280px;
        right: -10px;
    }
    
    .brand-subtitle {
        display: none;
    }
    
    .mobile-nav-panel {
        width: 100%;
    }
}

@media (max-width: 540px) {
    body {
        padding-top: 40px; /* Further reduced padding for small mobile */
    }

    .header-topbar {
        display: none;/* Even smaller height on small mobile */
    }
    
    .header-main {
        position: fixed;
        top: 0;         /* exactly below the top-bar */
        left: 0;
        right: 0;
        height: 65px; /* Even smaller height on small mobile */
    }
}

@media (max-width: 480px) {
    .site-header .container {
        padding: 0 var(--space-3);
    }
    
    body {
        padding-top: 40px; /* Further reduced padding for small mobile */
    }
    
    body.header-top-hidden,
    body.header-main-only {
        padding-top: 50px; /* Only main header on small mobile */
    }
    
    .header-topbar {
        display: none;/* Even smaller height on small mobile */
    }
    
    .header-main {
        position: fixed;
        top: 0;         /* exactly below the top-bar */
        left: 0;
        right: 0;
        height: 65px; /* Even smaller height on small mobile */
    }
    
    .topbar-info {
        flex-direction: column;
        gap: var(--space-2);
    }
    
    .info-item {
        padding: var(--space-1) var(--space-2);
        font-size: 0.8rem;
    }
    
    .topbar-actions {
        flex-direction: column;
        gap: var(--space-2);
    }
    
    .header-search .search-toggle {
        padding: var(--space-1) var(--space-2);
        font-size: 0.8rem;
    }
    
    .auth-buttons {
        flex-direction: column;
        gap: var(--space-2);
    }
    
    .auth-link {
        padding: var(--space-1) var(--space-2);
        font-size: 0.8rem;
        justify-content: center;
    }
    
    .brand-logo {
        height: 40px;
    }
    
    .brand-name {
        font-size: 1.2rem !important;
    }
    
    .navbar-brand {
        min-width: 120px;
    }
    
    .mobile-nav-header {
        padding: var(--space-3);
    }
    
    .mobile-brand img {
        height: 30px;
    }
}
</style>

<!-- Header functions are now handled by header-functions.js -->

<script>
// Toggle user dropdown
function toggleUserDropdown() {
    const dropdown = document.getElementById('userDropdownMenu');
    const profileMini = document.querySelector('.user-profile-mini');
    
    if (dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
        profileMini.classList.remove('active');
    } else {
        // Close any other open dropdowns
        document.querySelectorAll('.user-dropdown-menu.show').forEach(d => d.classList.remove('show'));
        document.querySelectorAll('.user-profile-mini.active').forEach(p => p.classList.remove('active'));
        
        dropdown.classList.add('show');
        profileMini.classList.add('active');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const profileMini = document.querySelector('.user-profile-mini');
    const dropdown = document.getElementById('userDropdownMenu');
    
    if (!profileMini.contains(event.target)) {
        dropdown.classList.remove('show');
        profileMini.classList.remove('active');
    }
});

// Toggle mobile menu
function toggleMobileMenu() {
    const mobileNav = document.getElementById('mobile-nav');
    const mobileToggle = document.querySelector('.mobile-toggle');
    
    mobileNav.classList.toggle('active');
    mobileToggle.classList.toggle('active');
    
    // Prevent body scroll when mobile menu is open
    if (mobileNav.classList.contains('active')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
}

// Toggle mobile submenu
function toggleMobileSubmenu(button) {
    const submenu = button.parentElement.nextElementSibling;
    const icon = button.querySelector('i');
    
    submenu.classList.toggle('active');
    
    if (submenu.classList.contains('active')) {
        icon.style.transform = 'rotate(180deg)';
    } else {
        icon.style.transform = 'rotate(0deg)';
    }
}

// Toggle categories dropdown
function toggleCategoriesDropdown(event) {
    event.preventDefault();
    event.stopPropagation();

    const categoriesDropdown = document.getElementById('categoriesDropdown');
    const navLink = event.currentTarget;
    const dropdownIcon = navLink.querySelector('.dropdown-icon');

    categoriesDropdown.classList.toggle('show');
    navLink.classList.toggle('active');

    if (dropdownIcon) {
        dropdownIcon.style.transform = categoriesDropdown.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
    }
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    const navLink = document.querySelector('.nav-item.has-dropdown > .nav-link');
    const categoriesDropdown = document.getElementById('categoriesDropdown');

    // Skip if click is on the trigger or inside dropdown
    if (!categoriesDropdown) return;
    if (categoriesDropdown.contains(event.target) || (navLink && navLink.contains(event.target))) {
        return;
    }

    // Close categories dropdown
    categoriesDropdown.classList.remove('show');
    if (navLink) navLink.classList.remove('active');
});

// Header scroll behavior
let lastScrollTop = 0;
const header = document.querySelector('.site-header');

window.addEventListener('scroll', function() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    if (scrollTop > 60) {
        header.classList.add('header-scrolled');
    } else {
        header.classList.remove('header-scrolled');
    }
    
    lastScrollTop = scrollTop;
});

// Search functionality
function openSearch() {
    // Implement search functionality
    console.log('Search opened');
}
</script> 