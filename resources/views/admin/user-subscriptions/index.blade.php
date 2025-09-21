@extends('admin.layout.app')

@section('title', 'User Subscriptions')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">User Subscriptions</h5>
                    @can('add-user-subscription')
                    <a href="{{ url('admin/user-subscriptions/create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Add New Subscription
                    </a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="userSubscriptionsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Plan</th>
                                    <th>Status</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subscriptions as $subscription)
                                <tr>
                                    <td>{{ $subscription->id }}</td>
                                    <td>
                                        <strong>{{ $subscription->user->name ?? 'N/A' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $subscription->user->email ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $subscription->membershipPlan->name ?? 'N/A' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $subscription->membershipPlan->billing_cycle ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        @if($subscription->status == 'active')
                                            <span class="badge bg-label-success">Active</span>
                                        @elseif($subscription->status == 'expired')
                                            <span class="badge bg-label-danger">Expired</span>
                                        @elseif($subscription->status == 'cancelled')
                                            <span class="badge bg-label-warning">Cancelled</span>
                                        @else
                                            <span class="badge bg-label-secondary">{{ ucfirst($subscription->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $subscription->start_date ? $subscription->start_date->format('M d, Y') : 'N/A' }}</td>
                                    <td>
                                        {{ $subscription->end_date ? $subscription->end_date->format('M d, Y') : 'N/A' }}
                                        @if($subscription->is_expired)
                                            <br><small class="text-danger">Expired {{ $subscription->end_date->diffForHumans() }}</small>
                                        @elseif($subscription->days_remaining > 0)
                                            <br><small class="text-success">{{ $subscription->days_remaining }} days remaining</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary">{{ $subscription->formatted_amount }}</span>
                                        <br>
                                        <small class="text-muted">{{ ucfirst($subscription->payment_method ?? 'N/A') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @can('view-user-subscription')
                                            <a href="{{ url('admin/user-subscriptions/'.$subscription->id) }}" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            @endcan
                                            @can('edit-user-subscription')
                                            <a href="{{ url('admin/user-subscriptions/edit/'.$subscription->id) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            @endcan
                                            @can('delete-user-subscription')
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-subscription" 
                                                    data-id="{{ $subscription->id }}" data-user="{{ $subscription->user->name ?? 'N/A' }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                            @endcan
                                            @if($subscription->status == 'active' && $subscription->auto_renew)
                                                @can('edit-user-subscription')
                                                <button type="button" class="btn btn-sm btn-outline-warning cancel-subscription" 
                                                        data-id="{{ $subscription->id }}" data-user="{{ $subscription->user->name ?? 'N/A' }}">
                                                    <i class="ti ti-x"></i>
                                                </button>
                                                @endcan
                                            @endif
                                            @if($subscription->status == 'cancelled' || $subscription->status == 'expired')
                                                @can('edit-user-subscription')
                                                <button type="button" class="btn btn-sm btn-outline-success renew-subscription" 
                                                        data-id="{{ $subscription->id }}" data-user="{{ $subscription->user->name ?? 'N/A' }}">
                                                    <i class="ti ti-refresh"></i>
                                                </button>
                                                @endcan
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __("lang.admin_confirm_delete") }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the subscription for user "<strong id="userName"></strong>"?</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Confirmation Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __("lang.admin_confirm_cancel") }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel the subscription for user "<strong id="cancelUserName"></strong>"?</p>
                <p class="text-warning">This will prevent auto-renewal of the subscription.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="cancelForm" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-warning">Cancel Subscription</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Renew Confirmation Modal -->
<div class="modal fade" id="renewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Renew</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to renew the subscription for user "<strong id="renewUserName"></strong>"?</p>
                <p class="text-success">This will extend the subscription period.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="renewForm" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success">Renew Subscription</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#userSubscriptionsTable').DataTable({
        responsive: true,
        order: [[0, 'desc']]
    });

    // Delete subscription
    $('.delete-subscription').click(function() {
        const id = $(this).data('id');
        const userName = $(this).data('user');
        
        $('#userName').text(userName);
        $('#deleteForm').attr('action', '{{ url("admin/user-subscriptions") }}/' + id);
        $('#deleteModal').modal('show');
    });

    // Cancel subscription
    $('.cancel-subscription').click(function() {
        const id = $(this).data('id');
        const userName = $(this).data('user');
        
        $('#cancelUserName').text(userName);
        $('#cancelForm').attr('action', '{{ url("admin/user-subscriptions") }}/' + id + '/cancel');
        $('#cancelModal').modal('show');
    });

    // Renew subscription
    $('.renew-subscription').click(function() {
        const id = $(this).data('id');
        const userName = $(this).data('user');
        
        $('#renewUserName').text(userName);
        $('#renewForm').attr('action', '{{ url("admin/user-subscriptions") }}/' + id + '/renew');
        $('#renewModal').modal('show');
    });
});
</script>
@endpush 