@extends('admin/layout/app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4 display-inline-block">
        <span class="text-muted fw-light">
            <a href="{{url('admin/dashboard')}}">{{__('lang.admin_dashboard')}}</a> / </span> {{__('lang.admin_transactions')}} {{__('lang.admin_list')}}
    </h4>
    
    <!-- Statistiques -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{ asset('admin-assets/img/icons/unicons/chart-success.png') }}" alt="chart success" class="rounded">
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">{{__('lang.admin_total_transactions')}}</span>
                    <h3 class="card-title mb-2">{{ $stats['total_transactions'] ?? 0 }}</h3>
                    <small class="text-success fw-semibold">{{__('lang.admin_amount')}}: {{ number_format($stats['total_amount'] ?? 0, 2) }} USD</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{ asset('admin-assets/img/icons/unicons/wallet-info.png') }}" alt="Credit Card" class="rounded">
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">{{__('lang.admin_completed_transactions')}}</span>
                    <h3 class="card-title text-nowrap mb-1">{{ $stats['completed_transactions'] ?? 0 }}</h3>
                    <small class="text-success fw-semibold">{{__('lang.admin_amount')}}: {{ number_format($stats['completed_amount'] ?? 0, 2) }} USD</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{ asset('admin-assets/img/icons/unicons/paypal.png') }}" alt="paypal" class="rounded">
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">{{__('lang.admin_pending_transactions')}}</span>
                    <h3 class="card-title text-nowrap mb-1">{{ $stats['pending_transactions'] ?? 0 }}</h3>
                    <small class="text-warning fw-semibold">{{__('lang.admin_amount')}}: {{ number_format($stats['pending_amount'] ?? 0, 2) }} USD</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{ asset('admin-assets/img/icons/unicons/cc-warning.png') }}" alt="Credit Card" class="rounded">
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">{{__('lang.admin_refunded_transactions')}}</span>
                    <h3 class="card-title text-nowrap mb-1">{{ $stats['refunded_transactions'] ?? 0 }}</h3>
                    <small class="text-danger fw-semibold">{{__('lang.admin_amount')}}: {{ number_format($stats['refunded_amount'] ?? 0, 2) }} USD</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card margin-bottom-20">
        <div class="card-header">
            <form method="get">
                <div class="row">
                    <h5 class="card-title display-inline-block">{{__('lang.admin_filters')}}</h5>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">{{__('lang.admin_select_user')}}</label>
                            <select id="user_id" name="user_id" class="form-select">
                                <option value="">{{__('lang.admin_select_user')}}</option>
                                @if(isset($users))
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name ?? __('lang.admin_anonymous') }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="type" class="form-label">{{__('lang.admin_type')}}</label>
                            <select id="type" name="type" class="form-select">
                                <option value="">{{__('lang.admin_select_type')}}</option>
                                <option value="completed" {{ request('type') == 'completed' ? 'selected' : '' }}>{{__('lang.admin_completed')}}</option>
                                <option value="pending" {{ request('type') == 'pending' ? 'selected' : '' }}>{{__('lang.admin_pending')}}</option>
                                <option value="refunded" {{ request('type') == 'refunded' ? 'selected' : '' }}>{{__('lang.admin_refunded')}}</option>
                                <option value="failed" {{ request('type') == 'failed' ? 'selected' : '' }}>{{__('lang.admin_failed')}}</option>
                                <option value="cancelled" {{ request('type') == 'cancelled' ? 'selected' : '' }}>{{__('lang.admin_cancelled')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">{{__('lang.admin_payment_method')}}</label>
                            <select id="payment_method" name="payment_method" class="form-select">
                                <option value="">{{__('lang.admin_select_payment_method')}}</option>
                                <option value="paypal" {{ request('payment_method') == 'paypal' ? 'selected' : '' }}>{{__('lang.admin_paypal')}}</option>
                                <option value="stripe" {{ request('payment_method') == 'stripe' ? 'selected' : '' }}>{{__('lang.admin_stripe')}}</option>
                                <option value="razorpay" {{ request('payment_method') == 'razorpay' ? 'selected' : '' }}>{{__('lang.admin_razorpay')}}</option>
                                <option value="paytm" {{ request('payment_method') == 'paytm' ? 'selected' : '' }}>{{__('lang.admin_paytm')}}</option>
                                <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>{{__('lang.admin_bank_transfer')}}</option>
                                <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>{{__('lang.admin_cash')}}</option>
                                <option value="credit_card" {{ request('payment_method') == 'credit_card' ? 'selected' : '' }}>{{__('lang.admin_credit_card')}}</option>
                                <option value="debit_card" {{ request('payment_method') == 'debit_card' ? 'selected' : '' }}>{{__('lang.admin_debit_card')}}</option>
                                <option value="wallet" {{ request('payment_method') == 'wallet' ? 'selected' : '' }}>{{__('lang.admin_wallet')}}</option>
                                <option value="upi" {{ request('payment_method') == 'upi' ? 'selected' : '' }}>{{__('lang.admin_upi')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="date_from" class="form-label">{{__('lang.admin_date_range')}}</label>
                            <div class="d-flex">
                                <input type="date" id="date_from" name="date_from" class="form-control me-2" value="{{ request('date_from') }}">
                                <input type="date" id="date_to" name="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary me-2">{{__('lang.admin_search')}}</button>
                        <a href="{{ url()->current() }}" class="btn btn-outline-secondary me-2">{{__('lang.admin_reset')}}</a>
                        <button type="submit" name="export" value="1" class="btn btn-success">{{__('lang.admin_export')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des transactions -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{__('lang.admin_transactions')}} {{__('lang.admin_list')}}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{__('lang.admin_id')}}</th>
                            <th>{{__('lang.admin_transaction_id')}}</th>
                            <th>{{__('lang.admin_user')}}</th>
                            <th>{{__('lang.admin_amount')}}</th>
                            <th>{{__('lang.admin_payment_method')}}</th>
                            <th>{{__('lang.admin_status')}}</th>
                            <th>{{__('lang.admin_date')}}</th>
                            <th>{{__('lang.admin_action')}}</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if(isset($transactions) && $transactions->count() > 0)
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>#{{ $transaction->id }}</td>
                                    <td>{{ $transaction->transaction_id ?? '-' }}</td>
                                    <td>
                                        @if($transaction->user)
                                            {{ $transaction->user->name }}
                                        @else
                                            <span class="text-muted">{{__('lang.admin_anonymous')}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>${{ number_format($transaction->amount ?? 0, 2) }}</strong>
                                    </td>
                                    <td>
                                        @switch($transaction->payment_method ?? '')
                                            @case('paypal')
                                                <span class="badge bg-label-primary">{{__('lang.admin_paypal')}}</span>
                                                @break
                                            @case('stripe')
                                                <span class="badge bg-label-info">{{__('lang.admin_stripe')}}</span>
                                                @break
                                            @case('razorpay')
                                                <span class="badge bg-label-warning">{{__('lang.admin_razorpay')}}</span>
                                                @break
                                            @case('paytm')
                                                <span class="badge bg-label-secondary">{{__('lang.admin_paytm')}}</span>
                                                @break
                                            @default
                                                <span class="badge bg-label-dark">{{ ucfirst($transaction->payment_method ?? 'N/A') }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        @switch($transaction->status ?? '')
                                            @case('completed')
                                                <span class="badge bg-label-success">{{__('lang.admin_completed')}}</span>
                                                @break
                                            @case('pending')
                                                <span class="badge bg-label-warning">{{__('lang.admin_pending')}}</span>
                                                @break
                                            @case('refunded')
                                                <span class="badge bg-label-danger">{{__('lang.admin_refunded')}}</span>
                                                @break
                                            @case('failed')
                                                <span class="badge bg-label-danger">{{__('lang.admin_failed')}}</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-label-secondary">{{__('lang.admin_cancelled')}}</span>
                                                @break
                                            @default
                                                <span class="badge bg-label-dark">{{ ucfirst($transaction->status ?? 'Unknown') }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y, H:i') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="viewTransaction({{ $transaction->id }})">
                                                    <i class="bx bx-show me-1"></i> {{__('lang.admin_view_transaction')}}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">{{__('lang.admin_record_not_found')}}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
            @if(isset($transactions) && $transactions->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal pour voir les détails de la transaction -->
<div class="modal fade" id="transactionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">{{__('lang.admin_view_transaction')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="transactionDetails">
                <!-- Le contenu sera chargé ici -->
            </div>
        </div>
    </div>
</div>

<script>
function viewTransaction(transactionId) {
    // Ici vous pouvez ajouter la logique pour afficher les détails de la transaction
    // Par exemple, faire un appel AJAX pour récupérer les détails
    $('#transactionModal').modal('show');
    
    // Exemple de contenu statique - à remplacer par un appel AJAX réel
    document.getElementById('transactionDetails').innerHTML = `
        <div class="row">
            <div class="col-12">
                <p><strong>{{__('lang.admin_transaction_id')}}:</strong> TXN-${transactionId}</p>
                <p><strong>{{__('lang.admin_status')}}:</strong> <span class="badge bg-label-success">{{__('lang.admin_completed')}}</span></p>
                <p><strong>{{__('lang.admin_amount')}}:</strong> $XX.XX</p>
                <p><strong>{{__('lang.admin_payment_method')}}:</strong> PayPal</p>
                <p><strong>{{__('lang.admin_date')}}:</strong> ${new Date().toLocaleString()}</p>
            </div>
        </div>
    `;
}
</script>
@endsection
