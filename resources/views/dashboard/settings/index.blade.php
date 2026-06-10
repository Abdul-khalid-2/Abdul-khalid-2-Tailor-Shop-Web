<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header title="Settings"
            :subtitle="$isSuperAdmin ? 'Manage shop configuration, branches, users, and order statuses' : 'Manage your branch shop information'">
            <x-slot:actions>
                <x-ui.button :href="route('dashboard')" variant="outline-secondary" icon="las la-arrow-left">Back to Dashboard</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <div class="row">
            {{-- General Info --}}
            <div class="col-lg-6 col-xl-3 mb-4">
                <x-ui.card class="h-100 border-left-primary" bodyClass="d-flex flex-column">
                    <div class="mb-3"><i class="las la-cog fa-2x text-primary"></i></div>
                    <h5 class="font-weight-bold">General Info</h5>
                    <p class="text-muted flex-grow-1">
                        Shop name, contact details, currency, receipts, and notifications
                    </p>
                    <x-ui.button :href="route('settings.general')" icon="las la-edit" class="btn-block mt-2">Configure</x-ui.button>
                </x-ui.card>
            </div>

            @if($isSuperAdmin)
                {{-- Branches --}}
                <div class="col-lg-6 col-xl-3 mb-4">
                    <x-ui.card class="h-100 border-left-success" bodyClass="d-flex flex-column">
                        <div class="mb-3"><i class="las la-store fa-2x text-success"></i></div>
                        <h5 class="font-weight-bold">Branches</h5>
                        <p class="text-muted flex-grow-1">
                            Add and manage shop branches and their details
                        </p>
                        <x-ui.button :href="route('branches.index')" variant="success" icon="las la-store" class="btn-block mt-2">Manage Branches</x-ui.button>
                    </x-ui.card>
                </div>

                {{-- Users --}}
                <div class="col-lg-6 col-xl-3 mb-4">
                    <x-ui.card class="h-100 border-left-info" bodyClass="d-flex flex-column">
                        <div class="mb-3"><i class="las la-users fa-2x text-info"></i></div>
                        <h5 class="font-weight-bold">Users</h5>
                        <p class="text-muted flex-grow-1">
                            Manage Super Admin and Branch Admin accounts
                        </p>
                        <x-ui.button :href="route('settings.users.index')" variant="info" icon="las la-user-cog" class="btn-block mt-2">Manage Users</x-ui.button>
                    </x-ui.card>
                </div>

                {{-- Order Statuses --}}
                <div class="col-lg-6 col-xl-3 mb-4">
                    <x-ui.card class="h-100 border-left-warning" bodyClass="d-flex flex-column">
                        <div class="mb-3"><i class="las la-clipboard-list fa-2x text-warning"></i></div>
                        <h5 class="font-weight-bold">Order Statuses</h5>
                        <p class="text-muted flex-grow-1">
                            Configure order workflow statuses and display order
                        </p>
                        <x-ui.button :href="route('settings.order-statuses.index')" variant="warning" icon="las la-list" class="btn-block mt-2">Manage Statuses</x-ui.button>
                    </x-ui.card>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
