<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __("lang.site_invoice_pdf") }} #{{ $transaction->id }} - {{ setting('site_name') }}</title>
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
        
        .invoice-container {
            max-width: 900px;
            margin: 2rem auto;
            background: var(--card);
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
            border: 1px solid var(--border);
            position: relative;
        }
        
        .invoice-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            padding: 3.25rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .invoice-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="invoicePattern" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23invoicePattern)"/></svg>');
            opacity: 0.3;
        }
        
        .invoice-header > * {
            position: relative;
            z-index: 2;
        }
        
        .invoice-badge {
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
        
        .invoice-badge i {
            color: var(--primary);
        }
        
        .invoice-header h1 {
            font-size: 2.6rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .invoice-header p {
            font-size: 1.05rem;
            opacity: 0.9;
            color: rgba(255, 255, 255, 0.85);
        }
        
        .invoice-content {
            padding: 3rem 2.25rem;
        }
        
        /* Invoice meta */
        .invoice-meta {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
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
        
        .invoice-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid var(--border);
        }
        
        .company-info,
        .customer-info {
            background: var(--bg);
            padding: 2rem;
            border-radius: 12px;
            border: 1px solid var(--border);
            position: relative;
        }
        
        .company-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px 12px 0 0;
        }
        
        .customer-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(135deg, var(--success), #229954);
            border-radius: 12px 12px 0 0;
        }
        
        .info-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .info-title i {
            color: var(--primary);
        }
        
        .customer-info .info-title i {
            color: var(--success);
        }
        
        .info-details {
            color: var(--muted);
            line-height: 1.8;
        }
        
        .info-details strong {
            color: var(--text);
            font-weight: 600;
        }
        
        .invoice-details {
            background: linear-gradient(135deg, #f8f9fa 0%, rgba(255, 255, 255, 0.5) 100%);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }
        
        .invoice-details::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        }
        
        .details-table {
            width: 100%;
            border-collapse: collapse;
            position: relative;
            z-index: 2;
        }
        
        .details-table th {
            background: linear-gradient(135deg, #34495e, #2c3e50);
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }
        
        .details-table th:first-child {
            border-radius: 8px 0 0 8px;
        }
        
        .details-table th:last-child {
            border-radius: 0 8px 8px 0;
        }
        
        .details-table td {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid var(--border);
            color: #495057;
        }
        
        .details-table tbody tr:hover {
            background: rgba(52, 152, 219, 0.05);
        }
        
        .transaction-type {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .transaction-type.subscription {
            background: linear-gradient(135deg, rgba(243, 156, 18, 0.15), rgba(230, 126, 34, 0.15));
            color: var(--warning);
            border: 1px solid rgba(243, 156, 18, 0.3);
        }
        
        .transaction-type.donation {
            background: linear-gradient(135deg, rgba(231, 76, 60, 0.15), rgba(192, 57, 43, 0.15));
            color: var(--danger);
            border: 1px solid rgba(231, 76, 60, 0.3);
        }
        
        .transaction-status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .transaction-status.completed {
            background: linear-gradient(135deg, rgba(39, 174, 96, 0.15), rgba(34, 153, 84, 0.15));
            color: var(--success);
            border: 1px solid rgba(39, 174, 96, 0.3);
        }
        
        .amount-cell {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--success);
            font-family: 'Courier New', monospace;
        }
        
        .invoice-summary {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-dark) 100%);
            color: white;
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .invoice-summary::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="summaryPattern" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23summaryPattern)"/></svg>');
            opacity: 0.3;
        }
        
        .invoice-summary > * {
            position: relative;
            z-index: 2;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .summary-row:last-child {
            border-bottom: none;
            padding-top: 1.5rem;
            margin-top: 1rem;
            border-top: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        .summary-label {
            font-weight: 600;
            color: rgba(255, 255, 255, 0.85);
        }
        
        .summary-value {
            font-weight: 700;
            font-size: 1.1rem;
        }
        
        .summary-total {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .invoice-footer {
            background: var(--bg);
            padding: 2rem;
            text-align: center;
            border-top: 1px solid var(--border);
        }
        
        .footer-note {
            color: var(--muted);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.6;
        }
        
        .payment-info {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid var(--border);
            margin-top: 1rem;
        }
        
        .payment-info h4 {
            color: var(--text);
            margin-bottom: 1rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .payment-info h4 i {
            color: var(--primary);
        }
        
        .payment-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .payment-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            background: var(--bg);
            border-radius: 8px;
            border: 1px solid var(--border);
        }
        
        .payment-label {
            font-weight: 600;
            color: var(--muted);
            font-size: 0.9rem;
        }
        
        .payment-value {
            font-weight: 700;
            color: var(--text);
        }
        
        .print-actions {
            margin: 2rem 0;
            text-align: center;
        }
        
        .print-btn {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1rem;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }
        
        .print-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
            color: white;
        }
        
        .download-btn {
            background: linear-gradient(135deg, var(--success), #229954);
            margin-left: 1rem;
        }
        
        .download-btn:hover {
            box-shadow: 0 8px 25px rgba(39, 174, 96, 0.4);
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
        .invoice-stamp {
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
            
            .invoice-container {
                margin: 0;
                box-shadow: none;
                border: none;
            }
            
            .print-actions,
            .watermark {
                display: none !important;
            }
            
            .invoice-header {
                background: #2c3e50 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .invoice-summary {
                background: #34495e !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .invoice-container {
                margin: 1rem;
                border-radius: 12px;
            }
            
            .invoice-header {
                padding: 2rem 1.5rem;
            }
            
            .invoice-header h1 {
                font-size: 2rem;
            }
            
            .invoice-content {
                padding: 2rem 1.5rem;
            }
            
            .invoice-info {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .payment-details {
                grid-template-columns: 1fr;
            }
            
            .print-actions {
                margin: 1rem 0;
            }
            
            .print-btn {
                padding: 0.75rem 1.5rem;
                font-size: 0.9rem;
            }
            
            .download-btn {
                margin-left: 0;
                margin-top: 0.5rem;
            }
            .invoice-meta {
                grid-template-columns: 1fr;
                margin: -1rem 0 1.5rem 0;
            }
        }
        
        /* Enhanced Visual Elements */
        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-indicator.success {
            background: linear-gradient(135deg, rgba(39, 174, 96, 0.15), rgba(34, 153, 84, 0.15));
            color: var(--success);
            border: 1px solid rgba(39, 174, 96, 0.3);
        }
        
        .amount-highlight {
            background: linear-gradient(135deg, rgba(52, 152, 219, 0.1), rgba(44, 128, 182, 0.1));
            padding: 1rem;
            border-radius: 12px;
            border: 1px solid rgba(52, 152, 219, 0.2);
            text-align: center;
            margin: 1rem 0;
        }
        
        .amount-highlight .amount {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            font-family: 'Courier New', monospace;
        }
        
        .company-logo {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            margin-bottom: 1rem;
            border: 2px solid var(--border);
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="watermark">{{ setting('site_name') }}</div>
        <!-- Invoice Header -->
        <div class="invoice-header">
            <div class="invoice-badge">
                <i class="fas fa-file-invoice"></i>
                <span>{{ __("lang.site_invoice_pdf") }}</span>
            </div>
            <h1>{{ __("lang.site_invoice_pdf") }} #{{ $transaction->id }}</h1>
            <p>{{ setting('site_name') }} - {{ __("lang.admin_transactions") }} {{ __("lang.invoice_date") }} {{ $transaction->created_at->format('d/m/Y') }}</p>
        </div>
        
        <!-- Invoice Content -->
        <div class="invoice-content">
            <!-- Meta quick facts -->
            <div class="invoice-meta">
                <div class="meta-card">
                    <div class="meta-label">{{ __("lang.invoice_invoice_number") }}</div>
                    <div class="meta-value">#{{ $transaction->id }}</div>
                </div>
                <div class="meta-card">
                    <div class="meta-label">{{ __("lang.invoice_date") }}</div>
                    <div class="meta-value">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <div class="meta-card">
                    <div class="meta-label">{{ __("lang.invoice_payment_method") }}</div>
                    <div class="meta-value">
                        @if($transaction->payment_method === 'stripe')
                            Stripe
                        @elseif($transaction->payment_method === 'paypal')
                            PayPal
                        @else
                            {{ $transaction->payment_method_label }}
                        @endif
                    </div>
                </div>
            </div>
            <!-- Company and Customer Info -->
            <div class="invoice-info">
                <div class="company-info">
                    <h3 class="info-title">
                        <i class="fas fa-building"></i>
                        {{ __("lang.invoice_company_info") }}
                    </h3>
                    @if(setting('site_logo'))
                        <img src="{{ url('uploads/setting/'.setting('site_logo')) }}" 
                             alt="{{ setting('site_name') }}" 
                             class="company-logo"
                             onerror="this.style.display='none'">
                    @endif
                    <div class="info-details">
                        <strong>{{ setting('site_name') }}</strong><br>
                        <strong>{{ __("lang.invoice_address") }}:</strong> {{ setting('contact_address') ?: 'Vardevegen Nord 7, 4700 Vennesla, Norge' }}<br>
                        <strong>{{ __("lang.invoice_email") }}:</strong> {{ setting('contact_email') ?: 'friverdenmedia@outlook.fr' }}<br>
                        <strong>{{ __("lang.invoice_phone") }}:</strong> {{ setting('contact_phone') ?: '+47 911 42 848' }}<br>
                        <strong>{{ __("lang.invoice_vat_number") }}:</strong> {{ setting('vat_number') ?: 'NO930504645' }}
                    </div>
                </div>
                
                <div class="customer-info">
                    <h3 class="info-title">
                        <i class="fas fa-user"></i>
                        {{ __("lang.invoice_customer_info") }}
                    </h3>
                    <div class="info-details">
                        <strong>{{ $transaction->user->name }}</strong><br>
                        <strong>{{ __("lang.invoice_email") }}:</strong> {{ $transaction->user->email }}<br>
                        <strong>{{ __("lang.invoice_creation_date") }}:</strong> {{ $transaction->created_at->format('d/m/Y') }}<br>
                        <strong>{{ __("lang.admin_id") }} {{ __("lang.admin_user") }}:</strong> #{{ $transaction->user->id }}
                        @if($transaction->user->hasActiveSubscription())
                            <br><strong>{{ __("lang.site_status") }}:</strong> <span class="status-indicator success">
                                <i class="fas fa-crown"></i>
                                {{ __("lang.invoice_premium_member") }}
                            </span>
                    @endif
                    </div>
                </div>
            </div>
            
            <!-- Transaction Details -->
            <div class="invoice-details">
                @if($transaction->status === 'completed')
                    <div class="invoice-stamp">{{ __("lang.invoice_paid") }}</div>
                @endif
                <table class="details-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-list me-2"></i>{{ __("lang.invoice_description") }}</th>
                            <th><i class="fas fa-tag me-2"></i>{{ __("lang.invoice_type") }}</th>
                            <th><i class="fas fa-calendar me-2"></i>{{ __("lang.admin_date") }}</th>
                            <th><i class="fas fa-euro-sign me-2"></i>{{ __("lang.site_amount") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $transaction->description }}</td>
                            <td>
                                <span class="transaction-type {{ $transaction->type }}">
                                    @if($transaction->type === 'subscription')
                                        <i class="fas fa-crown"></i>
                                    @elseif($transaction->type === 'donation')
                                        <i class="fas fa-heart"></i>
                                    @else
                                        <i class="fas fa-undo"></i>
                                    @endif
                                    {{ $transaction->type_label }}
                                </span>
                            </td>
                            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                            <td class="amount-cell">€{{ number_format($transaction->amount, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Amount Highlight -->
            <div class="amount-highlight">
                <div class="amount">€{{ number_format($transaction->amount, 2) }}</div>
                <div style="color: var(--muted); font-weight: 600; margin-top: 0.5rem;">
                    {{ __("lang.invoice_total_amount_paid") }}
                </div>
            </div>

            <!-- Invoice Summary -->
            <div class="invoice-summary">
                <div class="summary-row">
                    <span class="summary-label">{{ __("lang.invoice_subtotal") }}:</span>
                    <span class="summary-value">€{{ number_format($transaction->amount, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">{{ __("lang.invoice_vat") }}:</span>
                    <span class="summary-value">€0.00</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">{{ __("lang.invoice_total") }}:</span>
                    <span class="summary-value summary-total">€{{ number_format($transaction->amount, 2) }}</span>
                </div>
                    </div>

            <!-- Payment Information -->
            <div class="payment-info">
                <h4>
                    <i class="fas fa-credit-card"></i>
                    {{ __("lang.invoice_payment_information") }}
                </h4>
                <div class="payment-details">
                    <div class="payment-item">
                        <span class="payment-label">{{ __("lang.invoice_payment_method") }}:</span>
                        <span class="payment-value">
                            @if($transaction->payment_method === 'stripe')
                                <i class="fab fa-cc-stripe me-1"></i>Stripe
                            @elseif($transaction->payment_method === 'paypal')
                                <i class="fab fa-paypal me-1"></i>PayPal
                            @else
                                {{ $transaction->payment_method_label }}
                            @endif
                        </span>
                    </div>
                    <div class="payment-item">
                        <span class="payment-label">{{ __("lang.site_status") }}:</span>
                        <span class="payment-value">
                            <span class="transaction-status {{ $transaction->status }}">
                                <i class="fas fa-check"></i>
                                {{ $transaction->status_label }}
                            </span>
                        </span>
                    </div>
                    @if($transaction->transaction_id)
                    <div class="payment-item">
                        <span class="payment-label">{{ __("lang.invoice_transaction_id") }}:</span>
                        <span class="payment-value" style="font-family: 'Courier New', monospace;">{{ $transaction->transaction_id }}</span>
                    </div>
                            @endif
                    @if($transaction->processed_at)
                    <div class="payment-item">
                        <span class="payment-label">{{ __("lang.invoice_processed_on") }}:</span>
                        <span class="payment-value">{{ $transaction->processed_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Invoice Footer -->
        <div class="invoice-footer">
            <p class="footer-note">
                <strong>{{ __("lang.invoice_note") }}:</strong> {{ __("lang.invoice_note_text") }} {{ setting('contact_email') ?: 'friverdenmedia@outlook.fr' }}.
            </p>
            <p class="footer-note">
                <strong>{{ setting('site_name') }}</strong> - {{ __("lang.invoice_company_description") }}<br>
                {{ __("lang.invoice_thank_you") }}
            </p>
        </div>
    </div>

    <!-- Print Actions -->
    <div class="print-actions">
        <button onclick="window.print()" class="print-btn">
            <i class="fas fa-print"></i>
            {{ __("lang.invoice_print_invoice") }}
        </button>
        <a href="{{ route('transactions.show', $transaction->id) }}" class="print-btn download-btn">
            <i class="fas fa-arrow-left"></i>
            {{ __("lang.invoice_back_to_details") }}
        </a>
    </div>

    <script>
        // Auto-print functionality (optional)
        document.addEventListener('DOMContentLoaded', function() {
            // Add print functionality
            const printBtn = document.querySelector('.print-btn');
            if (printBtn) {
                printBtn.addEventListener('click', function() {
                    window.print();
                });
            }
            
            // Add download as PDF functionality (if needed)
            // This would require additional implementation
        });
    </script>
</body>
</html>
