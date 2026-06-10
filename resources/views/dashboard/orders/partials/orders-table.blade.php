<x-ui.table>
    <thead class="thead-light">
        <tr>
            <th>Order#</th>
            <th>Customer</th>
            <th>Label</th>
            <th class="text-center">Suits</th>
            <th class="text-right">Total</th>
            <th class="text-right">Balance</th>
            <th>Status</th>
            <th>Delivery Date</th>
            <th class="text-center" width="120">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
            <tr>
                <td>
                    <a href="{{ route('orders.show', $order) }}" class="font-weight-bold text-primary">
                        {{ $order->order_number }}
                    </a>
                </td>
                <td>
                    <div class="font-weight-bold">{{ $order->customer?->name ?? '—' }}</div>
                    <small class="text-muted">{{ $order->customer?->phone ?? '' }}</small>
                </td>
                <td>{{ $order->order_label ?: '—' }}</td>
                <td class="text-center">{{ $order->total_suits }}</td>
                <td class="text-right"><x-ui.currency :amount="$order->total_amount" /></td>
                <td class="text-right"><x-ui.currency :amount="$order->balance_due" :highlight="true" /></td>
                <td><x-ui.order-status-badge :order="$order" /></td>
                <td>
                    @if($order->delivery_date)
                        {{ $order->delivery_date->format('d M, Y') }}
                        @if($order->isOverdue())
                            <span class="text-danger font-weight-bold ml-1">OVERDUE</span>
                        @endif
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td>
                    <x-ui.row-actions
                        :view="route('orders.show', $order)"
                        :edit="route('orders.edit', $order)"
                    />
                </td>
            </tr>
        @empty
            <x-ui.empty-state icon="" title="No orders found." :colspan="9" :asRow="true" />
        @endforelse
    </tbody>
</x-ui.table>

@if($orders->hasPages())
    <div class="mt-3">
        <x-ui.pagination :paginator="$orders" label="orders" />
    </div>
@endif
