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
                <h4 class="mb-3">Order Details: {{ $order->order_number }}</h4>
                <p class="mb-0">Complete order information and tracking</p>
            </div>
            <div class="d-flex">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary mr-2">
                    <i class="las la-arrow-left"></i> Back
                </a>
                <a href="{{ route('orders.edit', $order) }}" class="btn btn-outline-primary mr-2">
                    <i class="las la-edit"></i> Edit
                </a>
                <button class="btn btn-outline-success" onclick="printOrder()">
                    <i class="las la-print"></i> Print
                </button>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Order Status</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <span class="badge badge-pill" style="background-color: {{ $order->status->color }}; color: white; font-size: 1rem;">
                                                {{ $order->status->name }}
                                            </span>
                                        </div>
                                        <div class="mt-2 mb-0 text-muted text-xs">
                                            @if($order->delivery_date->isFuture())
                                                {{ $order->delivery_date->diffInDays(now()) }} days remaining
                                            @else
                                                {{ $order->delivery_date->diffForHumans() }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="las la-{{ $order->status->slug == 'pending' ? 'clock' : ($order->status->slug == 'in-progress' ? 'tasks' : 'check-circle') }} fa-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Payment Status</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <span class="badge badge-pill" style="background-color: {{ $order->paymentStatus->color }}; color: white; font-size: 1rem;">
                                                {{ $order->paymentStatus->name }}
                                            </span>
                                        </div>
                                        <div class="mt-2 mb-0 text-muted text-xs">
                                            @if($order->paymentStatus->slug == 'partial')
                                                Rs {{ number_format($order->remaining_amount) }} remaining
                                            @elseif($order->paymentStatus->slug == 'paid')
                                                Fully paid
                                            @else
                                            Pending
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="las la-rupee-sign fa-2x text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer & Order Info -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Customer & Order Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="font-weight-bold text-primary mb-3">Customer Details</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <th width="40%">Name:</th>
                                        <td>{{ $order->customer->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td>{{ $order->customer->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address:</th>
                                        <td>{{ $order->customer->address ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer Type:</th>
                                        <td>
                                            <span class="badge badge-{{ $order->customer->customer_type == 'regular' ? 'primary' : 'success' }}">
                                                {{ ucfirst($order->customer->customer_type) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Discount Rate:</th>
                                        <td>{{ $order->customer->discount_rate }}%</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="font-weight-bold text-primary mb-3">Order Details</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <th width="40%">Order Number:</th>
                                        <td class="font-weight-bold">{{ $order->order_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order Date:</th>
                                        <td>{{ $order->order_date->format('d M, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Delivery Date:</th>
                                        <td>{{ $order->delivery_date->format('d M, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Branch:</th>
                                        <td>{{ $order->branch->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order Type:</th>
                                        <td>{{ ucfirst($order->order_type) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Order Items</h6>
                        <button class="btn btn-sm btn-outline-primary" onclick="addItem()">
                            <i class="las la-plus"></i> Add Item
                        </button>
                    </div>
                    <div class="card-body">
                        @foreach($order->items as $item)
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">{{ $item->item_name }}</h6>
                                        <small class="text-muted">Item Status: 
                                            <span class="badge badge-{{ $item->item_status == 'pending' ? 'warning' : ($item->item_status == 'ready' ? 'success' : 'info') }}">
                                                {{ ucfirst($item->item_status) }}
                                            </span>
                                        </small>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-weight-bold text-success">
                                            Rs {{ number_format($item->total) }}
                                        </div>
                                        <small class="text-muted">Qty: {{ $item->quantity }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($item->dressType)
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="font-weight-bold">Dress Type Details</h6>
                                        <table class="table table-sm">
                                            <tr>
                                                <th>Dress Type:</th>
                                                <td>{{ $item->dressType->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Base Price:</th>
                                                <td>Rs {{ number_format($item->dressType->base_price) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Est. Days:</th>
                                                <td>{{ $item->dressType->estimated_days }} days</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="font-weight-bold">Tailor Assignment</h6>
                                        @if($item->tailorAssignments->count() > 0)
                                            @php
                                                $assignment = $item->tailorAssignments->first();
                                            @endphp
                                            <table class="table table-sm">
                                                <tr>
                                                    <th>Tailor:</th>
                                                    <td>{{ $assignment->tailor->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Status:</th>
                                                    <td>
                                                        <span class="badge" style="background-color: {{ $assignment->status->color }}; color: white;">
                                                            {{ $assignment->status->name }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Stitching Charge:</th>
                                                    <td>Rs {{ number_format($assignment->stitching_charge) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Progress:</th>
                                                    <td>
                                                        <div class="progress" style="height: 6px;">
                                                            <div class="progress-bar" role="progressbar" 
                                                                 style="width: {{ $assignment->progress_percentage }}%; background-color: {{ $assignment->status->color }};">
                                                            </div>
                                                        </div>
                                                        <small class="text-muted">{{ $assignment->progress_percentage }}%</small>
                                                    </td>
                                                </tr>
                                            </table>
                                        @else
                                            <div class="alert alert-warning">
                                                <i class="las la-exclamation-triangle"></i> No tailor assigned yet.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Measurements -->
                                @if($item->measurements->count() > 0)
                                <div class="mt-3">
                                    <h6 class="font-weight-bold">Measurements (cm)</h6>
                                    <div class="row">
                                        @php
                                            $measurement = $item->measurements->first();
                                            $measurementFields = [
                                                'height' => 'Height',
                                                'chest' => 'Chest',
                                                'waist' => 'Waist',
                                                'hips' => 'Hips',
                                                'shoulder' => 'Shoulder',
                                                'sleeve_length' => 'Sleeve Length',
                                                'pant_length' => 'Pant Length',
                                                'inseam' => 'Inseam',
                                            ];
                                        @endphp
                                        @foreach($measurementFields as $field => $label)
                                            @if($measurement->$field)
                                            <div class="col-md-3 mb-2">
                                                <div class="bg-light p-2 rounded">
                                                    <small class="text-muted">{{ $label }}</small>
                                                    <div class="font-weight-bold">{{ $measurement->$field }} cm</div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                
                                <!-- Instructions -->
                                @if($item->instructions)
                                <div class="mt-3">
                                    <h6 class="font-weight-bold">Special Instructions</h6>
                                    <p class="mb-0">{{ $item->instructions }}</p>
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payments -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Payment History</h6>
                        <button class="btn btn-sm btn-outline-success" onclick="addPayment()">
                            <i class="las la-money-bill-wave"></i> Add Payment
                        </button>
                    </div>
                    <div class="card-body">
                        @if($order->payments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Receipt #</th>
                                        <th>Method</th>
                                        <th>Amount</th>
                                        <th>Previous Balance</th>
                                        <th>New Balance</th>
                                        <th>Received By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->payments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_date->format('d M, Y') }}</td>
                                        <td class="font-weight-bold">{{ $payment->receipt_number ??""  }}</td>
                                        <td>{{ $payment->paymentMethod->name ??"" }}</td>
                                        <td class="text-success font-weight-bold">Rs {{ number_format($payment->amount) }}</td>
                                        <td>Rs {{ number_format($payment->previous_balance) }}</td>
                                        <td>Rs {{ number_format($payment->new_balance) }}</td>
                                        <td>{{ $payment->receivedBy->name ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-info">
                            <i class="las la-info-circle"></i> No payments recorded yet.
                        </div>
                        @endif
                        
                        <!-- Payment Summary -->
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="card border-left-primary">
                                    <div class="card-body">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Amount</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            Rs {{ number_format($order->final_amount) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-left-success">
                                    <div class="card-body">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Total Paid</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            Rs {{ number_format($order->payments->sum('amount')) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-left-{{ $order->remaining_amount > 0 ? 'danger' : 'secondary' }}">
                                    <div class="card-body">
                                        <div class="text-xs font-weight-bold text-{{ $order->remaining_amount > 0 ? 'danger' : 'secondary' }} text-uppercase mb-1">
                                            Balance Due</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            Rs {{ number_format($order->remaining_amount) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="col-lg-4">
                <!-- Status Timeline -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Status Timeline</h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @foreach($order->statusLogs->sortBy('changed_at') as $log)
                            <div class="timeline-item mb-3">
                                <div class="timeline-marker" style="background-color: {{ $log->newStatus->color?? "green" }};"></div>
                                <div class="timeline-content">
                                    <div class="font-weight-bold">{{ $log->newStatus->name ?? "" }}</div>
                                    <small class="text-muted">
                                        {{ $log->changed_at->format('d M, Y h:i A') }}
                                    </small>
                                    @if($log->notes)
                                    <div class="mt-1 small">{{ $log->notes ??"" }}</div>
                                    @endif
                                    <div class="text-muted small">
                                        By {{ $log->changedBy->name ?? 'System' }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <button class="list-group-item list-group-item-action" onclick="updateStatus()">
                                <i class="las la-sync mr-2 text-primary"></i>
                                Update Status
                            </button>
                            <button class="list-group-item list-group-item-action" onclick="addPayment()">
                                <i class="las la-money-bill-wave mr-2 text-success"></i>
                                Add Payment
                            </button>
                            <button class="list-group-item list-group-item-action" onclick="assignTailor()">
                                <i class="las la-user-tie mr-2 text-info"></i>
                                Assign Tailor
                            </button>
                            <button class="list-group-item list-group-item-action" onclick="addMeasurement()">
                                <i class="las la-ruler mr-2 text-warning"></i>
                                Add Measurement
                            </button>
                            <a href="{{ route('orders.edit', $order) }}" class="list-group-item list-group-item-action">
                                <i class="las la-edit mr-2 text-secondary"></i>
                                Edit Order
                            </a>
                            <button class="list-group-item list-group-item-action text-danger" onclick="deleteOrder()">
                                <i class="las la-trash mr-2"></i>
                                Delete Order
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Notes</h6>
                    </div>
                    <div class="card-body">
                        @if($order->notes)
                        <h6 class="font-weight-bold">Customer Notes</h6>
                        <p class="mb-3">{{ $order->notes }}</p>
                        @endif
                        
                        @if($order->internal_notes)
                        <h6 class="font-weight-bold">Internal Notes</h6>
                        <p class="mb-3">{{ $order->internal_notes }}</p>
                        @endif
                        
                        <textarea class="form-control" rows="3" placeholder="Add new note..."></textarea>
                        <button class="btn btn-sm btn-primary mt-2">
                            <i class="las la-save"></i> Save Note
                        </button>
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
            function printOrder() {
                window.open('{{ route("orders.show", $order->id) }}?print=true', '_blank');
            }
            
            function updateStatus() {
                alert('Update status for order {{ $order->order_number }}');
                // Implement status update modal
            }
            
            function addPayment() {
                alert('Add payment for order {{ $order->order_number }}');
                // Implement payment modal
            }
            
            function assignTailor() {
                alert('Assign tailor for order {{ $order->order_number }}');
                // Implement tailor assignment modal
            }
            
            function addMeasurement() {
                alert('Add measurement for order {{ $order->order_number }}');
                // Implement measurement modal
            }
            
            function addItem() {
                alert('Add item to order {{ $order->order_number }}');
                // Implement add item modal
            }
            
            function deleteOrder() {
                if (confirm('Are you sure you want to delete order {{ $order->order_number }}?')) {
                    window.location.href = '{{ route("orders.destroy", $order->id) }}';
                }
            }
        </script>
    @endpush
    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #e9ecef;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }
        
        .timeline-marker {
            position: absolute;
            left: -30px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #3B82F6;
            border: 2px solid white;
            box-shadow: 0 0 0 3px #e9ecef;
        }
        
        .timeline-content {
            padding-left: 10px;
        }
        
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
        
        .badge {
            font-size: 0.75em;
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
        
        .progress {
            background-color: #e9ecef;
            border-radius: 2px;
        }
        
        .list-group-item {
            border: none;
            padding: 0.75rem 0;
        }
        
        .list-group-item:hover {
            background-color: #f8f9fa;
        }
    </style>
</x-app-layout>