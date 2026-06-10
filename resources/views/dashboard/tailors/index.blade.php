<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header title="Tailors" subtitle="Manage your tailor team and assignments">
            <x-slot:actions>
                <x-ui.button :href="route('tailors.create')" icon="las la-user-plus">Add Tailor</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <x-ui.filter-bar>
            <x-ui.filter-search
                :action="route('tailors.index')"
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
                        <th>Status</th>
                        <th class="text-center">Active Orders</th>
                        <th class="text-center">Total Suits</th>
                        <th class="text-right">Fee Balance</th>
                        <th class="text-center" width="160">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tailors as $tailor)
                        <tr>
                            <td class="font-weight-bold">{{ $tailor->name }}</td>
                            <td>{{ $tailor->phone }}</td>
                            <td>
                                <x-ui.badge :variant="$tailor->status === 'active' ? 'success' : 'warning'">
                                    {{ $tailor->status === 'active' ? 'Active' : 'On Leave' }}
                                </x-ui.badge>
                            </td>
                            <td class="text-center">
                                <x-ui.badge variant="primary">{{ $tailor->active_orders_count }}</x-ui.badge>
                            </td>
                            <td class="text-center">{{ $tailor->total_suits_assigned }}</td>
                            <td class="text-right {{ $tailor->total_fee_balance > 0 ? 'text-danger font-weight-bold' : '' }}">
                                Rs {{ number_format($tailor->total_fee_balance, 0) }}
                            </td>
                            <td>
                                <x-ui.row-actions
                                    :view="route('tailors.show', $tailor)"
                                    :edit="route('tailors.edit', $tailor)"
                                    :delete="route('tailors.destroy', $tailor)"
                                    deleteMessage="Delete this tailor?"
                                />
                            </td>
                        </tr>
                    @empty
                        <x-ui.empty-state
                            icon="las la-cut"
                            title="No tailors found."
                            :colspan="7"
                            :asRow="true"
                        >
                            <x-slot:action>
                                @if(request('search'))
                                    <x-ui.button :href="route('tailors.index')" variant="outline-secondary" size="sm">
                                        Clear search
                                    </x-ui.button>
                                @else
                                    <x-ui.button :href="route('tailors.create')" size="sm">
                                        Add First Tailor
                                    </x-ui.button>
                                @endif
                            </x-slot:action>
                        </x-ui.empty-state>
                    @endforelse
                </tbody>
            </x-ui.table>

            <x-slot:footer>
                <x-ui.pagination :paginator="$tailors" label="tailors" />
            </x-slot:footer>
        </x-ui.card>
    </div>
</x-app-layout>
