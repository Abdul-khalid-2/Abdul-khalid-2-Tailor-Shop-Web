@php
    $specialtyLabels = [
        'shalwar_kameez' => __('messages.shalwar_kameez'),
        'sherwani' => __('messages.sherwani'),
        'all' => __('messages.all_types'),
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
                <div class="d-flex">
                    @if($tailor->profile_photo)
                        <img src="{{ asset($tailor->profile_photo) }}" alt="{{ $tailor->name }}"
                             class="rounded mr-3" style="height:80px;width:80px;object-fit:cover;">
                    @endif
                    <div>
                    <h3 class="font-weight-bold mb-2">{{ $tailor->name }}</h3>
                    <p class="mb-1"><i class="las la-phone mr-1"></i> {{ $tailor->phone }}</p>
                    @if($tailor->cnic)
                        <p class="mb-1 text-muted"><i class="las la-id-card mr-1"></i> {{ $tailor->cnic }}</p>
                    @endif
                    <p class="mb-1 text-muted">
                        <i class="las la-calendar mr-1"></i>
                        {{ __('messages.joined') }}: {{ $tailor->joining_date ? $tailor->joining_date->format('d M, Y') : '—' }}
                    </p>
                    <p class="mb-1">
                        <strong>{{ __('messages.specialty') }}:</strong> {{ $specialtyLabels[$tailor->specialty] ?? $tailor->specialty }}
                    </p>
                    <p class="mb-1">
                        <strong>{{ __('messages.branch_label') }}:</strong> {{ $tailor->branch?->name ?? '—' }}
                    </p>
                    <x-ui.badge :variant="$tailor->status === 'active' ? 'success' : 'warning'">
                        {{ $tailor->status === 'active' ? __('messages.active') : __('messages.on_leave') }}
                    </x-ui.badge>
                    </div>
                </div>
                <div class="d-flex flex-wrap mt-2 mt-md-0">
                    <x-ui.button :href="route('tailors.edit', $tailor)" icon="las la-edit" class="mr-2 mb-2">{{ __('messages.edit') }}</x-ui.button>
                    <form action="{{ route('tailors.toggle', $tailor) }}" method="POST" class="mb-2">
                        @csrf
                        @method('PATCH')
                        <x-ui.button type="submit" :variant="$tailor->status === 'active' ? 'outline-warning' : 'outline-success'" icon="las la-toggle-on">
                            {{ $tailor->status === 'active' ? __('messages.mark_on_leave') : __('messages.mark_active') }}
                        </x-ui.button>
                    </form>
                    <x-ui.button :href="route('tailors.index')" variant="outline-secondary" icon="las la-arrow-left" class="mb-2 ml-2">{{ __('messages.back') }}</x-ui.button>
                </div>
            </div>
        </x-ui.card>

        {{-- Work Stats --}}
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <x-ui.stat-card :label="__('messages.total_orders')" :value="$tailor->total_orders_assigned" color="primary" />
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <x-ui.stat-card :label="__('messages.total_suits_label')" :value="$tailor->total_suits_assigned" color="info" />
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <x-ui.stat-card :label="__('messages.completed')" :value="$tailor->orders_completed" color="success" />
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <x-ui.stat-card :label="__('messages.pending_label')" :value="$tailor->orders_pending" color="warning" />
            </div>
        </div>

        {{-- Payment Stats --}}
        <div class="row mb-4">
            <div class="col-md-4 mb-3 mb-md-0">
                <x-ui.stat-card :label="__('messages.fee_earned')" :value="'Rs '.number_format($tailor->total_fee_earned, 0)" color="primary" />
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <x-ui.stat-card :label="__('messages.fee_received')" :value="'Rs '.number_format($tailor->total_fee_received, 0)" color="success" />
            </div>
            <div class="col-md-4">
                <x-ui.stat-card :label="__('messages.balance_label')" :value="'Rs '.number_format($tailor->total_fee_balance, 0)" :color="$tailor->total_fee_balance > 0 ? 'danger' : 'secondary'" />
            </div>
        </div>

        {{-- Active Orders --}}
        <x-ui.card :title="__('messages.active_orders')" class="mb-4" :noPadding="true">
            @if($activeOrders->count())
                <x-ui.table>
                    <thead class="thead-light">
                        <tr>
                            <th>{{ __('messages.order_hash') }}</th>
                            <th>{{ __('messages.customer') }}</th>
                            <th>{{ __('messages.label') }}</th>
                            <th class="text-center">{{ __('messages.suits') }}</th>
                            <th>{{ __('messages.delivery_date') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th class="text-right">{{ __('messages.fee_balance') }}</th>
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
                                            <span class="text-danger font-weight-bold ml-1">{{ __('messages.overdue_flag') }}</span>
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
                <x-ui.empty-state icon="" :title="__('messages.no_active_orders')" />
            @endif
        </x-ui.card>

        {{-- Order History --}}
        <x-ui.card :title="__('messages.order_history')" class="mb-4" :noPadding="true">
            @if($historyOrders->count())
                <x-ui.table>
                    <thead class="thead-light">
                        <tr>
                            <th>{{ __('messages.order_hash') }}</th>
                            <th>{{ __('messages.customer') }}</th>
                            <th class="text-center">{{ __('messages.suits') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.delivered_date') }}</th>
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
                <x-ui.empty-state icon="" :title="__('messages.no_history_orders')" />
            @endif
        </x-ui.card>

        @if($tailor->notes)
            <x-ui.card :title="__('messages.notes')">
                <p class="mb-0">{{ $tailor->notes }}</p>
            </x-ui.card>
        @endif
    </div>
</x-app-layout>
