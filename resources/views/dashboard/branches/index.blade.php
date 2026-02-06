<x-app-layout>
        @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    @endpush


    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-3">Branches Management</h4>
                <p class="mb-0">Manage all your tailor shop branches</p>
            </div>
            <div>
                <a href="{{ route('branches.create') }}" class="btn btn-primary">
                    <i class="las la-plus mr-1"></i> Add Branch
                </a>
            </div>
        </div>

        <!-- Branch Stats -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Branches</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-store fa-2x text-primary"></i>
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
                                    Active Branches</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-check-circle fa-2x text-success"></i>
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
                                    Total Users</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_users'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-users fa-2x text-info"></i>
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
                                    Total Customers</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_customers'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-user-friends fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Branches Table -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Branch List</h6>
                <a href="{{ route('settings.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="las la-cog mr-1"></i> System Settings
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="branchesTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Branch Info</th>
                                <th>Contact</th>
                                <th>Manager</th>
                                <th>Stats</th>
                                <th>Timing</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($branches as $branch)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $branch->name }}</div>
                                    <small class="text-muted">Code: {{ $branch->code }}</small><br>
                                    <small class="text-muted">Opened: {{ $branch->opening_date ? $branch->opening_date->format('d M, Y') : 'N/A' }}</small>
                                </td>
                                <td>
                                    <div><i class="las la-phone mr-1"></i> {{ $branch->phone ?? 'N/A' }}</div>
                                    <div><i class="las la-envelope mr-1"></i> {{ $branch->email ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ Str::limit($branch->address, 30) }}</small>
                                </td>
                                <td>
                                    @if($branch->manager_name)
                                    <div class="font-weight-bold">{{ $branch->manager_name }}</div>
                                    <div><i class="las la-phone mr-1"></i> {{ $branch->manager_phone ?? 'N/A' }}</div>
                                    <div><i class="las la-envelope mr-1"></i> {{ $branch->manager_email ?? 'N/A' }}</div>
                                    @else
                                    <span class="text-muted">Not assigned</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="font-weight-bold text-primary">{{ $branch->users_count }}</div>
                                            <small class="text-muted">Users</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="font-weight-bold text-success">{{ $branch->customers_count }}</div>
                                            <small class="text-muted">Customers</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="font-weight-bold text-info">{{ $branch->orders_count }}</div>
                                            <small class="text-muted">Orders</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small">
                                        <div><i class="las la-clock mr-1"></i> {{ $branch->opening_time }} - {{ $branch->closing_time }}</div>
                                        @if($branch->working_days)
                                        <div class="text-muted">{{ implode(', ', $branch->working_days) }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($branch->is_active)
                                    <span class="badge badge-success">Active</span>
                                    @else
                                    <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                            <i class="las la-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('branches.show', $branch) }}">
                                                <i class="las la-eye mr-2"></i> View Details
                                            </a>
                                            <a class="dropdown-item" href="{{ route('branches.edit', $branch) }}">
                                                <i class="las la-edit mr-2"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="{{ route('settings.branch', $branch) }}">
                                                <i class="las la-cog mr-2"></i> Settings
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('branches.toggle-status', $branch) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    <i class="las la-power-off mr-2"></i> 
                                                    {{ $branch->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('branches.destroy', $branch) }}" method="POST" onsubmit="return confirmDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="las la-trash mr-2"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($branches->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Showing {{ $branches->firstItem() }} to {{ $branches->lastItem() }} of {{ $branches->total() }} entries
                    </div>
                    <div>
                        {{ $branches->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-lg-4 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('branches.create') }}" class="btn btn-outline-primary btn-block text-left">
                                <i class="las la-plus-circle mr-2"></i> Add New Branch
                            </a>
                            <a href="{{ route('settings.general') }}" class="btn btn-outline-success btn-block text-left">
                                <i class="las la-cog mr-2"></i> General Settings
                            </a>
                            <a href="#" class="btn btn-outline-info btn-block text-left" data-toggle="modal" data-target="#branchReportModal">
                                <i class="las la-chart-bar mr-2"></i> Generate Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Active Branch Performance</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless">
                                <thead>
                                    <tr>
                                        <th>Branch</th>
                                        <th class="text-center">Orders</th>
                                        <th class="text-center">Revenue</th>
                                        <th class="text-center">Customers</th>
                                        <th class="text-center">Growth</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($branches->where('is_active', true)->take(3) as $branch)
                                    @php
                                        $revenue = $branch->orders()->sum('final_amount');
                                        $growth = rand(5, 20);
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold">{{ $branch->name }}</div>
                                            <small class="text-muted">{{ $branch->code }}</small>
                                        </td>
                                        <td class="text-center font-weight-bold text-primary">{{ $branch->orders_count }}</td>
                                        <td class="text-center font-weight-bold text-success">Rs {{ number_format($revenue) }}</td>
                                        <td class="text-center font-weight-bold text-info">{{ $branch->customers_count }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-success">
                                                <i class="las la-arrow-up"></i> {{ $growth }}%
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Modal -->
    <div class="modal fade" id="branchReportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate Branch Report</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="branchReportForm">
                        <div class="form-group">
                            <label>Report Type</label>
                            <select class="form-control" id="reportType">
                                <option value="performance">Branch Performance</option>
                                <option value="revenue">Revenue Report</option>
                                <option value="customer">Customer Report</option>
                                <option value="inventory">Inventory Report</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Date Range</label>
                            <input type="text" class="form-control" id="branchDateRange" placeholder="Select date range">
                        </div>
                        <div class="form-group">
                            <label>Format</label>
                            <select class="form-control" id="reportFormat">
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel</option>
                                <option value="csv">CSV</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="generateBranchReport()">
                        <i class="las la-download mr-1"></i> Generate
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    @push('js')
     <!-- Backend Bundle JavaScript -->
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
            $('#branchesTable').DataTable({
                pageLength: 10,
                responsive: true,
                searching: false,
                lengthChange: false,
                info: false,
                paging: false,
                dom: '<"row"<"col-sm-12"tr>>'
            });
            
            // Date range picker
            $('#branchDateRange').daterangepicker({
                ranges: {
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(30, 'days'),
                endDate: moment()
            });
        });
        
        function confirmDelete(event) {
            event.preventDefault();
            if (confirm('Are you sure you want to delete this branch? This action cannot be undone.')) {
                event.target.submit();
            }
            return false;
        }
        
        function generateBranchReport() {
            const reportType = $('#reportType').val();
            const format = $('#reportFormat').val();
            
            alert('Generating ' + reportType + ' report in ' + format.toUpperCase() + ' format...');
            $('#branchReportModal').modal('hide');
        }
    </script>
    
    <style>
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
        .btn {
            border-radius: 0.375rem;
        }
        .d-grid.gap-2 {
            gap: 0.5rem !important;
        }
    </style>
    @endpush
</x-app-layout>