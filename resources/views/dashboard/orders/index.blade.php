<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header :title="__('messages.orders')" :subtitle="__('messages.orders_subtitle')">
            <x-slot:actions>
                <x-ui.button :href="route('orders.create')" icon="las la-plus">{{ __('messages.new_order') }}</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <x-ui.filter-bar>
            <x-ui.filter-search
                :action="route('orders.index')"
                :placeholder="__('messages.search_orders_ph')"
            />
            <x-ui.filter-tabs
                :tabs="[
                    'orders.index'       => __('messages.all'),
                    'orders.pending'     => __('messages.pending_label'),
                    'orders.in-progress' => __('messages.in_progress_label'),
                    'orders.ready'       => __('messages.ready_label'),
                    'orders.overdue'     => __('messages.overdue_label'),
                ]"
                :preserve="request()->only('search')"
            />
        </x-ui.filter-bar>

        <x-ui.card>
            @include('dashboard.orders.partials.orders-table', ['orders' => $orders])
        </x-ui.card>
    </div>
</x-app-layout>
