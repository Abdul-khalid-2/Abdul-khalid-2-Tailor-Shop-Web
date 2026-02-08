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
                <h4 class="mb-3">Create New Order</h4>
                <p class="mb-0">Add a new tailoring order for customer</p>
            </div>
            <div>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left mr-1"></i> Back to Orders
                </a>
            </div>
        </div>

        <!-- Order Form -->
        <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- Customer & Basic Info -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Customer & Order Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Customer *</label>
                                            <select class="form-control select2" id="customer_id" name="customer_id" required>
                                                <option value="">Select Customer</option>
                                                @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" 
                                                    data-phone="{{ $customer->phone }}"
                                                    data-address="{{ $customer->address }}"
                                                    data-type="{{ $customer->customer_type }}"
                                                    data-discount="{{ $customer->discount_rate }}">
                                                    {{ $customer->name }} ({{ $customer->phone }})
                                                </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">Or <a href="{{ route('customers.create') }}" target="_blank">add new customer</a></small>
                                            @error('customer_id')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Order Date *</label>
                                            <input type="date" class="form-control" name="order_date" 
                                                   value="{{ old('order_date', date('Y-m-d')) }}" required>
                                            @error('order_date')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Branch *</label>
                                            <select class="form-control select2" name="branch_id" required>
                                                <option value="">Select Branch</option>
                                                @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('branch_id')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Dress Type *</label>
                                            <select class="form-control select2" id="dress_type_id" name="dress_type_id" required>
                                                <option value="">Select Dress Type</option>
                                                @foreach($dressTypes as $dressType)
                                                <option value="{{ $dressType->id }}" 
                                                        data-price="{{ $dressType->base_price }}"
                                                        data-days="{{ $dressType->estimated_days }}">
                                                    {{ $dressType->name }} - Rs {{ number_format($dressType->base_price) }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('dress_type_id')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Delivery Date *</label>
                                            <input type="date" class="form-control" id="delivery_date" name="delivery_date" 
                                                   value="{{ old('delivery_date', date('Y-m-d', strtotime('+7 days'))) }}" required>
                                            @error('delivery_date')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Base Price (Rs) *</label>
                                            <input type="number" step="0.01" class="form-control" id="base_price" 
                                                   name="base_price" value="{{ old('base_price', 0) }}" required readonly>
                                            @error('base_price')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Order Description</label>
                                        <textarea class="form-control" name="notes" rows="2" 
                                                  placeholder="Brief description of the order...">{{ old('notes') }}</textarea>
                                        @error('notes')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Measurement Section -->
                            <div class="card mb-4">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Measurements (in cm)</h6>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="loadTemplatesBtn">
                                        <i class="las la-ruler mr-1"></i> Use Template
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Height</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[height]" 
                                                   placeholder="170" value="{{ old('measurements.height') }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Chest</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[chest]" 
                                                   placeholder="42" value="{{ old('measurements.chest') }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Waist</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[waist]" 
                                                   placeholder="38" value="{{ old('measurements.waist') }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Hips</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[hips]" 
                                                   placeholder="44" value="{{ old('measurements.hips') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Shoulder</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[shoulder]" 
                                                   placeholder="18" value="{{ old('measurements.shoulder') }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Sleeve Length</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[sleeve_length]" 
                                                   placeholder="60" value="{{ old('measurements.sleeve_length') }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Pant Length</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[pant_length]" 
                                                   placeholder="100" value="{{ old('measurements.pant_length') }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Inseam</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[inseam]" 
                                                   placeholder="80" value="{{ old('measurements.inseam') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Fitting Preferences</label>
                                            <textarea class="form-control" name="measurements[fitting_preferences]" rows="2" 
                                                      placeholder="Loose, tight, or any specific preferences...">{{ old('measurements.fitting_preferences') }}</textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Measurement Notes</label>
                                            <textarea class="form-control" name="measurements[notes]" rows="2" 
                                                      placeholder="Additional notes about measurements...">{{ old('measurements.notes') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Fabric Details -->
                            <div class="card mb-4">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Fabric Details</h6>
                                    <button type="button" class="btn btn-sm btn-outline-info" id="selectFabricBtn">
                                        <i class="las la-layer-group mr-1"></i> Select from Inventory
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Fabric Type</label>
                                            <input type="text" class="form-control" id="fabric_type" 
                                                   placeholder="e.g., Silk, Cotton" value="{{ old('fabric_type') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Color</label>
                                            <input type="text" class="form-control" id="fabric_color" 
                                                   placeholder="e.g., Navy Blue" value="{{ old('fabric_color') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Meter Required</label>
                                            <input type="number" step="0.01" class="form-control" id="meter_required" 
                                                   placeholder="3.5" value="{{ old('meter_required', 0) }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Fabric Rate/m (Rs)</label>
                                            <input type="number" step="0.01" class="form-control" id="fabric_rate" 
                                                   value="{{ old('fabric_rate', 0) }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Fabric Cost (Rs)</label>
                                            <input type="number" step="0.01" class="form-control" id="fabric_cost" 
                                                   name="fabric_cost" value="{{ old('fabric_cost', 0) }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing & Payment -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Pricing & Payment</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Stitching Charges (Rs)</label>
                                            <input type="number" step="0.01" class="form-control" id="stitching_charges" 
                                                   name="stitching_charges" value="{{ old('stitching_charges', 0) }}">
                                            @error('stitching_charges')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Additional Charges (Rs)</label>
                                            <input type="number" step="0.01" class="form-control" id="additional_charges" 
                                                   name="additional_charges" value="{{ old('additional_charges', 0) }}">
                                            @error('additional_charges')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Discount (Rs)</label>
                                            <input type="number" step="0.01" class="form-control" id="discount_amount" 
                                                   name="discount_amount" value="{{ old('discount_amount', 0) }}">
                                            @error('discount_amount')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Total Amount (Rs)</label>
                                            <input type="number" step="0.01" class="form-control font-weight-bold" 
                                                   id="total_amount" value="0" readonly style="font-size: 1.2rem;">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Advance Paid (Rs) *</label>
                                            <input type="number" step="0.01" class="form-control" id="advance_amount" 
                                                   name="advance_amount" value="{{ old('advance_amount', 0) }}" required>
                                            @error('advance_amount')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Payment Method</label>
                                            <select class="form-control" name="payment_method_id">
                                                @foreach($paymentMethods as $method)
                                                <option value="{{ $method->id }}" {{ old('payment_method_id', 1) == $method->id ? 'selected' : '' }}>
                                                    {{ $method->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Balance Due (Rs)</label>
                                            <input type="number" step="0.01" class="form-control font-weight-bold text-danger" 
                                                   id="balance_due" value="0" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Remaining Amount</label>
                                            <input type="number" step="0.01" class="form-control" id="remaining_amount" 
                                                   name="remaining_amount" value="{{ old('remaining_amount', 0) }}" readonly>
                                            @error('remaining_amount')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tailor Assignment -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Tailor Assignment</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Assign to Tailor</label>
                                            <select class="form-control select2" id="tailor_id" name="tailor_id">
                                                <option value="">Select Tailor</option>
                                                @foreach($tailors as $tailor)
                                                <option value="{{ $tailor->id }}" {{ old('tailor_id') == $tailor->id ? 'selected' : '' }}>
                                                    {{ $tailor->name }} - {{ ucfirst($tailor->employment_type) }}
                                                    @if($tailor->specializations)
                                                    ({{ json_decode($tailor->specializations)[0] ?? 'General' }})
                                                    @endif
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Expected Completion</label>
                                            <input type="date" class="form-control" id="expected_completion" 
                                                   value="{{ date('Y-m-d', strtotime('+5 days')) }}">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Special Instructions for Tailor</label>
                                        <textarea class="form-control" rows="2" placeholder="Any special instructions for tailor..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Additional Notes</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Internal Notes</label>
                                        <textarea class="form-control" name="internal_notes" rows="3" 
                                                  placeholder="Internal notes about this order...">{{ old('internal_notes') }}</textarea>
                                        @error('internal_notes')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="urgentOrder" name="urgent_order">
                                        <label class="form-check-label text-warning" for="urgentOrder">
                                            <i class="las la-exclamation-circle"></i> Mark as Urgent Order
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                    <i class="las la-redo-alt"></i> Reset Form
                                </button>
                                <div>
                                    <button type="button" class="btn btn-outline-primary mr-2" onclick="saveAsDraft()">
                                        <i class="las la-save"></i> Save as Draft
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="las la-check-circle"></i> Create Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Measurement Template Modal -->
    <div class="modal fade" id="measurementModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Measurement Template</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="templateLoading" class="text-center p-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2">Loading templates...</p>
                    </div>
                    <div id="templateContent" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover" id="templatesTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Template Name</th>
                                        <th>Dress Type</th>
                                        <th>Height</th>
                                        <th>Chest</th>
                                        <th>Waist</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Templates will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="noTemplates" class="text-center p-4" style="display: none;">
                        <i class="las la-ruler-combined fa-3x text-muted mb-3"></i>
                        <p>No measurement templates found for this customer.</p>
                        <p class="text-muted small">Please add measurements manually.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fabric Selection Modal -->
    <div class="modal fade" id="fabricModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Fabric from Inventory</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Fabric Code</th>
                                    <th>Type</th>
                                    <th>Color</th>
                                    <th>Available (m)</th>
                                    <th>Rate/m (Rs)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fabrics as $fabric)
                                <tr>
                                    <td>{{ $fabric->fabric_code }}</td>
                                    <td>{{ $fabric->type }}</td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $this->getColorCode($fabric->color) }}; color: white;">
                                            {{ $fabric->color }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($fabric->stock_meter, 2) }}</td>
                                    <td>{{ number_format($fabric->selling_rate) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" 
                                                onclick="selectFabric('{{ $fabric->type }}', '{{ $fabric->color }}', {{ $fabric->selling_rate }})">
                                            Select
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap'
            });

            // Update base price when dress type changes
            $('#dress_type_id').change(function() {
                const selectedOption = $(this).find('option:selected');
                const basePrice = selectedOption.data('price') || 0;
                const estimatedDays = selectedOption.data('days') || 7;
                
                $('#base_price').val(basePrice);
                
                // Update delivery date based on estimated days
                const orderDate = $('input[name="order_date"]').val();
                if (orderDate) {
                    const deliveryDate = new Date(orderDate);
                    deliveryDate.setDate(deliveryDate.getDate() + parseInt(estimatedDays));
                    const formattedDate = deliveryDate.toISOString().split('T')[0];
                    $('#delivery_date').val(formattedDate);
                }
                
                calculateTotal();
            });

            // Calculate fabric cost
            $('#meter_required, #fabric_rate').on('input', function() {
                const meter = parseFloat($('#meter_required').val()) || 0;
                const rate = parseFloat($('#fabric_rate').val()) || 0;
                const fabricCost = meter * rate;
                $('#fabric_cost').val(fabricCost.toFixed(2));
                calculateTotal();
            });

            // Calculate total amount
            $('#stitching_charges, #additional_charges, #discount_amount, #advance_amount').on('input', calculateTotal);

            // Load measurement templates when customer changes
            $('#customer_id').change(function() {
                const customerId = $(this).val();
                if (customerId) {
                    $('#loadTemplatesBtn').prop('disabled', false);
                } else {
                    $('#loadTemplatesBtn').prop('disabled', true);
                }
            });

            // Load templates button click
            $('#loadTemplatesBtn').click(function() {
                const customerId = $('#customer_id').val();
                const dressTypeId = $('#dress_type_id').val();
                
                if (!customerId) {
                    alert('Please select a customer first.');
                    return;
                }
                
                $('#measurementModal').modal('show');
                loadMeasurementTemplates(customerId, dressTypeId);
            });

            // Select fabric button click
            $('#selectFabricBtn').click(function() {
                $('#fabricModal').modal('show');
            });

            // Form submission
            $('#orderForm').submit(function(e) {
                // Validate form
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
                    return;
                }

                // Check if total amount is valid
                const totalAmount = parseFloat($('#total_amount').val()) || 0;
                if (totalAmount <= 0) {
                    e.preventDefault();
                    alert('Please check pricing. Total amount should be greater than 0.');
                    return;
                }

                // Auto-calculate remaining amount before submission
                calculateTotal();
            });

            // Initialize calculations
            calculateTotal();
        });

        function loadMeasurementTemplates(customerId, dressTypeId) {
            $('#templateLoading').show();
            $('#templateContent').hide();
            $('#noTemplates').hide();
            
            $.ajax({
                url: `/orders/customer/${customerId}/details`,
                type: 'GET',
                success: function(response) {
                    $('#templateLoading').hide();
                    
                    const templates = response.customer.measurement_templates || [];
                    const tableBody = $('#templatesTable tbody');
                    tableBody.empty();
                    
                    if (templates.length > 0) {
                        // Filter by dress type if selected
                        let filteredTemplates = templates;
                        if (dressTypeId) {
                            filteredTemplates = templates.filter(template => 
                                template.dress_type.toLowerCase().includes($('#dress_type_id option:selected').text().toLowerCase())
                            );
                        }
                        
                        if (filteredTemplates.length > 0) {
                            filteredTemplates.forEach(template => {
                                const measurements = template.measurements;
                                const row = `
                                    <tr>
                                        <td>${template.template_name}</td>
                                        <td>${template.dress_type}</td>
                                        <td>${measurements.height || 'N/A'}</td>
                                        <td>${measurements.chest || 'N/A'}</td>
                                        <td>${measurements.waist || 'N/A'}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    onclick="applyTemplate(${JSON.stringify(measurements).replace(/"/g, '&quot;')})">
                                                Apply
                                            </button>
                                        </td>
                                    </tr>
                                `;
                                tableBody.append(row);
                            });
                            $('#templateContent').show();
                        } else {
                            $('#noTemplates').show();
                        }
                    } else {
                        $('#noTemplates').show();
                    }
                },
                error: function() {
                    $('#templateLoading').hide();
                    $('#noTemplates').show();
                }
            });
        }

        function applyTemplate(measurements) {
            // Apply measurements to form fields
            Object.keys(measurements).forEach(key => {
                const input = $(`input[name="measurements[${key}]"], textarea[name="measurements[${key}]"]`);
                if (input.length) {
                    input.val(measurements[key]);
                }
            });
            
            $('#measurementModal').modal('hide');
            alert('Measurement template applied successfully!');
        }

        function selectFabric(type, color, rate) {
            $('#fabric_type').val(type);
            $('#fabric_color').val(color);
            $('#fabric_rate').val(rate);
            $('#fabricModal').modal('hide');

            // Suggest meter requirement based on dress type
            const dressTypeName = $('#dress_type_id option:selected').text().toLowerCase();
            let suggestedMeters = 0;

            if (dressTypeName.includes('sherwani') || dressTypeName.includes('gown')) {
                suggestedMeters = 5.5;
            } else if (dressTypeName.includes('suit')) {
                suggestedMeters = 4.0;
            } else if (dressTypeName.includes('kurta') || dressTypeName.includes('shalwar')) {
                suggestedMeters = 3.5;
            } else if (dressTypeName.includes('lehenga')) {
                suggestedMeters = 6.0;
            } else {
                suggestedMeters = 2.5;
            }

            $('#meter_required').val(suggestedMeters);

            // Calculate fabric cost
            const fabricCost = suggestedMeters * rate;
            $('#fabric_cost').val(fabricCost.toFixed(2));
            calculateTotal();

            alert('Fabric selected: ' + type + ' (' + color + ')');
        }

        function calculateTotal() {
            const basePrice = parseFloat($('#base_price').val()) || 0;
            const fabricCost = parseFloat($('#fabric_cost').val()) || 0;
            const stitching = parseFloat($('#stitching_charges').val()) || 0;
            const additional = parseFloat($('#additional_charges').val()) || 0;
            const discount = parseFloat($('#discount_amount').val()) || 0;

            const total = basePrice + fabricCost + stitching + additional - discount;
            $('#total_amount').val(total.toFixed(2));
            
            // Calculate balance
            const advancePaid = parseFloat($('#advance_amount').val()) || 0;
            const balance = total - advancePaid;
            $('#balance_due').val(balance.toFixed(2));
            $('#remaining_amount').val(balance.toFixed(2));
        }

        function resetForm() {
            if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
                document.getElementById('orderForm').reset();
                $('.select2').val(null).trigger('change');
                $('#base_price').val(0);
                $('#fabric_cost').val(0);
                $('#total_amount').val(0);
                $('#balance_due').val(0);
                $('#remaining_amount').val(0);
                alert('Form reset successfully!');
            }
        }

        function saveAsDraft() {
            // In real app: AJAX call to save as draft
            // For now, just submit the form
            $('#orderForm').append('<input type="hidden" name="save_as_draft" value="1">');
            $('#orderForm').submit();
        }

        // Helper function to get color code
        function getColorCode(colorName) {
            const colors = {
                'navy blue': '#1D4ED8',
                'white': '#FFFFFF',
                'black': '#000000',
                'red': '#EF4444',
                'blue': '#3B82F6',
                'green': '#10B981',
                'yellow': '#F59E0B',
                'pink': '#EC4899',
                'purple': '#8B5CF6',
                'gray': '#6B7280',
                'brown': '#92400E',
                'beige': '#FDE68A',
                'maroon': '#991B1B',
                'orange': '#F97316',
                'gold': '#FBBF24',
                'silver': '#D1D5DB',
            };
            return colors[colorName.toLowerCase()] || '#6B7280';
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

        .modal-content {
            border-radius: 0.5rem;
            border: none;
        }

        .close {
            font-size: 1.5rem;
            font-weight: 300;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #6c757d;
        }

        .badge {
            font-size: 0.75em;
            font-weight: 500;
            padding: 0.35em 0.65em;
        }

        #total_amount {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #28a745;
        }

        #balance_due {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #dc3545;
        }

        .form-check-input:checked {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .select2-container--bootstrap .select2-selection {
            border-radius: 0.375rem;
        }
        
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>
    @endpush
</x-app-layout>