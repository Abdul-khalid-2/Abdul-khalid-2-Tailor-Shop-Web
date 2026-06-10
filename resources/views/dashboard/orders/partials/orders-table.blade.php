<div class="table-responsive">
    <table class="table table-bordered table-hover mb-0">
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
                    <td class="text-right">Rs {{ number_format($order->total_amount, 2) }}</td>
                    <td class="text-right {{ $order->balance_due > 0 ? 'text-warning font-weight-bold' : '' }}">
                        Rs {{ number_format($order->balance_due, 2) }}
                    </td>
                    <td>@include('dashboard.orders.partials.status-badge', ['order' => $order])</td>
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
                    <td class="text-center">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary" title="View">
                            <i class="las la-eye"></i>
                        </a>
                        <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                            <i class="las la-edit"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">No orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($orders->hasPages())
    <div class="d-flex flex-wrap justify-content-between align-items-center mt-3">
        <div class="text-muted small mb-2 mb-md-0">
            Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders
        </div>
        <div>{{ $orders->links() }}</div>
    </div>
@endif
