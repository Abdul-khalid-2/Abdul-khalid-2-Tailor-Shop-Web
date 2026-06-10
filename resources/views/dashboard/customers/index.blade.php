<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header title="Customers" subtitle="Manage your tailor shop customers">
            <x-slot:actions>
                <x-ui.button :href="route('customers.create')" icon="las la-user-plus">
                    Add Customer
                </x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <x-ui.filter-bar>
            <x-ui.filter-search
                :action="route('customers.index')"
                placeholder="Search by name or phone..."
                col="col-12"
            />
        </x-ui.filter-bar>

        <x-ui.card :noPadding="true">
            <x-ui.table>
                <thead class="thead-light">
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th class="text-center">Total Orders</th>
                        <th class="text-center" width="160">Actions</th>
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
                                    deleteMessage="Delete this customer?"
                                />
                            </td>
                        </tr>
                    @empty
                        <x-ui.empty-state
                            icon="las la-users"
                            title="No customers found."
                            :colspan="5"
                            :asRow="true"
                        >
                            <x-slot:action>
                                @if(request('search'))
                                    <x-ui.button :href="route('customers.index')" variant="outline-secondary" size="sm">
                                        Clear search
                                    </x-ui.button>
                                @else
                                    <x-ui.button :href="route('customers.create')" size="sm">
                                        Add First Customer
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
