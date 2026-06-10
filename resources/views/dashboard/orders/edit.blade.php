<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header title="Edit Order #{{ $order->order_number }}" subtitle="Update order details, suits, and measurements">
            <x-slot:actions>
                <x-ui.button :href="route('orders.show', $order)" variant="outline-secondary" icon="las la-arrow-left">Back to Order</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <form action="{{ route('orders.update', $order) }}" method="POST">
            @csrf
            @method('PUT')
            @include('dashboard.orders.partials.order-form', [
                'order' => $order,
                'customers' => $customers,
                'tailors' => $tailors,
                'orderDate' => $order->order_date->format('Y-m-d'),
            ])
        </form>
    </div>
</x-app-layout>
