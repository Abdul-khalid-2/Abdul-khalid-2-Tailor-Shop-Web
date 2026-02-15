<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/nano.min.css"/>
    <style>
        .order-item-card {
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            position: relative;
        }
        .order-item-header {
            background-color: #f8f9fa;
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
            border-radius: 0.5rem 0.5rem 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .remove-item-btn {
            color: #dc3545;
            cursor: pointer;
            transition: all 0.3s;
        }
        .remove-item-btn:hover {
            color: #bd2130;
            transform: scale(1.1);
        }
        .item-count-badge {
            background-color: #007bff;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.875rem;
        }
        .add-item-card {
            border: 2px dashed #dee2e6;
            border-radius: 0.5rem;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 1.5rem;
        }
        .add-item-card:hover {
            border-color: #007bff;
            background-color: #f8f9fa;
        }
        .add-item-card i {
            font-size: 2rem;
            color: #6c757d;
            transition: all 0.3s;
        }
        .add-item-card:hover i {
            color: #007bff;
        }
        .total-section {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
        }
        .grand-total {
            font-size: 1.5rem;
            font-weight: bold;
            color: #28a745;
        }
        .measurement-section {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 1rem;
            margin-top: 1rem;
            border-radius: 0.25rem;
        }
        .fabric-section {
            background-color: #d1ecf1;
            border-left: 4px solid #17a2b8;
            padding: 1rem;
            margin-top: 1rem;
            border-radius: 0.25rem;
        }
        .price-summary {
            background-color: #e9ecef;
            padding: 1rem;
            border-radius: 0.375rem;
        }
        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        .price-row.total {
            border-top: 1px solid #dee2e6;
            margin-top: 0.5rem;
            padding-top: 0.5rem;
            font-weight: bold;
            font-size: 1.1rem;
        }
        .bg-success-light {
            background-color: #d4edda;
        }
        .color-picker-container {
            display: none;
            position: absolute;
            z-index: 1000;
            background: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
        }
    </style>
    @endpush

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-3">{{ __('Edit Order: :order_number', ['order_number' => $order->order_number]) }}</h4>
                <p class="mb-0">{{ __('Update order for :customer_name', ['customer_name' => $order->customer->name]) }}</p>
            </div>
            <div>
                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-info mr-2">
                    <i class="las la-eye mr-1"></i> {{ __('View Order') }}
                </a>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left mr-1"></i> {{ __('Back to Orders') }}
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="las la-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="las la-exclamation-circle mr-2"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Order Form -->
        <form action="{{ route('orders.update', $order) }}" method="POST" id="orderForm">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- Customer & Basic Info -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">{{ __('Customer & Order Information') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('Customer') }} *</label>
                                            <select class="form-control select2" id="customer_id" name="customer_id" required>
                                                <option value="">{{ __('Select Customer') }}</option>
                                                @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" 
                                                    data-phone="{{ $customer->phone }}"
                                                    data-address="{{ $customer->address }}"
                                                    data-type="{{ $customer->customer_type }}"
                                                    data-discount="{{ $customer->discount_rate }}"
                                                    {{ $order->customer_id == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }} ({{ $customer->phone }})
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('customer_id')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('Order Date') }} *</label>
                                            <input type="date" class="form-control" name="order_date" 
                                                   value="{{ old('order_date', $order->order_date->format('Y-m-d')) }}" required>
                                            @error('order_date')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('Order Number') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">#</span>
                                                </div>
                                                <input type="text" class="form-control font-weight-bold" 
                                                       value="{{ $order->order_number }}" readonly>
                                                <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('Branch') }} *</label>
                                            <select class="form-control select2" name="branch_id" required>
                                                <option value="">{{ __('Select Branch') }}</option>
                                                @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ old('branch_id', $order->branch_id) == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('branch_id')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('Order Status') }} *</label>
                                            <select class="form-control select2" name="status_id" required>
                                                @foreach($orderStatuses as $status)
                                                <option value="{{ $status->id }}" 
                                                        style="color: {{ $status->color }}"
                                                        {{ old('status_id', $order->status_id) == $status->id ? 'selected' : '' }}>
                                                    {{ $status->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('status_id')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('Payment Status') }} *</label>
                                            <select class="form-control select2" name="payment_status_id" required>
                                                @foreach($paymentStatuses as $status)
                                                <option value="{{ $status->id }}" 
                                                        style="color: {{ $status->color }}"
                                                        {{ old('payment_status_id', $order->payment_status_id) == $status->id ? 'selected' : '' }}>
                                                    {{ $status->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('payment_status_id')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('Delivery Date') }} *</label>
                                            <input type="date" class="form-control" id="delivery_date" name="delivery_date" 
                                                   value="{{ old('delivery_date', $order->delivery_date->format('Y-m-d')) }}" required>
                                            @error('delivery_date')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('Order Notes') }}</label>
                                            <textarea class="form-control" name="notes" rows="2" 
                                                      placeholder="{{ __('General notes about the order...') }}">{{ old('notes', $order->notes) }}</textarea>
                                            @error('notes')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items Container -->
                            <div id="orderItemsContainer">
                                @foreach($order->items as $index => $item)
                                    @include('dashboard.orders.partials.edit-order-item', [
                                        'index' => $index,
                                        'item' => $item,
                                        'dressTypes' => $dressTypes,
                                        'tailors' => $tailors,
                                        'fabrics' => $fabrics,
                                        'enabledFields' => $enabledFields,
                                        'measurement' => $item->measurements->first(),
                                        'assignment' => $item->tailorAssignments->first()
                                    ])
                                @endforeach
                            </div>

                            <!-- Add More Items Button -->
                            <div class="add-item-card" id="addItemBtn">
                                <i class="las la-plus-circle"></i>
                                <h6 class="mt-2 mb-0">{{ __('Add Another Item') }}</h6>
                                <small class="text-muted">{{ __('Click to add more clothes to this order') }}</small>
                            </div>

                            <!-- Order Summary & Payment -->
                            <div class="card mb-4 mt-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">{{ __('Order Summary & Payment') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="price-summary">
                                                <div class="price-row">
                                                    <span>{{ __('Sub Total') }}:</span>
                                                    <span id="subTotal">Rs {{ number_format($order->total_amount, 0) }}</span>
                                                </div>
                                                <div class="price-row">
                                                    <span>{{ __('Total Fabric Cost') }}:</span>
                                                    <span id="totalFabricCost">Rs {{ number_format($order->items->sum('fabric_cost'), 0) }}</span>
                                                </div>
                                                <div class="price-row">
                                                    <span>{{ __('Total Stitching Charges') }}:</span>
                                                    <span id="totalStitchingCharges">Rs {{ number_format($order->items->sum(function($item) { 
                                                        return $item->tailorAssignments->sum('stitching_charge'); 
                                                    }), 0) }}</span>
                                                </div>
                                                <div class="price-row">
                                                    <span>{{ __('Total Additional Charges') }}:</span>
                                                    <span id="totalAdditionalCharges">Rs {{ number_format($order->items->sum('additional_charges'), 0) }}</span>
                                                </div>
                                                <div class="price-row">
                                                    <span>{{ __('Total Discount') }}:</span>
                                                    <span id="totalDiscount" class="text-danger">- Rs {{ number_format($order->discount_amount, 0) }}</span>
                                                </div>
                                                <div class="price-row total">
                                                    <span>{{ __('Grand Total') }}:</span>
                                                    <span id="grandTotal" class="grand-total">Rs {{ number_format($order->final_amount, 0) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="mb-3">{{ __('Payment Details') }}</h6>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">{{ __('Advance Paid') }} *</label>
                                                        <input type="number" step="0.01" class="form-control" id="advance_amount" 
                                                               name="advance_amount" value="{{ old('advance_amount', $order->advance_amount) }}" required>
                                                        @error('advance_amount')
                                                        <div class="text-danger small">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">{{ __('Discount Amount') }}</label>
                                                        <input type="number" step="0.01" class="form-control" id="order_discount" 
                                                               name="discount_amount" value="{{ old('discount_amount', $order->discount_amount) }}">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">{{ __('Payment Method') }}</label>
                                                        <select class="form-control" name="payment_method_id">
                                                            @foreach($paymentMethods as $method)
                                                            <option value="{{ $method->id }}" {{ old('payment_method_id', 1) == $method->id ? 'selected' : '' }}>
                                                                {{ $method->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-0">
                                                        <label class="form-label">{{ __('Balance Due') }}</label>
                                                        <input type="number" step="0.01" class="form-control font-weight-bold text-danger" 
                                                               id="balance_due" value="{{ $order->remaining_amount }}" readonly>
                                                        <input type="hidden" name="remaining_amount" id="remaining_amount" value="{{ $order->remaining_amount }}">
                                                        <input type="hidden" name="final_amount" id="final_amount" value="{{ $order->final_amount }}">
                                                        <input type="hidden" name="total_amount" id="total_amount" value="{{ $order->total_amount }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Internal Notes -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">{{ __('Internal Notes') }}</h6>
                                </div>
                                <div class="card-body">
                                    <textarea class="form-control" name="internal_notes" rows="3" 
                                              placeholder="{{ __('Internal notes about this order (not visible to customer)...') }}">{{ old('internal_notes', $order->internal_notes) }}</textarea>
                                    @error('internal_notes')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary">
                                    <i class="las la-times mr-1"></i> {{ __('Cancel') }}
                                </a>
                                <div>
                                    <button type="button" class="btn btn-outline-danger mr-2" onclick="deleteOrder()">
                                        <i class="las la-trash mr-1"></i> {{ __('Delete Order') }}
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="las la-save mr-1"></i> {{ __('Update Order') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Measurement Template Modal -->
    <div class="modal fade" id="measurementModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Select Measurement Template') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="templateLoading" class="text-center p-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">{{ __('Loading...') }}</span>
                        </div>
                        <p class="mt-2">{{ __('Loading templates...') }}</p>
                    </div>
                    <div id="templateContent" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover" id="templatesTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ __('Template Name') }}</th>
                                        <th>{{ __('Dress Type') }}</th>
                                        <th>{{ __('Height') }}</th>
                                        <th>{{ __('Chest') }}</th>
                                        <th>{{ __('Waist') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div id="noTemplates" class="text-center p-4" style="display: none;">
                        <i class="las la-ruler-combined fa-3x text-muted mb-3"></i>
                        <p>{{ __('No measurement templates found for this customer.') }}</p>
                        <p class="text-muted small">{{ __('You can add measurements manually.') }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fabric Selection Modal -->
    <div class="modal fade" id="fabricModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Select Fabric from Inventory') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('Fabric Code') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Color') }}</th>
                                    <th>{{ __('Available (m)') }}</th>
                                    <th>{{ __('Rate/m') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fabrics as $fabric)
                                <tr>
                                    <td>{{ $fabric->fabric_code }}</td>
                                    <td>{{ $fabric->type }}</td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $fabric->color }}; color: white;">
                                            {{ $fabric->color }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($fabric->stock_meter, 2) }}</td>
                                    <td>{{ number_format($fabric->selling_rate, 0) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary select-fabric-btn" 
                                                data-type="{{ $fabric->type }}"
                                                data-color="{{ $fabric->color }}"
                                                data-rate="{{ $fabric->selling_rate }}">
                                            {{ __('Select') }}
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
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
    <script src="{{ asset('backend/assets/vendor/select2/js/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
    <script src="{{ asset('backend/assets/js/table-treeview.js') }}"></script>
    <script src="{{ asset('backend/assets/js/customizer.js') }}"></script>
    <script src="{{ asset('backend/assets/js/chart-custom.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <script>
        let itemCount = {{ $order->items->count() }};
        let pickrInstances = {};

        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap'
            });

            // Initialize color pickers for existing items
            initializeColorPickers();

            // Add new order item
            $('#addItemBtn').click(function() {
                addNewOrderItem();
            });

            // Remove order item
            $(document).on('click', '.remove-item-btn', function() {
                const itemId = $(this).data('item-id');
                removeOrderItem(itemId);
            });

            // Dress type change
            $(document).on('change', '.dress-type-select', function() {
                const itemId = $(this).data('item-id');
                const selectedOption = $(this).find('option:selected');
                const basePrice = selectedOption.data('price') || 0;
                const estimatedDays = selectedOption.data('days') || 7;
                
                $(`#base_price_${itemId}`).val(basePrice.toFixed(2));
                calculateItemTotal(itemId);
                calculateGrandTotal();
            });

            // Fabric calculations
            $(document).on('input', '.fabric-meters, .fabric-rate', function() {
                const itemId = $(this).data('item-id');
                const meter = parseFloat($(`#fabric_meters_${itemId}`).val()) || 0;
                const rate = parseFloat($(`#fabric_rate_${itemId}`).val()) || 0;
                const fabricCost = meter * rate;
                $(`#fabric_cost_${itemId}`).val(fabricCost.toFixed(2));
                calculateItemTotal(itemId);
                calculateGrandTotal();
            });

            // Include fabric checkbox
            $(document).on('change', '.include-fabric-checkbox', function() {
                const itemId = $(this).data('item-id');
                calculateItemTotal(itemId);
                calculateGrandTotal();
                
                const fabricCostField = $(`#fabric_cost_${itemId}`);
                if ($(this).is(':checked')) {
                    fabricCostField.removeClass('bg-light text-muted').addClass('bg-success-light');
                } else {
                    fabricCostField.removeClass('bg-success-light').addClass('bg-light text-muted');
                }
            });

            // Stitching charges, additional charges, discount
            $(document).on('input', '.stitching-charges, .additional-charges, .item-discount', function() {
                const itemId = $(this).data('item-id');
                calculateItemTotal(itemId);
                calculateGrandTotal();
            });

            // Quantity change
            $(document).on('input', '.item-quantity', function() {
                const itemId = $(this).data('item-id');
                calculateItemTotal(itemId);
                calculateGrandTotal();
            });

            // Order discount and advance amount change
            $('#order_discount, #advance_amount').on('input', function() {
                calculateGrandTotal();
                calculateBalance();
            });

            // Load measurement templates
            $(document).on('click', '.load-templates-btn', function() {
                const customerId = $('#customer_id').val();
                const itemId = $(this).data('item-id');
                
                if (!customerId) {
                    alert('{{ __("Please select a customer first.") }}');
                    return;
                }
                
                window.activeMeasurementItemId = itemId;
                $('#measurementModal').modal('show');
                loadMeasurementTemplates(customerId);
            });

            // Select fabric button
            $(document).on('click', '.select-fabric-btn', function() {
                const type = $(this).data('type');
                const color = $(this).data('color');
                const rate = $(this).data('rate');
                const activeItemId = window.activeFabricItemId || 0;
                
                $(`#fabric_type_${activeItemId}`).val(type);
                $(`#fabric_color_${activeItemId}`).val(color);
                $(`#fabric_rate_${activeItemId}`).val(rate);
                
                $('#fabricModal').modal('hide');
                
                // Suggest meter requirement based on dress type
                const dressTypeName = $(`#dress_type_id_${activeItemId} option:selected`).text().toLowerCase();
                let suggestedMeters = 2.5;
                
                if (dressTypeName.includes('sherwani') || dressTypeName.includes('gown')) {
                    suggestedMeters = 5.5;
                } else if (dressTypeName.includes('suit')) {
                    suggestedMeters = 4.0;
                } else if (dressTypeName.includes('kurta') || dressTypeName.includes('shalwar')) {
                    suggestedMeters = 3.5;
                } else if (dressTypeName.includes('lehenga')) {
                    suggestedMeters = 6.0;
                }
                
                $(`#fabric_meters_${activeItemId}`).val(suggestedMeters);
                
                const fabricCost = suggestedMeters * rate;
                $(`#fabric_cost_${activeItemId}`).val(fabricCost.toFixed(2));
                calculateItemTotal(activeItemId);
                calculateGrandTotal();
            });

            // Select fabric from inventory button
            $(document).on('click', '.select-fabric-from-inventory', function() {
                window.activeFabricItemId = $(this).data('item-id');
                $('#fabricModal').modal('show');
            });

            // Initialize calculations
            calculateGrandTotal();
        });

        function addNewOrderItem() {
            $.ajax({
                url: '{{ route("orders.get-item-partial") }}',
                type: 'GET',
                data: {
                    index: itemCount,
                    dressTypes: @json($dressTypes),
                    tailors: @json($tailors),
                    enabledFields: @json($enabledFields)
                },
                success: function(response) {
                    $('#orderItemsContainer').append(response.html);
                    
                    // Initialize Select2 for new item
                    $(`#dress_type_id_${itemCount}`).select2({
                        theme: 'bootstrap',
                        dropdownParent: $(`#dress_type_id_${itemCount}`).parent()
                    });
                    
                    $(`#tailor_id_${itemCount}`).select2({
                        theme: 'bootstrap',
                        dropdownParent: $(`#tailor_id_${itemCount}`).parent()
                    });
                    
                    // Initialize color picker for new item
                    initializeColorPickerForItem(itemCount);
                    
                    itemCount++;
                    
                    // Scroll to new item
                    $('html, body').animate({
                        scrollTop: $(`#order_item_${itemCount - 1}`).offset().top - 100
                    }, 500);
                    
                    toastr.success('{{ __("New item added successfully.") }}');
                },
                error: function() {
                    toastr.error('{{ __("Failed to add new item.") }}');
                }
            });
        }

        function removeOrderItem(itemId) {
            if (itemCount === 1) {
                toastr.warning('{{ __("Cannot remove the last item.") }}');
                return;
            }
            
            if (confirm('{{ __("Are you sure you want to remove this item?") }}')) {
                // If it's an existing item from database, mark for deletion
                if ($(`#order_item_${itemId}`).data('is-existing') === true) {
                    $(`#order_item_${itemId}`).append(`<input type="hidden" name="items[${itemId}][delete]" value="1">`);
                    $(`#order_item_${itemId}`).hide();
                } else {
                    $(`#order_item_${itemId}`).remove();
                }
                itemCount--;
                calculateGrandTotal();
                toastr.success('{{ __("Item removed successfully.") }}');
            }
        }

        function calculateItemTotal(itemId) {
            const basePrice = parseFloat($(`#base_price_${itemId}`).val()) || 0;
            const fabricCost = parseFloat($(`#fabric_cost_${itemId}`).val()) || 0;
            const stitching = parseFloat($(`#stitching_charges_${itemId}`).val()) || 0;
            const additional = parseFloat($(`#additional_charges_${itemId}`).val()) || 0;
            const discount = parseFloat($(`#item_discount_${itemId}`).val()) || 0;
            const quantity = parseFloat($(`#quantity_${itemId}`).val()) || 1;
            
            const includeFabric = $(`#includeFabricInTotal_${itemId}`).is(':checked');
            
            let itemSubTotal = basePrice + stitching + additional - discount;
            let itemTotal = itemSubTotal * quantity;
            
            if (includeFabric) {
                itemTotal += (fabricCost * quantity);
            }
            
            $(`#item_total_${itemId}`).val(itemTotal.toFixed(2));
            $(`#item_total_display_${itemId}`).text('Rs ' + itemTotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ','));
        }

        function calculateGrandTotal() {
            let subTotal = 0;
            let totalFabricCost = 0;
            let totalStitching = 0;
            let totalAdditional = 0;
            let totalDiscount = 0;
            let grandTotal = 0;
            
            $('.order-item-card').each(function() {
                const itemId = $(this).data('item-id');
                
                // Skip hidden/deleted items
                if ($(this).css('display') === 'none') return;
                
                const basePrice = parseFloat($(`#base_price_${itemId}`).val()) || 0;
                const fabricCost = parseFloat($(`#fabric_cost_${itemId}`).val()) || 0;
                const stitching = parseFloat($(`#stitching_charges_${itemId}`).val()) || 0;
                const additional = parseFloat($(`#additional_charges_${itemId}`).val()) || 0;
                const discount = parseFloat($(`#item_discount_${itemId}`).val()) || 0;
                const quantity = parseFloat($(`#quantity_${itemId}`).val()) || 1;
                const includeFabric = $(`#includeFabricInTotal_${itemId}`).is(':checked');
                
                const itemSubTotal = (basePrice + stitching + additional - discount) * quantity;
                subTotal += itemSubTotal;
                
                totalFabricCost += includeFabric ? (fabricCost * quantity) : 0;
                totalStitching += stitching * quantity;
                totalAdditional += additional * quantity;
                totalDiscount += discount * quantity;
                
                let itemGrandTotal = itemSubTotal;
                if (includeFabric) {
                    itemGrandTotal += fabricCost * quantity;
                }
                grandTotal += itemGrandTotal;
            });
            
            // Apply order level discount
            const orderDiscount = parseFloat($('#order_discount').val()) || 0;
            grandTotal -= orderDiscount;
            totalDiscount += orderDiscount;
            
            $('#subTotal').text('Rs ' + subTotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $('#totalFabricCost').text('Rs ' + totalFabricCost.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $('#totalStitchingCharges').text('Rs ' + totalStitching.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $('#totalAdditionalCharges').text('Rs ' + totalAdditional.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $('#totalDiscount').text('- Rs ' + totalDiscount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $('#grandTotal').text('Rs ' + grandTotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            
            $('#total_amount').val(grandTotal.toFixed(2));
            $('#final_amount').val(grandTotal.toFixed(2));
            
            calculateBalance(grandTotal);
        }

        function calculateBalance(grandTotal = null) {
            if (grandTotal === null) {
                grandTotal = parseFloat($('#grandTotal').text().replace('Rs ', '').replace(/,/g, '')) || 0;
            }
            
            const advancePaid = parseFloat($('#advance_amount').val()) || 0;
            const balance = grandTotal - advancePaid;
            
            $('#balance_due').val(balance.toFixed(2));
            $('#remaining_amount').val(balance.toFixed(2));
        }

        function loadMeasurementTemplates(customerId) {
            $('#templateLoading').show();
            $('#templateContent').hide();
            $('#noTemplates').hide();
            
            $.ajax({
                url: `/orders/customer/${customerId}/details`,
                type: 'GET',
                success: function(response) {
                    $('#templateLoading').hide();
                    
                    const templates = response.customer.measurement_templates || [];
                    const tableBody = $('#templatesTable tbody');
                    tableBody.empty();
                    
                    if (templates.length > 0) {
                        templates.forEach(template => {
                            const measurements = template.measurements;
                            const row = `
                                <tr>
                                    <td>${template.template_name}</td>
                                    <td>${template.dress_type}</td>
                                    <td>${measurements.height || 'N/A'}</td>
                                    <td>${measurements.chest || 'N/A'}</td>
                                    <td>${measurements.waist || 'N/A'}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary apply-template-btn" 
                                                data-measurements='${JSON.stringify(measurements)}'
                                                data-item-id="${window.activeMeasurementItemId}">
                                            {{ __("Apply") }}
                                        </button>
                                    </td>
                                </tr>
                            `;
                            tableBody.append(row);
                        });
                        
                        $('#templateContent').show();
                        
                        // Apply template button handler
                        $('.apply-template-btn').click(function() {
                            const measurements = $(this).data('measurements');
                            const itemId = $(this).data('item-id');
                            applyTemplate(measurements, itemId);
                        });
                    } else {
                        $('#noTemplates').show();
                    }
                },
                error: function() {
                    $('#templateLoading').hide();
                    $('#noTemplates').show();
                }
            });
        }

        function applyTemplate(measurements, itemId) {
            Object.keys(measurements).forEach(key => {
                const input = $(`#order_item_${itemId} input[name="items[${itemId}][measurements][${key}]"], 
                               #order_item_${itemId} textarea[name="items[${itemId}][measurements][${key}]"]`);
                if (input.length) {
                    input.val(measurements[key]);
                }
            });
            
            $('#measurementModal').modal('hide');
            toastr.success('{{ __("Measurement template applied successfully.") }}');
        }

        function initializeColorPickers() {
            $('.color-picker-btn').each(function() {
                const itemId = $(this).data('item-id');
                initializeColorPickerForItem(itemId);
            });
        }

        function initializeColorPickerForItem(itemId) {
            const btnId = `#colorPickerBtn_${itemId}`;
            const containerId = `#colorPickerContainer_${itemId}`;
            
            $(btnId).click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                if (pickrInstances[itemId]) {
                    pickrInstances[itemId].show();
                    return;
                }
                
                pickrInstances[itemId] = Pickr.create({
                    el: containerId,
                    theme: 'nano',
                    default: $(`#fabric_color_${itemId}`).val() || '#1D4ED8',
                    swatches: [
                        '#000000', '#FFFFFF', '#1D4ED8', '#EF4444', '#10B981',
                        '#F59E0B', '#8B5CF6', '#EC4899', '#6B7280', '#92400E'
                    ],
                    components: {
                        preview: true,
                        opacity: true,
                        hue: true,
                        interaction: {
                            hex: true,
                            rgba: true,
                            hsla: true,
                            hsva: true,
                            cmyk: true,
                            input: true,
                            clear: true,
                            save: true
                        }
                    }
                });
                
                $(containerId).show();
                pickrInstances[itemId].show();
                
                pickrInstances[itemId].on('save', (color, instance) => {
                    const hexColor = color.toHEXA().toString();
                    $(`#fabric_color_${itemId}`).val(hexColor);
                    $(containerId).hide();
                    instance.hide();
                });
                
                pickrInstances[itemId].on('clear', (instance) => {
                    $(`#fabric_color_${itemId}`).val('');
                    $(containerId).hide();
                    instance.hide();
                });
            });
        }

        $(document).click(function(e) {
            if (!$(e.target).closest('[id^="colorPickerContainer"]').length && 
                !$(e.target).closest('[id^="colorPickerBtn"]').length && 
                !$(e.target).closest('.pcr-button').length) {
                
                Object.keys(pickrInstances).forEach(itemId => {
                    $(`#colorPickerContainer_${itemId}`).hide();
                    if (pickrInstances[itemId]) {
                        pickrInstances[itemId].hide();
                    }
                });
            }
        });

        function deleteOrder() {
            $('#deleteOrderModal').modal('show');
        }

        $('#orderForm').submit(function(e) {
            const requiredFields = $(this).find('[required]');
            let valid = true;
            
            requiredFields.each(function() {
                if (!$(this).val().trim()) {
                    valid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            if (!valid) {
                e.preventDefault();
                toastr.error('{{ __("Please fill all required fields.") }}');
                return;
            }
            
            const grandTotal = parseFloat($('#grandTotal').text().replace('Rs ', '').replace(/,/g, '')) || 0;
            if (grandTotal <= 0) {
                e.preventDefault();
                toastr.error('{{ __("Order total must be greater than zero.") }}');
                return;
            }
            
            calculateBalance(grandTotal);
        });

        // Toastr configuration
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 3000
        };
    </script>

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
            border-bottom: 1px solid rgba(0,0,0,.125);
        }
        
        .list-group-item:last-child {
            border-bottom: none;
        }
        
        .list-group-item:hover {
            background-color: #f8f9fa;
        }
        
        .bg-warning-light {
            background-color: #fff3cd;
        }
        
        .bg-info-light {
            background-color: #d1ecf1;
        }
        
        .progress {
            background-color: #eaecf4;
            border-radius: 0.25rem;
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
        }
        
        .invalid-feedback {
            display: block;
        }
    </style>
    @endpush
</x-app-layout>