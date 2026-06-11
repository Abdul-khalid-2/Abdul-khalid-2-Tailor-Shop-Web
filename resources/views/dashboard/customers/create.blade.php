<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header title="Add Customer" subtitle="Create a new customer profile">
            <x-slot:actions>
                <x-ui.button :href="route('customers.index')" variant="outline-secondary" icon="las la-arrow-left">Back to Customers</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <x-ui.card>
                    <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <x-ui.form.input name="name" label="Name" required />
                        <x-ui.form.input name="phone" label="Phone" required />
                        <x-ui.form.file name="profile_photo" label="Photo" accept="image/*" help="JPG, PNG or WEBP. Max 2MB." />
                        <x-ui.form.textarea name="address" label="Address" />
                        @if($branches->isNotEmpty())
                            <x-ui.form.select
                                name="branch_id"
                                label="Branch"
                                :options="$branches"
                                placeholder="— Select branch —"
                            />
                        @endif
                        <x-ui.form.textarea name="notes" label="Notes" />

                        <div class="d-flex">
                            <x-ui.button type="submit" icon="las la-save">Save Customer</x-ui.button>
                            <x-ui.button :href="route('customers.index')" variant="outline-secondary" class="ml-2">Cancel</x-ui.button>
                        </div>
                    </form>
                </x-ui.card>
            </div>
        </div>
    </div>
</x-app-layout>
