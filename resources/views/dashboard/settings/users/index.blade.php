<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header title="Users" subtitle="Manage Super Admin and Branch Admin accounts">
            <x-slot:actions>
                <x-ui.button :href="route('settings.users.create')" icon="las la-user-plus" class="mr-2">Add User</x-ui.button>
                <x-ui.button :href="route('settings.index')" variant="outline-secondary" icon="las la-arrow-left">Settings</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <x-ui.card :noPadding="true">
            <x-ui.table>
                <thead class="thead-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Branch</th>
                        <th>Status</th>
                        <th class="text-center" width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        @php
                            $roleName = $user->roles->first()?->name;
                            $roleLabel = match ($roleName) {
                                'superadmin' => 'Super Admin',
                                'admin'      => 'Branch Admin',
                                default      => $roleName ?? '—',
                            };
                        @endphp
                        <tr>
                            <td class="font-weight-bold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '—' }}</td>
                            <td>
                                <x-ui.badge :variant="$roleName === 'superadmin' ? 'danger' : 'primary'">{{ $roleLabel }}</x-ui.badge>
                            </td>
                            <td>{{ $user->branch?->name ?? '—' }}</td>
                            <td>
                                <x-ui.badge :variant="$user->status === 'active' ? 'success' : 'secondary'">
                                    {{ ucfirst($user->status) }}
                                </x-ui.badge>
                            </td>
                            <td>
                                <x-ui.row-actions
                                    :edit="route('settings.users.edit', $user)"
                                    :delete="$user->id !== auth()->id() ? route('settings.users.destroy', $user) : null"
                                    deleteMessage="Delete this user?"
                                />
                            </td>
                        </tr>
                    @empty
                        <x-ui.empty-state
                            icon="las la-users"
                            title="No users found."
                            :colspan="7"
                            :asRow="true"
                        />
                    @endforelse
                </tbody>
            </x-ui.table>

            <x-slot:footer>
                <x-ui.pagination :paginator="$users" label="users" />
            </x-slot:footer>
        </x-ui.card>
    </div>
</x-app-layout>
