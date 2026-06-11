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

        <div class="row g-4">
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

            {{-- Guidance note --}}
            <div class="col-lg-4">
                <x-ui.card class="mb-0">
                    <h6 class="font-weight-bold mb-3">
                        <i class="las la-info-circle text-primary mr-1"></i> Quick Guide
                    </h6>
                    <ul class="list-unstyled small text-muted mb-0 customer-guide">
                        <li class="mb-2"><i class="las la-user text-primary mr-1"></i>
                            <strong>Name</strong> and <strong>Phone</strong> are required — the rest is optional.</li>
                        <li class="mb-2"><i class="las la-phone text-primary mr-1"></i>
                            Use the customer's <strong>phone</strong> as their unique identifier; it must not already exist in your branch.</li>
                        <li class="mb-2"><i class="las la-image text-primary mr-1"></i>
                            <strong>Photo</strong> is optional — JPG, PNG or WEBP, up to 2MB.</li>
                        @if($branches->isNotEmpty())
                            <li class="mb-2"><i class="las la-store text-primary mr-1"></i>
                                Pick the <strong>branch</strong> this customer belongs to.</li>
                        @else
                            <li class="mb-2"><i class="las la-store text-primary mr-1"></i>
                                The customer is automatically added to <strong>your branch</strong>.</li>
                        @endif
                        <li class="mb-0"><i class="las la-sticky-note text-primary mr-1"></i>
                            Add <strong>address</strong> and <strong>notes</strong> for delivery details or preferences.</li>
                    </ul>
                </x-ui.card>
            </div>
        </div>
    </div>
</x-app-layout>
