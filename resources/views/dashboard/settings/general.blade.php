<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    @endpush

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-3">General Settings</h4>
                <p class="mb-0">Configure system-wide settings and defaults</p>
            </div>
            <div>
                <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left mr-1"></i> Back to Settings
                </a>
            </div>
        </div>

        <!-- Settings Form -->
        <form action="{{ route('settings.update.general') }}" method="POST" id="settingsForm">
            @csrf
            
            <div class="row">
                <div class="col-lg-8">
                    <!-- Shop Information -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light py-3">
                            <h6 class="mb-0">Shop Information</h6>
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

                    <!-- Notification Settings -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light py-3">
                            <h6 class="mb-0">Notification Settings</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="sms_notifications" class="form-check-input" id="sms_notifications"
                                               {{ old('sms_notifications', $setting->sms_notifications) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sms_notifications">Enable SMS Notifications</label>
                                        <small class="text-muted d-block">Send SMS notifications for orders, reminders, etc.</small>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="email_notifications" class="form-check-input" id="email_notifications"
                                               {{ old('email_notifications', $setting->email_notifications) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="email_notifications">Enable Email Notifications</label>
                                        <small class="text-muted d-block">Send email notifications for orders, reminders, etc.</small>
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
                            </div>
                        </div>
                    </div>

                    <!-- Measurement Settings -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light py-3">
                            <h6 class="mb-0">Measurement Settings</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Default Measurement Fields</label>
                                <div class="border rounded p-3">
                                    <div class="row">
                                        @php
                                            $defaultFields = ['height', 'weight', 'chest', 'waist', 'hips', 'shoulder', 'sleeve_length', 'sleeve_width'];
                                            $currentFields = old('measurement_fields', $setting->measurement_fields ?? $defaultFields);
                                            $currentFields = is_array($currentFields) ? $currentFields : [];
                                        @endphp
                                        @foreach($defaultFields as $field)
                                        <div class="col-md-3 mb-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="measurement_fields[]" class="form-check-input" 
                                                       id="field_{{ $field }}" value="{{ $field }}"
                                                       {{ in_array($field, $currentFields) ? 'checked' : '' }}>
                                                <label class="form-check-label text-capitalize" for="field_{{ $field }}">{{ str_replace('_', ' ', $field) }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <small class="text-muted">Select which measurement fields to enable by default</small>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='{{ route('settings.index') }}'">
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
                    <!-- Preview Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light py-3">
                            <h6 class="mb-0">Shop Preview</h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                @if($setting->logo_path)
                                <img src="{{ asset('storage/' . $setting->logo_path) }}" alt="Shop Logo" class="img-fluid mb-3" style="max-height: 100px;">
                                @else
                                <div class="avatar-placeholder mb-3">
                                    <i class="las la-store fa-4x text-muted"></i>
                                </div>
                                @endif
                                <h4 id="previewShopName">{{ $setting->shop_name }}</h4>
                                <p class="text-muted" id="previewShopContact">
                                    {{ $setting->shop_phone }}<br>
                                    {{ $setting->shop_email }}
                                </p>
                            </div>
                            
                            <div class="border rounded p-3 mb-3">
                                <h6 class="mb-2">Sample Receipt</h6>
                                <div class="receipt-preview small">
                                    <div class="text-center mb-2" id="previewReceiptHeader">{{ $setting->receipt_header ?: 'Thank you for your business!' }}</div>
                                    <div class="mb-2">
                                        <div class="d-flex justify-content-between">
                                            <span>Order #:</span>
                                            <span>{{ $setting->receipt_prefix }}-{{ $setting->next_receipt_number }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Date:</span>
                                            <span>{{ now()->format('d M, Y') }}</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mb-2">
                                        <div class="d-flex justify-content-between">
                                            <span>Subtotal:</span>
                                            <span>{{ $setting->currency_symbol }} 5,000</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Tax ({{ $setting->tax_rate }}%):</span>
                                            <span>{{ $setting->currency_symbol }} {{ number_format(5000 * $setting->tax_rate / 100, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between font-weight-bold">
                                            <span>Total:</span>
                                            <span>{{ $setting->currency_symbol }} {{ number_format(5000 * (1 + $setting->tax_rate / 100), 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="text-center mt-2 text-muted" id="previewReceiptFooter">{{ $setting->receipt_footer ?: 'Visit us again!' }}</div>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="updatePreview()">
                                    <i class="las la-redo-alt"></i> Update Preview
                                </button>
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
                                <button type="button" class="btn btn-outline-primary btn-block text-left" data-toggle="modal" data-target="#logoModal">
                                    <i class="las la-image mr-2"></i> Upload Logo
                                </button>
                                <button type="button" class="btn btn-outline-success btn-block text-left" onclick="resetToDefaults()">
                                    <i class="las la-undo mr-2"></i> Reset to Defaults
                                </button>
                                <button type="button" class="btn btn-outline-info btn-block text-left" onclick="testNotifications()">
                                    <i class="las la-bell mr-2"></i> Test Notifications
                                </button>
                                <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary btn-block text-left">
                                    <i class="las la-cog mr-2"></i> All Settings
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- System Info -->
                    <div class="card shadow">
                        <div class="card-header bg-light py-3">
                            <h6 class="mb-0">System Information</h6>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Logo Modal -->
    <div class="modal fade" id="logoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Logo</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="logoForm" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Select Logo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="logoFile" accept="image/*" onchange="previewLogo(this)">
                                <label class="custom-file-label" for="logoFile">Choose file</label>
                            </div>
                            <small class="text-muted">Max size: 2MB, Formats: JPG, PNG, SVG</small>
                        </div>
                        <div class="form-group text-center">
                            <div id="logoPreview" class="mb-3">
                                @if($setting->logo_path)
                                <img src="{{ asset('storage/' . $setting->logo_path) }}" alt="Current Logo" class="img-fluid" style="max-height: 100px;">
                                @else
                                <div class="avatar-placeholder">
                                    <i class="las la-store fa-4x text-muted"></i>
                                </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="uploadLogo()">
                        <i class="las la-upload mr-1"></i> Upload Logo
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    @push('js')
     <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>

    <!-- Table Treeview JavaScript -->
    <script src="{{ asset('backend/assets/js/table-treeview.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('backend/assets/js/customizer.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('backend/assets/js/chart-custom.js') }}"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap'
            });
            
            // File input label
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
            
            // Form validation
            $('#settingsForm').submit(function(e) {
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
        
        function updatePreview() {
            // Update shop name preview
            const shopName = $('input[name="shop_name"]').val();
            if (shopName) {
                $('#previewShopName').text(shopName);
            }
            
            // Update contact preview
            const phone = $('input[name="shop_phone"]').val();
            const email = $('input[name="shop_email"]').val();
            $('#previewShopContact').html(phone + (email ? '<br>' + email : ''));
            
            // Update receipt header/footer
            const header = $('textarea[name="receipt_header"]').val();
            const footer = $('textarea[name="receipt_footer"]').val();
            if (header) $('#previewReceiptHeader').text(header);
            if (footer) $('#previewReceiptFooter').text(footer);
            
            alert('Preview updated!');
        }
        
        function resetToDefaults() {
            if (confirm('Are you sure you want to reset all settings to defaults?')) {
                // Reset form values to defaults
                const defaults = {
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
                
                // Reset measurement fields
                $('input[name="measurement_fields[]"]').prop('checked', false);
                const defaultFields = ['height', 'weight', 'chest', 'waist', 'hips', 'shoulder', 'sleeve_length', 'sleeve_width'];
                defaultFields.forEach(field => {
                    $(`#field_${field}`).prop('checked', true);
                });
                
                updatePreview();
                alert('Settings reset to defaults.');
            }
        }
        
        function testNotifications() {
            if (confirm('Send test notifications? This will send SMS and email if enabled.')) {
                alert('Test notifications sent!');
                // In real app: AJAX call to send test notifications
            }
        }
        
        function previewLogo(input) {
            const preview = document.getElementById('logoPreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" class="img-fluid" style="max-height: 100px;">`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        function uploadLogo() {
            const file = $('#logoFile')[0].files[0];
            if (!file) {
                alert('Please select a logo file');
                return;
            }
            
            // Check file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB');
                return;
            }
            
            // Check file type
            const validTypes = ['image/jpeg', 'image/png', 'image/svg+xml'];
            if (!validTypes.includes(file.type)) {
                alert('Only JPG, PNG, and SVG files are allowed');
                return;
            }
            
            alert('Logo uploaded successfully!');
            $('#logoModal').modal('hide');
            // In real app: AJAX call to upload logo
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
        .btn {
            border-radius: 0.375rem;
        }
        .form-control {
            border-radius: 0.375rem;
        }
        .receipt-preview {
            font-family: 'Courier New', monospace;
        }
        .form-check.form-switch .form-check-input {
            width: 3em;
            height: 1.5em;
        }
        .avatar-placeholder {
            width: 100px;
            height: 100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 50%;
        }
        .border {
            border-radius: 0.375rem;
        }
        .modal-content {
            border-radius: 0.5rem;
        }
    </style>
    @endpush
</x-app-layout>