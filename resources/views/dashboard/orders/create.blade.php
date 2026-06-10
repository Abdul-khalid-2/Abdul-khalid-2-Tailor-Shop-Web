<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header title="New Order" subtitle="Create a new tailor order with suits and measurements">
            <x-slot:actions>
                <x-ui.button :href="route('orders.index')" variant="outline-secondary" icon="las la-arrow-left">Back to Orders</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            @include('dashboard.orders.partials.order-form', [
                'customers' => $customers,
                'tailors' => $tailors,
                'orderDate' => $orderDate,
            ])
        </form>
    </div>
</x-app-layout>
