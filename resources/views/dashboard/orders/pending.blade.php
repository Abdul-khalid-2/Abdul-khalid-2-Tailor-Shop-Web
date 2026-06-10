<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header title="Pending Orders" subtitle="Orders awaiting tailor assignment or start">
            <x-slot:actions>
                <x-ui.button :href="route('orders.create')" icon="las la-plus" class="mr-2">New Order</x-ui.button>
                <x-ui.button :href="route('orders.index')" variant="outline-secondary" icon="las la-arrow-left">All Orders</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <x-ui.card>
            @include('dashboard.orders.partials.orders-table', ['orders' => $orders])
        </x-ui.card>
    </div>
</x-app-layout>
