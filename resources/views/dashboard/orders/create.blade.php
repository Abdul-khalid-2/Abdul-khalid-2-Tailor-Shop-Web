<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/select2/css/select2.min.css') }}">
    @endpush>

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
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-body">
                        <form id="orderForm">
                            <!-- Customer & Basic Info -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Customer & Order Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Customer *</label>
                                            <select class="form-control select2" id="customerSelect" required>
                                                <option value="">Select Customer</option>
                                                <option value="1">Mohammed Ali (0300-1234567)</option>
                                                <option value="2">Fatima Khan (0300-7654321)</option>
                                                <option value="3">Ahmed Raza (0312-9876543)</option>
                                                <option value="4">Sara Ahmed (0333-4567890)</option>
                                            </select>
                                            <small class="text-muted">Or <a href="{{ route('customers.create') }}">add new customer</a></small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Order Date *</label>
                                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Dress Type *</label>
                                            <select class="form-control select2" id="dressType" required>
                                                <option value="">Select Dress Type</option>
                                                <option value="sherwani" data-price="12000">Sherwani</option>
                                                <option value="suit" data-price="8000">Suit</option>
                                                <option value="kurta" data-price="3500">Kurta</option>
                                                <option value="shalwar_kameez" data-price="4500">Shalwar Kameez</option>
                                                <option value="gown" data-price="15000">Gown</option>
                                                <option value="lehenga" data-price="18000">Lehenga</option>
                                                <option value="blouse" data-price="2500">Blouse</option>
                                                <option value="abaya" data-price="5500">Abaya</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Delivery Date *</label>
                                            <input type="date" class="form-control" id="deliveryDate" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Order Description</label>
                                        <textarea class="form-control" rows="2" placeholder="Brief description of the order..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Measurement Section -->
                            <div class="card mb-4">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Measurements (in cm)</h6>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#measurementModal">
                                        <i class="las la-ruler mr-1"></i> Use Template
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Height</label>
                                            <input type="number" step="0.1" class="form-control" placeholder="170">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Chest</label>
                                            <input type="number" step="0.1" class="form-control" placeholder="42">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Waist</label>
                                            <input type="number" step="0.1" class="form-control" placeholder="38">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Hips</label>
                                            <input type="number" step="0.1" class="form-control" placeholder="44">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Shoulder</label>
                                            <input type="number" step="0.1" class="form-control" placeholder="18">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Sleeve Length</label>
                                            <input type="number" step="0.1" class="form-control" placeholder="60">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Pant Length</label>
                                            <input type="number" step="0.1" class="form-control" placeholder="100">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Inseam</label>
                                            <input type="number" step="0.1" class="form-control" placeholder="80">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Additional Notes</label>
                                        <textarea class="form-control" rows="2" placeholder="Any special instructions or preferences..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Fabric Details -->
                            <div class="card mb-4">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Fabric Details</h6>
                                    <button type="button" class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#fabricModal">
                                        <i class="las la-layer-group mr-1"></i> Select from Inventory
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Fabric Type</label>
                                            <select class="form-control select2" id="fabricSelect">
                                                <option value="">Select Fabric</option>
                                                <option value="silk">Silk</option>
                                                <option value="cotton">Cotton</option>
                                                <option value="linen">Linen</option>
                                                <option value="wool">Wool</option>
                                                <option value="polyester">Polyester</option>
                                                <option value="georgette">Georgette</option>
                                                <option value="chiffon">Chiffon</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Color</label>
                                            <input type="text" class="form-control" id="fabricColor" placeholder="e.g., Navy Blue">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Meter Required</label>
                                            <input type="number" step="0.01" class="form-control" id="meterRequired" placeholder="3.5" value="0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Fabric Rate/m (Rs)</label>
                                            <input type="number" class="form-control" id="fabricRate" value="0">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Fabric Cost (Rs)</label>
                                            <input type="number" class="form-control" id="fabricCost" value="0" readonly>
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
                                            <label class="form-label">Base Price (Rs)</label>
                                            <input type="number" class="form-control" id="basePrice" value="0" readonly>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Stitching Charges (Rs)</label>
                                            <input type="number" class="form-control" id="stitchingCharges" value="1000">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Additional Charges (Rs)</label>
                                            <input type="number" class="form-control" id="additionalCharges" value="0">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Discount (Rs)</label>
                                            <input type="number" class="form-control" id="discount" value="0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Total Amount (Rs)</label>
                                            <input type="number" class="form-control font-weight-bold" id="totalAmount" value="0" readonly style="font-size: 1.2rem;">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Advance Paid (Rs)</label>
                                            <input type="number" class="form-control" id="advancePaid" value="0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Payment Method</label>
                                            <select class="form-control" id="paymentMethod">
                                                <option value="cash">Cash</option>
                                                <option value="card">Credit Card</option>
                                                <option value="bank">Bank Transfer</option>
                                                <option value="mobile">Mobile Payment</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Balance Due (Rs)</label>
                                            <input type="number" class="form-control font-weight-bold text-danger" id="balanceDue" value="0" readonly>
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
                                            <select class="form-control select2" id="tailorSelect">
                                                <option value="">Select Tailor</option>
                                                <option value="1">Tailor Ali (Sherwani Specialist)</option>
                                                <option value="2">Tailor Ahmed (Suit Expert)</option>
                                                <option value="3">Tailor Fatima (Ladies Wear)</option>
                                                <option value="4">Tailor Raza (Traditional Wear)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Expected Completion</label>
                                            <input type="date" class="form-control" id="expectedCompletion" value="{{ date('Y-m-d', strtotime('+5 days')) }}">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Special Instructions</label>
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
                                        <label class="form-label">Order Notes (Internal)</label>
                                        <textarea class="form-control" rows="3" placeholder="Internal notes about this order..."></textarea>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="urgentOrder">
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Template Name</th>
                                    <th>Height</th>
                                    <th>Chest</th>
                                    <th>Waist</th>
                                    <th>Hips</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Mohammed Ali - Sherwani</td>
                                    <td>170 cm</td>
                                    <td>42 cm</td>
                                    <td>38 cm</td>
                                    <td>44 cm</td>
                                    <td><button class="btn btn-sm btn-outline-primary" onclick="applyTemplate(170, 42, 38, 44, 18, 60, 100, 80)">Apply</button></td>
                                </tr>
                                <tr>
                                    <td>Ahmed Raza - Suit</td>
                                    <td>175 cm</td>
                                    <td>44 cm</td>
                                    <td>40 cm</td>
                                    <td>46 cm</td>
                                    <td><button class="btn btn-sm btn-outline-primary" onclick="applyTemplate(175, 44, 40, 46, 19, 62, 102, 82)">Apply</button></td>
                                </tr>
                                <tr>
                                    <td>Fatima Khan - Gown</td>
                                    <td>165 cm</td>
                                    <td>38 cm</td>
                                    <td>34 cm</td>
                                    <td>42 cm</td>
                                    <td><button class="btn btn-sm btn-outline-primary" onclick="applyTemplate(165, 38, 34, 42, 16, 58, 95, 75)">Apply</button></td>
                                </tr>
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
                                    <th>Fabric Type</th>
                                    <th>Color</th>
                                    <th>Available (m)</th>
                                    <th>Rate/m (Rs)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Silk</td>
                                    <td><span class="badge" style="background-color: #1D4ED8; color: white;">Navy Blue</span></td>
                                    <td>25.5</td>
                                    <td>800</td>
                                    <td><button class="btn btn-sm btn-outline-primary" onclick="selectFabric('Silk', 'Navy Blue', 800)">Select</button></td>
                                </tr>
                                <tr>
                                    <td>Cotton</td>
                                    <td><span class="badge" style="background-color: #ffffff; color: #000; border: 1px solid #ddd;">White</span></td>
                                    <td>45.0</td>
                                    <td>300</td>
                                    <td><button class="btn btn-sm btn-outline-primary" onclick="selectFabric('Cotton', 'White', 300)">Select</button></td>
                                </tr>
                                <tr>
                                    <td>Linen</td>
                                    <td><span class="badge" style="background-color: #FDE68A; color: #000;">Beige</span></td>
                                    <td>18.5</td>
                                    <td>600</td>
                                    <td><button class="btn btn-sm btn-outline-primary" onclick="selectFabric('Linen', 'Beige', 600)">Select</button></td>
                                </tr>
                                <tr>
                                    <td>Georgette</td>
                                    <td><span class="badge" style="background-color: #EC4899; color: white;">Pink</span></td>
                                    <td>15.2</td>
                                    <td>550</td>
                                    <td><button class="btn btn-sm btn-outline-primary" onclick="selectFabric('Georgette', 'Pink', 550)">Select</button></td>
                                </tr>
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
            $('#dressType').change(function() {
                const selectedOption = $(this).find('option:selected');
                const basePrice = selectedOption.data('price') || 0;
                $('#basePrice').val(basePrice);
                calculateTotal();
            });

            // Calculate fabric cost
            $('#meterRequired, #fabricRate').on('input', function() {
                const meter = parseFloat($('#meterRequired').val()) || 0;
                const rate = parseFloat($('#fabricRate').val()) || 0;
                const fabricCost = meter * rate;
                $('#fabricCost').val(fabricCost.toFixed(2));
                calculateTotal();
            });

            // Calculate total amount
            $('#stitchingCharges, #additionalCharges, #discount').on('input', calculateTotal);
            $('#advancePaid').on('input', calculateBalance);

            // Form submission
            $('#orderForm').submit(function(e) {
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

                if (!valid) {
                    alert('Please fill in all required fields.');
                    return;
                }

                // Check if total amount is valid
                const totalAmount = parseFloat($('#totalAmount').val()) || 0;
                if (totalAmount <= 0) {
                    alert('Please check pricing. Total amount should be greater than 0.');
                    return;
                }

                // Simulate form submission
                alert('Order created successfully! Order #: TS-' + Math.floor(1000 + Math.random() * 9000));
                window.location.href = "{{ route('orders.index') }}";
            });

            // Initialize calculations
            calculateTotal();
            calculateBalance();
        });

        function calculateTotal() {
            const basePrice = parseFloat($('#basePrice').val()) || 0;
            const fabricCost = parseFloat($('#fabricCost').val()) || 0;
            const stitching = parseFloat($('#stitchingCharges').val()) || 0;
            const additional = parseFloat($('#additionalCharges').val()) || 0;
            const discount = parseFloat($('#discount').val()) || 0;

            const total = basePrice + fabricCost + stitching + additional - discount;
            $('#totalAmount').val(total.toFixed(2));
            calculateBalance();
        }

        function calculateBalance() {
            const totalAmount = parseFloat($('#totalAmount').val()) || 0;
            const advancePaid = parseFloat($('#advancePaid').val()) || 0;
            const balance = totalAmount - advancePaid;
            $('#balanceDue').val(balance.toFixed(2));
        }

        function applyTemplate(height, chest, waist, hips, shoulder, sleeve, pant, inseam) {
            $('input[placeholder="170"]').val(height);
            $('input[placeholder="42"]').val(chest);
            $('input[placeholder="38"]').val(waist);
            $('input[placeholder="44"]').val(hips);
            $('input[placeholder="18"]').val(shoulder);
            $('input[placeholder="60"]').val(sleeve);
            $('input[placeholder="100"]').val(pant);
            $('input[placeholder="80"]').val(inseam);

            $('#measurementModal').modal('hide');
            alert('Measurement template applied successfully!');
        }

        function selectFabric(type, color, rate) {
            $('#fabricSelect').val(type.toLowerCase()).trigger('change');
            $('#fabricColor').val(color);
            $('#fabricRate').val(rate);
            $('#fabricModal').modal('hide');

            // Suggest meter requirement based on dress type
            const dressType = $('#dressType').val();
            let suggestedMeters = 0;

            if (dressType === 'sherwani' || dressType === 'gown') {
                suggestedMeters = 5.5;
            } else if (dressType === 'suit') {
                suggestedMeters = 4.0;
            } else if (dressType === 'kurta' || dressType === 'shalwar_kameez') {
                suggestedMeters = 3.5;
            } else if (dressType === 'lehenga') {
                suggestedMeters = 6.0;
            } else {
                suggestedMeters = 2.5;
            }

            $('#meterRequired').val(suggestedMeters);

            // Calculate fabric cost
            const fabricCost = suggestedMeters * rate;
            $('#fabricCost').val(fabricCost.toFixed(2));
            calculateTotal();

            alert('Fabric selected: ' + type + ' (' + color + ')');
        }

        function resetForm() {
            if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
                document.getElementById('orderForm').reset();
                $('.select2').val(null).trigger('change');
                $('#basePrice').val(0);
                $('#fabricCost').val(0);
                $('#totalAmount').val(0);
                $('#balanceDue').val(0);
                alert('Form reset successfully!');
            }
        }

        function saveAsDraft() {
            alert('Order saved as draft!');
            // In real app: AJAX call to save as draft
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

        #totalAmount {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #28a745;
        }

        #balanceDue {
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
    </style>
    @endpush
</x-app-layout>