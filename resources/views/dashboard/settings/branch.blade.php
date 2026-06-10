<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header :title="'Branch Settings - ' . $branch->name" :subtitle="'Configure settings for ' . $branch->name . ' branch'">
            <x-slot:actions>
                <x-ui.button :href="route('branches.show', $branch)" variant="outline-secondary" icon="las la-arrow-left" class="mr-2">Back to Branch</x-ui.button>
                <x-ui.button :href="route('settings.index')" variant="outline-secondary" icon="las la-cog">All Settings</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <!-- Settings Form -->
        <form action="{{ route('settings.update.branch', $branch) }}" method="POST" id="branchSettingsForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
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
                            </div>
                        </div>
                    </div>

                    <!-- Logo Settings -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light py-3">
                            <h6 class="mb-0">Logo Settings</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Upload Branch Logo</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="logo" name="logo" accept="image/*">
                                            <label class="custom-file-label" for="logo">Choose file...</label>
                                        </div>
                                        <small class="text-muted">Max size: 2MB, Formats: JPG, PNG, SVG</small>
                                        @error('logo')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    @if($setting->logo_path)
                                    <div class="mb-3">
                                        <label class="form-label">Current Logo</label>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ Storage::url($setting->logo_path) }}" alt="Logo" class="img-thumbnail mr-3" style="max-height: 60px;">
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeleteLogo()">
                                                <i class="las la-trash mr-1"></i> Delete Logo
                                            </button>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="alert alert-info">
                                        <h6><i class="las la-info-circle mr-2"></i> Note:</h6>
                                        <ul class="mb-0 pl-3">
                                            <li>Branch logo overrides general logo</li>
                                            <li>Will appear on branch-specific receipts</li>
                                            <li>Leave empty to use general logo</li>
                                            <li>Recommended: Square logo with transparent background</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='{{ route('settings.index') }}'">
                            <i class="las la-times mr-1"></i> Cancel
                        </button>
                        <div>
                            <button type="reset" class="btn btn-outline-warning mr-2">
                                <i class="las la-redo mr-1"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="las la-save mr-1"></i> Save Settings
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
                                    <label class="text-muted">Email:</label>
                                    <div>{{ $branch->email ?? 'N/A' }}</div>
                                </div>
                                <div class="mb-2">
                                    <label class="text-muted">Hours:</label>
                                    <div>{{ \Carbon\Carbon::parse($branch->opening_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($branch->closing_time)->format('h:i A') }}</div>
                                </div>
                                <div class="mb-2">
                                    <label class="text-muted">Manager:</label>
                                    <div>{{ $branch->manager_name ?? 'N/A' }}</div>
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
                                <button type="button" class="btn btn-outline-warning btn-block text-left" onclick="resetToDefaults()">
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
                                    <label class="text-muted">Created:</label>
                                    <div>{{ $setting->created_at->format('d M, Y h:i A') }}</div>
                                </div>
                                <div class="mb-2">
                                    <label class="text-muted">Last Updated:</label>
                                    <div>{{ $setting->updated_at->format('d M, Y h:i A') }}</div>
                                </div>
                                @if($setting->createdBy)
                                <div class="mb-2">
                                    <label class="text-muted">Created By:</label>
                                    <div>{{ $setting->createdBy->name }}</div>
                                </div>
                                @endif
                                @if($setting->updatedBy)
                                <div>
                                    <label class="text-muted">Last Updated By:</label>
                                    <div>{{ $setting->updatedBy->name }}</div>
                                </div>
                                @endif
                                <div class="mt-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="overrideGeneral" 
                                               {{ $setting->override_general ?? false ? 'checked' : '' }}>
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
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap',
                width: '100%'
            });
            
            // File input label
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
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
                fetch('{{ route("settings.general") }}/data')
                    .then(response => response.json())
                    .then(data => {
                        Object.keys(data).forEach(key => {
                            const element = $(`[name="${key}"]`);
                            if (element.length) {
                                if (element.attr('type') === 'checkbox') {
                                    element.prop('checked', data[key]);
                                } else if (element.is('select')) {
                                    element.val(data[key]).trigger('change');
                                } else {
                                    element.val(data[key]);
                                }
                            }
                        });
                        
                        // Update select2
                        $('.select2').trigger('change');
                        
                        alert('Settings copied from general settings.');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Unable to fetch general settings.');
                    });
            }
        }
        
        function resetToDefaults() {
            if (confirm('Reset branch settings to defaults?')) {
                // Get original values from database
                const defaults = @json($setting->toArray());
                
                Object.keys(defaults).forEach(key => {
                    if (key !== 'id' && key !== 'created_at' && key !== 'updated_at' && key !== 'created_by' && key !== 'updated_by') {
                        const element = $(`[name="${key}"]`);
                        if (element.length) {
                            if (element.attr('type') === 'checkbox') {
                                element.prop('checked', defaults[key]);
                            } else if (element.is('select')) {
                                element.val(defaults[key]).trigger('change');
                            } else {
                                element.val(defaults[key]);
                            }
                        }
                    }
                });
                
                // Update select2
                $('.select2').trigger('change');
                
                alert('Branch settings reset to saved values.');
            }
        }
        
        function confirmDeleteLogo() {
            if (confirm('Are you sure you want to delete the branch logo? This cannot be undone.')) {
                window.location.href = "{{ route('settings.delete.logo', ['type' => 'branch', 'branch' => $branch]) }}";
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
        .img-thumbnail {
            border-radius: 0.375rem;
        }
        .alert {
            border-radius: 0.375rem;
            border: none;
        }
    </style>
    @endpush
</x-app-layout>