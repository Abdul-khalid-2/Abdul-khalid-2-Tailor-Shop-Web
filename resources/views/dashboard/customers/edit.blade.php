<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header :title="__('messages.edit_customer')" :subtitle="__('messages.edit_customer_subtitle')">
            <x-slot:actions>
                <x-ui.button :href="route('customers.show', $customer)" variant="outline-secondary" icon="las la-arrow-left">{{ __('messages.back_to_customer') }}</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <x-ui.card>
                    <form action="{{ route('customers.update', $customer) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <x-ui.form.input name="name" :label="__('messages.name')" :value="$customer->name" required />
                        <x-ui.form.input name="phone" :label="__('messages.phone')" :value="$customer->phone" required />

                        @if($customer->profile_photo)
                            <div class="form-group">
                                <label class="form-label d-block">{{ __('messages.current_photo') }}</label>
                                <img src="{{ asset($customer->profile_photo) }}" alt="{{ $customer->name }}"
                                     class="rounded" style="height:90px;width:90px;object-fit:cover;">
                            </div>
                        @endif
                        <x-ui.form.file name="profile_photo" :label="__('messages.photo')" accept="image/*" :help="__('messages.photo_help_keep')" />

                        <x-ui.form.textarea name="address" :label="__('messages.address')" :value="$customer->address" />
                        @if($branches->isNotEmpty())
                            <x-ui.form.select
                                name="branch_id"
                                :label="__('messages.branch_label')"
                                :options="$branches"
                                :selected="$customer->branch_id"
                                :placeholder="__('messages.select_branch')"
                            />
                        @endif
                        <x-ui.form.textarea name="notes" :label="__('messages.notes')" :value="$customer->notes" />

                        <div class="d-flex">
                            <x-ui.button type="submit" icon="las la-save">{{ __('messages.save_customer') }}</x-ui.button>
                            <x-ui.button :href="route('customers.show', $customer)" variant="outline-secondary" class="ml-2">{{ __('messages.cancel') }}</x-ui.button>
                        </div>
                    </form>
                </x-ui.card>
            </div>
        </div>
    </div>
</x-app-layout>
