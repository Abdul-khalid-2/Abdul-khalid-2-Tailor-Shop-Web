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
                <!-- Customer Bill Print Button -->
                <button class="btn btn-outline-success mr-2" onclick="printCustomerBill()">
                    <i class="las la-file-invoice"></i> {{ __('Customer Bill') }}
                </button>
                <!-- Tailor Worksheet Print Button -->
                <button class="btn btn-outline-info" onclick="printTailorWorksheet()">
                    <i class="las la-tshirt"></i> {{ __('Tailor Worksheet') }}
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
                                            {{ __('Order Status') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <span class="badge badge-pill" style="background-color: {{ $order->status->color }}; color: white; font-size: 1rem;">
                                                {{ $order->status->name }}
                                            </span>
                                        </div>
                                        <div class="mt-2 mb-0 text-muted text-xs">
                                            @if($order->delivery_date->isFuture())
                                            {{ __(':days days remaining', ['days' => $order->delivery_date->diffInDays(now())]) }}
                                            @elseif($order->delivery_date->isPast() && $order->status->slug != 'delivered')
                                            <span class="text-danger">{{ __('Overdue by :days days', ['days' => now()->diffInDays($order->delivery_date)]) }}</span>
                                            @else
                                            {{ $order->delivery_date->diffForHumans() }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="las la-{{ $order->status->slug == 'pending' ? 'clock' : ($order->status->slug == 'in-progress' ? 'tasks' : ($order->status->slug == 'delivered' ? 'check-circle' : 'circle')) }} fa-2x text-primary"></i>
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
                                            {{ __('Payment Status') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <span class="badge badge-pill" style="background-color: {{ $order->paymentStatus->color }}; color: white; font-size: 1rem;">
                                                {{ $order->paymentStatus->name }}
                                            </span>
                                        </div>
                                        <div class="mt-2 mb-0 text-muted text-xs">
                                            @if($order->paymentStatus->slug == 'partial')
                                            {{ __('Rs :amount remaining', ['amount' => number_format($order->remaining_amount, 0)]) }}
                                            @elseif($order->paymentStatus->slug == 'paid')
                                            {{ __('Fully paid') }}
                                            @else
                                            {{ __('Pending') }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="las la-money-bill-wave fa-2x text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer & Order Info -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('messages.customer_order_info') }}</h6>
                        <span class="badge badge-light">{{ __('Order Date') }}: {{ $order->order_date->format('d M, Y') }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar bg-primary text-white rounded-circle mr-3">
                                        <span class="avatar-title">{{ substr($order->customer->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 font-weight-bold">{{ $order->customer->name }}</h6>
                                        <small class="text-muted">{{ __('Customer ID') }}: #{{ $order->customer->id }}</small>
                                    </div>
                                </div>
                                <table class="table table-sm">
                                    <tr>
                                        <th width="40%">{{ __('messages.phone') }}:</th>
                                        <td>{{ $order->customer->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('messages.address') }}:</th>
                                        <td>{{ $order->customer->address ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Customer Type') }}:</th>
                                        <td>
                                            <span class="badge badge-{{ $order->customer->customer_type == 'regular' ? 'primary' : ($order->customer->customer_type == 'vip' ? 'success' : 'secondary') }}">
                                                {{ ucfirst($order->customer->customer_type) }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tr>
                                        <th width="40%">{{ __('messages.order_number') }}:</th>
                                        <td class="font-weight-bold">{{ $order->order_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('messages.delivery_date') }}:</th>
                                        <td>
                                            {{ $order->delivery_date->format('d M, Y') }}
                                            @if($order->delivery_date->isToday())
                                            <span class="badge badge-warning ml-2">{{ __('Today') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('messages.branch') }}:</th>
                                        <td>{{ $order->branch->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Order Type') }}:</th>
                                        <td>
                                            <span class="badge badge-{{ $order->order_type == 'tailoring' ? 'info' : 'secondary' }}">
                                                {{ ucfirst($order->order_type) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Total Items') }}:</th>
                                        <td><span class="badge badge-dark">{{ $order->items->count() }}</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($order->notes)
                        <div class="mt-3 p-3 bg-light rounded">
                            <div class="d-flex">
                                <i class="las la-sticky-note text-primary mr-2 mt-1"></i>
                                <div>
                                    <strong>{{ __('Customer Notes') }}:</strong>
                                    <p class="mb-0">{{ $order->notes }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('Order Items') }}</h6>
                        <button class="btn btn-sm btn-outline-primary" onclick="addItem({{ $order->id }})">
                            <i class="las la-plus"></i> {{ __('Add Item') }}
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach($order->items as $index => $item)
                            <div class="list-group-item p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1 font-weight-bold">
                                            {{ $item->item_name ?? $item->dressType->name ?? 'N/A' }}
                                            <span class="badge badge-pill badge-{{ $item->item_status == 'pending' ? 'warning' : ($item->item_status == 'cutting' ? 'info' : ($item->item_status == 'stitching' ? 'primary' : ($item->item_status == 'ready' ? 'success' : 'secondary'))) }} ml-2">
                                                {{ ucfirst($item->item_status) }}
                                            </span>
                                        </h6>
                                        <small class="text-muted">
                                            <i class="las la-tag"></i> {{ __('Item #:index', ['index' => $index + 1]) }}
                                        </small>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-weight-bold text-success">
                                            Rs {{ number_format($item->total, 0) }}
                                        </div>
                                        <small class="text-muted">{{ __('Qty: :quantity', ['quantity' => $item->quantity]) }}</small>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <small class="text-muted d-block">{{ __('Base Price') }}:</small>
                                        <span class="font-weight-bold">Rs {{ number_format($item->price, 0) }}</span>
                                    </div>
                                    @if($item->fabric_type || $item->fabric_color || $item->fabric_meters)
                                    <div class="col-md-8">
                                        <small class="text-muted d-block">{{ __('Fabric Details') }}:</small>
                                        <span>
                                            @if($item->fabric_type){{ $item->fabric_type }}@endif
                                            @if($item->fabric_color) / {{ $item->fabric_color }}@endif
                                            @if($item->fabric_meters) / {{ $item->fabric_meters }} m @endif
                                            @if($item->fabric_rate) @ Rs {{ number_format($item->fabric_rate, 0) }}/m @endif
                                        </span>
                                    </div>
                                    @endif
                                </div>

                                <!-- Tailor Assignment -->
                                @if($item->tailorAssignments->count() > 0)
                                <div class="mt-2 pt-2 border-top">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            @php $assignment = $item->tailorAssignments->first(); @endphp
                                            <small class="text-muted d-block">{{ __('Tailor') }}:</small>
                                            <div class="d-flex align-items-center mt-1">
                                                <div class="avatar avatar-sm bg-info text-white rounded-circle mr-2">
                                                    <span class="avatar-title">{{ substr($assignment->tailor->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <strong>{{ $assignment->tailor->name }}</strong>
                                                    <small class="d-block text-muted">
                                                        <span class="badge" style="background-color: {{ $assignment->status->color }}; color: white;">
                                                            {{ $assignment->status->name }}
                                                        </span>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted d-block">{{ __('Progress') }}:</small>
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 mr-2" style="height: 6px;">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: {{ $assignment->progress_percentage }}%; background-color: {{ $assignment->status->color }};">
                                                    </div>
                                                </div>
                                                <span class="small font-weight-bold">{{ $assignment->progress_percentage }}%</span>
                                            </div>
                                            <small class="text-muted d-block mt-1">
                                                <!-- {{ __('Stitching Charge') }}: Rs {{ number_format($assignment->stitching_charge, 0) }} -->
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Measurements -->
                                @if($item->measurements->count() > 0)
                                <div class="mt-2 pt-2 border-top">
                                    <div class="d-flex align-items-center">
                                        <i class="las la-ruler text-primary mr-2"></i>
                                        <small class="font-weight-bold">{{ __('messages.measurements_cm') }}:</small>
                                    </div>
                                    <div class="row mt-2">
                                        @php
                                        $measurement = $item->measurements->first();
                                        $displayedFields = 0;
                                        @endphp

                                        @foreach($enabledFields as $field)
                                        @if($measurement->$field !== null)
                                        <div class="col-md-3 col-6 mb-2">
                                            <div class="bg-light p-2 rounded">
                                                <small class="text-muted d-block">{{ __('messages.' . $field) }}</small>
                                                <span class="font-weight-bold">{{ $measurement->$field }} cm</span>
                                            </div>
                                        </div>
                                        @php $displayedFields++; @endphp
                                        @endif
                                        @endforeach

                                        @if($displayedFields == 0)
                                        <div class="col-12">
                                            <p class="text-muted small mb-0">{{ __('No measurements recorded for this item.') }}</p>
                                        </div>
                                        @endif
                                    </div>

                                    @if($measurement->fitting_preferences || $measurement->notes)
                                    <div class="mt-2">
                                        @if($measurement->fitting_preferences)
                                        <div class="bg-warning-light p-2 rounded">
                                            <small class="text-muted d-block">{{ __('messages.fitting_preferences') }}</small>
                                            <span>{{ $measurement->fitting_preferences }}</span>
                                        </div>
                                        @endif

                                        @if($measurement->notes)
                                        <div class="bg-info-light p-2 rounded mt-1">
                                            <small class="text-muted d-block">{{ __('messages.measurement_notes') }}</small>
                                            <span>{{ $measurement->notes }}</span>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                                @endif

                                <!-- Instructions -->
                                @if($item->instructions)
                                <div class="mt-2 pt-2 border-top">
                                    <div class="d-flex">
                                        <i class="las la-clipboard-list text-warning mr-2"></i>
                                        <div>
                                            <small class="font-weight-bold d-block">{{ __('messages.special_instructions') }}:</small>
                                            <span class="small">{{ $item->instructions }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Item Actions -->
                                <div class="mt-2 pt-2 border-top text-right">
                                    <button class="btn btn-xs btn-outline-info" onclick="updateItemStatus({{ $item->id }}, '{{ $item->item_status }}')">
                                        <i class="las la-sync"></i> {{ __('Update Status') }}
                                    </button>
                                    <button class="btn btn-xs btn-outline-primary" onclick="editItem({{ $item->id }})">
                                        <i class="las la-edit"></i> {{ __('Edit') }}
                                    </button>
                                    @if($item->tailorAssignments->count() == 0)
                                    <button class="btn btn-xs btn-outline-warning" onclick="assignTailorToItem({{ $item->id }})">
                                        <i class="las la-user-tie"></i> {{ __('Assign Tailor') }}
                                    </button>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
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
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Receipt #') }}</th>
                                        <th>{{ __('Method') }}</th>
                                        <th class="text-right">{{ __('Amount') }}</th>
                                        <th class="text-right">{{ __('Previous Balance') }}</th>
                                        <th class="text-right">{{ __('New Balance') }}</th>
                                        <th>{{ __('Received By') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->payments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_date->format('d M, Y') }}</td>
                                        <td class="font-weight-bold">{{ $payment->receipt_number ?? 'N/A' }}</td>
                                        <td>{{ $payment->paymentMethod->name ?? 'N/A' }}</td>
                                        <td class="text-right text-success font-weight-bold">Rs {{ number_format($payment->amount, 0) }}</td>
                                        <td class="text-right">Rs {{ number_format($payment->previous_balance, 0) }}</td>
                                        <td class="text-right">Rs {{ number_format($payment->new_balance, 0) }}</td>
                                        <td>{{ $payment->receivedBy->name ?? 'N/A' }}</td>
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
                                            {{ __('messages.total_amount') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            Rs {{ number_format($order->final_amount, 0) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-left-success">
                                    <div class="card-body">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            {{ __('Total Paid') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            Rs {{ number_format($order->payments->sum('amount'), 0) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-left-{{ $order->remaining_amount > 0 ? 'danger' : 'secondary' }}">
                                    <div class="card-body">
                                        <div class="text-xs font-weight-bold text-{{ $order->remaining_amount > 0 ? 'danger' : 'secondary' }} text-uppercase mb-1">
                                            {{ __('messages.balance_due') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            Rs {{ number_format($order->remaining_amount, 0) }}
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
                    <div class="card-body p-0">
                        <div class="timeline p-3">
                            @forelse($order->statusLogs->sortByDesc('changed_at') as $log)
                            <div class="timeline-item mb-3">
                                <div class="timeline-marker" style="background-color: {{ $log->newStatus->color ?? '#6b7280' }};"></div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between">
                                        <div class="font-weight-bold">{{ $log->newStatus->name ?? 'Status Updated' }}</div>
                                        <small class="text-muted">{{ $log->changed_at->format('h:i A') }}</small>
                                    </div>
                                    <small class="text-muted d-block">
                                        {{ $log->changed_at->format('d M, Y') }}
                                    </small>
                                    @if($log->notes)
                                    <div class="mt-1 p-2 bg-light rounded small">
                                        <i class="las la-quote-left"></i> {{ $log->notes }}
                                    </div>
                                    @endif
                                    <div class="text-muted small mt-1">
                                        <i class="las la-user"></i> {{ $log->changedBy->name ?? __('System') }}
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="las la-history fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">{{ __('No status logs available.') }}</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('Quick Actions') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <button class="list-group-item list-group-item-action d-flex align-items-center" onclick="updateOrderStatus({{ $order->id }})">
                                <i class="las la-sync text-primary mr-3 fa-lg"></i>
                                <div class="flex-grow-1">
                                    <strong>{{ __('Update Status') }}</strong>
                                    <small class="d-block text-muted">{{ __('Change order progress') }}</small>
                                </div>
                                <i class="las la-chevron-right text-muted"></i>
                            </button>

                            <button class="list-group-item list-group-item-action d-flex align-items-center" onclick="addPayment()">
                                <i class="las la-money-bill-wave text-success mr-3 fa-lg"></i>
                                <div class="flex-grow-1">
                                    <strong>{{ __('Add Payment') }}</strong>
                                    <small class="d-block text-muted">{{ __('Record a new payment') }}</small>
                                </div>
                                <i class="las la-chevron-right text-muted"></i>
                            </button>

                            <button class="list-group-item list-group-item-action d-flex align-items-center" onclick="assignTailor()">
                                <i class="las la-user-tie text-info mr-3 fa-lg"></i>
                                <div class="flex-grow-1">
                                    <strong>{{ __('Assign Tailor') }}</strong>
                                    <small class="d-block text-muted">{{ __('Assign to a tailor') }}</small>
                                </div>
                                <i class="las la-chevron-right text-muted"></i>
                            </button>

                            <a href="{{ route('orders.edit', $order) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="las la-edit text-warning mr-3 fa-lg"></i>
                                <div class="flex-grow-1">
                                    <strong>{{ __('messages.edit') }}</strong>
                                    <small class="d-block text-muted">{{ __('Modify order details') }}</small>
                                </div>
                                <i class="las la-chevron-right text-muted"></i>
                            </a>

                            <button class="list-group-item list-group-item-action d-flex align-items-center" onclick="printCustomerBill()">
                                <i class="las la-file-invoice text-secondary mr-3 fa-lg"></i>
                                <div class="flex-grow-1">
                                    <strong>{{ __('Print Bill') }}</strong>
                                    <small class="d-block text-muted">{{ __('Generate customer invoice') }}</small>
                                </div>
                                <i class="las la-chevron-right text-muted"></i>
                            </button>

                            <button class="list-group-item list-group-item-action d-flex align-items-center text-danger" onclick="deleteOrder({{ $order->id }})">
                                <i class="las la-trash mr-3 fa-lg"></i>
                                <div class="flex-grow-1">
                                    <strong>{{ __('Delete Order') }}</strong>
                                    <small class="d-block text-muted">{{ __('Permanently delete') }}</small>
                                </div>
                                <i class="las la-chevron-right text-muted"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('messages.additional_notes') }}</h6>
                    </div>
                    <div class="card-body">
                        @if($order->internal_notes)
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="las la-lock text-warning mr-2"></i>
                                <strong>{{ __('messages.internal_notes') }}</strong>
                            </div>
                            <div class="bg-light p-3 rounded">
                                {{ $order->internal_notes }}
                            </div>
                        </div>
                        @endif
                        {{-- {{ route('orders.notes.store', $order) }} --}}
                        <form id="addNoteForm" method="POST" action="">
                            @csrf
                            <div class="form-group">
                                <label for="note">{{ __('Add New Note') }}</label>
                                <textarea class="form-control" id="note" name="notes" rows="3" placeholder="{{ __('Add internal note...') }}"></textarea>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="is_internal" name="is_internal" checked>
                                <label class="form-check-label" for="is_internal">
                                    {{ __('Internal note (not visible to customer)') }}
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="las la-save"></i> {{ __('Save Note') }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Order Summary Card -->
                <div class="card shadow bg-gradient-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="m-0 font-weight-bold">{{ __('Order Summary') }}</h6>
                            <span class="badge badge-light">{{ $order->order_number }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ __('Subtotal') }}:</span>
                            <span class="font-weight-bold">Rs {{ number_format($order->total_amount, 0) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ __('Discount') }}:</span>
                            <span class="font-weight-bold">- Rs {{ number_format($order->discount_amount, 0) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ __('Advance Paid') }}:</span>
                            <span class="font-weight-bold">Rs {{ number_format($order->advance_amount, 0) }}</span>
                        </div>
                        <hr class="bg-white">
                        <div class="d-flex justify-content-between">
                            <span class="h6 mb-0">{{ __('Balance Due') }}:</span>
                            <span class="h5 mb-0 font-weight-bold">Rs {{ number_format($order->remaining_amount, 0) }}</span>
                        </div>
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

    <!-- Update Status Modal -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Update Order Status') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- {{ route('orders.status.update', $order) }} --}}
                <form id="updateStatusForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">{{ __('Status') }} *</label>
                            <select class="form-control select2" name="status_id" required>
                                <option value="">{{ __('Select Status') }}</option>
                                @foreach($orderStatuses ?? \App\Models\OrderStatus::where('is_active', true)->get() as $status)
                                <option value="{{ $status->id }}" {{ $order->status_id == $status->id ? 'selected' : '' }}
                                    data-color="{{ $status->color }}">
                                    {{ $status->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ __('Notes') }}</label>
                            <textarea class="form-control" name="notes" rows="3"
                                placeholder="{{ __('Add notes about this status change...') }}"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Update Status') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Order Confirmation Modal -->
    <div class="modal fade" id="deleteOrderModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">{{ __('Delete Order') }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center py-3">
                        <i class="las la-exclamation-triangle fa-4x text-danger mb-3"></i>
                        <h5>{{ __('Are you sure?') }}</h5>
                        <p class="text-muted">
                            {{ __('You are about to delete order :order_number. This action cannot be undone.', ['order_number' => $order->order_number]) }}
                        </p>
                        @if($order->payments->count() > 0)
                        <div class="alert alert-warning">
                            <i class="las la-exclamation-circle"></i>
                            {{ __('This order has :count payment(s). Deleting will also remove payment records.', ['count' => $order->payments->count()]) }}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="las la-trash"></i> {{ __('Yes, Delete Order') }}
                        </button>
                    </form>
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

            // Payment amount preview
            $('#payment_amount').on('input', function() {
                const amount = parseFloat($(this).val()) || 0;
                const currentBalance = parseFloat('{{ $order->remaining_amount }}');
                const newBalance = currentBalance - amount;

                $('#preview_amount').text(amount.toFixed(2));
                $('#new_balance').text(newBalance.toFixed(2));

                // Validate max amount
                if (amount > currentBalance || amount <= 0) {
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
                            // toastr.success(response.message);

                            // Close modal and reset form
                            $('#addPaymentModal').modal('hide');
                            $('#paymentForm')[0].reset();
                            $('#paymentForm').removeClass('was-validated');
                            $('#preview_amount').text('0.00');
                            $('#new_balance').text('{{ number_format($order->remaining_amount, 2) }}');

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
                        $('#addPaymentModal').modal('hide');
                    }
                });
            });

            // Update Status Form Submission
            $('#updateStatusForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            // toastr.success(response.message);
                            $('#updateStatusModal').modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Error updating status');
                    }
                });
            });

            // Add Note Form Submission
            $('#addNoteForm').submit(function(e) {
                e.preventDefault();

                const note = $('#note').val();
                if (!note.trim()) {
                    toastr.warning('Please enter a note');
                    return;
                }

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Note added successfully');
                            $('#note').val('');
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error adding note');
                    }
                });
            });
        });

        // Reset modal when closed
        $('#addPaymentModal').on('hidden.bs.modal', function() {
            $('#paymentForm')[0].reset();
            $('#paymentForm').removeClass('was-validated');
            $('#preview_amount').text('0.00');
            $('#new_balance').text('{{ number_format($order->remaining_amount, 2) }}');
            $('#savePaymentBtn').prop('disabled', false);
        });

        function updateOrderStatus(orderId) {
            $('#updateStatusModal').modal('show');
        }

        function addPayment() {
            $('#addPaymentModal').modal('show');
        }

        function assignTailor() {
            alert('{{ __("Assign tailor functionality will be implemented") }}');
            // TODO: Implement tailor assignment modal
        }

        function assignTailorToItem(itemId) {
            alert('{{ __("Assign tailor to item: ") }}' + itemId);
            // TODO: Implement tailor assignment per item
        }

        function addItem(orderId) {
            alert('{{ __("Add item to order functionality will be implemented") }}');
            // TODO: Implement add item modal
        }

        function updateItemStatus(itemId, currentStatus) {
            alert('{{ __("Update status for item: ") }}' + itemId + ' - Current: ' + currentStatus);
            // TODO: Implement item status update modal
        }

        function editItem(itemId) {
            alert('{{ __("Edit item: ") }}' + itemId);
            // TODO: Implement edit item modal
        }

        function deleteOrder(orderId) {
            $('#deleteOrderModal').modal('show');
        }

        // Print Functions
        function printCustomerBill() {
            var content = document.getElementById('customer-bill-template').innerHTML;
            var printWindow = window.open('', '_blank', 'width=900,height=700');

            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Customer Bill - Order #{{ $order->order_number }}</title>
                    <style>
                        body { font-family: 'Arial', sans-serif; margin: 0; padding: 20px; background: white; }
                        @media print {
                            body { padding: 0; }
                            .no-print { display: none !important; }
                        }
                        .bill-header { text-align: center; margin-bottom: 30px; }
                        .shop-name { font-size: 24px; font-weight: bold; color: #333; }
                        .bill-title { font-size: 20px; margin: 15px 0; }
                        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                        th { background: #f8f9fa; padding: 10px; text-align: left; border: 1px solid #dee2e6; }
                        td { padding: 10px; border: 1px solid #dee2e6; }
                        .text-right { text-align: right; }
                        .text-center { text-align: center; }
                        .font-bold { font-weight: bold; }
                        .total-row { font-size: 16px; }
                        .grand-total { font-size: 18px; font-weight: bold; color: #28a745; }
                        .footer { margin-top: 50px; text-align: center; font-size: 14px; color: #6c757d; }
                        .no-print { text-align: center; margin-top: 30px; }
                    </style>
                </head>
                <body>
                    ${content}
                    <div class="no-print">
                        <button onclick="window.print();" style="background: #28a745; color: white; border: none; padding: 12px 30px; border-radius: 5px; font-size: 16px; cursor: pointer; margin-right: 10px;">
                            🖨️ Print Bill
                        </button>
                        <button onclick="window.close()" style="background: #6c757d; color: white; border: none; padding: 12px 30px; border-radius: 5px; font-size: 16px; cursor: pointer;">
                            ✕ Close
                        </button>
                    </div>
                </body>
                </html>
            `);
            printWindow.document.close();
        }

        function printTailorWorksheet() {
            var content = document.getElementById('tailor-worksheet-template').innerHTML;
            var printWindow = window.open('', '_blank', 'width=900,height=700');

            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Tailor Worksheet - Order #{{ $order->order_number }}</title>
                    <style>
                        body { font-family: 'Arial', sans-serif; margin: 0; padding: 20px; background: white; }
                        @media print {
                            body { padding: 0; }
                            .no-print { display: none !important; }
                        }
                        .header { text-align: center; margin-bottom: 30px; }
                        .worksheet-title { font-size: 24px; font-weight: bold; margin: 15px 0; }
                        .order-info { background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
                        .item-card { border: 1px solid #dee2e6; border-radius: 5px; padding: 15px; margin-bottom: 20px; }
                        .measurement-table { width: 100%; border-collapse: collapse; margin: 10px 0; }
                        .measurement-table td { padding: 8px; border: 1px solid #dee2e6; }
                        .label { font-weight: bold; color: #495057; }
                        .no-print { text-align: center; margin-top: 30px; }
                    </style>
                </head>
                <body>
                    ${content}
                    <div class="no-print">
                        <button onclick="window.print();" style="background: #17a2b8; color: white; border: none; padding: 12px 30px; border-radius: 5px; font-size: 16px; cursor: pointer; margin-right: 10px;">
                            🖨️ Print Worksheet
                        </button>
                        <button onclick="window.close()" style="background: #6c757d; color: white; border: none; padding: 12px 30px; border-radius: 5px; font-size: 16px; cursor: pointer;">
                            ✕ Close
                        </button>
                    </div>
                </body>
                </html>
            `);
            printWindow.document.close();
        }

        // Toastr Configuration
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 3000
        };
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
            border-radius: 50%;
            font-weight: bold;
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
        }

        .card {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-danger {
            border-left: 0.25rem solid #e74a3b !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .bg-gradient-primary {
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
        }

        .badge-pill {
            padding: 0.5rem 1rem;
        }

        .list-group-item {
            border: none;
            border-bottom: 1px solid rgba(0, 0, 0, .125);
            padding: 1rem 1.25rem;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }
    </style>

    <!-- Include Print Templates -->
    @include('dashboard.orders.customer_bill')
    @include('dashboard.orders.tailor_worksheet')
</x-app-layout>