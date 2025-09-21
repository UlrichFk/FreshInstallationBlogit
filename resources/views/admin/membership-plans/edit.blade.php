@extends('admin.layout.app')

@section('title', '{{ __("lang.admin_edit_membership_plan") }}')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __("lang.admin_edit_membership_plan") }}: {{ $plan->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/update-membership-plan') }}" method="POST" id="editPlanForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $plan->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Plan Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $plan->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                               id="price" name="price" value="{{ old('price', $plan->price) }}" 
                                               step="0.01" min="0" required>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="currency" class="form-label">Currency</label>
                                    <select class="form-select @error('currency') is-invalid @enderror" 
                                            id="currency" name="currency">
                                        <option value="USD" {{ old('currency', $plan->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                                        <option value="EUR" {{ old('currency', $plan->currency) == 'EUR' ? 'selected' : '' }}>EUR</option>
                                        <option value="GBP" {{ old('currency', $plan->currency) == 'GBP' ? 'selected' : '' }}>GBP</option>
                                        <option value="CAD" {{ old('currency', $plan->currency) == 'CAD' ? 'selected' : '' }}>CAD</option>
                                    </select>
                                    @error('currency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="billing_cycle" class="form-label">Billing Cycle <span class="text-danger">*</span></label>
                                    <select class="form-select @error('billing_cycle') is-invalid @enderror" 
                                            id="billing_cycle" name="billing_cycle" required>
                                        <option value="">Select Billing Cycle</option>
                                        <option value="monthly" {{ old('billing_cycle', $plan->billing_cycle) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                        <option value="yearly" {{ old('billing_cycle', $plan->billing_cycle) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                        <option value="lifetime" {{ old('billing_cycle', $plan->billing_cycle) == 'lifetime' ? 'selected' : '' }}>Lifetime</option>
                                    </select>
                                    @error('billing_cycle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="duration_days" class="form-label">Duration (Days) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('duration_days') is-invalid @enderror" 
                                           id="duration_days" name="duration_days" value="{{ old('duration_days', $plan->duration_days) }}" 
                                           min="1" required>
                                    <small class="form-text text-muted">Number of days the plan is valid for</small>
                                    @error('duration_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                           id="sort_order" name="sort_order" value="{{ old('sort_order', $plan->sort_order) }}" 
                                           min="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $plan->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="features" class="form-label">Features</label>
                            <div id="featuresContainer">
                                @if($plan->features && is_array($plan->features))
                                    @foreach($plan->features as $feature)
                                    <div class="feature-item mb-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="features[]" 
                                                   value="{{ $feature }}" placeholder="{{ __("lang.admin_enter_feature") }}">
                                            <button type="button" class="btn btn-outline-danger remove-feature">
                                                <i class="ti ti-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="feature-item mb-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="features[]" 
                                                   placeholder="{{ __("lang.admin_enter_feature_placeholder") }}">
                                            <button type="button" class="btn btn-outline-danger remove-feature">
                                                <i class="ti ti-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="addFeature">
                                <i class="ti ti-plus me-1"></i> Add Feature
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" 
                                               name="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active Plan
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_featured" 
                                               name="is_featured" value="1" {{ old('is_featured', $plan->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            Featured Plan
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ url('admin/membership-plans') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Plan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Add feature field
    $('#addFeature').click(function() {
        const featureHtml = `
            <div class="feature-item mb-2">
                <div class="input-group">
                    <input type="text" class="form-control" name="features[]" 
                           placeholder="{{ __("lang.admin_enter_feature_placeholder") }}">
                    <button type="button" class="btn btn-outline-danger remove-feature">
                        <i class="ti ti-minus"></i>
                    </button>
                </div>
            </div>
        `;
        $('#featuresContainer').append(featureHtml);
    });

    // Remove feature field
    $(document).on('click', '.remove-feature', function() {
        $(this).closest('.feature-item').remove();
    });

    // Auto-calculate duration days based on billing cycle
    $('#billing_cycle').change(function() {
        const cycle = $(this).val();
        let days = 0;
        
        switch(cycle) {
            case 'monthly':
                days = 30;
                break;
            case 'yearly':
                days = 365;
                break;
            case 'lifetime':
                days = 36500; // 100 years
                break;
        }
        
        if (days > 0) {
            $('#duration_days').val(days);
        }
    });
});
</script>
@endpush 