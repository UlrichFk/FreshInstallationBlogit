@extends('site.layout.site-app')

@section('title', 'Membership Dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold">Membership Dashboard</h1>
                <p class="lead text-muted">{{ __("lang.site_manage_subscription_premium") }}</p>
            </div>
        </div>
    </div>

    @auth
        @if($activeSubscription)
        <!-- Active Subscription -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">
                            <i class="ti ti-crown me-2"></i>
                            Active Subscription
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>{{ $activeSubscription->membershipPlan->name }}</h5>
                                <p class="text-muted">{{ $activeSubscription->membershipPlan->description }}</p>
                                <div class="mb-3">
                                    <strong>Amount:</strong> ${{ number_format($activeSubscription->amount_paid, 2) }} {{ $activeSubscription->currency }}
                                </div>
                                <div class="mb-3">
                                    <strong>Start Date:</strong> {{ $activeSubscription->start_date->format('M d, Y') }}
                                </div>
                                <div class="mb-3">
                                    <strong>End Date:</strong> {{ $activeSubscription->end_date->format('M d, Y') }}
                                </div>
                                <div class="mb-3">
                                    <strong>Days Remaining:</strong> 
                                    <span class="badge bg-{{ $activeSubscription->days_remaining > 30 ? 'success' : ($activeSubscription->days_remaining > 7 ? 'warning' : 'danger') }}">
                                        {{ $activeSubscription->days_remaining }} days
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="mb-3">
                                    <a href="{{ url('membership/status') }}" class="btn btn-outline-primary">
                                        <i class="ti ti-eye me-1"></i>
                                        View Details
                                    </a>
                                </div>
                                <div class="mb-3">
                                    <a href="{{ url('membership-plans') }}" class="btn btn-outline-secondary">
                                        <i class="ti ti-crown me-1"></i>
                                        Change Plan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- No Active Subscription -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">
                            <i class="ti ti-alert-triangle me-2"></i>
                            No Active Subscription
                        </h4>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <i class="ti ti-lock-off fs-1 text-muted"></i>
                        </div>
                        <h5>You don't have an active subscription</h5>
                        <p class="text-muted">{{ __("lang.site_subscribe_premium_features") }}</p>
                        <a href="{{ url('membership-plans') }}" class="btn btn-primary btn-lg">
                            <i class="ti ti-crown me-2"></i>
                            View Plans
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @else
        <!-- Not Logged In -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">
                            <i class="ti ti-user me-2"></i>
                            Login Required
                        </h4>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <i class="ti ti-login fs-1 text-muted"></i>
                        </div>
                        <h5>Please log in to access your membership</h5>
                        <p class="text-muted">You need to be logged in to view your subscription details.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ url('login') }}" class="btn btn-primary">
                                <i class="ti ti-login me-2"></i>
                                Login
                            </a>
                            <a href="{{ url('signup') }}" class="btn btn-outline-primary">
                                <i class="ti ti-user-plus me-2"></i>
                                Sign Up
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    <!-- Available Plans -->
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">Available Plans</h3>
        </div>
    </div>

    <div class="row">
        @foreach($plans as $plan)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 {{ $plan->is_featured ? 'border-primary shadow-lg' : '' }}">
                @if($plan->is_featured)
                <div class="card-header bg-primary text-white text-center">
                    <span class="badge bg-warning">Most Popular</span>
                </div>
                @endif
                <div class="card-body text-center">
                    <h4 class="card-title">{{ $plan->name }}</h4>
                    <div class="pricing-price mb-3">
                        <span class="display-5 fw-bold text-primary">${{ number_format($plan->price, 2) }}</span>
                        <span class="text-muted">/{{ ucfirst($plan->billing_cycle) }}</span>
                    </div>
                    
                    @if($plan->description)
                    <p class="card-text text-muted mb-3">{{ $plan->description }}</p>
                    @endif

                    @if($plan->features && is_array($plan->features))
                    <ul class="list-unstyled mb-4">
                        @foreach(array_slice($plan->features, 0, 3) as $feature)
                        <li class="mb-2">
                            <i class="ti ti-check text-success me-2"></i>
                            {{ $feature }}
                        </li>
                        @endforeach
                        @if(count($plan->features) > 3)
                        <li class="mb-2">
                            <i class="ti ti-plus text-muted me-2"></i>
                            And {{ count($plan->features) - 3 }} more features
                        </li>
                        @endif
                    </ul>
                    @endif

                    <div class="d-grid">
                        @auth
                            @if($activeSubscription && $activeSubscription->membership_plan_id == $plan->id)
                                <button class="btn btn-success" disabled>
                                    <i class="ti ti-check me-1"></i> Current Plan
                                </button>
                            @else
                                <a href="{{ url('membership/subscribe/'.$plan->id) }}" class="btn btn-primary">
                                    <i class="ti ti-crown me-1"></i> 
                                    {{ $activeSubscription ? '{{ __("lang.site_switch_to_plan") }}' : '{{ __("lang.site_subscribe_now") }}' }}
                                </a>
                            @endif
                        @else
                            <a href="{{ url('login') }}" class="btn btn-primary">
                                <i class="ti ti-login me-1"></i> Login to Subscribe
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- FAQ Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Frequently Asked Questions</h3>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            How do I cancel my subscription?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            You can cancel your subscription at any time from your account dashboard. Your access will continue until the end of your current billing period.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            Can I change my plan?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes, you can upgrade or downgrade your plan at any time. Changes will take effect at the start of your next billing cycle.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            What payment methods do you accept?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            We accept all major credit cards (Visa, MasterCard, American Express) and PayPal for your convenience.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 