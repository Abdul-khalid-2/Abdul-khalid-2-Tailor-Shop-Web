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
                <h4 class="mb-3">Pending Orders</h4>
                <p class="mb-0">Orders waiting for processing or assignment</p>
            </div>
            <div>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary mr-2">
                    <i class="las la-arrow-left"></i> All Orders
                </a>
                <a href="{{ route('orders.create') }}" class="btn btn-primary">
                    <i class="las la-plus-circle"></i> New Order
                </a>
            </div>
        </div>

        <!-- Pending Orders Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    Awaiting Measurements</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-ruler-combined fa-2x text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Fabric Selection</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-layer-group fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Tailor Assignment</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">6</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-user-secret fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Overdue Start</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-exclamation-circle fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Orders Table -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-warning">Pending Orders List</h6>
                <div>
                    <button class="btn btn-sm btn-outline-warning" onclick="assignMultiple()">
                        <i class="las la-user-plus"></i> Assign Multiple
                    </button>
                    <button class="btn btn-sm btn-outline-primary" onclick="sendReminders()">
                        <i class="las la-bell"></i> Send Reminders
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="pendingOrdersTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="50">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Days Pending</th>
                                <th>Status</th>
                                <th>Required Action</th>
                                <th>Assigned To</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 1; $i <= 8; $i++)
                            @php
                                $statuses = [
                                    ['text' => 'Awaiting Measurements', 'color' => 'secondary', 'action' => 'Take Measurements'],
                                    ['text' => 'Fabric Selection', 'color' => 'info', 'action' => 'Select Fabric'],
                                    ['text' => 'Tailor Assignment', 'color' => 'warning', 'action' => 'Assign Tailor'],
                                    ['text' => 'Payment Pending', 'color' => 'danger', 'action' => 'Collect Payment']
                                ];
                                $status = $statuses[$i % 4];
                                $days = [1, 2, 3, 4, 5, 6, 7][$i % 7];
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" class="orderCheckbox" value="{{ $i }}">
                                </td>
                                <td>TS-00{{ 130 + $i }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm mr-2">
                                            <span class="avatar-title rounded-circle bg-primary text-white">
                                                C{{ $i }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">Customer {{ $i }}</div>
                                            <small class="text-muted">Ordered: {{ now()->subDays($days)->format('d M') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $days > 3 ? 'danger' : 'warning' }}">
                                        {{ $days }} day{{ $days > 1 ? 's' : '' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $status['color'] }}">{{ $status['text'] }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-{{ $status['color'] }}" onclick="takeAction({{ $i }})">
                                        <i class="las la-forward"></i> {{ $status['action'] }}
                                    </button>
                                </td>
                                <td>
                                    @if($i % 3 == 0)
                                    <span class="text-muted">Not Assigned</span>
                                    @else
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xs mr-2">
                                            <span class="avatar-title rounded-circle bg-info text-white">
                                                T{{ $i }}
                                            </span>
                                        </div>
                                        <span>Tailor {{ $i }}</span>
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('orders.show', ['id' => $i]) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="las la-eye"></i>
                                        </a>
                                        <a href="{{ route('orders.edit', ['id' => $i]) }}" class="btn btn-sm btn-outline-info">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-success" onclick="markInProgress({{ $i }})">
                                            <i class="las la-play"></i>
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
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#pendingOrdersTable').DataTable({
                pageLength: 10,
                order: [[3, 'desc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search pending orders..."
                }
            });
            
            // Select all checkbox
            $('#selectAll').click(function() {
                $('.orderCheckbox').prop('checked', this.checked);
            });
        });
        
        function takeAction(orderId) {
            alert('Taking action on order #TS-' + orderId);
            // In real app: window.location.href = `/orders/${orderId}/process`;
        }
        
        function markInProgress(orderId) {
            if (confirm('Mark this order as In Progress?')) {
                console.log('Order marked in progress:', orderId);
                // In real app: AJAX call to update status
                alert('Order marked as In Progress!');
            }
        }
        
        function assignMultiple() {
            const selected = $('.orderCheckbox:checked');
            if (selected.length === 0) {
                alert('Please select orders to assign');
                return;
            }
            const ids = selected.map(function() {
                return $(this).val();
            }).get();
            alert('Assigning ' + ids.length + ' orders to tailor...');
            // In real app: Open assign modal with selected IDs
        }
        
        function sendReminders() {
            alert('Reminders sent to customers for pending orders!');
        }
    </script>
    @endpush
</x-app-layout>