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
                <h4 class="mb-3">{{ $status->name }} Orders</h4>
                <p class="mb-0">{{ $status->description ?? 'View all ' . strtolower($status->name) . ' orders' }}</p>
            </div>
            <div>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left mr-1"></i> All Orders
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-4">
                <div class="card border-left-{{ $status->slug == 'pending' ? 'warning' : ($status->slug == 'in-progress' ? 'info' : 'success') }} shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-{{ $status->slug == 'pending' ? 'warning' : ($status->slug == 'in-progress' ? 'info' : 'success') }} text-uppercase mb-1">
                                    Total {{ $status->name }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span>{{ $status->name }} orders</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-{{ $status->slug == 'pending' ? 'clock' : ($status->slug == 'in-progress' ? 'tasks' : 'check-circle') }} fa-2x text-{{ $status->slug == 'pending' ? 'warning' : ($status->slug == 'in-progress' ? 'info' : 'success') }}"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Revenue</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rs {{ number_format($stats['revenue']) }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span>From {{ $stats['total'] }} orders</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-rupee-sign fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    Average Order Value</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rs {{ number_format($stats['avg_amount'] ?? 0) }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span>Per order</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-chart-line fa-2x text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">{{ $status->name }} Orders</h6>
                <div>
                    <button class="btn btn-sm btn-outline-secondary mr-2" onclick="exportOrders()">
                        <i class="las la-download"></i> Export
                    </button>
                    @if($status->slug == 'completed')
                    <button class="btn btn-sm btn-outline-success" onclick="generateCertificates()">
                        <i class="las la-certificate"></i> Certificates
                    </button>
                    @endif
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
                                <th>Payment</th>
                                <th>Tailor</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            @php
                                $orderItem = $order->orderItems->first();
                            @endphp
                            <tr>
                                <td>
                                    <div class="font-weight-bold">{{ $order->order_number }}</div>
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
                                </td>
                                <td>
                                    <span class="badge badge-{{ $order->delivery_date->isPast() ? 'secondary' : 'light' }}">
                                        {{ $order->delivery_date->format('d M, Y') }}
                                    </span>
                                    @if($status->slug == 'pending' && $order->delivery_date->isFuture())
                                    <div class="text-muted small">{{ $order->delivery_date->diffInDays(now()) }} days left</div>
                                    @endif
                                </td>
                                <td class="font-weight-bold text-success">
                                    Rs {{ number_format($order->final_amount) }}
                                </td>
                                <td>
                                    <span class="badge" style="background-color: {{ $order->paymentStatus->color }}; color: white;">
                                        {{ $order->paymentStatus->name }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $tailorAssignment = $orderItem?->tailorAssignments->first();
                                    @endphp
                                    @if($tailorAssignment)
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xs mr-2">
                                            <span class="avatar-title rounded-circle bg-info text-white">
                                                {{ substr($tailorAssignment->tailor->name, 0, 1) }}
                                            </span>
                                        </div>
                                        <span>{{ $tailorAssignment->tailor->name }}</span>
                                    </div>
                                    @else
                                    <span class="badge badge-light">Not assigned</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="las la-eye"></i>
                                        </a>
                                        <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-outline-info">
                                            <i class="las la-edit"></i>
                                        </a>
                                        @if($status->slug == 'pending')
                                        <button class="btn btn-sm btn-outline-success" onclick="startOrder({{ $order->id }})">
                                            <i class="las la-play"></i>
                                        </button>
                                        @elseif($status->slug == 'in-progress')
                                        <button class="btn btn-sm btn-outline-success" onclick="completeOrder({{ $order->id }})">
                                            <i class="las la-check"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} entries
                        </div>
                        <div>
                            {{ $orders->links() }}
                        </div>
                    </div>
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
            $('#ordersTable').DataTable({
                pageLength: 10,
                responsive: true,
                ordering: false,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search orders..."
                }
            });
        });

        function exportOrders() {
            alert('Exporting {{ $status->name }} orders...');
        }

        function generateCertificates() {
            alert('Generating completion certificates...');
        }

        function startOrder(orderId) {
            if (confirm('Start processing this order?')) {
                $.ajax({
                    url: `/orders/${orderId}/status`,
                    type: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status_id: 3 // In Progress
                    },
                    success: function(response) {
                        alert('Order started successfully!');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON?.message);
                    }
                });
            }
        }

        function completeOrder(orderId) {
            if (confirm('Mark this order as completed?')) {
                $.ajax({
                    url: `/orders/${orderId}/status`,
                    type: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status_id: 5 // Delivered (completed)
                    },
                    success: function(response) {
                        alert('Order completed successfully!');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON?.message);
                    }
                });
            }
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
    </style>
    @endpush
</x-app-layout>