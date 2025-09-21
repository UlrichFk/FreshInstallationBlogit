@extends('site.layout.site-app')

@section('title', '{{ __("lang.site_payment_cancelled") }}')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="mb-4">
                        <i class="ti ti-x-circle text-warning" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h2 class="card-title text-warning mb-3">{{ __("lang.site_payment_cancelled") }}</h2>
                    
                    <div class="alert alert-warning">
                        <h5>{{ __('lang.site_no_worries') }}</h5>
                        <p class="mb-0">{{ __('lang.site_your_payment_was_cancelled') }}</p>
                    </div>

                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h6>{{ __('lang.site_what_happened') }}</h6>
                            <ul class="list-unstyled text-start">
                                <li><i class="ti ti-check text-success me-2"></i>{{ __('lang.site_no_charges_were_made_to_your_account') }}</li>
                                <li><i class="ti ti-check text-success me-2"></i>{{ __('lang.site_your_payment_information_is_secure') }}</li>
                                <li><i class="ti ti-check text-success me-2"></i>{{ __('lang.site_you_can_try_again_anytime') }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ url('membership-plans') }}" class="btn btn-primary">
                            <i class="ti ti-crown me-2"></i>{{ __('lang.site_try_again') }}
                        </a>
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-home me-2"></i>{{ __('lang.site_go_to_homepage') }}
                        </a>
                    </div>

                    <div class="mt-4">
                        <small class="text-muted">
                            {{ __('lang.site_need_help') }} <a href="{{ url('contact') }}">{{ __('lang.site_contact_our_support_team') }}</a>
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
.ti-x-circle {
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% {
        transform: translateX(0);
    }
    25% {
        transform: translateX(-5px);
    }
    75% {
        transform: translateX(5px);
    }
}
</style>
@endpush 