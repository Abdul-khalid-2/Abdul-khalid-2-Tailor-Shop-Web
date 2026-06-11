@php
    $currency = $setting->currency_symbol ?? 'Rs';
    $shopName = $setting->shop_name ?? config('app.name', 'Tailor Shop');

    // Prefer the order branch's own contact details, falling back to the shop setting.
    $shopAddress = $order->branch->address ?? $setting->shop_address ?? null;
    $shopPhone   = $order->branch->phone   ?? $setting->shop_phone   ?? null;
    $shopEmail   = $order->branch->email   ?? $setting->shop_email   ?? null;

    $fmt = fn ($amount) => $currency . ' ' . number_format((float) $amount, 0);

    // WhatsApp "click to chat" link (message built on the Order model).
    $hasPhone = filled($order->customer->phone ?? null);
    $waUrl = $order->billWhatsappUrl();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bill — {{ $order->order_number }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #222;
            margin: 0;
            background: #f3f4f6;
            font-size: 13px;
        }
        .toolbar {
            max-width: 800px;
            margin: 16px auto;
            display: flex;
            gap: 8px;
            justify-content: flex-end;
            padding: 0 8px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: none;
            border-radius: 6px;
            padding: 9px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
        }
        .btn-print { background: #374151; }
        .btn-wa    { background: #25D366; }
        .btn-back  { background: #6b7280; }

        .bill {
            max-width: 800px;
            margin: 0 auto 32px;
            background: #fff;
            padding: 28px 32px;
            box-shadow: 0 1px 6px rgba(0,0,0,.1);
        }

        .head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid #333;
            padding-bottom: 14px;
            margin-bottom: 18px;
        }
        .shop-name { font-size: 24px; font-weight: 800; letter-spacing: -.5px; }
        .shop-meta { color: #555; margin-top: 4px; font-size: 11px; line-height: 1.6; }
        .bill-tag { text-align: right; }
        .bill-tag .label { font-size: 13px; letter-spacing: 2px; color: #777; font-weight: 700; }
        .bill-tag .num {
            margin-top: 6px; font-size: 14px; font-weight: 700;
            background: #333; color: #fff; padding: 4px 12px; border-radius: 16px; display: inline-block;
        }

        .grid2 { display: flex; gap: 24px; margin-bottom: 18px; }
        .grid2 > div { flex: 1; }
        .section-title {
            font-size: 12px; font-weight: 800; text-transform: uppercase;
            letter-spacing: .5px; color: #333; margin-bottom: 8px;
        }
        .kv { width: 100%; border-collapse: collapse; }
        .kv td { padding: 3px 0; vertical-align: top; }
        .kv td.k { color: #666; width: 42%; font-weight: 600; }
        .kv td.v { font-weight: 600; color: #111; }

        table.items { width: 100%; border-collapse: collapse; margin-top: 6px; }
        table.items thead tr { background: #333; color: #fff; }
        table.items th { padding: 8px 10px; font-size: 11px; text-align: left; }
        table.items th.r, table.items td.r { text-align: right; }
        table.items th.c, table.items td.c { text-align: center; }
        table.items td { padding: 7px 10px; border-bottom: 1px solid #eee; }
        table.items tr.total td { border-top: 2px solid #333; font-weight: 800; font-size: 14px; }

        .summary { display: flex; justify-content: flex-end; margin-top: 14px; }
        .summary table { width: 300px; border-collapse: collapse; }
        .summary td { padding: 6px 4px; }
        .summary td.k { color: #555; font-weight: 600; }
        .summary td.v { text-align: right; font-weight: 700; }
        .summary tr.grand td { border-top: 2px solid #333; font-size: 16px; font-weight: 900; padding-top: 10px; }
        .summary tr.balance td { color: #b91c1c; }

        .measure { margin-top: 18px; }
        .measure .chips { display: flex; flex-wrap: wrap; gap: 10px 22px; }
        .measure .chip small { color: #777; display: block; font-size: 10px; }
        .measure .chip b { font-size: 13px; }

        .notes {
            margin-top: 16px; padding: 10px 12px; background: #fff8e1;
            border-left: 4px solid #ffc107; font-size: 12px;
        }
        .foot {
            margin-top: 24px; border-top: 1px dashed #ccc; padding-top: 12px;
            text-align: center; color: #888; font-size: 11px;
        }
        .foot .thanks { color: #333; font-weight: 700; font-size: 13px; margin-bottom: 4px; }

        @media print {
            body { background: #fff; }
            .toolbar { display: none; }
            .bill { box-shadow: none; margin: 0; max-width: 100%; padding: 0; }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <a href="{{ route('orders.show', $order) }}" class="btn btn-back">&larr; Back</a>
        @if($hasPhone)
            <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="btn btn-wa">WhatsApp to Customer</a>
        @endif
        <button type="button" class="btn btn-print" onclick="window.print()">Print Bill</button>
    </div>

    <div class="bill">
        <div class="head">
            <div>
                <div class="shop-name">{{ $shopName }}</div>
                <div class="shop-meta">
                    @if($shopAddress){{ $shopAddress }}<br>@endif
                    @if($shopPhone)Phone: {{ $shopPhone }}@endif
                    @if($shopEmail) &nbsp;|&nbsp; Email: {{ $shopEmail }}@endif
                </div>
            </div>
            <div class="bill-tag">
                <div class="label">BILL</div>
                <div class="num">#{{ $order->order_number }}</div>
            </div>
        </div>

        <div class="grid2">
            <div>
                <div class="section-title">Customer Details</div>
                <table class="kv">
                    <tr><td class="k">Name:</td><td class="v">{{ $order->customer->name }}</td></tr>
                    <tr><td class="k">Phone:</td><td class="v">{{ $order->customer->phone }}</td></tr>
                    @if($order->customer->address)
                        <tr><td class="k">Address:</td><td class="v">{{ $order->customer->address }}</td></tr>
                    @endif
                </table>
            </div>
            <div>
                <div class="section-title">Order Details</div>
                <table class="kv">
                    <tr><td class="k">Order Date:</td><td class="v">{{ $order->order_date->format('d M, Y') }}</td></tr>
                    <tr>
                        <td class="k">Delivery Date:</td>
                        <td class="v">{{ $order->delivery_date ? $order->delivery_date->format('d M, Y') : '—' }}</td>
                    </tr>
                    <tr><td class="k">Status:</td><td class="v">{{ $order->status->name ?? '—' }}</td></tr>
                    @if($order->order_label)
                        <tr><td class="k">Label:</td><td class="v">{{ $order->order_label }}</td></tr>
                    @endif
                    @if($order->tailor)
                        <tr><td class="k">Tailor:</td><td class="v">{{ $order->tailor->name }}</td></tr>
                    @endif
                </table>
            </div>
        </div>

        <div class="section-title">Items</div>
        <table class="items">
            <thead>
                <tr>
                    <th>Color / Item</th>
                    <th class="c">Qty</th>
                    <th class="r">Stitching</th>
                    <th class="r">Buttons</th>
                    <th class="r">Other</th>
                    <th class="r">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->suits as $suit)
                    <tr>
                        <td>
                            {{ $suit->color }}
                            @if($suit->other_charge_note)
                                <br><small style="color:#888;">{{ $suit->other_charge_note }}</small>
                            @endif
                        </td>
                        <td class="c">{{ $suit->quantity }}</td>
                        <td class="r">{{ $fmt($suit->stitching_charge) }}</td>
                        <td class="r">{{ $fmt($suit->button_charge) }}</td>
                        <td class="r">{{ $fmt($suit->other_charge) }}</td>
                        <td class="r">{{ $fmt($suit->suit_total) }}</td>
                    </tr>
                @endforeach
                <tr class="total">
                    <td colspan="5" class="r">TOTAL ({{ $order->total_suits }} pcs)</td>
                    <td class="r">{{ $fmt($order->total_amount) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="summary">
            <table>
                <tr><td class="k">Subtotal</td><td class="v">{{ $fmt($order->total_amount) }}</td></tr>
                <tr><td class="k">Advance Paid</td><td class="v">{{ $fmt($order->advance_paid) }}</td></tr>
                <tr class="grand {{ $order->balance_due > 0 ? 'balance' : '' }}">
                    <td>Balance Due</td>
                    <td style="text-align:right;">{{ $fmt($order->balance_due) }}</td>
                </tr>
            </table>
        </div>

        @if($order->measurement)
            <div class="measure">
                <div class="section-title">Measurements</div>
                <div class="chips">
                    @php
                        $mFields = [
                            'length' => 'Length', 'shoulder' => 'Shoulder', 'chest' => 'Chest', 'waist' => 'Waist',
                            'hip' => 'Hip', 'sleeve' => 'Sleeve', 'collar' => 'Collar',
                            'trouser_length' => 'Trouser Length', 'trouser_waist' => 'Trouser Waist',
                            'thigh' => 'Thigh', 'bottom_opening' => 'Bottom Opening',
                        ];
                    @endphp
                    @foreach($mFields as $field => $label)
                        @if($order->measurement->$field !== null)
                            <div class="chip"><small>{{ $label }}</small><b>{{ $order->measurement->$field }}"</b></div>
                        @endif
                    @endforeach
                </div>
                @if($order->measurement->notes)
                    <div style="margin-top:8px;color:#555;"><b>Notes:</b> {{ $order->measurement->notes }}</div>
                @endif
            </div>
        @endif

        @if($order->notes)
            <div class="notes"><b>Order Notes:</b> {{ $order->notes }}</div>
        @endif

        <div class="foot">
            <div class="thanks">{{ $setting->receipt_footer ?? 'Thank you for your business!' }}</div>
            <div>{{ $shopName }} @if($shopPhone)• {{ $shopPhone }}@endif • Printed {{ now()->format('d M, Y h:i A') }}</div>
        </div>
    </div>

    @if(request()->query('autoprint'))
        <script>window.addEventListener('load', function () { window.print(); });</script>
    @endif
</body>
</html>
