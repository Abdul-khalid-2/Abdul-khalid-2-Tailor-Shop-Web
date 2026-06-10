<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header title="Edit Tailor" subtitle="Update tailor information">
            <x-slot:actions>
                <x-ui.button :href="route('tailors.show', $tailor)" variant="outline-secondary" icon="las la-arrow-left">Back to Tailor</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <x-ui.card>
                    <form action="{{ route('tailors.update', $tailor) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <x-ui.form.input name="name" label="Name" :value="$tailor->name" required />
                            </div>
                            <div class="col-md-6">
                                <x-ui.form.input name="phone" label="Phone" :value="$tailor->phone" required />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-ui.form.input name="cnic" label="CNIC" :value="$tailor->cnic" />
                            </div>
                            <div class="col-md-6">
                                <x-ui.form.input type="date" name="joining_date" label="Joining Date" :value="$tailor->joining_date?->format('Y-m-d')" />
                            </div>
                        </div>

                        <x-ui.form.textarea name="address" label="Address" :value="$tailor->address" :rows="2" />

                        <div class="row">
                            <div class="col-md-4">
                                <x-ui.form.select
                                    name="specialty"
                                    label="Specialty"
                                    :options="['all' => 'All', 'shalwar_kameez' => 'Shalwar Kameez', 'sherwani' => 'Sherwani']"
                                    :selected="$tailor->specialty"
                                />
                            </div>
                            <div class="col-md-4">
                                <x-ui.form.select
                                    name="status"
                                    label="Status"
                                    :options="['active' => 'Active', 'on_leave' => 'On Leave']"
                                    :selected="$tailor->status"
                                />
                            </div>
                            @if($branches->isNotEmpty())
                                <div class="col-md-4">
                                    <x-ui.form.select
                                        name="branch_id"
                                        label="Branch"
                                        :options="$branches"
                                        :selected="$tailor->branch_id"
                                        placeholder="— Select branch —"
                                    />
                                </div>
                            @endif
                        </div>

                        <x-ui.form.textarea name="notes" label="Notes" :value="$tailor->notes" />

                        <div class="d-flex">
                            <x-ui.button type="submit" icon="las la-save">Save Tailor</x-ui.button>
                            <x-ui.button :href="route('tailors.show', $tailor)" variant="outline-secondary" class="ml-2">Cancel</x-ui.button>
                        </div>
                    </form>
                </x-ui.card>
            </div>
        </div>
    </div>
</x-app-layout>
