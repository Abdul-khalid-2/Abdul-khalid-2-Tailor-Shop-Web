<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header :title="__('messages.add_tailor')" :subtitle="__('messages.add_tailor_subtitle')">
            <x-slot:actions>
                <x-ui.button :href="route('tailors.index')" variant="outline-secondary" icon="las la-arrow-left">{{ __('messages.back_to_tailors') }}</x-ui.button>
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
                                <x-ui.form.input name="name" :label="__('messages.name')" required />
                            </div>
                            <div class="col-md-6">
                                <x-ui.form.input name="phone" :label="__('messages.phone')" required />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-ui.form.input name="cnic" :label="__('messages.cnic')" />
                            </div>
                            <div class="col-md-6">
                                <x-ui.form.input type="date" name="joining_date" :label="__('messages.joining_date')" />
                            </div>
                        </div>

                        <x-ui.form.file name="profile_photo" :label="__('messages.photo')" accept="image/*" :help="__('messages.photo_help_new')" />

                        <x-ui.form.textarea name="address" :label="__('messages.address')" :rows="2" />

                        <div class="row">
                            <div class="col-md-6">
                                <x-ui.form.select
                                    name="specialty"
                                    :label="__('messages.specialty')"
                                    :options="['all' => __('messages.all_types'), 'shalwar_kameez' => __('messages.shalwar_kameez'), 'sherwani' => __('messages.sherwani')]"
                                    selected="all"
                                />
                            </div>
                            @if($branches->isNotEmpty())
                                <div class="col-md-6">
                                    <x-ui.form.select
                                        name="branch_id"
                                        :label="__('messages.branch_label')"
                                        :options="$branches"
                                        :placeholder="__('messages.select_branch')"
                                    />
                                </div>
                            @endif
                        </div>

                        <x-ui.form.textarea name="notes" :label="__('messages.notes')" />

                        <div class="d-flex">
                            <x-ui.button type="submit" icon="las la-save">{{ __('messages.save_tailor') }}</x-ui.button>
                            <x-ui.button :href="route('tailors.index')" variant="outline-secondary" class="ml-2">{{ __('messages.cancel') }}</x-ui.button>
                        </div>
                    </form>
                </x-ui.card>
            </div>

            {{-- Guidance note --}}
            <div class="col-lg-4">
                <x-ui.card class="mb-0">
                    <h6 class="font-weight-bold mb-3">
                        <i class="las la-info-circle text-primary mr-1"></i> {{ __('messages.quick_guide') }}
                    </h6>
                    <ul class="list-unstyled small text-muted mb-0 tailor-guide">
                        <li class="mb-2"><i class="las la-user text-primary mr-1"></i>
                            {!! __('messages.tailor_guide_required') !!}</li>
                        <li class="mb-2"><i class="las la-id-card text-primary mr-1"></i>
                            {!! __('messages.tailor_guide_cnic') !!}</li>
                        <li class="mb-2"><i class="las la-image text-primary mr-1"></i>
                            {!! __('messages.tailor_guide_photo') !!}</li>
                        <li class="mb-2"><i class="las la-cut text-primary mr-1"></i>
                            {!! __('messages.tailor_guide_specialty') !!}</li>
                        @if($branches->isNotEmpty())
                            <li class="mb-2"><i class="las la-store text-primary mr-1"></i>
                                {!! __('messages.tailor_guide_branch_pick') !!}</li>
                        @else
                            <li class="mb-2"><i class="las la-store text-primary mr-1"></i>
                                {!! __('messages.tailor_guide_branch_auto') !!}</li>
                        @endif
                        <li class="mb-0"><i class="las la-sticky-note text-primary mr-1"></i>
                            {!! __('messages.tailor_guide_status') !!}</li>
                    </ul>
                </x-ui.card>
            </div>
        </div>
    </div>
</x-app-layout>
