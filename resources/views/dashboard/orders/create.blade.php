<x-app-layout>

    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
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
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-body">
                        <form id="orderForm">
                            <!-- Customer & Basic Info -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Customer *</label>
                                    <select class="form-control" required>
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

                            <!-- Order Details -->
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Dress Type *</label>
                                    <select class="form-control" required>
                                        <option value="">Select Dress Type</option>
                                        <option value="1">Sherwani</option>
                                        <option value="2">Suit</option>
                                        <option value="3">Kurta</option>
                                        <option value="4">Shalwar Kameez</option>
                                        <option value="5">Gown</option>
                                        <option value="6">Lehenga</option>
                                        <option value="7">Blouse</option>
                                        <option value="8">Abaya</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Delivery Date *</label>
                                    <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                                </div>
                            </div>

                            <!-- Measurement Section -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Measurements (in cm)</h6>
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
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#measurementModal">
                                        <i class="las la-ruler"></i> Use Measurement Template
                                    </button>
                                </div>
                            </div>

                            <!-- Fabric Details -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Fabric Details</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Fabric Type</label>
                                            <select class="form-control">
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
                                            <input type="text" class="form-control" placeholder="e.g., Navy Blue">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Meter Required</label>
                                            <input type="number" step="0.01" class="form-control" placeholder="3.5">
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#fabricModal">
                                        <i class="las la-layer-group"></i> Select from Inventory
                                    </button>
                                </div>
                            </div>

                            <!-- Pricing & Payment -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Pricing & Payment</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Base Price (Rs)</label>
                                            <input type="number" class="form-control" value="5000" readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Fabric Cost (Rs)</label>
                                            <input type="number" class="form-control" value="1500">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Stitching Charges (Rs)</label>
                                            <input type="number" class="form-control" value="1000">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Additional Charges (Rs)</label>
                                            <input type="number" class="form-control" value="0">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Discount (Rs)</label>
                                            <input type="number" class="form-control" value="0">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Total Amount (Rs)</label>
                                            <input type="number" class="form-control" value="7500" readonly class="font-weight-bold">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Advance Paid (Rs)</label>
                                            <input type="number" class="form-control" value="3000">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Payment Method</label>
                                            <select class="form-control">
                                                <option value="cash">Cash</option>
                                                <option value="card">Credit Card</option>
                                                <option value="bank">Bank Transfer</option>
                                                <option value="mobile">Mobile Payment</option>
                                            </select>
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
                                            <select class="form-control">
                                                <option value="">Select Tailor</option>
                                                <option value="1">Tailor Ali (Sherwani Specialist)</option>
                                                <option value="2">Tailor Ahmed (Suit Expert)</option>
                                                <option value="3">Tailor Fatima (Ladies Wear)</option>
                                                <option value="4">Tailor Raza (Traditional Wear)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Expected Completion</label>
                                            <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime('+5 days')) }}">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Special Instructions</label>
                                        <textarea class="form-control" rows="2" placeholder="Any special instructions for tailor..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="mb-4">
                                <label class="form-label">Order Notes (Internal)</label>
                                <textarea class="form-control" rows="3" placeholder="Internal notes about this order..."></textarea>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                    <i class="las la-redo-alt"></i> Reset
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
                        <table class="table table-sm">
                            <thead>
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
                                    <td><button class="btn btn-sm btn-outline-primary">Apply</button></td>
                                </tr>
                                <tr>
                                    <td>Ahmed Raza - Suit</td>
                                    <td>175 cm</td>
                                    <td>44 cm</td>
                                    <td>40 cm</td>
                                    <td>46 cm</td>
                                    <td><button class="btn btn-sm btn-outline-primary">Apply</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                        <table class="table table-sm">
                            <thead>
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
                                    <td>Navy Blue</td>
                                    <td>25.5</td>
                                    <td>800</td>
                                    <td><button class="btn btn-sm btn-outline-primary">Select</button></td>
                                </tr>
                                <tr>
                                    <td>Cotton</td>
                                    <td>White</td>
                                    <td>45.0</td>
                                    <td>300</td>
                                    <td><button class="btn btn-sm btn-outline-primary">Select</button></td>
                                </tr>
                                <tr>
                                    <td>Linen</td>
                                    <td>Beige</td>
                                    <td>18.5</td>
                                    <td>600</td>
                                    <td><button class="btn btn-sm btn-outline-primary">Select</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')

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
        // Form handling
        $('#orderForm').submit(function(e) {
            e.preventDefault();
            alert('Order created successfully!');
            window.location.href = "{{ route('orders.index') }}";
        });
        
        function resetForm() {
            if (confirm('Reset all form fields?')) {
                document.getElementById('orderForm').reset();
            }
        }
        
        function saveAsDraft() {
            alert('Order saved as draft!');
        }
        
        // Auto-calculate total
        $('input[type="number"]').on('input', function() {
            calculateTotal();
        });
        
        function calculateTotal() {
            const basePrice = parseFloat($('input[placeholder="Base Price (Rs)"]').val()) || 0;
            const fabricCost = parseFloat($('input[placeholder="Fabric Cost (Rs)"]').val()) || 0;
            const stitching = parseFloat($('input[placeholder="Stitching Charges (Rs)"]').val()) || 0;
            const additional = parseFloat($('input[placeholder="Additional Charges (Rs)"]').val()) || 0;
            const discount = parseFloat($('input[placeholder="Discount (Rs)"]').val()) || 0;
            
            const total = basePrice + fabricCost + stitching + additional - discount;
            $('input[placeholder="Total Amount (Rs)"]').val(total.toFixed(2));
        }
        
        // Initialize calculations
        calculateTotal();
    </script>
    @endpush
</x-app-layout>