<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/datatables/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/daterangepicker/daterangepicker.css') }}">
        <style>
            /* Fix DataTables dropdown clipping */
            .table-responsive,
            .dataTables_wrapper,
            .dataTables_wrapper .row,
            .card-body {
                overflow: visible !important;
            }

            /* Ensure dropdown is above everything */
            .dropdown-menu {
                z-index: 9999 !important;
            }

        </style>
    @endpush

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-3">Customers Management</h4>
                <p class="mb-0">Manage all your tailor shop customers</p>
            </div>
            <div>
                <a href="{{ route('customers.create') }}" class="btn btn-primary">
                    <i class="las la-user-plus mr-1"></i> Add Customer
                </a>
            </div>
        </div>

        <!-- Customer Stats -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Customers</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    @php
                                        $lastMonth = now()->subMonth();
                                        $newLastMonth = \App\Models\Customer::whereMonth('created_at', $lastMonth->month)->count();
                                        $growth = $stats['new_this_month'] > 0 ? 
                                                (($stats['new_this_month'] - $newLastMonth) / max($newLastMonth, 1) * 100) : 0;
                                    @endphp
                                    <span class="{{ $growth > 0 ? 'text-success' : 'text-danger' }} mr-2">
                                        <i class="fa fa-arrow-{{ $growth > 0 ? 'up' : 'down' }}"></i> {{ number_format(abs($growth), 1) }}%
                                    </span>
                                    <span>this month</span>
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
                                    Active Customers</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active'] }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2">{{ number_format(($stats['active'] / max($stats['total'], 1)) * 100, 0) }}%</span>
                                    <span>of total</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-user-check fa-2x text-success"></i>
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
                                    Avg. Orders/Customer</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['avg_orders'], 1) }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 0.4</span>
                                    <span>increase</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-shopping-cart fa-2x text-info"></i>
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
                                    New This Month</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['new_this_month'] }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    @php
                                        $lastMonth = now()->subMonth();
                                        $newLastMonth = \App\Models\Customer::whereMonth('created_at', $lastMonth->month)->count();
                                        $growth = $stats['new_this_month'] > 0 ? 
                                                (($stats['new_this_month'] - $newLastMonth) / max($newLastMonth, 1) * 100) : 0;
                                    @endphp
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{ number_format($growth, 0) }}%</span>
                                    <span>growth</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-user-plus fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Actions Bar -->
        <div class="card shadow mb-4">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search customers..." id="customerSearch">
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
                                    <option value="new">New</option>
                                    <option value="repeat">Repeat</option>
                                </select>
                            </div>
                            <div class="mr-3 mb-2">
                                <select class="form-control form-control-sm" id="filterBranch">
                                    <option value="">All Branches</option>
                                    <option value="1">Main Shop</option>
                                    <option value="2">Downtown Branch</option>
                                    <option value="3">Mall Outlet</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                    <i class="las la-download"></i> Export
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#" onclick="exportCustomers('csv')">CSV</a>
                                    <a class="dropdown-item" href="#" onclick="exportCustomers('excel')">Excel</a>
                                    <a class="dropdown-item" href="#" onclick="exportCustomers('pdf')">PDF</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers Table -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Customer List</h6>
                <div>
                    <button class="btn btn-sm btn-outline-primary" onclick="sendBulkMessage()">
                        <i class="las la-envelope"></i> Send Message
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="customersTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Orders</th>
                                <th>Total Spent</th>
                                <th>Last Order</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                            @php
                                $statusColor = $customer->orders_count > 5 ? 'success' : 
                                            ($customer->orders_count > 0 ? 'info' : 
                                            ($customer->created_at->diffInDays() < 7 ? 'primary' : 'secondary'));
                                $statusText = $customer->orders_count > 5 ? 'VIP' : 
                                            ($customer->orders_count > 0 ? 'Active' : 
                                            ($customer->created_at->diffInDays() < 7 ? 'New' : 'Regular'));
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration + (($customers->currentPage() - 1) * $customers->perPage()) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar mr-3">
                                            @if(!empty($customer->profile_photo) && file_exists(public_path('backend/'.$customer->profile_photo)))
                                                <img src="{{ asset('backend/'.$customer->profile_photo) }}"
                                                    class="rounded-circle"
                                                    alt="{{ $customer->name }}"
                                                    width="40"
                                                    height="40">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=3B82F6&color=fff&size=40" 
                                                class="rounded-circle" 
                                                alt="{{ $customer->name }}">

                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $customer->name }}</div>
                                            <small class="text-muted">ID: CUS-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="font-weight-bold">{{ $customer->phone }}</div>
                                    <small class="text-muted">Verified</small>
                                </td>
                                <td>
                                    <div>{{ $customer->email ?? 'N/A' }}</div>
                                    @if($customer->email)
                                    <small class="text-success"><i class="las la-check-circle"></i> Verified</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-center">
                                        <div class="font-weight-bold">{{ $customer->orders_count }}</div>
                                        <small class="text-muted">orders</small>
                                    </div>
                                </td>
                                <td class="font-weight-bold text-success">
                                    Rs {{ number_format($customer->total_spent ?: 0) }}
                                </td>
                                <td>
                                    @if($customer->last_order_date)
                                        @php
                                            $lastOrderDays = \Carbon\Carbon::parse($customer->last_order_date)->diffInDays();
                                        @endphp
                                        @if($lastOrderDays < 7)
                                        <span class="badge badge-success">{{ \Carbon\Carbon::parse($customer->last_order_date)->format('d M') }}</span>
                                        @else
                                        <span class="text-muted">{{ \Carbon\Carbon::parse($customer->last_order_date)->format('d M, Y') }}</span>
                                        @endif
                                    @else
                                    <span class="text-muted">No orders yet</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $statusColor }}">{{ $statusText }}</span>
                                </td>
                                <td>
                                    <div class="dropdown table-dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                            <i class="las la-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('customers.show', $customer->id) }}">
                                                <i class="las la-eye mr-2"></i> View Profile
                                            </a>
                                            <a class="dropdown-item" href="{{ route('customers.edit', $customer->id) }}">
                                                <i class="las la-edit mr-2"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="{{ route('orders.create') }}?customer={{ $customer->id }}">
                                                <i class="las la-plus-circle mr-2"></i> New Order
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#" onclick="sendMessage({{ $customer->id }})">
                                                <i class="las la-envelope mr-2"></i> Send Message
                                            </a>
                                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete(event)">
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

                    <!-- Pagination -->
                    @if($customers->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }} entries
                        </div>
                        <div>
                            {{ $customers->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Customers Widget -->
        <!-- <div class="row mt-4">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Top Customers by Spending</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Orders</th>
                                        <th>Total Spent</th>
                                        <th>Avg. Order Value</th>
                                        <th>Last Order</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i = 1; $i <= 5; $i++)
                                    @php
                                        $orders = rand(8, 15);
                                        $total = $orders * rand(5000, 12000);
                                        $avg = round($total / $orders, 2);
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm mr-2">
                                                    <span class="avatar-title rounded-circle bg-primary text-white">
                                                        T{{ $i }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">Top Customer {{ $i }}</div>
                                                    <small class="text-muted">VIP Member</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $orders }}</td>
                                        <td class="font-weight-bold text-success">Rs {{ number_format($total) }}</td>
                                        <td>Rs {{ number_format($avg) }}</td>
                                        <td><span class="badge badge-success">{{ now()->subDays(rand(1, 7))->format('d M') }}</span></td>
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
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('customers.create') }}" class="list-group-item list-group-item-action">
                                <i class="las la-user-plus mr-2 text-primary"></i>
                                Add New Customer
                            </a>
                            <a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#importModal">
                                <i class="las la-file-import mr-2 text-info"></i>
                                Import Customers
                            </a>
                            <a href="#" class="list-group-item list-group-item-action" onclick="sendBulkMessage()">
                                <i class="las la-envelope mr-2 text-success"></i>
                                Send Bulk Message
                            </a>
                            <a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#reportModal">
                                <i class="las la-chart-pie mr-2 text-warning"></i>
                                Generate Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Customers</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="importForm">
                        <div class="form-group">
                            <label>Select File</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customerFile" accept=".csv,.xlsx,.xls">
                                <label class="custom-file-label" for="customerFile">Choose file</label>
                            </div>
                            <small class="form-text text-muted">Supports CSV, Excel files. <a href="#">Download template</a></small>
                        </div>
                        <div class="form-group">
                            <label>Import Type</label>
                            <select class="form-control" id="importType">
                                <option value="new">Only New Customers</option>
                                <option value="update">Update Existing Customers</option>
                                <option value="both">Import All</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="importCustomers()">
                        <i class="las la-upload mr-1"></i> Import
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Modal -->
    <div class="modal fade" id="reportModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate Customer Report</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="reportForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Report Type</label>
                                <select class="form-control" id="reportType">
                                    <option value="customer_list">Customer List</option>
                                    <option value="customer_orders">Customer Orders Summary</option>
                                    <option value="customer_spending">Customer Spending Analysis</option>
                                    <option value="new_customers">New Customers Report</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Date Range</label>
                                <input type="text" class="form-control" id="reportDateRange" placeholder="Select date range">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Format</label>
                                <select class="form-control" id="reportFormat">
                                    <option value="pdf">PDF</option>
                                    <option value="excel">Excel</option>
                                    <option value="csv">CSV</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Include</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeContact" checked>
                                    <label class="form-check-label" for="includeContact">Contact Details</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeOrders" checked>
                                    <label class="form-check-label" for="includeOrders">Order History</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="generateReport()">
                        <i class="las la-download mr-1"></i> Generate
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
            var table = $('#customersTable').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                    '<"row"<"col-sm-12"tr>>' +
                    '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search customers..."
                }
            });

            // Custom search
            $('#customerSearch').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Filter by status
            $('#filterStatus').change(function() {
                table.column(7).search(this.value).draw();
            });

            // Filter by branch
            $('#filterBranch').change(function() {
                // In real app: AJAX call to filter by branch
                console.log('Filter by branch:', this.value);
            });

            // File input label
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

            // Date range picker for report
            $('#reportDateRange').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')]
                },
                startDate: moment().subtract(30, 'days'),
                endDate: moment()
            });
        });

        function sendMessage(customerId) {
            alert('Opening message composer for customer ID: ' + customerId);
            // In real app: Open message modal or SMS composer
        }

        function deleteCustomer(customerId) {
            if (confirm('Are you sure you want to delete this customer? This action cannot be undone.')) {
                console.log('Deleting customer:', customerId);
                alert('Customer deleted successfully!');
                // In real app: AJAX call to delete customer
            }
        }

        function sendBulkMessage() {
            alert('Opening bulk message composer...');
            // In real app: Open bulk message modal
        }

        function importCustomers() {
            const file = $('#customerFile')[0].files[0];
            if (!file) {
                alert('Please select a file to import');
                return;
            }

            const importType = $('#importType').val();
            console.log('Importing file:', file.name, 'Type:', importType);

            // Simulate import
            $('#importModal').modal('hide');
            alert('Importing customers... This may take a moment.');

            setTimeout(() => {
                alert('Import completed successfully!');
            }, 2000);
        }

        function generateReport() {
            const reportType = $('#reportType').val();
            const format = $('#reportFormat').val();

            alert('Generating ' + reportType + ' report in ' + format.toUpperCase() + ' format...');
            // In real app: Generate and download report
            $('#reportModal').modal('hide');
        }

        function exportCustomers(format) {
            alert('Exporting customers data in ' + format.toUpperCase() + ' format...');
            // In real app: Generate and download export file
        }
    </script>
    <script>
        $(document).on('shown.bs.dropdown', '.table-dropdown', function () {
            let $dropdown = $(this).find('.dropdown-menu');
            $('body').append($dropdown.detach());

            let offset = $(this).offset();
            let height = $(this).outerHeight();

            $dropdown.css({
                position: 'absolute',
                top: offset.top + height,
                left: offset.left,
                display: 'block'
            });
        });

        $(document).on('hidden.bs.dropdown', '.table-dropdown', function () {
            let $dropdown = $('body').find('.dropdown-menu');
            $(this).append($dropdown.detach());
            $dropdown.removeAttr('style');
        });
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

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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

        .custom-file-label::after {
            content: "Browse";
        }
    </style>
    @endpush
</x-app-layout>