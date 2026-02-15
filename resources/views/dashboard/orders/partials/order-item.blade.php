<div class="order-item-card" id="order_item_{{ $index }}" data-item-id="{{ $index }}">
    <div class="order-item-header">
        <div>
            <span class="item-count-badge">{{ __('messages.item') }} #{{ $index + 1 }}</span>
            <span class="ml-2 text-muted small">
                <i class="las la-tag"></i> 
                <span id="item_total_display_{{ $index }}">Rs 0.00</span>
            </span>
        </div>
        <div>
            <button type="button" class="btn btn-sm btn-outline-info load-templates-btn mr-2" 
                    data-item-id="{{ $index }}" id="loadTemplatesBtn" disabled>
                <i class="las la-ruler"></i> {{ __('messages.load_template') }}
            </button>
            <i class="las la-trash-alt remove-item-btn" data-item-id="{{ $index }}" 
               title="{{ __('messages.remove_item') }}" data-toggle="tooltip"></i>
        </div>
    </div>
    
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ __('messages.dress_type') }} *</label>
                <select class="form-control select2 dress-type-select" 
                        id="dress_type_id_{{ $index }}" 
                        name="items[{{ $index }}][dress_type_id]" 
                        data-item-id="{{ $index }}" required>
                    <option value="">{{ __('messages.select_dress_type') }}</option>
                    @foreach($dressTypes as $dressType)
                    <option value="{{ $dressType->id }}" 
                            data-price="{{ $dressType->base_price }}"
                            data-days="{{ $dressType->estimated_days }}">
                        {{ $dressType->name }} - Rs {{ number_format($dressType->base_price) }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-2 mb-3">
                <label class="form-label">{{ __('messages.quantity') }}</label>
                <input type="number" class="form-control item-quantity" 
                       id="quantity_{{ $index }}"
                       name="items[{{ $index }}][quantity]" 
                       value="1" min="1" step="1"
                       data-item-id="{{ $index }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label">{{ __('messages.base_price') }}</label>
                <input type="number" step="0.01" class="form-control" 
                       id="base_price_{{ $index }}"
                       name="items[{{ $index }}][base_price]" 
                       value="0" readonly>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label">{{ __('messages.item_total') }}</label>
                <input type="hidden" id="item_total_{{ $index }}" 
                       name="items[{{ $index }}][item_total]" value="0">
                <div class="form-control bg-light font-weight-bold" 
                     id="item_total_display_{{ $index }}">Rs 0.00</div>
            </div>
        </div>

        <!-- Fabric Details -->
        <div class="fabric-section">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">{{ __('messages.fabric_details') }}</h6>
                <div>
                    <div class="custom-control custom-switch d-inline-block mr-3">
                        <input type="checkbox" class="custom-control-input include-fabric-checkbox" 
                               id="includeFabricInTotal_{{ $index }}" 
                               name="include_fabric_in_total[{{ $index }}]"
                               data-item-id="{{ $index }}" checked>
                        <label class="custom-control-label" for="includeFabricInTotal_{{ $index }}">
                            {{ __('messages.include_fabric_in_total') }}
                        </label>
                    </div>
                    
                    <button type="button" class="btn btn-sm btn-outline-info select-fabric-from-inventory" 
                            data-item-id="{{ $index }}">
                        <i class="las la-layer-group mr-1"></i> {{ __('messages.select_from_inventory') }}
                    </button>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.fabric_type') }}</label>
                    <input type="text" class="form-control" 
                           id="fabric_type_{{ $index }}"
                           name="items[{{ $index }}][fabric_type]" 
                           placeholder="{{ __('e.g., Silk, Cotton') }}">
                </div>
                
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.color') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" 
                               id="fabric_color_{{ $index }}"
                               name="items[{{ $index }}][fabric_color]"
                               placeholder="{{ __('e.g., Navy Blue') }}">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary color-picker-btn" 
                                    id="colorPickerBtn_{{ $index }}" data-item-id="{{ $index }}">
                                <i class="las la-eye-dropper"></i>
                            </button>
                        </div>
                    </div>
                    <div id="colorPickerContainer_{{ $index }}" class="mt-2" style="display: none;"></div>
                </div>
                
                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('messages.meter_required') }}</label>
                    <input type="number" step="0.01" class="form-control fabric-meters" 
                           id="fabric_meters_{{ $index }}"
                           name="items[{{ $index }}][fabric_meters]" 
                           placeholder="3.5" value="0"
                           data-item-id="{{ $index }}">
                </div>
                
                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('messages.fabric_rate_m') }}</label>
                    <input type="number" step="0.01" class="form-control fabric-rate" 
                           id="fabric_rate_{{ $index }}"
                           name="items[{{ $index }}][fabric_rate]" 
                           value="0"
                           data-item-id="{{ $index }}">
                </div>
                
                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('messages.fabric_cost') }}</label>
                    <input type="number" step="0.01" class="form-control bg-light" 
                           id="fabric_cost_{{ $index }}"
                           name="items[{{ $index }}][fabric_cost]" 
                           value="0" readonly>
                </div>
            </div>
        </div>

        <!-- Measurements -->
        <div class="measurement-section">
            <h6 class="mb-3">{{ __('messages.measurements_cm') }}</h6>
            <div class="row">
                @if(in_array('height', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.height') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][height]" 
                           placeholder="170">
                </div>
                @endif
                
                @if(in_array('weight', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.weight') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][weight]" 
                           placeholder="70">
                </div>
                @endif
                
                @if(in_array('chest', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.chest') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][chest]" 
                           placeholder="42">
                </div>
                @endif
                
                @if(in_array('waist', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.waist') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][waist]" 
                           placeholder="38">
                </div>
                @endif
                
                @if(in_array('hips', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.hips') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][hips]" 
                           placeholder="44">
                </div>
                @endif
                
                @if(in_array('shoulder', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.shoulder') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][shoulder]" 
                           placeholder="18">
                </div>
                @endif
                
                @if(in_array('sleeve_length', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.sleeve_length') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][sleeve_length]" 
                           placeholder="60">
                </div>
                @endif
                
                @if(in_array('sleeve_width', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.sleeve_width') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][sleeve_width]" 
                           placeholder="18">
                </div>
                @endif
            </div>
            
            <div class="row">
                @if(in_array('collar', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.collar') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][collar]" 
                           placeholder="16">
                </div>
                @endif
                
                @if(in_array('bicep', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.bicep') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][bicep]" 
                           placeholder="12">
                </div>
                @endif
                
                @if(in_array('wrist', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.wrist') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][wrist]" 
                           placeholder="8">
                </div>
                @endif
                
                @if(in_array('pant_length', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.pant_length') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][pant_length]" 
                           placeholder="100">
                </div>
                @endif
                
                @if(in_array('inseam', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.inseam') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][inseam]" 
                           placeholder="80">
                </div>
                @endif
                
                @if(in_array('thigh', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.thigh') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][thigh]" 
                           placeholder="24">
                </div>
                @endif
                
                @if(in_array('knee', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.knee') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][knee]" 
                           placeholder="18">
                </div>
                @endif
                
                @if(in_array('bottom', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.bottom') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][bottom]" 
                           placeholder="22">
                </div>
                @endif
                
                @if(in_array('ankle', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.ankle') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][ankle]" 
                           placeholder="10">
                </div>
                @endif
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('messages.fitting_preferences') }}</label>
                    <textarea class="form-control" 
                              name="items[{{ $index }}][measurements][fitting_preferences]" 
                              rows="2" placeholder="{{ __('Loose, tight, or any specific preferences...') }}"></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('messages.measurement_notes') }}</label>
                    <textarea class="form-control" 
                              name="items[{{ $index }}][measurements][notes]" 
                              rows="2" placeholder="{{ __('Additional notes about measurements...') }}"></textarea>
                </div>
            </div>
        </div>

        <!-- Pricing & Tailor -->
        <div class="row mt-3">
            <div class="col-md-3 mb-3">
                <label class="form-label">{{ __('messages.stitching_charges') }}</label>
                <input type="number" step="0.01" class="form-control stitching-charges" 
                       id="stitching_charges_{{ $index }}"
                       name="items[{{ $index }}][stitching_charges]" 
                       value="0"
                       data-item-id="{{ $index }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label">{{ __('messages.additional_charges') }}</label>
                <input type="number" step="0.01" class="form-control additional-charges" 
                       id="additional_charges_{{ $index }}"
                       name="items[{{ $index }}][additional_charges]" 
                       value="0"
                       data-item-id="{{ $index }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label">{{ __('messages.discount') }}</label>
                <input type="number" step="0.01" class="form-control item-discount" 
                       id="item_discount_{{ $index }}"
                       name="items[{{ $index }}][discount_amount]" 
                       value="0"
                       data-item-id="{{ $index }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label">{{ __('messages.assign_to_tailor') }}</label>
                <select class="form-control select2" id="tailor_id_{{ $index }}" 
                        name="items[{{ $index }}][tailor_id]">
                    <option value="">{{ __('messages.select_tailor') }}</option>
                    @foreach($tailors as $tailor)
                    <option value="{{ $tailor->id }}">
                        {{ $tailor->name }} - {{ ucfirst($tailor->employment_type) }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <label class="form-label">{{ __('messages.special_instructions') }}</label>
                <textarea class="form-control" 
                          name="items[{{ $index }}][instructions]" 
                          rows="2" placeholder="{{ __('Any special instructions for this item...') }}"></textarea>
            </div>
        </div>
    </div>
</div>