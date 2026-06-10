<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header subtitle="These orders are past their delivery date and need attention">
            <x-slot:title>
                <span class="text-danger"><i class="las la-exclamation-triangle mr-1"></i> Overdue Orders</span>
            </x-slot:title>
            <x-slot:actions>
                <x-ui.button :href="route('orders.create')" icon="las la-plus" class="mr-2">New Order</x-ui.button>
                <x-ui.button :href="route('orders.index')" variant="outline-secondary" icon="las la-arrow-left">All Orders</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <x-ui.alert type="danger" :dismissible="false">
            <strong>Warning:</strong> The orders below have passed their delivery date and have not been marked as delivered.
        </x-ui.alert>

        <x-ui.card border="danger">
            @include('dashboard.orders.partials.orders-table', ['orders' => $orders])
        </x-ui.card>
    </div>
</x-app-layout>
