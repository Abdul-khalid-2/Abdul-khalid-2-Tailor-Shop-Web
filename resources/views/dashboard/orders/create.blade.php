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
    @endpush

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-3">{{ __('messages.create_order') }}</h4>
                <p class="mb-0">{{ __('messages.add_new_order') }}</p>
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
                                                <select class="form-control select2" id="customer_id" name="customer_id" required>
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
                                                   value="{{ old('order_date', date('Y-m-d')) }}" required>
                                            @error('order_date')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.order_date') }} *</label>
                                            <input type="date" class="form-control" name="order_date" 
                                                value="{{ old('order_date', date('Y-m-d')) }}" required>
                                            @error('order_date')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
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
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.branch') }} *</label>
                                            <select class="form-control select2" name="branch_id" required>
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

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.dress_type') }} *</label>
                                            <select class="form-control select2" id="dress_type_id" name="dress_type_id" required>
                                                <option value="">{{ __('messages.select_dress_type') }}</option>
                                                @foreach($dressTypes as $dressType)
                                                <option value="{{ $dressType->id }}" 
                                                        data-price="{{ $dressType->base_price }}"
                                                        data-days="{{ $dressType->estimated_days }}">
                                                    {{ $dressType->name }} - Rs {{ number_format($dressType->base_price) }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('dress_type_id')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.delivery_date') }} *</label>
                                            <input type="date" class="form-control" id="delivery_date" name="delivery_date" 
                                                   value="{{ old('delivery_date', date('Y-m-d', strtotime('+7 days'))) }}" required>
                                            @error('delivery_date')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.base_price') }} *</label>
                                            <input type="number" step="0.01" class="form-control" id="base_price" 
                                                   name="base_price" value="{{ old('base_price', 0) }}" required readonly>
                                            @error('base_price')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">{{ __('messages.order_description') }}</label>
                                        <textarea class="form-control" name="notes" rows="2" 
                                                  placeholder="{{ __('Brief description of the order...') }}">{{ old('notes') }}</textarea>
                                        @error('notes')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Measurement Section -->
                            <div class="card mb-4">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">{{ __('messages.measurements_cm') }}</h6>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="loadTemplatesBtn">
                                        <i class="las la-ruler mr-1"></i> {{ __('messages.use_template') }}
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if(in_array('height', $enabledFields))
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.height') }}</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[height]" 
                                                   placeholder="-- 170 --" value="{{ old('measurements.height') }}">
                                        </div>
                                        @endif
                                        
                                        @if(in_array('weight', $enabledFields))
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.weight') }}</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[weight]" 
                                                placeholder="-- 70 --" value="{{ old('measurements.weight') }}">
                                        </div>
                                        @endif
                                        
                                        @if(in_array('chest', $enabledFields))
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.chest') }}</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[chest]" 
                                                   placeholder="-- 42 --" value="{{ old('measurements.chest') }}">
                                        </div>
                                        @endif
                                        
                                        @if(in_array('waist', $enabledFields))
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.waist') }}</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[waist]" 
                                                   placeholder="-- 38 --" value="{{ old('measurements.waist') }}">
                                        </div>
                                        @endif
                                        
                                        @if(in_array('hips', $enabledFields))
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.hips') }}</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[hips]" 
                                                   placeholder="-- 44 --" value="{{ old('measurements.hips') }}">
                                        </div>
                                        @endif
                                        
                                        @if(in_array('shoulder', $enabledFields))
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.shoulder') }}</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[shoulder]" 
                                                   placeholder="-- 18 --" value="{{ old('measurements.shoulder') }}">
                                        </div>
                                        @endif
                                        
                                        @if(in_array('sleeve_length', $enabledFields))
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.sleeve_length') }}</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[sleeve_length]" 
                                                   placeholder="-- 60 --" value="{{ old('measurements.sleeve_length') }}">
                                        </div>
                                        @endif
                                        
                                        @if(in_array('sleeve_width', $enabledFields))
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.sleeve_width') }}</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[sleeve_width]" 
                                                placeholder="-- 18 --" value="{{ old('measurements.sleeve_width') }}">
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <div class="row">
                                        @if(in_array('collar', $enabledFields))
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.collar') }}</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[collar]" 
                                                placeholder="-- 16 --" value="{{ old('measurements.collar') }}">
                                        </div>
                                        @endif
                                        
                                        @if(in_array('bicep', $enabledFields))
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.bicep') }}</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[bicep]" 
                                                placeholder="-- 12 --" value="{{ old('measurements.bicep') }}">
                                        </div>
                                        @endif
                                        
                                        @if(in_array('wrist', $enabledFields))
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.wrist') }}</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[wrist]" 
                                                placeholder="-- 8 --" value="{{ old('measurements.wrist') }}">
                                        </div>
                                        @endif
                                        
                                        @if(in_array('pant_length', $enabledFields))
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.pant_length') }}</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[pant_length]" 
                                                   placeholder="-- 100 --" value="{{ old('measurements.pant_length') }}">
                                        </div>
                                        @endif
                                        
                                        @if(in_array('inseam', $enabledFields))
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.inseam') }}</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[inseam]" 
                                                   placeholder="-- 80 --" value="{{ old('measurements.inseam') }}">
                                        </div>
                                        @endif
                                        
                                        @if(in_array('thigh', $enabledFields))
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.thigh') }}</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[thigh]" 
                                                placeholder="-- 24 --" value="{{ old('measurements.thigh') }}">
                                        </div>
                                        @endif
                                        
                                        @if(in_array('knee', $enabledFields))
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.knee') }}</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[knee]" 
                                                placeholder="-- 18 --" value="{{ old('measurements.knee') }}">
                                        </div>
                                        @endif
                                        
                                        @if(in_array('bottom', $enabledFields))
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.bottom') }}</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[bottom]" 
                                                placeholder="-- 22 --" value="{{ old('measurements.bottom') }}">
                                        </div>
                                        @endif
                                        
                                        @if(in_array('ankle', $enabledFields))
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.ankle') }}</label>
                                            <input type="number" step="0.1" class="form-control" name="measurements[ankle]" 
                                                placeholder="-- 10 --" value="{{ old('measurements.ankle') }}">
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.fitting_preferences') }}</label>
                                            <textarea class="form-control" name="measurements[fitting_preferences]" rows="2" 
                                                      placeholder="{{ __('Loose, tight, or any specific preferences...') }}">{{ old('measurements.fitting_preferences') }}</textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.measurement_notes') }}</label>
                                            <textarea class="form-control" name="measurements[notes]" rows="2" 
                                                      placeholder="{{ __('Additional notes about measurements...') }}">{{ old('measurements.notes') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Fabric Details -->
                            <div class="card mb-4">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">{{ __('messages.fabric_details') }}</h6>
                                    <button type="button" class="btn btn-sm btn-outline-info" id="selectFabricBtn">
                                        <i class="las la-layer-group mr-1"></i> {{ __('messages.select_from_inventory') }}
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">{{ __('messages.fabric_type') }}</label>
                                            <input type="text" class="form-control" name="fabric_type" id="fabric_type" 
                                                   placeholder="{{ __('e.g., Silk, Cotton') }}" value="{{ old('fabric_type') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">{{ __('messages.color') }}</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="fabric_color" id="fabric_color"
                                                    placeholder="{{ __('e.g., Navy Blue') }}" value="{{ old('fabric_color') }}">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-secondary" id="colorPickerBtn">
                                                        <i class="las la-eye-dropper"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div id="colorPickerContainer" class="mt-2"></div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">{{ __('messages.meter_required') }}</label>
                                            <input type="number" step="0.01" class="form-control" name="fabric_meters" id="fabric_meters" 
                                                   placeholder="3.5" value="{{ old('fabric_meters', 0) }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.fabric_rate_m') }}</label>
                                            <input type="number" step="0.01" class="form-control" name="fabric_rate" id="fabric_rate" 
                                                   value="{{ old('fabric_rate', 0) }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.fabric_cost') }}</label>
                                            <input type="number" step="0.01" class="form-control" id="fabric_cost" 
                                                   name="fabric_cost" value="{{ old('fabric_cost', 0) }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing & Payment -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">{{ __('messages.pricing_payment') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.stitching_charges') }}</label>
                                            <input type="number" step="0.01" class="form-control" id="stitching_charges" 
                                                   name="stitching_charges" value="{{ old('stitching_charges', 0) }}">
                                            @error('stitching_charges')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.additional_charges') }}</label>
                                            <input type="number" step="0.01" class="form-control" id="additional_charges" 
                                                   name="additional_charges" value="{{ old('additional_charges', 0) }}">
                                            @error('additional_charges')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.discount') }}</label>
                                            <input type="number" step="0.01" class="form-control" id="discount_amount" 
                                                   name="discount_amount" value="{{ old('discount_amount', 0) }}">
                                            @error('discount_amount')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">{{ __('messages.total_amount') }}</label>
                                            <input type="number" step="0.01" class="form-control font-weight-bold" 
                                                   id="total_amount" value="0" readonly style="font-size: 1.2rem;">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.advance_paid') }} *</label>
                                            <input type="number" step="0.01" class="form-control" id="advance_amount" 
                                                   name="advance_amount" value="{{ old('advance_amount', 0) }}" required>
                                            @error('advance_amount')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.payment_method') }}</label>
                                            <select class="form-control" name="payment_method_id">
                                                @foreach($paymentMethods as $method)
                                                <option value="{{ $method->id }}" {{ old('payment_method_id', 1) == $method->id ? 'selected' : '' }}>
                                                    {{ $method->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.balance_due') }}</label>
                                            <input type="number" step="0.01" class="form-control font-weight-bold text-danger" 
                                                   id="balance_due" value="0" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.remaining_amount') }}</label>
                                            <input type="number" step="0.01" class="form-control" id="remaining_amount" 
                                                   name="remaining_amount" value="{{ old('remaining_amount', 0) }}" readonly>
                                            @error('remaining_amount')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tailor Assignment -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">{{ __('messages.tailor_assignment') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.assign_to_tailor') }}</label>
                                            <select class="form-control select2" id="tailor_id" name="tailor_id">
                                                <option value="">{{ __('messages.select_tailor') }}</option>
                                                @foreach($tailors as $tailor)
                                                <option value="{{ $tailor->id }}" {{ old('tailor_id') == $tailor->id ? 'selected' : '' }}>
                                                    {{ $tailor->name }} - {{ ucfirst($tailor->employment_type) }}
                                                    @if($tailor->specializations)
                                                    ({{ $tailor->specializations[0] ?? 'General' }})
                                                    @endif
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.expected_completion') }}</label>
                                            <input type="date" class="form-control" id="expected_completion" 
                                                   value="{{ date('Y-m-d', strtotime('+5 days')) }}">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('messages.special_instructions') }}</label>
                                        <textarea class="form-control" rows="2" placeholder="{{ __('Any special instructions for tailor...') }}"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">{{ __('messages.additional_notes') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('messages.internal_notes') }}</label>
                                        <textarea class="form-control" name="internal_notes" rows="3" 
                                                  placeholder="{{ __('Internal notes about this order...') }}">{{ old('internal_notes') }}</textarea>
                                        @error('internal_notes')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="urgentOrder" name="urgent_order">
                                        <label class="form-check-label text-warning" for="urgentOrder">
                                            <i class="las la-exclamation-circle"></i> {{ __('messages.mark_as_urgent') }}
                                        </label>
                                    </div>
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
                                <input type="text" class="form-control" id="new_customer_name" name="name" required>
                                <div class="invalid-feedback">{{ __('Please enter customer name.') }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('messages.phone') }} *</label>
                                <input type="text" class="form-control" id="new_customer_phone" name="phone" required>
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
                                <select class="form-control" id="new_customer_branch" name="branch_id" required>
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
                                <tbody>
                                    <!-- Templates will be loaded here -->
                                </tbody>
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
                                        <button class="btn btn-sm btn-outline-primary" 
                                                onclick="selectFabric('{{ $fabric->type }}', '{{ $fabric->color }}', {{ $fabric->selling_rate }})">
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
    <!-- Select2 JS -->
    <script src="{{ asset('backend/assets/vendor/select2/js/select2.min.js') }}"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Simple Color Picker JS -->
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>

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
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap'
            });

            // Initialize Color Picker
            let pickr = null;
            
            // Create color picker when button is clicked
            $('#colorPickerBtn').click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // If pickr already exists, show it
                if (pickr) {
                    pickr.show();
                    return;
                }
                
                // Create new pickr instance
                pickr = Pickr.create({
                    el: '#colorPickerContainer',
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

                // Show picker
                $('#colorPickerContainer').show();
                pickr.show();

                // When color is selected
                pickr.on('save', (color, instance) => {
                    const hexColor = color.toHEXA().toString();
                    $('#fabric_color').val(hexColor);
                    $('#colorPickerContainer').hide();
                    pickr.hide();
                });

                // When clear button is clicked
                pickr.on('clear', (instance) => {
                    $('#fabric_color').val('');
                    $('#colorPickerContainer').hide();
                    pickr.hide();
                });
            });

            // Close color picker when clicking outside
            $(document).click(function(e) {
                if (!$(e.target).closest('#colorPickerContainer, #colorPickerBtn, .pcr-button').length) {
                    if (pickr) {
                        $('#colorPickerContainer').hide();
                        pickr.hide();
                    }
                }
            });

            // Add Customer Modal
            $('#addCustomerBtn').click(function() {
                $('#addCustomerModal').modal('show');
            });

            // Save new customer via AJAX - Fixed URL
            $('#newCustomerForm').submit(function(e) {
                e.preventDefault();

                const saveBtn = $('#saveCustomerBtn');
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
                    url: '{{ route("orders.customer.store") }}', // Use the new route
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            // Add new customer to select2 dropdown
                            const newOption = new Option(
                                response.customer.name + ' (' + response.customer.phone + ')',
                                response.customer.id,
                                false,
                                true
                            );

                            $('#customer_id').append(newOption).trigger('change');

                            // Close modal and reset form
                            $('#addCustomerModal').modal('hide');
                            $('#newCustomerForm')[0].reset();
                            $('#newCustomerForm').removeClass('was-validated');

                            toastr.success('{{ __("messages.customer_added_successfully") }}');
                        } else {
                            toastr.error('{{ __("messages.failed_to_add_customer") }}');
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
            $('#addCustomerModal').on('hidden.bs.modal', function() {
                $('#newCustomerForm')[0].reset();
                $('#newCustomerForm').removeClass('was-validated');
            });

            // Update base price when dress type changes
            $('#dress_type_id').change(function() {
                const selectedOption = $(this).find('option:selected');
                const basePrice = selectedOption.data('price') || 0;
                const estimatedDays = selectedOption.data('days') || 7;
                
                $('#base_price').val(basePrice);
                
                // Update delivery date based on estimated days
                const orderDate = $('input[name="order_date"]').val();
                if (orderDate) {
                    const deliveryDate = new Date(orderDate);
                    deliveryDate.setDate(deliveryDate.getDate() + parseInt(estimatedDays));
                    const formattedDate = deliveryDate.toISOString().split('T')[0];
                    $('#delivery_date').val(formattedDate);
                }
                
                calculateTotal();
            });

            // Calculate fabric cost
            $('#fabric_meters, #fabric_rate').on('input', function() {
                const meter = parseFloat($('#fabric_meters').val()) || 0;
                const rate = parseFloat($('#fabric_rate').val()) || 0;
                const fabricCost = meter * rate;
                $('#fabric_cost').val(fabricCost.toFixed(2));
                calculateTotal();
            });

            // Calculate total amount
            $('#stitching_charges, #additional_charges, #discount_amount, #advance_amount').on('input', calculateTotal);

            // Load measurement templates when customer changes
            $('#customer_id').change(function() {
                const customerId = $(this).val();
                if (customerId) {
                    $('#loadTemplatesBtn').prop('disabled', false);
                } else {
                    $('#loadTemplatesBtn').prop('disabled', true);
                }
            });

            // Load templates button click
            $('#loadTemplatesBtn').click(function() {
                const customerId = $('#customer_id').val();
                const dressTypeId = $('#dress_type_id').val();
                
                if (!customerId) {
                    alert('{{ __("messages.please_select_customer_first") }}');
                    return;
                }
                
                $('#measurementModal').modal('show');
                loadMeasurementTemplates(customerId, dressTypeId);
            });

            // Select fabric button click
            $('#selectFabricBtn').click(function() {
                $('#fabricModal').modal('show');
            });

            // Form submission
            $('#orderForm').submit(function(e) {
                // Validate form
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
                    alert('{{ __("messages.please_fill_required_fields") }}');
                    return;
                }

                // Check if total amount is valid
                const totalAmount = parseFloat($('#total_amount').val()) || 0;
                if (totalAmount <= 0) {
                    e.preventDefault();
                    alert('{{ __("messages.check_pricing_total") }}');
                    return;
                }

                // Auto-calculate remaining amount before submission
                calculateTotal();
            });

            // Initialize calculations
            calculateTotal();
        });

        function loadMeasurementTemplates(customerId, dressTypeId) {
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
                        // Filter by dress type if selected
                        let filteredTemplates = templates;
                        if (dressTypeId) {
                            filteredTemplates = templates.filter(template => 
                                template.dress_type.toLowerCase().includes($('#dress_type_id option:selected').text().toLowerCase())
                            );
                        }
                        
                        if (filteredTemplates.length > 0) {
                            filteredTemplates.forEach(template => {
                                const measurements = template.measurements;
                                const row = `
                                    <tr>
                                        <td>${template.template_name}</td>
                                        <td>${template.dress_type}</td>
                                        <td>${measurements.height || 'N/A'}</td>
                                        <td>${measurements.chest || 'N/A'}</td>
                                        <td>${measurements.waist || 'N/A'}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    onclick="applyTemplate(${JSON.stringify(measurements).replace(/"/g, '&quot;')})">
                                                {{ __("messages.apply") }}
                                            </button>
                                        </td>
                                    </tr>
                                `;
                                tableBody.append(row);
                            });
                            $('#templateContent').show();
                        } else {
                            $('#noTemplates').show();
                        }
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

        function applyTemplate(measurements) {
            // Apply measurements to form fields
            Object.keys(measurements).forEach(key => {
                const input = $(`input[name="measurements[${key}]"], textarea[name="measurements[${key}]"]`);
                if (input.length) {
                    input.val(measurements[key]);
                }
            });
            
            $('#measurementModal').modal('hide');
            alert('{{ __("messages.measurement_template_applied") }}');
        }

        function selectFabric(type, color, rate) {
            $('#fabric_type').val(type);
            $('#fabric_color').val(color);
            $('#fabric_rate').val(rate);
            $('#fabricModal').modal('hide');

            // Suggest meter requirement based on dress type
            const dressTypeName = $('#dress_type_id option:selected').text().toLowerCase();
            let suggestedMeters = 0;

            if (dressTypeName.includes('sherwani') || dressTypeName.includes('gown')) {
                suggestedMeters = 5.5;
            } else if (dressTypeName.includes('suit')) {
                suggestedMeters = 4.0;
            } else if (dressTypeName.includes('kurta') || dressTypeName.includes('shalwar')) {
                suggestedMeters = 3.5;
            } else if (dressTypeName.includes('lehenga')) {
                suggestedMeters = 6.0;
            } else {
                suggestedMeters = 2.5;
            }

            $('#fabric_meters').val(suggestedMeters);

            // Calculate fabric cost
            const fabricCost = suggestedMeters * rate;
            $('#fabric_cost').val(fabricCost.toFixed(2));
            calculateTotal();

            alert(`{{ __("messages.fabric_selected") }}`.replace(':type', type).replace(':color', color));
        }

        function calculateTotal() {
            const basePrice = parseFloat($('#base_price').val()) || 0;
            const fabricCost = parseFloat($('#fabric_cost').val()) || 0;
            const stitching = parseFloat($('#stitching_charges').val()) || 0;
            const additional = parseFloat($('#additional_charges').val()) || 0;
            const discount = parseFloat($('#discount_amount').val()) || 0;

            const total = basePrice + fabricCost + stitching + additional - discount;
            $('#total_amount').val(total.toFixed(2));
            
            // Calculate balance
            const advancePaid = parseFloat($('#advance_amount').val()) || 0;
            const balance = total - advancePaid;
            $('#balance_due').val(balance.toFixed(2));
            $('#remaining_amount').val(balance.toFixed(2));
        }

        function resetForm() {
            if (confirm('{{ __("messages.are_you_sure_reset") }}')) {
                document.getElementById('orderForm').reset();
                $('.select2').val(null).trigger('change');
                $('#base_price').val(0);
                $('#fabric_cost').val(0);
                $('#total_amount').val(0);
                $('#balance_due').val(0);
                $('#remaining_amount').val(0);
                alert('{{ __("messages.form_reset_successfully") }}');
            }
        }

        function saveAsDraft() {
            // In real app: AJAX call to save as draft
            // For now, just submit the form
            $('#orderForm').append('<input type="hidden" name="save_as_draft" value="1">');
            $('#orderForm').submit();
        }

        // Helper function to get color code
        function getColorCode(colorName) {
            const colors = {
                'navy blue': '#1D4ED8',
                'white': '#FFFFFF',
                'black': '#000000',
                'red': '#EF4444',
                'blue': '#3B82F6',
                'green': '#10B981',
                'yellow': '#F59E0B',
                'pink': '#EC4899',
                'purple': '#8B5CF6',
                'gray': '#6B7280',
                'brown': '#92400E',
                'beige': '#FDE68A',
                'maroon': '#991B1B',
                'orange': '#F97316',
                'gold': '#FBBF24',
                'silver': '#D1D5DB',
            };
            return colors[colorName.toLowerCase()] || '#6B7280';
        }
    </script>

    <style>
        .card {
            border-radius: 0.5rem;
        }

        .card-header.bg-light {
            background-color: #f8f9fa !important;
            border-bottom: 1px solid #e9ecef;
        }

        .btn {
            border-radius: 0.375rem;
        }

        .form-control {
            border-radius: 0.375rem;
        }

        .modal-content {
            border-radius: 0.5rem;
            border: none;
        }

        .close {
            font-size: 1.5rem;
            font-weight: 300;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #6c757d;
        }

        .badge {
            font-size: 0.75em;
            font-weight: 500;
            padding: 0.35em 0.65em;
        }

        #total_amount {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #28a745;
        }

        #balance_due {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #dc3545;
        }

        .form-check-input:checked {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .select2-container--bootstrap .select2-selection {
            border-radius: 0.375rem;
        }
        
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        /* Color Picker Styles */
        #colorPickerContainer {
            display: none;
            position: absolute;
            z-index: 1000;
            background: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        .pickr {
            width: 100% !important;
        }

        .pcr-button {
            width: 100% !important;
            height: 40px !important;
            border-radius: 4px;
        }

        /* Toastr customization */
        .toast-success {
            background-color: #28a745 !important;
        }

        .toast-error {
            background-color: #dc3545 !important;
        }
    </style>
    @endpush
</x-app-layout>