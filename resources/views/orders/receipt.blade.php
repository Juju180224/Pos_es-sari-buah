<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Receipt #{{ $order->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Courier New', monospace; font-size: 11px; line-height: 1.4; width: 70mm; padding: 5mm; }
        .header { text-align: center; margin-bottom: 10px; border-bottom: 1px dashed #000; padding-bottom: 10px; }
        .header h1 { font-size: 16px; font-weight: bold; margin-bottom: 5px; }
        .header p { font-size: 10px; margin: 2px 0; }
        .section { margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px dashed #000; }
        .section-title { font-weight: bold; font-size: 12px; margin-bottom: 5px; text-transform: uppercase; }
        .info-row { display: flex; justify-content: space-between; margin: 3px 0; }
        .info-label { font-weight: bold; width: 45%; }
        .info-value { width: 55%; text-align: right; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th { text-align: left; padding: 5px 0; border-bottom: 1px solid #000; font-weight: bold; font-size: 10px; }
        td { padding: 5px 0; font-size: 10px; }
        .item-name { width: 50%; }
        .item-qty { width: 15%; text-align: center; }
        .item-price { width: 35%; text-align: right; }
        .total-section { margin-top: 10px; padding-top: 10px; border-top: 2px solid #000; }
        .total-row { display: flex; justify-content: space-between; margin: 5px 0; font-size: 12px; }
        .total-row.grand-total { font-size: 14px; font-weight: bold; border-top: 1px solid #000; padding-top: 5px; margin-top: 5px; }
        .status-badge { display: inline-block; padding: 3px 8px; border: 1px solid #000; font-weight: bold; font-size: 10px; }
        .footer { text-align: center; margin-top: 15px; padding-top: 10px; border-top: 1px dashed #000; font-size: 10px; }
        .barcode { text-align: center; margin: 10px 0; font-size: 24px; font-weight: bold; letter-spacing: 2px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mb-5 { margin-bottom: 5px; }
    </style>
</head>
<body>

@php
    $orderTotal = $order->total();
    $orderReceived = $order->receivedAmount();
    $orderRemaining = $orderTotal - $orderReceived;

    $statusLabel = $orderReceived == 0
        ? 'BELUM DIBAYAR'
        : ($orderReceived < $orderTotal ? 'SEBAGIAN' : 'LUNAS');
@endphp

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

<div class="section">
    <div class="info-row">
        <span class="info-label">Receipt #:</span>
        <span class="info-value">{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Date:</span>
        <span class="info-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Status:</span>
        <span class="info-value"><span class="status-badge">{{ $statusLabel }}</span></span>
    </div>
    <div class="info-row">
        <span class="info-label">Kasir:</span>
        <span class="info-value">{{ $order->user->name ?? 'QR Order' }}</span>
    </div>
</div>

<div class="section">
    <div class="section-title">Customer Information</div>
    <div class="info-row">
        <span class="info-label">Name:</span>
        <span class="info-value">{{ $order->getCustomerName() }}</span>
    </div>
    @if($order->customer && $order->customer->phone)
        <div class="info-row">
            <span class="info-label">Phone:</span>
            <span class="info-value">{{ $order->customer->phone }}</span>
        </div>
    @endif
</div>

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
        @foreach($order->items as $item)
            <tr>
                <td class="item-name">
                    {{ $item->product->name ?? 'Produk Dihapus' }}<br>
                    <small style="font-size: 9px;">
                        {{ config('settings.currency_symbol') }}{{ number_format($item->price, 2) }} / pcs
                    </small>
                </td>
                <td class="item-qty">{{ $item->quantity }}</td>
                <td class="item-price">
                    {{ config('settings.currency_symbol') }}{{ number_format($item->price * $item->quantity, 2) }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="total-section">
    <div class="total-row">
        <span>Subtotal:</span>
        <span>{{ config('settings.currency_symbol') }}{{ number_format($orderTotal, 2) }}</span>
    </div>
    <div class="total-row grand-total">
        <span>TOTAL:</span>
        <span>{{ config('settings.currency_symbol') }}{{ number_format($orderTotal, 2) }}</span>
    </div>
    <div class="total-row">
        <span>Dibayar:</span>
        <span>{{ config('settings.currency_symbol') }}{{ number_format($orderReceived, 2) }}</span>
    </div>
    <div class="total-row">
        <span>Sisa:</span>
        <span>{{ config('settings.currency_symbol') }}{{ number_format($orderRemaining, 2) }}</span>
    </div>
    <div class="info-row" style="margin-top: 10px;">
        <span class="info-label">Total Items:</span>
        <span class="info-value">{{ $order->items->sum('quantity') }} pcs</span>
    </div>
</div>

@if($order->payments->isNotEmpty())
    <div class="section">
        <div class="section-title">Riwayat Pembayaran</div>
        @foreach($order->payments as $payment)
            <div class="info-row">
                <span class="info-label" style="font-weight: normal;">
                    {{ $payment->created_at->format('d/m/Y H:i') }}
                    @if(!empty($payment->payment_method))
                        ({{ strtoupper($payment->payment_method) }})
                    @endif
                </span>
                <span class="info-value">
                    {{ config('settings.currency_symbol') }}{{ number_format($payment->amount, 2) }}
                </span>
            </div>
        @endforeach
    </div>
@endif

<div class="barcode">
    *{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}*
</div>

<div class="footer">
    <p>Thank you for your business!</p>
    <p style="margin-top: 5px;">{{ now()->format('d/m/Y H:i:s') }}</p>
    <p style="margin-top: 10px; font-size: 9px;">
        This is a computer generated receipt.<br>
        No signature required.
    </p>
</div>
</body>
</html>