@extends('layouts.admin')

@section('content-header', __('dashboard.title'))

@section('content')

    <div class="container-fluid">

        <!-- STAT BOX -->
        <div class="row">

            <!-- TOTAL ORDER -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $orders_count }}</h3>
                        <p>Total Orders</p>
                    </div>

                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>

                    <a href="{{ route('orders.index') }}" class="small-box-footer">
                        More Info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- TOTAL INCOME -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>
                            {{ config('settings.currency_symbol') }}
                            {{ number_format($income, 2) }}
                        </h3>

                        <p>Total Income</p>
                    </div>

                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>

                    <a href="{{ route('orders.index') }}" class="small-box-footer">
                        More Info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- TODAY INCOME -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">

                        <h3>
                            {{ config('settings.currency_symbol') }}
                            {{ number_format($income_today, 2) }}
                        </h3>

                        <p>Income Today</p>

                    </div>

                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>

                    <a href="{{ route('orders.index') }}" class="small-box-footer">
                        More Info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- CUSTOMERS -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">

                    <div class="inner">
                        <h3>{{ $customers_count }}</h3>
                        <p>Total Customers</p>
                    </div>

                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>

                    <a href="{{ route('customers.index') }}" class="small-box-footer">
                        More Info <i class="fas fa-arrow-circle-right"></i>
                    </a>

                </div>
            </div>

        </div>

    </div>

    <!-- SMART ANALYTICS -->
    <div class="container-fluid my-3">

        <div class="row">

            <!-- SMART INFO -->
            <div class="col-md-6">

                <div class="card">

                    <div class="card-header bg-primary">
                        <h3 class="card-title">
                            Smart Analytics
                        </h3>
                    </div>

                    <div class="card-body">

                        <p>
                            🔥 Best Selling Product :
                            <strong>
                                {{ $best_selling_products->first()->name ?? 'No Data' }}
                            </strong>
                        </p>

                        <p>
                            ⚠ Low Stock Products :
                            <strong>
                                {{ $low_stock_products->count() }}
                            </strong>
                        </p>

                        <p>
                            💰 Income Today :
                            <strong>
                                Rp {{ number_format($income_today, 0) }}
                            </strong>
                        </p>

                        <p>
                            📦 Total Orders :
                            <strong>
                                {{ $orders_count }}
                            </strong>
                        </p>

                        <p>
                            👥 Customers :
                            <strong>
                                {{ $customers_count }}
                            </strong>
                        </p>

                    </div>

                </div>

            </div>

            <!-- SALES CHART -->
            <div class="col-md-6">

                <div class="card">

                    <div class="card-header bg-success">
                        <h3 class="card-title">
                            Sales Analytics
                        </h3>
                    </div>

                    <div class="card-body">
                        <canvas id="salesChart"></canvas>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- PRODUCT TABLE -->
    <div class="container-fluid">

        <div class="row">

            <!-- LOW STOCK -->
            <div class="col-6 my-2">

                <h3>Low Stock Products</h3>

                <div class="card product-list">

                    <div class="card-body">

                        <table class="table">

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Barcode</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($low_stock_products as $product)
                                    <tr>

                                        <td>{{ $product->id }}</td>

                                        <td>{{ $product->name }}</td>

                                        <td>
                                            <img src="{{ asset('images/' . $product->image) }}" width="50">
                                        </td>

                                        <td>{{ $product->barcode }}</td>

                                        <td>{{ $product->price }}</td>

                                        <td>{{ $product->quantity }}</td>

                                        <td>

                                            <span class="badge badge-{{ $product->status ? 'success' : 'danger' }}">

                                                {{ $product->status ? 'Active' : 'Inactive' }}

                                            </span>

                                        </td>

                                        <td>{{ $product->updated_at }}</td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <!-- BEST SELLING -->
            <div class="col-6 my-2">

                <h3>Best Selling Products</h3>

                <div class="card product-list">

                    <div class="card-body">

                        <table class="table">

                            <thead>

                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Barcode</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Updated At</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($best_selling_products as $product)
                                    <tr>

                                        <td>{{ $product->id }}</td>

                                        <td>{{ $product->name }}</td>

                                        <td>
                                            <img class="product-img" src="{{ asset('images/' . $product->image) }}"
                                                width="50">
                                        </td>

                                        <td>{{ $product->barcode }}</td>

                                        <td>{{ $product->price }}</td>

                                        <td>{{ $product->quantity }}</td>

                                        <td>

                                            <span class="badge badge-{{ $product->status ? 'success' : 'danger' }}">

                                                {{ $product->status ? 'Active' : 'Inactive' }}

                                            </span>

                                        </td>

                                        <td>{{ $product->updated_at }}</td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- CHART JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('salesChart');

        new Chart(ctx, {

            type: 'bar',

            data: {

                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],

                datasets: [{

                    label: 'Sales',

                    data: [120000, 190000, 300000, 500000, 200000, 450000, 350000],

                    borderWidth: 1

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false

            }

        });
    </script>

@endsection
