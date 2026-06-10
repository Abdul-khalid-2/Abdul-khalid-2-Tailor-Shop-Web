<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header title="Add User">
            <x-slot:actions>
                <x-ui.button :href="route('settings.users.index')" variant="outline-secondary" icon="las la-arrow-left">Back to Users</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <div class="row justify-content-center">
            <div class="col-lg-7">
                <x-ui.card>
                    @include('dashboard.settings.users._form', ['user' => null])
                </x-ui.card>
            </div>
        </div>
    </div>
</x-app-layout>
