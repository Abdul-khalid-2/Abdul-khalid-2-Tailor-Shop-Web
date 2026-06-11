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
                    <form action="{{ route('customers.update', $customer) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <x-ui.form.input name="name" label="Name" :value="$customer->name" required />
                        <x-ui.form.input name="phone" label="Phone" :value="$customer->phone" required />

                        @if($customer->profile_photo)
                            <div class="form-group">
                                <label class="form-label d-block">Current Photo</label>
                                <img src="{{ asset($customer->profile_photo) }}" alt="{{ $customer->name }}"
                                     class="rounded" style="height:90px;width:90px;object-fit:cover;">
                            </div>
                        @endif
                        <x-ui.form.file name="profile_photo" label="Photo" accept="image/*" help="Leave empty to keep current photo. JPG, PNG or WEBP. Max 2MB." />

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
