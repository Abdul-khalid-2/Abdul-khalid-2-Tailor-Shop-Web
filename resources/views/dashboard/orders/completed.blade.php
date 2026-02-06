<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/datatables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/daterangepicker/daterangepicker.css') }}">
    @endpush

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-3">Completed Orders</h4>
                <p class="mb-0">Orders that have been delivered to customers</p>
            </div>
            <div class="d-flex">
                <div class="mr-3">
                    <input type="text" class="form-control form-control-sm" id="dateRangePicker" placeholder="Select date range">
                </div>
                <div>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                        <i class="las la-arrow-left"></i> All Orders
                    </a>
                </div>
            </div>
        </div>

        <!-- Completed Stats -->
        <div class="row mb-4">
            <div class="col-md-3 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    This Month</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">48</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 12.5%</span>
                                    <span>from last month</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-calendar-check fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Revenue</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rs 245,800</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 8.2%</span>
                                    <span>growth</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-rupee-sign fa-2x text-primary"></i>
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
                                    Avg. Completion Time</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">4.2 days</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2"><i class="fa fa-arrow-down"></i> 0.8 days</span>
                                    <span>faster</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-clock fa-2x text-info"></i>
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
                                    Top Tailor</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Tailor #3</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2">12 orders</span>
                                    <span>completed</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-crown fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Orders Table -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-success">Completed Orders</h6>
                <div>
                    <button class="btn btn-sm btn-outline-success mr-2" onclick="exportCompletedOrders()">
                        <i class="las la-file-export"></i> Export
                    </button>
                    <button class="btn btn-sm btn-outline-primary" onclick="generateInvoice()">
                        <i class="las la-file-invoice"></i> Generate Invoice
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="completedOrdersTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Dress Type</th>
                                <th>Order Date</th>
                                <th>Delivery Date</th>
                                <th>Tailor</th>
                                <th>Amount</th>
                                <th>Rating</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 1; $i <= 12; $i++)
                                @php
                                $deliveryDate=now()->subDays(rand(1, 30));
                                $orderDate = $deliveryDate->copy()->subDays(rand(3, 7));
                                $rating = rand(4, 5);
                                @endphp
                                <tr>
                                    <td>TS-00{{ 150 + $i }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm mr-2">
                                                <span class="avatar-title rounded-circle bg-info text-white">
                                                    C{{ $i }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="font-weight-bold">Customer {{ $i }}</div>
                                                <small class="text-muted">Delivered {{ $deliveryDate->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php $types = ['Sherwani', 'Suit', 'Kurta', 'Gown', 'Lehenga']; @endphp
                                        {{ $types[$i % 5] }}
                                    </td>
                                    <td>{{ $orderDate->format('d M, Y') }}</td>
                                    <td>
                                        <span class="badge badge-success">{{ $deliveryDate->format('d M, Y') }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs mr-2">
                                                <span class="avatar-title rounded-circle bg-primary text-white">
                                                    T{{ $i % 4 + 1 }}
                                                </span>
                                            </div>
                                            <span>Tailor {{ $i % 4 + 1 }}</span>
                                        </div>
                                    </td>
                                    <td class="font-weight-bold text-success">
                                        Rs {{ number_format(3000 + ($i * 1200)) }}
                                    </td>
                                    <td>
                                        <div class="star-rating">
                                            @for($j = 1; $j <= 5; $j++)
                                                <i class="las la-star {{ $j <= $rating ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                        </div>
                                        <small class="text-muted">{{ $rating }}.0</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('orders.show', ['id' => $i]) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="las la-eye"></i> View
                                            </a>
                                            <button class="btn btn-sm btn-outline-info" onclick="printReceipt({{ $i }})">
                                                <i class="las la-print"></i> Receipt
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary" onclick="repeatOrder({{ $i }})">
                                                <i class="las la-redo"></i> Repeat
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
    <script src="{{ asset('backend/assets/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/daterangepicker/daterangepicker.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#completedOrdersTable').DataTable({
                pageLength: 10,
                order: [
                    [4, 'desc']
                ],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                    '<"row"<"col-sm-12"tr>>' +
                    '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
            });

            // Date range picker
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

            // Date range change handler
            $('#dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
                const start = picker.startDate.format('YYYY-MM-DD');
                const end = picker.endDate.format('YYYY-MM-DD');
                console.log('Filtering orders from', start, 'to', end);
                // In real app: AJAX call to filter orders
            });
        });

        function exportCompletedOrders() {
            alert('Exporting completed orders report...');
            // In real app: Generate and download report
        }

        function generateInvoice() {
            alert('Generating invoice for selected orders...');
            // In real app: Show invoice generation modal
        }

        function printReceipt(orderId) {
            alert('Printing receipt for order #TS-' + orderId);
            // In real app: Open print preview
        }

        function repeatOrder(orderId) {
            if (confirm('Create a new order with same details?')) {
                alert('Creating repeat order...');
                // In real app: Duplicate order
            }
        }
    </script>
    <style>
        .star-rating {
            display: inline-block;
        }

        .star-rating .las {
            font-size: 14px;
        }
    </style>
    @endpush
</x-app-layout>