@extends('site.layout.site-app')

@section('title', {{ __('lang.site_support_our_mission') }})

@section('content')
<div class="donation-page">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-background">
            <div class="hero-pattern"></div>
            <div class="hero-glow"></div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <div class="hero-content">
                        <div class="hero-badge">
                            <i class="ti ti-heart-pulse"></i>
                            <span>{{ __('lang.site_make_a_difference') }}</span>
                        </div>
                        <h1 class="hero-title">
                            {{ __('lang.site_support_our') }} <span class="highlight">{{ __('lang.site_mission') }}</span>
                        </h1>
                        <p class="hero-subtitle">
                            {{ __('lang.site_each_donation_counts_and_helps_us_to_continue_providing_quality_content') }}
                        </p>
                        <div class="hero-stats">
                            <div class="stat-item">
                                <div class="stat-icon">
                                    <i class="ti ti-shield-check"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-number">100%</div>
                                    <div class="stat-label">{{ __('lang.site_transparent') }}</div>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon">
                                    <i class="ti ti-clock"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-number">{{ __('lang.site_24_7') }}</div>
                                    <div class="stat-label">{{ __('lang.site_available') }}</div>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon">
                                    <i class="ti ti-lock"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-number">{{ __("lang.site_secure") }}</div>
                                    <div class="stat-label">{{ __('lang.site_payment') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Donation Form Section -->
    <section class="donation-form-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="donation-container">
                        <div class="row g-5">
                            <!-- Donation Form -->
                            <div class="col-lg-8">
                                <div class="donation-form-card">
                                    <div class="card-header">
                                        <div class="header-icon">
                                            <i class="ti ti-gift"></i>
                                        </div>
                                        <h3>{{ __("lang.site_make_donation") }}</h3>
                                        <p>{{ __("lang.site_choose_amount_complete_info") }}</p>
                                    </div>
                                    
                                    <form id="donationForm" action="{{ url('payment/stripe/donation') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" id="payment_method" value="stripe">
                                        
                                        <div class="form-section">
                                            <div class="section-header">
                                                <div class="section-icon">
                                                    <i class="ti ti-wallet"></i>
                                                </div>
                                                <h4>{{ __('lang.site_payment_method') }}</h4>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-12 d-flex gap-4 flex-wrap">
                                                    @if(\Helpers::isStripeEnabled())
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="gateway" id="gateway_stripe" value="stripe" checked>
                                                        <label class="form-check-label" for="gateway_stripe">
                                                            <i class="ti ti-brand-stripe me-1"></i> {{ __('lang.site_card_stripe') }}
                                                        </label>
                                                    </div>
                                                    @endif
                                                    @if(\Helpers::isPayPalEnabled())
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="gateway" id="gateway_paypal" value="paypal" @if(!\Helpers::isStripeEnabled()) checked @endif>
                                                        <label class="form-check-label" for="gateway_paypal">
                                                            <i class="ti ti-brand-paypal me-1"></i> {{ __('lang.site_paypal') }}
                                                        </label>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-section">
                                            <div class="section-header">
                                                <div class="section-icon">
                                                    <i class="ti ti-user"></i>
                                                </div>
                                                <h4>{{ __('lang.site_personal_information') }}</h4>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="donor_name" class="form-label">
                                                        {{ __('lang.site_your_name') }} <span class="required">*</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <i class="ti ti-user input-icon"></i>
                                                        <input type="text" class="form-control @error('donor_name') is-invalid @enderror" 
                                                               id="donor_name" name="donor_name" 
                                                               value="{{ old('donor_name', auth()->user()->name ?? '') }}" 
                                                               placeholder="{{ __("lang.site_enter_full_name") }}" required>
                                                    </div>
                                                    @error('donor_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label for="donor_email" class="form-label">
                                                        {{ __("lang.site_email_address") }} <span class="required">*</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <i class="ti ti-mail input-icon"></i>
                                                        <input type="email" class="form-control @error('donor_email') is-invalid @enderror" 
                                                               id="donor_email" name="donor_email" 
                                                               value="{{ old('donor_email', auth()->user()->email ?? '') }}" 
                                                               placeholder="{{ __("lang.site_your_email_placeholder") }}" required>
                                                    </div>
                                                    @error('donor_email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-section">
                                            <div class="section-header">
                                                <div class="section-icon">
                                                    <i class="ti ti-coin"></i>
                                                </div>
                                                <h4>{{ __("lang.site_donation_amount") }}</h4>
                                            </div>
                                            <div class="amount-selection">
                                                <div class="preset-amounts">
                                                    <div class="preset-grid">
                                                        <div class="amount-option">
                                                            <input type="radio" class="amount-radio" name="preset_amount" id="amount5" value="5">
                                                            <label class="amount-btn" for="amount5">
                                                                <div class="amount-value">€5</div>
                                                                <div class="amount-impact">{{ __('lang.site_small_donation_big_impact') }}</div>
                                                            </label>
                                                        </div>
                                                        
                                                        <div class="amount-option">
                                                            <input type="radio" class="amount-radio" name="preset_amount" id="amount10" value="10" checked>
                                                            <label class="amount-btn active" for="amount10">
                                                                <div class="amount-value">€10</div>
                                                                <div class="amount-impact">{{ __('lang.site_standard_donation') }}</div>
                                                            </label>
                                                        </div>
                                                        
                                                        <div class="amount-option">
                                                            <input type="radio" class="amount-radio" name="preset_amount" id="amount25" value="25">
                                                            <label class="amount-btn" for="amount25">
                                                                <div class="amount-value">€25</div>
                                                                <div class="amount-impact">{{ __('lang.site_generous_donation') }}</div>
                                                            </label>
                                                        </div>
                                                        
                                                        <div class="amount-option">
                                                            <input type="radio" class="amount-radio" name="preset_amount" id="amount50" value="50">
                                                            <label class="amount-btn" for="amount50">
                                                                <div class="amount-value">€50</div>
                                                                <div class="amount-impact">{{ __('lang.site_premium_donation') }}</div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="custom-amount">
                                                    <label for="amount" class="form-label">{{ __("lang.site_custom_amount") }}</label>
                                                    <div class="input-wrapper">
                                                        <i class="ti ti-currency-euro input-icon"></i>
                                                        <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                                               id="amount" name="amount" value="{{ old('amount', 10) }}" 
                                                               step="0.01" min="1" placeholder="{{ __("lang.site_enter_amount") }}" required>
                                                    </div>
                                                    <div class="form-text">{{ __("lang.site_minimum_amount") }}</div>
                                                    @error('amount')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-section">
                                            <div class="section-header">
                                                <div class="section-icon">
                                                    <i class="ti ti-settings"></i>
                                                </div>
                                                <h4>{{ __("lang.site_additional_options") }}</h4>
                                            </div>
                                            <div class="options-grid">
                                                <div class="option-item">
                                                    <label for="message" class="form-label">
                                                        <i class="ti ti-message-circle"></i>
                                                        {{ __('lang.site_message') }} ({{ __('lang.site_optional') }})
                                                    </label>
                                                    <textarea class="form-control @error('message') is-invalid @enderror" 
                                                              id="message" name="message" rows="3" 
                                                              placeholder="Partagez pourquoi vous faites ce don ou laissez un message d'encouragement...">{{ old('message') }}</textarea>
                                                    @error('message')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="checkbox-options">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="is_anonymous" name="is_anonymous" value="1">
                                                        <label class="form-check-label" for="is_anonymous">
                                                            <i class="ti ti-eye-off"></i>
                                                            {{ __('lang.site_make_this_donation_anonymous') }}
                                                        </label>
                                                    </div>
                                                    
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="is_recurring" name="is_recurring" value="1">
                                                        <label class="form-check-label" for="is_recurring">
                                                            <i class="ti ti-refresh"></i>
                                                            {{ __('lang.site_recurring_monthly_donation') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-section" id="card-section">
                                            <div class="section-header">
                                                <div class="section-icon">
                                                    <i class="ti ti-credit-card"></i>
                                                </div>
                                                <h4>{{ __('lang.site_card_details') }}</h4>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="card_number" class="form-label">
                                                        {{ __('lang.site_card_number') }} <span class="required">*</span>
                                                    </label>
                                                    <div class="input-wrapper">
                                                        <i class="ti ti-credit-card input-icon"></i>
                                                        <input type="text" class="form-control" id="card_number" name="card_number" placeholder="1234 5678 9012 3456">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="expiry" class="form-label">Expiration <span class="required">*</span></label>
                                                    <div class="input-wrapper">
                                                        <i class="ti ti-calendar input-icon"></i>
                                                        <input type="text" class="form-control" id="expiry" name="expiry" placeholder="{{ __("lang.site_expiry_date_placeholder") }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="cvv" class="form-label">CVV <span class="required">*</span></label>
                                                    <div class="input-wrapper">
                                                        <i class="ti ti-lock input-icon"></i>
                                                        <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary btn-donate">
                                                <div class="btn-content">
                                                    <i class="ti ti-heart"></i>
                                                    <span>{{ __("lang.site_make_donation") }} {{ __('lang.site_now') }}</span>
                                                </div>
                                                <div class="btn-loading" style="display: none;">
                                                    <i class="ti ti-loader ti-spin"></i>
                                                    <span>{{ __('lang.site_processing') }}...</span>
                                                </div>
                                            </button>
                                            <div class="security-note">
                                                <i class="ti ti-shield-check"></i>
                                                <span>{{ __("lang.site_secure_payment_stripe") }}</span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="col-lg-4">
                                <div class="donation-sidebar">
                                    <!-- Impact Stats -->
                                    <div class="sidebar-card impact-stats">
                                        <div class="card-header">
                                            <h4>{{ __('lang.site_impact_of_your_donations') }}</h4>
                                            <p>{{ __('lang.site_discover_how_your_contributions_make_a_difference') }}</p>
                                        </div>
                                        <div class="impact-items">
                                            <div class="impact-item">
                                                <div class="impact-icon">
                                                    <i class="ti ti-article"></i>
                                                </div>
                                                <div class="impact-content">
                                                    <div class="impact-number">150+</div>
                                                    <div class="impact-label">{{ __('lang.site_articles_published') }}</div>
                                                </div>
                                            </div>
                                            <div class="impact-item">
                                                <div class="impact-icon">
                                                    <i class="ti ti-users"></i>
                                                </div>
                                                <div class="impact-content">
                                                    <div class="impact-number">10K+</div>
                                                    <div class="impact-label">{{ __('lang.site_readers_served') }}</div>
                                                </div>
                                            </div>
                                            <div class="impact-item">
                                                <div class="impact-icon">
                                                    <i class="ti ti-world"></i>
                                                </div>
                                                <div class="impact-content">
                                                    <div class="impact-number">24/7</div>
                                                    <div class="impact-label">{{ __('lang.site_availability') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Recent Donations -->
                                    <div class="sidebar-card">
                                        <div class="card-header">
                                            <h4>{{ __('lang.site_recent_donations') }}</h4>
                                            <p>{{ __('lang.site_join_our_community_of_donors') }}</p>
                                        </div>
                                        <div class="recent-donations">
                                            <div class="donation-item">
                                                <div class="donor-info">
                                                    <div class="donor-avatar">A</div>
                                                    <div class="donor-details">
                                                        <div class="donor-name">{{ __('lang.site_anonymous') }}</div>
                                                        <div class="donation-amount">€25</div>
                                                    </div>
                                                </div>
                                                <div class="donation-time">{{ __('lang.site_2_hours_ago') }}</div>
                                            </div>
                                            
                                            <div class="donation-item">
                                                <div class="donor-info">
                                                    <div class="donor-avatar">M</div>
                                                    <div class="donor-details">
                                                        <div class="donor-name">{{ __('lang.site_marie_l') }}</div>
                                                        <div class="donation-amount">€10</div>
                                                    </div>
                                                </div>
                                                <div class="donation-time">{{ __('lang.site_5_hours_ago') }}</div>
                                            </div>
                                            
                                            <div class="donation-item">
                                                <div class="donor-info">
                                                    <div class="donor-avatar">P</div>
                                                    <div class="donor-details">
                                                        <div class="donor-name">{{ __('lang.site_pierre_d') }}</div>
                                                        <div class="donation-amount">€50</div>
                                                    </div>
                                                </div>
                                                <div class="donation-time">{{ __('lang.site_1_day_ago') }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Security Info -->
                                    <div class="sidebar-card security-info">
                                        <div class="security-icon">
                                            <i class="ti ti-shield-check"></i>
                                        </div>
                                        <h5>{{ __("lang.site_secure_payment") }}</h5>
                                        <p>{{ __("lang.site_donations_ssl_protected") }}</p>
                                        <div class="security-badges">
                                            <span class="badge">{{ __('lang.site_ssl') }}</span>
                                            <span class="badge">{{ __('lang.site_pci_dss') }}</span>
                                            <span class="badge">{{ __('lang.site_stripe') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.donation-page {
    background: var(--primary-color);
    min-height: 100vh;
}

/* Hero Section */
.hero-section {
    padding: 120px 0 80px;
    background: var(--gradient-primary);
    position: relative;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.hero-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="heroPattern" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.08)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.08)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.06)"/><circle cx="10" cy="60" r="0.8" fill="rgba(255,255,255,0.04)"/><circle cx="90" cy="40" r="0.6" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23heroPattern)"/></svg>');
    opacity: 0.4;
}

.hero-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(15, 52, 96, 0.3) 0%, transparent 70%);
    border-radius: 50%;
    filter: blur(80px);
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50px;
    padding: 0.75rem 1.5rem;
    margin-bottom: 2rem;
    color: var(--text-primary);
    font-weight: 500;
    font-size: 0.9rem;
}

.hero-badge i {
    color: var(--accent-color);
    font-size: 1rem;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.hero-title .highlight {
    background: var(--gradient-accent);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
}

.hero-title .highlight::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--gradient-accent);
    border-radius: 2px;
}

.hero-subtitle {
    font-size: 1.25rem;
    color: var(--text-secondary);
    margin-bottom: 3rem;
    line-height: 1.6;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

.hero-stats {
    display: flex;
    justify-content: center;
    gap: 3rem;
    flex-wrap: wrap;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    min-width: 180px;
    transition: all 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.3);
}

.stat-icon {
    width: 50px;
    height: 50px;
    background: var(--gradient-accent);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.stat-content {
    text-align: left;
}

.stat-number {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 500;
}

/* Donation Form Section */
.donation-form-section {
    padding: 80px 0;
    background: var(--secondary-color);
}

.donation-container {
    max-width: 1200px;
    margin: 0 auto;
}

.donation-form-card {
    background: var(--card-bg);
    border-radius: 24px;
    padding: 2.5rem;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
}

.donation-form-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
}

.card-header {
    text-align: center;
    margin-bottom: 2.5rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid var(--border-color);
}

.header-icon {
    width: 80px;
    height: 80px;
    background: var(--gradient-accent);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2rem;
}

.card-header h3 {
    color: var(--text-primary);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
}

.card-header p {
    color: var(--text-secondary);
    margin: 0;
    font-size: 1.1rem;
}

.form-section {
    margin-bottom: 2.5rem;
    padding: 2rem;
    background: rgba(15, 52, 96, 0.03);
    border-radius: 20px;
    border: 1px solid rgba(15, 52, 96, 0.08);
    transition: all 0.3s ease;
}

.form-section:hover {
    background: rgba(15, 52, 96, 0.05);
    border-color: rgba(15, 52, 96, 0.12);
    transform: translateY(-2px);
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.section-icon {
    width: 50px;
    height: 50px;
    background: var(--gradient-accent);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.form-section h4 {
    color: var(--text-primary);
    font-size: 1.35rem;
    font-weight: 600;
    margin: 0;
}

.form-label {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 0.75rem;
    font-size: 1rem;
}

.required {
    color: #e74c3c;
    font-weight: 700;
}

.input-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    z-index: 2;
    font-size: 1.1rem;
}

.form-control {
    background: var(--primary-color);
    border: 2px solid var(--border-color);
    color: var(--text-primary);
    border-radius: 16px;
    padding: 1rem 1rem 1rem 3rem;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.form-control:focus {
    background: var(--primary-color);
    border-color: var(--accent-color);
    color: var(--text-primary);
    box-shadow: 0 0 0 0.2rem rgba(15, 52, 96, 0.15);
    transform: translateY(-1px);
}

.form-control::placeholder {
    color: var(--text-muted);
    opacity: 0.7;
}

/* Amount Selection */
.amount-selection {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.preset-amounts {
    margin-bottom: 1rem;
}

.preset-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 1rem;
}

.amount-option {
    position: relative;
}

.amount-radio {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.amount-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1.5rem 1rem;
    background: var(--card-bg);
    border: 2px solid var(--border-color);
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    min-height: 120px;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.amount-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--gradient-accent);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.amount-btn:hover {
    border-color: var(--accent-color);
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(15, 52, 96, 0.2);
}

.amount-radio:checked + .amount-btn {
    border-color: var(--accent-color);
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.1) 0%, rgba(15, 52, 96, 0.05) 100%);
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(15, 52, 96, 0.25);
}

.amount-radio:checked + .amount-btn::before {
    opacity: 0.1;
}

.amount-value {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}

.amount-impact {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    position: relative;
    z-index: 1;
}

.custom-amount {
    background: rgba(15, 52, 96, 0.05);
    border: 1px solid rgba(15, 52, 96, 0.1);
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.custom-amount::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--gradient-accent);
    opacity: 0.7;
}

.custom-amount .input-wrapper {
    max-width: 250px;
    margin: 0 auto;
}

.custom-amount .form-control {
    text-align: center;
    font-size: 1.25rem;
    font-weight: 600;
    padding: 1rem;
    background: var(--primary-color);
    border: 2px solid var(--border-color);
    border-radius: 16px;
    transition: all 0.3s ease;
}

.custom-amount .form-control:focus {
    border-color: var(--accent-color);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(15, 52, 96, 0.2);
}

.form-text {
    color: var(--text-muted);
    font-size: 0.85rem;
    margin-top: 0.75rem;
    font-style: italic;
}

/* Options Section */
.options-grid {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.option-item {
    background: rgba(15, 52, 96, 0.03);
    border: 1px solid rgba(15, 52, 96, 0.08);
    border-radius: 20px;
    padding: 2rem;
    transition: all 0.3s ease;
}

.option-item:hover {
    background: rgba(15, 52, 96, 0.05);
    border-color: rgba(15, 52, 96, 0.12);
    transform: translateY(-2px);
}

.option-item .form-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.option-item .form-label i {
    color: var(--accent-color);
    font-size: 1.1rem;
}

.option-item textarea {
    background: var(--primary-color);
    border: 2px solid var(--border-color);
    color: var(--text-primary);
    border-radius: 16px;
    padding: 1rem;
    font-size: 1rem;
    resize: vertical;
    min-height: 100px;
    transition: all 0.3s ease;
}

.option-item textarea:focus {
    border-color: var(--accent-color);
    box-shadow: 0 0 0 0.2rem rgba(15, 52, 96, 0.15);
    transform: translateY(-1px);
}

.checkbox-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    background: rgba(15, 52, 96, 0.03);
    border: 1px solid rgba(15, 52, 96, 0.08);
    border-radius: 20px;
    padding: 2rem;
}

.form-check {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin: 0;
    padding: 1rem;
    background: var(--card-bg);
    border-radius: 16px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.form-check:hover {
    border-color: var(--accent-color);
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(15, 52, 96, 0.1);
}

.form-check-input {
    width: 24px;
    height: 24px;
    margin: 0;
    background-color: var(--primary-color);
    border: 2px solid var(--border-color);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
}

.form-check-input:checked {
    background-color: var(--accent-color);
    border-color: var(--accent-color);
    transform: scale(1.1);
}

.form-check-input:checked::after {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 14px;
    font-weight: bold;
}

.form-check-input:focus {
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(15, 52, 96, 0.25);
    border-color: var(--accent-color);
}

.form-check-input:hover {
    border-color: var(--accent-color);
}

.form-check-label {
    color: var(--text-secondary);
    font-size: 1rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    line-height: 1.4;
    margin: 0;
    font-weight: 500;
}

.form-check-label i {
    color: var(--accent-color);
    font-size: 1.1rem;
}

/* Form Actions */
.form-actions {
    text-align: center;
    margin-top: 3rem;
    padding-top: 2.5rem;
    border-top: 2px solid var(--border-color);
}

.btn-donate {
    background: var(--gradient-accent);
    border: none;
    color: white;
    padding: 1.25rem 3rem;
    font-size: 1.2rem;
    font-weight: 600;
    border-radius: 50px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    min-width: 280px;
    box-shadow: 0 10px 30px rgba(15, 52, 96, 0.3);
}

.btn-donate:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(15, 52, 96, 0.4);
}

.btn-donate:active {
    transform: translateY(-1px);
}

.btn-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}

.btn-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}

.btn-donate i {
    font-size: 1.3rem;
}

.security-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1.5rem;
    color: var(--text-muted);
    font-size: 0.9rem;
    font-weight: 500;
}

.security-note i {
    color: var(--accent-color);
    font-size: 1rem;
}

/* Sidebar */
.donation-sidebar {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.sidebar-card {
    background: var(--card-bg);
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.sidebar-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.sidebar-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--gradient-accent);
    opacity: 0.7;
}

.sidebar-card .card-header {
    text-align: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.sidebar-card .card-header h4 {
    color: var(--text-primary);
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.sidebar-card .card-header p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 0;
}

/* Impact Stats */
.impact-stats {
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.05) 0%, rgba(15, 52, 96, 0.02) 100%);
}

.impact-items {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.impact-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 16px;
    border: 1px solid rgba(15, 52, 96, 0.08);
    transition: all 0.3s ease;
}

.impact-item:hover {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(15, 52, 96, 0.12);
    transform: translateX(5px);
}

.impact-icon {
    width: 50px;
    height: 50px;
    background: var(--gradient-accent);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.impact-content {
    flex: 1;
}

.impact-number {
    color: var(--text-primary);
    font-size: 1.5rem;
    font-weight: 800;
    margin-bottom: 0.25rem;
}

.impact-label {
    color: var(--text-secondary);
    font-size: 0.85rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Recent Donations */
.recent-donations {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.donation-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem;
    background: rgba(15, 52, 96, 0.03);
    border-radius: 16px;
    border: 1px solid rgba(15, 52, 96, 0.08);
    transition: all 0.3s ease;
}

.donation-item:hover {
    background: rgba(15, 52, 96, 0.05);
    border-color: rgba(15, 52, 96, 0.12);
    transform: translateX(5px);
}

.donor-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.donor-avatar {
    width: 45px;
    height: 45px;
    background: var(--gradient-accent);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1rem;
    flex-shrink: 0;
}

.donor-details {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.donor-name {
    color: var(--text-primary);
    font-weight: 600;
    font-size: 0.95rem;
}

.donation-amount {
    color: var(--accent-color);
    font-weight: 700;
    font-size: 1rem;
}

.donation-time {
    color: var(--text-muted);
    font-size: 0.8rem;
    font-weight: 500;
}

/* Security Info */
.security-info {
    text-align: center;
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.08) 0%, rgba(15, 52, 96, 0.03) 100%);
}

.security-icon {
    width: 70px;
    height: 70px;
    background: var(--gradient-accent);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 1.75rem;
}

.security-info h5 {
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-size: 1.2rem;
    font-weight: 600;
}

.security-info p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.5;
    margin: 0 0 1.5rem 0;
}

.security-badges {
    display: flex;
    justify-content: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.security-badges .badge {
    background: rgba(15, 52, 96, 0.1);
    color: var(--accent-color);
    border: 1px solid rgba(15, 52, 96, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .hero-title {
        font-size: 3rem;
    }
    
    .preset-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .hero-section {
        padding: 80px 0 60px;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
    }
    
    .hero-stats {
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .stat-item {
        min-width: auto;
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
    }
    
    .donation-form-section {
        padding: 60px 0;
    }
    
    .donation-form-card {
        padding: 2rem;
        border-radius: 20px;
    }
    
    .form-section {
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .preset-grid {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }
    
    .amount-btn {
        padding: 1.25rem 1rem;
        min-height: 100px;
    }
    
    .amount-value {
        font-size: 1.5rem;
    }
    
    .checkbox-options {
        grid-template-columns: 1fr;
        padding: 1.5rem;
    }
    
    .btn-donate {
        min-width: 100%;
        padding: 1.25rem 2rem;
    }
    
    .sidebar-card {
        padding: 1.5rem;
    }
    
    .impact-items {
        gap: 1rem;
    }
    
    .impact-item {
        padding: 0.75rem;
    }
    
    .donation-item {
        padding: 1rem;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-badge {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
    }
    
    .donation-form-card {
        padding: 1.5rem;
    }
    
    .form-section {
        padding: 1rem;
    }
    
    .section-header {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }
    
    .section-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .btn-donate {
        font-size: 1.1rem;
        padding: 1rem 1.5rem;
    }
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.hero-content {
    animation: fadeInUp 0.8s ease-out;
}

.hero-stats .stat-item:nth-child(1) {
    animation: slideInLeft 0.6s ease-out 0.2s both;
}

.hero-stats .stat-item:nth-child(2) {
    animation: slideInLeft 0.6s ease-out 0.4s both;
}

.hero-stats .stat-item:nth-child(3) {
    animation: slideInLeft 0.6s ease-out 0.6s both;
}

.donation-form-card {
    animation: fadeInUp 0.8s ease-out 0.3s both;
}

.donation-sidebar .sidebar-card:nth-child(1) {
    animation: slideInRight 0.6s ease-out 0.4s both;
}

.donation-sidebar .sidebar-card:nth-child(2) {
    animation: slideInRight 0.6s ease-out 0.6s both;
}

.donation-sidebar .sidebar-card:nth-child(3) {
    animation: slideInRight 0.6s ease-out 0.8s both;
}

/* Hover Effects */
.amount-btn:hover .amount-value {
    color: var(--accent-color);
}

.amount-btn:hover .amount-impact {
    color: var(--text-secondary);
}

.form-check:hover .form-check-label {
    color: var(--text-primary);
}

.impact-item:hover .impact-number {
    color: var(--accent-color);
}

.donation-item:hover .donor-name {
    color: var(--accent-color);
}

/* Focus States */
.form-control:focus + .input-icon {
    color: var(--accent-color);
}

.amount-radio:focus + .amount-btn {
    box-shadow: 0 0 0 0.2rem rgba(15, 52, 96, 0.25);
}

.form-check-input:focus + .form-check-label {
    color: var(--text-primary);
}

/* Loading States */
.btn-donate.loading .btn-content {
    display: none;
}

.btn-donate.loading .btn-loading {
    display: flex;
}

.btn-donate.loading {
    pointer-events: none;
    opacity: 0.8;
}

/* Success States */
.form-control.is-valid {
    border-color: #28a745;
    background-color: rgba(40, 167, 69, 0.05);
}

.form-control.is-invalid {
    border-color: #dc3545;
    background-color: rgba(220, 53, 69, 0.05);
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    display: block;
}

/* Custom Scrollbar */
.donation-page::-webkit-scrollbar {
    width: 8px;
}

.donation-page::-webkit-scrollbar-track {
    background: var(--primary-color);
}

.donation-page::-webkit-scrollbar-thumb {
    background: var(--accent-color);
    border-radius: 4px;
}

.donation-page::-webkit-scrollbar-thumb:hover {
    background: var(--hover-color);
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preset amount selection
        const presetAmounts = document.querySelectorAll('input[name="preset_amount"]');
        const customAmount = document.getElementById('amount');
        
        presetAmounts.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    customAmount.value = this.value;
                    updatePresetButtons();
                }
            });
        });
        
        // Custom amount input
        customAmount.addEventListener('input', function() {
            updatePresetButtons();
        });
        
        function updatePresetButtons() {
            const currentValue = customAmount.value;
            presetAmounts.forEach(radio => {
                const btn = document.querySelector(`label[for="${radio.id}"]`);
                if (radio.value == currentValue) {
                    btn.classList.add('active');
                    radio.checked = true;
                } else {
                    btn.classList.remove('active');
                }
            });
        }
        
        // Initialize
        updatePresetButtons();
        
        // Add visual feedback for amount selection
        const amountBtns = document.querySelectorAll('.amount-btn');
        amountBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                amountBtns.forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');
            });
        });
        
        // Form submission
        const donationForm = document.getElementById('donationForm');
        donationForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.btn-donate');
            submitBtn.innerHTML = '<i class="ti ti-loader ti-spin me-2"></i>Traitement...';
            submitBtn.disabled = true;
        });

        const form = document.getElementById('donationForm');
        const cardSection = document.getElementById('card-section');
        const gatewayStripe = document.getElementById('gateway_stripe');
        const gatewayPayPal = document.getElementById('gateway_paypal');
        const paymentMethodInput = document.getElementById('payment_method');

        function applyGateway(gateway) {
            if (gateway === 'paypal') {
                form.action = '{{ url('payment/paypal/donation') }};
                paymentMethodInput.value = 'paypal';
                if (cardSection) cardSection.style.display = 'none';
            } else {
                form.action = '{{ url('payment/stripe/donation') }};
                paymentMethodInput.value = 'stripe';
                if (cardSection) cardSection.style.display = 'block';
            }
        }

        if (gatewayStripe && gatewayStripe.checked) applyGateway('stripe');
        if (gatewayPayPal && gatewayPayPal.checked && !gatewayStripe) applyGateway('paypal');

        if (gatewayStripe) gatewayStripe.addEventListener('change', () => applyGateway('stripe'));
        if (gatewayPayPal) gatewayPayPal.addEventListener('change', () => applyGateway('paypal'));
    });
</script>
@endsection