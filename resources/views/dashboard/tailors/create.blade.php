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

        <div class="row justify-content-center">
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
        </div>
    </div>
</x-app-layout>
