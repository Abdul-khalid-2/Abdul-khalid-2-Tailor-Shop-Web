<!-- Customer Bill Template - Compact Single Page Design with Bold Clear Text -->
<div id="customer-bill-template" style="display: none;">
    <div class="print-customer-bill" style="font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 15px; background: white; font-size: 12px; line-height: 1.5;">
        
        <!-- Header - Compact with Bold Elements -->
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #333338;; padding-bottom: 12px; margin-bottom: 18px;">
            <div>
                <div style="font-size: 24px; font-weight: 800; color: #333338;; letter-spacing: -0.5px;">
                    {{ $settings->shop_name ?? config('app.name', 'Tailor Shop') }}
                </div>
                <div style="color: #444; margin-top: 5px; font-size: 11px; font-weight: 500;">
                    <span style="font-weight: 600;">{{ $settings->shop_address ?? '123 Main Street, City, State - 123456' }}</span><br>
                    <span style="font-weight: 600;">Phone:</span> {{ $settings->shop_phone ?? '+91 98765 43210' }} 
                    @if($settings->shop_email) | <span style="font-weight: 600;">Email:</span> {{ $settings->shop_email }} @endif
                </div>
            </div>
            <div style="text-align: right;">
                
                <div style="margin-top: 8px; font-size: 14px; font-weight: 700; background: #333; color: white; padding: 4px 12px; border-radius: 20px; display: inline-block;">
                    #{{ $order->order_number }}
                </div>
            </div>
        </div>

        <!-- Customer & Order Info - Compact Grid with Bold Labels -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 10px; padding: 5px; border-radius: 8px;">
            <div>
                <div style="color: #333338;; font-size: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px; ">
                    CUSTOMER DETAILS
                </div>
                <table style="width: 100%; margin-top: 10px; border-collapse: collapse; font-size: 12px;">
                    <tr>
                        <td style="padding: 6px 0; color: #555; width: 35%; font-weight: 700;">Name:</td>
                        <td style="padding: 6px 0; font-weight: 700; color: #000;">{{ $order->customer->name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #555; font-weight: 700;">Phone:</td>
                        <td style="padding: 6px 0; font-weight: 600;">{{ $order->customer->phone }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #555; font-weight: 700;">Address:</td>
                        <td style="padding: 6px 0; font-weight: 500;">{{ $order->customer->address ?? 'N/A' }}</td>
                    </tr>
                    @if($order->customer->discount_rate > 0)
                    <tr>
                        <td style="padding: 6px 0; color: #555; font-weight: 700;">Discount:</td>
                        <td style="padding: 6px 0; font-weight: 700; color: #dc3545;">{{ $order->customer->discount_rate }}%</td>
                    </tr>
                    @endif
                </table>
            </div>
            <div>
                <div style="color: #333338;; font-size: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px; ">
                    ORDER DETAILS
                </div>
                <table style="width: 100%; margin-top: 10px; border-collapse: collapse; font-size: 12px;">
                    <tr>
                        <td style="padding: 6px 0; color: #555; width: 40%; font-weight: 700;">Order Date:</td>
                        <td style="padding: 6px 0; font-weight: 600;">{{ $order->order_date->format('d M, Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #555; font-weight: 700;">Delivery Date:</td>
                        <td style="padding: 6px 0; font-weight: 700; color: {{ $order->delivery_date->isFuture() ? '#28a745' : '#dc3545' }};">
                            {{ $order->delivery_date->format('d M, Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #555; font-weight: 700;">Branch:</td>
                        <td style="padding: 6px 0; font-weight: 600;">{{ $order->branch->name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #555; font-weight: 700;">Payment:</td>
                        <td style="padding: 6px 0;">
                            <span style="background: {{ $order->paymentStatus->color }}; color: white; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; letter-spacing: 0.3px;">
                                {{ $order->paymentStatus->name }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Order Items - Compact Table with Bold Headers -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="color: #333338;; font-size: 16px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                    ORDER ITEMS
                </div>
                <span style="background: #333338;; color: white; padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                    Total Items: {{ $order->items->count() }}
                </span>
            </div>
            table border add
            <table style="width: 100%;  font-size: 12px; ">
                <thead>
                    <tr style="background: #333338; color: white; font-weight: 700;">
                        <th style="padding: 10px; text-align: left; font-size: 12px;">Item</th>
                        <th style="padding: 10px; text-align: left; font-size: 12px;">Dress Type</th>
                        <th style="padding: 10px; text-align: center; font-size: 12px;">Qty</th>
                        <th style="padding: 10px; text-align: right; font-size: 12px;">Unit Price</th>
                        <th style="padding: 10px; text-align: right; font-size: 12px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 8px 10px; font-weight: 600;">{{ $item->item_name }}</td>
                        <td style="padding: 8px 10px; font-weight: 500;">{{ $item->dressType->name ?? 'N/A' }}</td>
                        <td style="padding: 8px 10px; text-align: center; font-weight: 600;">{{ $item->quantity }}</td>
                        <td style="padding: 8px 10px; text-align: right; font-weight: 500;">
                            {{ $settings->currency_symbol ?? 'Rs' }} {{ number_format($item->dressType->base_price ?? 0) }}
                        </td>
                        <td style="padding: 8px 10px; text-align: right; font-weight: 700; color: #333338;;">
                            {{ $settings->currency_symbol ?? 'Rs' }} {{ number_format($item->total + $assignment->stitching_charge)  }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Amount Summary - Bold and Clear total paid discoutn etc-->
        <div style="display: flex; justify-content: flex-end;">
            <div style="width: 350px; border-radius: 8px; ">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <tr>
                        <td style="padding: 8px; color: #555; font-weight: 700;">Subtotal:</td>
                        <td style="padding: 8px; text-align: right; font-weight: 600;">{{ $settings->currency_symbol ?? 'Rs' }} {{ number_format($order->items->sum('total')) }}</td>
                    </tr>
                    @if($order->discount_amount > 0)
                    <tr>
                        <td style="padding: 8px; color: #555; font-weight: 700;">Discount:</td>
                        <td style="padding: 8px; text-align: right; font-weight: 700; color: #dc3545;">
                            - {{ $settings->currency_symbol ?? 'Rs' }} {{ number_format($order->discount_amount) }}
                        </td>
                    </tr>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Advance Paid:</span>
                        <span>Rs {{ number_format($order->advance_amount, 0) }}</span>
                    </div>
                    @endif
                    @if(($settings->tax_rate ?? 0) > 0)
                    <tr>
                        <td style="padding: 8px; color: #555; font-weight: 700;">Tax ({{ $settings->tax_rate }}%):</td>
                        <td style="padding: 8px; text-align: right; font-weight: 600;">
                            {{ $settings->currency_symbol ?? 'Rs' }} {{ number_format($order->final_amount * ($settings->tax_rate / 100), 2) }}
                        </td>
                    </tr>
                    @endif
                    <tr style="border-top: 3px solid #333338;;">
                        <td style="padding: 12px 8px; font-weight: 800; color: #333338;; font-size: 15px;">Total Amount:</td>
                        <td style="padding: 12px 8px; text-align: right; font-size: 20px; font-weight: 900; color: #333338;;">
                            {{ $settings->currency_symbol ?? 'Rs' }} {{ number_format($order->final_amount) }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>


        <!-- Payment History - Bold Table -->
        @if($order->payments->count() > 0)
        <div style="margin-bottom: 20px;">
            <div style="color: #333338;; font-size: 15px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0px;  display: inline-block;">
                PAYMENT HISTORY
            </div>
            <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                <thead>
                    <tr style="background: #333338;; color: white; font-weight: 700;">
                        <th style="padding: 10px; text-align: left;">Date</th>
                        <th style="padding: 10px; text-align: left;">Receipt #</th>
                        <th style="padding: 10px; text-align: left;">Method</th>
                        <th style="padding: 10px; text-align: right;">Amount</th>
                        <th style="padding: 10px; text-align: right;">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->payments as $payment)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 8px 10px; font-weight: 600;">{{ $payment->payment_date->format('d M, Y') }}</td>
                        <td style="padding: 8px 10px; font-weight: 700; color: #333338;;">{{ $payment->receipt_number }}</td>
                        <td style="padding: 8px 10px; font-weight: 500;">{{ $payment->paymentMethod->name ?? '' }}</td>
                        <td style="padding: 8px 10px; text-align: right; font-weight: 700; color: #28a745;">
                            {{ $settings->currency_symbol ?? 'Rs' }} {{ number_format($payment->amount) }}
                        </td>
                        <td style="padding: 8px 10px; text-align: right; font-weight: 600;">
                            {{ $settings->currency_symbol ?? 'Rs' }} {{ number_format($payment->new_balance) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Notes - Bold and Clear -->
        @if($order->notes)
        <div style="margin-bottom: 20px; padding: 15px; background: #fff8e1; border-left: 6px solid #ffc107; border-radius: 5px; font-size: 12px; border: 1px solid #ffe082;">
            <span style="font-weight: 800; color: #856404; text-transform: uppercase; letter-spacing: 0.5px;">📝 NOTES:</span>
            <span style="margin-left: 10px; font-weight: 600; color: #333;">{{ $order->notes }}</span>
        </div>
        @endif

        <!-- Footer - Bold Two Column -->
        <div style="display: flex; justify-content: space-between; align-items: center;  padding-top: 20px;">
            <div>
                <p style="margin: 0; font-size: 13px; font-weight: 700; color: #333338;;">{{ $settings->receipt_footer ?? 'Thank you for your business!' }}</p>
                <p style="margin: 5px 0 0; font-size: 11px; font-weight: 500; color: #666;">This is a computer generated invoice • No signature required</p>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 13px; margin-bottom: 10px; background: #f0f0f0; padding: 0px 0px; border-radius: 20px; display: inline-block;">
                    <span style="font-weight: 700; color: #555;">Date: </span>
                    <span style="font-weight: 800; color: #000;">{{ now()->format('d M, Y') }}</span>
                </div>
                <div style="display: flex; gap: 25px; margin-top: 10px;">
                    <div style="text-align: center;">
                        <div style="border-top: 3px solid #333; width: 140px; padding-top: 8px;">
                            <span style="font-weight: 700; font-size: 11px; color: #555;">CUSTOMER SIGNATURE</span>
                        </div>
                    </div>
                    <div style="text-align: center;">
                        <div style="border-top: 3px solid #333; width: 140px; padding-top: 8px;">
                            <span style="font-weight: 700; font-size: 11px; color: #555;">AUTHORIZED SIGNATURE</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Additional Footer Note -->
        <div style="margin-top: 15px; text-align: center; font-size: 10px; color: #999; font-weight: 500; border-top: 1px dashed #ddd; padding-top: 12px;">
            {{ $settings->shop_name ?? config('app.name', 'Tailor Shop') }} • {{ $settings->shop_phone ?? '' }} • {{ $settings->shop_email ?? '' }}
        </div>
    </div>
</div>