@php
    use App\Models\OrderStatus;

    $statuses = OrderStatus::orderBy('sort_order')->get();
    $specialtyLabels = [
        'shalwar_kameez' => 'Shalwar Kameez',
        'sherwani' => 'Sherwani',
        'all' => 'All Types',
    ];
    $measurementFields = [
        'length' => __('messages.m_length'), 'shoulder' => __('messages.m_shoulder'),
        'chest' => __('messages.m_chest'), 'waist' => __('messages.m_waist'),
        'hip' => __('messages.m_hip'), 'sleeve' => __('messages.m_sleeve'), 'collar' => __('messages.m_collar'),
        'trouser_length' => __('messages.m_trouser_length'), 'trouser_waist' => __('messages.m_trouser_waist'),
        'thigh' => __('messages.m_thigh'), 'bottom_opening' => __('messages.m_bottom_opening'),
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
                        <span class="mr-3"><strong>{{ __('messages.order_date') }}:</strong> {{ $order->order_date->format('d M, Y') }}</span>
                        <span>
                            <strong>{{ __('messages.delivery_date') }}:</strong>
                            @if($order->delivery_date)
                                {{ $order->delivery_date->format('d M, Y') }}
                                @if($order->isOverdue())
                                    <span class="text-danger font-weight-bold ml-1">{{ __('messages.overdue_flag') }}</span>
                                @endif
                            @else
                                —
                            @endif
                        </span>
                    </div>
                </div>
                <div class="d-flex flex-wrap mt-2 mt-md-0">
                    <x-ui.button :href="route('orders.bill', $order)" target="_blank" variant="outline-dark" icon="las la-receipt" class="mr-2 mb-2">{{ __('messages.bill') }}</x-ui.button>
                    <x-ui.button :href="route('orders.bill', ['order' => $order, 'autoprint' => 1])" target="_blank" variant="outline-primary" icon="las la-print" class="mr-2 mb-2">{{ __('messages.print_bill') }}</x-ui.button>
                    <x-ui.button :href="$whatsappUrl" target="_blank" variant="outline-success" icon="lab la-whatsapp" class="mr-2 mb-2">{{ __('messages.whatsapp') }}</x-ui.button>
                    <x-ui.button :href="route('orders.edit', $order)" icon="las la-edit" class="mr-2 mb-2">{{ __('messages.edit') }}</x-ui.button>
                    <x-ui.button variant="outline-info" icon="las la-sync" class="mr-2 mb-2" data-toggle="modal" data-target="#statusModal">{{ __('messages.update_status') }}</x-ui.button>
                    <x-ui.button :href="route('orders.index')" variant="outline-secondary" icon="las la-arrow-left" class="mb-2">{{ __('messages.back') }}</x-ui.button>
                </div>
            </div>
        </x-ui.card>

        {{-- Customer & Tailor --}}
        <div class="row mb-4">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <x-ui.card :title="__('messages.customer')" class="h-100">
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
                <x-ui.card :title="__('messages.tailor')" class="h-100">
                    @if($order->tailor)
                        <h5 class="font-weight-bold mb-2">{{ $order->tailor->name }}</h5>
                        <p class="mb-1"><i class="las la-phone mr-1"></i> {{ $order->tailor->phone }}</p>
                        <p class="mb-1">
                            <strong>{{ __('messages.specialty') }}:</strong>
                            {{ $specialtyLabels[$order->tailor->specialty] ?? $order->tailor->specialty }}
                        </p>
                        <p class="mb-3">
                            <strong>{{ __('messages.status') }}:</strong>
                            <x-ui.badge :variant="$order->tailor->status === 'active' ? 'success' : 'warning'">
                                {{ $order->tailor->status === 'active' ? __('messages.active') : __('messages.on_leave') }}
                            </x-ui.badge>
                        </p>
                        <div class="row mb-3">
                            <div class="col-4">
                                <small class="text-muted d-block">{{ __('messages.fee_total') }}</small>
                                <strong><x-ui.currency :amount="$order->tailor_fee_total" /></strong>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">{{ __('messages.fee_paid') }}</small>
                                <strong><x-ui.currency :amount="$order->tailor_fee_paid" /></strong>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">{{ __('messages.fee_balance') }}</small>
                                <strong class="{{ $order->tailor_fee_balance > 0 ? 'text-danger' : '' }}">
                                    Rs {{ number_format($order->tailor_fee_balance, 2) }}
                                </strong>
                            </div>
                        </div>
                        <form action="{{ route('orders.tailor-payment', $order) }}" method="POST" class="form-inline">
                            @csrf
                            <label class="sr-only" for="tailor_amount">{{ __('messages.amount_ph') }}</label>
                            <input type="number" name="amount" id="tailor_amount" class="form-control form-control-sm mr-2"
                                   min="0.01" step="0.01" placeholder="{{ __('messages.amount_ph') }}" required style="width: 120px;">
                            <x-ui.button type="submit" variant="outline-primary" size="sm">{{ __('messages.record_tailor_payment') }}</x-ui.button>
                        </form>
                    @else
                        <p class="text-muted mb-0">{{ __('messages.no_tailor_assigned') }}</p>
                    @endif
                </x-ui.card>
            </div>
        </div>

        {{-- Suits & Payments --}}
        <x-ui.card :title="__('messages.suits_billing')" class="mb-4" :noPadding="true">
            <x-ui.table :hover="false">
                <thead class="thead-light">
                    <tr>
                        <th>{{ __('messages.color') }}</th>
                        <th class="text-center">{{ __('messages.qty') }}</th>
                        <th class="text-right">{{ __('messages.stitching') }}</th>
                        <th class="text-right">{{ __('messages.buttons') }}</th>
                        <th class="text-right">{{ __('messages.other') }}</th>
                        <th>{{ __('messages.note') }}</th>
                        <th class="text-right">{{ __('messages.row_total') }}</th>
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
                        <td colspan="6" class="text-right">{{ __('messages.total') }}</td>
                        <td class="text-right"><x-ui.currency :amount="$order->total_amount" /></td>
                    </tr>
                </tbody>
            </x-ui.table>

            <x-slot:footer>
                <div class="row align-items-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <span class="mr-4"><strong>{{ __('messages.advance_paid_label') }}:</strong> Rs {{ number_format($order->advance_paid, 2) }}</span>
                        <span class="{{ $order->balance_due > 0 ? 'text-warning font-weight-bold' : 'font-weight-bold' }}">
                            <strong>{{ __('messages.balance_due_label') }}:</strong> Rs {{ number_format($order->balance_due, 2) }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('orders.customer-payment', $order) }}" method="POST" class="form-inline justify-content-md-end">
                            @csrf
                            <label class="sr-only" for="customer_amount">{{ __('messages.amount_ph') }}</label>
                            <input type="number" name="amount" id="customer_amount" class="form-control form-control-sm mr-2"
                                   min="0.01" step="0.01" placeholder="{{ __('messages.payment_amount_ph') }}" required style="width: 140px;">
                            <x-ui.button type="submit" variant="outline-success" size="sm">{{ __('messages.record_customer_payment') }}</x-ui.button>
                        </form>
                    </div>
                </div>
            </x-slot:footer>
        </x-ui.card>

        {{-- Measurements --}}
        @if($order->measurement)
            <x-ui.card :title="__('messages.measurements')" class="mb-4">
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
                    <small class="text-muted d-block">{{ __('messages.notes') }}</small>
                    <p class="mb-0">{{ $order->measurement->notes }}</p>
                @endif
            </x-ui.card>
        @endif

        {{-- Status History --}}
        <x-ui.card :title="__('messages.status_history')" class="mb-4" :noPadding="true">
            <x-ui.table :hover="false">
                <thead class="thead-light">
                    <tr>
                        <th>{{ __('messages.date') }}</th>
                        <th>{{ __('messages.from') }}</th>
                        <th>{{ __('messages.to') }}</th>
                        <th>{{ __('messages.by') }}</th>
                        <th>{{ __('messages.notes') }}</th>
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
                        <x-ui.empty-state icon="" :title="__('messages.no_status_changes')" :colspan="5" :asRow="true" />
                    @endforelse
                </tbody>
            </x-ui.table>
        </x-ui.card>

        @if($order->notes)
            <x-ui.card :title="__('messages.order_notes')" class="mb-4">
                <p class="mb-0">{{ $order->notes }}</p>
            </x-ui.card>
        @endif
    </div>

    {{-- Update Status Modal --}}
    <x-ui.modal id="statusModal" :title="__('messages.update_order_status')">
        <form id="statusForm" action="{{ route('orders.update-status', $order) }}" method="POST">
            @csrf
            @method('PATCH')
            <x-ui.form.select name="status_id" :label="__('messages.new_status')" :options="$statuses" :selected="$order->status_id" required />
            <x-ui.form.textarea name="notes" :label="__('messages.notes_optional')" :placeholder="__('messages.reason_for_status')" class="mb-0" />
        </form>

        <x-slot:footer>
            <x-ui.button variant="secondary" data-dismiss="modal">{{ __('messages.cancel') }}</x-ui.button>
            <x-ui.button type="submit" form="statusForm">{{ __('messages.update_status') }}</x-ui.button>
        </x-slot:footer>
    </x-ui.modal>
</x-app-layout>
