<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header :title="__('messages.add_customer')" :subtitle="__('messages.add_customer_subtitle')">
            <x-slot:actions>
                <x-ui.button :href="route('customers.index')" variant="outline-secondary" icon="las la-arrow-left">{{ __('messages.back_to_customers') }}</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <div class="row g-4">
            <div class="col-lg-8">
                <x-ui.card>
                    <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <x-ui.form.input name="name" :label="__('messages.name')" required />
                        <x-ui.form.input name="phone" :label="__('messages.phone')" required />
                        <x-ui.form.file name="profile_photo" :label="__('messages.photo')" accept="image/*" :help="__('messages.photo_help_new')" />
                        <x-ui.form.textarea name="address" :label="__('messages.address')" />
                        @if($branches->isNotEmpty())
                            <x-ui.form.select
                                name="branch_id"
                                :label="__('messages.branch_label')"
                                :options="$branches"
                                :placeholder="__('messages.select_branch')"
                            />
                        @endif
                        <x-ui.form.textarea name="notes" :label="__('messages.notes')" />

                        <div class="d-flex">
                            <x-ui.button type="submit" icon="las la-save">{{ __('messages.save_customer') }}</x-ui.button>
                            <x-ui.button :href="route('customers.index')" variant="outline-secondary" class="ml-2">{{ __('messages.cancel') }}</x-ui.button>
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
                    <ul class="list-unstyled small text-muted mb-0 customer-guide">
                        <li class="mb-2"><i class="las la-user text-primary mr-1"></i>
                            {!! __('messages.cust_guide_required') !!}</li>
                        <li class="mb-2"><i class="las la-phone text-primary mr-1"></i>
                            {!! __('messages.cust_guide_phone') !!}</li>
                        <li class="mb-2"><i class="las la-image text-primary mr-1"></i>
                            {!! __('messages.cust_guide_photo') !!}</li>
                        @if($branches->isNotEmpty())
                            <li class="mb-2"><i class="las la-store text-primary mr-1"></i>
                                {!! __('messages.cust_guide_branch_pick') !!}</li>
                        @else
                            <li class="mb-2"><i class="las la-store text-primary mr-1"></i>
                                {!! __('messages.cust_guide_branch_auto') !!}</li>
                        @endif
                        <li class="mb-0"><i class="las la-sticky-note text-primary mr-1"></i>
                            {!! __('messages.cust_guide_notes') !!}</li>
                    </ul>
                </x-ui.card>
            </div>
        </div>
    </div>
</x-app-layout>
