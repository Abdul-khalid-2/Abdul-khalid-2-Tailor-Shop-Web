<x-app-layout>

    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Simple Color Picker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/nano.min.css"/>
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/select2/css/select2.min.css') }}">
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

        /* Validation Styling */
        .form-control.is-invalid,
        .form-control:invalid {
            border-color: #dc3545 !important;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath fill='%23dc3545' d='M8 4a.5.5 0 0 0-.854-.354L6.5 5.293 4.854 3.646A.5.5 0 1 0 4 4.5L5.293 6l-1.147 1.146A.5.5 0 0 0 4.854 8.5L6.5 6.707l1.646 1.647A.5.5 0 0 0 8 7.5L6.707 6 8 4.707a.5.5 0 0 0 0-.707z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .form-control.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .invalid-feedback,
        .invalid-tooltip {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #dc3545;
        }

        /* Select2 Validation Styling */
        .select2-container.select2-container--default.is-invalid .select2-selection--single,
        .select2-container.select2-container--default.is-invalid .select2-selection--multiple {
            border-color: #dc3545 !important;
        }

        .select2-container.select2-container--default.is-invalid .select2-selection--single:focus,
        .select2-container.select2-container--default.is-invalid .select2-selection--multiple:focus {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        .select2-wrapper {
            position: relative;
        }

        .select2-wrapper.is-invalid .select2-wrapper__error {
            display: block;
        }

        .select2-wrapper__error {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #dc3545;
        }
        
        .bg-info-light {
            background-color: #d1ecf1 !important;
            border-color: #bee5eb !important;
        }

        .item-breakdown {
            transition: all 0.3s ease;
        }

        .item-breakdown:hover {
            background-color: #f8f9fa;
            padding-left: 5px;
        }
    </style>
    @endpush

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-3">{{ __('messages.create_order') }}</h4>
                <p class="mb-0">{{ __('messages.add_new_order_multiple_items') }}</p>
            </div>
            <div>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left mr-1"></i> {{ __('messages.back_to_orders') }}
                </a>
            </div>
        </div>

        <!-- Order Form -->
        <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- Customer & Basic Info -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">{{ __('messages.customer_order_info') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.customer') }} *</label>
                                            <div class="input-group">
                                                <select class="form-control select2" id="customer_id" name="customer_id">
                                                    <option value="">{{ __('messages.select_customer') }}</option>
                                                    @foreach($customers as $customer)
                                                    <option value="{{ $customer->id }}"
                                                        data-phone="{{ $customer->phone }}"
                                                        data-address="{{ $customer->address }}"
                                                        data-type="{{ $customer->customer_type }}"
                                                        data-discount="{{ $customer->discount_rate }}">
                                                        {{ $customer->name }} ({{ $customer->phone }})
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-primary" id="addCustomerBtn">
                                                        <i class="las la-plus"></i> {{ __('messages.add_new') }}
                                                    </button>
                                                </div>
                                            </div>
                                            @error('customer_id')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.order_date') }} *</label>
                                            <input type="date" class="form-control" name="order_date" 
                                                   value="{{ old('order_date', date('Y-m-d')) }}">
                                            @error('order_date')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.order_number') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">{{ $receiptPrefix }}-</span>
                                                </div>
                                                <input type="text" class="form-control font-weight-bold" 
                                                    value="{{ str_pad($nextReceiptNumber, 6, '0', STR_PAD_LEFT) }}" readonly>
                                            </div>
                                            <small class="form-text text-muted">
                                                {{ __('Next Order Number:') }} <strong>{{ $orderNumber }}</strong>
                                            </small>
                                            <input type="hidden" name="order_number" value="{{ $orderNumber }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.branch') }} *</label>
                                            <select class="form-control select2" name="branch_id">
                                                <option value="">{{ __('messages.select_branch') }}</option>
                                                @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('branch_id')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">{{ __('messages.order_notes') }}</label>
                                        <textarea class="form-control" name="notes" rows="2" 
                                                  placeholder="{{ __('General notes about the order...') }}">{{ old('notes') }}</textarea>
                                        @error('notes')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items Container -->
                            <div id="orderItemsContainer">
                                <!-- Order Item 1 (Default) -->
                                @include('dashboard.orders.partials.order-item', [
                                    'index' => 0,
                                    'dressTypes' => $dressTypes,
                                    'tailors' => $tailors,
                                    'fabrics' => $fabrics,
                                    'enabledFields' => $enabledFields
                                ])
                            </div>

                            <!-- Add More Items Button -->
                            <div class="add-item-card" id="addItemBtn">
                                <i class="las la-plus-circle"></i>
                                <h6 class="mt-2 mb-0">{{ __('messages.add_another_item') }}</h6>
                                <small class="text-muted">{{ __('messages.click_to_add_more_clothes') }}</small>
                            </div>

                            <!-- Order Summary & Payment -->
                            <div class="card mb-4 mt-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">{{ __('messages.order_summary_payment') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="price-summary">
                                                <!-- Items Breakdown -->
                                                <div class="mb-3 pb-3" style="border-bottom: 1px solid #dee2e6;">
                                                    <h6 class="mb-2">{{ __('messages.item_wise_breakdown') }}</h6>
                                                    <div id="itemsBreakdown" class="small">
                                                        <!-- Item totals will be populated here -->
                                                    </div>
                                                </div>

                                                <div class="price-row">
                                                    <span>{{ __('messages.sub_total') }}:</span>
                                                    <span id="subTotal">Rs 0.00</span>
                                                </div>
                                                <div class="price-row">
                                                    <span>{{ __('messages.total_fabric_cost') }}:</span>
                                                    <span id="totalFabricCost">Rs 0.00</span>
                                                </div>
                                                <div class="price-row">
                                                    <span>{{ __('messages.total_stitching_charges') }}:</span>
                                                    <span id="totalStitchingCharges">Rs 0.00</span>
                                                </div>
                                                <div class="price-row">
                                                    <span>{{ __('messages.total_additional_charges') }}:</span>
                                                    <span id="totalAdditionalCharges">Rs 0.00</span>
                                                </div>
                                                <div class="price-row">
                                                    <span>{{ __('messages.total_discount') }}:</span>
                                                    <span id="totalDiscount" class="text-danger">- Rs 0.00</span>
                                                </div>
                                                <div class="price-row total">
                                                    <span>{{ __('messages.grand_total') }}:</span>
                                                    <span id="grandTotal" class="grand-total">Rs 0.00</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="mb-3">{{ __('messages.payment_details') }}</h6>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">{{ __('messages.advance_paid') }} *</label>
                                                        <input type="number" step="0.01" class="form-control" id="advance_amount" 
                                                               name="advance_amount" value="{{ old('advance_amount', 0) }}">
                                                        @error('advance_amount')
                                                        <div class="text-danger small">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">{{ __('messages.payment_method') }}</label>
                                                        <select class="form-control" name="payment_method_id">
                                                            @foreach($paymentMethods as $method)
                                                            <option value="{{ $method->id }}" {{ old('payment_method_id', 1) == $method->id ? 'selected' : '' }}>
                                                                {{ $method->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-0">
                                                        <label class="form-label">{{ __('messages.balance_due') }}</label>
                                                        <input type="number" step="0.01" class="form-control font-weight-bold text-danger" 
                                                               id="balance_due" value="0" readonly>
                                                        <input type="hidden" name="remaining_amount" id="remaining_amount" value="0">
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
                                    <h6 class="mb-0">{{ __('messages.internal_notes') }}</h6>
                                </div>
                                <div class="card-body">
                                    <textarea class="form-control" name="internal_notes" rows="3" 
                                              placeholder="{{ __('Internal notes about this order (not visible to customer)...') }}">{{ old('internal_notes') }}</textarea>
                                    @error('internal_notes')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                    <i class="las la-redo-alt"></i> {{ __('messages.reset_form') }}
                                </button>
                                <div>
                                    <button type="button" class="btn btn-outline-primary mr-2" onclick="saveAsDraft()">
                                        <i class="las la-save"></i> {{ __('messages.save_as_draft') }}
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="las la-check-circle"></i> {{ __('messages.create_order_btn') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Add Customer Modal -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.add_new_customer') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="newCustomerForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('messages.name') }} *</label>
                                <input type="text" class="form-control" id="new_customer_name" name="name">
                                <div class="invalid-feedback">{{ __('Please enter customer name.') }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('messages.phone') }} *</label>
                                <input type="text" class="form-control" id="new_customer_phone" name="phone">
                                <div class="invalid-feedback">{{ __('Please enter phone number.') }}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('messages.email') }}</label>
                                <input type="email" class="form-control" id="new_customer_email" name="email">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('messages.address') }}</label>
                                <textarea class="form-control" id="new_customer_address" name="address" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">{{ __('messages.branch') }} *</label>
                                <select class="form-control" id="new_customer_branch" name="branch_id">
                                    <option value="">{{ __('messages.select_branch') }}</option>
                                    @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">{{ __('Please select a branch.') }}</div>
                            </div>
                        </div>
                        <input type="hidden" name="customer_type" value="walk_in">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="saveCustomerBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            {{ __('messages.save_customer') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Measurement Template Modal -->
    <div class="modal fade" id="measurementModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.select_measurement_template') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="templateLoading" class="text-center p-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">{{ __('Loading...') }}</span>
                        </div>
                        <p class="mt-2">{{ __('messages.loading_templates') }}</p>
                    </div>
                    <div id="templateContent" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover" id="templatesTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ __('messages.template_name') }}</th>
                                        <th>{{ __('messages.dress_type') }}</th>
                                        <th>{{ __('messages.height') }}</th>
                                        <th>{{ __('messages.chest') }}</th>
                                        <th>{{ __('messages.waist') }}</th>
                                        <th>{{ __('messages.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div id="noTemplates" class="text-center p-4" style="display: none;">
                        <i class="las la-ruler-combined fa-3x text-muted mb-3"></i>
                        <p>{{ __('messages.no_templates_found') }}</p>
                        <p class="text-muted small">{{ __('messages.add_measurements_manually') }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fabric Selection Modal -->
    <div class="modal fade" id="fabricModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.select_fabric') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('messages.fabric_code') }}</th>
                                    <th>{{ __('messages.type') }}</th>
                                    <th>{{ __('messages.color') }}</th>
                                    <th>{{ __('messages.available_m') }}</th>
                                    <th>{{ __('messages.rate_m') }}</th>
                                    <th>{{ __('messages.action') }}</th>
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
                                    <td>{{ number_format($fabric->selling_rate) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary select-fabric-btn" 
                                                data-type="{{ $fabric->type }}"
                                                data-color="{{ $fabric->color }}"
                                                data-rate="{{ $fabric->selling_rate }}">
                                            {{ __('messages.select') }}
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/select2/js/select2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
    <script src="{{ asset('backend/assets/js/table-treeview.js') }}"></script>
    <script src="{{ asset('backend/assets/js/customizer.js') }}"></script>
    <script src="{{ asset('backend/assets/js/chart-custom.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <script>
        let itemCount = 1;
        let pickrInstances = {};

        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap'
            });

            // Initialize color pickers for existing items
            initializeColorPickers();
            
            // Initialize fabric cost field styling for existing items
            initializeFabricCostFieldStyles();

            // Add Customer Modal
            $('#addCustomerBtn').click(function() {
                $('#addCustomerModal').modal('show');
            });

            // Save new customer via AJAX
            $('#newCustomerForm').submit(function(e) {
                e.preventDefault();

                const saveBtn = $('#saveCustomerBtn');
                const spinner = saveBtn.find('.spinner-border');

                if (!this.checkValidity()) {
                    e.stopPropagation();
                    $(this).addClass('was-validated');
                    return;
                }

                saveBtn.prop('disabled', true);
                spinner.removeClass('d-none');

                $.ajax({
                    url: '{{ route("orders.customer.store") }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            const newOption = new Option(
                                response.customer.name + ' (' + response.customer.phone + ')',
                                response.customer.id,
                                false,
                                true
                            );
                            $('#customer_id').append(newOption).trigger('change');
                            $('#addCustomerModal').modal('hide');
                            $('#newCustomerForm')[0].reset();
                            $('#newCustomerForm').removeClass('was-validated');
                            toastr.success('{{ __("messages.customer_added_successfully") }}');
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
                const basePrice = parseFloat(selectedOption.data('price')) || 0;
                const estimatedDays = selectedOption.data('days') || 7;
                
                // Set base price
                $(`#base_price_${itemId}`).val(basePrice.toFixed(2));
                
                const orderDate = $('input[name="order_date"]').val();
                if (orderDate && itemId === 0) {
                    const deliveryDate = new Date(orderDate);
                    deliveryDate.setDate(deliveryDate.getDate() + parseInt(estimatedDays));
                    const formattedDate = deliveryDate.toISOString().split('T')[0];
                    $('#delivery_date').val(formattedDate);
                }
                
                // Clear validation error when dress type is selected
                if ($(this).val()) {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.select2-container').removeClass('is-invalid');
                    $(this).siblings('.invalid-feedback').remove();
                }
                
                // Calculate item total and update everything
                calculateItemTotal(itemId);
                calculateGrandTotal();
                updateOrderBreakdown();
            });

            // Update fabric cost calculation
            $(document).on('input', '.fabric-meters, .fabric-rate', function() {
                const itemId = $(this).data('item-id');
                const meter = parseFloat($(`#fabric_meters_${itemId}`).val()) || 0;
                const rate = parseFloat($(`#fabric_rate_${itemId}`).val()) || 0;
                const fabricCost = meter * rate;
                $(`#fabric_cost_${itemId}`).val(fabricCost.toFixed(2));
                
                // Update fabric cost field styling
                const fabricCostField = $(`#fabric_cost_${itemId}`);
                if (fabricCost > 0) {
                    fabricCostField.removeClass('bg-light').addClass('bg-info-light');
                } else {
                    fabricCostField.removeClass('bg-info-light').addClass('bg-light');
                }
                
                calculateGrandTotal();
                updateOrderBreakdown();
            });

            // Update when include fabric checkbox changes
            $(document).on('change', '.include-fabric-checkbox', function() {
                const itemId = $(this).data('item-id');
                calculateGrandTotal();
                updateOrderBreakdown();
                
                const fabricCostField = $(`#fabric_cost_${itemId}`);
                if ($(this).is(':checked')) {
                    fabricCostField.removeClass('bg-light').addClass('bg-info-light');
                } else {
                    fabricCostField.removeClass('bg-info-light').addClass('bg-light');
                }
            });

            // Update when stitching charges change
            $(document).on('input', '.stitching-charges', function() {
                const itemId = $(this).data('item-id');
                const value = parseFloat($(this).val()) || 0;
                
                // Clear validation error
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').remove();
                
                calculateGrandTotal();
                updateOrderBreakdown();
            });

            // Update when additional charges change
            $(document).on('input', '.additional-charges', function() {
                const itemId = $(this).data('item-id');
                const value = parseFloat($(this).val()) || 0;
                
                // Clear validation error
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').remove();
                
                calculateGrandTotal();
                updateOrderBreakdown();
            });

            // Update when discount changes
            $(document).on('input', '.item-discount', function() {
                const itemId = $(this).data('item-id');
                const value = parseFloat($(this).val()) || 0;
                
                // Clear validation error
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').remove();
                
                calculateGrandTotal();
                updateOrderBreakdown();
            });

            // Update when quantity changes
            $(document).on('input', '.item-quantity', function() {
                const itemId = $(this).data('item-id');
                const quantity = parseFloat($(this).val()) || 1;
                
                // Ensure minimum quantity is 1
                if (quantity < 1) {
                    $(this).val(1);
                }
                
                // Clear validation error if value is now valid
                if (quantity > 0) {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.invalid-feedback').remove();
                }
                
                calculateItemTotal(itemId);
                calculateGrandTotal();
                updateOrderBreakdown();
            });

            // Real-time validation clearing for text/date/number inputs
            $(document).on('change input blur', 'input[name="order_date"], #advance_amount', function() {
                const value = $(this).val();
                if (value && value.toString().trim()) {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                }
            });

            // Real-time validation clearing for Select2 fields
            $('#customer_id, select[name="branch_id"]').on('change', function() {
                if ($(this).val()) {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.select2-container').removeClass('is-invalid');
                    $(this).siblings('.invalid-feedback').remove();
                }
            });

            // Select2 change event for customer
            $('#customer_id').on('change', function() {
                if ($(this).val()) {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.select2-container').removeClass('is-invalid');
                    $(this).siblings('.invalid-feedback').remove();
                }
                
                // Load customer details
                const customerId = $(this).val();
                const selectedOption = $(this).find('option:selected');
                if (customerId && selectedOption.length) {
                    const phone = selectedOption.data('phone');
                    const address = selectedOption.data('address');
                    const type = selectedOption.data('type');
                    
                    // You can populate customer details here if needed
                }
            });

            // Advance amount change
            $('#advance_amount').on('input', function() {
                // Clear validation error
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').remove();
                
                calculateBalance();
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
                
                // Suggest meter requirement
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

            // Load measurement templates
            $('#loadTemplatesBtn').click(function() {
                const customerId = $('#customer_id').val();
                const itemId = $(this).data('item-id');
                
                if (!customerId) {
                    alert('{{ __("messages.please_select_customer_first") }}');
                    return;
                }
                
                window.activeMeasurementItemId = itemId;
                $('#measurementModal').modal('show');
                loadMeasurementTemplates(customerId);
            });

            // Load customer details
            $('#customer_id').change(function() {
                const customerId = $(this).val();
                if (customerId) {
                    $('.load-templates-btn').prop('disabled', false);
                } else {
                    $('.load-templates-btn').prop('disabled', true);
                }
            });

            // Initial calculation
            setTimeout(function() {
                calculateGrandTotal();
                updateOrderBreakdown();
            }, 100);
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
                    
                    // Initialize fabric cost field styling for new item
                    const fabricCostField = $(`#fabric_cost_${itemCount}`);
                    const checkbox = $(`#includeFabricInTotal_${itemCount}`);
                    if (checkbox.is(':checked')) {
                        fabricCostField.removeClass('bg-light').addClass('bg-info-light');
                    } else {
                        fabricCostField.removeClass('bg-info-light').addClass('bg-light');
                    }
                    
                    itemCount++;
                    
                    // Update calculations
                    calculateGrandTotal();
                    updateOrderBreakdown();
                    
                    // Scroll to new item
                    $('html, body').animate({
                        scrollTop: $(`#order_item_${itemCount - 1}`).offset().top - 100
                    }, 500);
                    
                    toastr.info('{{ __("messages.new_item_added") }}');
                },
                error: function() {
                    toastr.error('{{ __("messages.failed_to_add_item") }}');
                }
            });
        }

        function removeOrderItem(itemId) {
            if (itemCount === 1) {
                toastr.warning('{{ __("messages.cannot_remove_last_item") }}');
                return;
            }
            
            if (confirm('{{ __("messages.are_you_sure_remove_item") }}')) {
                $(`#order_item_${itemId}`).remove();
                itemCount--;
                calculateGrandTotal();
                updateOrderBreakdown();
                toastr.success('{{ __("messages.item_removed") }}');
            }
        }

        function calculateItemTotal(itemId) {
            const basePrice = parseFloat($(`#base_price_${itemId}`).val()) || 0;
            const quantity = parseFloat($(`#quantity_${itemId}`).val()) || 1;
            
            // Item Total = Base Price × Quantity
            const itemTotal = basePrice * quantity;
            
            // Update hidden input and display elements
            $(`#item_total_${itemId}`).val(itemTotal.toFixed(2));
            $(`#item_total_display_${itemId}`).text('Rs ' + itemTotal.toFixed(2));
            $(`#item_total_header_${itemId}`).text('Rs ' + itemTotal.toFixed(2));
            
            // Update the breakdown display in order summary
            updateOrderBreakdown();
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
                
                const basePrice = parseFloat($(`#base_price_${itemId}`).val()) || 0;
                const fabricCost = parseFloat($(`#fabric_cost_${itemId}`).val()) || 0;
                const stitchingPerItem = parseFloat($(`#stitching_charges_${itemId}`).val()) || 0;
                const additionalPerItem = parseFloat($(`#additional_charges_${itemId}`).val()) || 0;
                const discountPerItem = parseFloat($(`#item_discount_${itemId}`).val()) || 0;
                const quantity = parseFloat($(`#quantity_${itemId}`).val()) || 1;
                const includeFabric = $(`#includeFabricInTotal_${itemId}`).is(':checked');
                
                // Calculate totals with quantity
                const itemSubTotal = basePrice * quantity;
                const itemStitchingTotal = stitchingPerItem * quantity;
                const itemAdditionalTotal = additionalPerItem * quantity;
                const itemDiscountTotal = discountPerItem * quantity;
                const itemFabricTotal = includeFabric ? (fabricCost * quantity) : 0;
                
                // Accumulate totals
                subTotal += itemSubTotal;
                totalStitching += itemStitchingTotal;
                totalAdditional += itemAdditionalTotal;
                totalDiscount += itemDiscountTotal;
                totalFabricCost += itemFabricTotal;
                
                // Grand Total = SubTotal + FabricCost + Stitching + Additional - Discount
                grandTotal += itemSubTotal + itemFabricTotal + itemStitchingTotal + itemAdditionalTotal - itemDiscountTotal;
            });
            
            // Update summary displays
            $('#subTotal').text('Rs ' + subTotal.toFixed(2));
            $('#totalFabricCost').text('Rs ' + totalFabricCost.toFixed(2));
            $('#totalStitchingCharges').text('Rs ' + totalStitching.toFixed(2));
            $('#totalAdditionalCharges').text('Rs ' + totalAdditional.toFixed(2));
            $('#totalDiscount').text('- Rs ' + totalDiscount.toFixed(2));
            $('#grandTotal').text('Rs ' + grandTotal.toFixed(2));
            
            calculateBalance(grandTotal);
        }

        function updateOrderBreakdown() {
            let breakdownHTML = '';
            
            $('.order-item-card').each(function() {
                const itemId = $(this).data('item-id');
                
                // Get values
                const basePrice = parseFloat($(`#base_price_${itemId}`).val()) || 0;
                const quantity = parseFloat($(`#quantity_${itemId}`).val()) || 1;
                const stitchingPerItem = parseFloat($(`#stitching_charges_${itemId}`).val()) || 0;
                const additionalPerItem = parseFloat($(`#additional_charges_${itemId}`).val()) || 0;
                const discountPerItem = parseFloat($(`#item_discount_${itemId}`).val()) || 0;
                const fabricCost = parseFloat($(`#fabric_cost_${itemId}`).val()) || 0;
                const includeFabric = $(`#includeFabricInTotal_${itemId}`).is(':checked');
                
                // Calculate totals
                const itemTotal = basePrice * quantity;
                const stitchingTotal = stitchingPerItem * quantity;
                const additionalTotal = additionalPerItem * quantity;
                const discountTotal = discountPerItem * quantity;
                const fabricTotal = includeFabric ? (fabricCost * quantity) : 0;
                
                // Get dress type name for display
                const dressTypeSelect = $(`#dress_type_id_${itemId}`);
                const dressTypeName = dressTypeSelect.find('option:selected').text().split(' -')[0] || 'Item';
                
                // Build breakdown HTML
                breakdownHTML += `
                    <div class="item-breakdown mb-3 pb-2" style="border-bottom: 1px dashed #dee2e6;">
                        <div class="d-flex justify-content-between mb-1">
                            <strong>${dressTypeName} #${itemId + 1}</strong>
                            <strong class="text-primary">Rs ${itemTotal.toFixed(2)} (${quantity} ${quantity > 1 ? 'items' : 'item'})</strong>
                        </div>
                `;
                
                // if (stitchingTotal > 0) {
                //     breakdownHTML += `
                //         <div class="d-flex justify-content-between small text-muted pl-3">
                //             <span>Stitching charges (Rs ${stitchingPerItem.toFixed(2)} × ${quantity})</span>
                //             <span>+ Rs ${stitchingTotal.toFixed(2)}</span>
                //         </div>
                //     `;
                // }
                
                // if (additionalTotal > 0) {
                //     breakdownHTML += `
                //         <div class="d-flex justify-content-between small text-muted pl-3">
                //             <span>Additional charges (Rs ${additionalPerItem.toFixed(2)} × ${quantity})</span>
                //             <span>+ Rs ${additionalTotal.toFixed(2)}</span>
                //         </div>
                //     `;
                // }
                
                if (fabricTotal > 0) {
                    breakdownHTML += `
                        <div class="d-flex justify-content-between small text-muted pl-3">
                            <span>Fabric cost (Rs ${fabricCost.toFixed(2)} × ${quantity})</span>
                            <span>+ Rs ${fabricTotal.toFixed(2)}</span>
                        </div>
                    `;
                }
                
                if (discountTotal > 0) {
                    breakdownHTML += `
                        <div class="d-flex justify-content-between small text-danger pl-3">
                            <span>Discount (Rs ${discountPerItem.toFixed(2)} × ${quantity})</span>
                            <span>- Rs ${discountTotal.toFixed(2)}</span>
                        </div>
                    `;
                }
                
                breakdownHTML += `</div>`;
            });
            
            $('#itemsBreakdown').html(breakdownHTML || '<p class="text-muted mb-0">No items added</p>');
        }

        function calculateBalance(grandTotal = null) {
            if (grandTotal === null) {
                grandTotal = parseFloat($('#grandTotal').text().replace('Rs ', '')) || 0;
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
                                            {{ __("messages.apply") }}
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
                const input = $(`#order_item_${itemId} input[name="measurements[${itemId}][${key}]"], 
                               #order_item_${itemId} textarea[name="measurements[${itemId}][${key}]"]`);
                if (input.length) {
                    input.val(measurements[key]);
                }
            });
            
            $('#measurementModal').modal('hide');
            toastr.success('{{ __("messages.measurement_template_applied") }}');
        }

        function initializeColorPickers() {
            $('.color-picker-btn').each(function() {
                const itemId = $(this).data('item-id');
                initializeColorPickerForItem(itemId);
            });
        }

        function initializeFabricCostFieldStyles() {
            $('.include-fabric-checkbox').each(function() {
                const itemId = $(this).data('item-id');
                const fabricCostField = $(`#fabric_cost_${itemId}`);
                
                if ($(this).is(':checked')) {
                    fabricCostField.removeClass('bg-light text-muted').addClass('bg-success-light');
                } else {
                    fabricCostField.removeClass('bg-success-light').addClass('bg-light text-muted');
                }
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
                    default: '#1D4ED8',
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

        function resetForm() {
            if (confirm('{{ __("messages.are_you_sure_reset") }}')) {
                document.getElementById('orderForm').reset();
                $('.select2').val(null).trigger('change');
                
                // Keep first item, remove others
                $('.order-item-card:not([data-item-id="0"])').remove();
                itemCount = 1;
                
                // Reset first item
                $('#base_price_0').val(0);
                $('#fabric_cost_0').val(0);
                $('#stitching_charges_0').val(0);
                $('#additional_charges_0').val(0);
                $('#item_discount_0').val(0);
                $('#quantity_0').val(1);
                $('#item_total_0').val(0);
                $('#item_total_display_0').text('Rs 0.00');
                
                $('#advance_amount').val(0);
                
                calculateGrandTotal();
                toastr.success('{{ __("messages.form_reset_successfully") }}');
            }
        }

        function saveAsDraft() {
            $('#orderForm').append('<input type="hidden" name="save_as_draft" value="1">');
            $('#orderForm').submit();
        }

        function clearValidationMessages() {
            // Clear all previous error messages
            $('.invalid-feedback').remove();
            $('.form-control').removeClass('is-invalid');
            $('.select2-container').removeClass('is-invalid');
        }

        function showFieldError(fieldElement, errorMessage) {
            // Add is-invalid class
            fieldElement.addClass('is-invalid');
            
            // For Select2, also add class to the container
            if (fieldElement.hasClass('select2')) {
                fieldElement.siblings('.select2-container').addClass('is-invalid');
            }
            
            // Remove existing error message if any
            fieldElement.siblings('.invalid-feedback').remove();
            
            // Add error message after the field
            const errorHtml = `<div class="invalid-feedback" style="display: block;">${errorMessage}</div>`;
            fieldElement.after(errorHtml);
        }

        // Form validation without HTML required attributes
        function validateAllFields() {
            clearValidationMessages();
            
            let isValid = true;
            let firstErrorField = null;
            
            // 1. Validate Customer (required)
            const $customerSelect = $('#customer_id');
            if (!$customerSelect.val()) {
                isValid = false;
                showFieldError($customerSelect, '{{ __("messages.customer_is_required") }}');
                if (!firstErrorField) firstErrorField = $customerSelect;
            }
            
            // 2. Validate Order Date (required)
            const $orderDate = $('input[name="order_date"]');
            if (!$orderDate.val()) {
                isValid = false;
                showFieldError($orderDate, '{{ __("messages.order_date_is_required") }}');
                if (!firstErrorField) firstErrorField = $orderDate;
            }
            
            // 3. Validate Branch (required)
            const $branchSelect = $('select[name="branch_id"]');
            if (!$branchSelect.val()) {
                isValid = false;
                showFieldError($branchSelect, '{{ __("messages.branch_is_required") }}');
                if (!firstErrorField) firstErrorField = $branchSelect;
            }
            
            // 4. Validate Advance Amount (required and must be >= 0)
            const $advanceAmount = $('#advance_amount');
            const advanceValue = parseFloat($advanceAmount.val());
            if ($advanceAmount.val() === '' || isNaN(advanceValue)) {
                isValid = false;
                showFieldError($advanceAmount, '{{ __("messages.advance_amount_is_required") }}');
                if (!firstErrorField) firstErrorField = $advanceAmount;
            } else if (advanceValue < 0) {
                isValid = false;
                showFieldError($advanceAmount, '{{ __("messages.advance_amount_cannot_be_negative") }}');
                if (!firstErrorField) firstErrorField = $advanceAmount;
            }
            
            // 5. Validate Order Items
            if ($('.order-item-card').length === 0) {
                isValid = false;
                toastr.error('{{ __("messages.please_add_at_least_one_item") }}');
                return false;
            }
            
            // Validate each order item
            $('.order-item-card').each(function(index) {
                const itemId = $(this).data('item-id');
                const itemElement = this;
                
                // Validate Dress Type (required for each item)
                const $dressType = $(`#dress_type_id_${itemId}`);
                if (!$dressType.val()) {
                    isValid = false;
                    showFieldError($dressType, '{{ __("messages.dress_type_is_required") }}');
                    if (!firstErrorField) firstErrorField = $dressType;
                }
                
                // Validate Quantity (required, must be > 0)
                const $quantity = $(`#quantity_${itemId}`);
                const quantityValue = parseInt($quantity.val());
                if (!$quantity.val() || isNaN(quantityValue) || quantityValue < 1) {
                    isValid = false;
                    showFieldError($quantity, '{{ __("messages.quantity_must_be_at_least_1") }}');
                    if (!firstErrorField) firstErrorField = $quantity;
                }
                
                // Validate Fabric Meters if fabric rate is provided
                const $fabricMeters = $(`#fabric_meters_${itemId}`);
                const $fabricRate = $(`#fabric_rate_${itemId}`);
                const fabricMeters = parseFloat($fabricMeters.val()) || 0;
                const fabricRate = parseFloat($fabricRate.val()) || 0;
                
                if (fabricRate > 0 && fabricMeters <= 0) {
                    isValid = false;
                    showFieldError($fabricMeters, '{{ __("messages.fabric_meters_required_when_rate_provided") }}');
                    if (!firstErrorField) firstErrorField = $fabricMeters;
                }
                
                // Validate Stitching Charges (must be >= 0)
                const $stitching = $(`#stitching_charges_${itemId}`);
                const stitchingValue = parseFloat($stitching.val()) || 0;
                if (stitchingValue < 0) {
                    isValid = false;
                    showFieldError($stitching, '{{ __("messages.stitching_charges_cannot_be_negative") }}');
                    if (!firstErrorField) firstErrorField = $stitching;
                }
                
                // Validate Additional Charges (must be >= 0)
                const $additional = $(`#additional_charges_${itemId}`);
                const additionalValue = parseFloat($additional.val()) || 0;
                if (additionalValue < 0) {
                    isValid = false;
                    showFieldError($additional, '{{ __("messages.additional_charges_cannot_be_negative") }}');
                    if (!firstErrorField) firstErrorField = $additional;
                }
                
                // Validate Discount (must be >= 0 and not exceed item total)
                const $discount = $(`#item_discount_${itemId}`);
                const discountValue = parseFloat($discount.val()) || 0;
                const basePrice = parseFloat($(`#base_price_${itemId}`).val()) || 0;
                
                if (discountValue < 0) {
                    isValid = false;
                    showFieldError($discount, '{{ __("messages.discount_cannot_be_negative") }}');
                    if (!firstErrorField) firstErrorField = $discount;
                } else if (discountValue > basePrice) {
                    isValid = false;
                    showFieldError($discount, '{{ __("messages.discount_cannot_exceed_base_price") }}');
                    if (!firstErrorField) firstErrorField = $discount;
                }
            });
            
            // 6. Validate Grand Total (must be > 0)
            const grandTotal = parseFloat($('#grandTotal').text().replace('Rs ', '')) || 0;
            if (grandTotal <= 0) {
                isValid = false;
                toastr.error('{{ __("messages.grand_total_must_be_greater_than_zero") }}');
            }
            
            // Scroll to first error field if exists
            if (firstErrorField) {
                $('html, body').animate({
                    scrollTop: firstErrorField.offset().top - 150
                }, 500);
            }
            
            return isValid;
        }

        // Enhanced showFieldError function
        function showFieldError(fieldElement, errorMessage) {
            // Remove any existing error for this field
            fieldElement.siblings('.invalid-feedback').remove();
            
            // Add is-invalid class
            fieldElement.addClass('is-invalid');
            
            // Special handling for Select2
            if (fieldElement.hasClass('select2-hidden-accessible')) {
                fieldElement.next('.select2-container').addClass('is-invalid');
            } else if (fieldElement.hasClass('select2')) {
                fieldElement.siblings('.select2-container').addClass('is-invalid');
            }
            
            // Add error message after the field or its container
            const errorHtml = `<div class="invalid-feedback" style="display: block;">${errorMessage}</div>`;
            
            if (fieldElement.hasClass('select2-hidden-accessible')) {
                fieldElement.next('.select2-container').after(errorHtml);
            } else if (fieldElement.hasClass('select2')) {
                fieldElement.siblings('.select2-container').after(errorHtml);
            } else {
                fieldElement.after(errorHtml);
            }
        }

        // Enhanced clearValidationMessages function
        function clearValidationMessages() {
            // Remove all error messages
            $('.invalid-feedback').remove();
            
            // Remove is-invalid class from all inputs and selects
            $('.form-control').removeClass('is-invalid');
            $('select').removeClass('is-invalid');
            $('.select2-container').removeClass('is-invalid');
        }

        // Real-time validation clearing
        $(document).on('focus change input', '.form-control, select', function() {
            const $this = $(this);
            
            // Clear validation for this field when user interacts with it
            $this.removeClass('is-invalid');
            $this.siblings('.invalid-feedback').remove();
            
            // Handle Select2
            if ($this.hasClass('select2-hidden-accessible')) {
                $this.next('.select2-container').removeClass('is-invalid');
            } else if ($this.hasClass('select2')) {
                $this.siblings('.select2-container').removeClass('is-invalid');
            }
        });

        // Form submission handler
        $('#orderForm').submit(function(e) {
            e.preventDefault(); // Prevent default submission
            
            // Clear all previous validation messages
            clearValidationMessages();
            
            // Run validation
            if (validateAllFields()) {
                // Calculate final balance before submitting
                calculateBalance();
                
                // Submit the form
                this.submit();
            } else {
                toastr.error('{{ __("messages.please_fix_validation_errors") }}');
            }
        });

        // Add validation for numeric fields to prevent negative values
        $(document).on('input', 'input[type="number"]', function() {
            const value = parseFloat($(this).val());
            if (value < 0) {
                $(this).val(0);
            }
        });

        // Validate advance amount doesn't exceed grand total
        $('#advance_amount').on('blur', function() {
            const advance = parseFloat($(this).val()) || 0;
            const grandTotal = parseFloat($('#grandTotal').text().replace('Rs ', '')) || 0;
            
            if (advance > grandTotal) {
                showFieldError($(this), '{{ __("messages.advance_amount_cannot_exceed_grand_total") }}');
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').remove();
            }
            
            calculateBalance();
        });

        $('#orderForm').submit(function(e) {
            const validation = validateAllFields();
            
            if (!validation.valid) {
                e.preventDefault();
                const message = validation.errors.length > 0 
                    ? validation.errors.slice(0, 4).join('<br>') + (validation.errors.length > 4 ? '<br>And more...' : '')
                    : '{{ __("messages.please_fill_required_fields") }}';
                toastr.error(message);
                
                // Scroll to first error
                const firstError = $('.is-invalid').first();
                if (firstError.length) {
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 500);
                }
                return false;
            }
            
            calculateBalance(parseFloat($('#grandTotal').text().replace('Rs ', '')) || 0);
        });

        // Modal reset on close
        $('#addCustomerModal').on('hidden.bs.modal', function() {
            $('#newCustomerForm')[0].reset();
            $('#newCustomerForm').removeClass('was-validated');
        });

        // Set active fabric item ID when opening fabric modal
        $('.select-fabric-from-inventory').click(function() {
            window.activeFabricItemId = $(this).data('item-id');
            $('#fabricModal').modal('show');
        });

        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
    </script>
    @endpush
</x-app-layout>