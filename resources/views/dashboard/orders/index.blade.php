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
                <h4 class="mb-3">All Orders</h4>
                <p class="mb-0">Manage and track all customer orders</p>
            </div>
            <div class="d-flex">
                <div class="mr-3">
                    <a href="{{ route('orders.create') }}" class="btn btn-primary">
                        <i class="las la-plus-circle mr-1"></i> New Order
                    </a>
                </div>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="las la-filter"></i> Filter by Status
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('orders.pending') }}">
                            <span class="badge badge-warning mr-2">●</span> Pending
                        </a>
                        <a class="dropdown-item" href="{{ route('orders.in-progress') }}">
                            <span class="badge badge-info mr-2">●</span> In Progress
                        </a>
                        <a class="dropdown-item" href="{{ route('orders.completed') }}">
                            <span class="badge badge-success mr-2">●</span> Completed
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('orders.index') }}">All Orders</a>
                    </div>
                </div>
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

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Orders</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2">{{ $stats['pending'] }} Pending</span>
                                    <span>{{ $stats['in_progress'] }} In Progress</span>
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
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span>Awaiting processing</span>
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
                                    In Progress</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['in_progress'] }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span>Being tailored</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-tasks fa-2x text-info"></i>
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
                                    Completed</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['completed'] }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span>Delivered to customers</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter and Search -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('orders.index') }}" id="filterForm">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Search</label>
                            <input type="text" class="form-control" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Search by order #, customer name or phone...">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Status</label>
                            <select class="form-control" name="status_id">
                                <option value="all" {{ request('status_id') == 'all' ? 'selected' : '' }}>All Status</option>
                                @foreach($orderStatuses as $status)
                                <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Date Range</label>
                            <input type="text" class="form-control" name="date_range" id="dateRangePicker" 
                                   value="{{ request('date_range') }}" placeholder="Select date range">
                        </div>
                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="las la-filter mr-1"></i> Filter
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                                <i class="las la-sync mr-1"></i> Reset
                            </a>
                            <a href="{{ route('orders.export') }}?{{ http_build_query(request()->query()) }}" 
                               class="btn btn-outline-success">
                                <i class="las la-download mr-1"></i> Export
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Orders List</h6>
                <div>
                    <button class="btn btn-sm btn-outline-secondary mr-2" onclick="printOrders()">
                        <i class="las la-print"></i> Print
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="ordersTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Dress Type</th>
                                <th>Order Date</th>
                                <th>Delivery Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            @php
                                $orderItem = $order->items->first();
                                $daysRemaining = \Carbon\Carbon::parse($order->delivery_date)->diffInDays(now());
                                $isUrgent = $daysRemaining <= 2 && $order->status_id != 6 && $order->status_id != 5;
                            @endphp
                            <tr class="{{ $isUrgent ? 'table-warning' : '' }}">
                                <td>
                                    <div class="font-weight-bold">{{ $order->order_number }}</div>
                                    <small class="text-muted">#{{ $order->id }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm mr-2">
                                            <span class="avatar-title rounded-circle bg-primary text-white">
                                                {{ substr($order->customer->name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $order->customer->name }}</div>
                                            <small class="text-muted">{{ $order->customer->phone }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ $orderItem?->dressType?->name ?? 'N/A' }}
                                </td>
                                <td>
                                    {{ $order->order_date->format('d M, Y') }}
                                    <div class="text-muted small">{{ $order->order_date->diffForHumans() }}</div>
                                </td>
                                <td>
                                    @if($isUrgent)
                                    <span class="badge badge-danger">
                                        {{ $order->delivery_date->format('d M') }}
                                        <i class="las la-exclamation ml-1"></i>
                                    </span>
                                    @else
                                    <span class="badge badge-{{ $order->delivery_date->isPast() ? 'secondary' : 'light' }}">
                                        {{ $order->delivery_date->format('d M, Y') }}
                                    </span>
                                    @endif
                                    @if($order->delivery_date->isFuture())
                                    <div class="text-muted small">{{ $daysRemaining }} days left</div>
                                    @endif
                                </td>
                                <td class="font-weight-bold">
                                    <div class="text-success">Rs {{ number_format($order->final_amount) }}</div>
                                    <div class="text-muted small">
                                        Adv: Rs {{ number_format($order->advance_amount) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-pill" style="background-color: {{ $order->status->color }}; color: white;">
                                        {{ $order->status->name }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-pill" style="background-color: {{ $order->paymentStatus->color }}; color: white;">
                                        {{ $order->paymentStatus->name }}
                                    </span>
                                    <div class="progress mt-1" style="height: 4px;">
                                        @php
                                            $paymentPercentage = $order->final_amount > 0 ? ($order->advance_amount / $order->final_amount) * 100 : 0;
                                        @endphp
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: {{ $paymentPercentage }}%; background-color: {{ $order->paymentStatus->color }};">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="las la-eye"></i>
                                        </a>
                                        <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-outline-info" title="Edit">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                                    data-toggle="dropdown" aria-expanded="false">
                                                <i class="las la-cog"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" onclick="updateStatus({{ $order->id }})">
                                                    <i class="las la-sync mr-2"></i> Update Status
                                                </a>
                                                <a class="dropdown-item" href="#" onclick="addPayment({{ $order->id }})">
                                                    <i class="las la-money-bill-wave mr-2"></i> Add Payment
                                                </a>
                                                <a class="dropdown-item" href="#" onclick="assignTailor({{ $order->id }})">
                                                    <i class="las la-user-tie mr-2"></i> Assign Tailor
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger" href="#" 
                                                   onclick="deleteOrder({{ $order->id }}, '{{ $order->order_number }}')">
                                                    <i class="las la-trash mr-2"></i> Delete
                                                </a>
                                            </div>
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

        <!-- Orders Summary -->
        <div class="row mt-4">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Orders by Status</h6>
                        <select class="form-control form-control-sm w-auto" id="chartPeriod">
                            <option value="month">This Month</option>
                            <option value="week">This Week</option>
                            <option value="year">This Year</option>
                        </select>
                    </div>
                    <div class="card-body">
                        <canvas id="ordersChart" height="150"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Activities</h6>
                        <small><a href="#">View All</a></small>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush" id="recentActivities">
                            <!-- Recent activities will be loaded via AJAX -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="statusForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Update Order Status</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="order_id" id="order_id">
                        <div class="form-group">
                            <label>New Status</label>
                            <select class="form-control" name="status_id" required>
                                <option value="">Select Status</option>
                                @foreach($orderStatuses as $status)
                                <option value="{{ $status->id }}" data-color="{{ $status->color }}">
                                    {{ $status->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Notes</label>
                            <textarea class="form-control" name="notes" rows="3" 
                                      placeholder="Add notes about status change..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
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
        let ordersChart;
        
        $(document).ready(function() {
            // Initialize DataTable
            $('#ordersTable').DataTable({
                pageLength: 10,
                responsive: true,
                ordering: false,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search orders..."
                }
            });

            // Initialize date range picker
            $('#dateRangePicker').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(30, 'days'),
                endDate: moment()
            });

            // Load statistics
            loadStatistics();
            loadRecentActivities();
            
            // Auto-hide alerts
            setTimeout(() => {
                $('.alert').alert('close');
            }, 5000);
        });

        function loadStatistics() {
            fetch('{{ route("orders.statistics") }}')
                .then(response => response.json())
                .then(data => {
                    initOrdersChart(data);
                })
                .catch(error => console.error('Error loading statistics:', error));
        }

        function loadRecentActivities() {
            fetch('{{ route("orders.statistics") }}')
                .then(response => response.json())
                .then(data => {
                    const activities = document.getElementById('recentActivities');
                    activities.innerHTML = '';
                    
                    data.recent_orders.forEach(order => {
                        const activity = `
                            <div class="list-group-item list-group-item-action border-0 px-0 py-2">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm mr-3">
                                        <span class="avatar-title rounded-circle" style="background-color: ${order.color}; color: white;">
                                            ${order.customer_name.charAt(0)}
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="font-weight-bold">Order ${order.order_number}</div>
                                        <small class="text-muted">${order.customer_name} • ${order.time}</small>
                                    </div>
                                    <div>
                                        <span class="badge" style="background-color: ${order.color}; color: white;">
                                            ${order.status}
                                        </span>
                                        <div class="text-success small mt-1">Rs ${order.amount.toLocaleString()}</div>
                                    </div>
                                </div>
                            </div>
                        `;
                        activities.innerHTML += activity;
                    });
                });
        }

        function initOrdersChart(data) {
            const ctx = document.getElementById('ordersChart').getContext('2d');
            
            if (ordersChart) {
                ordersChart.destroy();
            }
            
            ordersChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'In Progress', 'Completed', 'Others'],
                    datasets: [{
                        data: [
                            data.pending,
                            data.in_progress,
                            data.completed,
                            data.total - (data.pending + data.in_progress + data.completed)
                        ],
                        backgroundColor: ['#F59E0B', '#3B82F6', '#10B981', '#6B7280'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.raw + ' orders';
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }

        function updateStatus(orderId) {
            $('#order_id').val(orderId);
            $('#statusModal').modal('show');
        }

        $('#statusForm').submit(function(e) {
            e.preventDefault();
            
            const formData = $(this).serialize();
            const orderId = $('#order_id').val();
            
            $.ajax({
                url: `/orders/${orderId}/status`,
                type: 'PATCH',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert('Status updated successfully!');
                        $('#statusModal').modal('hide');
                        location.reload();
                    }
                },
                error: function(xhr) {
                    alert('Error updating status: ' + xhr.responseJSON?.message || 'Unknown error');
                }
            });
        });

        function deleteOrder(orderId, orderNumber) {
            if (confirm(`Are you sure you want to delete order ${orderNumber}? This action cannot be undone.`)) {
                $.ajax({
                    url: `/orders/${orderId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert('Order deleted successfully!');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Error deleting order: ' + xhr.responseJSON?.message || 'Unknown error');
                    }
                });
            }
        }

        function addPayment(orderId) {
            alert('Opening payment form for order #' + orderId);
            // Implement payment form modal
        }

        function assignTailor(orderId) {
            alert('Opening tailor assignment for order #' + orderId);
            // Implement tailor assignment modal
        }

        function printOrders() {
            window.print();
        }

        $('#chartPeriod').change(function() {
            loadStatistics();
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

        .avatar-xs {
            width: 24px;
            height: 24px;
            font-size: 10px;
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

        .progress {
            background-color: #e9ecef;
            border-radius: 2px;
        }

        .progress-bar {
            border-radius: 2px;
        }

        @media print {
            .btn, .d-flex.align-items-center.justify-content-between,
            .row.mb-4, .card.shadow.mb-4, .row.mt-4 {
                display: none !important;
            }
        }
    </style>
    @endpush
</x-app-layout>