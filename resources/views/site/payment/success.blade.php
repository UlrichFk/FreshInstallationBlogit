@extends('site.layout.site-app')

@section('title', 'Payment Successful')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="mb-4">
                        <i class="ti ti-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h2 class="card-title text-success mb-3">{{ __("lang.site_payment_successful") }}</h2>
                    
                    @if(isset($subscription))
                    <div class="alert alert-success">
                        <h5>{{ __('lang.site_welcome_to_premium') }}</h5>
                        <p class="mb-0">{{ __('lang.site_your_subscription_to') }} <strong>{{ $subscription->membershipPlan->name }}</strong> {{ __('lang.site_has_been_activated_successfully') }}.</p>
                    </div>
                    
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h6>{{ __('lang.site_subscription_details') }}:</h6>
                            <ul class="list-unstyled">
                                <li><strong>{{ __('lang.site_plan') }}:</strong> {{ $subscription->membershipPlan->name }}</li>
                                <li><strong>{{ __('lang.site_amount') }}:</strong> ${{ number_format($subscription->amount_paid, 2) }}</li>
                                <li><strong>{{ __('lang.site_start_date') }}:</strong> {{ $subscription->start_date->format('M d, Y') }}</li>
                                <li><strong>{{ __('lang.site_end_date') }}:</strong> {{ $subscription->end_date->format('M d, Y') }}</li>
                                <li><strong>{{ __('lang.site_status') }}:</strong> <span class="badge bg-success">{{ __('lang.site_active') }}</span></li>
                            </ul>
                        </div>
                    </div>
                    @endif

                    @if(isset($donation))
                    <div class="alert alert-success">
                        <h5>{{ __('lang.site_thank_you_for_your_donation') }}</h5>
                        <p class="mb-0">{{ __('lang.site_your_generous_donation_of') }} <strong>${{ number_format($donation->amount, 2) }}</strong> {{ __('lang.site_has_been_received') }}.</p>
                    </div>
                    
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h6>{{ __('lang.site_donation_details') }}:</h6>
                            <ul class="list-unstyled">
                                <li><strong>{{ __('lang.site_amount') }}:</strong> ${{ number_format($donation->amount, 2) }}</li>
                                <li><strong>{{ __('lang.site_donor') }}:</strong> {{ $donation->is_anonymous ? __('lang.site_anonymous') : $donation->donor_name }}</li>
                                @if($donation->is_recurring)
                                <li><strong>{{ __('lang.site_type') }}:</strong> {{ __('lang.site_recurring') }} ({{ ucfirst($donation->recurring_interval) }})</li>
                                @else
                                <li><strong>{{ __('lang.site_type') }}:</strong> {{ __('lang.site_one_time') }}</li>
                                @endif
                                <li><strong>{{ __('lang.site_date') }}:</strong> {{ $donation->created_at->format('M d, Y H:i') }}</li>
                            </ul>
                        </div>
                    </div>
                    @endif

                    <div class="d-grid gap-2">
                        @if(isset($subscription))
                        <a href="{{ url('/') }}" class="btn btn-primary">
                            <i class="ti ti-home me-2"></i>{{ __('lang.site_go_to_homepage') }}
                        </a>
                        <a href="{{ url('blog') }}" class="btn btn-outline-primary">
                            <i class="ti ti-article me-2"></i>{{ __('lang.site_browse_articles') }}
                        </a>
                        @else
                        <a href="{{ url('/') }}" class="btn btn-primary">
                            <i class="ti ti-home me-2"></i>{{ __('lang.site_go_to_homepage') }}
                        </a>
                        <a href="{{ url('donation') }}" class="btn btn-outline-primary">
                        </a>
                        @endif
                    </div>

                    <div class="mt-4">
                        <small class="text-muted">
                            {{ __('lang.site_a_confirmation_email_has_been_sent_to_your_email_address') }}.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.ti-check-circle {
    animation: bounce 1s ease-in-out;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}
</style>
@endpush 