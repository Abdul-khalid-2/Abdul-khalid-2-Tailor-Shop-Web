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
                <h4 class="mb-3">Add New Fabric</h4>
                <p class="mb-0">Add new fabric to your inventory</p>
            </div>
            <div>
                <a href="{{ route('fabrics.index') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left mr-1"></i> Back to Inventory
                </a>
            </div>
        </div>

        <!-- Fabric Form -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-body">
                        <form id="fabricForm">
                            <!-- Basic Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Fabric Details</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Fabric Name *</label>
                                            <input type="text" class="form-control" placeholder="e.g., Pure Silk, Egyptian Cotton" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Fabric Code</label>
                                            <input type="text" class="form-control" value="FB-{{ str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT) }}" readonly>
                                            <small class="text-muted">Auto-generated</small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Fabric Type *</label>
                                            <select class="form-control select2" id="fabricType" required>
                                                <option value="">Select Type</option>
                                                <option value="silk">Silk</option>
                                                <option value="cotton">Cotton</option>
                                                <option value="linen">Linen</option>
                                                <option value="wool">Wool</option>
                                                <option value="polyester">Polyester</option>
                                                <option value="georgette">Georgette</option>
                                                <option value="chiffon">Chiffon</option>
                                                <option value="velvet">Velvet</option>
                                                <option value="satin">Satin</option>
                                                <option value="denim">Denim</option>
                                                <option value="jersey">Jersey</option>
                                                <option value="organza">Organza</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Color *</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="e.g., Navy Blue" required>
                                                <div class="input-group-append">
                                                    <input type="color" class="form-control" style="width: 50px; padding: 5px;" value="#3B82F6" title="Pick color">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Pattern/Design</label>
                                            <select class="form-control">
                                                <option value="">Select Pattern</option>
                                                <option value="solid">Solid</option>
                                                <option value="striped">Striped</option>
                                                <option value="checked">Checked</option>
                                                <option value="printed">Printed</option>
                                                <option value="embroidered">Embroidered</option>
                                                <option value="floral">Floral</option>
                                                <option value="geometric">Geometric</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Weight (GSM)</label>
                                            <input type="number" class="form-control" placeholder="e.g., 120 (grams per square meter)">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" rows="3" placeholder="Description of fabric quality, texture, features..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Stock & Pricing -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Stock & Pricing</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Initial Stock (m) *</label>
                                            <input type="number" class="form-control" min="0.1" step="0.1" value="10" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Minimum Stock Level (m)</label>
                                            <input type="number" class="form-control" min="1" value="5">
                                            <small class="text-muted">Low stock alert will trigger below this level</small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Purchase Rate/m (Rs) *</label>
                                            <input type="number" class="form-control" min="1" id="purchaseRate" required>
                                            <small class="text-muted">Cost price per meter</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Selling Rate/m (Rs) *</label>
                                            <input type="number" class="form-control" min="1" id="sellingRate" required>
                                            <small class="text-muted">Selling price per meter</small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Profit Margin (%)</label>
                                            <input type="number" class="form-control" id="profitMargin" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Total Value (Rs)</label>
                                            <input type="number" class="form-control" id="totalValue" readonly>
                                            <small class="text-muted">Stock × Purchase Rate</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Supplier Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Supplier Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Supplier *</label>
                                            <select class="form-control select2" id="supplier" required>
                                                <option value="">Select Supplier</option>
                                                <option value="1">Textile Wholesalers</option>
                                                <option value="2">Fabric House</option>
                                                <option value="3">Direct Mill</option>
                                                <option value="4">Local Market</option>
                                                <option value="5">International Import</option>
                                            </select>
                                            <small class="text-muted">Or <a href="#" onclick="addSupplier()">add new supplier</a></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Supplier Reference</label>
                                            <input type="text" class="form-control" placeholder="Supplier item code or reference">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Purchase Date</label>
                                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Invoice Number</label>
                                            <input type="text" class="form-control" placeholder="Purchase invoice number">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Supplier Notes</label>
                                        <textarea class="form-control" rows="2" placeholder="Any notes about this supplier..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Fabric Properties -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Fabric Properties</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Width (inches)</label>
                                            <input type="number" class="form-control" placeholder="e.g., 45">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Shrinkage (%)</label>
                                            <input type="number" class="form-control" min="0" max="20" placeholder="e.g., 3">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Wash Care</label>
                                            <select class="form-control">
                                                <option value="">Select Care</option>
                                                <option value="dry_clean">Dry Clean Only</option>
                                                <option value="hand_wash">Hand Wash</option>
                                                <option value="machine_wash">Machine Wash</option>
                                                <option value="do_not_wash">Do Not Wash</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Suitable For</label>
                                        <select class="form-control select2" multiple="multiple">
                                            <option value="sherwani">Sherwani</option>
                                            <option value="suit">Suit</option>
                                            <option value="kurta">Kurta</option>
                                            <option value="gown">Gown</option>
                                            <option value="lehenga">Lehenga</option>
                                            <option value="blouse">Blouse</option>
                                            <option value="abaya">Abaya</option>
                                            <option value="formal_wear">Formal Wear</option>
                                            <option value="casual_wear">Casual Wear</option>
                                        </select>
                                        <small class="text-muted">Select dress types this fabric is suitable for</small>
                                    </div>

                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="premiumQuality">
                                        <label class="form-check-label" for="premiumQuality">Premium Quality Fabric</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="imported">
                                        <label class="form-check-label" for="imported">Imported Fabric</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="ecoFriendly">
                                        <label class="form-check-label" for="ecoFriendly">Eco-Friendly / Organic</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Additional Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Storage Location</label>
                                            <input type="text" class="form-control" placeholder="e.g., Rack A-3, Shelf 2">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-control">
                                                <option value="active" selected>Active</option>
                                                <option value="inactive">Inactive</option>
                                                <option value="discontinued">Discontinued</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Notes</label>
                                        <textarea class="form-control" rows="3" placeholder="Any additional notes about this fabric..."></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Fabric Images</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="fabricImages" accept="image/*" multiple>
                                            <label class="custom-file-label" for="fabricImages">Choose images</label>
                                        </div>
                                        <small class="text-muted">Upload images showing fabric texture, color, and pattern</small>
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
                                        <i class="las la-plus-circle"></i> Add to Inventory
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Fabric Preview -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Fabric Preview</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="fabric-preview mb-3">
                            <div id="fabricPreview" style="width: 100%; height: 150px; background: linear-gradient(45deg, #3B82F6 25%, #1D4ED8 25%, #1D4ED8 50%, #3B82F6 50%, #3B82F6 75%, #1D4ED8 75%, #1D4ED8 100%); background-size: 20px 20px; border-radius: 8px; border: 2px solid #e5e7eb;"></div>
                        </div>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="text-primary">Type</div>
                                <div id="previewType" class="font-weight-bold">-</div>
                            </div>
                            <div class="col-6">
                                <div class="text-success">Color</div>
                                <div id="previewColor" class="font-weight-bold">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Inventory Statistics</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Total Fabrics</span>
                                <span class="badge badge-primary">28</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Total Stock Value</span>
                                <span class="badge badge-success">Rs 245,800</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Low Stock Items</span>
                                <span class="badge badge-warning">8</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>This Month Usage</span>
                                <span class="badge badge-info">245 m</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card shadow">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('fabrics.index') }}" class="btn btn-outline-primary btn-block text-left">
                                <i class="las la-list mr-2"></i> View All Fabrics
                            </a>
                            <a href="#" class="btn btn-outline-success btn-block text-left" onclick="quickReorder()">
                                <i class="las la-shopping-cart mr-2"></i> Quick Reorder
                            </a>
                            <a href="#" class="btn btn-outline-info btn-block text-left" onclick="viewLowStock()">
                                <i class="las la-exclamation-triangle mr-2"></i> Low Stock Alert
                            </a>
                            <a href="#" class="btn btn-outline-warning btn-block text-left" onclick="generateReport()">
                                <i class="las la-chart-bar mr-2"></i> Generate Report
                            </a>
                        </div>
                    </div>
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

            // File input label
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

            // Update fabric preview
            $('#fabricType, input[type="color"], input[placeholder="e.g., Navy Blue"]').on('change input', function() {
                updateFabricPreview();
            });

            // Calculate profit margin and total value
            $('#purchaseRate, #sellingRate, input[placeholder="Initial Stock (m)"]').on('input', function() {
                calculatePricing();
            });

            // Form submission
            $('#fabricForm').submit(function(e) {
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

                // Simulate form submission
                alert('Fabric added to inventory successfully!');
                window.location.href = "{{ route('fabrics.index') }}";
            });

            // Initialize calculations and preview
            updateFabricPreview();
            calculatePricing();
        });

        function updateFabricPreview() {
            const type = $('#fabricType').val() || '-';
            const color = $('input[placeholder="e.g., Navy Blue"]').val() || '-';
            const colorPicker = $('input[type="color"]').val();

            $('#previewType').text(type.charAt(0).toUpperCase() + type.slice(1));
            $('#previewColor').text(color);

            // Update preview background with selected color
            if (colorPicker) {
                $('#fabricPreview').css('background', colorPicker);
            }
        }

        function calculatePricing() {
            const purchaseRate = parseFloat($('#purchaseRate').val()) || 0;
            const sellingRate = parseFloat($('#sellingRate').val()) || 0;
            const stock = parseFloat($('input[placeholder="Initial Stock (m)"]').val()) || 0;

            // Calculate profit margin
            let profitMargin = 0;
            if (purchaseRate > 0) {
                profitMargin = ((sellingRate - purchaseRate) / purchaseRate) * 100;
            }

            // Calculate total value
            const totalValue = stock * purchaseRate;

            $('#profitMargin').val(profitMargin.toFixed(2));
            $('#totalValue').val(totalValue.toFixed(2));
        }

        function addSupplier() {
            alert('Opening add supplier form...');
            // In real app: Open supplier modal
        }

        function resetForm() {
            if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
                document.getElementById('fabricForm').reset();
                $('.custom-file-label').removeClass('selected').html('Choose images');
                $('.select2').val(null).trigger('change');
                $('input[type="color"]').val('#3B82F6');
                updateFabricPreview();
                calculatePricing();
            }
        }

        function saveAsDraft() {
            alert('Fabric saved as draft!');
            // In real app: AJAX call to save as draft
        }

        function quickReorder() {
            alert('Opening quick reorder tool...');
        }

        function viewLowStock() {
            alert('Showing low stock items...');
        }

        function generateReport() {
            alert('Generating inventory report...');
        }
    </script>

    <style>
        .fabric-preview {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px;
            background: #f9fafb;
        }

        input[type="color"] {
            cursor: pointer;
            border: none;
            padding: 0;
            height: 38px;
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

        .select2-container--bootstrap .select2-selection {
            border-radius: 0.375rem;
        }
    </style>
    @endpush
</x-app-layout>