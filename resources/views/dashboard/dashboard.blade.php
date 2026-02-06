<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/chart.js/Chart.min.css') }}">
    @endpush

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-3">Dashboard Overview</h4>
                <p class="mb-0">Welcome back! Here's what's happening with your business today.</p>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex">
                <div class="mr-3">
                    <select class="form-control form-control-sm" id="branchFilter">
                        <option value="">All Branches</option>
                        <option value="1" selected>Main Store</option>
                        <option value="2">Warehouse</option>
                        <option value="3">Outlet 1</option>
                    </select>
                </div>
                <div>
                    <select class="form-control form-control-sm" id="dateRange">
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="this_week" selected>This Week</option>
                        <option value="last_week">Last Week</option>
                        <option value="this_month">This Month</option>
                        <option value="last_month">Last Month</option>
                        <option value="this_year">This Year</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Today's Sales</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">₹ 45,680</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 12.5%</span>
                                    <span>from yesterday</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-shopping-cart fa-2x text-primary"></i>
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
                                    Total Orders</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">128</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 8.2%</span>
                                    <span>from yesterday</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-file-invoice-dollar fa-2x text-success"></i>
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
                                    New Customers</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">24</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 5.7%</span>
                                    <span>this week</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-user-plus fa-2x text-info"></i>
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
                                    Low Stock Items</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-8">18</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-danger mr-2"><i class="fa fa-arrow-up"></i> 3.2%</span>
                                    <span>needs attention</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-exclamation-triangle fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Widgets Row -->
        <div class="row">
            <!-- Sales Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Sales Overview</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Options:</div>
                                <a class="dropdown-item" href="#" onclick="exportChart()">Export Chart</a>
                                <a class="dropdown-item" href="#" onclick="toggleChartType()">Toggle Chart Type</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">View Full Report</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            ('dashboard.charts.sales-chart')
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Transactions</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="recentTransactions" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Invoice #</th>
                                        <th>Customer</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>INV-2024-00125</td>
                                        <td>John Doe</td>
                                        <td>Today, 10:30 AM</td>
                                        <td>₹ 5,450</td>
                                        <td><span class="badge badge-success">Paid</span></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="las la-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>INV-2024-00124</td>
                                        <td>Jane Smith</td>
                                        <td>Today, 9:15 AM</td>
                                        <td>₹ 8,920</td>
                                        <td><span class="badge badge-success">Paid</span></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="las la-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>INV-2024-00123</td>
                                        <td>Robert Johnson</td>
                                        <td>Yesterday, 4:45 PM</td>
                                        <td>₹ 12,350</td>
                                        <td><span class="badge badge-warning">Pending</span></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="las la-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>INV-2024-00122</td>
                                        <td>Sarah Williams</td>
                                        <td>Yesterday, 2:20 PM</td>
                                        <td>₹ 3,250</td>
                                        <td><span class="badge badge-success">Paid</span></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="las la-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column Widgets -->
            <div class="col-xl-4 col-lg-5">
                <!-- Top Products -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Top Selling Products</h6>
                    </div>
                    <div class="card-body">
                        ('dashboard.widgets.top-products')
                    </div>
                </div>

                <!-- Low Stock Widget -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">Low Stock Alert</h6>
                    </div>
                    <div class="card-body">
                        ('dashboard.widgets.low-stock')
                    </div>
                </div>

                <!-- Sales Summary Widget -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Sales Summary</h6>
                    </div>
                    <div class="card-body">
                        ('dashboard.widgets.sales-summary')
                    </div>
                </div>

                <!-- Inventory Chart -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Inventory Status</h6>
                    </div>
                    <div class="card-body">
                        ('dashboard.charts.inventory-chart')
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Statistics</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3 col-6 mb-3">
                                <div class="border rounded p-3">
                                    <div class="text-muted">Avg. Order Value</div>
                                    <div class="h4 font-weight-bold">₹ 3,560</div>
                                    <small class="text-success"><i class="las la-arrow-up"></i> 4.5% increase</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="border rounded p-3">
                                    <div class="text-muted">Conversion Rate</div>
                                    <div class="h4 font-weight-bold">42.5%</div>
                                    <small class="text-success"><i class="las la-arrow-up"></i> 2.3% increase</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="border rounded p-3">
                                    <div class="text-muted">Inventory Value</div>
                                    <div class="h4 font-weight-bold">₹ 245,800</div>
                                    <small class="text-info">1825 items in stock</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="border rounded p-3">
                                    <div class="text-muted">Customer Retention</div>
                                    <div class="h4 font-weight-bold">78.3%</div>
                                    <small class="text-success"><i class="las la-arrow-up"></i> 5.1% increase</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
    
    <!-- Chart.js -->
    <script src="{{ asset('backend/assets/vendor/chart.js/Chart.min.js') }}"></script>
    
    <!-- app JavaScript -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    
    <!-- Dashboard Charts -->
    <script>
        $(document).ready(function() {
            // Initialize date range filter
            $('#dateRange').change(function() {
                loadDashboardData($(this).val(), $('#branchFilter').val());
            });
            
            // Initialize branch filter
            $('#branchFilter').change(function() {
                loadDashboardData($('#dateRange').val(), $(this).val());
            });
            
            // Load initial data
            loadDashboardData('this_week', '1');
        });
        
        function loadDashboardData(dateRange, branchId) {
            // Show loading
            $('.chart-area').html('<div class="text-center py-5"><i class="las la-spinner la-spin fa-2x text-primary"></i><p class="mt-2">Loading data...</p></div>');
            
            // Simulate API call
            // setTimeout(() => {
            //     console.log('Loading data for:', { dateRange, branchId });
            //     // In real app, you would fetch data via AJAX and update charts
            //     alert('Dashboard data refreshed for ' + dateRange + ' and branch ' + branchId);
                
            //     // Reload chart components
            //     $('.chart-area').load('#?range=' + dateRange + '&branch=' + branchId);
            // }, 1000);
        }
        
        function exportChart() {
            // Implement chart export functionality
            alert('Chart exported successfully!');
        }
        
        function toggleChartType() {
            // Implement chart type toggling
            alert('Chart type toggled!');
        }
        
        // Real-time updates simulation
        setInterval(() => {
            // Update some dynamic values
            const salesElement = $('.card:first .h5').first();
            const currentSales = parseInt(salesElement.text().replace(/[^0-9]/g, ''));
            const randomIncrement = Math.floor(Math.random() * 500) + 100;
            const newSales = currentSales + randomIncrement;
            salesElement.text('₹ ' + newSales.toLocaleString());
        }, 30000); // Update every 30 seconds
    </script>
    @endpush
</x-app-layout>