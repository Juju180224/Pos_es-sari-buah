<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchase Receipt #{{ $purchase->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 11px;
            line-height: 1.4;
            width: 70mm;
            padding: 5mm;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 10px;
            margin: 2px 0;
        }

        .section {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #000;
        }

        .section-title {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }

        .info-label {
            font-weight: bold;
            width: 45%;
        }

        .info-value {
            width: 55%;
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        th {
            text-align: left;
            padding: 5px 0;
            border-bottom: 1px solid #000;
            font-weight: bold;
            font-size: 10px;
        }

        td {
            padding: 5px 0;
            font-size: 10px;
        }

        .item-name {
            width: 50%;
        }

        .item-qty {
            width: 15%;
            text-align: center;
        }

        .item-price {
            width: 35%;
            text-align: right;
        }

        .total-section {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #000;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            font-size: 12px;
        }

        .total-row.grand-total {
            font-size: 14px;
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border: 1px solid #000;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px dashed #000;
            font-size: 10px;
        }

        .barcode {
            text-align: center;
            margin: 10px 0;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>

@php
    $itemsTotal = $purchase->items->sum(
        fn($item) => $item->purchase_price * $item->quantity
    );
@endphp

<!-- Header -->
<div class="header">
    <h1>{{ config('app.name') }}</h1>
    <p>STRUK PEMBELIAN</p>
    @if(config('settings.store_address'))
        <p>{{ config('settings.store_address') }}</p>
    @endif
    @if(config('settings.store_phone'))
        <p>Tel: {{ config('settings.store_phone') }}</p>
    @endif
</div>

<!-- Purchase Info -->
<div class="section">
    <div class="info-row">
        <span class="info-label">Receipt #:</span>
        <span class="info-value">{{ str_pad($purchase->id, 6, '0', STR_PAD_LEFT) }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Date:</span>
        <span class="info-value">
            {{ \Illuminate\Support\Carbon::parse($purchase->purchase_date)->format('d/m/Y') }}
        </span>
    </div>
    <div class="info-row">
        <span class="info-label">Status:</span>
        <span class="info-value">
            <span class="status-badge">{{ $purchase->status }}</span>
        </span>
    </div>
    <div class="info-row">
        <span class="info-label">Dibuat oleh:</span>
        <span class="info-value">{{ $purchase->user->name ?? '-' }}</span>
    </div>
</div>

<!-- Supplier Info -->
<div class="section">
    <div class="section-title">Supplier</div>
    <div class="info-row">
        <span class="info-label">Name:</span>
        <span class="info-value">
            {{ trim(($purchase->supplier->first_name ?? '') . ' ' . ($purchase->supplier->last_name ?? '')) ?: '-' }}
        </span>
    </div>
    @if(!empty($purchase->supplier->phone))
        <div class="info-row">
            <span class="info-label">Phone:</span>
            <span class="info-value">{{ $purchase->supplier->phone }}</span>
        </div>
    @endif
</div>

<!-- Items -->
<div class="section">
    <div class="section-title">Items</div>
    <table>
        <thead>
        <tr>
            <th class="item-name">Item</th>
            <th class="item-qty">Qty</th>
            <th class="item-price">Price</th>
        </tr>
        </thead>
        <tbody>
        @foreach($purchase->items as $item)
            <tr>
                <td class="item-name">
                    {{ $item->product->name ?? 'Produk Dihapus' }}<br>
                    <small style="font-size: 9px;">
                        {{ config('settings.currency_symbol') }}{{ number_format($item->purchase_price, 2) }} / pcs
                    </small>
                </td>
                <td class="item-qty">{{ $item->quantity }}</td>
                <td class="item-price">
                    {{ config('settings.currency_symbol') }}{{ number_format($item->purchase_price * $item->quantity, 2) }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- Total -->
<div class="total-section">
    <div class="total-row">
        <span>Subtotal Items:</span>
        <span>{{ config('settings.currency_symbol') }}{{ number_format($itemsTotal, 2) }}</span>
    </div>
    <div class="total-row grand-total">
        <span>TOTAL:</span>
        <span>{{ config('settings.currency_symbol') }}{{ number_format($purchase->total_amount, 2) }}</span>
    </div>
    <div class="info-row" style="margin-top: 10px;">
        <span class="info-label">Total Items:</span>
        <span class="info-value">{{ $purchase->items->sum('quantity') }} pcs</span>
    </div>
</div>

@if(!empty($purchase->notes))
    <div class="section">
        <div class="section-title">Notes</div>
        <p style="font-size: 10px;">{{ $purchase->notes }}</p>
    </div>
@endif

<!-- Barcode -->
<div class="barcode">
    *{{ str_pad($purchase->id, 6, '0', STR_PAD_LEFT) }}*
</div>

<!-- Footer -->
<div class="footer">
    <p>Purchase Receipt</p>
    <p style="margin-top: 5px;">{{ now()->format('d/m/Y H:i:s') }}</p>
    <p style="margin-top: 10px; font-size: 9px;">
        This is a computer generated receipt.<br>
        No signature required.
    </p>
</div>
</body>
</html>