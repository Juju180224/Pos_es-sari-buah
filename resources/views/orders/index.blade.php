@extends('layouts.admin')

@section('title', __('order.Orders_List'))
@section('content-header', __('order.Orders_List'))

@section('content-actions')
    <a href="{{ route('cart.index') }}" class="btn btn-primary">
        {{ __('sidebar.pos') }}
    </a>
@endsection

@section('content')

    <div class="card">
        <div class="card-body">

            <!-- FILTER -->
            <div class="row">
                <div class="col-md-7"></div>
                <div class="col-md-5">
                    <form action="{{ route('orders.index') }}">
                        <div class="row">
                            <div class="col-md-5">
                                <input type="date" name="start_date" class="form-control"
                                    value="{{ request('start_date') }}" />
                            </div>
                            <div class="col-md-5">
                                <input type="date" name="end_date" class="form-control"
                                    value="{{ request('end_date') }}" />
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-outline-primary" type="submit">
                                    {{ __('order.submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TABLE -->
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('order.ID') }}</th>
                        <th>{{ __('order.Customer_Name') }}</th>
                        <th>{{ __('order.Total') }}</th>
                        <th>{{ __('order.Received_Amount') }}</th>
                        <th>{{ __('order.Status') }}</th>
                        <th>{{ __('order.To_Pay') }}</th>
                        <th>{{ __('order.Created_At') }}</th>
                        <th>{{ __('order.Actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($orders as $order)
                        @php
                            $orderTotal = $order->total();
                            $orderReceived = $order->receivedAmount();
                            $orderRemaining = $orderTotal - $orderReceived;
                        @endphp

                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->getCustomerName() }}</td>
                            <td>{{ config('settings.currency_symbol') }} {{ number_format($orderTotal, 2) }}</td>
                            <td>{{ config('settings.currency_symbol') }} {{ number_format($orderReceived, 2) }}</td>

                            <td>
                                @if ($orderReceived == 0)
                                    <span class="badge badge-danger">{{ __('order.Not_Paid') }}</span>
                                @elseif($orderReceived < $orderTotal)
                                    <span class="badge badge-warning">{{ __('order.Partial') }}</span>
                                @else
                                    <span class="badge badge-success">{{ __('order.Paid') }}</span>
                                @endif
                            </td>

                            <td>{{ config('settings.currency_symbol') }} {{ number_format($orderRemaining, 2) }}</td>
                            <td>{{ $order->created_at }}</td>

                            <td>
                                <!-- VIEW -->
                                <button class="btn btn-sm btn-secondary btnShowInvoice" data-toggle="modal"
                                    data-target="#modalInvoice" data-order-id="{{ $order->id }}"
                                    data-customer-name="{{ $order->getCustomerName() }}" data-total="{{ $orderTotal }}"
                                    data-received="{{ $orderReceived }}" data-items='@json($order->items)'
                                    data-created-at="{{ $order->created_at }}">
                                    <ion-icon size="small" name="eye"></ion-icon>
                                </button>

                                <!-- PARTIAL -->
                                @if ($orderRemaining > 0)
                                    <button class="btn btn-sm btn-primary btnPartialPayment" data-toggle="modal"
                                        data-target="#partialPaymentModal" data-order-id="{{ $order->id }}"
                                        data-remaining-amount="{{ $orderRemaining }}">
                                        {{ __('order.Pay_Partial') }}
                                    </button>
                                @endif

                                <!-- PRINT RECEIPT (hanya jika sudah ada pembayaran) -->
                                @if ($orderReceived > 0)
                                    <a href="{{ route('orders.receipt', $order->id) }}" target="_blank"
                                        class="btn btn-sm btn-info">
                                        <ion-icon size="small" name="print"></ion-icon>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>{{ config('settings.currency_symbol') }} {{ number_format($total, 2) }}</th>
                        <th>{{ config('settings.currency_symbol') }} {{ number_format($receivedAmount, 2) }}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>

            {{ $orders->render() }}

        </div>
    </div>

    <!-- ================= MODAL PARTIAL ================= -->
    <div class="modal fade" id="partialPaymentModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">{{ __('order.Pay_Partial') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="POST" action="{{ route('orders.partial-payment') }}">
                    @csrf

                    <div class="modal-body">
                        <input type="hidden" name="order_id" id="modalOrderId">

                        <div class="form-group">
                            <label>{{ __('order.Payment_Method') }}</label>
                            <select class="form-control" name="payment_method" id="paymentMethod" required>
                                <option value="cash">Cash</option>
                                <option value="qris">QRIS</option>
                                <option value="transfer_bca">Transfer BCA</option>
                                <option value="transfer_bni">Transfer BNI</option>
                                <option value="transfer_mandiri">Transfer Mandiri</option>
                                <option value="transfer_bri">Transfer BRI</option>
                                <option value="ovo">OVO</option>
                                <option value="gopay">GoPay</option>
                                <option value="dana">DANA</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>{{ __('order.Enter_Amount') }}</label>
                            <input type="number" class="form-control" step="0.01" id="partialAmount" name="amount"
                                required>

                            <small class="text-muted">
                                {{ __('order.Remaining') }}:
                                <span id="remainingAmount"></span>
                            </small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            {{ __('common.Cancel') }}
                        </button>
                        <button type="button" class="btn btn-success" id="btnPayFull">
                            {{ __('order.Pay_Full') }}
                        </button>
                        <button class="btn btn-primary">
                            {{ __('order.Submit_Payment') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection


@section('model')
    <!-- ================= MODAL INVOICE ================= -->
    <div class="modal fade" id="modalInvoice">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">{{ __('order.Invoice') }}</h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body"></div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">
                        {{ __('common.Close') }}
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        jQuery(function($) {

            let currencySymbol = '{{ config('settings.currency_symbol') }}';

            $(document).on('click', '.btnShowInvoice', function() {

                let btn = $(this);

                let orderId = btn.data('order-id');
                let name = btn.data('customer-name');
                let total = btn.data('total');
                let paid = btn.data('received');
                let date = btn.data('created-at');
                let items = btn.data('items');

                let status = paid == 0 ?
                    '<span class="badge badge-danger">{{ __('order.Not_Paid') }}</span>' :
                    paid < total ?
                    '<span class="badge badge-warning">{{ __('order.Partial') }}</span>' :
                    '<span class="badge badge-success">{{ __('order.Paid') }}</span>';

                let rows = '';

                if (items?.length) {
                    items.forEach((item, i) => {
                        rows += `
                    <tr>
                        <td>${i+1}</td>
                        <td>${item.product?.name ?? '-'}</td>
                        <td>-</td>
                        <td>${currencySymbol} ${item.product?.price ?? 0}</td>
                        <td>${item.quantity}</td>
                        <td>${currencySymbol} ${item.price}</td>
                    </tr>`;
                    });
                } else {
                    rows = `<tr><td colspan="6" class="text-center">{{ __('order.No_Items') }}</td></tr>`;
                }

                $('#modalInvoice .modal-body').html(`
            <div class="card">
                <div class="card-header">
                    {{ __('order.Invoice') }} #${orderId}
                    <span class="float-right">${status}</span>
                </div>

                <div class="card-body">
                    <p><strong>${name}</strong></p>
                    <p>${date}</p>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('order.Item') }}</th>
                                <th>{{ __('order.Description') }}</th>
                                <th>{{ __('order.Unit_Cost') }}</th>
                                <th>{{ __('order.Qty') }}</th>
                                <th>{{ __('order.Total') }}</th>
                            </tr>
                        </thead>

                        <tbody>${rows}</tbody>
                    </table>
                </div>
            </div>
        `);
            });

            $(document).on('click', '.btnPartialPayment', function() {

                let btn = $(this);

                let orderId = btn.data('order-id');
                let remaining = btn.data('remaining-amount');

                $('#modalOrderId').val(orderId);
                $('#remainingAmount').text(currencySymbol + ' ' + parseFloat(remaining).toFixed(2));
                $('#partialAmount').attr('max', remaining);
            });

        });

        $(document).on('click', '#btnPayFull', function() {
            let remaining = $('#partialAmount').attr('max');
            $('#partialAmount').val(remaining);
            $('#partialAmount').closest('form').submit();
        });
    </script>
@endsection