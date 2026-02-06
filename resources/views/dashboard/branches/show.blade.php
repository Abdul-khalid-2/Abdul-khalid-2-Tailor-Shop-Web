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
                <h4 class="mb-3">Branch Details</h4>
                <p class="mb-0">{{ $branch->name }} - {{ $branch->code }}</p>
            </div>
            <div>
                <a href="{{ route('branches.index') }}" class="btn btn-outline-secondary mr-2">
                    <i class="las la-arrow-left mr-1"></i> Back to Branches
                </a>
                <a href="{{ route('branches.edit', $branch) }}" class="btn btn-primary">
                    <i class="las la-edit mr-1"></i> Edit Branch
                </a>
            </div>
        </div>

        <!-- Branch Information -->
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Basic Info Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Basic Information</h6>
                        <span class="badge badge-{{ $branch->is_active ? 'success' : 'secondary' }}">
                            {{ $branch->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted">Branch Name</label>
                                <div class="font-weight-bold">{{ $branch->name }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted">Branch Code</label>
                                <div class="font-weight-bold">{{ $branch->code }}</div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted">Opening Date</label>
                                <div class="font-weight-bold">
                                    {{ $branch->opening_date ? $branch->opening_date->format('d M, Y') : 'N/A' }}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted">Created On</label>
                                <div class="font-weight-bold">{{ $branch->created_at->format('d M, Y h:i A') }}</div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <label class="text-muted">Address</label>
                                <div class="font-weight-bold">{{ $branch->address ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Info Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Contact Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted"><i class="las la-phone mr-2"></i> Phone</label>
                                <div class="font-weight-bold">{{ $branch->phone ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted"><i class="las la-envelope mr-2"></i> Email</label>
                                <div class="font-weight-bold">{{ $branch->email ?? 'N/A' }}</div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted"><i class="las la-clock mr-2"></i> Opening Time</label>
                                <div class="font-weight-bold">{{ $branch->opening_time }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted"><i class="las la-clock mr-2"></i> Closing Time</label>
                                <div class="font-weight-bold">{{ $branch->closing_time }}</div>
                            </div>
                        </div>
                        
                        @if($branch->working_days)
                        <div class="row">
                            <div class="col-md-12">
                                <label class="text-muted"><i class="las la-calendar mr-2"></i> Working Days</label>
                                <div class="font-weight-bold">
                                    @foreach($branch->working_days as $day)
                                    <span class="badge badge-light mr-1">{{ $day }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Manager Info Card -->
                @if($branch->manager_name)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Branch Manager</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar mr-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($branch->manager_name) }}&background=3B82F6&color=fff&size=60" 
                                     class="rounded-circle" 
                                     alt="{{ $branch->manager_name }}">
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $branch->manager_name }}</h5>
                                <div class="text-muted mb-2">Branch Manager</div>
                                <div class="d-flex flex-wrap">
                                    @if($branch->manager_phone)
                                    <div class="mr-3">
                                        <i class="las la-phone text-primary mr-1"></i>
                                        <span>{{ $branch->manager_phone }}</span>
                                    </div>
                                    @endif
                                    @if($branch->manager_email)
                                    <div>
                                        <i class="las la-envelope text-primary mr-1"></i>
                                        <span>{{ $branch->manager_email }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Statistics Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Branch Statistics</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span><i class="las la-users text-primary mr-2"></i> Total Users</span>
                                <span class="badge badge-primary">{{ $branch->users_count }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span><i class="las la-user-friends text-success mr-2"></i> Total Customers</span>
                                <span class="badge badge-success">{{ $branch->customers_count }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span><i class="las la-shopping-cart text-info mr-2"></i> Total Orders</span>
                                <span class="badge badge-info">{{ $branch->orders_count }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span><i class="las la-user-tie text-warning mr-2"></i> Total Tailors</span>
                                <span class="badge badge-warning">{{ $branch->tailors_count }}</span>
                            </div>
                            @if($branch->fabrics_count)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span><i class="las la-cut text-danger mr-2"></i> Total Fabrics</span>
                                <span class="badge badge-danger">{{ $branch->fabrics_count }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('settings.branch', $branch) }}" class="btn btn-outline-primary btn-block text-left">
                                <i class="las la-cog mr-2"></i> Branch Settings
                            </a>
                            <a href="{{ route('users.index') }}?branch={{ $branch->id }}" class="btn btn-outline-success btn-block text-left">
                                <i class="las la-users mr-2"></i> View Users
                            </a>
                            <a href="{{ route('customers.index') }}?branch_id={{ $branch->id }}" class="btn btn-outline-info btn-block text-left">
                                <i class="las la-user-friends mr-2"></i> View Customers
                            </a>
                            <a href="{{ route('orders.index') }}?branch_id={{ $branch->id }}" class="btn btn-outline-warning btn-block text-left">
                                <i class="las la-shopping-cart mr-2"></i> View Orders
                            </a>
                            <form action="{{ route('branches.toggle-status', $branch) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-{{ $branch->is_active ? 'danger' : 'success' }} btn-block text-left">
                                    <i class="las la-power-off mr-2"></i> 
                                    {{ $branch->is_active ? 'Deactivate Branch' : 'Activate Branch' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Audit Info -->
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Audit Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="small">
                            <div class="mb-2">
                                <label class="text-muted">Created By:</label>
                                <div>{{ $branch->createdBy->name ?? 'System' }}</div>
                            </div>
                            <div class="mb-2">
                                <label class="text-muted">Created At:</label>
                                <div>{{ $branch->created_at->format('d M, Y h:i A') }}</div>
                            </div>
                            @if($branch->updatedBy)
                            <div class="mb-2">
                                <label class="text-muted">Last Updated By:</label>
                                <div>{{ $branch->updatedBy->name }}</div>
                            </div>
                            <div>
                                <label class="text-muted">Last Updated At:</label>
                                <div>{{ $branch->updated_at->format('d M, Y h:i A') }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row mt-4">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Orders</h6>
                        <a href="{{ route('orders.index') }}?branch_id={{ $branch->id }}" class="btn btn-sm btn-outline-primary">
                            View All
                        </a>
                    </div>
                    <div class="card-body">
                        @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('orders.show', $order) }}">{{ $order->order_number }}</a>
                                        </td>
                                        <td>{{ $order->customer->name }}</td>
                                        <td class="text-success">Rs {{ number_format($order->final_amount) }}</td>
                                        <td>
                                            <span class="badge" style="background-color: {{ $order->status->color ?? '#6b7280' }}">
                                                {{ $order->status->name ?? 'Pending' }}
                                            </span>
                                        </td>
                                        <td>{{ $order->order_date->format('d M') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="las la-shopping-cart fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No orders found for this branch</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Customers</h6>
                        <a href="{{ route('customers.index') }}?branch_id={{ $branch->id }}" class="btn btn-sm btn-outline-primary">
                            View All
                        </a>
                    </div>
                    <div class="card-body">
                        @if($recentCustomers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Phone</th>
                                        <th>Orders</th>
                                        <th>Joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentCustomers as $customer)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar mr-2">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=3B82F6&color=fff&size=30" 
                                                         class="rounded-circle" 
                                                         alt="{{ $customer->name }}">
                                                </div>
                                                <div>
                                                    <div>{{ $customer->name }}</div>
                                                    <small class="text-muted">ID: CUS-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>
                                            <span class="badge badge-light">{{ $customer->orders_count }}</span>
                                        </td>
                                        <td>{{ $customer->created_at->format('d M') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="las la-user-friends fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No customers found for this branch</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow border-danger">
                    <div class="card-header py-3 bg-danger text-white">
                        <h6 class="m-0 font-weight-bold">Danger Zone</h6>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h6 class="text-danger">Delete This Branch</h6>
                                <p class="text-muted mb-0">
                                    Once you delete a branch, there is no going back. Please be certain.
                                    Note: You can only delete branches with no users, customers, or orders.
                                </p>
                            </div>
                            <div class="col-md-4 text-right">
                                <form action="{{ route('branches.destroy', $branch) }}" method="POST" onsubmit="return confirmDelete()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" 
                                            {{ $branch->users_count > 0 || $branch->customers_count > 0 || $branch->orders_count > 0 ? 'disabled' : '' }}>
                                        <i class="las la-trash mr-1"></i> Delete Branch
                                    </button>
                                </form>
                            </div>
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
        function confirmDelete() {
            return confirm('Are you sure you want to delete this branch? This action cannot be undone.');
        }
    </script>
    
    <style>
        .card {
            border-radius: 0.5rem;
        }
        .avatar {
            width: 60px;
            height: 60px;
            display: inline-flex;
        }
        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .badge {
            font-size: 0.75em;
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
        .list-group-item {
            border: none;
            padding: 0.75rem 0;
        }
        .btn {
            border-radius: 0.375rem;
        }
        .table th {
            border-top: none;
            font-weight: 600;
            color: #6c757d;
        }
        .border-danger {
            border: 1px solid #dc3545 !important;
        }
    </style>
    @endpush
</x-app-layout>