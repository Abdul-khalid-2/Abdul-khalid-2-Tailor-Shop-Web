@php
    $specialtyLabels = [
        'shalwar_kameez' => 'Shalwar Kameez',
        'sherwani' => 'Sherwani',
        'all' => 'All Types',
    ];

    $activeOrders = $tailor->orders->filter(function ($order) {
        return ! in_array($order->status?->name, ['Delivered', 'Cancelled'], true);
    });

    $historyOrders = $tailor->orders->filter(function ($order) {
        return in_array($order->status?->name, ['Delivered', 'Cancelled'], true);
    });
@endphp

<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    @endpush

    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="las la-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="las la-exclamation-circle mr-2"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        {{-- Header --}}
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-start">
                    <div>
                        <h3 class="font-weight-bold mb-2">{{ $tailor->name }}</h3>
                        <p class="mb-1"><i class="las la-phone mr-1"></i> {{ $tailor->phone }}</p>
                        @if($tailor->cnic)
                            <p class="mb-1 text-muted"><i class="las la-id-card mr-1"></i> {{ $tailor->cnic }}</p>
                        @endif
                        <p class="mb-1 text-muted">
                            <i class="las la-calendar mr-1"></i>
                            Joined: {{ $tailor->joining_date ? $tailor->joining_date->format('d M, Y') : '—' }}
                        </p>
                        <p class="mb-1">
                            <strong>Specialty:</strong> {{ $specialtyLabels[$tailor->specialty] ?? $tailor->specialty }}
                        </p>
                        <p class="mb-1">
                            <strong>Branch:</strong> {{ $tailor->branch?->name ?? '—' }}
                        </p>
                        <span class="badge badge-{{ $tailor->status === 'active' ? 'success' : 'warning' }}">
                            {{ $tailor->status === 'active' ? 'Active' : 'On Leave' }}
                        </span>
                    </div>
                    <div class="d-flex flex-wrap mt-2 mt-md-0">
                        <a href="{{ route('tailors.edit', $tailor) }}" class="btn btn-primary mr-2 mb-2">
                            <i class="las la-edit mr-1"></i> Edit
                        </a>
                        <form action="{{ route('tailors.toggle', $tailor) }}" method="POST" class="mb-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-{{ $tailor->status === 'active' ? 'warning' : 'success' }}">
                                <i class="las la-toggle-on mr-1"></i>
                                {{ $tailor->status === 'active' ? 'Mark On Leave' : 'Mark Active' }}
                            </button>
                        </form>
                        <a href="{{ route('tailors.index') }}" class="btn btn-outline-secondary mb-2 ml-2">
                            <i class="las la-arrow-left mr-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Work Stats --}}
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Orders</div>
                        <div class="h4 mb-0 font-weight-bold">{{ $tailor->total_orders_assigned }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Suits</div>
                        <div class="h4 mb-0 font-weight-bold">{{ $tailor->total_suits_assigned }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Completed</div>
                        <div class="h4 mb-0 font-weight-bold">{{ $tailor->orders_completed }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending</div>
                        <div class="h4 mb-0 font-weight-bold">{{ $tailor->orders_pending }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Payment Stats --}}
        <div class="row mb-4">
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Fee Earned</div>
                        <div class="h4 mb-0 font-weight-bold text-primary">Rs {{ number_format($tailor->total_fee_earned, 0) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Fee Received</div>
                        <div class="h4 mb-0 font-weight-bold text-success">Rs {{ number_format($tailor->total_fee_received, 0) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-left-{{ $tailor->total_fee_balance > 0 ? 'danger' : 'secondary' }} shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-{{ $tailor->total_fee_balance > 0 ? 'danger' : 'secondary' }} text-uppercase mb-1">Balance</div>
                        <div class="h4 mb-0 font-weight-bold {{ $tailor->total_fee_balance > 0 ? 'text-danger' : 'text-secondary' }}">
                            Rs {{ number_format($tailor->total_fee_balance, 0) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Active Orders --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Active Orders</h6>
            </div>
            <div class="card-body p-0">
                @if($activeOrders->count())
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Order#</th>
                                    <th>Customer</th>
                                    <th>Label</th>
                                    <th class="text-center">Suits</th>
                                    <th>Delivery Date</th>
                                    <th>Status</th>
                                    <th class="text-right">Fee Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeOrders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('orders.show', $order) }}" class="font-weight-bold">
                                                {{ $order->order_number }}
                                            </a>
                                        </td>
                                        <td>{{ $order->customer?->name ?? '—' }}</td>
                                        <td>{{ $order->order_label ?: '—' }}</td>
                                        <td class="text-center">{{ $order->total_suits }}</td>
                                        <td>
                                            @if($order->delivery_date)
                                                {{ $order->delivery_date->format('d M, Y') }}
                                                @if($order->isOverdue())
                                                    <span class="text-danger font-weight-bold ml-1">OVERDUE</span>
                                                @endif
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td>@include('dashboard.orders.partials.status-badge', ['order' => $order])</td>
                                        <td class="text-right {{ $order->tailor_fee_balance > 0 ? 'text-danger font-weight-bold' : '' }}">
                                            Rs {{ number_format($order->tailor_fee_balance, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted py-4">No active orders assigned.</div>
                @endif
            </div>
        </div>

        {{-- Order History --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Order History</h6>
            </div>
            <div class="card-body p-0">
                @if($historyOrders->count())
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Order#</th>
                                    <th>Customer</th>
                                    <th class="text-center">Suits</th>
                                    <th>Status</th>
                                    <th>Delivered Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($historyOrders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('orders.show', $order) }}" class="font-weight-bold">
                                                {{ $order->order_number }}
                                            </a>
                                        </td>
                                        <td>{{ $order->customer?->name ?? '—' }}</td>
                                        <td class="text-center">{{ $order->total_suits }}</td>
                                        <td>@include('dashboard.orders.partials.status-badge', ['order' => $order])</td>
                                        <td>
                                            @if($order->actual_delivery_date)
                                                {{ $order->actual_delivery_date->format('d M, Y') }}
                                            @elseif($order->status?->name === 'Delivered' && $order->delivery_date)
                                                {{ $order->delivery_date->format('d M, Y') }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted py-4">No completed or cancelled orders yet.</div>
                @endif
            </div>
        </div>

        @if($tailor->notes)
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Notes</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $tailor->notes }}</p>
                </div>
            </div>
        @endif
    </div>

    @push('js')
        <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
        <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>
