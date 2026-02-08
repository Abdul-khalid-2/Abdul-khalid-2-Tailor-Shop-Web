<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/datatables/dataTables.bootstrap4.min.css') }}">
    @endpush

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-3">Dress Types Management</h4>
                <p class="mb-0">Manage dress types, pricing, and configurations</p>
            </div>
            <div>
                <a href="{{ route('dress-types.create') }}" class="btn btn-primary">
                    <i class="las la-plus-circle mr-1"></i> Add Dress Type
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="las la-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="las la-exclamation-circle mr-2"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Dress Type Stats -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Dress Types</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2">{{ $stats['active'] }} Active</span>
                                    <span class="text-muted">{{ $stats['inactive'] }} Inactive</span>
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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rs {{ number_format($stats['avg_price']) }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2">Highest: Rs {{ number_format($stats['max_price']) }}</span>
                                    <span class="text-muted">Lowest: Rs {{ number_format($stats['min_price']) }}</span>
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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['avg_days'], 1) }} days</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-info mr-2">Range: 1-365 days</span>
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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['most_popular']['name'] }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2">{{ $stats['most_popular']['orders'] }} orders</span>
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

        <!-- Filter and Search -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('dress-types.index') }}">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Search</label>
                            <input type="text" class="form-control" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Search by name, slug or description...">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Sort By</label>
                            <select class="form-control" name="sort_by">
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="base_price" {{ request('sort_by') == 'base_price' ? 'selected' : '' }}>Price</option>
                                <option value="estimated_days" {{ request('sort_by') == 'estimated_days' ? 'selected' : '' }}>Days</option>
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Sort Order</label>
                            <select class="form-control" name="sort_order">
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="las la-filter mr-1"></i> Filter
                            </button>
                            <a href="{{ route('dress-types.index') }}" class="btn btn-secondary">
                                <i class="las la-sync mr-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Dress Types Table -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Dress Types List</h6>
                <div>
                    <a href="{{ route('dress-types.export') }}" class="btn btn-sm btn-outline-secondary mr-2">
                        <i class="las la-download"></i> Export
                    </a>
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
                                <th>Total Orders</th>
                                <th>Monthly Orders</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dressTypes as $index => $type)
                            @php
                                $popularity = $type->monthly_orders > 30 ? 'high' : ($type->monthly_orders > 10 ? 'medium' : 'low');
                                $popularityColor = $popularity == 'high' ? 'success' : ($popularity == 'medium' ? 'warning' : 'secondary');
                            @endphp
                            <tr>
                                <td>{{ $dressTypes->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar mr-3">
                                            <span class="avatar-title rounded-circle bg-primary text-white">
                                                {{ substr($type->name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $type->name }}</div>
                                            <small class="text-muted">{{ $type->slug }}</small>
                                            @if($type->description)
                                            <div class="text-muted small mt-1">{{ Str::limit($type->description, 50) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="font-weight-bold text-success">
                                    Rs {{ number_format($type->base_price, 2) }}
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $type->estimated_days }} days</span>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">{{ $type->total_orders }} orders</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar bg-{{ $popularityColor }}" 
                                                 style="width: {{ min(($type->monthly_orders / 50) * 100, 100) }}%">
                                            </div>
                                        </div>
                                        <div class="ml-2 font-weight-bold">{{ $type->monthly_orders }}</div>
                                    </div>
                                </td>
                                <td>
                                    @if($type->is_active)
                                    <span class="badge badge-success">Active</span>
                                    @else
                                    <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $type->createdBy->name ?? 'N/A' }}</small>
                                    <div class="text-muted small">{{ $type->created_at->format('M d, Y') }}</div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('dress-types.edit', $type) }}" class="btn btn-sm btn-outline-info">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewDetails({{ $type->id }})">
                                            <i class="las la-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-{{ $type->is_active ? 'warning' : 'success' }}" 
                                                onclick="toggleStatus({{ $type->id }})">
                                            <i class="las la-{{ $type->is_active ? 'ban' : 'check' }}"></i>
                                        </button>
                                        <form action="{{ route('dress-types.destroy', $type) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirmDelete()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="las la-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Showing {{ $dressTypes->firstItem() }} to {{ $dressTypes->lastItem() }} of {{ $dressTypes->total() }} entries
                        </div>
                        <div>
                            {{ $dressTypes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular Dress Types Chart -->
        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Popular Dress Types (This Month)</h6>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                    data-toggle="dropdown" aria-expanded="false">
                                <i class="las la-calendar"></i> This Month
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="changeChartPeriod('week')">This Week</a>
                                <a class="dropdown-item" href="#" onclick="changeChartPeriod('month')">This Month</a>
                                <a class="dropdown-item" href="#" onclick="changeChartPeriod('year')">This Year</a>
                            </div>
                        </div>
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
                            <a href="{{ route('dress-types.create') }}" class="list-group-item list-group-item-action">
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
                        
                        <!-- Active Dress Types -->
                        <div class="mt-4">
                            <h6 class="font-weight-bold mb-3">Active Dress Types</h6>
                            @foreach($dressTypes->where('is_active', true)->take(5) as $activeType)
                            <div class="d-flex align-items-center mb-2">
                                <span class="avatar-title bg-light-primary text-primary rounded-circle mr-2" 
                                      style="width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px;">
                                    {{ substr($activeType->name, 0, 1) }}
                                </span>
                                <div class="flex-grow-1">
                                    <div class="font-weight-bold">{{ $activeType->name }}</div>
                                    <small class="text-muted">Rs {{ number_format($activeType->base_price) }}</small>
                                </div>
                                <span class="badge badge-light">{{ $activeType->monthly_orders }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('dress-types.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Import Dress Types</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>CSV File</label>
                            <input type="file" class="form-control" name="file" accept=".csv,.txt" required>
                            <small class="text-muted">Download <a href="{{ asset('templates/dress_types_template.csv') }}">template</a> for reference</small>
                        </div>
                        <div class="alert alert-info">
                            <i class="las la-info-circle"></i> File should contain columns: name, description, base_price, estimated_days, is_active
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Dress Type Details</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="dressTypeDetails">
                    <!-- Details will be loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
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
        let popularityChart;
        
        $(document).ready(function() {
            // Initialize DataTable
            $('#dressTypesTable').DataTable({
                pageLength: 10,
                responsive: true,
                ordering: false, // Disable DataTable sorting as we have pagination
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search dress types..."
                }
            });
            
            // Initialize chart
            initPopularityChart('month');
            
            // Auto-hide alerts after 5 seconds
            setTimeout(() => {
                $('.alert').alert('close');
            }, 5000);
        });
        
        function initPopularityChart(period = 'month') {
            const ctx = document.getElementById('popularityChart').getContext('2d');
            
            // Destroy existing chart if it exists
            if (popularityChart) {
                popularityChart.destroy();
            }
            
            // Fetch data from API
            fetch(`/api/dress-types/popularity?period=${period}`)
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.name);
                    const orders = data.map(item => item.orders);
                    
                    popularityChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Orders',
                                data: orders,
                                backgroundColor: [
                                    '#3B82F6', '#10B981', '#8B5CF6', '#F59E0B', 
                                    '#EF4444', '#6B7280', '#EC4899', '#14B8A6',
                                    '#F97316', '#8B5CF6'
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
                                        stepSize: Math.max(1, Math.round(Math.max(...orders) / 10))
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching chart data:', error);
                });
        }
        
        function changeChartPeriod(period) {
            initPopularityChart(period);
        }
        
        function toggleStatus(id) {
            if (confirm('Toggle dress type status?')) {
                $.ajax({
                    url: `/dress-types/${id}/toggle-status`,
                    type: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        alert('Error updating status');
                    }
                });
            }
        }
        
        function viewDetails(id) {
            $.ajax({
                url: `/api/dress-types/${id}`,
                type: 'GET',
                success: function(response) {
                    const details = `
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Basic Information</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <th>Name:</th>
                                        <td>${response.name}</td>
                                    </tr>
                                    <tr>
                                        <th>Slug:</th>
                                        <td>${response.slug}</td>
                                    </tr>
                                    <tr>
                                        <th>Base Price:</th>
                                        <td>Rs ${parseFloat(response.base_price).toLocaleString()}</td>
                                    </tr>
                                    <tr>
                                        <th>Estimated Days:</th>
                                        <td>${response.estimated_days} days</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            ${response.is_active 
                                                ? '<span class="badge badge-success">Active</span>' 
                                                : '<span class="badge badge-secondary">Inactive</span>'}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6>Order Statistics</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <th>Total Orders:</th>
                                        <td>${response.total_orders || 0}</td>
                                    </tr>
                                    <tr>
                                        <th>This Month:</th>
                                        <td>${response.monthly_orders || 0}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        ${response.description ? `
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6>Description</h6>
                                <p>${response.description}</p>
                            </div>
                        </div>
                        ` : ''}
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6>Audit Information</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <th>Created By:</th>
                                        <td>${response.created_by_name || 'N/A'}</td>
                                        <th>Created At:</th>
                                        <td>${new Date(response.created_at).toLocaleString()}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated By:</th>
                                        <td>${response.updated_by_name || 'N/A'}</td>
                                        <th>Updated At:</th>
                                        <td>${new Date(response.updated_at).toLocaleString()}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    `;
                    $('#dressTypeDetails').html(details);
                    $('#detailsModal').modal('show');
                },
                error: function(xhr) {
                    alert('Error loading dress type details');
                }
            });
        }
        
        function importDressTypes() {
            $('#importModal').modal('show');
        }
        
        function confirmDelete() {
            return confirm('Are you sure you want to delete this dress type? This action cannot be undone.');
        }
        
        function updatePrices() {
            alert('Opening price update tool...');
            // Implement bulk price update
        }
        
        function manageTemplates() {
            alert('Opening measurement templates manager...');
            // Redirect to measurement templates
        }
        
        function generateReport() {
            window.open('/reports/dress-types?format=pdf', '_blank');
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
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
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
        }
    </style>
    @endpush
</x-app-layout>