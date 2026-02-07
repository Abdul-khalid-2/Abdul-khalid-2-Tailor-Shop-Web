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
                <h4 class="mb-3">Edit Customer: {{ $customer->name }}</h4>
                <p class="mb-0">Update customer profile information</p>
            </div>
            <div>
                <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left mr-1"></i> Back to Customers
                </a>
            </div>
        </div>

        <!-- Customer Form -->
        <form action="{{ route('customers.update', $customer->id) }}" method="POST" id="customerForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-body">
                            
                                <!-- Basic Information -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Basic Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Full Name *</label>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                                    placeholder="Enter customer name" value="{{ old('name', $customer->name) }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Customer ID</label>
                                                <input type="text" class="form-control" value="CUS-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}" readonly>
                                                <small class="text-muted">Auto-generated</small>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Phone Number *</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">+92</span>
                                                    </div>
                                                    <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                                        placeholder="300 1234567" value="{{ old('phone', $customer->phone) }}" required>
                                                </div>
                                                @error('phone')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Email Address</label>
                                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                                    placeholder="customer@example.com" value="{{ old('email', $customer->email) }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Branch *</label>
                                                <select name="branch_id" class="form-control select2 @error('branch_id') is-invalid @enderror" required>
                                                    <option value="">Select Branch</option>
                                                    @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}" {{ old('branch_id', $customer->branch_id) == $branch->id ? 'selected' : '' }}>
                                                            {{ $branch->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('branch_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Reference/Source</label>
                                                <input type="text" name="reference" class="form-control" 
                                                    placeholder="How did they hear about us?" value="{{ old('reference', $customer->reference) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Details -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Contact Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Address</label>
                                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                                rows="3" placeholder="Full address including city and area">{{ old('address', $customer->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Business Information -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Business Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Customer Type</label>
                                                <select name="customer_type" class="form-control select2">
                                                    <option value="regular" {{ old('customer_type', $customer->customer_type) == 'regular' ? 'selected' : '' }}>Regular Customer</option>
                                                    <option value="vip" {{ old('customer_type', $customer->customer_type) == 'vip' ? 'selected' : '' }}>VIP Customer</option>
                                                    <option value="corporate" {{ old('customer_type', $customer->customer_type) == 'corporate' ? 'selected' : '' }}>Corporate Customer</option>
                                                    <option value="walk_in" {{ old('customer_type', $customer->customer_type) == 'walk_in' ? 'selected' : '' }}>Walk-in Customer</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Discount Rate (%)</label>
                                                <input type="number" name="discount_rate" class="form-control" 
                                                    min="0" max="50" step="0.01" value="{{ old('discount_rate', $customer->discount_rate) }}">
                                                <small class="text-muted">Special discount for this customer</small>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Occupation</label>
                                                <input type="text" name="occupation" class="form-control" 
                                                    placeholder="e.g., Business, Doctor, Student" value="{{ old('occupation', $customer->occupation) }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Anniversary Date</label>
                                                <input type="date" name="anniversary_date" class="form-control" 
                                                    value="{{ old('anniversary_date', $customer->anniversary_date ? $customer->anniversary_date->format('Y-m-d') : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Measurement Templates -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Measurement Templates</h6>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addMeasurementTemplate()">
                                            <i class="las la-plus"></i> Add Template
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div id="measurementTemplates">
                                            @php $templateIndex = 0; @endphp
                                            @foreach(old('measurement_templates', $customer->measurementTemplates ?? []) as $index => $template)
                                                <div class="template-item mb-3 border p-3 rounded" data-index="{{ $templateIndex }}">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="mb-0">Template #<span class="template-number">{{ $loop->iteration }}</span></h6>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeTemplate(this)">
                                                            <i class="las la-times"></i> Remove
                                                        </button>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Dress Type</label>
                                                            <select name="measurement_templates[{{ $templateIndex }}][dress_type_id]" class="form-control select2">
                                                                <option value="">Select Dress Type</option>
                                                                @foreach($dressTypes as $dressType)
                                                                    <option value="{{ $dressType->id }}" 
                                                                        {{ (isset($template['dress_type_id']) ? $template['dress_type_id'] : ($template['dress_type_id'] ?? '')) == $dressType->id ? 'selected' : '' }}>
                                                                        {{ $dressType->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Template Name</label>
                                                            <input type="text" name="measurement_templates[{{ $templateIndex }}][template_name]" 
                                                                class="form-control" placeholder="e.g., Wedding Sherwani"
                                                                value="{{ old('measurement_templates.' . $templateIndex . '.template_name', $template['template_name'] ?? '') }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 mb-2">
                                                            <label class="form-label">Height (cm)</label>
                                                            <input type="number" name="measurement_templates[{{ $templateIndex }}][measurements][height]" 
                                                                class="form-control" placeholder="Height"
                                                                value="{{ old('measurement_templates.' . $templateIndex . '.measurements.height', $template['measurements']['height'] ?? '') }}">
                                                        </div>
                                                        <div class="col-md-3 mb-2">
                                                            <label class="form-label">Chest (cm)</label>
                                                            <input type="number" name="measurement_templates[{{ $templateIndex }}][measurements][chest]" 
                                                                class="form-control" placeholder="Chest"
                                                                value="{{ old('measurement_templates.' . $templateIndex . '.measurements.chest', $template['measurements']['chest'] ?? '') }}">
                                                        </div>
                                                        <div class="col-md-3 mb-2">
                                                            <label class="form-label">Waist (cm)</label>
                                                            <input type="number" name="measurement_templates[{{ $templateIndex }}][measurements][waist]" 
                                                                class="form-control" placeholder="Waist"
                                                                value="{{ old('measurement_templates.' . $templateIndex . '.measurements.waist', $template['measurements']['waist'] ?? '') }}">
                                                        </div>
                                                        <div class="col-md-3 mb-2">
                                                            <label class="form-label">Hips (cm)</label>
                                                            <input type="number" name="measurement_templates[{{ $templateIndex }}][measurements][hips]" 
                                                                class="form-control" placeholder="Hips"
                                                                value="{{ old('measurement_templates.' . $templateIndex . '.measurements.hips', $template['measurements']['hips'] ?? '') }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Additional Notes</label>
                                                            <textarea name="measurement_templates[{{ $templateIndex }}][notes]" class="form-control" 
                                                                rows="2" placeholder="Any additional notes...">{{ old('measurement_templates.' . $templateIndex . '.notes', $template['notes'] ?? '') }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" 
                                                            name="measurement_templates[{{ $templateIndex }}][is_default]" value="1" 
                                                            id="defaultTemplate{{ $templateIndex }}"
                                                            {{ (old('measurement_templates.' . $templateIndex . '.is_default', $template['is_default'] ?? 0)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="defaultTemplate{{ $templateIndex }}">Set as default template</label>
                                                    </div>
                                                </div>
                                                @php $templateIndex++; @endphp
                                            @endforeach
                                        </div>
                                        <template id="templateForm">
                                            <div class="template-item mb-3 border p-3 rounded" data-index="__INDEX__">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="mb-0">Template #<span class="template-number">1</span></h6>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeTemplate(this)">
                                                        <i class="las la-times"></i> Remove
                                                    </button>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Dress Type</label>
                                                        <select name="measurement_templates[__INDEX__][dress_type_id]" class="form-control select2">
                                                            <option value="">Select Dress Type</option>
                                                            @foreach($dressTypes as $dressType)
                                                                <option value="{{ $dressType->id }}">{{ $dressType->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Template Name</label>
                                                        <input type="text" name="measurement_templates[__INDEX__][template_name]" 
                                                            class="form-control" placeholder="e.g., Wedding Sherwani">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mb-2">
                                                        <label class="form-label">Height (cm)</label>
                                                        <input type="number" name="measurement_templates[__INDEX__][measurements][height]" 
                                                            class="form-control" placeholder="Height">
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <label class="form-label">Chest (cm)</label>
                                                        <input type="number" name="measurement_templates[__INDEX__][measurements][chest]" 
                                                            class="form-control" placeholder="Chest">
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <label class="form-label">Waist (cm)</label>
                                                        <input type="number" name="measurement_templates[__INDEX__][measurements][waist]" 
                                                            class="form-control" placeholder="Waist">
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <label class="form-label">Hips (cm)</label>
                                                        <input type="number" name="measurement_templates[__INDEX__][measurements][hips]" 
                                                            class="form-control" placeholder="Hips">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label">Additional Notes</label>
                                                        <textarea name="measurement_templates[__INDEX__][notes]" class="form-control" 
                                                            rows="2" placeholder="Any additional notes..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" 
                                                        name="measurement_templates[__INDEX__][is_default]" value="1" id="defaultTemplate__INDEX__">
                                                    <label class="form-check-label" for="defaultTemplate__INDEX__">Set as default template</label>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Additional Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Special Notes</label>
                                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                                                rows="3" placeholder="Any special notes about this customer...">{{ old('notes', $customer->notes) }}</textarea>
                                            @error('notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Preferred Communication</label>
                                            @php
                                                $preferredComm = old('preferred_communication', $customer->preferred_communication ? json_decode($customer->preferred_communication, true) : []);
                                            @endphp
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="preferred_communication[]" 
                                                    value="sms" id="smsPreferred" {{ in_array('sms', $preferredComm) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="smsPreferred">SMS</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="preferred_communication[]" 
                                                    value="email" id="emailPreferred" {{ in_array('email', $preferredComm) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="emailPreferred">Email</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="preferred_communication[]" 
                                                    value="whatsapp" id="whatsappPreferred" {{ in_array('whatsapp', $preferredComm) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="whatsappPreferred">WhatsApp</label>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Created At</label>
                                                <input type="text" class="form-control" value="{{ $customer->created_at->format('d M, Y h:i A') }}" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Last Updated</label>
                                                <input type="text" class="form-control" value="{{ $customer->updated_at->format('d M, Y h:i A') }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-outline-secondary">
                                        <i class="las la-times"></i> Cancel
                                    </a>
                                    <div>
                                        <button type="button" class="btn btn-outline-danger mr-2" onclick="confirmDelete()">
                                            <i class="las la-trash"></i> Delete Customer
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="las la-check-circle"></i> Update Customer
                                        </button>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Customer Photo -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Customer Photo</h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="avatar-upload mb-3">
                                <div class="avatar-preview mb-3">
                                    <div id="imagePreview" style="width: 150px; height: 150px; margin: 0 auto; border-radius: 50%; background-color: #f8f9fa; border: 2px solid #dee2e6; display: flex; align-items: center; justify-content: center;">
                                        @if($customer->profile_photo)
                                            <img src="{{ asset('backend/' . $customer->profile_photo) }}" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="las la-user fa-3x text-primary"></i>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="profile_photo" class="custom-file-input" id="customerPhoto" 
                                            accept="image/*" onchange="previewImage(this)">
                                        <label class="custom-file-label" for="customerPhoto">Change photo</label>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-2">Max size: 2MB, Formats: JPG, PNG, GIF</small>
                                @if($customer->profile_photo)
                                    <div class="form-check mt-2">
                                        <input type="checkbox" class="form-check-input" name="remove_profile_photo" value="1" id="removePhoto">
                                        <label class="form-check-label text-danger" for="removePhoto">Remove current photo</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Customer Statistics</h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Total Orders</span>
                                    <span class="badge badge-primary">{{ $customer->orders()->count() }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Total Spent</span>
                                    <span class="badge badge-success">Rs {{ number_format($customer->orders()->sum('final_amount'), 2) }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Last Order</span>
                                    <span class="badge badge-info">
                                        @if($customer->orders()->exists())
                                            {{ $customer->orders()->latest()->first()->order_date->format('d M') }}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>Member Since</span>
                                    <span class="badge badge-warning">{{ $customer->created_at->format('d M, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="card shadow">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-outline-primary btn-block text-left">
                                    <i class="las la-eye mr-2"></i> View Profile
                                </a>
                                <a href="{{ route('orders.create') }}?customer={{ $customer->id }}" class="btn btn-outline-success btn-block text-left">
                                    <i class="las la-plus-circle mr-2"></i> Create New Order
                                </a>
                                <a href="{{ route('orders.index') }}?customer_id={{ $customer->id }}" class="btn btn-outline-info btn-block text-left">
                                    <i class="las la-file-alt mr-2"></i> View All Orders
                                </a>
                                <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary btn-block text-left">
                                    <i class="las la-list mr-2"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
        <!-- Delete Form -->
        <form id="deleteForm" action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </div>

    @push('js')
    <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/select2/js/select2.min.js') }}"></script>

    <!-- Table Treeview JavaScript -->
    <script src="{{ asset('backend/assets/js/table-treeview.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('backend/assets/js/customizer.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('backend/assets/js/chart-custom.js') }}"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <script>
        let templateIndex = {{ $templateIndex ?? 0 }};
        
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
            
            // Form submission validation
            $('#customerForm').submit(function(e) {
                e.preventDefault();
                
                // Form validation
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
                
                if (valid) {
                    this.submit();
                } else {
                    alert('Please fill in all required fields.');
                }
            });
            
            // If no templates exist, add one
            if ($('.template-item').length === 0) {
                addMeasurementTemplate();
            }
        });
        
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        function addMeasurementTemplate() {
            const template = document.getElementById('templateForm').innerHTML;
            const newTemplate = template.replace(/__INDEX__/g, templateIndex);
            
            const div = document.createElement('div');
            div.innerHTML = newTemplate;
            div.querySelector('.template-number').textContent = $('.template-item').length + 1;
            
            document.getElementById('measurementTemplates').appendChild(div.firstElementChild);
            
            // Initialize Select2 for new template
            $(div).find('.select2').select2({
                theme: 'bootstrap'
            });
            
            templateIndex++;
        }
        
        function removeTemplate(button) {
            if ($('.template-item').length > 1) {
                $(button).closest('.template-item').remove();
                updateTemplateNumbers();
            } else {
                alert('At least one measurement template is required.');
            }
        }
        
        function updateTemplateNumbers() {
            $('.template-item').each(function(index) {
                $(this).find('.template-number').text(index + 1);
            });
        }
        
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this customer? This action cannot be undone and will delete all associated orders and data.')) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
    
    <style>
        .avatar-upload {
            position: relative;
        }
        .avatar-preview {
            position: relative;
        }
        .template-item {
            position: relative;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .custom-file-label.selected::after {
            content: "" !important;
        }
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
        .badge {
            font-size: 0.75em;
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
        .list-group-item {
            border: none;
            padding: 0.75rem 0;
        }
        .d-grid.gap-2 {
            gap: 0.5rem !important;
        }
    </style>

    @endpush
</x-app-layout>