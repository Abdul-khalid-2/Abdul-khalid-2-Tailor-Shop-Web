<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header :title="__('messages.dashboard')" :subtitle="__('messages.dashboard_subtitle')">
            <x-slot:actions>
                <x-ui.button :href="route('orders.create')" icon="las la-plus">{{ __('messages.new_order') }}</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <x-ui.stat-card :label="__('messages.pending_label')" :value="$pendingCount" icon="las la-clock" color="warning" :href="route('orders.pending')" />
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-ui.stat-card :label="__('messages.in_progress_label')" :value="$inProgressCount" icon="las la-cut" color="primary" :href="route('orders.in-progress')" />
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-ui.stat-card :label="__('messages.ready_label')" :value="$readyCount" icon="las la-check-circle" color="success" :href="route('orders.ready')" />
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-ui.stat-card :label="__('messages.overdue_label')" :value="$overdueCount" icon="las la-exclamation-triangle" color="danger" :href="route('orders.overdue')" />
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <x-ui.card class="h-100" border="danger">
                    <x-slot:header>
                        <h6 class="m-0 font-weight-bold text-danger">
                            <i class="las la-exclamation-triangle mr-1"></i> {{ __('messages.overdue_orders') }}
                        </h6>
                        <x-ui.button :href="route('orders.overdue')" variant="outline-danger" size="sm">{{ __('messages.view_all') }}</x-ui.button>
                    </x-slot:header>

                    <x-ui.table>
                        <thead class="thead-light">
                            <tr>
                                <th>{{ __('messages.order_hash') }}</th>
                                <th>{{ __('messages.customer') }}</th>
                                <th>{{ __('messages.tailor') }}</th>
                                <th>{{ __('messages.delivery_date') }}</th>
                                <th class="text-right">{{ __('messages.days_overdue') }}</th>
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
                                <x-ui.empty-state :title="__('messages.no_overdue_orders')" :colspan="5" :asRow="true" />
                            @endforelse
                        </tbody>
                    </x-ui.table>
                </x-ui.card>
            </div>

            <div class="col-lg-6 mb-4">
                <x-ui.card class="h-100" :title="__('messages.todays_deliveries')">
                    <x-slot:header>
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="las la-calendar-day mr-1"></i> {{ __('messages.todays_deliveries') }}
                        </h6>
                    </x-slot:header>

                    <x-ui.table>
                        <thead class="thead-light">
                            <tr>
                                <th>{{ __('messages.customer') }}</th>
                                <th>{{ __('messages.phone') }}</th>
                                <th class="text-center">{{ __('messages.suits') }}</th>
                                <th class="text-right">{{ __('messages.balance_due_label') }}</th>
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
                                <x-ui.empty-state :title="__('messages.no_deliveries_today')" :colspan="4" :asRow="true" />
                            @endforelse
                        </tbody>
                    </x-ui.table>
                </x-ui.card>
            </div>
        </div>

        <x-ui.card :title="__('messages.recent_orders')" class="mb-4" :noPadding="true">
            <x-slot:header>
                <h6 class="m-0 font-weight-bold text-primary">{{ __('messages.recent_orders') }}</h6>
                <x-ui.button :href="route('orders.index')" variant="outline-primary" size="sm">{{ __('messages.view_all_orders') }}</x-ui.button>
            </x-slot:header>

            <x-ui.table>
                <thead class="thead-light">
                    <tr>
                        <th>{{ __('messages.order_hash') }}</th>
                        <th>{{ __('messages.customer') }}</th>
                        <th>{{ __('messages.label') }}</th>
                        <th class="text-center">{{ __('messages.suits') }}</th>
                        <th class="text-right">{{ __('messages.total') }}</th>
                        <th>{{ __('messages.status') }}</th>
                        <th>{{ __('messages.date') }}</th>
                        <th class="text-center" width="80">{{ __('messages.action') }}</th>
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
                        <x-ui.empty-state :title="__('messages.no_orders_yet')" :colspan="8" :asRow="true">
                            <x-slot:action>
                                <x-ui.button :href="route('orders.create')" size="sm">{{ __('messages.create_first_order') }}</x-ui.button>
                            </x-slot:action>
                        </x-ui.empty-state>
                    @endforelse
                </tbody>
            </x-ui.table>
        </x-ui.card>
    </div>
</x-app-layout>
