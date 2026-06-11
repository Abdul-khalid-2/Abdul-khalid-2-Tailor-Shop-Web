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
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.session-alerts />

        {{-- Header --}}
        <x-ui.card class="mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start">
                <div class="d-flex">
                    @if($customer->profile_photo)
                        <img src="{{ asset($customer->profile_photo) }}" alt="{{ $customer->name }}"
                             class="rounded mr-3" style="height:80px;width:80px;object-fit:cover;">
                    @endif
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
                </div>
                <div class="d-flex flex-wrap mt-2 mt-md-0">
                    <x-ui.button :href="route('customers.edit', $customer)" icon="las la-edit" class="mr-2 mb-2">Edit</x-ui.button>
                    <x-ui.button :href="route('orders.create')" variant="outline-primary" icon="las la-plus" class="mr-2 mb-2">New Order for this Customer</x-ui.button>
                    <x-ui.button href="https://wa.me/{{ $waPhone }}" target="_blank" rel="noopener noreferrer" variant="success" icon="lab la-whatsapp" class="mb-2">WhatsApp</x-ui.button>
                </div>
            </div>
        </x-ui.card>

        {{-- Stats --}}
        <div class="row mb-4">
            <div class="col-md-4 mb-3 mb-md-0">
                <x-ui.stat-card label="Total Orders" :value="$totalOrders" color="primary" />
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <x-ui.stat-card label="Total Spent" :value="'Rs '.number_format($totalSpent, 0)" color="success" />
            </div>
            <div class="col-md-4">
                <x-ui.stat-card label="Balance Due" :value="'Rs '.number_format($balanceDue, 0)" :color="$balanceDue > 0 ? 'danger' : 'secondary'" />
            </div>
        </div>

        {{-- Orders --}}
        <x-ui.card title="Customer Orders" :noPadding="true">
            @if($orders->count())
                <x-ui.table>
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
                                <td class="text-right"><x-ui.currency :amount="$order->total_amount" /></td>
                                <td class="text-right"><x-ui.currency :amount="$order->advance_paid" /></td>
                                <td class="text-right"><x-ui.currency :amount="$order->balance_due" :highlight="true" /></td>
                                <td><x-ui.order-status-badge :order="$order" /></td>
                                <td>{{ $order->order_date->format('d M, Y') }}</td>
                                <td class="text-center">
                                    <x-ui.icon-button :href="route('orders.show', $order)" icon="las la-eye" title="View" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-ui.table>
            @else
                <x-ui.empty-state icon="las la-shopping-bag" title="No orders yet for this customer.">
                    <x-slot:action>
                        <x-ui.button :href="route('orders.create')" icon="las la-plus">Create First Order</x-ui.button>
                    </x-slot:action>
                </x-ui.empty-state>
            @endif

            @if($orders->hasPages())
                <x-slot:footer>
                    <x-ui.pagination :paginator="$orders" label="orders" />
                </x-slot:footer>
            @endif
        </x-ui.card>

        @if($customer->notes)
            <x-ui.card title="Notes" class="mt-4">
                <p class="mb-0">{{ $customer->notes }}</p>
            </x-ui.card>
        @endif
    </div>
</x-app-layout>
