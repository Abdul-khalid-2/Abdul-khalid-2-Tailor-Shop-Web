<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header title="Edit Customer" subtitle="Update customer information">
            <x-slot:actions>
                <x-ui.button :href="route('customers.show', $customer)" variant="outline-secondary" icon="las la-arrow-left">Back to Customer</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <x-ui.card>
                    <form action="{{ route('customers.update', $customer) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <x-ui.form.input name="name" label="Name" :value="$customer->name" required />
                        <x-ui.form.input name="phone" label="Phone" :value="$customer->phone" required />
                        <x-ui.form.textarea name="address" label="Address" :value="$customer->address" />
                        @if($branches->isNotEmpty())
                            <x-ui.form.select
                                name="branch_id"
                                label="Branch"
                                :options="$branches"
                                :selected="$customer->branch_id"
                                placeholder="— Select branch —"
                            />
                        @endif
                        <x-ui.form.textarea name="notes" label="Notes" :value="$customer->notes" />

                        <div class="d-flex">
                            <x-ui.button type="submit" icon="las la-save">Save Customer</x-ui.button>
                            <x-ui.button :href="route('customers.show', $customer)" variant="outline-secondary" class="ml-2">Cancel</x-ui.button>
                        </div>
                    </form>
                </x-ui.card>
            </div>
        </div>
    </div>
</x-app-layout>
