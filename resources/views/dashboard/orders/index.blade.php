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
                <div>
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="las la-filter"></i> Filter
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('orders.pending') }}">Pending</a>
                        <a class="dropdown-item" href="{{ route('orders.in-progress') }}">In Progress</a>
                        <a class="dropdown-item" href="{{ route('orders.completed') }}">Completed</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('orders.index') }}">All Orders</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Orders</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">245</div>
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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">24</div>
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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">203</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Orders List</h6>
                <div>
                    <button class="btn btn-sm btn-outline-secondary mr-2" onclick="exportOrders()">
                        <i class="las la-download"></i> Export
                    </button>
                    <button class="btn btn-sm btn-outline-info" onclick="printOrders()">
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
                                <th>Tailor</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 1; $i <= 10; $i++)
                                <tr>
                                <td>TS-00{{ 125 + $i }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm mr-2">
                                            <span class="avatar-title rounded-circle bg-primary text-white">
                                                {{ substr('Customer ' . $i, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">Customer {{ $i }}</div>
                                            <small class="text-muted">+92 300 123456{{ $i }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php $types = ['Sherwani', 'Suit', 'Kurta', 'Shalwar Kameez', 'Gown', 'Lehenga']; @endphp
                                    {{ $types[$i % 6] }}
                                </td>
                                <td>{{ now()->subDays($i)->format('d M, Y') }}</td>
                                <td>
                                    @if($i % 3 == 0)
                                    <span class="badge badge-danger">{{ now()->addDays(1)->format('d M') }}</span>
                                    @else
                                    {{ now()->addDays($i + 3)->format('d M, Y') }}
                                    @endif
                                </td>
                                <td class="font-weight-bold">
                                    Rs{{ number_format(5000 + ($i * 1500)) }}
                                </td>
                                <td>
                                    @php
                                    $statuses = [
                                    ['badge' => 'warning', 'text' => 'Pending'],
                                    ['badge' => 'info', 'text' => 'Measurements'],
                                    ['badge' => 'primary', 'text' => 'Cutting'],
                                    ['badge' => 'secondary', 'text' => 'Stitching'],
                                    ['badge' => 'success', 'text' => 'Ready'],
                                    ['badge' => 'dark', 'text' => 'Delivered']
                                    ];
                                    $status = $statuses[$i % 6];
                                    @endphp
                                    <span class="badge badge-{{ $status['badge'] }}">{{ $status['text'] }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xs mr-2">
                                            <span class="avatar-title rounded-circle bg-info text-white">
                                                T{{ $i }}
                                            </span>
                                        </div>
                                        <span>Tailor {{ $i }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('orders.show', ['id' => $i]) }}" class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="las la-eye"></i>
                                        </a>
                                        <a href="{{ route('orders.edit', ['id' => $i]) }}" class="btn btn-sm btn-outline-info" title="Edit">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger" title="Delete" onclick="deleteOrder({{ $i }})">
                                            <i class="las la-trash"></i>
                                        </button>
                                    </div>
                                </td>
                                </tr>
                                @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Orders Summary -->
        <div class="row mt-4">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Orders by Status</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="ordersChart" height="150"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Activities</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @for($i = 1; $i <= 5; $i++)
                                <div class="list-group-item list-group-item-action border-0 px-0 py-2">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm mr-3">
                                        <span class="avatar-title rounded-circle bg-info text-white">
                                            {{ substr('Customer ' . $i, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="font-weight-bold">Order TS-00{{ 130 + $i }} updated</div>
                                        <small class="text-muted">{{ now()->subHours($i)->diffForHumans() }}</small>
                                    </div>
                                    <span class="badge badge-{{ $i % 2 == 0 ? 'success' : 'warning' }}">{{ $i % 2 == 0 ? 'Completed' : 'In Progress' }}</span>
                                </div>
                        </div>
                        @endfor
                    </div>
                </div>
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
        $(document).ready(function() {
            // Initialize DataTable
            $('#ordersTable').DataTable({
                pageLength: 10,
                order: [
                    [3, 'desc']
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search orders..."
                }
            });

            // Initialize orders chart
            initOrdersChart();
        });

        function initOrdersChart() {
            const ctx = document.getElementById('ordersChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'In Progress', 'Completed', 'Delivered'],
                    datasets: [{
                        data: [24, 18, 203, 156],
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
                        }
                    }
                }
            });
        }

        function deleteOrder(orderId) {
            if (confirm('Are you sure you want to delete this order?')) {
                alert('Order deleted successfully!');
                // In real app: AJAX call to delete order
            }
        }

        function exportOrders() {
            alert('Exporting orders data...');
            // In real app: Generate and download export
        }

        function printOrders() {
            window.print();
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

        @media print {

            .btn,
            .d-flex.align-items-center.justify-content-between,
            .row.mb-4 {
                display: none !important;
            }
        }
    </style>
    @endpush
</x-app-layout>