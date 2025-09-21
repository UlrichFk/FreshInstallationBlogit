@extends('admin.layout.app')

@section('title', 'Membership Plans')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Membership Plans</h5>
                    @can('add-membership-plan')
                    <a href="{{ url('admin/add-membership-plan') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Add New Plan
                    </a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="membershipPlansTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plans as $plan)
                                <tr>
                                    <td>{{ $plan->id }}</td>
                                    <td>
                                        <strong>{{ $plan->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $plan->description }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary">{{ $plan->formatted_price }}</span>
                                        <br>
                                        <small class="text-muted">{{ ucfirst($plan->billing_cycle) }}</small>
                                    </td>
                                    <td>{{ $plan->duration_text }}</td>
                                    <td>
                                        @if($plan->is_active)
                                            <span class="badge bg-label-success">Active</span>
                                        @else
                                            <span class="badge bg-label-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($plan->is_featured)
                                            <span class="badge bg-label-warning">Featured</span>
                                        @else
                                            <span class="badge bg-label-secondary">Regular</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @can('update-membership-plan')
                                            <a href="{{ url('admin/edit-membership-plan/'.$plan->id) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            @endcan
                                            @can('delete-membership-plan')
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-plan" 
                                                    data-id="{{ $plan->id }}" data-name="{{ $plan->name }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                            @endcan
                                            @can('update-membership-plan')
                                            <button type="button" class="btn btn-sm btn-outline-{{ $plan->is_active ? 'warning' : 'success' }} toggle-status" 
                                                    data-id="{{ $plan->id }}" data-status="{{ $plan->is_active ? 0 : 1 }}">
                                                <i class="ti ti-{{ $plan->is_active ? 'eye-off' : 'eye' }}"></i>
                                            </button>
                                            @endcan
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
                <p>Are you sure you want to delete the plan "<strong id="planName"></strong>"?</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
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
    $('#membershipPlansTable').DataTable({
        responsive: true,
        order: [[0, 'desc']]
    });

    // Delete plan
    $('.delete-plan').click(function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        
        $('#planName').text(name);
        $('#deleteForm').attr('action', '{{ url("admin/delete-membership-plan") }}/' + id);
        $('#deleteModal').modal('show');
    });

    // Handle delete form submission
    $('#deleteForm').submit(function(e) {
        e.preventDefault();
        
        const form = $(this);
        const action = form.attr('action');
        
        $.ajax({
            url: action,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function(response) {
                $('#deleteModal').modal('hide');
                toastr.success('Plan supprimé avec succès');
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function(xhr) {
                $('#deleteModal').modal('hide');
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error('Erreur lors de la suppression du plan');
                }
            }
        });
    });

    // Toggle status
    $('.toggle-status').click(function() {
        const id = $(this).data('id');
        const status = $(this).data('status');
        
        $.ajax({
            url: '{{ url("admin/update-membership-plan-status") }}/' + id + '/' + status,
            type: 'GET',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('An error occurred. Please try again.');
            }
        });
    });
});
</script>
@endpush 