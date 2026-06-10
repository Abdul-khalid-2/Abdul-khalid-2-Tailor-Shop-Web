@php
    $totalOrders = $orders->total();
    $totalSpent = $customer->orders()->sum('total_amount');
    $balanceDue = $customer->orders()->sum('balance_due');

    $waPhone = preg_replace('/[^0-9]/', '', $customer->phone);
    if (str_starts_with($waPhone, '0')) {
        $waPhone = '92' . substr($waPhone, 1);
    }
@endphp

<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/brands.min.css') }}">
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
                        <h3 class="font-weight-bold mb-2">{{ $customer->name }}</h3>
                        <p class="mb-1"><i class="las la-phone mr-1"></i> {{ $customer->phone }}</p>
                        @if($customer->address)
                            <p class="mb-1 text-muted"><i class="las la-map-marker mr-1"></i> {{ $customer->address }}</p>
                        @endif
                        <p class="mb-0 text-muted">
                            <i class="las la-store mr-1"></i>
                            Branch: {{ $customer->branch?->name ?? '—' }}
                        </p>
                    </div>
                    <div class="d-flex flex-wrap mt-2 mt-md-0">
                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary mr-2 mb-2">
                            <i class="las la-edit mr-1"></i> Edit
                        </a>
                        <a href="{{ route('orders.create') }}" class="btn btn-outline-primary mr-2 mb-2">
                            <i class="las la-plus mr-1"></i> New Order for this Customer
                        </a>
                        <a href="https://wa.me/{{ $waPhone }}" target="_blank" rel="noopener noreferrer"
                           class="btn btn-success mb-2">
                            <i class="lab la-whatsapp mr-1"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="row mb-4">
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Orders</div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $totalOrders }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Spent</div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">Rs {{ number_format($totalSpent, 0) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-left-{{ $balanceDue > 0 ? 'danger' : 'secondary' }} shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-{{ $balanceDue > 0 ? 'danger' : 'secondary' }} text-uppercase mb-1">Balance Due</div>
                        <div class="h4 mb-0 font-weight-bold {{ $balanceDue > 0 ? 'text-danger' : 'text-gray-800' }}">
                            Rs {{ number_format($balanceDue, 0) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Orders --}}
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Customer Orders</h6>
            </div>
            <div class="card-body p-0">
                @if($orders->count())
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Order#</th>
                                    <th>Label</th>
                                    <th class="text-center">Suits</th>
                                    <th class="text-right">Total</th>
                                    <th class="text-right">Advance</th>
                                    <th class="text-right">Balance</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('orders.show', $order) }}" class="font-weight-bold">
                                                {{ $order->order_number }}
                                            </a>
                                        </td>
                                        <td>{{ $order->order_label ?: '—' }}</td>
                                        <td class="text-center">{{ $order->suits_count }}</td>
                                        <td class="text-right">Rs {{ number_format($order->total_amount, 2) }}</td>
                                        <td class="text-right">Rs {{ number_format($order->advance_paid, 2) }}</td>
                                        <td class="text-right {{ $order->balance_due > 0 ? 'text-warning font-weight-bold' : '' }}">
                                            Rs {{ number_format($order->balance_due, 2) }}
                                        </td>
                                        <td>@include('dashboard.orders.partials.status-badge', ['order' => $order])</td>
                                        <td>{{ $order->order_date->format('d M, Y') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="las la-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($orders->hasPages())
                        <div class="card-footer d-flex flex-wrap justify-content-between align-items-center">
                            <small class="text-muted">
                                Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }}
                            </small>
                            {{ $orders->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center text-muted py-5">
                        <i class="las la-shopping-bag fa-3x mb-3 d-block"></i>
                        <p class="mb-3">No orders yet for this customer.</p>
                        <a href="{{ route('orders.create') }}" class="btn btn-primary">
                            <i class="las la-plus mr-1"></i> Create First Order
                        </a>
                    </div>
                @endif
            </div>
        </div>

        @if($customer->notes)
            <div class="card shadow mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Notes</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $customer->notes }}</p>
                </div>
            </div>
        @endif
    </div>

    @push('js')
        <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
        <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>
