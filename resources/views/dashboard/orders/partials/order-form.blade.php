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
    $newCustomerBranches = \App\Models\Branch::where('is_active', true)->orderBy('name')->get();
@endphp

<style>
    /* Suit rows: hide number spinners so values are fully visible in narrow columns */
    .suits-table input[type=number] { -moz-appearance: textfield; text-align: center; }
    .suits-table input[type=number]::-webkit-outer-spin-button,
    .suits-table input[type=number]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .suits-table .form-control-sm { min-width: 60px; }
    .suit-color-swatch {
        display: inline-block; width: 16px; height: 16px;
        border-radius: 3px; border: 1px solid #ccc; vertical-align: middle;
    }
    .suits-table .input-group-text { background-color: #fff; }
</style>

<div class="row g-4" x-data="orderForm(@js($initialSuits), {{ (float) old('advance_paid', $isEdit ? $order->advance_paid : 0) }})">
    {{-- Mobile / tablet summary (shown above form) --}}
    <div class="col-12 d-xl-none">
        @include('dashboard.orders.partials.order-summary')
    </div>

    <div class="col-xl-8">
        {{-- Section 1: Order Info --}}
        <x-ui.card title="Order Information" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="customer_input">Customer <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text"
                                   id="customer_input"
                                   class="form-control {{ isset($errors) && $errors->has('customer_id') ? 'is-invalid' : '' }}"
                                   list="customers-list"
                                   value="{{ $customerDisplay }}"
                                   placeholder="Search by name or phone"
                                   autocomplete="off"
                                   required>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-primary" title="Add new customer"
                                        data-toggle="modal" data-target="#addCustomerModal">
                                    <i class="las la-plus"></i>
                                </button>
                            </div>
                        </div>
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

                    <x-ui.form.input name="order_label" label="Order Label"
                        :value="$isEdit ? $order->order_label : ''"
                        placeholder="For Self / For Bilal / For Wife" />

                    <x-ui.form.input type="date" name="order_date" label="Order Date"
                        :value="$isEdit ? $order->order_date->format('Y-m-d') : $orderDate" required />

                    <x-ui.form.input type="date" name="delivery_date" label="Delivery Date"
                        :value="$isEdit && $order->delivery_date ? $order->delivery_date->format('Y-m-d') : ''" />
                </div>

                <div class="col-md-6">
                    <x-ui.form.select name="tailor_id" label="Assign Tailor"
                        :options="$tailors" :selected="$isEdit ? $order->tailor_id : ''"
                        placeholder="— Select tailor —" />

                    <x-ui.form.input type="number" name="tailor_fee_total" label="Tailor Fee"
                        :value="$isEdit ? $order->tailor_fee_total : 0" min="0" step="0.01" />

                    <x-ui.form.input type="number" name="advance_paid" label="Advance Paid"
                        :value="$isEdit ? $order->advance_paid : 0" min="0" step="0.01"
                        x-model.number="advancePaid" />

                    <x-ui.form.textarea name="notes" label="Notes"
                        :value="$isEdit ? $order->notes : ''" />
                </div>
            </div>
        </x-ui.card>

        {{-- Section 2: Suits --}}
        <x-ui.card class="mb-4" :noPadding="true">
            <x-slot:header>
                <h6 class="m-0 font-weight-bold text-primary">Suits</h6>
                <x-ui.button type="button" variant="outline-primary" size="sm" icon="las la-plus" @click="addSuit()">Add Suit</x-ui.button>
            </x-slot:header>

                <div class="table-responsive">
                    <table class="table table-bordered mb-0 suits-table">
                        <thead class="thead-light">
                            <tr>
                                <th>Color</th>
                                <th width="80">Qty</th>
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
                                        <div class="input-group input-group-sm flex-nowrap">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text px-2">
                                                    <span class="suit-color-swatch" :style="{ backgroundColor: hexFor(suit.color) }"></span>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" x-model="suit.color"
                                                   :name="'suits[' + index + '][color]'" list="suit-colors"
                                                   required placeholder="Pick or type a color">
                                        </div>
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
                {{-- Shared color suggestions: pick one of the 7 or type a new name --}}
                <datalist id="suit-colors">
                    <option value="Black"></option>
                    <option value="White"></option>
                    <option value="Navy Blue"></option>
                    <option value="Grey"></option>
                    <option value="Maroon"></option>
                    <option value="Beige"></option>
                    <option value="Olive Green"></option>
                </datalist>
                @if(isset($errors) && $errors->has('suits'))
                    <div class="text-danger small px-3 py-2">{{ $errors->first('suits') }}</div>
                @endif
                @if(isset($errors) && $errors->has('suits.*'))
                    <div class="text-danger small px-3 py-2">Please check suit row details.</div>
                @endif
        </x-ui.card>

        {{-- Section 3: Measurements --}}
        <x-ui.card class="mb-4">
            <x-slot:header>
                <button type="button" class="btn btn-link p-0 font-weight-bold text-primary text-decoration-none"
                        @click="measurementsOpen = !measurementsOpen">
                    <span x-text="measurementsOpen ? 'Hide Measurements ▲' : 'Add Measurements ▼'"></span>
                </button>
            </x-slot:header>

            <div x-show="measurementsOpen" x-cloak>
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
        </x-ui.card>

        <div class="mb-4">
            <x-ui.button type="submit" size="lg" icon="las la-save">{{ $isEdit ? 'Update Order' : 'Create Order' }}</x-ui.button>
            <x-ui.button :href="$isEdit ? route('orders.show', $order) : route('orders.index')" variant="outline-secondary" size="lg" class="ml-2">Cancel</x-ui.button>
        </div>
    </div>

    {{-- Desktop summary sidebar --}}
    <div class="col-xl-4 d-none d-xl-block">
        <div class="order-summary-sticky">
            @include('dashboard.orders.partials.order-summary')
        </div>
    </div>
</div>

{{-- Add New Customer modal (AJAX — no page reload) --}}
<x-ui.modal id="addCustomerModal" title="Add New Customer">
    <div id="ncErrors" class="alert alert-danger d-none"></div>

    <div class="form-group">
        <label for="nc_name">Name <span class="text-danger">*</span></label>
        <input type="text" id="nc_name" class="form-control" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="nc_phone">Phone <span class="text-danger">*</span></label>
        <input type="text" id="nc_phone" class="form-control" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="nc_address">Address</label>
        <textarea id="nc_address" class="form-control" rows="2"></textarea>
    </div>
    <div class="form-group">
        <label for="nc_branch_id">Branch</label>
        <select id="nc_branch_id" class="form-control">
            <option value="">— Select branch —</option>
            @foreach($newCustomerBranches as $b)
                <option value="{{ $b->id }}">{{ $b->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group mb-0">
        <label for="nc_notes">Notes</label>
        <textarea id="nc_notes" class="form-control" rows="2"></textarea>
    </div>

    <x-slot:footer>
        <x-ui.button variant="secondary" data-dismiss="modal">Cancel</x-ui.button>
        <x-ui.button type="button" id="ncSaveBtn" icon="las la-save">Save Customer</x-ui.button>
    </x-slot:footer>
</x-ui.modal>

@push('js')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.15.4/dist/cdn.min.js"></script>
<script>
    function orderForm(initialSuits, initialAdvance) {
        return {
            suits: initialSuits,
            advancePaid: initialAdvance,
            measurementsOpen: {{ ($isEdit && $measurement) ? 'true' : 'false' }},

            colorMap: {
                'Black': '#000000', 'White': '#FFFFFF', 'Navy Blue': '#1F3A5F',
                'Grey': '#808080', 'Maroon': '#800000', 'Beige': '#F5F5DC',
                'Olive Green': '#556B2F'
            },

            hexFor(name) {
                if (!name) return 'transparent';
                const key = name.trim();
                // Known names map to a precise hex; otherwise let the browser
                // try the raw value (CSS names like "red"/"green" still work).
                return this.colorMap[key] || key;
            },

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
        const customersList = document.getElementById('customers-list');

        function resolveCustomerId() {
            const value = customerInput.value.trim();
            let found = '';
            customersList.querySelectorAll('option').forEach(function (opt) {
                if (opt.value === value) {
                    found = opt.dataset.id || '';
                }
            });
            customerIdInput.value = found;
        }

        customerInput.addEventListener('change', resolveCustomerId);
        customerInput.addEventListener('blur', resolveCustomerId);

        /* ── Add new customer via AJAX ── */
        const CSRF = '{{ csrf_token() }}';
        const STORE_URL = '{{ route('customers.store') }}';
        const ncSaveBtn = document.getElementById('ncSaveBtn');
        const ncErrors = document.getElementById('ncErrors');

        function ncShowError(msg) {
            ncErrors.innerHTML = msg;
            ncErrors.classList.remove('d-none');
        }

        if (ncSaveBtn) {
            ncSaveBtn.addEventListener('click', function () {
                ncErrors.classList.add('d-none');
                ncErrors.innerHTML = '';
                ncSaveBtn.disabled = true;

                const payload = {
                    name:      document.getElementById('nc_name').value,
                    phone:     document.getElementById('nc_phone').value,
                    address:   document.getElementById('nc_address').value,
                    branch_id: document.getElementById('nc_branch_id').value,
                    notes:     document.getElementById('nc_notes').value,
                };

                fetch(STORE_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': CSRF
                    },
                    body: JSON.stringify(payload)
                }).then(async function (res) {
                    let data = {};
                    try { data = await res.json(); } catch (e) {}

                    if (res.ok && data.customer) {
                        const c = data.customer;
                        const label = c.name + ' - ' + c.phone;

                        // Add to datalist and select it immediately
                        const opt = document.createElement('option');
                        opt.value = label;
                        opt.dataset.id = c.id;
                        customersList.appendChild(opt);

                        customerInput.value = label;
                        customerIdInput.value = c.id;
                        customerInput.classList.remove('is-invalid');

                        // Reset modal fields
                        ['nc_name', 'nc_phone', 'nc_address', 'nc_notes'].forEach(function (id) {
                            document.getElementById(id).value = '';
                        });
                        document.getElementById('nc_branch_id').value = '';

                        if (window.jQuery) {
                            jQuery('#addCustomerModal').modal('hide');
                        }
                    } else if (res.status === 422 && data.errors) {
                        ncShowError(Object.values(data.errors).flat()
                            .map(function (e) { return '• ' + e; }).join('<br>'));
                    } else {
                        ncShowError(data.message || 'Something went wrong. Please try again.');
                    }
                }).catch(function () {
                    ncShowError('Network error. Please try again.');
                }).finally(function () {
                    ncSaveBtn.disabled = false;
                });
            });
        }
    });
</script>
@endpush
