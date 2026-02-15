<div class="order-item-card" id="order_item_{{ $index }}" data-item-id="{{ $index }}" data-is-existing="true">
    <div class="order-item-header">
        <div>
            <span class="item-count-badge">{{ __('Item') }} #{{ $index + 1 }}</span>
            <span class="ml-2 text-muted small">
                <i class="las la-tag"></i> 
                <span id="item_total_display_{{ $index }}">Rs {{ number_format($item->total, 0) }}</span>
            </span>
        </div>
        <div>
            <span class="badge badge-{{ $item->item_status == 'pending' ? 'warning' : ($item->item_status == 'cutting' ? 'info' : ($item->item_status == 'stitching' ? 'primary' : ($item->item_status == 'ready' ? 'success' : 'secondary'))) }} mr-2">
                {{ ucfirst($item->item_status) }}
            </span>
            <button type="button" class="btn btn-sm btn-outline-info load-templates-btn mr-2" 
                    data-item-id="{{ $index }}" id="loadTemplatesBtn_{{ $index }}">
                <i class="las la-ruler"></i> {{ __('Load Template') }}
            </button>
            <i class="las la-trash-alt remove-item-btn" data-item-id="{{ $index }}" 
               title="{{ __('Remove Item') }}" data-toggle="tooltip"></i>
        </div>
    </div>
    
    <div class="card-body">
        <!-- Item ID for update -->
        <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
        
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ __('Dress Type') }} *</label>
                <select class="form-control select2 dress-type-select" 
                        id="dress_type_id_{{ $index }}" 
                        name="items[{{ $index }}][dress_type_id]" 
                        data-item-id="{{ $index }}" required>
                    <option value="">{{ __('Select Dress Type') }}</option>
                    @foreach($dressTypes as $dressType)
                    <option value="{{ $dressType->id }}" 
                            data-price="{{ $dressType->base_price }}"
                            data-days="{{ $dressType->estimated_days }}"
                            {{ $item->dress_type_id == $dressType->id ? 'selected' : '' }}>
                        {{ $dressType->name }} - Rs {{ number_format($dressType->base_price, 0) }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-2 mb-3">
                <label class="form-label">{{ __('Quantity') }}</label>
                <input type="number" class="form-control item-quantity" 
                       id="quantity_{{ $index }}"
                       name="items[{{ $index }}][quantity]" 
                       value="{{ $item->quantity }}" min="1" step="1"
                       data-item-id="{{ $index }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label">{{ __('Base Price') }}</label>
                <input type="number" step="0.01" class="form-control" 
                       id="base_price_{{ $index }}"
                       name="items[{{ $index }}][base_price]" 
                       value="{{ $item->price }}" readonly>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label">{{ __('Item Total') }}</label>
                <input type="hidden" id="item_total_{{ $index }}" 
                       name="items[{{ $index }}][item_total]" value="{{ $item->total }}">
                <div class="form-control bg-light font-weight-bold" 
                     id="item_total_display_{{ $index }}">Rs {{ number_format($item->total, 0) }}</div>
            </div>
        </div>

        <!-- Fabric Details -->
        <div class="fabric-section">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">{{ __('Fabric Details') }}</h6>
                <div>
                    <div class="custom-control custom-switch d-inline-block mr-3">
                        <input type="checkbox" class="custom-control-input include-fabric-checkbox" 
                               id="includeFabricInTotal_{{ $index }}" 
                               data-item-id="{{ $index }}" 
                               {{ $item->fabric_cost > 0 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="includeFabricInTotal_{{ $index }}">
                            {{ __('Include in Total') }}
                        </label>
                    </div>
                    
                    <button type="button" class="btn btn-sm btn-outline-info select-fabric-from-inventory" 
                            data-item-id="{{ $index }}">
                        <i class="las la-layer-group mr-1"></i> {{ __('Select from Inventory') }}
                    </button>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Fabric Type') }}</label>
                    <input type="text" class="form-control" 
                           id="fabric_type_{{ $index }}"
                           name="items[{{ $index }}][fabric_type]" 
                           placeholder="{{ __('e.g., Silk, Cotton') }}"
                           value="{{ $item->fabric_type }}">
                </div>
                
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Color') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" 
                               id="fabric_color_{{ $index }}"
                               name="items[{{ $index }}][fabric_color]"
                               placeholder="{{ __('e.g., Navy Blue') }}"
                               value="{{ $item->fabric_color }}">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary color-picker-btn" 
                                    id="colorPickerBtn_{{ $index }}" data-item-id="{{ $index }}">
                                <i class="las la-eye-dropper"></i>
                            </button>
                        </div>
                    </div>
                    <div id="colorPickerContainer_{{ $index }}" class="color-picker-container"></div>
                </div>
                
                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('Meters') }}</label>
                    <input type="number" step="0.01" class="form-control fabric-meters" 
                           id="fabric_meters_{{ $index }}"
                           name="items[{{ $index }}][fabric_meters]" 
                           placeholder="3.5" value="{{ $item->fabric_meters ?? 0 }}"
                           data-item-id="{{ $index }}">
                </div>
                
                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('Rate/m') }}</label>
                    <input type="number" step="0.01" class="form-control fabric-rate" 
                           id="fabric_rate_{{ $index }}"
                           name="items[{{ $index }}][fabric_rate]" 
                           value="{{ $item->fabric_rate ?? 0 }}"
                           data-item-id="{{ $index }}">
                </div>
                
                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('Fabric Cost') }}</label>
                    <input type="number" step="0.01" class="form-control bg-light" 
                           id="fabric_cost_{{ $index }}"
                           name="items[{{ $index }}][fabric_cost]" 
                           value="{{ $item->fabric_cost ?? 0 }}" readonly>
                </div>
            </div>
            
            <!-- Inventory fabric hidden fields -->
            <input type="hidden" name="items[{{ $index }}][fabric_product_id]" value="{{ $item->fabric_product_id }}">
            <input type="hidden" name="items[{{ $index }}][is_inventory_fabric]" value="{{ $item->is_inventory_fabric }}">
        </div>

        <!-- Measurements -->
        <div class="measurement-section">
            <h6 class="mb-3">{{ __('Measurements (cm)') }}</h6>
            <div class="row">
                @if(in_array('height', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Height') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][height]" 
                           placeholder="170" value="{{ $measurement->height ?? '' }}">
                </div>
                @endif
                
                @if(in_array('weight', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Weight') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][weight]" 
                           placeholder="70" value="{{ $measurement->weight ?? '' }}">
                </div>
                @endif
                
                @if(in_array('chest', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Chest') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][chest]" 
                           placeholder="42" value="{{ $measurement->chest ?? '' }}">
                </div>
                @endif
                
                @if(in_array('waist', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Waist') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][waist]" 
                           placeholder="38" value="{{ $measurement->waist ?? '' }}">
                </div>
                @endif
                
                @if(in_array('hips', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Hips') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][hips]" 
                           placeholder="44" value="{{ $measurement->hips ?? '' }}">
                </div>
                @endif
                
                @if(in_array('shoulder', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Shoulder') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][shoulder]" 
                           placeholder="18" value="{{ $measurement->shoulder ?? '' }}">
                </div>
                @endif
                
                @if(in_array('sleeve_length', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Sleeve Length') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][sleeve_length]" 
                           placeholder="60" value="{{ $measurement->sleeve_length ?? '' }}">
                </div>
                @endif
                
                @if(in_array('sleeve_width', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Sleeve Width') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][sleeve_width]" 
                           placeholder="18" value="{{ $measurement->sleeve_width ?? '' }}">
                </div>
                @endif
            </div>
            
            <div class="row">
                @if(in_array('collar', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Collar') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][collar]" 
                           placeholder="16" value="{{ $measurement->collar ?? '' }}">
                </div>
                @endif
                
                @if(in_array('bicep', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Bicep') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][bicep]" 
                           placeholder="12" value="{{ $measurement->bicep ?? '' }}">
                </div>
                @endif
                
                @if(in_array('wrist', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Wrist') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][wrist]" 
                           placeholder="8" value="{{ $measurement->wrist ?? '' }}">
                </div>
                @endif
                
                @if(in_array('pant_length', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Pant Length') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][pant_length]" 
                           placeholder="100" value="{{ $measurement->pant_length ?? '' }}">
                </div>
                @endif
                
                @if(in_array('inseam', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Inseam') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][inseam]" 
                           placeholder="80" value="{{ $measurement->inseam ?? '' }}">
                </div>
                @endif
                
                @if(in_array('thigh', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Thigh') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][thigh]" 
                           placeholder="24" value="{{ $measurement->thigh ?? '' }}">
                </div>
                @endif
                
                @if(in_array('knee', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Knee') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][knee]" 
                           placeholder="18" value="{{ $measurement->knee ?? '' }}">
                </div>
                @endif
                
                @if(in_array('bottom', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Bottom') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][bottom]" 
                           placeholder="22" value="{{ $measurement->bottom ?? '' }}">
                </div>
                @endif
                
                @if(in_array('ankle', $enabledFields))
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Ankle') }}</label>
                    <input type="number" step="0.1" class="form-control" 
                           name="items[{{ $index }}][measurements][ankle]" 
                           placeholder="10" value="{{ $measurement->ankle ?? '' }}">
                </div>
                @endif
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Fitting Preferences') }}</label>
                    <textarea class="form-control" 
                              name="items[{{ $index }}][measurements][fitting_preferences]" 
                              rows="2" placeholder="{{ __('Loose, tight, or any specific preferences...') }}">{{ $measurement->fitting_preferences ?? '' }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Measurement Notes') }}</label>
                    <textarea class="form-control" 
                              name="items[{{ $index }}][measurements][notes]" 
                              rows="2" placeholder="{{ __('Additional notes about measurements...') }}">{{ $measurement->notes ?? '' }}</textarea>
                </div>
            </div>
            
            <!-- Measurement version tracking -->
            <input type="hidden" name="items[{{ $index }}][measurements][id]" value="{{ $measurement->id ?? '' }}">
            <input type="hidden" name="items[{{ $index }}][measurements][version]" value="{{ $measurement->version ?? 1 }}">
        </div>

        <!-- Pricing & Tailor -->
        <div class="row mt-3">
            <div class="col-md-3 mb-3">
                <label class="form-label">{{ __('Stitching Charges') }}</label>
                <input type="number" step="0.01" class="form-control stitching-charges" 
                       id="stitching_charges_{{ $index }}"
                       name="items[{{ $index }}][stitching_charges]" 
                       value="{{ $assignment->stitching_charge ?? 0 }}"
                       data-item-id="{{ $index }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label">{{ __('Additional Charges') }}</label>
                <input type="number" step="0.01" class="form-control additional-charges" 
                       id="additional_charges_{{ $index }}"
                       name="items[{{ $index }}][additional_charges]" 
                       value="{{ $item->additional_charges ?? 0 }}"
                       data-item-id="{{ $index }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label">{{ __('Discount') }}</label>
                <input type="number" step="0.01" class="form-control item-discount" 
                       id="item_discount_{{ $index }}"
                       name="items[{{ $index }}][discount_amount]" 
                       value="{{ $item->discount_amount ?? 0 }}"
                       data-item-id="{{ $index }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label">{{ __('Assign Tailor') }}</label>
                <select class="form-control select2" id="tailor_id_{{ $index }}" 
                        name="items[{{ $index }}][tailor_id]">
                    <option value="">{{ __('Select Tailor') }}</option>
                    @foreach($tailors as $tailor)
                    <option value="{{ $tailor->id }}" 
                        {{ ($assignment->tailor_id ?? '') == $tailor->id ? 'selected' : '' }}>
                        {{ $tailor->name }} - {{ ucfirst($tailor->employment_type) }}
                        @if($tailor->specializations)
                        ({{ is_array($tailor->specializations) ? ($tailor->specializations[0] ?? 'General') : $tailor->specializations }})
                        @endif
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        @if($assignment)
        <!-- Existing tailor assignment -->
        <input type="hidden" name="items[{{ $index }}][tailor_assignment_id]" value="{{ $assignment->id }}">
        <input type="hidden" name="items[{{ $index }}][tailor_assignment_status]" value="{{ $assignment->status_id }}">
        @endif
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ __('Expected Completion') }}</label>
                <input type="date" class="form-control" 
    name="items[{{ $index }}][expected_date]" 
    value="{{ $assignment && $assignment->expected_date ? $assignment->expected_date->format('Y-m-d') : date('Y-m-d', strtotime('+5 days')) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ __('Progress (%)') }}</label>
                <input type="number" class="form-control" 
                       name="items[{{ $index }}][progress_percentage]" 
                       min="0" max="100"
                       value="{{ $assignment->progress_percentage ?? 0 }}">
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <label class="form-label">{{ __('Special Instructions') }}</label>
                <textarea class="form-control" 
                          name="items[{{ $index }}][instructions]" 
                          rows="2" placeholder="{{ __('Any special instructions for this item...') }}">{{ $item->instructions ?? $assignment->instructions ?? '' }}</textarea>
            </div>
        </div>
        
        <!-- Item Status -->
        <div class="row mt-2">
            <div class="col-md-12">
                <label class="form-label">{{ __('Item Status') }}</label>
                <select class="form-control" name="items[{{ $index }}][item_status]">
                    <option value="pending" {{ $item->item_status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                    <option value="cutting" {{ $item->item_status == 'cutting' ? 'selected' : '' }}>{{ __('Cutting') }}</option>
                    <option value="stitching" {{ $item->item_status == 'stitching' ? 'selected' : '' }}>{{ __('Stitching') }}</option>
                    <option value="ready" {{ $item->item_status == 'ready' ? 'selected' : '' }}>{{ __('Ready') }}</option>
                    <option value="delivered" {{ $item->item_status == 'delivered' ? 'selected' : '' }}>{{ __('Delivered') }}</option>
                </select>
            </div>
        </div>
    </div>
</div>