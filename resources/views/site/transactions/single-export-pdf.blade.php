<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __("lang.site_export") }} {{ __("lang.admin_transactions") }} #{{ $transaction->id }} - {{ setting('site_name') }}</title>
    <style>
        :root {
            --bg: #f8f9fa;
            --card: #ffffff;
            --text: #2c3e50;
            --muted: #6c757d;
            --border: #e9ecef;
            --primary: #3498db;
            --primary-dark: #2c80b6;
            --secondary: #2c3e50;
            --secondary-dark: #34495e;
            --success: #27ae60;
            --warning: #f39c12;
            --danger: #e74c3c;
            --shadow: 0 20px 40px rgba(0,0,0,0.08);
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            color: var(--text);
            background: var(--bg);
        }
        
        .export-container {
            max-width: 900px;
            margin: 2rem auto;
            background: var(--card);
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
            border: 1px solid var(--border);
            position: relative;
        }
        
        .export-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            padding: 3.25rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .export-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="exportPattern" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23exportPattern)"/></svg>');
            opacity: 0.3;
        }
        
        .export-header > * {
            position: relative;
            z-index: 2;
        }
        
        .export-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        
        .export-badge i {
            color: var(--primary);
        }
        
        .export-header h1 {
            font-size: 2.6rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .export-header p {
            font-size: 1.05rem;
            opacity: 0.9;
            color: rgba(255, 255, 255, 0.85);
        }
        
        .export-content {
            padding: 3rem 2.25rem;
        }
        
        /* Export meta */
        .export-meta {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin: -2rem 0 2rem 0;
        }
        .meta-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.04);
        }
        .meta-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--muted);
            margin-bottom: 0.25rem;
            font-weight: 600;
        }
        .meta-value {
            font-weight: 800;
            color: var(--text);
        }
        
        .transaction-overview {
            background: linear-gradient(135deg, #f8f9fa 0%, rgba(255, 255, 255, 0.8) 100%);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }
        
        .transaction-overview::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        }
        
        .overview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            position: relative;
            z-index: 2;
        }
        
        .overview-item {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid var(--border);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .overview-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .overview-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 1.5rem;
        }
        
        .overview-item:nth-child(1) .overview-icon {
            background: linear-gradient(135deg, var(--primary), #2980b9);
        }
        
        .overview-item:nth-child(2) .overview-icon {
            background: linear-gradient(135deg, var(--warning), #e67e22);
        }
        
        .overview-item:nth-child(3) .overview-icon {
            background: linear-gradient(135deg, var(--success), #229954);
        }
        
        .overview-item:nth-child(4) .overview-icon {
            background: linear-gradient(135deg, var(--danger), #c0392b);
        }
        
        .overview-title {
            font-size: 0.9rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .overview-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text);
        }
        
        .details-section {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: relative;
        }
        
        .details-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 16px 16px 0 0;
        }
        
        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border);
        }
        
        .section-title i {
            color: var(--primary);
        }
        
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .details-table th {
            background: linear-gradient(135deg, var(--secondary-dark), var(--secondary));
            color: white;
            padding: 1rem 0.75rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
        }
        
        .details-table th:first-child {
            border-radius: 8px 0 0 8px;
        }
        
        .details-table th:last-child {
            border-radius: 0 8px 8px 0;
        }
        
        .details-table td {
            padding: 1rem 0.75rem;
            border-bottom: 1px solid var(--border);
            color: #495057;
            vertical-align: top;
        }
        
        .details-table tbody tr:nth-child(even) {
            background: var(--bg);
        }
        
        .details-table tbody tr:hover {
            background: rgba(52, 152, 219, 0.05);
        }
        
        .type-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .type-badge.subscription {
            background: rgba(243, 156, 18, 0.15);
            color: var(--warning);
            border: 1px solid rgba(243, 156, 18, 0.3);
        }
        
        .type-badge.donation {
            background: rgba(231, 76, 60, 0.15);
            color: var(--danger);
            border: 1px solid rgba(231, 76, 60, 0.3);
        }
        
        .type-badge.refund {
            background: rgba(52, 152, 219, 0.15);
            color: var(--primary);
            border: 1px solid rgba(52, 152, 219, 0.3);
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-badge.completed {
            background: rgba(39, 174, 96, 0.15);
            color: var(--success);
            border: 1px solid rgba(39, 174, 96, 0.3);
        }
        
        .status-badge.pending {
            background: rgba(243, 156, 18, 0.15);
            color: var(--warning);
            border: 1px solid rgba(243, 156, 18, 0.3);
        }
        
        .status-badge.failed {
            background: rgba(231, 76, 60, 0.15);
            color: var(--danger);
            border: 1px solid rgba(231, 76, 60, 0.3);
        }
        
        .amount-highlight {
            background: linear-gradient(135deg, rgba(52, 152, 219, 0.1), rgba(44, 128, 182, 0.1));
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid rgba(52, 152, 219, 0.2);
            text-align: center;
            margin: 2rem 0;
            position: relative;
        }
        
        .amount-highlight .amount {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            font-family: 'Courier New', monospace;
            margin-bottom: 0.5rem;
        }
        
        .amount-highlight .label {
            color: var(--muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }
        
        .export-footer {
            background: var(--bg);
            padding: 1.5rem;
            text-align: center;
            border-radius: 12px;
            border: 1px solid var(--border);
            margin-top: 2rem;
        }
        
        .footer-note {
            color: var(--muted);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            line-height: 1.6;
        }
        
        /* Decorative watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            font-size: 4rem;
            font-weight: 900;
            color: rgba(44, 62, 80, 0.03);
            user-select: none;
            pointer-events: none;
            white-space: nowrap;
        }
        
        /* Paid stamp */
        .export-stamp {
            position: absolute;
            top: -12px;
            right: -12px;
            background: rgba(39, 174, 96, 0.12);
            color: var(--success);
            border: 2px solid rgba(39, 174, 96, 0.6);
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            transform: rotate(6deg);
        }
        
        /* Print Styles */
        @media print {
            @page {
                size: A4;
                margin: 16mm;
            }
            body {
                background: white;
            }
            
            .export-container {
                max-width: none;
                margin: 0;
                box-shadow: none;
                border: none;
            }
            
            .watermark {
                display: none !important;
            }
            
            .export-header {
                background: #2c3e50 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .export-container {
                margin: 1rem;
                border-radius: 12px;
            }
            
            .export-header {
                padding: 2rem 1.5rem;
            }
            
            .export-header h1 {
                font-size: 2rem;
            }
            
            .export-content {
                padding: 2rem 1.5rem;
            }
            
            .overview-grid {
                grid-template-columns: 1fr;
            }
            
            .export-meta {
                grid-template-columns: 1fr;
                margin: -1rem 0 1.5rem 0;
            }
        }
    </style>
</head>
<body>
    <div class="export-container">
        <div class="watermark">{{ setting('site_name') }}</div>
        <!-- Export Header -->
        <div class="export-header">
            <div class="export-badge">
                <i class="fas fa-file-export"></i>
                <span>{{ __("lang.export_transaction_export") }}</span>
            </div>
            <h1>{{ __("lang.admin_transactions") }} #{{ $transaction->id }}</h1>
            <p>{{ setting('site_name') }} - {{ __("lang.export_exported_on") }} {{ $export_date }}</p>
        </div>

        <!-- Export Content -->
        <div class="export-content">
            <!-- Meta quick facts -->
            <div class="export-meta">
                <div class="meta-card">
                    <div class="meta-label">{{ __("lang.export_transaction_id") }}</div>
                    <div class="meta-value">#{{ $transaction->id }}</div>
                </div>
                <div class="meta-card">
                    <div class="meta-label">{{ __("lang.invoice_type") }}</div>
                    <div class="meta-value">{{ $transaction->type_label ?? ucfirst($transaction->type) }}</div>
                </div>
                <div class="meta-card">
                    <div class="meta-label">{{ __("lang.invoice_status") }}</div>
                    <div class="meta-value">{{ $transaction->status_label ?? ucfirst($transaction->status) }}</div>
                </div>
                <div class="meta-card">
                    <div class="meta-label">{{ __("lang.invoice_date") }}</div>
                    <div class="meta-value">{{ $transaction->created_at->format('d/m/Y') }}</div>
                </div>
            </div>

            <!-- Transaction Overview -->
            <div class="transaction-overview">
                @if($transaction->status === 'completed')
                    <div class="export-stamp">{{ __("lang.invoice_paid") }}</div>
                @endif
                <div class="overview-grid">
                    <div class="overview-item">
                        <div class="overview-icon">
                            <i class="fas fa-hashtag"></i>
                        </div>
                        <div class="overview-title">{{ __("lang.admin_transaction_id") }}</div>
                        <div class="overview-value">#{{ $transaction->id }}</div>
                    </div>
                    <div class="overview-item">
                        <div class="overview-icon">
                            @if($transaction->type === 'subscription')
                                <i class="fas fa-crown"></i>
                            @elseif($transaction->type === 'donation')
                                <i class="fas fa-heart"></i>
                            @else
                                <i class="fas fa-undo"></i>
                            @endif
                        </div>
                        <div class="overview-title">{{ __("lang.site_type") }}</div>
                        <div class="overview-value">{{ $transaction->type_label ?? ucfirst($transaction->type) }}</div>
                    </div>
                    <div class="overview-item">
                        <div class="overview-icon">
                            @if($transaction->status === 'completed')
                                <i class="fas fa-check"></i>
                            @elseif($transaction->status === 'pending')
                                <i class="fas fa-clock"></i>
                            @else
                                <i class="fas fa-times"></i>
                            @endif
                        </div>
                        <div class="overview-title">{{ __("lang.site_status") }}</div>
                        <div class="overview-value">{{ $transaction->status_label ?? ucfirst($transaction->status) }}</div>
                    </div>
                    <div class="overview-item">
                        <div class="overview-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="overview-title">{{ __("lang.site_date") }}</div>
                        <div class="overview-value">{{ $transaction->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Amount Highlight -->
            <div class="amount-highlight">
                <div class="amount">€{{ number_format($transaction->amount, 2) }}</div>
                <div class="label">{{ __("lang.site_amount") }}</div>
            </div>

            <!-- Transaction Details -->
            <div class="details-section">
                <h2 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    {{ __("lang.export_transaction_details") }}
                </h2>
                <table class="details-table">
                    <thead>
                        <tr>
                            <th>{{ __("lang.export_field") }}</th>
                            <th>{{ __("lang.export_information") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>{{ __("lang.admin_transaction_id") }}</strong></td>
                            <td>#{{ $transaction->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __("lang.export_transaction_type") }}</strong></td>
                            <td>
                                <span class="type-badge {{ $transaction->type }}">
                                    @if($transaction->type === 'subscription')
                                        <i class="fas fa-crown"></i>
                                    @elseif($transaction->type === 'donation')
                                        <i class="fas fa-heart"></i>
                                    @else
                                        <i class="fas fa-undo"></i>
                                    @endif
                                    {{ $transaction->type_label ?? ucfirst($transaction->type) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>{{ __("lang.invoice_description") }}</strong></td>
                            <td>{{ $transaction->description }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __("lang.invoice_amount") }}</strong></td>
                            <td style="font-weight: 700; color: var(--success); font-size: 1.1rem;">€{{ number_format($transaction->amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __("lang.site_status") }}</strong></td>
                            <td>
                                <span class="status-badge {{ $transaction->status }}">
                                    @if($transaction->status === 'completed')
                                        <i class="fas fa-check"></i>
                                    @elseif($transaction->status === 'pending')
                                        <i class="fas fa-clock"></i>
                                    @elseif($transaction->status === 'failed')
                                        <i class="fas fa-times"></i>
                                    @elseif($transaction->status === 'cancelled')
                                        <i class="fas fa-ban"></i>
                                    @else
                                        <i class="fas fa-undo"></i>
                                    @endif
                                    {{ $transaction->status_label ?? ucfirst($transaction->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>{{ __("lang.export_payment_method") }}</strong></td>
                            <td>
                                @if($transaction->payment_method === 'stripe')
                                    <i class="fab fa-cc-stripe"></i> Stripe
                                @elseif($transaction->payment_method === 'paypal')
                                    <i class="fab fa-paypal"></i> PayPal
                                @else
                                    {{ $transaction->payment_method_label ?? ucfirst($transaction->payment_method) }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>{{ __("lang.export_creation_date") }}</strong></td>
                            <td>{{ $transaction->created_at->format('d/m/Y à H:i') }}</td>
                        </tr>
                        @if($transaction->processed_at)
                        <tr>
                            <td><strong>{{ __("lang.export_processing_date") }}</strong></td>
                            <td>{{ $transaction->processed_at->format('d/m/Y à H:i') }}</td>
                        </tr>
                        @endif
                        @if($transaction->transaction_id)
                        <tr>
                            <td><strong>{{ __("lang.export_external_transaction_id") }}</strong></td>
                            <td style="font-family: 'Courier New', monospace;">{{ $transaction->transaction_id }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong>{{ __("lang.export_client_name") }}</strong></td>
                            <td>{{ $transaction->user->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __("lang.export_client_email") }}</strong></td>
                            <td>{{ $transaction->user->email }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Additional Details based on Transaction {{ __("lang.site_type") }} -->
            @if($transaction->type === 'subscription' && $transaction->subscription)
            <div class="details-section">
                <h2 class="section-title">
                    <i class="fas fa-crown"></i>
                    {{ __("lang.export_subscription_details") }}
                </h2>
                <table class="details-table">
                    <thead>
                        <tr>
                            <th>{{ __("lang.export_field") }}</th>
                            <th>{{ __("lang.export_information") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>{{ __("lang.export_subscription_plan") }}</strong></td>
                            <td>{{ $transaction->subscription->membershipPlan->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __("lang.export_start_date") }}</strong></td>
                            <td>{{ $transaction->subscription->start_date ? $transaction->subscription->start_date->format('d/m/Y') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __("lang.export_end_date") }}</strong></td>
                            <td>{{ $transaction->subscription->end_date ? $transaction->subscription->end_date->format('d/m/Y') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __("lang.export_subscription_status") }}</strong></td>
                            <td>
                                <span class="status-badge {{ $transaction->subscription->is_active ? 'completed' : 'failed' }}">
                                    @if($transaction->subscription->is_active)
                                        <i class="fas fa-check"></i> {{ __("lang.export_active") }}
                                    @else
                                        <i class="fas fa-times"></i> {{ __("lang.export_inactive") }}
                                    @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>{{ __("lang.export_amount_paid") }}</strong></td>
                            <td style="font-weight: 700; color: var(--success);">€{{ number_format($transaction->subscription->amount_paid ?? $transaction->amount, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif

            @if($transaction->type === 'donation' && $transaction->donation)
            <div class="details-section">
                <h2 class="section-title">
                    <i class="fas fa-heart"></i>
                    {{ __("lang.export_donation_details") }}
                </h2>
                <table class="details-table">
                    <thead>
                        <tr>
                            <th>{{ __("lang.export_field") }}</th>
                            <th>{{ __("lang.export_information") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>{{ __("lang.export_donor_name") }}</strong></td>
                            <td>{{ $transaction->donation->is_anonymous ? __("lang.export_anonymous") : $transaction->donation->donor_name }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __("lang.export_donor_email") }}</strong></td>
                            <td>{{ $transaction->donation->is_anonymous ? __("lang.export_anonymous") : $transaction->donation->donor_email }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __("lang.export_donation_type") }}</strong></td>
                            <td>
                                {{ $transaction->donation->is_recurring ? __("lang.export_recurring_donation") : __("lang.export_one_time_donation") }}
                                @if($transaction->donation->is_recurring)
                                    ({{ ucfirst($transaction->donation->recurring_interval ?? 'mensuel') }})
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>{{ __("lang.export_donation_amount") }}</strong></td>
                            <td style="font-weight: 700; color: var(--danger);">€{{ number_format($transaction->donation->amount ?? $transaction->amount, 2) }}</td>
                        </tr>
                        @if($transaction->donation->message)
                        <tr>
                            <td><strong>{{ __("lang.export_donor_message") }}</strong></td>
                            <td style="font-style: italic; color: var(--muted);">{{ $transaction->donation->message }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        <!-- Export Footer -->
        <div class="export-footer">
            <p class="footer-note">
                <strong>{{ __("lang.invoice_note") }}:</strong> {{ __("lang.export_document_generated") }} {{ $export_date }}.
            </p>
            <p class="footer-note">
                <strong>{{ setting('site_name') }}</strong> - {{ __("lang.invoice_company_description") }}<br>
                {{ __("lang.export_contact_us") }} {{ setting('contact_email') ?: 'friverdenmedia@outlook.fr' }}
            </p>
        </div>
    </div>
</body>
</html>
