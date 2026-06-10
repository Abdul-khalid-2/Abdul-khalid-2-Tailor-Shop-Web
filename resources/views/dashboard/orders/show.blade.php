@php
    use App\Models\OrderStatus;

    $statuses = OrderStatus::orderBy('sort_order')->get();
    $specialtyLabels = [
        'shalwar_kameez' => 'Shalwar Kameez',
        'sherwani' => 'Sherwani',
        'all' => 'All Types',
    ];
    $measurementFields = [
        'length' => 'Length', 'shoulder' => 'Shoulder', 'chest' => 'Chest', 'waist' => 'Waist',
        'hip' => 'Hip', 'sleeve' => 'Sleeve', 'collar' => 'Collar',
        'trouser_length' => 'Trouser Length', 'trouser_waist' => 'Trouser Waist',
        'thigh' => 'Thigh', 'bottom_opening' => 'Bottom Opening',
    ];
@endphp

<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    @endpush

    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="las la-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="las la-exclamation-circle mr-2"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        {{-- Header --}}
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-start">
                    <div>
                        <h4 class="mb-2">{{ $order->order_number }}</h4>
                        @if($order->order_label)
                            <p class="text-muted mb-2">{{ $order->order_label }}</p>
                        @endif
                        <div class="mb-2">@include('dashboard.orders.partials.status-badge', ['order' => $order])</div>
                        <div class="text-muted small">
                            <span class="mr-3"><strong>Order Date:</strong> {{ $order->order_date->format('d M, Y') }}</span>
                            <span>
                                <strong>Delivery Date:</strong>
                                @if($order->delivery_date)
                                    {{ $order->delivery_date->format('d M, Y') }}
                                    @if($order->isOverdue())
                                        <span class="text-danger font-weight-bold ml-1">OVERDUE</span>
                                    @endif
                                @else
                                    —
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap mt-2 mt-md-0">
                        <a href="{{ route('orders.edit', $order) }}" class="btn btn-primary mr-2 mb-2">
                            <i class="las la-edit mr-1"></i> Edit
                        </a>
                        <button type="button" class="btn btn-outline-info mr-2 mb-2" data-toggle="modal" data-target="#statusModal">
                            <i class="las la-sync mr-1"></i> Update Status
                        </button>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary mb-2">
                            <i class="las la-arrow-left mr-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Customer & Tailor --}}
        <div class="row mb-4">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Customer</h6>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-bold mb-2">
                            <a href="{{ route('customers.show', $order->customer) }}">{{ $order->customer?->name }}</a>
                        </h5>
                        <p class="mb-1"><i class="las la-phone mr-1"></i> {{ $order->customer?->phone }}</p>
                        @if($order->customer?->address)
                            <p class="mb-0 text-muted"><i class="las la-map-marker mr-1"></i> {{ $order->customer->address }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tailor</h6>
                    </div>
                    <div class="card-body">
                        @if($order->tailor)
                            <h5 class="font-weight-bold mb-2">{{ $order->tailor->name }}</h5>
                            <p class="mb-1"><i class="las la-phone mr-1"></i> {{ $order->tailor->phone }}</p>
                            <p class="mb-1">
                                <strong>Specialty:</strong>
                                {{ $specialtyLabels[$order->tailor->specialty] ?? $order->tailor->specialty }}
                            </p>
                            <p class="mb-3">
                                <strong>Status:</strong>
                                <span class="badge badge-{{ $order->tailor->status === 'active' ? 'success' : 'warning' }}">
                                    {{ ucfirst(str_replace('_', ' ', $order->tailor->status)) }}
                                </span>
                            </p>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <small class="text-muted d-block">Fee Total</small>
                                    <strong>Rs {{ number_format($order->tailor_fee_total, 2) }}</strong>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted d-block">Fee Paid</small>
                                    <strong>Rs {{ number_format($order->tailor_fee_paid, 2) }}</strong>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted d-block">Fee Balance</small>
                                    <strong class="{{ $order->tailor_fee_balance > 0 ? 'text-danger' : '' }}">
                                        Rs {{ number_format($order->tailor_fee_balance, 2) }}
                                    </strong>
                                </div>
                            </div>
                            <form action="{{ route('orders.tailor-payment', $order) }}" method="POST" class="form-inline">
                                @csrf
                                <label class="sr-only" for="tailor_amount">Amount</label>
                                <input type="number" name="amount" id="tailor_amount" class="form-control form-control-sm mr-2"
                                       min="0.01" step="0.01" placeholder="Amount" required style="width: 120px;">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Record Tailor Payment</button>
                            </form>
                        @else
                            <p class="text-muted mb-0">No tailor assigned to this order.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Suits & Payments --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Suits &amp; Billing</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Color</th>
                                <th class="text-center">Qty</th>
                                <th class="text-right">Stitching</th>
                                <th class="text-right">Buttons</th>
                                <th class="text-right">Other</th>
                                <th>Note</th>
                                <th class="text-right">Row Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->suits as $suit)
                                <tr>
                                    <td>{{ $suit->color }}</td>
                                    <td class="text-center">{{ $suit->quantity }}</td>
                                    <td class="text-right">Rs {{ number_format($suit->stitching_charge, 2) }}</td>
                                    <td class="text-right">Rs {{ number_format($suit->button_charge, 2) }}</td>
                                    <td class="text-right">Rs {{ number_format($suit->other_charge, 2) }}</td>
                                    <td>{{ $suit->other_charge_note ?: '—' }}</td>
                                    <td class="text-right font-weight-bold">Rs {{ number_format($suit->suit_total, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr class="bg-light font-weight-bold">
                                <td colspan="6" class="text-right">TOTAL</td>
                                <td class="text-right">Rs {{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <span class="mr-4"><strong>Advance Paid:</strong> Rs {{ number_format($order->advance_paid, 2) }}</span>
                        <span class="{{ $order->balance_due > 0 ? 'text-warning font-weight-bold' : 'font-weight-bold' }}">
                            <strong>Balance Due:</strong> Rs {{ number_format($order->balance_due, 2) }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('orders.customer-payment', $order) }}" method="POST" class="form-inline justify-content-md-end">
                            @csrf
                            <label class="sr-only" for="customer_amount">Amount</label>
                            <input type="number" name="amount" id="customer_amount" class="form-control form-control-sm mr-2"
                                   min="0.01" step="0.01" placeholder="Payment amount" required style="width: 140px;">
                            <button type="submit" class="btn btn-sm btn-outline-success">Record Customer Payment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Measurements --}}
        @if($order->measurement)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Measurements</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($measurementFields as $field => $label)
                            @if($order->measurement->$field !== null)
                                <div class="col-md-3 col-sm-4 mb-3">
                                    <small class="text-muted d-block">{{ $label }}</small>
                                    <strong>{{ $order->measurement->$field }}"</strong>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @if($order->measurement->notes)
                        <hr>
                        <small class="text-muted d-block">Notes</small>
                        <p class="mb-0">{{ $order->measurement->notes }}</p>
                    @endif
                </div>
            </div>
        @endif

        {{-- Status History --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Status History</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Date</th>
                                <th>From</th>
                                <th>To</th>
                                <th>By</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->statusLogs as $log)
                                <tr>
                                    <td>{{ ($log->changed_at ?? $log->created_at)->format('d M, Y h:i A') }}</td>
                                    <td>{{ $log->oldStatus?->name ?? '—' }}</td>
                                    <td>{{ $log->newStatus?->name ?? '—' }}</td>
                                    <td>{{ $log->changedBy?->name ?? 'System' }}</td>
                                    <td>{{ $log->notes ?: '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">No status changes recorded.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($order->notes)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order Notes</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $order->notes }}</p>
                </div>
            </div>
        @endif
    </div>

    {{-- Update Status Modal --}}
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Update Order Status</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="status_id">New Status</label>
                            <select name="status_id" id="status_id" class="form-control" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" @selected($order->status_id == $status->id)>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label for="status_notes">Notes (optional)</label>
                            <textarea name="notes" id="status_notes" class="form-control" rows="3" placeholder="Reason for status change"></textarea>
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
        <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>
