<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">

        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">

        <span class="brand-text font-weight-light">
            {{ config('app.name') }}
        </span>

    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <nav class="mt-2">

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                <!-- Dashboard -->
                <li class="nav-item">

                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-tachometer-alt"></i>

                        <p>{{ __('dashboard.title') }}</p>

                    </a>

                </li>

                <!-- Products -->
                <li class="nav-item">

                    <a href="{{ route('products.index') }}" class="nav-link {{ activeSegment('products') }}">

                        <i class="nav-icon fas fa-th-large"></i>

                        <p>{{ __('product.title') }}</p>

                    </a>

                </li>

                <!-- SALES -->
                <li class="nav-header">{{ __('sidebar.sales') }}</li>

                <!-- POS -->
                <li class="nav-item">

                    <a href="{{ route('cart.index') }}" class="nav-link {{ activeSegment('cart') }}">

                        <i class="nav-icon fas fa-cart-plus"></i>

                        <p>{{ __('sidebar.pos') }}</p>

                    </a>

                </li>

                <!-- Orders -->
                <li class="nav-item">

                    <a href="{{ route('orders.index') }}" class="nav-link {{ activeSegment('orders') }}">

                        <i class="nav-icon fas fa-shopping-cart"></i>

                        <p>{{ __('sidebar.order_list') }}</p>

                    </a>

                </li>

                <!-- Customers -->
                <li class="nav-item">

                    <a href="{{ route('customers.index') }}" class="nav-link {{ activeSegment('customers') }}">

                        <i class="nav-icon fas fa-users"></i>

                        <p>{{ __('customer.title') }}</p>

                    </a>

                </li>

                <!-- PURCHASES -->
                <li class="nav-header">{{ __('sidebar.purchases') }}</li>

                <li class="nav-item {{ request()->routeIs('purchases.*') ? 'menu-open' : '' }}">

                    <a href="#" class="nav-link {{ activeSegment('purchases') }}">

                        <i class="nav-icon fas fa-box"></i>

                        <p>
                            {{ __('sidebar.purchases') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>

                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">

                            <a href="{{ route('purchases.create') }}"
                                class="nav-link {{ request()->routeIs('purchases.create') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>{{ __('sidebar.new_purchase') }}</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="{{ route('purchases.index') }}"
                                class="nav-link {{ request()->routeIs('purchases.index') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>{{ __('sidebar.all_purchases') }}</p>

                            </a>

                        </li>

                    </ul>

                </li>

                <!-- Supplier -->
                <li class="nav-item">

                    <a href="{{ route('suppliers.index') }}" class="nav-link {{ activeSegment('suppliers') }}">

                        <i class="nav-icon fas fa-truck"></i>

                        <p>{{ __('sidebar.supplier') }}</p>

                    </a>

                </li>

                <!-- Raw Materials -->
<li class="nav-item">

    <a href="{{ route('raw-materials.index') }}"
        class="nav-link {{ activeSegment('raw-materials') }}">

        <i class="nav-icon fas fa-boxes"></i>

        <p>Bahan Baku</p>

    </a>

</li>

                <!-- SMART ANALYSIS -->
                <li class="nav-header">SMART ANALYSIS</li>

                <li class="nav-item {{ request()->is('admin/smart*') ? 'menu-open' : '' }}">

                    <a href="#" class="nav-link {{ request()->is('admin/smart*') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-brain"></i>

                        <p>
                            Smart
                            <i class="right fas fa-angle-left"></i>
                        </p>

                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('smart.kriteria') }}"
                                class="nav-link {{ request()->routeIs('smart.kriteria') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Kriteria</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('smart.alternatif') }}"
                                class="nav-link {{ request()->routeIs('smart.alternatif') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Alternatif</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('smart.penilaian') }}"
                                class="nav-link {{ request()->routeIs('smart.penilaian') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Penilaian</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('smart.proses') }}"
                                class="nav-link {{ request()->routeIs('smart.proses') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Proses SMART</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('smart.hasil') }}"
                                class="nav-link {{ request()->routeIs('smart.hasil') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hasil Ranking</p>
                            </a>
                        </li>

                    </ul>

                </li>

                <!-- EXTRA -->
                <li class="nav-header">{{ __('sidebar.extra') }}</li>

                <!-- Settings -->
                <li class="nav-item">

                    <a href="{{ route('settings.index') }}" class="nav-link {{ activeSegment('settings') }}">

                        <i class="nav-icon fas fa-cogs"></i>

                        <p>{{ __('settings.title') }}</p>

                    </a>

                </li>

                <!-- Logout -->
                <li class="nav-item">

                    <a href="#" class="nav-link"
                        onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">

                        <i class="nav-icon fas fa-sign-out-alt"></i>

                        <p>{{ __('common.Logout') }}</p>

                    </a>

                    <form action="{{ route('logout') }}" method="POST" id="logout-form" class="d-none">

                        @csrf

                    </form>

                </li>

            </ul>

        </nav>

    </div>

</aside>
