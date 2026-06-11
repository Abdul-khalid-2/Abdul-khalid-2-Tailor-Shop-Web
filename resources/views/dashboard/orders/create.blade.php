<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header :title="__('messages.new_order')" :subtitle="__('messages.new_order_subtitle')">
            <x-slot:actions>
                <x-ui.button :href="route('orders.index')" variant="outline-secondary" icon="las la-arrow-left">{{ __('messages.back_to_orders') }}</x-ui.button>
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
