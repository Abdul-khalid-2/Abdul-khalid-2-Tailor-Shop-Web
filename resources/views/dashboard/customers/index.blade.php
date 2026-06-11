<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header :title="__('messages.customers')" :subtitle="__('messages.customers_subtitle')">
            <x-slot:actions>
                <x-ui.button :href="route('customers.create')" icon="las la-user-plus">
                    {{ __('messages.add_customer') }}
                </x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <x-ui.filter-bar>
            <x-ui.filter-search
                :action="route('customers.index')"
                :placeholder="__('messages.search_name_phone_ph')"
                col="col-12"
            />
        </x-ui.filter-bar>

        <x-ui.card :noPadding="true">
            <x-ui.table>
                <thead class="thead-light">
                    <tr>
                        <th>{{ __('messages.name') }}</th>
                        <th>{{ __('messages.phone') }}</th>
                        <th>{{ __('messages.address') }}</th>
                        <th class="text-center">{{ __('messages.total_orders') }}</th>
                        <th class="text-center" width="160">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td class="font-weight-bold">{{ $customer->name }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->address ? \Illuminate\Support\Str::limit($customer->address, 50) : '—' }}</td>
                            <td class="text-center">
                                <x-ui.badge variant="info">{{ $customer->orders_count }}</x-ui.badge>
                            </td>
                            <td>
                                <x-ui.row-actions
                                    :view="route('customers.show', $customer)"
                                    :edit="route('customers.edit', $customer)"
                                    :delete="route('customers.destroy', $customer)"
                                    :deleteMessage="__('messages.delete_customer_q')"
                                />
                            </td>
                        </tr>
                    @empty
                        <x-ui.empty-state
                            icon="las la-users"
                            :title="__('messages.no_customers_found')"
                            :colspan="5"
                            :asRow="true"
                        >
                            <x-slot:action>
                                @if(request('search'))
                                    <x-ui.button :href="route('customers.index')" variant="outline-secondary" size="sm">
                                        {{ __('messages.clear_search') }}
                                    </x-ui.button>
                                @else
                                    <x-ui.button :href="route('customers.create')" size="sm">
                                        {{ __('messages.add_first_customer') }}
                                    </x-ui.button>
                                @endif
                            </x-slot:action>
                        </x-ui.empty-state>
                    @endforelse
                </tbody>
            </x-ui.table>

            <x-slot:footer>
                <x-ui.pagination :paginator="$customers" label="customers" />
            </x-slot:footer>
        </x-ui.card>
    </div>
</x-app-layout>
