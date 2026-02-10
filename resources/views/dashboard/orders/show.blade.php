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
                <h4 class="mb-3">{{ __('Order Details: :order_number', ['order_number' => $order->order_number]) }}</h4>
                <p class="mb-0">{{ __('Complete order information and tracking') }}</p>
            </div>
            <div class="d-flex">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary mr-2">
                    <i class="las la-arrow-left"></i> {{ __('messages.back') }}
                </a>
                <a href="{{ route('orders.edit', $order) }}" class="btn btn-outline-primary mr-2">
                    <i class="las la-edit"></i> {{ __('messages.edit') }}
                </a>
                <button class="btn btn-outline-success" onclick="printOrder()">
                    <i class="las la-print"></i> {{ __('Print') }}
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
                                            {{ __('Order Status') }}</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <span class="badge badge-pill" style="background-color: {{ $order->status->color }}; color: white; font-size: 1rem;">
                                                {{ $order->status->name }}
                                            </span>
                                        </div>
                                        <div class="mt-2 mb-0 text-muted text-xs">
                                            @if($order->delivery_date->isFuture())
                                                {{ __(':days days remaining', ['days' => round($order->delivery_date->diffInDays(now()))]) }}
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
                                            {{ __('Payment Status') }}</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <span class="badge badge-pill" style="background-color: {{ $order->paymentStatus->color }}; color: white; font-size: 1rem;">
                                                {{ $order->paymentStatus->name }}
                                            </span>
                                        </div>
                                        <div class="mt-2 mb-0 text-muted text-xs">
                                            @if($order->paymentStatus->slug == 'partial')
                                                {{ __('Rs :amount remaining', ['amount' => number_format($order->remaining_amount)]) }}
                                            @elseif($order->paymentStatus->slug == 'paid')
                                                {{ __('Fully paid') }}
                                            @else
                                                {{ __('Pending') }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        {{-- <p class="fa-2x text-success">Rs</p> --}}
                                        {{-- <i class="las la-rupee-sign "></i> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer & Order Info -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('messages.customer_order_info') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="font-weight-bold text-primary mb-3">{{ __('Customer Details') }}</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <th width="40%">{{ __('messages.name') }}:</th>
                                        <td>{{ $order->customer->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('messages.phone') }}:</th>
                                        <td>{{ $order->customer->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('messages.address') }}:</th>
                                        <td>{{ $order->customer->address ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Customer Type') }}:</th>
                                        <td>
                                            <span class="badge badge-{{ $order->customer->customer_type == 'regular' ? 'primary' : 'success' }}">
                                                {{ ucfirst($order->customer->customer_type) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Discount Rate') }}:</th>
                                        <td>{{ $order->customer->discount_rate }}%</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="font-weight-bold text-primary mb-3">{{ __('Order Details') }}</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <th width="40%">{{ __('messages.order_number') }}:</th>
                                        <td class="font-weight-bold">{{ $order->order_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('messages.order_date') }}:</th>
                                        <td>{{ $order->order_date->format('d M, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('messages.delivery_date') }}:</th>
                                        <td>{{ $order->delivery_date->format('d M, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('messages.branch') }}:</th>
                                        <td>{{ $order->branch->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Order Type') }}:</th>
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
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('Order Items') }}</h6>
                        <button class="btn btn-sm btn-outline-primary" onclick="addItem()">
                            <i class="las la-plus"></i> {{ __('Add Item') }}
                        </button>
                    </div>
                    <div class="card-body">
                        @foreach($order->items as $item)
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">{{ $item->item_name }}</h6>
                                        <small class="text-muted">{{ __('Item Status:') }}
                                            <span class="badge badge-{{ $item->item_status == 'pending' ? 'warning' : ($item->item_status == 'ready' ? 'success' : 'info') }}">
                                                {{ ucfirst($item->item_status) }}
                                            </span>
                                        </small>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-weight-bold text-success">
                                            Rs {{ number_format($item->total) }}
                                        </div>
                                        <small class="text-muted">{{ __('Qty: :quantity', ['quantity' => $item->quantity]) }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($item->dressType)
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="font-weight-bold">{{ __('Dress Type Details') }}</h6>
                                        <table class="table table-sm">
                                            <tr>
                                                <th>{{ __('messages.dress_type') }}:</th>
                                                <td>{{ $item->dressType->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Base Price') }}:</th>
                                                <td>Rs {{ number_format($item->dressType->base_price) }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Estimated Days') }}:</th>
                                                <td>{{ $item->dressType->estimated_days }} {{ __('days') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="font-weight-bold">{{ __('Tailor Assignment') }}</h6>
                                        @if($item->tailorAssignments->count() > 0)
                                            @php
                                                $assignment = $item->tailorAssignments->first();
                                            @endphp
                                            <table class="table table-sm">
                                                <tr>
                                                    <th>{{ __('messages.tailors') }}:</th>
                                                    <td>{{ $assignment->tailor->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Status') }}:</th>
                                                    <td>
                                                        <span class="badge" style="background-color: {{ $assignment->status->color }}; color: white;">
                                                            {{ $assignment->status->name }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Stitching Charge') }}:</th>
                                                    <td>Rs {{ number_format($assignment->stitching_charge) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Progress') }}:</th>
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
                                                <i class="las la-exclamation-triangle"></i> {{ __('No tailor assigned yet.') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Measurements -->
                                @if($item->measurements->count() > 0)
                                <div class="mt-3">
                                    <h6 class="font-weight-bold">{{ __('messages.measurements_cm') }}</h6>
                                    <div class="row">
                                        @php
                                            $measurement = $item->measurements->first();
                                            
                                            // Define all possible measurement fields with their labels
                                            $measurementFields = [
                                                'height' => __('messages.height'),
                                                'weight' => __('messages.weight'),
                                                'shoulder' => __('messages.shoulder'),
                                                'chest' => __('messages.chest'),
                                                'waist' => __('messages.waist'),
                                                'hips' => __('messages.hips'),
                                                'sleeve_length' => __('messages.sleeve_length'),
                                                'sleeve_width' => __('messages.sleeve_width'),
                                                'collar' => __('messages.collar'),
                                                'bicep' => __('messages.bicep'),
                                                'wrist' => __('messages.wrist'),
                                                'pant_length' => __('messages.pant_length'),
                                                'inseam' => __('messages.inseam'),
                                                'thigh' => __('messages.thigh'),
                                                'knee' => __('messages.knee'),
                                                'bottom' => __('messages.bottom'),
                                                'ankle' => __('messages.ankle'),
                                            ];
                                        @endphp
                                        @foreach($measurementFields as $field => $label)
                                            @if(in_array($field, $enabledFields) && $measurement->$field !== null)
                                            <div class="col-md-3 mb-2">
                                                <div class="bg-light p-2 rounded">
                                                    <small class="text-muted">{{ $label }}</small>
                                                    <div class="font-weight-bold">{{ $measurement->$field }} {{ __('cm') }}</div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                        
                                        <!-- Handle additional_measurements JSON field -->
                                        @if($measurement->additional_measurements && is_array($measurement->additional_measurements))
                                            @foreach($measurement->additional_measurements as $field => $value)
                                                @if($value !== null && $value !== '')
                                                <div class="col-md-3 mb-2">
                                                    <div class="bg-light p-2 rounded">
                                                        <small class="text-muted">{{ ucwords(str_replace('_', ' ', $field)) }}</small>
                                                        <div class="font-weight-bold">{{ is_numeric($value) ? $value . ' ' . __('cm') : $value }}</div>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        @endif
                                        
                                        <!-- Show fitting preferences if exists -->
                                        @if($measurement->fitting_preferences)
                                        <div class="col-md-12 mb-2">
                                            <div class="bg-light p-2 rounded">
                                                <small class="text-muted">{{ __('messages.fitting_preferences') }}</small>
                                                <div class="font-weight-bold">{{ $measurement->fitting_preferences }}</div>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <!-- Show notes if exists -->
                                        @if($measurement->notes)
                                        <div class="col-md-12 mb-2">
                                            <div class="bg-light p-2 rounded">
                                                <small class="text-muted">{{ __('messages.measurement_notes') }}</small>
                                                <div class="font-weight-bold">{{ $measurement->notes }}</div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                
                                <!-- Instructions -->
                                @if($item->instructions)
                                <div class="mt-3">
                                    <h6 class="font-weight-bold">{{ __('messages.special_instructions') }}</h6>
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
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('Payment History') }}</h6>
                        <button class="btn btn-sm btn-outline-success" onclick="addPayment()">
                            <i class="las la-money-bill-wave"></i> {{ __('Add Payment') }}
                        </button>
                    </div>
                    <div class="card-body">
                        @if($order->payments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Receipt #') }}</th>
                                        <th>{{ __('Method') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Previous Balance') }}</th>
                                        <th>{{ __('New Balance') }}</th>
                                        <th>{{ __('Received By') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->payments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_date->format('d M, Y') }}</td>
                                        <td class="font-weight-bold">{{ $payment->receipt_number ?? "" }}</td>
                                        <td>{{ $payment->paymentMethod->name ?? "" }}</td>
                                        <td class="text-success font-weight-bold">Rs {{ number_format($payment->amount) }}</td>
                                        <td>Rs {{ number_format($payment->previous_balance) }}</td>
                                        <td>Rs {{ number_format($payment->new_balance) }}</td>
                                        <td>{{ $payment->receivedBy->name ?? __('N/A') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-info">
                            <i class="las la-info-circle"></i> {{ __('No payments recorded yet.') }}
                        </div>
                        @endif
                        
                        <!-- Payment Summary -->
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="card border-left-primary">
                                    <div class="card-body">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            {{ __('messages.total_amount') }}</div>
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
                                            {{ __('Total Paid') }}</div>
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
                                            {{ __('messages.balance_due') }}</div>
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
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('Status Timeline') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @foreach($order->statusLogs->sortBy('changed_at') as $log)
                            <div class="timeline-item mb-3">
                                <div class="timeline-marker" style="background-color: {{ $log->newStatus->color ?? "green" }};"></div>
                                <div class="timeline-content">
                                    <div class="font-weight-bold">{{ $log->newStatus->name ?? "" }}</div>
                                    <small class="text-muted">
                                        {{ $log->changed_at->format('d M, Y h:i A') }}
                                    </small>
                                    @if($log->notes)
                                    <div class="mt-1 small">{{ $log->notes ?? "" }}</div>
                                    @endif
                                    <div class="text-muted small">
                                        {{ __('By :name', ['name' => $log->changedBy->name ?? __('System')]) }}
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
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('Quick Actions') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <button class="list-group-item list-group-item-action" onclick="updateStatus()">
                                <i class="las la-sync mr-2 text-primary"></i>
                                {{ __('Update Status') }}
                            </button>
                            <button class="list-group-item list-group-item-action" onclick="addPayment()">
                                <i class="las la-money-bill-wave mr-2 text-success"></i>
                                {{ __('Add Payment') }}
                            </button>
                            <button class="list-group-item list-group-item-action" onclick="assignTailor()">
                                <i class="las la-user-tie mr-2 text-info"></i>
                                {{ __('Assign Tailor') }}
                            </button>
                            <button class="list-group-item list-group-item-action" onclick="addMeasurement()">
                                <i class="las la-ruler mr-2 text-warning"></i>
                                {{ __('Add Measurement') }}
                            </button>
                            <a href="{{ route('orders.edit', $order) }}" class="list-group-item list-group-item-action">
                                <i class="las la-edit mr-2 text-secondary"></i>
                                {{ __('messages.edit') }}
                            </a>
                            <button class="list-group-item list-group-item-action text-danger" onclick="deleteOrder()">
                                <i class="las la-trash mr-2"></i>
                                {{ __('Delete Order') }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('messages.additional_notes') }}</h6>
                    </div>
                    <div class="card-body">
                        @if($order->notes)
                        <h6 class="font-weight-bold">{{ __('Customer Notes') }}</h6>
                        <p class="mb-3">{{ $order->notes }}</p>
                        @endif
                        
                        @if($order->internal_notes)
                        <h6 class="font-weight-bold">{{ __('messages.internal_notes') }}</h6>
                        <p class="mb-3">{{ $order->internal_notes }}</p>
                        @endif
                        
                        <textarea class="form-control" rows="3" placeholder="{{ __('Add new note...') }}"></textarea>
                        <button class="btn btn-sm btn-primary mt-2">
                            <i class="las la-save"></i> {{ __('Save Note') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Payment Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Add Payment for Order: :order_number', ['order_number' => $order->order_number]) }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('messages.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="paymentForm" method="POST" action="{{ route('orders.payments.store', $order) }}">
                    @csrf
                    <div class="modal-body">
                        <!-- Order & Balance Info -->
                        <div class="alert alert-info">
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>{{ __('Order Total') }}:</strong><br>
                                    <h5 class="mt-1 text-dark">Rs {{ number_format($order->final_amount) }}</h5>
                                </div>
                                <div class="col-md-4">
                                    <strong>{{ __('Already Paid') }}:</strong><br>
                                    <h5 class="mt-1 text-success">Rs {{ number_format($order->payments->sum('amount')) }}</h5>
                                </div>
                                <div class="col-md-4">
                                    <strong>{{ __('messages.balance_due') }}:</strong><br>
                                    <h5 class="mt-1 text-danger">Rs {{ number_format($order->remaining_amount) }}</h5>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Payment Amount') }} *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rs</span>
                                    </div>
                                    <input type="number" step="0.01" class="form-control" id="payment_amount" 
                                        name="amount" required min="0" max="{{ $order->remaining_amount }}"
                                        placeholder="{{ __('Enter payment amount') }}">
                                </div>
                                <small class="form-text text-muted">{{ __('Maximum: Rs :amount', ['amount' => number_format($order->remaining_amount)]) }}</small>
                                <div class="invalid-feedback">{{ __('Please enter a valid payment amount.') }}</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Payment Date') }} *</label>
                                <input type="date" class="form-control" name="payment_date" 
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('messages.payment_method') }} *</label>
                                <select class="form-control select2" name="payment_method_id" required>
                                    <option value="">{{ __('messages.select') }} {{ __('messages.payment_method') }}</option>
                                    @foreach($paymentMethods as $method)
                                    <option value="{{ $method->id }}" {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
                                        {{ $method->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">{{ __('Please select a payment method.') }}</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Receipt Number') }}</label>
                                <input type="text" class="form-control" name="receipt_number" 
                                    placeholder="{{ __('Auto-generated if left blank') }}"
                                    value="{{ old('receipt_number', 'RC-' . time()) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Reference/Transaction ID') }}</label>
                                <input type="text" class="form-control" name="reference_number" 
                                    placeholder="{{ __('e.g., Bank transaction ID, UTR No.') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Collected By') }}</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                                <input type="hidden" name="received_by" value="{{ auth()->id() }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Payment Notes') }}</label>
                            <textarea class="form-control" name="notes" rows="3" 
                                    placeholder="{{ __('Any additional notes about this payment...') }}"></textarea>
                        </div>

                        <!-- Payment Preview -->
                        <div class="card border-primary">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">{{ __('Payment Preview') }}</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-sm">
                                            <tr>
                                                <th>{{ __('Current Balance') }}:</th>
                                                <td class="text-danger">Rs <span id="current_balance">{{ number_format($order->remaining_amount, 2) }}</span></td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Payment Amount') }}:</th>
                                                <td class="text-success">Rs <span id="preview_amount">0.00</span></td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('New Balance') }}:</th>
                                                <td class="font-weight-bold text-primary">Rs <span id="new_balance">{{ number_format($order->remaining_amount, 2) }}</span></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-light">
                                            <small class="text-muted">
                                                <i class="las la-info-circle"></i>
                                                {{ __('After this payment, the remaining balance will be updated automatically.') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="savePaymentBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            {{ __('Record Payment') }}
                        </button>
                    </div>
                </form>
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
                alert('{{ __("Update status for order :order_number", ["order_number" => $order->order_number]) }}');
                // Implement status update modal
            }
            
            function addPayment() {
                $('#addPaymentModal').modal('show');
            }

            // Payment amount preview
            $('#payment_amount').on('input', function() {
                const amount = parseFloat($(this).val()) || 0;
                const currentBalance = parseFloat('{{ $order->remaining_amount }}');
                const newBalance = currentBalance - amount;
                
                $('#preview_amount').text(amount.toFixed(2));
                $('#new_balance').text(newBalance.toFixed(2));
                
                // Validate max amount
                if (amount > currentBalance) {
                    $(this).addClass('is-invalid');
                    $('#savePaymentBtn').prop('disabled', true);
                } else {
                    $(this).removeClass('is-invalid');
                    $('#savePaymentBtn').prop('disabled', false);
                }
            });

            // Payment form submission
            $('#paymentForm').submit(function(e) {
                e.preventDefault();
                
                const saveBtn = $('#savePaymentBtn');
                const spinner = saveBtn.find('.spinner-border');
                
                // Validate form
                if (!this.checkValidity()) {
                    e.stopPropagation();
                    $(this).addClass('was-validated');
                    return;
                }
                
                // Show loading
                saveBtn.prop('disabled', true);
                spinner.removeClass('d-none');
                
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            
                            // Close modal and reset form
                            $('#addPaymentModal').modal('hide');
                            $('#paymentForm')[0].reset();
                            $('#paymentForm').removeClass('was-validated');
                            
                            // Reload page to show updated payment info
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = '{{ __("messages.an_error_occurred") }}';
                        
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            errorMessage = Object.values(errors).flat().join('<br>');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        saveBtn.prop('disabled', false);
                        spinner.addClass('d-none');
                    }
                });
            });

            // Reset modal when closed
            $('#addPaymentModal').on('hidden.bs.modal', function() {
                $('#paymentForm')[0].reset();
                $('#paymentForm').removeClass('was-validated');
                $('#preview_amount').text('0.00');
                $('#new_balance').text('{{ number_format($order->remaining_amount, 2) }}');
            });
            
            function assignTailor() {
                alert('{{ __("Assign tailor for order :order_number", ["order_number" => $order->order_number]) }}');
                // Implement tailor assignment modal
            }
            
            function addMeasurement() {
                alert('{{ __("Add measurement for order :order_number", ["order_number" => $order->order_number]) }}');
                // Implement measurement modal
            }
            
            function addItem() {
                alert('{{ __("Add item to order :order_number", ["order_number" => $order->order_number]) }}');
                // Implement add item modal
            }
            
            function deleteOrder() {
                if (confirm('{{ __("Are you sure you want to delete order :order_number?", ["order_number" => $order->order_number]) }}')) {
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