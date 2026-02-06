resources\views\dashboard\orders\index.blade.php
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
                                    ₹ {{ number_format(5000 + ($i * 1500)) }}
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
    @endpush
</x-app-layout>