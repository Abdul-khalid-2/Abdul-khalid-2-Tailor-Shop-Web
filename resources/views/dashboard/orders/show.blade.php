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
    $whatsappUrl = $order->billWhatsappUrl();
@endphp

<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.session-alerts />

        {{-- Header --}}
        <x-ui.card class="mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start">
                <div>
                    <h4 class="mb-2">{{ $order->order_number }}</h4>
                    @if($order->order_label)
                        <p class="text-muted mb-2">{{ $order->order_label }}</p>
                    @endif
                    <div class="mb-2"><x-ui.order-status-badge :order="$order" /></div>
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
                    <x-ui.button :href="route('orders.bill', $order)" target="_blank" variant="outline-dark" icon="las la-receipt" class="mr-2 mb-2">Bill</x-ui.button>
                    <x-ui.button :href="route('orders.bill', ['order' => $order, 'autoprint' => 1])" target="_blank" variant="outline-primary" icon="las la-print" class="mr-2 mb-2">Print Bill</x-ui.button>
                    <x-ui.button :href="$whatsappUrl" target="_blank" variant="outline-success" icon="lab la-whatsapp" class="mr-2 mb-2">WhatsApp</x-ui.button>
                    <x-ui.button :href="route('orders.edit', $order)" icon="las la-edit" class="mr-2 mb-2">Edit</x-ui.button>
                    <x-ui.button variant="outline-info" icon="las la-sync" class="mr-2 mb-2" data-toggle="modal" data-target="#statusModal">Update Status</x-ui.button>
                    <x-ui.button :href="route('orders.index')" variant="outline-secondary" icon="las la-arrow-left" class="mb-2">Back</x-ui.button>
                </div>
            </div>
        </x-ui.card>

        {{-- Customer & Tailor --}}
        <div class="row mb-4">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <x-ui.card title="Customer" class="h-100">
                    <h5 class="font-weight-bold mb-2">
                        <a href="{{ route('customers.show', $order->customer) }}">{{ $order->customer?->name }}</a>
                    </h5>
                    <p class="mb-1"><i class="las la-phone mr-1"></i> {{ $order->customer?->phone }}</p>
                    @if($order->customer?->address)
                        <p class="mb-0 text-muted"><i class="las la-map-marker mr-1"></i> {{ $order->customer->address }}</p>
                    @endif
                </x-ui.card>
            </div>
            <div class="col-lg-6">
                <x-ui.card title="Tailor" class="h-100">
                    @if($order->tailor)
                        <h5 class="font-weight-bold mb-2">{{ $order->tailor->name }}</h5>
                        <p class="mb-1"><i class="las la-phone mr-1"></i> {{ $order->tailor->phone }}</p>
                        <p class="mb-1">
                            <strong>Specialty:</strong>
                            {{ $specialtyLabels[$order->tailor->specialty] ?? $order->tailor->specialty }}
                        </p>
                        <p class="mb-3">
                            <strong>Status:</strong>
                            <x-ui.badge :variant="$order->tailor->status === 'active' ? 'success' : 'warning'">
                                {{ ucfirst(str_replace('_', ' ', $order->tailor->status)) }}
                            </x-ui.badge>
                        </p>
                        <div class="row mb-3">
                            <div class="col-4">
                                <small class="text-muted d-block">Fee Total</small>
                                <strong><x-ui.currency :amount="$order->tailor_fee_total" /></strong>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Fee Paid</small>
                                <strong><x-ui.currency :amount="$order->tailor_fee_paid" /></strong>
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
                            <x-ui.button type="submit" variant="outline-primary" size="sm">Record Tailor Payment</x-ui.button>
                        </form>
                    @else
                        <p class="text-muted mb-0">No tailor assigned to this order.</p>
                    @endif
                </x-ui.card>
            </div>
        </div>

        {{-- Suits & Payments --}}
        <x-ui.card title="Suits &amp; Billing" class="mb-4" :noPadding="true">
            <x-ui.table :hover="false">
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
                            <td class="text-right"><x-ui.currency :amount="$suit->stitching_charge" /></td>
                            <td class="text-right"><x-ui.currency :amount="$suit->button_charge" /></td>
                            <td class="text-right"><x-ui.currency :amount="$suit->other_charge" /></td>
                            <td>{{ $suit->other_charge_note ?: '—' }}</td>
                            <td class="text-right font-weight-bold"><x-ui.currency :amount="$suit->suit_total" /></td>
                        </tr>
                    @endforeach
                    <tr class="bg-light font-weight-bold">
                        <td colspan="6" class="text-right">TOTAL</td>
                        <td class="text-right"><x-ui.currency :amount="$order->total_amount" /></td>
                    </tr>
                </tbody>
            </x-ui.table>

            <x-slot:footer>
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
                            <x-ui.button type="submit" variant="outline-success" size="sm">Record Customer Payment</x-ui.button>
                        </form>
                    </div>
                </div>
            </x-slot:footer>
        </x-ui.card>

        {{-- Measurements --}}
        @if($order->measurement)
            <x-ui.card title="Measurements" class="mb-4">
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
            </x-ui.card>
        @endif

        {{-- Status History --}}
        <x-ui.card title="Status History" class="mb-4" :noPadding="true">
            <x-ui.table :hover="false">
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
                        <x-ui.empty-state icon="" title="No status changes recorded." :colspan="5" :asRow="true" />
                    @endforelse
                </tbody>
            </x-ui.table>
        </x-ui.card>

        @if($order->notes)
            <x-ui.card title="Order Notes" class="mb-4">
                <p class="mb-0">{{ $order->notes }}</p>
            </x-ui.card>
        @endif
    </div>

    {{-- Update Status Modal --}}
    <x-ui.modal id="statusModal" title="Update Order Status">
        <form id="statusForm" action="{{ route('orders.update-status', $order) }}" method="POST">
            @csrf
            @method('PATCH')
            <x-ui.form.select name="status_id" label="New Status" :options="$statuses" :selected="$order->status_id" required />
            <x-ui.form.textarea name="notes" label="Notes (optional)" placeholder="Reason for status change" class="mb-0" />
        </form>

        <x-slot:footer>
            <x-ui.button variant="secondary" data-dismiss="modal">Cancel</x-ui.button>
            <x-ui.button type="submit" form="statusForm">Update Status</x-ui.button>
        </x-slot:footer>
    </x-ui.modal>
</x-app-layout>
