<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header title="Orders" subtitle="Manage all tailor shop orders">
            <x-slot:actions>
                <x-ui.button :href="route('orders.create')" icon="las la-plus">New Order</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <x-ui.filter-bar>
            <x-ui.filter-search
                :action="route('orders.index')"
                placeholder="Search order#, customer name or phone..."
            />
            <x-ui.filter-tabs
                :tabs="[
                    'orders.index'       => 'All',
                    'orders.pending'     => 'Pending',
                    'orders.in-progress' => 'In Progress',
                    'orders.ready'       => 'Ready',
                    'orders.overdue'     => 'Overdue',
                ]"
                :preserve="request()->only('search')"
            />
        </x-ui.filter-bar>

        <x-ui.card>
            @include('dashboard.orders.partials.orders-table', ['orders' => $orders])
        </x-ui.card>
    </div>
</x-app-layout>
