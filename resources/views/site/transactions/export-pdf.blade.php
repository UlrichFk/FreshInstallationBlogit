<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __("lang.site_export") }} {{ __("lang.admin_transactions") }} - {{ setting('site_name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            color: #2c3e50;
            background: white;
        }
        
        .export-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .export-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
            border-radius: 12px;
            margin-bottom: 2rem;
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
            background: none;
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
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        
        .export-badge i {
            color: #3498db;
        }
        
        .export-header h1 {
            font-size: 2.25rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #3498db, #2c80b6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .export-header p {
            font-size: 1rem;
            opacity: 0.9;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .summary-section {
            background: linear-gradient(135deg, #f8f9fa 0%, rgba(255, 255, 255, 0.8) 100%);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid #e9ecef;
            position: relative;
            overflow: hidden;
        }
        
        .summary-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #3498db, #2c80b6);
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            position: relative;
            z-index: 2;
        }
        
        .summary-item {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            text-align: center;
        }
        
        .summary-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 1.3rem;
        }
        
        .summary-item:nth-child(1) .summary-icon {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }
        
        .summary-item:nth-child(2) .summary-icon {
            background: linear-gradient(135deg, #27ae60, #229954);
        }
        
        .summary-item:nth-child(3) .summary-icon {
            background: linear-gradient(135deg, #f39c12, #e67e22);
        }
        
        .summary-item:nth-child(4) .summary-icon {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }
        
        .summary-title {
            font-size: 0.85rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .summary-value {
            font-size: 1.3rem;
            font-weight: 800;
            color: #2c3e50;
        }
        
        .transactions-section {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e9ecef;
        }
        
        .section-title i {
            color: #3498db;
        }
        
        .transactions-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        
        .transactions-table th {
            background: linear-gradient(135deg, #34495e, #2c3e50);
            color: white;
            padding: 1rem 0.75rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.8rem;
        }
        
        .transactions-table th:first-child {
            border-radius: 8px 0 0 0;
        }
        
        .transactions-table th:last-child {
            border-radius: 0 8px 0 0;
        }
        
        .transactions-table td {
            padding: 0.75rem;
            border-bottom: 1px solid #e9ecef;
            color: #495057;
            vertical-align: top;
            font-size: 0.9rem;
        }
        
        .transactions-table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .transactions-table tbody tr:hover {
            background: #e3f2fd;
        }
        
        .type-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .type-badge.subscription {
            background: rgba(243, 156, 18, 0.15);
            color: #f39c12;
            border: 1px solid rgba(243, 156, 18, 0.3);
        }
        
        .type-badge.donation {
            background: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
            border: 1px solid rgba(231, 76, 60, 0.3);
        }
        
        .type-badge.refund {
            background: rgba(52, 152, 219, 0.15);
            color: #3498db;
            border: 1px solid rgba(52, 152, 219, 0.3);
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-badge.completed {
            background: rgba(39, 174, 96, 0.15);
            color: #27ae60;
            border: 1px solid rgba(39, 174, 96, 0.3);
        }
        
        .status-badge.pending {
            background: rgba(243, 156, 18, 0.15);
            color: #f39c12;
            border: 1px solid rgba(243, 156, 18, 0.3);
        }
        
        .status-badge.failed {
            background: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
            border: 1px solid rgba(231, 76, 60, 0.3);
        }
        
        .amount-cell {
            font-weight: 700;
            color: #27ae60;
            font-family: 'Courier New', monospace;
        }
        
        .export-footer {
            background: #f8f9fa;
            padding: 1.5rem;
            text-align: center;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            margin-top: 2rem;
        }
        
        .footer-note {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            line-height: 1.6;
        }
        
        /* Print Styles */
        @media print {
            .export-container {
                max-width: none;
                margin: 0;
                padding: 1rem;
            }
            
            .export-header {
                background: #2c3e50 !important;
                -webkit-print-color-adjust: exact;
            }
            
            .transactions-table {
                font-size: 0.8rem;
            }
            
            .transactions-table th,
            .transactions-table td {
                padding: 0.5rem 0.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="export-container">
        <!-- Export Header -->
        <div class="export-header">
            <div class="export-badge">
                <i class="fas fa-file-export"></i>
                <span>{{ __("lang.site_export") }} {{ __("lang.admin_transactions") }}</span>
            </div>
            <h1>{{ __("lang.site_transaction_history") }}</h1>
            <p>{{ setting('site_name') }} - Exporté le {{ $export_date }}</p>
        </div>

        <!-- Summary Section -->
        <div class="summary-section">
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-icon">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div class="summary-title">{{ __("lang.admin_total_transactions") }}</div>
                    <div class="summary-value">{{ $transactions->count() }}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-icon">
                        <i class="fas fa-euro-sign"></i>
                    </div>
                    <div class="summary-title">Montant Total</div>
                    <div class="summary-value">€{{ number_format($transactions->sum('amount'), 2) }}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="summary-title">Complétées</div>
                    <div class="summary-value">{{ $transactions->where('status', 'completed')->count() }}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="summary-title">En Attente</div>
                    <div class="summary-value">{{ $transactions->where('status', 'pending')->count() }}</div>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="transactions-section">
            <h2 class="section-title">
                <i class="fas fa-list"></i>
                {{ __("lang.site_transaction_details") }}
            </h2>
            <table class="transactions-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Méthode</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td style="font-family: 'Courier New', monospace; font-weight: 600;">#{{ $transaction->id }}</td>
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
                        <td>{{ $transaction->description }}</td>
                        <td class="amount-cell">€{{ number_format($transaction->amount, 2) }}</td>
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
                        <td>
                            @if($transaction->payment_method === 'stripe')
                                <i class="fab fa-cc-stripe"></i> Stripe
                            @elseif($transaction->payment_method === 'paypal')
                                <i class="fab fa-paypal"></i> PayPal
                            @else
                                {{ $transaction->payment_method_label ?? ucfirst($transaction->payment_method) }}
                            @endif
                        </td>
                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Export Footer -->
        <div class="export-footer">
            <p class="footer-note">
                <strong>Note:</strong> Ce document a été généré automatiquement le {{ $export_date }}.
            </p>
            <p class="footer-note">
                <strong>{{ setting('site_name') }}</strong> - Journalisme indépendant et analyses approfondies<br>
                Pour toute question, contactez-nous à {{ setting('contact_email') ?: 'friverdenmedia@outlook.fr' }}
            </p>
        </div>
    </div>
</body>
</html> 