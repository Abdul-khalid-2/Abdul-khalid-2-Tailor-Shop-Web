<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header title="Add Tailor" subtitle="Register a new tailor to your team">
            <x-slot:actions>
                <x-ui.button :href="route('tailors.index')" variant="outline-secondary" icon="las la-arrow-left">Back to Tailors</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <div class="row g-4">
            <div class="col-lg-8">
                <x-ui.card>
                    <form action="{{ route('tailors.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <x-ui.form.input name="name" label="Name" required />
                            </div>
                            <div class="col-md-6">
                                <x-ui.form.input name="phone" label="Phone" required />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-ui.form.input name="cnic" label="CNIC" />
                            </div>
                            <div class="col-md-6">
                                <x-ui.form.input type="date" name="joining_date" label="Joining Date" />
                            </div>
                        </div>

                        <x-ui.form.file name="profile_photo" label="Photo" accept="image/*" help="JPG, PNG or WEBP. Max 2MB." />

                        <x-ui.form.textarea name="address" label="Address" :rows="2" />

                        <div class="row">
                            <div class="col-md-6">
                                <x-ui.form.select
                                    name="specialty"
                                    label="Specialty"
                                    :options="['all' => 'All', 'shalwar_kameez' => 'Shalwar Kameez', 'sherwani' => 'Sherwani']"
                                    selected="all"
                                />
                            </div>
                            @if($branches->isNotEmpty())
                                <div class="col-md-6">
                                    <x-ui.form.select
                                        name="branch_id"
                                        label="Branch"
                                        :options="$branches"
                                        placeholder="— Select branch —"
                                    />
                                </div>
                            @endif
                        </div>

                        <x-ui.form.textarea name="notes" label="Notes" />

                        <div class="d-flex">
                            <x-ui.button type="submit" icon="las la-save">Save Tailor</x-ui.button>
                            <x-ui.button :href="route('tailors.index')" variant="outline-secondary" class="ml-2">Cancel</x-ui.button>
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
                    <ul class="list-unstyled small text-muted mb-0 tailor-guide">
                        <li class="mb-2"><i class="las la-user text-primary mr-1"></i>
                            <strong>Name</strong> and <strong>Phone</strong> are required — the rest is optional.</li>
                        <li class="mb-2"><i class="las la-id-card text-primary mr-1"></i>
                            <strong>CNIC</strong> and <strong>Joining Date</strong> are for your records only.</li>
                        <li class="mb-2"><i class="las la-image text-primary mr-1"></i>
                            <strong>Photo</strong> is optional — JPG, PNG or WEBP, up to 2MB.</li>
                        <li class="mb-2"><i class="las la-cut text-primary mr-1"></i>
                            <strong>Specialty</strong> sets the suit types this tailor handles (defaults to <em>All</em>).</li>
                        @if($branches->isNotEmpty())
                            <li class="mb-2"><i class="las la-store text-primary mr-1"></i>
                                Pick the <strong>branch</strong> this tailor works at.</li>
                        @else
                            <li class="mb-2"><i class="las la-store text-primary mr-1"></i>
                                The tailor is automatically added to <strong>your branch</strong>.</li>
                        @endif
                        <li class="mb-0"><i class="las la-sticky-note text-primary mr-1"></i>
                            New tailors start <strong>active</strong>; you can change status later from their profile.</li>
                    </ul>
                </x-ui.card>
            </div>
        </div>
    </div>
</x-app-layout>
