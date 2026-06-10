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
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.session-alerts />

        {{-- Header --}}
        <x-ui.card class="mb-4">
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
                    <x-ui.badge :variant="$tailor->status === 'active' ? 'success' : 'warning'">
                        {{ $tailor->status === 'active' ? 'Active' : 'On Leave' }}
                    </x-ui.badge>
                </div>
                <div class="d-flex flex-wrap mt-2 mt-md-0">
                    <x-ui.button :href="route('tailors.edit', $tailor)" icon="las la-edit" class="mr-2 mb-2">Edit</x-ui.button>
                    <form action="{{ route('tailors.toggle', $tailor) }}" method="POST" class="mb-2">
                        @csrf
                        @method('PATCH')
                        <x-ui.button type="submit" :variant="$tailor->status === 'active' ? 'outline-warning' : 'outline-success'" icon="las la-toggle-on">
                            {{ $tailor->status === 'active' ? 'Mark On Leave' : 'Mark Active' }}
                        </x-ui.button>
                    </form>
                    <x-ui.button :href="route('tailors.index')" variant="outline-secondary" icon="las la-arrow-left" class="mb-2 ml-2">Back</x-ui.button>
                </div>
            </div>
        </x-ui.card>

        {{-- Work Stats --}}
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <x-ui.stat-card label="Total Orders" :value="$tailor->total_orders_assigned" color="primary" />
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <x-ui.stat-card label="Total Suits" :value="$tailor->total_suits_assigned" color="info" />
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <x-ui.stat-card label="Completed" :value="$tailor->orders_completed" color="success" />
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <x-ui.stat-card label="Pending" :value="$tailor->orders_pending" color="warning" />
            </div>
        </div>

        {{-- Payment Stats --}}
        <div class="row mb-4">
            <div class="col-md-4 mb-3 mb-md-0">
                <x-ui.stat-card label="Fee Earned" :value="'Rs '.number_format($tailor->total_fee_earned, 0)" color="primary" />
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <x-ui.stat-card label="Fee Received" :value="'Rs '.number_format($tailor->total_fee_received, 0)" color="success" />
            </div>
            <div class="col-md-4">
                <x-ui.stat-card label="Balance" :value="'Rs '.number_format($tailor->total_fee_balance, 0)" :color="$tailor->total_fee_balance > 0 ? 'danger' : 'secondary'" />
            </div>
        </div>

        {{-- Active Orders --}}
        <x-ui.card title="Active Orders" class="mb-4" :noPadding="true">
            @if($activeOrders->count())
                <x-ui.table>
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
                                <td><x-ui.order-status-badge :order="$order" /></td>
                                <td class="text-right"><x-ui.currency :amount="$order->tailor_fee_balance" :highlight="true" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-ui.table>
            @else
                <x-ui.empty-state icon="" title="No active orders assigned." />
            @endif
        </x-ui.card>

        {{-- Order History --}}
        <x-ui.card title="Order History" class="mb-4" :noPadding="true">
            @if($historyOrders->count())
                <x-ui.table>
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
                                <td><x-ui.order-status-badge :order="$order" /></td>
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
                </x-ui.table>
            @else
                <x-ui.empty-state icon="" title="No completed or cancelled orders yet." />
            @endif
        </x-ui.card>

        @if($tailor->notes)
            <x-ui.card title="Notes">
                <p class="mb-0">{{ $tailor->notes }}</p>
            </x-ui.card>
        @endif
    </div>
</x-app-layout>
