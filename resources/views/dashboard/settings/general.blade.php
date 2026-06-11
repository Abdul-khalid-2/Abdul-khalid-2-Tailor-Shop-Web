<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header title="General Info"
            :subtitle="$scope === 'global' ? 'System-wide shop settings' : 'Settings for '.$branch->name.' branch'">
            <x-slot:actions>
                <x-ui.button :href="route('settings.index')" variant="outline-secondary" icon="las la-arrow-left">Back to Settings</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <form action="{{ route('settings.update.general') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-8">
                    <x-ui.card title="Shop Information" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <x-ui.form.input name="shop_name" label="Shop Name" :value="$setting->shop_name" required />
                            </div>
                            <div class="col-md-6">
                                <x-ui.form.input name="shop_phone" label="Phone" :value="$setting->shop_phone" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <x-ui.form.input type="email" name="shop_email" label="Email" :value="$setting->shop_email" />
                            </div>
                            <div class="col-md-3">
                                <x-ui.form.input name="currency" label="Currency" :value="$setting->currency" maxlength="3" required />
                            </div>
                            <div class="col-md-3">
                                <x-ui.form.input name="currency_symbol" label="Symbol" :value="$setting->currency_symbol" required />
                            </div>
                        </div>
                        <x-ui.form.textarea name="shop_address" label="Address" :value="$setting->shop_address" :rows="2" />
                    </x-ui.card>

                    <x-ui.card title="Business Defaults" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <x-ui.form.input type="number" name="default_delivery_days" label="Default Delivery Days"
                                    :value="$setting->default_delivery_days" min="1" max="30" required />
                            </div>
                            <div class="col-md-4">
                                <x-ui.form.input type="number" name="tax_rate" label="Tax Rate (%)"
                                    :value="$setting->tax_rate" min="0" max="100" step="0.01" required />
                            </div>
                            <div class="col-md-4">
                                <x-ui.form.input type="number" name="reminder_days_before" label="Reminder Days Before Delivery"
                                    :value="$setting->reminder_days_before" min="0" max="7" />
                            </div>
                        </div>
                    </x-ui.card>

                    <x-ui.card title="Receipt Settings" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <x-ui.form.input name="receipt_prefix" label="Receipt Prefix"
                                    :value="$setting->receipt_prefix" maxlength="10" required />
                            </div>
                            <div class="col-md-4">
                                <x-ui.form.input type="number" name="next_receipt_number" label="Next Receipt Number"
                                    :value="$setting->next_receipt_number" min="1" required />
                            </div>
                        </div>
                        <x-ui.form.textarea name="receipt_header" label="Receipt Header" :value="$setting->receipt_header" :rows="2" />
                        <x-ui.form.textarea name="receipt_footer" label="Receipt Footer" :value="$setting->receipt_footer" :rows="2" class="mb-0" />
                    </x-ui.card>

                    <x-ui.card title="Notifications" class="mb-4">
                        <x-ui.form.checkbox name="sms_notifications" label="Enable SMS notifications" :checked="$setting->sms_notifications" />
                        <x-ui.form.checkbox name="email_notifications" label="Enable email notifications" :checked="$setting->email_notifications" wrapperClass="" />
                    </x-ui.card>

                    <x-ui.button type="submit" size="lg" icon="las la-save">Save Settings</x-ui.button>
                </div>

                <div class="col-lg-4">
                    <x-ui.card title="Shop Logo">
                        @if($setting->logo_path)
                            <div class="text-center mb-3">
                                <img src="{{ $setting->logo_url }}" alt="Logo" class="img-fluid rounded" style="max-height: 120px;">
                            </div>
                            <x-ui.button :href="route('settings.delete.logo', 'general')" variant="outline-danger" size="sm"
                                icon="las la-trash" class="btn-block mb-3"
                                onclick="return confirm('Delete this logo?')">Remove Logo</x-ui.button>
                        @endif
                        <x-ui.form.file name="logo" label="Upload Logo" accept="image/*" help="JPG, PNG, or SVG. Max 2MB." class="mb-0" />
                    </x-ui.card>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
