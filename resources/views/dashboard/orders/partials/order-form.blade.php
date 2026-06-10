@php
    $isEdit = isset($order);
    $customerDisplay = old('customer_display', $isEdit && $order->customer
        ? $order->customer->name . ' - ' . $order->customer->phone
        : '');
    $customerId = old('customer_id', $isEdit ? $order->customer_id : '');
    $orderDateValue = old('order_date', $isEdit ? $order->order_date->format('Y-m-d') : $orderDate);
    $deliveryDateValue = old('delivery_date', $isEdit && $order->delivery_date ? $order->delivery_date->format('Y-m-d') : '');
    $initialSuits = old('suits', $isEdit
        ? $order->suits->map(fn ($s) => [
            'color' => $s->color,
            'quantity' => $s->quantity,
            'stitching_charge' => $s->stitching_charge,
            'button_charge' => $s->button_charge,
            'other_charge' => $s->other_charge,
            'other_charge_note' => $s->other_charge_note ?? '',
            'notes' => $s->notes ?? '',
        ])->values()->all()
        : [['color' => '', 'quantity' => 1, 'stitching_charge' => 0, 'button_charge' => 0, 'other_charge' => 0, 'other_charge_note' => '', 'notes' => '']]);
    $measurement = $isEdit ? $order->measurement : null;
    $measurementFields = [
        'length', 'shoulder', 'chest', 'waist', 'hip', 'sleeve', 'collar',
        'trouser_length', 'trouser_waist', 'thigh', 'bottom_opening',
    ];
    $measurementLabels = [
        'length' => 'Length', 'shoulder' => 'Shoulder', 'chest' => 'Chest', 'waist' => 'Waist',
        'hip' => 'Hip', 'sleeve' => 'Sleeve', 'collar' => 'Collar',
        'trouser_length' => 'Trouser Length', 'trouser_waist' => 'Trouser Waist',
        'thigh' => 'Thigh', 'bottom_opening' => 'Bottom Opening',
    ];
@endphp

<div class="row" x-data="orderForm(@js($initialSuits), {{ (float) old('advance_paid', $isEdit ? $order->advance_paid : 0) }})">
    <div class="col-lg-8">
        {{-- Section 1: Order Info --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Order Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="customer_input">Customer <span class="text-danger">*</span></label>
                            <input type="text"
                                   id="customer_input"
                                   class="form-control {{ isset($errors) && $errors->has('customer_id') ? 'is-invalid' : '' }}"
                                   list="customers-list"
                                   value="{{ $customerDisplay }}"
                                   placeholder="Search by name or phone"
                                   autocomplete="off"
                                   required>
                            <datalist id="customers-list">
                                @foreach($customers as $c)
                                    <option value="{{ $c->name }} - {{ $c->phone }}" data-id="{{ $c->id }}"></option>
                                @endforeach
                            </datalist>
                            <input type="hidden" name="customer_id" id="customer_id" value="{{ $customerId }}">
                            @if(isset($errors) && $errors->has('customer_id'))
                                <div class="invalid-feedback d-block">{{ $errors->first('customer_id') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="order_label">Order Label</label>
                            <input type="text" name="order_label" id="order_label" class="form-control"
                                   value="{{ old('order_label', $isEdit ? $order->order_label : '') }}"
                                   placeholder="For Self / For Bilal / For Wife">
                        </div>

                        <div class="form-group">
                            <label for="order_date">Order Date <span class="text-danger">*</span></label>
                            <input type="date" name="order_date" id="order_date" class="form-control {{ isset($errors) && $errors->has('order_date') ? 'is-invalid' : '' }}"
                                   value="{{ $orderDateValue }}" required>
                            @if(isset($errors) && $errors->has('order_date'))
                                <div class="invalid-feedback">{{ $errors->first('order_date') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="delivery_date">Delivery Date</label>
                            <input type="date" name="delivery_date" id="delivery_date" class="form-control {{ isset($errors) && $errors->has('delivery_date') ? 'is-invalid' : '' }}"
                                   value="{{ $deliveryDateValue }}">
                            @if(isset($errors) && $errors->has('delivery_date'))
                                <div class="invalid-feedback">{{ $errors->first('delivery_date') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tailor_id">Assign Tailor</label>
                            <select name="tailor_id" id="tailor_id" class="form-control">
                                <option value="">— Select tailor —</option>
                                @foreach($tailors as $tailor)
                                    <option value="{{ $tailor->id }}" @selected(old('tailor_id', $isEdit ? $order->tailor_id : '') == $tailor->id)>
                                        {{ $tailor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tailor_fee_total">Tailor Fee</label>
                            <input type="number" name="tailor_fee_total" id="tailor_fee_total" class="form-control" min="0" step="0.01"
                                   value="{{ old('tailor_fee_total', $isEdit ? $order->tailor_fee_total : 0) }}">
                        </div>

                        <div class="form-group">
                            <label for="advance_paid">Advance Paid</label>
                            <input type="number" name="advance_paid" id="advance_paid" class="form-control" min="0" step="0.01"
                                   x-model.number="advancePaid"
                                   value="{{ old('advance_paid', $isEdit ? $order->advance_paid : 0) }}">
                        </div>

                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $isEdit ? $order->notes : '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2: Suits --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Suits</h6>
                <button type="button" class="btn btn-sm btn-outline-primary" @click="addSuit()">
                    <i class="las la-plus"></i> Add Suit
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Color</th>
                                <th width="70">Qty</th>
                                <th width="100">Stitching</th>
                                <th width="100">Buttons</th>
                                <th width="100">Other</th>
                                <th>Note</th>
                                <th width="100" class="text-right">Row Total</th>
                                <th width="50"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(suit, index) in suits" :key="index">
                                <tr>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" x-model="suit.color"
                                               :name="'suits[' + index + '][color]'" required placeholder="e.g. Green">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" x-model.number="suit.quantity" min="1"
                                               :name="'suits[' + index + '][quantity]'" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" x-model.number="suit.stitching_charge" min="0" step="0.01"
                                               :name="'suits[' + index + '][stitching_charge]'">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" x-model.number="suit.button_charge" min="0" step="0.01"
                                               :name="'suits[' + index + '][button_charge]'">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" x-model.number="suit.other_charge" min="0" step="0.01"
                                               :name="'suits[' + index + '][other_charge]'">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" x-model="suit.other_charge_note"
                                               :name="'suits[' + index + '][other_charge_note]'" placeholder="Other charge note">
                                        <input type="hidden" x-model="suit.notes" :name="'suits[' + index + '][notes]'">
                                    </td>
                                    <td class="text-right align-middle font-weight-bold" x-text="'Rs ' + rowTotal(suit).toFixed(2)"></td>
                                    <td class="text-center align-middle">
                                        <button type="button" class="btn btn-sm btn-outline-danger" @click="removeSuit(index)" x-show="suits.length > 1" title="Remove">
                                            <i class="las la-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                @if(isset($errors) && $errors->has('suits'))
                    <div class="text-danger small px-3 py-2">{{ $errors->first('suits') }}</div>
                @endif
                @if(isset($errors) && $errors->has('suits.*'))
                    <div class="text-danger small px-3 py-2">Please check suit row details.</div>
                @endif
            </div>
        </div>

        {{-- Section 3: Measurements --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button type="button" class="btn btn-link p-0 font-weight-bold text-primary text-decoration-none"
                        @click="measurementsOpen = !measurementsOpen">
                    <span x-text="measurementsOpen ? 'Hide Measurements ▲' : 'Add Measurements ▼'"></span>
                </button>
            </div>
            <div class="card-body" x-show="measurementsOpen" x-cloak>
                <div class="row">
                    @foreach($measurementFields as $field)
                        <div class="col-md-4 mb-3">
                            <label for="measurement_{{ $field }}">{{ $measurementLabels[$field] }}</label>
                            <input type="number" name="measurement[{{ $field }}]" id="measurement_{{ $field }}"
                                   class="form-control" step="0.1" min="0" placeholder="inches"
                                   value="{{ old('measurement.'.$field, $measurement?->$field) }}">
                        </div>
                    @endforeach
                    <div class="col-12">
                        <label for="measurement_notes">Measurement Notes</label>
                        <textarea name="measurement[notes]" id="measurement_notes" class="form-control" rows="2"
                                  placeholder="Optional notes">{{ old('measurement.notes', $measurement?->notes) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="las la-save mr-1"></i> {{ $isEdit ? 'Update Order' : 'Create Order' }}
            </button>
            <a href="{{ $isEdit ? route('orders.show', $order) : route('orders.index') }}" class="btn btn-outline-secondary btn-lg ml-2">Cancel</a>
        </div>
    </div>

    {{-- Summary Bar --}}
    <div class="col-lg-4">
        <div class="card shadow border-left-primary sticky-top" style="top: 1rem;">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Order Summary</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Total Amount</span>
                    <span class="font-weight-bold h5 mb-0" x-text="'Rs ' + totalAmount.toFixed(2)"></span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Advance Paid</span>
                    <span class="font-weight-bold" x-text="'Rs ' + (parseFloat(advancePaid) || 0).toFixed(2)"></span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="font-weight-bold">Balance Due</span>
                    <span class="font-weight-bold h5 mb-0" :class="balanceDue > 0 ? 'text-warning' : 'text-success'"
                          x-text="'Rs ' + balanceDue.toFixed(2)"></span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.15.4/dist/cdn.min.js"></script>
<script>
    function orderForm(initialSuits, initialAdvance) {
        return {
            suits: initialSuits,
            advancePaid: initialAdvance,
            measurementsOpen: {{ ($isEdit && $measurement) ? 'true' : 'false' }},

            rowTotal(suit) {
                const qty = parseFloat(suit.quantity) || 0;
                const stitch = parseFloat(suit.stitching_charge) || 0;
                const btn = parseFloat(suit.button_charge) || 0;
                const other = parseFloat(suit.other_charge) || 0;
                return (stitch + btn + other) * qty;
            },

            get totalAmount() {
                return this.suits.reduce((sum, suit) => sum + this.rowTotal(suit), 0);
            },

            get balanceDue() {
                const advance = parseFloat(this.advancePaid) || 0;
                return Math.max(0, this.totalAmount - advance);
            },

            addSuit() {
                this.suits.push({
                    color: '', quantity: 1, stitching_charge: 0, button_charge: 0,
                    other_charge: 0, other_charge_note: '', notes: ''
                });
            },

            removeSuit(index) {
                if (this.suits.length > 1) {
                    this.suits.splice(index, 1);
                }
            }
        };
    }

    document.addEventListener('DOMContentLoaded', function () {
        const customerInput = document.getElementById('customer_input');
        const customerIdInput = document.getElementById('customer_id');
        const options = document.querySelectorAll('#customers-list option');

        function resolveCustomerId() {
            const value = customerInput.value.trim();
            let found = '';
            options.forEach(function (opt) {
                if (opt.value === value) {
                    found = opt.dataset.id || '';
                }
            });
            customerIdInput.value = found;
        }

        customerInput.addEventListener('change', resolveCustomerId);
        customerInput.addEventListener('blur', resolveCustomerId);
    });
</script>
@endpush
