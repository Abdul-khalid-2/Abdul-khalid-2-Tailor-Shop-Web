resources\views\dashboard\tailors\index.blade.php
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
                <h4 class="mb-3">Tailors Management</h4>
                <p class="mb-0">Manage your tailor team and their assignments</p>
            </div>
            <div>
                <a href="{{ route('tailors.create') }}" class="btn btn-primary">
                    <i class="las la-user-plus mr-1"></i> Add Tailor
                </a>
            </div>
        </div>

        <!-- Tailor Stats -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Tailors</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2">15 Active</span>
                                    <span class="text-muted">3 Inactive</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-users fa-2x text-primary"></i>
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
                                    Orders in Progress</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">42</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-info mr-2">Avg. 2.8/tailor</span>
                                    <span>capacity</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-tasks fa-2x text-success"></i>
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
                                    Avg. Completion Time</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">3.2 days</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2"><i class="fa fa-arrow-down"></i> 0.5 days</span>
                                    <span>improvement</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-clock fa-2x text-warning"></i>
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
                                    Today's Capacity</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">82%</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2">15/18</span>
                                    <span>tailors working</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-chart-pie fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tailor Actions Bar -->
        <div class="card shadow mb-4">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search tailors..." id="tailorSearch">
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
                                <select class="form-control form-control-sm" id="filterStatus">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="on_leave">On Leave</option>
                                </select>
                            </div>
                            <div class="mr-3 mb-2">
                                <select class="form-control form-control-sm" id="filterType">
                                    <option value="">All Types</option>
                                    <option value="permanent">Permanent</option>
                                    <option value="contract">Contract</option>
                                    <option value="freelance">Freelance</option>
                                </select>
                            </div>
                            <div class="mr-3 mb-2">
                                <select class="form-control form-control-sm" id="filterBranch">
                                    <option value="">All Branches</option>
                                    <option value="1">Main Shop</option>
                                    <option value="2">Downtown Branch</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <button class="btn btn-sm btn-outline-secondary" onclick="refreshTailors()">
                                    <i class="las la-sync-alt"></i> Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tailors Table -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Tailor List</h6>
                <div>
                    <a href="{{ route('tailor-assignments.index') }}" class="btn btn-sm btn-outline-info mr-2">
                        <i class="las la-tasks"></i> View Assignments
                    </a>
                    <button class="btn btn-sm btn-outline-success" onclick="assignBulkOrders()">
                        <i class="las la-plus-circle"></i> Bulk Assign
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tailorsTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Tailor</th>
                                <th>Specialization</th>
                                <th>Employment Type</th>
                                <th>Current Orders</th>
                                <th>Performance</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 1; $i <= 12; $i++)
                            @php
                                $types = ['permanent', 'contract', 'freelance'];
                                $type = $types[$i % 3];
                                $typeColors = ['permanent' => 'success', 'contract' => 'primary', 'freelance' => 'info'];
                                
                                $statuses = ['active', 'active', 'active', 'on_leave', 'inactive'];
                                $status = $statuses[$i % 5];
                                $statusColors = ['active' => 'success', 'inactive' => 'secondary', 'on_leave' => 'warning'];
                                
                                $specializations = [
                                    'Sherwani & Suits',
                                    'Ladies Wear',
                                    'Traditional Wear',
                                    'Kids Wear',
                                    'Formal Wear',
                                    'Casual Wear'
                                ];
                                $spec = $specializations[$i % 6];
                                
                                $currentOrders = rand(1, 5);
                                $performance = rand(75, 98);
                            @endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar mr-3">
                                            <img src="https://ui-avatars.com/api/?name=Tailor+{{ $i }}&background=10B981&color=fff&size=40" 
                                                 class="rounded-circle" 
                                                 alt="Tailor {{ $i }}">
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">Tailor {{ $i }}</div>
                                            <small class="text-muted">ID: T-00{{ 100 + $i }}</small>
                                            <div class="small">
                                                <i class="las la-phone mr-1"></i> +92 300 4567{{ str_pad($i, 3, '0', STR_PAD_LEFT) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="font-weight-bold">{{ $spec }}</div>
                                    <small class="text-muted">Experience: {{ rand(2, 15) }} years</small>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $typeColors[$type] }}">
                                        {{ ucfirst($type) }}
                                    </span>
                                    @if($type == 'permanent')
                                    <div class="small text-muted">Salary: ₹{{ number_format(rand(25000, 50000)) }}</div>
                                    @elseif($type == 'contract')
                                    <div class="small text-muted">Rate: ₹{{ number_format(rand(500, 1500)) }}/order</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-center">
                                        <div class="font-weight-bold">{{ $currentOrders }}</div>
                                        <div class="progress" style="height: 5px; width: 60px; margin: 0 auto;">
                                            <div class="progress-bar bg-{{ $currentOrders > 3 ? 'danger' : 'success' }}" 
                                                 style="width: {{ ($currentOrders / 5) * 100 }}%">
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ $currentOrders }}/5 capacity</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1" style="height: 10px;">
                                            <div class="progress-bar bg-{{ $performance > 90 ? 'success' : ($performance > 80 ? 'warning' : 'danger') }}" 
                                                 style="width: {{ $performance }}%">
                                            </div>
                                        </div>
                                        <div class="ml-2 font-weight-bold">{{ $performance }}%</div>
                                    </div>
                                    <small class="text-muted">On-time delivery</small>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $statusColors[$status] }}">
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                    </span>
                                    @if($status == 'on_leave')
                                    <div class="small text-muted">Returns: {{ now()->addDays(rand(1, 7))->format('d M') }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                            <i class="las la-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('tailors.show', ['id' => $i]) }}">
                                                <i class="las la-eye mr-2"></i> View Profile
                                            </a>
                                            <a class="dropdown-item" href="{{ route('tailors.edit', ['id' => $i]) }}">
                                                <i class="las la-edit mr-2"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="#" onclick="assignOrder({{ $i }})">
                                                <i class="las la-plus-circle mr-2"></i> Assign Order
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">
                                                <i class="las la-file-invoice-dollar mr-2"></i> Payment History
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <i class="las la-chart-line mr-2"></i> Performance Report
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            @if($status == 'active')
                                            <a class="dropdown-item text-warning" href="#" onclick="changeStatus({{ $i }}, 'inactive')">
                                                <i class="las la-user-slash mr-2"></i> Mark Inactive
                                            </a>
                                            @else
                                            <a class="dropdown-item text-success" href="#" onclick="changeStatus({{ $i }}, 'active')">
                                                <i class="las la-user-check mr-2"></i> Mark Active
                                            </a>
                                            @endif
                                            <a class="dropdown-item text-danger" href="#" onclick="deleteTailor({{ $i }})">
                                                <i class="las la-trash mr-2"></i> Remove
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Top Performers & Capacity -->
        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Top Performers</h6>
                        <select class="form-control form-control-sm" style="width: auto;" onchange="filterByMonth(this)">
                            <option value="this_month">This Month</option>
                            <option value="last_month">Last Month</option>
                            <option value="last_3months">Last 3 Months</option>
                        </select>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless">
                                <thead>
                                    <tr>
                                        <th>Tailor</th>
                                        <th>Orders Completed</th>
                                        <th>On-Time Rate</th>
                                        <th>Quality Rating</th>
                                        <th>Earnings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i = 1; $i <= 5; $i++)
                                    @php
                                        $completed = rand(15, 30);
                                        $onTime = rand(85, 98);
                                        $quality = rand(4.0, 5.0);
                                        $earnings = $completed * rand(800, 2000);
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm mr-2">
                                                    <span class="avatar-title rounded-circle bg-warning text-white">
                                                        T{{ $i }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">Top Tailor {{ $i }}</div>
                                                    <small class="text-muted">{{ $specializations[$i % 6] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold">{{ $completed }}</div>
                                            <small class="text-muted">orders</small>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 8px; width: 80px;">
                                                <div class="progress-bar bg-success" style="width: {{ $onTime }}%"></div>
                                            </div>
                                            <small>{{ $onTime }}%</small>
                                        </td>
                                        <td>
                                            <div class="star-rating">
                                                @for($j = 1; $j <= 5; $j++)
                                                    <i class="las la-star {{ $j <= floor($quality) ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                            </div>
                                            <small>{{ number_format($quality, 1) }}/5.0</small>
                                        </td>
                                        <td class="font-weight-bold text-success">
                                            ₹ {{ number_format($earnings) }}
                                        </td>
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Capacity Overview</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="capacityChart" height="200"></canvas>
                        <div class="row text-center mt-3">
                            <div class="col-6">
                                <div class="text-primary">Available</div>
                                <div class="h4 font-weight-bold">15</div>
                            </div>
                            <div class="col-6">
                                <div class="text-warning">Busy</div>
                                <div class="h4 font-weight-bold">3</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Order Modal -->
    <div class="modal fade" id="assignModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Order to Tailor</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="assignForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Select Tailor</label>
                                <select class="form-control select2" id="assignTailor" required>
                                    <option value="">Select Tailor</option>
                                    @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">Tailor {{ $i }} ({{ $specializations[$i % 6] }})</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Select Order</label>
                                <select class="form-control select2" id="assignOrder" required>
                                    <option value="">Select Order</option>
                                    @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">TS-001{{ 20 + $i }} - Customer {{ $i }} (Sherwani)</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Stitching Charges (₹)</label>
                                <input type="number" class="form-control" id="stitchingCharges" value="1200" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Expected Completion Date</label>
                                <input type="date" class="form-control" id="expectedDate" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Special Instructions</label>
                            <textarea class="form-control" id="instructions" rows="3" placeholder="Any special instructions for the tailor..."></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="notifyTailor">
                                <label class="form-check-label" for="notifyTailor">Notify tailor about this assignment</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="submitAssignment()">
                        <i class="las la-check-circle mr-1"></i> Assign Order
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
            var table = $('#tailorsTable').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                     '<"row"<"col-sm-12"tr>>' +
                     '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search tailors..."
                }
            });
            
            // Custom search
            $('#tailorSearch').on('keyup', function() {
                table.search(this.value).draw();
            });
            
            // Filter by status
            $('#filterStatus').change(function() {
                table.column(6).search(this.value).draw();
            });
            
            // Filter by type
            $('#filterType').change(function() {
                table.column(3).search(this.value).draw();
            });
            
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap'
            });
            
            // Set default expected date
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 3);
            $('#expectedDate').val(tomorrow.toISOString().split('T')[0]);
            
            // Initialize capacity chart
            initCapacityChart();
        });
        
        function initCapacityChart() {
            const ctx = document.getElementById('capacityChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Available', 'Busy', 'On Leave'],
                    datasets: [{
                        data: [15, 3, 2],
                        backgroundColor: ['#10B981', '#F59E0B', '#6B7280'],
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
        
        function refreshTailors() {
            const btn = event.target;
            $(btn).addClass('fa-spin');
            setTimeout(() => {
                $(btn).removeClass('fa-spin');
                alert('Tailors list refreshed!');
            }, 1000);
        }
        
        function assignOrder(tailorId) {
            $('#assignTailor').val(tailorId).trigger('change');
            $('#assignModal').modal('show');
        }
        
        function assignBulkOrders() {
            alert('Opening bulk assignment tool...');
            // In real app: Open bulk assignment modal
        }
        
        function submitAssignment() {
            const tailor = $('#assignTailor').val();
            const order = $('#assignOrder').val();
            
            if (!tailor || !order) {
                alert('Please select both tailor and order');
                return;
            }
            
            alert('Order assigned successfully to Tailor #' + tailor);
            $('#assignModal').modal('hide');
            $('#assignForm')[0].reset();
        }
        
        function changeStatus(tailorId, newStatus) {
            const statusText = newStatus === 'active' ? 'Active' : 'Inactive';
            if (confirm('Change tailor status to ' + statusText + '?')) {
                alert('Tailor status updated to ' + statusText);
                // In real app: AJAX call to update status
            }
        }
        
        function deleteTailor(tailorId) {
            if (confirm('Are you sure you want to remove this tailor? This action cannot be undone.')) {
                alert('Tailor removed from system');
                // In real app: AJAX call to delete tailor
            }
        }
        
        function filterByMonth(select) {
            console.log('Filtering by:', select.value);
            // In real app: AJAX call to filter top performers
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
        .avatar-sm {
            width: 30px;
            height: 30px;
            font-size: 12px;
        }
        .star-rating {
            display: inline-block;
        }
        .star-rating .las {
            font-size: 14px;
        }
    </style>
    @endpush
</x-app-layout>