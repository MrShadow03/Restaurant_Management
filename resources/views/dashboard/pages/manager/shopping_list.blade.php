@php
    // dd($products);
@endphp
<!DOCTYPE html>
<html>

<head>
    <title>Shopping List</title>
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
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        button{
            text-align: center;
        }
        @media print {
            .print-hide {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h1>Shopping List</h1>
            <p>{{ $business_details->address }}</p>
            <p>Phone: +88{{ $business_details->phone_number }}</p>
            @if ($business_details->email)
                <p>Email: {{ $business_details->email }}</p>
            @endif
        </div>
        <div class="info mb-10 mt-10">
            <table>
                <tr>
                    <td class="text-left">Date: {{ date('d.m.Y') }}</td>
                    <td class="text-right">Time: {{ date('h:i a') }}</td>
                </tr>
                <tr>
                    <td class="text-right pb-10">Generated By: {{ Auth::user()->name }}</td>
                </tr>
            </table>
        </div>
        <div class="details">
            <table>
                <thead>
                    <tr>
                        <th colspan="2">Item</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $index = 1;
                        $subTotal = 0;
                    @endphp
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $index }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ round($product->unit_cost, 1) }}</td>
                    </tr>
                    @endforeach
                    {{-- <tr>
                        <td colspan="5">Paid</td>
                        <td class="text-right">{{ $invoice->paid }}</td>
                    </tr>
                    <tr class="border-top border-dark">
                        <td colspan="5">{{ $invoice->paid < $grandTotal ? 'Due' : 'Change'}}</td>
                        <td class="text-right">{{ abs($invoice->paid - $grandTotal) }}</td>
                    </tr> --}}
            </table>
        </div>
        <div class="footer">
            <p class="op-7 mt-5">This List is automatically generated by the Restaurant Management Software by PepploBD<sup>TM</sup></p>
        </div>
        <button class="btn-primary print-hide" onclick="window.print()">Print</button>
    </div>
</body>
</html>
