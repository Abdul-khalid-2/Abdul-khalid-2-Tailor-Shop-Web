resources\views\dashboard\dress-types\index.blade.php
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
                <h4 class="mb-3">Dress Types Management</h4>
                <p class="mb-0">Manage dress types, pricing, and configurations</p>
            </div>
            <div>
                <button class="btn btn-primary" onclick="addDressType()">
                    <i class="las la-plus-circle mr-1"></i> Add Dress Type
                </button>
            </div>
        </div>

        <!-- Dress Type Stats -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Dress Types</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">24</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2">20 Active</span>
                                    <span class="text-muted">4 Inactive</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-tshirt fa-2x text-primary"></i>
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
                                    Avg. Base Price</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">₹ 4,850</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2">Highest: ₹ 12,000</span>
                                    <span class="text-muted">Lowest: ₹ 1,500</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-rupee-sign fa-2x text-success"></i>
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
                                    Avg. Completion Time</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">4.5 days</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-info mr-2">Fastest: 2 days</span>
                                    <span class="text-muted">Longest: 10 days</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-clock fa-2x text-info"></i>
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
                                    Most Popular</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Sherwani</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2">45 orders</span>
                                    <span>this month</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-crown fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dress Types Table -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Dress Types List</h6>
                <div>
                    <button class="btn btn-sm btn-outline-secondary mr-2" onclick="exportDressTypes()">
                        <i class="las la-download"></i> Export
                    </button>
                    <button class="btn btn-sm btn-outline-info" onclick="importDressTypes()">
                        <i class="las la-upload"></i> Import
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dressTypesTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Dress Type</th>
                                <th>Base Price</th>
                                <th>Estimated Days</th>
                                <th>Measurements</th>
                                <th>Orders This Month</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $dressTypes = [
                                    ['name' => 'Sherwani', 'price' => 12000, 'days' => 7, 'measurements' => 12, 'orders' => 45],
                                    ['name' => 'Suit', 'price' => 8000, 'days' => 5, 'measurements' => 10, 'orders' => 38],
                                    ['name' => 'Kurta', 'price' => 3500, 'days' => 3, 'measurements' => 8, 'orders' => 42],
                                    ['name' => 'Shalwar Kameez', 'price' => 4500, 'days' => 4, 'measurements' => 9, 'orders' => 28],
                                    ['name' => 'Gown', 'price' => 15000, 'days' => 10, 'measurements' => 15, 'orders' => 18],
                                    ['name' => 'Lehenga', 'price' => 18000, 'days' => 12, 'measurements' => 18, 'orders' => 15],
                                    ['name' => 'Blouse', 'price' => 2500, 'days' => 2, 'measurements' => 6, 'orders' => 32],
                                    ['name' => 'Abaya', 'price' => 5500, 'days' => 4, 'measurements' => 8, 'orders' => 22],
                                    ['name' => 'Kids Wear', 'price' => 3000, 'days' => 3, 'measurements' => 7, 'orders' => 25],
                                    ['name' => 'Formal Shirt', 'price' => 2000, 'days' => 2, 'measurements' => 6, 'orders' => 40],
                                    ['name' => 'Casual Shirt', 'price' => 1500, 'days' => 2, 'measurements' => 5, 'orders' => 35],
                                    ['name' => 'Traditional Jacket', 'price' => 6000, 'days' => 5, 'measurements' => 9, 'orders' => 12],
                                ];
                            @endphp
                            @foreach($dressTypes as $index => $type)
                            @php
                                $isActive = $index < 8;
                                $popularity = $type['orders'] > 30 ? 'high' : ($type['orders'] > 20 ? 'medium' : 'low');
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar mr-3">
                                            <span class="avatar-title rounded-circle bg-primary text-white">
                                                {{ substr($type['name'], 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $type['name'] }}</div>
                                            <small class="text-muted">ID: DT-{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="font-weight-bold text-success">
                                    ₹ {{ number_format($type['price']) }}
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $type['days'] }} days</span>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">{{ $type['measurements'] }} fields</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar bg-{{ $popularity == 'high' ? 'success' : ($popularity == 'medium' ? 'warning' : 'secondary') }}" 
                                                 style="width: {{ ($type['orders'] / 50) * 100 }}%">
                                            </div>
                                        </div>
                                        <div class="ml-2 font-weight-bold">{{ $type['orders'] }}</div>
                                    </div>
                                </td>
                                <td>
                                    @if($isActive)
                                    <span class="badge badge-success">Active</span>
                                    @else
                                    <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-info" onclick="editDressType({{ $index + 1 }})">
                                            <i class="las la-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewDetails({{ $index + 1 }})">
                                            <i class="las la-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-{{ $isActive ? 'warning' : 'success' }}" onclick="toggleStatus({{ $index + 1 }})">
                                            <i class="las la-{{ $isActive ? 'ban' : 'check' }}"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteDressType({{ $index + 1 }})">
                                            <i class="las la-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Popular Dress Types Chart -->
        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Popular Dress Types</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="popularityChart" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action" onclick="addDressType()">
                                <i class="las la-plus-circle mr-2 text-primary"></i>
                                Add New Dress Type
                            </a>
                            <a href="#" class="list-group-item list-group-item-action" onclick="updatePrices()">
                                <i class="las la-rupee-sign mr-2 text-success"></i>
                                Update Prices
                            </a>
                            <a href="#" class="list-group-item list-group-item-action" onclick="manageTemplates()">
                                <i class="las la-ruler-combined mr-2 text-info"></i>
                                Manage Templates
                            </a>
                            <a href="#" class="list-group-item list-group-item-action" onclick="generateReport()">
                                <i class="las la-chart-bar mr-2 text-warning"></i>
                                Generate Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Dress Type Modal -->
    <div class="modal fade" id="dressTypeModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Dress Type</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="dressTypeForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Dress Type Name *</label>
                                <input type="text" class="form-control" placeholder="e.g., Sherwani" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Slug (URL)</label>
                                <input type="text" class="form-control" placeholder="sherwani" readonly>
                                <small class="text-muted">Auto-generated from name</small>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Base Price (₹) *</label>
                                <input type="number" class="form-control" placeholder="12000" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Estimated Days *</label>
                                <input type="number" class="form-control" min="1" max="30" value="7" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3" placeholder="Description of this dress type..."></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Required Measurements</label>
                            <div class="row">
                                @php $measurements = ['Height', 'Chest', 'Waist', 'Hips', 'Shoulder', 'Sleeve Length', 'Pant Length', 'Inseam']; @endphp
                                @foreach($measurements as $measurement)
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="measure_{{ $loop->index }}" checked>
                                        <label class="form-check-label" for="measure_{{ $loop->index }}">{{ $measurement }}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-control">
                                    <option value="mens">Mens Wear</option>
                                    <option value="womens">Womens Wear</option>
                                    <option value="kids">Kids Wear</option>
                                    <option value="traditional">Traditional</option>
                                    <option value="formal">Formal</option>
                                    <option value="casual">Casual</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control">
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveDressType()">
                        <i class="las la-save mr-1"></i> Save Dress Type
                    </button>
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
        $(document).ready(function() {
            // Initialize DataTable
            $('#dressTypesTable').DataTable({
                pageLength: 10,
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search dress types..."
                }
            });
            
            // Initialize popularity chart
            initPopularityChart();
        });
        
        function initPopularityChart() {
            const ctx = document.getElementById('popularityChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Sherwani', 'Suit', 'Kurta', 'Gown', 'Lehenga', 'Blouse'],
                    datasets: [{
                        label: 'Orders This Month',
                        data: [45, 38, 42, 18, 15, 32],
                        backgroundColor: [
                            '#3B82F6', '#10B981', '#8B5CF6', '#F59E0B', '#EF4444', '#6B7280'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 10
                            }
                        }
                    }
                }
            });
        }
        
        function addDressType() {
            $('#dressTypeModal').modal('show');
        }
        
        function editDressType(id) {
            $('#dressTypeModal .modal-title').text('Edit Dress Type');
            $('#dressTypeModal').modal('show');
            // In real app: Load dress type data
        }
        
        function saveDressType() {
            alert('Dress type saved successfully!');
            $('#dressTypeModal').modal('hide');
        }
        
        function viewDetails(id) {
            alert('Viewing dress type details for ID: ' + id);
            // In real app: Open details modal
        }
        
        function toggleStatus(id) {
            if (confirm('Toggle dress type status?')) {
                alert('Dress type status updated!');
                // In real app: AJAX call to toggle status
            }
        }
        
        function deleteDressType(id) {
            if (confirm('Are you sure you want to delete this dress type?')) {
                alert('Dress type deleted!');
                // In real app: AJAX call to delete
            }
        }
        
        function exportDressTypes() {
            alert('Exporting dress types data...');
        }
        
        function importDressTypes() {
            alert('Opening import dialog...');
        }
        
        function updatePrices() {
            alert('Opening price update tool...');
        }
        
        function manageTemplates() {
            alert('Opening measurement templates manager...');
        }
        
        function generateReport() {
            alert('Generating dress types report...');
        }
    </script>
    
    <style>
        .avatar {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .avatar-title {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            font-weight: bold;
        }
    </style>
    @endpush
</x-app-layout>