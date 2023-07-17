@section('title')
    @if ($report_type == 'daily')
        <title>Daily Product Report - {{ isset($date) ? $date : date('M d, Y') }}</title>
    @elseif ($report_type == 'monthly')
        <title>Monthly Product Report -
            {{ isset($month) ? Carbon\Carbon::createFromFormat('m', $month)->monthName : date('F, Y') }}</title>
    @elseif ($report_type == 'yearly')
        <title>Yearly Product Report - {{ isset($year) ? $year : date('Y') }}</title>
    @endif
@endsection
@extends('dashboard.app')
@section('exclusive_styles')
    <link rel="stylesheet" href="{{ asset('dashboard/vendors/css/dt-buttons.min.css') }}">
    <style>
        .filter__input {
            border: 1px solid #616970;
            border-radius: 5px;
            padding: 8px 18px;
            font-size: 14px;
            font-family: "Roboto", sans-serif;
            outline: none;
            margin-right: 10px;
        }

        .btn-group .btn-group-button {
            background-color: #6c757d;
            border: 1px solid #616970;
            color: white;
            padding: 8px 18px;
            cursor: pointer;
            float: left;
            font-size: 14px;
            font-family: "Roboto", sans-serif;
            outline: none;
        }

        /* Clear floats (clearfix hack) */
        .btn-group:after {
            content: "";
            clear: both;
            display: table;
        }

        .btn-group .btn-group-button:not(:last-child) {
            border-right: none;
            /* Prevent double borders */
        }

        /* Add border radius to first and last button */
        .btn-group .btn-group-button:first-child {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .btn-group .btn-group-button:last-child {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        /* Add a background color on hover */
        .btn-group .btn-group-button:hover {
            background-color: #343a40;
        }

        .btn-group .btn-group-button:focus {
            background-color: #343a40;
            border-color: #343a40;
            /* background-color: #2196f3;
                border-color: #2196f3; */
        }

        .btn-group .active {
            background-color: #343a40;
            border-color: #343a40;
        }
    </style>
@endsection
@section('main')
    <x-sidebar />
    <div class="right_content" data-simplebar>
        <x-navbar />
        <div class="heading">
            <h2 class="heading__title text-title">Sales Details</h2>
            <div class="heading__left d-flex">
                <div class="form d-flex" style="width:100%">
                    @if ($report_type == 'daily')
                        <input type="date" name="daily_input" id="daily_input" class="filter__input filter__input--daily"
                            value="{{ isset($date) ? $date : date('Y-m-d') }}"
                            onchange="submitQuery(this.value, '{{ $report_type }}')">
                    @elseif ($report_type == 'monthly')
                        <select name="monthly_input" id="monthly_input" class="filter__input filter__input--monthly"
                            onchange="submitQuery(this.value, '{{ $report_type }}')">
                            <option value="01" {{ isset($month) && $month == '01' ? 'selected' : '' }}>January</option>
                            <option value="02" {{ isset($month) && $month == '02' ? 'selected' : '' }}>Febuary</option>
                            <option value="03" {{ isset($month) && $month == '03' ? 'selected' : '' }}>March</option>
                            <option value="04" {{ isset($month) && $month == '04' ? 'selected' : '' }}>April</option>
                            <option value="05" {{ isset($month) && $month == '05' ? 'selected' : '' }}>May</option>
                            <option value="06" {{ isset($month) && $month == '06' ? 'selected' : '' }}>June</option>
                            <option value="07" {{ isset($month) && $month == '07' ? 'selected' : '' }}>July</option>
                            <option value="08" {{ isset($month) && $month == '08' ? 'selected' : '' }}>August</option>
                            <option value="09" {{ isset($month) && $month == '09' ? 'selected' : '' }}>September
                            </option>
                            <option value="10" {{ isset($month) && $month == '10' ? 'selected' : '' }}>October</option>
                            <option value="11" {{ isset($month) && $month == '11' ? 'selected' : '' }}>November
                            </option>
                            <option value="12" {{ isset($month) && $month == '12' ? 'selected' : '' }}>December
                            </option>
                        </select>
                    @elseif ($report_type == 'yearly')
                        <select name="yearly_input" id="yearly_input" class="filter__input filter__input--yearly"
                            onchange="submitQuery(this.value, '{{ $report_type }}')">
                            @for ($i = date('Y'); $i >= 2010; $i--)
                                <option value="{{ $i }}" {{ isset($year) && $year == $i ? 'selected' : '' }}>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    @endif
                </div>
                <div class="btn-group" style="width:100%">
                    <a class="btn-group-button text-center {{ $report_type == 'daily' ? 'active' : '' }}"
                        href="?report_type=daily">Daily</a>
                    <a class="btn-group-button text-center {{ $report_type == 'monthly' ? 'active' : '' }}"
                        href="?report_type=monthly">Monthly</a>
                    <a class="btn-group-button text-center {{ $report_type == 'yearly' ? 'active' : '' }}"
                        href="?report_type=yearly">Yearly</a>
                </div>
            </div>
        </div>
        <div>
            {{-- {{ dd($sales[0]) }} --}}
            <div class="table_box">
                <div class="table-wrapper">
                    <table class="w-100 data-table">
                        <thead>
                            <tr class="heading-row">
                                <th class="heading-column">Index</th>
                                <th class="heading-column">Product</th>
                                <th class="heading-column">Activity</th>
                                <th class="heading-column">Quantity</th>
                                <th class="heading-column">Cost</th>
                                <th class="heading-column">Used For</th>
                                <th class="heading-column">Done By</th>
                                <th class="heading-column">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $index = 1;
                                $total_sale = 0;
                                $total_waste = 0;
                            @endphp
                            @foreach ($reports as $report)
                            <tr class="table-row">
                                <td class="table-column">
                                    <div class="table-column__wrapper">
                                        <div class="table-column__content">
                                            <h3 class="table-column__title">{{ $index }}</h3>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-column">
                                    <div class="table-column__wrapper">
                                        <div class="table-column__content">
                                            <h3 class="table-column__title">{{ $report->product_name }}</h3>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-column">
                                    <div class="table-column__wrapper">
                                        <div class="table-column__content">
                                            <h3 class="table-column__title"><span class="badge {!! $report->activity === 'added' ? 'badge-success' : 'badge-danger' !!}">{{ ucfirst($report->activity) }}</span></h3>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-column">
                                    <div class="table-column__wrapper">
                                        <div class="table-column__content">
                                            <h3 class="table-column__title">{{ $report->quantity }} {{ $report->measurement_unit }}</h3>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-column">
                                    <div class="table-column__wrapper">
                                        <div class="table-column__content">
                                            <h3 class="table-column__title">{{ round($report->cost) }} TK</h3>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-column">
                                    <div class="table-column__wrapper">
                                        <div class="table-column__content">
                                            <h3 class="table-column__title">{{ $report->recipe_name }}</h3>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-column">
                                    <div class="table-column__wrapper">
                                        <div class="table-column__content">
                                            <h3 class="table-column__title {{ $report->done_manually ? 'text-orange' : '' }}">{{ $report->done_manually ? $report->done_manually : 'Software' }}</h3>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-column">
                                    <div class="table-column__wrapper">
                                        <div class="table-column__content">
                                            <h3 data-sort="{{ Carbon\Carbon::parse($report->created_at)->format('Y-m-d') }}"
                                                class="table-column__title">
                                                {{ Carbon\Carbon::parse($report->created_at)->format('M d, Y') }}</h3>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                                @php
                                    $index++;
                                    // $total_sale += $recipe->total_sale;
                                    // $total_waste += $recipe->total_waste;
                                @endphp
                            @endforeach
                            @php
                                $total = 0;
                                // foreach ($sales as $sale) {
                                //     $total += $sale->price * $sale->quantity;
                                // }
                            @endphp
                            {{-- <tr>
                                <td class="table-column">__</td>
                                <td class="table-column">
                                    <div class="table-column__wrapper">
                                        <div class="table-column__content">
                                            <h3 class="table-column__title text-orange fs-16 fw-600">Total</h3>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-column">
                                    <div class="table-column__wrapper">
                                        <div class="table-column__content">
                                            <h3 class="table-column__title text-orange fs-16 fw-600">{{ $total_sale }} TK</h3>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-column">
                                </td>
                                <td class="table-column">
                                    <div class="table-column__wrapper">
                                        <div class="table-column__content">
                                            <h3 class="table-column__title text-orange fs-16 fw-600">{{ $total_waste }} TK</h3>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-column"></td>
                                <td class="table-column"></td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('exclusive_scripts')
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script>
        (function($) {
            $(document).ready(function() {
                $('.data-table').DataTable({
                    "processing": true,
                    lengthMenu: [
                        [20, 10, 15, 25, 50],
                        [20, 10, 15, 25, 50]
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            });
        })(jQuery);

        function submitQuery(value, type) {
            if (type == "daily") {
                window.location.href = "?report_type=" + type + "&date=" + value;
            } else if (type == "monthly") {
                window.location.href = "?report_type=" + type + "&month=" + value;
            } else if (type == "yearly") {
                window.location.href = "?report_type=" + type + "&year=" + value;
            }
        }
    </script>
@endsection
