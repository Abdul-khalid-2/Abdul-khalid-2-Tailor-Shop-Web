<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header title="Dashboard" subtitle="Overview of your tailor shop orders and deliveries">
            <x-slot:actions>
                <x-ui.button :href="route('orders.create')" icon="las la-plus">New Order</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <x-ui.stat-card label="Pending" :value="$pendingCount" icon="las la-clock" color="warning" :href="route('orders.pending')" />
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-ui.stat-card label="In Progress" :value="$inProgressCount" icon="las la-cut" color="primary" :href="route('orders.in-progress')" />
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-ui.stat-card label="Ready" :value="$readyCount" icon="las la-check-circle" color="success" :href="route('orders.ready')" />
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-ui.stat-card label="Overdue" :value="$overdueCount" icon="las la-exclamation-triangle" color="danger" :href="route('orders.overdue')" />
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <x-ui.card class="h-100" border="danger">
                    <x-slot:header>
                        <h6 class="m-0 font-weight-bold text-danger">
                            <i class="las la-exclamation-triangle mr-1"></i> Overdue Orders
                        </h6>
                        <x-ui.button :href="route('orders.overdue')" variant="outline-danger" size="sm">View All</x-ui.button>
                    </x-slot:header>

                    <x-ui.table>
                        <thead class="thead-light">
                            <tr>
                                <th>Order#</th>
                                <th>Customer</th>
                                <th>Tailor</th>
                                <th>Delivery Date</th>
                                <th class="text-right">Days Overdue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($overdueList as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('orders.show', $order) }}" class="font-weight-bold">{{ $order->order_number }}</a>
                                    </td>
                                    <td>{{ $order->customer?->name ?? '—' }}</td>
                                    <td>{{ $order->tailor?->name ?? '—' }}</td>
                                    <td>{{ $order->delivery_date?->format('d M, Y') ?? '—' }}</td>
                                    <td class="text-right text-danger font-weight-bold">
                                        {{ $order->delivery_date ? $order->delivery_date->diffInDays(now()) : '—' }}
                                    </td>
                                </tr>
                            @empty
                                <x-ui.empty-state title="No overdue orders." :colspan="5" :asRow="true" />
                            @endforelse
                        </tbody>
                    </x-ui.table>
                </x-ui.card>
            </div>

            <div class="col-lg-6 mb-4">
                <x-ui.card class="h-100" title="Today's Deliveries">
                    <x-slot:header>
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="las la-calendar-day mr-1"></i> Today's Deliveries
                        </h6>
                    </x-slot:header>

                    <x-ui.table>
                        <thead class="thead-light">
                            <tr>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th class="text-center">Suits</th>
                                <th class="text-right">Balance Due</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($todayDeliveries as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('orders.show', $order) }}" class="font-weight-bold">
                                            {{ $order->customer?->name ?? '—' }}
                                        </a>
                                    </td>
                                    <td>{{ $order->customer?->phone ?? '—' }}</td>
                                    <td class="text-center">{{ $order->total_suits }}</td>
                                    <td class="text-right">
                                        <x-ui.currency :amount="$order->balance_due" :highlight="true" />
                                    </td>
                                </tr>
                            @empty
                                <x-ui.empty-state title="No deliveries scheduled for today." :colspan="4" :asRow="true" />
                            @endforelse
                        </tbody>
                    </x-ui.table>
                </x-ui.card>
            </div>
        </div>

        <x-ui.card title="Recent Orders" class="mb-4" :noPadding="true">
            <x-slot:header>
                <h6 class="m-0 font-weight-bold text-primary">Recent Orders</h6>
                <x-ui.button :href="route('orders.index')" variant="outline-primary" size="sm">View All Orders</x-ui.button>
            </x-slot:header>

            <x-ui.table>
                <thead class="thead-light">
                    <tr>
                        <th>Order#</th>
                        <th>Customer</th>
                        <th>Label</th>
                        <th class="text-center">Suits</th>
                        <th class="text-right">Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-center" width="80">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="font-weight-bold text-primary">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td>{{ $order->customer?->name ?? '—' }}</td>
                            <td>{{ $order->order_label ?: '—' }}</td>
                            <td class="text-center">{{ $order->total_suits }}</td>
                            <td class="text-right"><x-ui.currency :amount="$order->total_amount" /></td>
                            <td><x-ui.order-status-badge :order="$order" /></td>
                            <td>{{ $order->order_date->format('d M, Y') }}</td>
                            <td>
                                <x-ui.row-actions :view="route('orders.show', $order)" />
                            </td>
                        </tr>
                    @empty
                        <x-ui.empty-state title="No orders yet." :colspan="8" :asRow="true">
                            <x-slot:action>
                                <x-ui.button :href="route('orders.create')" size="sm">Create your first order</x-ui.button>
                            </x-slot:action>
                        </x-ui.empty-state>
                    @endforelse
                </tbody>
            </x-ui.table>
        </x-ui.card>
    </div>
</x-app-layout>
