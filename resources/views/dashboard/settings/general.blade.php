<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    @endpush

    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1">General Info</h4>
                <p class="mb-0 text-muted">
                    @if($scope === 'global')
                        System-wide shop settings
                    @else
                        Settings for {{ $branch->name }} branch
                    @endif
                </p>
            </div>
            <div>
                <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left mr-1"></i> Back to Settings
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="las la-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('settings.update.general') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Shop Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="shop_name">Shop Name <span class="text-danger">*</span></label>
                                    <input type="text" name="shop_name" id="shop_name" class="form-control"
                                           value="{{ old('shop_name', $setting->shop_name) }}" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="shop_phone">Phone <span class="text-danger">*</span></label>
                                    <input type="text" name="shop_phone" id="shop_phone" class="form-control"
                                           value="{{ old('shop_phone', $setting->shop_phone) }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="shop_email">Email</label>
                                    <input type="email" name="shop_email" id="shop_email" class="form-control"
                                           value="{{ old('shop_email', $setting->shop_email) }}">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="currency">Currency <span class="text-danger">*</span></label>
                                    <input type="text" name="currency" id="currency" class="form-control"
                                           value="{{ old('currency', $setting->currency) }}" maxlength="3" required>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="currency_symbol">Symbol <span class="text-danger">*</span></label>
                                    <input type="text" name="currency_symbol" id="currency_symbol" class="form-control"
                                           value="{{ old('currency_symbol', $setting->currency_symbol) }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="shop_address">Address</label>
                                <textarea name="shop_address" id="shop_address" class="form-control" rows="2">{{ old('shop_address', $setting->shop_address) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Business Defaults</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="default_delivery_days">Default Delivery Days <span class="text-danger">*</span></label>
                                    <input type="number" name="default_delivery_days" id="default_delivery_days" class="form-control"
                                           value="{{ old('default_delivery_days', $setting->default_delivery_days) }}" min="1" max="30" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="tax_rate">Tax Rate (%) <span class="text-danger">*</span></label>
                                    <input type="number" name="tax_rate" id="tax_rate" class="form-control"
                                           value="{{ old('tax_rate', $setting->tax_rate) }}" min="0" max="100" step="0.01" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="reminder_days_before">Reminder Days Before Delivery</label>
                                    <input type="number" name="reminder_days_before" id="reminder_days_before" class="form-control"
                                           value="{{ old('reminder_days_before', $setting->reminder_days_before) }}" min="0" max="7">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Receipt Settings</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="receipt_prefix">Receipt Prefix <span class="text-danger">*</span></label>
                                    <input type="text" name="receipt_prefix" id="receipt_prefix" class="form-control"
                                           value="{{ old('receipt_prefix', $setting->receipt_prefix) }}" maxlength="10" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="next_receipt_number">Next Receipt Number <span class="text-danger">*</span></label>
                                    <input type="number" name="next_receipt_number" id="next_receipt_number" class="form-control"
                                           value="{{ old('next_receipt_number', $setting->next_receipt_number) }}" min="1" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="receipt_header">Receipt Header</label>
                                <textarea name="receipt_header" id="receipt_header" class="form-control" rows="2">{{ old('receipt_header', $setting->receipt_header) }}</textarea>
                            </div>
                            <div class="form-group mb-0">
                                <label for="receipt_footer">Receipt Footer</label>
                                <textarea name="receipt_footer" id="receipt_footer" class="form-control" rows="2">{{ old('receipt_footer', $setting->receipt_footer) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Notifications</h6>
                        </div>
                        <div class="card-body">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="sms_notifications" name="sms_notifications"
                                       {{ old('sms_notifications', $setting->sms_notifications) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="sms_notifications">Enable SMS notifications</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="email_notifications" name="email_notifications"
                                       {{ old('email_notifications', $setting->email_notifications) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="email_notifications">Enable email notifications</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="las la-save mr-1"></i> Save Settings
                    </button>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Shop Logo</h6>
                        </div>
                        <div class="card-body">
                            @if($setting->logo_path)
                                <div class="text-center mb-3">
                                    <img src="{{ Storage::url($setting->logo_path) }}" alt="Logo" class="img-fluid rounded" style="max-height: 120px;">
                                </div>
                                <a href="{{ route('settings.delete.logo', 'general') }}" class="btn btn-sm btn-outline-danger btn-block mb-3"
                                   onclick="return confirm('Delete this logo?')">
                                    <i class="las la-trash mr-1"></i> Remove Logo
                                </a>
                            @endif
                            <div class="form-group mb-0">
                                <label for="logo">Upload Logo</label>
                                <input type="file" name="logo" id="logo" class="form-control-file" accept="image/*">
                                <small class="text-muted">JPG, PNG, or SVG. Max 2MB.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('js')
        <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
        <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>
