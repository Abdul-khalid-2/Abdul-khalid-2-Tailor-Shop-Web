<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/datatables/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/select2/css/select2.min.css') }}">
    @endpush

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-3">Fabric Inventory Management</h4>
                <p class="mb-0">Manage fabric stock, orders, and inventory</p>
            </div>
            <div>
                <a href="{{ route('fabrics.create') }}" class="btn btn-primary">
                    <i class="las la-plus-circle mr-1"></i> Add Fabric
                </a>
            </div>
        </div>

        <!-- Fabric Stats -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Stock Value</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">₹ 245,800</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2">1825 m</span>
                                    <span>in stock</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-rupee-sign fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Available Fabrics</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">28</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2">15 types</span>
                                    <span>in stock</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-layer-group fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Low Stock Alert</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-danger mr-2"><i class="las la-exclamation-circle"></i> </span>
                                    <span>needs reorder</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-exclamation-triangle fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    This Month Usage</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">245 m</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-info mr-2">≈ ₹ 85,400</span>
                                    <span>worth</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-chart-line fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Bar -->
        <div class="card shadow mb-4">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search fabrics..." id="fabricSearch">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="las la-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-end flex-wrap">
                            <div class="mr-3 mb-2">
                                <select class="form-control form-control-sm" id="filterType">
                                    <option value="">All Types</option>
                                    <option value="silk">Silk</option>
                                    <option value="cotton">Cotton</option>
                                    <option value="linen">Linen</option>
                                    <option value="wool">Wool</option>
                                    <option value="polyester">Polyester</option>
                                </select>
                            </div>
                            <div class="mr-3 mb-2">
                                <select class="form-control form-control-sm" id="filterStatus">
                                    <option value="">All Status</option>
                                    <option value="in_stock">In Stock</option>
                                    <option value="low_stock">Low Stock</option>
                                    <option value="out_of_stock">Out of Stock</option>
                                    <option value="ordered">Ordered</option>
                                </select>
                            </div>
                            <div class="mr-3 mb-2">
                                <select class="form-control form-control-sm" id="filterColor">
                                    <option value="">All Colors</option>
                                    <option value="red">Red</option>
                                    <option value="blue">Blue</option>
                                    <option value="green">Green</option>
                                    <option value="black">Black</option>
                                    <option value="white">White</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                    <i class="las la-cog"></i> Actions
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#" onclick="placeBulkOrder()">
                                        <i class="las la-shopping-cart mr-2"></i> Place Bulk Order
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="updatePrices()">
                                        <i class="las la-rupee-sign mr-2"></i> Update Prices
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="exportInventory()">
                                        <i class="las la-file-export mr-2"></i> Export Inventory
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" onclick="generateReport()">
                                        <i class="las la-chart-bar mr-2"></i> Generate Report
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fabrics Table -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Fabric Inventory</h6>
                <div>
                    <button class="btn btn-sm btn-outline-warning mr-2" onclick="viewLowStock()">
                        <i class="las la-exclamation-triangle"></i> Low Stock
                    </button>
                    <button class="btn btn-sm btn-outline-success" onclick="quickReorder()">
                        <i class="las la-redo"></i> Quick Reorder
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="fabricsTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="50">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>Fabric</th>
                                <th>Type</th>
                                <th>Color</th>
                                <th>Stock (m)</th>
                                <th>Rate/m (₹)</th>
                                <th>Value (₹)</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $fabrics = [
                                    ['name' => 'Pure Silk', 'type' => 'Silk', 'color' => 'Navy Blue', 'stock' => 45.5, 'rate' => 850, 'status' => 'in_stock'],
                                    ['name' => 'Egyptian Cotton', 'type' => 'Cotton', 'color' => 'White', 'stock' => 120.0, 'rate' => 320, 'status' => 'in_stock'],
                                    ['name' => 'Italian Linen', 'type' => 'Linen', 'color' => 'Beige', 'stock' => 65.2, 'rate' => 620, 'status' => 'in_stock'],
                                    ['name' => 'Merino Wool', 'type' => 'Wool', 'color' => 'Charcoal', 'stock' => 35.8, 'rate' => 950, 'status' => 'in_stock'],
                                    ['name' => 'Premium Polyester', 'type' => 'Polyester', 'color' => 'Black', 'stock' => 85.0, 'rate' => 280, 'status' => 'in_stock'],
                                    ['name' => 'Georgette', 'type' => 'Silk', 'color' => 'Red', 'stock' => 25.5, 'rate' => 720, 'status' => 'low_stock'],
                                    ['name' => 'Chiffon', 'type' => 'Silk', 'color' => 'Pink', 'stock' => 8.5, 'rate' => 680, 'status' => 'low_stock'],
                                    ['name' => 'Velvet', 'type' => 'Cotton', 'color' => 'Burgundy', 'stock' => 15.2, 'rate' => 920, 'status' => 'low_stock'],
                                    ['name' => 'Satin', 'type' => 'Silk', 'color' => 'Gold', 'stock' => 5.8, 'rate' => 1100, 'status' => 'out_of_stock'],
                                    ['name' => 'Denim', 'type' => 'Cotton', 'color' => 'Blue', 'stock' => 0, 'rate' => 450, 'status' => 'out_of_stock'],
                                    ['name' => 'Linen Cotton Blend', 'type' => 'Linen', 'color' => 'Cream', 'stock' => 42.5, 'rate' => 480, 'status' => 'in_stock'],
                                    ['name' => 'Silk Satin', 'type' => 'Silk', 'color' => 'Silver', 'stock' => 18.8, 'rate' => 1250, 'status' => 'in_stock'],
                                ];
                            @endphp
                            @foreach($fabrics as $index => $fabric)
                            @php
                                $value = $fabric['stock'] * $fabric['rate'];
                                $statusColors = [
                                    'in_stock' => 'success',
                                    'low_stock' => 'warning',
                                    'out_of_stock' => 'danger',
                                    'ordered' => 'info'
                                ];
                                $statusTexts = [
                                    'in_stock' => 'In Stock',
                                    'low_stock' => 'Low Stock',
                                    'out_of_stock' => 'Out of Stock',
                                    'ordered' => 'Ordered'
                                ];
                                $lastUpdated = now()->subDays(rand(1, 30));
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" class="fabricCheckbox" value="{{ $index }}">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="fabric-swatch mr-3" style="width: 30px; height: 30px; background-color: {{ $fabric['color'] == 'White' ? '#f8f9fa' : strtolower($fabric['color']) }}; border: 1px solid #dee2e6; border-radius: 4px;"></div>
                                        <div>
                                            <div class="font-weight-bold">{{ $fabric['name'] }}</div>
                                            <small class="text-muted">Code: FB-{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-light">{{ $fabric['type'] }}</span>
                                </td>
                                <td>
                                    <div class="font-weight-bold">{{ $fabric['color'] }}</div>
                                    <small class="text-muted">{{ $fabric['type'] == 'Silk' ? 'Shiny' : ($fabric['type'] == 'Cotton' ? 'Matte' : 'Textured') }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1" style="height: 8px; width: 80px;">
                                            @php
                                                $maxStock = 150;
                                                $stockPercent = ($fabric['stock'] / $maxStock) * 100;
                                            @endphp
                                            <div class="progress-bar bg-{{ $fabric['status'] == 'in_stock' ? 'success' : ($fabric['status'] == 'low_stock' ? 'warning' : 'danger') }}" 
                                                 style="width: {{ $stockPercent }}%">
                                            </div>
                                        </div>
                                        <div class="ml-2 font-weight-bold">{{ $fabric['stock'] }} m</div>
                                    </div>
                                </td>
                                <td class="font-weight-bold text-success">
                                    ₹ {{ number_format($fabric['rate']) }}
                                </td>
                                <td class="font-weight-bold">
                                    ₹ {{ number_format($value) }}
                                </td>
                                <td>
                                    <span class="badge badge-{{ $statusColors[$fabric['status']] }}">
                                        {{ $statusTexts[$fabric['status']] }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $lastUpdated->format('d M, Y') }}</small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                            <i class="las la-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#" onclick="viewFabric({{ $index }})">
                                                <i class="las la-eye mr-2"></i> View Details
                                            </a>
                                            <a class="dropdown-item" href="#" onclick="editFabric({{ $index }})">
                                                <i class="las la-edit mr-2"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="#" onclick="addStock({{ $index }})">
                                                <i class="las la-plus-circle mr-2"></i> Add Stock
                                            </a>
                                            <a class="dropdown-item" href="#" onclick="useFabric({{ $index }})">
                                                <i class="las la-cut mr-2"></i> Use Fabric
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            @if($fabric['status'] == 'low_stock' || $fabric['status'] == 'out_of_stock')
                                            <a class="dropdown-item text-warning" href="#" onclick="reorderFabric({{ $index }})">
                                                <i class="las la-shopping-cart mr-2"></i> Reorder
                                            </a>
                                            @endif
                                            <a class="dropdown-item text-danger" href="#" onclick="deleteFabric({{ $index }})">
                                                <i class="las la-trash mr-2"></i> Remove
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Inventory Overview -->
        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Inventory Overview by Type</h6>
                        <select class="form-control form-control-sm" style="width: auto;" onchange="filterOverview(this)">
                            <option value="quantity">By Quantity</option>
                            <option value="value">By Value</option>
                        </select>
                    </div>
                    <div class="card-body">
                        <canvas id="inventoryChart" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">Low Stock Alert</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach(array_slice($fabrics, 5, 5) as $index => $fabric)
                            @if($fabric['status'] == 'low_stock' || $fabric['status'] == 'out_of_stock')
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <div class="font-weight-bold">{{ $fabric['name'] }}</div>
                                    <small class="text-muted">{{ $fabric['color'] }} • {{ $fabric['stock'] }}m left</small>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-outline-warning" onclick="reorderFabric({{ $index + 5 }})">
                                        <i class="las la-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-sm btn-outline-warning btn-block" onclick="viewLowStock()">
                                View All Low Stock Items
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Stock Modal -->
    <div class="modal fade" id="addStockModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Stock to Fabric</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="addStockForm">
                        <div class="form-group">
                            <label>Fabric</label>
                            <input type="text" class="form-control" id="fabricName" readonly>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Quantity to Add (m) *</label>
                                <input type="number" class="form-control" id="addQuantity" min="0.1" step="0.1" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>New Rate/m (₹)</label>
                                <input type="number" class="form-control" id="newRate" min="1">
                                <small class="text-muted">Leave empty to keep current rate</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Supplier</label>
                                <input type="text" class="form-control" id="supplier" placeholder="Supplier name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Invoice Number</label>
                                <input type="text" class="form-control" id="invoiceNumber" placeholder="Invoice #">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Notes</label>
                            <textarea class="form-control" id="stockNotes" rows="3" placeholder="Any notes about this stock addition..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveStockAddition()">
                        <i class="las la-plus-circle mr-1"></i> Add Stock
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reorder Modal -->
    <div class="modal fade" id="reorderModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reorder Fabric</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="reorderForm">
                        <div class="form-group">
                            <label>Fabric</label>
                            <input type="text" class="form-control" id="reorderFabricName" readonly>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Order Quantity (m) *</label>
                                <input type="number" class="form-control" id="orderQuantity" min="1" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Expected Rate/m (₹)</label>
                                <input type="number" class="form-control" id="expectedRate" min="1" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Supplier *</label>
                                <select class="form-control" id="reorderSupplier" required>
                                    <option value="">Select Supplier</option>
                                    <option value="1">Textile Wholesalers</option>
                                    <option value="2">Fabric House</option>
                                    <option value="3">Direct Mill</option>
                                    <option value="4">Local Market</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Expected Delivery</label>
                                <input type="date" class="form-control" id="expectedDelivery" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Order Notes</label>
                            <textarea class="form-control" id="orderNotes" rows="3" placeholder="Any special instructions..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="placeReorder()">
                        <i class="las la-shopping-cart mr-1"></i> Place Order
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/chart.js/Chart.min.js') }}"></script>

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
            // Initialize DataTable
            var table = $('#fabricsTable').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                     '<"row"<"col-sm-12"tr>>' +
                     '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search fabrics..."
                }
            });
            
            // Custom search
            $('#fabricSearch').on('keyup', function() {
                table.search(this.value).draw();
            });
            
            // Filter by type
            $('#filterType').change(function() {
                table.column(2).search(this.value).draw();
            });
            
            // Filter by status
            $('#filterStatus').change(function() {
                table.column(7).search(this.value).draw();
            });
            
            // Filter by color
            $('#filterColor').change(function() {
                table.column(3).search(this.value).draw();
            });
            
            // Select all checkbox
            $('#selectAll').click(function() {
                $('.fabricCheckbox').prop('checked', this.checked);
            });
            
            // Set expected delivery date (tomorrow)
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            $('#expectedDelivery').val(tomorrow.toISOString().split('T')[0]);
            
            // Initialize inventory chart
            initInventoryChart();
        });
        
        function initInventoryChart() {
            const ctx = document.getElementById('inventoryChart').getContext('2d');
            window.inventoryChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Silk', 'Cotton', 'Linen', 'Wool', 'Polyester', 'Other'],
                    datasets: [{
                        data: [125, 210, 85, 42, 120, 65],
                        backgroundColor: [
                            '#3B82F6',
                            '#10B981',
                            '#F59E0B',
                            '#8B5CF6',
                            '#EF4444',
                            '#6B7280'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
        
        function filterOverview(select) {
            if (select.value === 'value') {
                // Update chart with value data
                window.inventoryChart.data.datasets[0].data = [106250, 67200, 52700, 40660, 33600, 26000];
                window.inventoryChart.update();
            } else {
                // Update chart with quantity data
                window.inventoryChart.data.datasets[0].data = [125, 210, 85, 42, 120, 65];
                window.inventoryChart.update();
            }
        }
        
        function viewFabric(index) {
            const fabric = @json($fabrics)[index];
            alert(`Viewing: ${fabric.name}\nType: ${fabric.type}\nColor: ${fabric.color}\nStock: ${fabric.stock}m\nRate: ₹${fabric.rate}/m`);
        }
        
        function editFabric(index) {
            alert(`Editing fabric #${index + 1}`);
            // In real app: Open edit modal
        }
        
        function addStock(index) {
            const fabric = @json($fabrics)[index];
            $('#fabricName').val(fabric.name + ' - ' + fabric.color);
            $('#addStockModal').modal('show');
        }
        
        function saveStockAddition() {
            const quantity = $('#addQuantity').val();
            if (!quantity || quantity <= 0) {
                alert('Please enter valid quantity');
                return;
            }
            
            alert(`Added ${quantity}m to fabric stock`);
            $('#addStockModal').modal('hide');
            $('#addStockForm')[0].reset();
        }
        
        function useFabric(index) {
            const fabric = @json($fabrics)[index];
            alert(`Opening fabric usage form for: ${fabric.name}`);
            // In real app: Open usage modal
        }
        
        function reorderFabric(index) {
            const fabric = @json($fabrics)[index];
            $('#reorderFabricName').val(fabric.name + ' - ' + fabric.color);
            $('#orderQuantity').val(Math.max(50 - fabric.stock, 10));
            $('#expectedRate').val(fabric.rate);
            $('#reorderModal').modal('show');
        }
        
        function placeReorder() {
            const quantity = $('#orderQuantity').val();
            const supplier = $('#reorderSupplier').val();
            
            if (!quantity || quantity <= 0) {
                alert('Please enter valid quantity');
                return;
            }
            
            if (!supplier) {
                alert('Please select a supplier');
                return;
            }
            
            alert(`Order placed for ${quantity}m of fabric`);
            $('#reorderModal').modal('hide');
            $('#reorderForm')[0].reset();
        }
        
        function deleteFabric(index) {
            if (confirm('Are you sure you want to remove this fabric from inventory?')) {
                alert('Fabric removed from inventory');
                // In real app: AJAX call to delete
            }
        }
        
        function viewLowStock() {
            $('#filterStatus').val('low_stock').trigger('change');
            $('#filterStatus').val('out_of_stock').trigger('change');
        }
        
        function quickReorder() {
            const selected = $('.fabricCheckbox:checked');
            if (selected.length === 0) {
                alert('Please select fabrics to reorder');
                return;
            }
            alert(`Opening bulk reorder for ${selected.length} fabrics`);
        }
        
        function placeBulkOrder() {
            alert('Opening bulk order placement tool...');
        }
        
        function updatePrices() {
            alert('Opening price update tool...');
        }
        
        function exportInventory() {
            alert('Exporting inventory data...');
        }
        
        function generateReport() {
            alert('Generating inventory report...');
        }
    </script>
    
    <style>
        .fabric-swatch {
            width: 30px;
            height: 30px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }
        .card {
            border-radius: 0.5rem;
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
        .dropdown-menu {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border: none;
        }
        .list-group-item {
            border: none;
            padding: 0.75rem 0;
        }
        .list-group-item:hover {
            background-color: #f8f9fa;
        }
        .progress {
            background-color: #e9ecef;
            border-radius: 0.25rem;
        }
        .progress-bar {
            border-radius: 0.25rem;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        .modal-content {
            border-radius: 0.5rem;
            border: none;
        }
        .close {
            font-size: 1.5rem;
            font-weight: 300;
        }
    </style>
    @endpush
</x-app-layout>