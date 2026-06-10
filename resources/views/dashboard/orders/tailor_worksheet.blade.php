<!-- Tailor Worksheet Template -->
<div id="tailor-worksheet-template" style="display: none;">
    <div class="print-tailor-worksheet" style="font-family: 'Courier New', monospace; max-width: 800px; margin: 0 auto; padding: 20px; background: white;">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 15px;">
            <div style="font-size: 24px; font-weight: bold; text-transform: uppercase;">TAILOR WORKSHEET</div>
            <div style="font-size: 16px; margin-top: 5px;">{{ $settings->shop_name ?? config('app.name', 'Tailor Shop') }}</div>
            <div style="font-size: 14px;">Order #{{ $order->order_number }}</div>
            {{-- @if($order->delivery_date->diffInDays(now()) < ($settings->reminder_days_before ?? 3) && $order->delivery_date->isFuture())
                <div style="color: red; font-weight: bold; font-size: 18px; margin-top: 5px;">
                    ⚠️ URGENT - DELIVERY IN {{ round($order->delivery_date->diffInDays(now())) }} DAYS ⚠️
                </div>
            @endif --}}
        </div>

        <!-- Order Summary -->
        <div style="display: flex; justify-content: space-between; margin-bottom: 30px; padding: 15px; border: 2px solid #000; background: #f0f0f0;">
            <div>
                <strong>Customer:</strong> {{ $order->customer->name }}<br>
                <strong>Phone:</strong> {{ $order->customer->phone }}<br>
                <strong>Order Date:</strong> {{ $order->order_date->format('d M, Y') }}
            </div>
            <div>
                {{-- <strong>Delivery Date:</strong> {{ $order->delivery_date->format('d M, Y') }}<br> --}}
                <strong>Branch:</strong> {{ $order->branch->name }}<br>
                <strong>Order Type:</strong> {{ ucfirst($order->order_type) }}
            </div>
        </div>

        <!-- Items for Tailor -->
        @foreach($order->items as $item)
        <div style="margin-bottom: 30px; padding: 15px; border: 2px solid #000; page-break-inside: avoid;">
            <div style="background: #000; color: white; padding: 10px; margin: -15px -15px 15px -15px; font-weight: bold; font-size: 16px;">
                {{ $item->item_name }} | Qty: {{ $item->quantity }}
                @if($item->item_status == 'pending')
                    <span style="float: right; background: #ffc107; color: black; padding: 2px 8px;">NEW ORDER</span>
                @elseif($item->item_status == 'in-progress')
                    <span style="float: right; background: #17a2b8; color: white; padding: 2px 8px;">IN PROGRESS</span>
                @elseif($item->item_status == 'ready')
                    <span style="float: right; background: #28a745; color: white; padding: 2px 8px;">READY</span>
                @endif
            </div>

            <!-- Dress Type Info -->
            @if($item->dressType)
            <div style="margin-bottom: 15px;">
                <strong>Dress Type:</strong> {{ $item->dressType->name }}<br>
                <strong>Estimated Days:</strong> {{ $item->dressType->estimated_days ?? $settings->default_delivery_days ?? 7 }} days
            </div>
            @endif

            <!-- Tailor Assignment -->
            @if($item->tailorAssignments->count() > 0)
                @php $assignment = $item->tailorAssignments->first(); @endphp
                <div style="margin-top: 15px; padding: 10px; border-top: 2px dashed #000;">
                    <strong>ASSIGNED TO:</strong> {{ strtoupper($assignment->tailor->name) }}<br>
                    <!-- <strong>Stitching Charge:</strong> {{ $settings->currency_symbol ?? 'Rs' }} {{ number_format($assignment->stitching_charge) }}<br> -->
                    <strong>Status:</strong> {{ $assignment->status->name }} | <strong>Progress:</strong> {{ $assignment->progress_percentage }}%
                </div>
            @else
                <div style="margin: 15px 0; padding: 10px; background: #ffc107; color: black; font-weight: bold;">
                    ⚠️ NOT ASSIGNED - PLEASE ASSIGN TAILOR
                </div>
            @endif

            <!-- Measurements - Dynamic from enabledFields -->
            @if($item->measurements->count() > 0)
                @php $measurement = $item->measurements->first(); @endphp
                <div style="margin-top: 20px;">
                    <strong style="font-size: 16px;">📏 MEASUREMENTS (cm)</strong>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 15px;">
                        @php
                            $enabledFields = $enabledFields ?? [
                                'height', 'chest', 'waist', 'hips', 'shoulder', 
                                'sleeve_length', 'collar', 'bicep', 'wrist', 
                                'pant_length', 'inseam', 'thigh'
                            ];
                        @endphp
                        
                        @foreach($enabledFields as $field)
                            @if(isset($measurement->$field) && $measurement->$field !== null)
                                @php
                                    $labels = [
                                        'height' => 'Height',
                                        'weight' => 'Weight',
                                        'chest' => 'Chest',
                                        'waist' => 'Waist',
                                        'hips' => 'Hips',
                                        'shoulder' => 'Shoulder',
                                        'sleeve_length' => 'Sleeve Length',
                                        'sleeve_width' => 'Sleeve Width',
                                        'collar' => 'Collar',
                                        'bicep' => 'Bicep',
                                        'wrist' => 'Wrist',
                                        'pant_length' => 'Pant Length',
                                        'inseam' => 'Inseam',
                                        'thigh' => 'Thigh',
                                        'knee' => 'Knee',
                                        'bottom' => 'Bottom',
                                        'ankle' => 'Ankle',
                                    ];
                                    $label = $labels[$field] ?? ucwords(str_replace('_', ' ', $field));
                                @endphp
                                <div style="padding: 8px; border: 1px solid #ddd; background: #fafafa;">
                                    <strong>{{ $label }}:</strong> {{ $measurement->$field }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                    
                    @if($measurement->fitting_preferences)
                    <div style="margin-top: 15px; padding: 10px; background: #e9ecef;">
                        <strong>Fitting Preferences:</strong> {{ $measurement->fitting_preferences }}
                    </div>
                    @endif
                    
                    @if($measurement->notes)
                    <div style="margin-top: 10px; padding: 10px; background: #fff3cd; border-left: 4px solid #ffc107;">
                        <strong>📝 Notes:</strong> {{ $measurement->notes }}
                    </div>
                    @endif
                </div>
            @else
                <div style="margin-top: 15px; padding: 10px; background: #dc3545; color: white; font-weight: bold;">
                    ❌ NO MEASUREMENTS RECORDED
                </div>
            @endif

            <!-- Special Instructions -->
            @if($item->instructions)
            <div style="margin-top: 20px; padding: 10px; background: #d1ecf1; border-left: 4px solid #0c5460;">
                <strong>📋 Special Instructions:</strong> {{ $item->instructions }}
            </div>
            @endif

            <!-- Quality Checklist -->
            <div style="margin-top: 20px; padding: 10px; border: 1px solid #000;">
                <strong>✓ QUALITY CHECKLIST</strong>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); margin-top: 10px;">
                    <div>☐ Measurements verified</div>
                    <div>☐ Fabric checked</div>
                    <div>☐ Stitching started</div>
                    <div>☐ First fitting completed</div>
                    <div>☐ Final stitching</div>
                    <div>☐ Ironing/Pressing</div>
                    <div>☐ Quality check</div>
                    <div>☐ Ready for delivery</div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Internal Notes -->
        @if($order->internal_notes)
        <div style="margin-top: 30px; padding: 15px; border: 2px solid #000; background: #f8f9fa;">
            <strong>📌 INTERNAL NOTES:</strong><br>
            {{ $order->internal_notes }}
        </div>
        @endif

        <!-- Footer with Signature Lines -->
        <div style="margin-top: 40px; padding-top: 20px; border-top: 2px solid #000; font-size: 12px;">
            <div style="display: flex; justify-content: space-between;">
                <div>
                    <strong>Tailor Name:</strong> _________________________<br>
                    <strong>Start Date:</strong> _________________________<br>
                    <strong>Completion Date:</strong> _________________________
                </div>
                <div>
                    <strong>Supervisor:</strong> _________________________<br>
                    <strong>Quality Check:</strong> _________________________
                </div>
            </div>
            <div style="margin-top: 20px; text-align: center;">
                <p style="font-size: 10px;">{{ $settings->receipt_footer ?? 'This worksheet must be returned with the finished garment' }}</p>
            </div>
        </div>
    </div>
</div>