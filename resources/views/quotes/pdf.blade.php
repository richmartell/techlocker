<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quote {{ $quote->quote_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            padding: 40px;
        }
        
        .header {
            margin-bottom: 40px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
        }
        
        .logo-section {
            margin-bottom: 20px;
        }
        
        .logo {
            max-width: 200px;
            max-height: 80px;
        }
        
        .company-info {
            font-size: 9pt;
            color: #666;
            margin-top: 10px;
        }
        
        .quote-title {
            font-size: 28pt;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }
        
        .quote-number {
            font-size: 12pt;
            color: #666;
        }
        
        .info-section {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .info-column {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }
        
        .info-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        
        .info-box h3 {
            font-size: 11pt;
            color: #2563eb;
            margin-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        
        .info-row {
            margin-bottom: 8px;
        }
        
        .info-label {
            font-weight: bold;
            color: #666;
            font-size: 9pt;
        }
        
        .info-value {
            color: #333;
            font-size: 10pt;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .items-table thead {
            background-color: #2563eb;
            color: white;
        }
        
        .items-table th {
            padding: 12px 8px;
            text-align: left;
            font-size: 10pt;
            font-weight: bold;
        }
        
        .items-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 9pt;
        }
        
        .items-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .items-table .description {
            width: 45%;
        }
        
        .items-table .time {
            width: 15%;
            text-align: center;
        }
        
        .items-table .rate {
            width: 15%;
            text-align: right;
        }
        
        .items-table .qty {
            width: 10%;
            text-align: center;
        }
        
        .items-table .total {
            width: 15%;
            text-align: right;
            font-weight: bold;
        }
        
        .totals-section {
            margin-left: auto;
            width: 300px;
            margin-bottom: 30px;
        }
        
        .total-row {
            display: table;
            width: 100%;
            padding: 8px 0;
        }
        
        .total-label {
            display: table-cell;
            text-align: left;
            font-size: 10pt;
            color: #666;
        }
        
        .total-value {
            display: table-cell;
            text-align: right;
            font-size: 10pt;
            font-weight: bold;
        }
        
        .grand-total {
            background-color: #2563eb;
            color: white;
            padding: 12px;
            border-radius: 5px;
            margin-top: 10px;
        }
        
        .grand-total .total-label,
        .grand-total .total-value {
            color: white;
            font-size: 14pt;
            font-weight: bold;
        }
        
        .notes-section {
            margin-top: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 4px solid #2563eb;
        }
        
        .notes-section h3 {
            font-size: 11pt;
            color: #2563eb;
            margin-bottom: 10px;
        }
        
        .notes-section p {
            font-size: 9pt;
            color: #666;
            line-height: 1.6;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 9pt;
            color: #666;
        }
        
        .valid-until {
            background-color: #fef3c7;
            border: 1px solid #fbbf24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 9pt;
            color: #92400e;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            @if($quote->account->branding_logo)
                <div class="logo-section">
                    <img src="{{ storage_path('app/public/' . $quote->account->branding_logo) }}" alt="Company Logo" class="logo">
                </div>
            @endif
            
            <div class="company-info">
                @if($quote->account->branding_trading_name)
                    <strong>{{ $quote->account->branding_trading_name }}</strong><br>
                @endif
                @if($quote->account->branding_address)
                    {{ nl2br(e($quote->account->branding_address)) }}<br>
                @endif
                @if($quote->account->vat_number)
                    VAT No: {{ $quote->account->vat_number }}
                @endif
            </div>
        </div>
        
        <!-- Quote Title -->
        <div style="margin-bottom: 30px;">
            <div class="quote-title">QUOTE</div>
            <div class="quote-number">{{ $quote->quote_number }}</div>
        </div>
        
        <!-- Valid Until Notice -->
        @if($quote->valid_until)
            <div class="valid-until">
                <strong>Valid Until:</strong> {{ $quote->valid_until->format('d/m/Y') }}
            </div>
        @endif
        
        <!-- Customer & Vehicle Info -->
        <div class="info-section">
            <div class="info-column">
                <div class="info-box">
                    <h3>Customer Details</h3>
                    <div class="info-row">
                        <span class="info-value">
                            <strong>{{ $quote->customer->first_name }} {{ $quote->customer->last_name }}</strong>
                        </span>
                    </div>
                    @if($quote->customer->email)
                        <div class="info-row">
                            <span class="info-label">Email:</span>
                            <span class="info-value">{{ $quote->customer->email }}</span>
                        </div>
                    @endif
                    @if($quote->customer->phone)
                        <div class="info-row">
                            <span class="info-label">Phone:</span>
                            <span class="info-value">{{ $quote->customer->phone }}</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="info-column">
                <div class="info-box">
                    <h3>Vehicle Details</h3>
                    <div class="info-row">
                        <span class="info-label">Registration:</span>
                        <span class="info-value"><strong>{{ $quote->vehicle->registration }}</strong></span>
                    </div>
                    @if($quote->vehicle->haynespro_make || $quote->vehicle->haynespro_model)
                        <div class="info-row">
                            <span class="info-label">Make & Model:</span>
                            <span class="info-value">
                                {{ $quote->vehicle->haynespro_make }} {{ $quote->vehicle->haynespro_model }}
                            </span>
                        </div>
                    @endif
                    <div class="info-row">
                        <span class="info-label">Quote Date:</span>
                        <span class="info-value">{{ $quote->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th class="description">Description</th>
                    <th class="time">Time (hrs)</th>
                    <th class="rate">Rate</th>
                    <th class="qty">Qty</th>
                    <th class="total">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quote->items as $item)
                    <tr>
                        <td class="description">{{ $item->description }}</td>
                        <td class="time">{{ number_format($item->time_hours, 2) }}</td>
                        <td class="rate">£{{ number_format($item->labour_rate, 2) }}</td>
                        <td class="qty">{{ $item->quantity }}</td>
                        <td class="total">£{{ number_format($item->line_total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Totals -->
        <div class="totals-section">
            <div class="total-row">
                <span class="total-label">Subtotal:</span>
                <span class="total-value">£{{ number_format($quote->subtotal, 2) }}</span>
            </div>
            
            @if($quote->vat_rate > 0)
                <div class="total-row">
                    <span class="total-label">VAT ({{ number_format($quote->vat_rate, 0) }}%):</span>
                    <span class="total-value">£{{ number_format($quote->vat_amount, 2) }}</span>
                </div>
            @endif
            
            <div class="grand-total">
                <div class="total-row">
                    <span class="total-label">Total:</span>
                    <span class="total-value">£{{ number_format($quote->total, 2) }}</span>
                </div>
            </div>
        </div>
        
        <!-- Notes -->
        @if($quote->notes)
            <div class="notes-section">
                <h3>Additional Notes</h3>
                <p>{{ $quote->notes }}</p>
            </div>
        @endif
        
        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your business!</p>
            <p style="margin-top: 5px; font-size: 8pt;">
                This quote was generated on {{ now()->format('d/m/Y \a\t H:i') }}
            </p>
        </div>
    </div>
</body>
</html>

