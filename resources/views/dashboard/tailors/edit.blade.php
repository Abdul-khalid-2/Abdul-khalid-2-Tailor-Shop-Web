<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header :title="__('messages.edit_tailor')" :subtitle="__('messages.edit_tailor_subtitle')">
            <x-slot:actions>
                <x-ui.button :href="route('tailors.show', $tailor)" variant="outline-secondary" icon="las la-arrow-left">{{ __('messages.back_to_tailor') }}</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <x-ui.card>
                    <form action="{{ route('tailors.update', $tailor) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <x-ui.form.input name="name" :label="__('messages.name')" :value="$tailor->name" required />
                            </div>
                            <div class="col-md-6">
                                <x-ui.form.input name="phone" :label="__('messages.phone')" :value="$tailor->phone" required />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-ui.form.input name="cnic" :label="__('messages.cnic')" :value="$tailor->cnic" />
                            </div>
                            <div class="col-md-6">
                                <x-ui.form.input type="date" name="joining_date" :label="__('messages.joining_date')" :value="$tailor->joining_date?->format('Y-m-d')" />
                            </div>
                        </div>

                        @if($tailor->profile_photo)
                            <div class="form-group">
                                <label class="form-label d-block">{{ __('messages.current_photo') }}</label>
                                <img src="{{ asset($tailor->profile_photo) }}" alt="{{ $tailor->name }}"
                                     class="rounded" style="height:90px;width:90px;object-fit:cover;">
                            </div>
                        @endif
                        <x-ui.form.file name="profile_photo" :label="__('messages.photo')" accept="image/*" :help="__('messages.photo_help_keep')" />

                        <x-ui.form.textarea name="address" :label="__('messages.address')" :value="$tailor->address" :rows="2" />

                        <div class="row">
                            <div class="col-md-4">
                                <x-ui.form.select
                                    name="specialty"
                                    :label="__('messages.specialty')"
                                    :options="['all' => __('messages.all_types'), 'shalwar_kameez' => __('messages.shalwar_kameez'), 'sherwani' => __('messages.sherwani')]"
                                    :selected="$tailor->specialty"
                                />
                            </div>
                            <div class="col-md-4">
                                <x-ui.form.select
                                    name="status"
                                    :label="__('messages.status')"
                                    :options="['active' => __('messages.active'), 'on_leave' => __('messages.on_leave')]"
                                    :selected="$tailor->status"
                                />
                            </div>
                            @if($branches->isNotEmpty())
                                <div class="col-md-4">
                                    <x-ui.form.select
                                        name="branch_id"
                                        :label="__('messages.branch_label')"
                                        :options="$branches"
                                        :selected="$tailor->branch_id"
                                        :placeholder="__('messages.select_branch')"
                                    />
                                </div>
                            @endif
                        </div>

                        <x-ui.form.textarea name="notes" :label="__('messages.notes')" :value="$tailor->notes" />

                        <div class="d-flex">
                            <x-ui.button type="submit" icon="las la-save">{{ __('messages.save_tailor') }}</x-ui.button>
                            <x-ui.button :href="route('tailors.show', $tailor)" variant="outline-secondary" class="ml-2">{{ __('messages.cancel') }}</x-ui.button>
                        </div>
                    </form>
                </x-ui.card>
            </div>
        </div>
    </div>
</x-app-layout>
