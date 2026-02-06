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
                <h4 class="mb-3">Tailor Shop Dashboard</h4>
                <p class="mb-0">Welcome back! Here's what's happening in your tailor shop today.</p>
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
                        <option value="1" selected>Main Shop</option>
                        <option value="2">Downtown Branch</option>
                        <option value="3">Mall Outlet</option>
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

        <!-- Summary Cards for Tailor Shop -->
        <div class="row">
            <!-- Today's Orders -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Today's Orders</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rs 12,850</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 8.5%</span>
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

            <!-- Pending Orders -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending Orders</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">24</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-danger mr-2"><i class="fa fa-clock"></i> </span>
                                    <span>Need attention</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-clock fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Tailors -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Active Tailors</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">15/18</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2"><i class="fa fa-user-check"></i> 83%</span>
                                    <span>Availability</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-user-secret fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fabric Inventory Value -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Fabric Inventory</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-8">Rs 85,420</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-info mr-2"><i class="fa fa-boxes"></i></span>
                                    <span>in stock</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-layer-group fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Widgets Row -->
        <div class="row">
            <!-- Orders & Revenue Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Orders & Revenue Trends</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Options:</div>
                                <a class="dropdown-item" href="#" onclick="exportChart()">Export Chart</a>
                                <a class="dropdown-item" href="#" onclick="toggleChartType()">Toggle View</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('orders.index') }}">View All Orders</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="ordersRevenueChart" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Orders</h6>
                        <a href="{{ route('orders.create') }}" class="btn btn-sm btn-primary">
                            <i class="las la-plus mr-1"></i> New Order
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="recentOrders" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Dress Type</th>
                                        <th>Delivery Date</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>TS-00125</td>
                                        <td>Mohammed Ali</td>
                                        <td>Sherwani</td>
                                        <td>Tomorrow</td>
                                        <td><span class="badge badge-warning">Stitching</span></td>
                                        <td>Rs 8,500</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="las la-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>TS-00124</td>
                                        <td>Fatima Khan</td>
                                        <td>Gown</td>
                                        <td>Dec 28</td>
                                        <td><span class="badge badge-info">Measurements</span></td>
                                        <td>Rs 12,000</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="las la-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>TS-00123</td>
                                        <td>Ahmed Raza</td>
                                        <td>Suit</td>
                                        <td>Today</td>
                                        <td><span class="badge badge-success">Ready</span></td>
                                        <td>Rs 5,800</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="las la-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>TS-00122</td>
                                        <td>Sara Ahmed</td>
                                        <td>Lehenga</td>
                                        <td>Dec 30</td>
                                        <td><span class="badge badge-primary">Cutting</span></td>
                                        <td>Rs 18,500</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="las la-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>TS-00121</td>
                                        <td>John Smith</td>
                                        <td>Shirt & Trouser</td>
                                        <td>Dec 25</td>
                                        <td><span class="badge badge-secondary">Pending</span></td>
                                        <td>Rs 3,200</td>
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
                <!-- Tailor Performance -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tailor Performance</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Tailor #1</span>
                                <span>8/10 orders</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 80%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Tailor #2</span>
                                <span>7/10 orders</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 70%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Tailor #3</span>
                                <span>9/10 orders</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 90%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Tailor #4</span>
                                <span>6/10 orders</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 60%"></div>
                            </div>
                        </div>
                        <a href="{{ route('tailors.index') }}" class="btn btn-sm btn-outline-primary btn-block mt-2">
                            View All Tailors
                        </a>
                    </div>
                </div>

                <!-- Upcoming Deliveries -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">Upcoming Deliveries</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h6 class="mb-1">TS-00123</h6>
                                    <small class="text-muted">Ahmed Raza - Suit</small>
                                </div>
                                <span class="badge badge-success badge-pill">Today</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h6 class="mb-1">TS-00125</h6>
                                    <small class="text-muted">Mohammed Ali - Sherwani</small>
                                </div>
                                <span class="badge badge-warning badge-pill">Tomorrow</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h6 class="mb-1">TS-00120</h6>
                                    <small class="text-muted">Fatima Bibi - Abaya</small>
                                </div>
                                <span class="badge badge-info badge-pill">Dec 24</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h6 class="mb-1">TS-00118</h6>
                                    <small class="text-muted">Raza Ali - Kurta</small>
                                </div>
                                <span class="badge badge-secondary badge-pill">Dec 25</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fabric Status -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Fabric Status</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="fabricChart" height="200"></canvas>
                        <div class="row text-center mt-3">
                            <div class="col-4">
                                <div class="text-primary">Silk</div>
                                <div class="font-weight-bold">45 m</div>
                            </div>
                            <div class="col-4">
                                <div class="text-success">Cotton</div>
                                <div class="font-weight-bold">120 m</div>
                            </div>
                            <div class="col-4">
                                <div class="text-warning">Linen</div>
                                <div class="font-weight-bold">65 m</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <a href="{{ route('orders.create') }}" class="btn btn-primary btn-block">
                                    <i class="las la-plus-circle mr-1"></i> New Order
                                </a>
                            </div>
                            <div class="col-6 mb-3">
                                <a href="{{ route('customers.create') }}" class="btn btn-success btn-block">
                                    <i class="las la-user-plus mr-1"></i> Add Customer
                                </a>
                            </div>
                            <div class="col-6 mb-3">
                                <a href="{{ route('payments.create') }}" class="btn btn-info btn-block">
                                    <i class="las la-money-bill-wave mr-1"></i> Receive Payment
                                </a>
                            </div>
                            <div class="col-6 mb-3">
                                <a href="{{ route('fabrics.create') }}" class="btn btn-warning btn-block">
                                    <i class="las la-layer-group mr-1"></i> Add Fabric
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Statistics Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Business Insights</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3 col-6 mb-3">
                                <div class="border rounded p-3">
                                    <div class="text-muted">Avg. Stitching Time</div>
                                    <div class="h4 font-weight-bold">3.2 days</div>
                                    <small class="text-success"><i class="las la-arrow-down"></i> 0.5 days faster</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="border rounded p-3">
                                    <div class="text-muted">Customer Satisfaction</div>
                                    <div class="h4 font-weight-bold">94.5%</div>
                                    <small class="text-success"><i class="las la-arrow-up"></i> 2.3% increase</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="border rounded p-3">
                                    <div class="text-muted">Order Completion Rate</div>
                                    <div class="h4 font-weight-bold">88.7%</div>
                                    <small class="text-warning"><i class="las la-exclamation-circle"></i> On time</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="border rounded p-3">
                                    <div class="text-muted">Repeat Customers</div>
                                    <div class="h4 font-weight-bold">65.8%</div>
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
            
            // Initialize charts
            initializeCharts();
        });
        
        function initializeCharts() {
            // Orders & Revenue Chart
            const ordersRevenueCtx = document.getElementById('ordersRevenueChart').getContext('2d');
            const ordersRevenueChart = new Chart(ordersRevenueCtx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Orders',
                        data: [12, 19, 15, 25, 22, 30, 18],
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        fill: true
                    }, {
                        label: 'Revenue (Rs)',
                        data: [25000, 32000, 28000, 42000, 38000, 50000, 30000],
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rs' + value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.datasetIndex === 1) {
                                        label += 'Rs' + context.parsed.y.toLocaleString();
                                    } else {
                                        label += context.parsed.y;
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
            
            // Fabric Chart
            const fabricCtx = document.getElementById('fabricChart').getContext('2d');
            const fabricChart = new Chart(fabricCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Silk', 'Cotton', 'Linen', 'Wool', 'Polyester'],
                    datasets: [{
                        data: [45, 120, 65, 35, 85],
                        backgroundColor: [
                            '#3B82F6',
                            '#10B981',
                            '#F59E0B',
                            '#8B5CF6',
                            '#EF4444'
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
        
        function loadDashboardData(dateRange, branchId) {
            // Show loading
            $('.chart-area').html('<div class="text-center py-5"><i class="las la-spinner la-spin fa-2x text-primary"></i><p class="mt-2">Loading dashboard data...</p></div>');
            
            // Simulate API call
            setTimeout(() => {
                console.log('Loading data for:', { dateRange, branchId });
                // In real app, you would fetch data via AJAX and update charts
                
                // Reload charts with new data
                initializeCharts();
            }, 1000);
        }
        
        function exportChart() {
            // Implement chart export functionality
            alert('Chart exported successfully!');
        }
        
        function toggleChartType() {
            // Implement chart type toggling
            alert('Chart view toggled!');
        }
        
        // Real-time updates simulation for tailor shop
        setInterval(() => {
            // Update order count
            const ordersElement = $('.card:nth-child(2) .h5').first();
            const currentOrders = parseInt(ordersElement.text());
            const randomChange = Math.floor(Math.random() * 3) - 1; // -1, 0, or 1
            const newOrders = Math.max(0, currentOrders + randomChange);
            ordersElement.text(newOrders);
            
            // Update fabric inventory value
            const fabricElement = $('.card:last .h5').first();
            const currentFabric = parseInt(fabricElement.text().replace(/[^0-9]/g, ''));
            const fabricChange = Math.floor(Math.random() * 1000) - 500;
            const newFabric = Math.max(0, currentFabric + fabricChange);
            fabricElement.text('Rs ' + newFabric.toLocaleString());
        }, 45000); // Update every 45 seconds
    </script>
    @endpush
</x-app-layout>