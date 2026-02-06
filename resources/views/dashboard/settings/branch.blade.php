<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/select2/css/select2.min.css') }}">
    @endpush

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-3">Branch Settings - {{ $branch->name }}</h4>
                <p class="mb-0">Configure settings for {{ $branch->name }} branch</p>
            </div>
            <div>
                <a href="{{ route('branches.show', $branch) }}" class="btn btn-outline-secondary mr-2">
                    <i class="las la-arrow-left mr-1"></i> Back to Branch
                </a>
            </div>
        </div>

        <!-- Settings Form -->
        <form action="{{ route('settings.update.branch', $branch) }}" method="POST" id="branchSettingsForm">
            @csrf
            
            <div class="row">
                <div class="col-lg-8">
                    <!-- Branch Shop Information -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light py-3">
                            <h6 class="mb-0">Branch Shop Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Shop Name *</label>
                                    <input type="text" name="shop_name" class="form-control @error('shop_name') is-invalid @enderror" 
                                           value="{{ old('shop_name', $setting->shop_name) }}" required>
                                    @error('shop_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Shop Phone *</label>
                                    <input type="tel" name="shop_phone" class="form-control @error('shop_phone') is-invalid @enderror" 
                                           value="{{ old('shop_phone', $setting->shop_phone) }}" required>
                                    @error('shop_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Shop Email</label>
                                    <input type="email" name="shop_email" class="form-control @error('shop_email') is-invalid @enderror" 
                                           value="{{ old('shop_email', $setting->shop_email) }}">
                                    @error('shop_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Currency *</label>
                                    <select name="currency" class="form-control select2 @error('currency') is-invalid @enderror" required>
                                        <option value="PKR" {{ old('currency', $setting->currency) == 'PKR' ? 'selected' : '' }}>Pakistani Rupee (PKR)</option>
                                        <option value="USD" {{ old('currency', $setting->currency) == 'USD' ? 'selected' : '' }}>US Dollar (USD)</option>
                                        <option value="EUR" {{ old('currency', $setting->currency) == 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                                        <option value="GBP" {{ old('currency', $setting->currency) == 'GBP' ? 'selected' : '' }}>British Pound (GBP)</option>
                                        <option value="AED" {{ old('currency', $setting->currency) == 'AED' ? 'selected' : '' }}>UAE Dirham (AED)</option>
                                    </select>
                                    @error('currency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Currency Symbol *</label>
                                    <input type="text" name="currency_symbol" class="form-control @error('currency_symbol') is-invalid @enderror" 
                                           value="{{ old('currency_symbol', $setting->currency_symbol) }}" required maxlength="5">
                                    @error('currency_symbol')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tax Rate (%) *</label>
                                    <input type="number" name="tax_rate" class="form-control @error('tax_rate') is-invalid @enderror" 
                                           value="{{ old('tax_rate', $setting->tax_rate) }}" min="0" max="100" step="0.01" required>
                                    @error('tax_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Shop Address</label>
                                <textarea name="shop_address" class="form-control @error('shop_address') is-invalid @enderror" 
                                          rows="3">{{ old('shop_address', $setting->shop_address) }}</textarea>
                                @error('shop_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Receipt Settings -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light py-3">
                            <h6 class="mb-0">Receipt Settings</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Receipt Prefix *</label>
                                    <input type="text" name="receipt_prefix" class="form-control @error('receipt_prefix') is-invalid @enderror" 
                                           value="{{ old('receipt_prefix', $setting->receipt_prefix) }}" required maxlength="10">
                                    @error('receipt_prefix')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Next Receipt Number *</label>
                                    <input type="number" name="next_receipt_number" class="form-control @error('next_receipt_number') is-invalid @enderror" 
                                           value="{{ old('next_receipt_number', $setting->next_receipt_number) }}" min="1" required>
                                    @error('next_receipt_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Default Delivery Days *</label>
                                    <input type="number" name="default_delivery_days" class="form-control @error('default_delivery_days') is-invalid @enderror" 
                                           value="{{ old('default_delivery_days', $setting->default_delivery_days) }}" min="1" max="30" required>
                                    @error('default_delivery_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Receipt Header</label>
                                <textarea name="receipt_header" class="form-control @error('receipt_header') is-invalid @enderror" 
                                          rows="3" placeholder="Text to appear at the top of receipts">{{ old('receipt_header', $setting->receipt_header) }}</textarea>
                                @error('receipt_header')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Receipt Footer</label>
                                <textarea name="receipt_footer" class="form-control @error('receipt_footer') is-invalid @enderror" 
                                          rows="3" placeholder="Text to appear at the bottom of receipts">{{ old('receipt_footer', $setting->receipt_footer) }}</textarea>
                                @error('receipt_footer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Branch Specific Settings -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light py-3">
                            <h6 class="mb-0">Branch Specific Settings</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="sms_notifications" class="form-check-input" id="sms_notifications"
                                               {{ old('sms_notifications', $setting->sms_notifications) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sms_notifications">Enable SMS Notifications</label>
                                        <small class="text-muted d-block">Send SMS notifications from this branch</small>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="email_notifications" class="form-check-input" id="email_notifications"
                                               {{ old('email_notifications', $setting->email_notifications) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="email_notifications">Enable Email Notifications</label>
                                        <small class="text-muted d-block">Send email notifications from this branch</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Reminder Days Before Delivery</label>
                                    <input type="number" name="reminder_days_before" class="form-control @error('reminder_days_before') is-invalid @enderror" 
                                           value="{{ old('reminder_days_before', $setting->reminder_days_before) }}" min="0" max="7">
                                    <small class="text-muted">Number of days before delivery to send reminder</small>
                                    @error('reminder_days_before')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Default Tailor Assignment</label>
                                    <select name="default_tailor_id" class="form-control select2">
                                        <option value="">Select Default Tailor</option>
                                        @php
                                            $tailors = \App\Models\Tailor::where('branch_id', $branch->id)
                                                ->where('status', 'active')
                                                ->get();
                                        @endphp
                                        @foreach($tailors as $tailor)
                                        <option value="{{ $tailor->id }}" {{ old('default_tailor_id', $setting->default_tailor_id ?? '') == $tailor->id ? 'selected' : '' }}>
                                            {{ $tailor->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Default tailor for new assignments</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='{{ route('branches.show', $branch) }}'">
                            <i class="las la-times"></i> Cancel
                        </button>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="las la-save"></i> Save Settings
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Branch Info Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light py-3">
                            <h6 class="mb-0">Branch Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <div class="avatar mb-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($branch->name) }}&background=3B82F6&color=fff&size=80" 
                                         class="rounded-circle" 
                                         alt="{{ $branch->name }}">
                                </div>
                                <h5>{{ $branch->name }}</h5>
                                <p class="text-muted">{{ $branch->code }}</p>
                                <span class="badge badge-{{ $branch->is_active ? 'success' : 'secondary' }}">
                                    {{ $branch->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            
                            <div class="small">
                                <div class="mb-2">
                                    <label class="text-muted">Address:</label>
                                    <div>{{ $branch->address ?? 'N/A' }}</div>
                                </div>
                                <div class="mb-2">
                                    <label class="text-muted">Phone:</label>
                                    <div>{{ $branch->phone ?? 'N/A' }}</div>
                                </div>
                                <div class="mb-2">
                                    <label class="text-muted">Hours:</label>
                                    <div>{{ $branch->opening_time }} - {{ $branch->closing_time }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light py-3">
                            <h6 class="mb-0">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('branches.edit', $branch) }}" class="btn btn-outline-primary btn-block text-left">
                                    <i class="las la-edit mr-2"></i> Edit Branch
                                </a>
                                <a href="{{ route('settings.general') }}" class="btn btn-outline-success btn-block text-left">
                                    <i class="las la-cog mr-2"></i> General Settings
                                </a>
                                <button type="button" class="btn btn-outline-info btn-block text-left" onclick="copyFromGeneral()">
                                    <i class="las la-copy mr-2"></i> Copy from General
                                </button>
                                <button type="button" class="btn btn-outline-warning btn-block text-left" onclick="resetBranchSettings()">
                                    <i class="las la-undo mr-2"></i> Reset to Defaults
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Settings Status -->
                    <div class="card shadow">
                        <div class="card-header bg-light py-3">
                            <h6 class="mb-0">Settings Status</h6>
                        </div>
                        <div class="card-body">
                            <div class="small">
                                <div class="mb-2">
                                    <label class="text-muted">Last Updated:</label>
                                    <div>{{ $setting->updated_at ? $setting->updated_at->format('d M, Y h:i A') : 'Never' }}</div>
                                </div>
                                @if($setting->updatedBy)
                                <div>
                                    <label class="text-muted">Updated By:</label>
                                    <div>{{ $setting->updatedBy->name }}</div>
                                </div>
                                @endif
                                <div class="mt-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="overrideGeneral" checked>
                                        <label class="form-check-label" for="overrideGeneral">Override General Settings</label>
                                        <small class="text-muted d-block">When checked, branch settings override general settings</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    @push('js')
    <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/select2/js/select2.min.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap'
            });
            
            // Form validation
            $('#branchSettingsForm').submit(function(e) {
                const requiredFields = $(this).find('[required]');
                let valid = true;
                
                requiredFields.each(function() {
                    if (!$(this).val().trim()) {
                        valid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
                
                if (!valid) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                }
            });
        });
        
        function copyFromGeneral() {
            if (confirm('Copy settings from general settings? This will overwrite current values.')) {
                // In real app: AJAX call to get general settings
                const generalSettings = {
                    shop_name: 'Tailor Shop',
                    shop_phone: '+92 300 1234567',
                    shop_email: 'info@tailorshop.com',
                    currency: 'PKR',
                    currency_symbol: 'Rs',
                    tax_rate: 0,
                    receipt_prefix: 'TS',
                    next_receipt_number: 1000,
                    default_delivery_days: 7,
                    receipt_header: 'Thank you for your business!',
                    receipt_footer: 'Visit us again!',
                    sms_notifications: true,
                    email_notifications: true,
                    reminder_days_before: 1
                };
                
                Object.keys(generalSettings).forEach(key => {
                    const element = $(`[name="${key}"]`);
                    if (element.length) {
                        if (element.attr('type') === 'checkbox') {
                            element.prop('checked', generalSettings[key]);
                        } else {
                            element.val(generalSettings[key]);
                        }
                    }
                });
                
                // Update select2 if needed
                $('.select2').trigger('change');
                
                alert('Settings copied from general settings.');
            }
        }
        
        function resetBranchSettings() {
            if (confirm('Reset branch settings to defaults?')) {
                const defaults = {
                    shop_name: '{{ $branch->name }}',
                    shop_phone: '{{ $branch->phone }}',
                    shop_email: '{{ $branch->email }}',
                    shop_address: '{{ $branch->address }}',
                    currency: 'PKR',
                    currency_symbol: 'Rs',
                    tax_rate: 0,
                    receipt_prefix: '{{ strtoupper(substr($branch->code, 0, 2)) }}',
                    next_receipt_number: 1000,
                    default_delivery_days: 7,
                    receipt_header: 'Thank you for your business!',
                    receipt_footer: 'Visit us again!',
                    sms_notifications: true,
                    email_notifications: true,
                    reminder_days_before: 1
                };
                
                Object.keys(defaults).forEach(key => {
                    const element = $(`[name="${key}"]`);
                    if (element.length) {
                        if (element.attr('type') === 'checkbox') {
                            element.prop('checked', defaults[key]);
                        } else {
                            element.val(defaults[key]);
                        }
                    }
                });
                
                // Update select2 if needed
                $('.select2').trigger('change');
                
                alert('Branch settings reset to defaults.');
            }
        }
    </script>
    
    <style>
        .card {
            border-radius: 0.5rem;
        }
        .card-header.bg-light {
            background-color: #f8f9fa !important;
            border-bottom: 1px solid #e9ecef;
        }
        .avatar {
            width: 80px;
            height: 80px;
            margin: 0 auto;
        }
        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .btn {
            border-radius: 0.375rem;
        }
        .form-control {
            border-radius: 0.375rem;
        }
        .badge {
            font-size: 0.75em;
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
        .form-check.form-switch .form-check-input {
            width: 3em;
            height: 1.5em;
        }
    </style>
    @endpush
</x-app-layout>