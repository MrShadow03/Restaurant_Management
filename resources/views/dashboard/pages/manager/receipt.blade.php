@php
    $business_details = App\Models\BusinessInformation::first();

    function calculateCheckDigit($code) {
        $sum = 0;
        for ($i = 0; $i < 11; $i += 2) {
            $sum += $code[$i];
        }
        $sum *= 3;
        for ($i = 1; $i < 11; $i += 2) {
            $sum += $code[$i];
        }
        $remainder = $sum % 10;
        if ($remainder == 0) {
            return 0;
        } else {
            return 10 - $remainder;
        }
    }
@endphp
<!DOCTYPE html>
<html>

<head>
    <title>Receipt - {{ $invoice->invoice_number }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .receipt {
            border: 1px solid #ccc;
            padding: 10px;
            max-width: 300px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 18px;
        }

        .header h2 {
            font-size: 14px;
        }

        .details {
            margin-bottom: 10px;
        }

        .details table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .details table td {
            padding: 2px 0;
        }

        .details table td:first-child {
            padding-right: 10px;
            text-align: right;
        }

        .barcode {
            text-align: center;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dotted #ccc;
            display: flex;
            justify-content: center;
        }

        .barcode img {
            max-width: 100%;
            height: auto;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dotted #ccc;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .border-bottom {
            border-bottom: 1px solid #ccc;
        }

        .border-top {
            border-top: 1px solid #ccc;
        }

        .border-dark {
            border-color: #707070;
        }

        .mt-5 {
            margin-top: 5px;
        }

        .mb-5 {
            margin-bottom: 5px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .pt-5 {
            padding-top: 5px;
        }

        .pb-5 {
            padding-bottom: 5px;
        }

        .pt-10 {
            padding-top: 10px;
        }

        .pb-10 {
            padding-bottom: 10px;
        }

        .fs-12 {
            font-size: 12px;
        }

        .fs-13 {
            font-size: 13px;
        }

        .fs-14 {
            font-size: 14px;
        }

        .fs-16 {
            font-size: 16px;
        }
        .op-6 {
            opacity: 0.6;
        }
        .op-7 {
            opacity: 0.7;
        }
        .op-8 {
            opacity: 0.8;
        }
        .op-9 {
            opacity: 0.9;
        }
    </style>
</head>
@php
    $code = '97269256665';
    $checkDigit = calculateCheckDigit($code);
    $barcode = $code . $checkDigit;
@endphp
<body>
    <div class="receipt">
        <div class="header">
            <h1>{{ $business_details->name }}</h1>
            <p>{{ $business_details->address }}</p>
            <p>Phone: +88{{ $business_details->phone_number }}</p>
            @if ($business_details->email)
                <p>Email: {{ $business_details->email }}</p>
            @endif
        </div>
        <div class="info mb-10 mt-10">
            <table>
                <tr>
                    <td class="text-left">Date: {{ Carbon\Carbon::parse($invoice->created_at)->format('d.m.Y') }}</td>
                    <td class="text-right">Time: {{ Carbon\Carbon::parse($invoice->created_at)->format('h:i a') }}</td>
                </tr>
                <tr>
                    <td class="text-left pb-10">Table: {{ $invoice->table_number }}</td>
                    <td class="text-right pb-10">Served By: {{ $invoice->username }}</td>
                </tr>
                <tr>
                    <td class="text-center border-top border-bottom pt-5 pb-5 fs-14" colspan="2"><b>Invoice: {{ $invoice->invoice_number }}</b></td>
                </tr>
                <tr>
                    <td class="text-left pt-10">Customer: {{ $invoice->customer_name }}</td>
                    <td class="text-right pt-10">Contact: {{ $invoice->customer_contact }}</td>
                </tr>
            </table>
        </div>
        <div class="details">
            <table>
                <thead>
                    <tr>
                        <th colspan="2">Item</th>

                        <th>Price</th>
                        <th>Disc%</th>
                        <th>Qty</th>
                        <th class="text-right">Total(৳)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $index = 1;
                        $subTotal = 0;
                    @endphp
                    @foreach ($invoice->sales as $sale)
                    <tr>
                        <td>{{ $index }}</td>
                        <td>{{ $sale->recipe_name }}</td>

                        <td>{{ round($sale->price, 1) }}</td>
                        <td>{{ $sale->discount }}</td>
                        <td class="text-right">{{ $sale->quantity }}</td>
                        <td class="text-right">{{ round((($sale->price)-($sale->price*($sale->discount/100)))*$sale->quantity, 1) }}</td>
                    </tr>
                    @php
                        $subTotal += (($sale->price)-($sale->price*($sale->discount/100)))*$sale->quantity;
                        $index++
                    @endphp
                    @endforeach
                    @php
                        $discount = $subTotal*($invoice->discount/100);
                    @endphp
                    <tr class="border-top border-dark">
                        <td colspan="5">Sub Total</td>
                        <td class="text-right">{{ round($subTotal) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5">Discount {{ $invoice->discount ? "({$invoice->discount}%)" : '' }}</td>
                        <td class="text-right">{{ round($discount) }}</td>
                    </tr>
                    <tr class="border-top border-dark">
                        <td colspan="5">Grand total</td>
                        <td class="text-right">{{ $grandTotal = round($subTotal-$discount) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5">Paid</td>
                        <td class="text-right">{{ $invoice->paid }}</td>
                    </tr>
                    <tr class="border-top border-dark">
                        <td colspan="5">{{ $invoice->paid < $grandTotal ? 'Due' : 'Change'}}</td>
                        <td class="text-right">{{ abs($invoice->paid - $grandTotal) }}</td>
                    </tr>
            </table>
        </div>
        <div class="barcode">
            {!! DNS1D::getBarcodeHTML($invoice->invoice_number, 'UPCA'); !!}
        </div>
        <div class="footer">
            <p>Thank you for coming!</p>
            <p class="op-7 mt-5">This receipt is automatically generated by the Restaurant Management Software by PepploBD<sup>TM</sup></p>
        </div>
    </div>
</body>
</html>
