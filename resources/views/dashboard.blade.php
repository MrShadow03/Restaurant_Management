@section('title')
<title>Home | Manager</title>
@endsection
@extends('dashboard.app')
@section('main')
    <x-sidebar/>
    <div class="right_content" data-simplebar>
        <x-navbar />
        <div class="dashboard_card_wrapper">
            @php
                //calculate total sale and revenue of today and yesterday
                $todaysTotalSale = $sales->where('created_at', Carbon\Carbon::now()->format('Y-m-d'))->sum('total_discounted_price');
                $todaysTotalRevenue = $sales->where('created_at', Carbon\Carbon::now()->format('Y-m-d'))->sum('revenue');
                $yesterdaysTotalSale = $sales->where('created_at', Carbon\Carbon::now()->subDays(1)->format('Y-m-d'))->sum('total_discounted_price');
                $yesterdaysTotalRevenue = $sales->where('created_at', Carbon\Carbon::now()->subDays(1)->format('Y-m-d'))->sum('revenue');
                $hasTodaySalesDecreased = $todaysTotalSale < $yesterdaysTotalSale;
                $hasTodayRevenueDecreased = $todaysTotalRevenue < $yesterdaysTotalRevenue;
                $todaysNumberOfSales = abs($todaysTotalSale - $yesterdaysTotalSale);

                //calculate total sale and revenue of this week (starting from saturday)
                $thisWeeksTotalSale = $sales->where('created_at', '>=', Carbon\Carbon::now()->startOfWeek(Carbon\Carbon::SATURDAY)->format('Y-m-d'))->sum('total_discounted_price');
                $thisWeeksTotalRevenue = $sales->where('created_at', '>=', Carbon\Carbon::now()->startOfWeek(Carbon\Carbon::SATURDAY)->format('Y-m-d'))->sum('revenue');
                $lastWeeksTotalSale = $sales->whereBetween('created_at', [Carbon\Carbon::now()->startOfWeek(Carbon\Carbon::SATURDAY)->subDays(7)->format('Y-m-d'), Carbon\Carbon::now()->startOfWeek(Carbon\Carbon::SATURDAY)->subDays(1)->format('Y-m-d')])->sum('total_discounted_price');
                $lastWeeksTotalRevenue = $sales->whereBetween('created_at', [Carbon\Carbon::now()->startOfWeek(Carbon\Carbon::SATURDAY)->subDays(7)->format('Y-m-d'), Carbon\Carbon::now()->startOfWeek(Carbon\Carbon::SATURDAY)->subDays(1)->format('Y-m-d')])->sum('revenue');
                $hasThisWeekSalesDecreased = $thisWeeksTotalSale < $lastWeeksTotalSale;
                $hasThisWeekRevenueDecreased = $thisWeeksTotalRevenue < $lastWeeksTotalRevenue;
                $thisWeeksNumberOfSales = abs($thisWeeksTotalSale - $lastWeeksTotalSale);

                //calculate total sale and revenue of this month
                $thisMonthsTotalSale = $sales->where('created_at', '>=', Carbon\Carbon::now()->startOfMonth()->format('Y-m-d'))->sum('total_discounted_price');
                $thisMonthsTotalRevenue = $sales->where('created_at', '>=', Carbon\Carbon::now()->startOfMonth()->format('Y-m-d'))->sum('revenue');
                $lastMonthsTotalSale = $sales->whereBetween('created_at', [Carbon\Carbon::now()->startOfMonth()->subMonth()->format('Y-m-d'), Carbon\Carbon::now()->startOfMonth()->subDays(1)->format('Y-m-d')])->sum('total_discounted_price');
                $lastMonthsTotalRevenue = $sales->whereBetween('created_at', [Carbon\Carbon::now()->startOfMonth()->subMonth()->format('Y-m-d'), Carbon\Carbon::now()->startOfMonth()->subDays(1)->format('Y-m-d')])->sum('revenue');
                $hasThisMonthSalesDecreased = $thisMonthsTotalSale < $lastMonthsTotalSale;
                $hasThisMonthRevenueDecreased = $thisMonthsTotalRevenue < $lastMonthsTotalRevenue;
                $thisMonthsNumberOfSales = abs($thisMonthsTotalSale - $lastMonthsTotalSale);

                //calculate total sale and revenue of this year
                $thisYearsTotalSale = $sales->where('created_at', '>=', Carbon\Carbon::now()->startOfYear()->format('Y-m-d'))->sum('total_discounted_price');
                $thisYearsTotalRevenue = $sales->where('created_at', '>=', Carbon\Carbon::now()->startOfYear()->format('Y-m-d'))->sum('revenue');
                $lastYearsTotalSale = $sales->whereBetween('created_at', [Carbon\Carbon::now()->startOfYear()->subYear()->format('Y-m-d'), Carbon\Carbon::now()->startOfYear()->subDays(1)->format('Y-m-d')])->sum('total_discounted_price');
                $lastYearsTotalRevenue = $sales->whereBetween('created_at', [Carbon\Carbon::now()->startOfYear()->subYear()->format('Y-m-d'), Carbon\Carbon::now()->startOfYear()->subDays(1)->format('Y-m-d')])->sum('revenue');
                $hasThisYearSalesDecreased = $thisYearsTotalSale < $lastYearsTotalSale;
                $hasThisYearRevenueDecreased = $thisYearsTotalRevenue < $lastYearsTotalRevenue;
                $thisYearsNumberOfSales = abs($thisYearsTotalSale - $lastYearsTotalSale);

                //sum up the wasted cost
                $wastedCost = $waste->sum('cost');

            @endphp
            <div class="card">
                <div class="card__icon__wrapper bg-purple-light"><i class="card__icon fa-solid fa-coins text-purple"></i></div>
                <div class="card__details">
                    <h6 class="card__title">Today's Total Sell</h6>
                    <h6 class="card__data text-purple">{{ number_format($todaysTotalSale, 0, '.', ',') }} TK</h6>
                    {{-- <div class="badge badge-danger">
                        <i class="fs-12 fa-regular fa-arrow-up {{ $hasTodaySalesDecreased ? 'text-danger' : 'text-success' }}"></i>
                        <span class="fs-12 op-6">{{ $todaysNumberOfSales }}</span>
                    </div> --}}
                </div>
            </div>
            <div class="card">
                <div class="card__icon__wrapper bg-orange-light"><i class="card__icon fa-solid fa-stars text-orange"></i></div>
                <div class="card__details">
                    <h6 class="card__title">Today's Revenue</h6>
                    <h6 class="card__data text-orange">{{ number_format($todaysTotalRevenue, 0, '.', ',') }} TK</h6>
                </div>
            </div>
            <div class="card">
                <div class="card__icon__wrapper bg-info-light"><i class="card__icon fa-solid fa-coins text-info"></i></div>
                <div class="card__details">
                    <h6 class="card__title">This Week's Sell</h6>
                    <h6 class="card__data text-info">{{ number_format($thisWeeksTotalSale, 0, '.', ',') }} TK</h6>
                </div>
            </div>
            <div class="card">
                <div class="card__icon__wrapper bg-danger-light"><i class="card__icon fa-solid fa-trash-can text-danger"></i></div>
                <div class="card__details">
                    <h6 class="card__title">Total Waste</h6>
                    <h6 class="card__data text-danger">{{ number_format($wastedCost, 0, '.', ',') }} TK</h6>
                </div>
            </div>
        </div>
        <div class="dashboard_card_wrapper dashboard_card_wrapper--row2">
            <div class="card" data-simplebar>
                <div class="modal_heading">
                    <h2 class="modal_title text-primary op-8" id="edit_product"><i class="fa-solid fa-chart-mixed fs-16"></i> &nbsp; Top Selling Items</h2>
                </div>
                <div class="menu_wrapper">
                    @php
                        $index = 1;
                    @endphp
                    @foreach ($top_sales as $sale)
                    @php
                        $has_sales_decreased = $sale->current_week_sales < $sale->last_week_sales;
                        $number_of_sales = $sale->current_week_sales - $sale->last_week_sales;
                    @endphp
                    <div class="item_wrapper" style="padding: 1.5rem 0;">
                        <div class="item_left">
                            <div class="item_image">
                                <p class="badge-index badge-info 
                                @if($index === 1)
                                {{ 'gradient-purple text-white' }}
                                @elseif($index === 2)
                                {{ 'gradient-blue text-white' }}
                                @elseif($index === 3)
                                {{ 'gradient-green text-white' }}
                                @endif
                                ">{{ $index }}</p>
                            </div>
                            <div class="item_content">
                                <h3 class="text-md-alt text-primary op-9">{{ $sale->recipe_name }} <span title="Sale has {{ $has_sales_decreased ? 'decreased' : 'increased' }} by {{ abs($number_of_sales) }} compared to last week" class="fs-12 {{ $has_sales_decreased ? 'text-danger' : 'text-success' }}"><i class="fa-regular fa-circle-{{ $has_sales_decreased ? 'down' : 'up' }}"></i> {{ abs($number_of_sales) }}</span></h3>
                                <h3 title="Total {{ $sale->total_quantity }} items has been sold till now" class="item_subtitle text-sm-alt op-6">{{ $sale->total_quantity }} items sold</h3>
                            </div>
                        </div>
                        <div class="item_right">
                            <h3 class="item_subtitle text-sm-alt op-6">{{ round($sale->total_sale) }} BDT</h3>
                        </div>
                    </div>
                    @php
                        $index++;
                    @endphp
                    @endforeach
                </div>
            </div>
            <div class="card" data-simplebar>
                <div class="modal_heading">
                    <h2 class="modal_title text-primary op-8"><i class="fa-regular fa-messages-dollar fs-16"></i> &nbsp; Recent Purchases</h2>
                </div>
                <div class="menu_wrapper">
                    @foreach ($recent_purchases as $invoice)
                    <div title="Click to view the invoice" class="item_wrapper item_wrapper_hoverable" style="padding: 1.5rem 0;" onclick="openInvoice({{ $invoice->id }})">
                        <div class="item_left">
                            <div class="item_image">
                                <p class="badge-index badge-info"><i class="fa-solid fa-square-poll-horizontal"></i></p>
                            </div>
                            <div class="item_content">
                                <h3 class="text-md-alt op-9 {{ $invoice->customer_name === 'Guest' ? 'text-primary' : 'text-orange' }}">{{ $invoice->customer_name }}</h3>
                                <h3 class="item_subtitle item_subtitle--link text-sm-alt op-6">Invoice: {{ $invoice->invoice_number }}</h3>
                            </div>
                        </div>
                        <div class="item_right">
                            <h3 class="item_subtitle text-sm-alt op-6"><i class="fa-solid fa-bangladeshi-taka-sign fs-12"></i> {{ floor(($invoice->total)-($invoice->total*($invoice->discount/100))) }} BDT</h3>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="card" data-simplebar>
                <div class="modal_heading">
                    <h2 class="modal_title"><i class="fa-solid fa-fork-knife fs-16"></i> &nbsp; Todays Menu</h2>
                </div>
                <div class="menu_wrapper">
                    @foreach ($recipes as $recipe)
                    <div class="item_wrapper" style="padding: 1.5rem 0;">
                        <div class="item_left">
                            <div class="item_image">
                                <p id="food_availability_index{{ $recipe->id }}" class="badge-index {{ $recipe->on_menu ? 'badge-info' : 'badge-danger' }}"><i class="fa-solid fa-meat"></i></p>
                            </div>
                            <div class="item_content">
                                <h3 class="text-md-alt text-primary op-9">{{ $recipe->recipe_name }} <i id="food_availability_status{{ $recipe->id }}" class="fs-12 fa-solid {{ $recipe->on_menu ? 'fa-circle-check text-success' : 'fa-circle-xmark text-danger' }}"></i></h3>
                                <h3 class="item_subtitle text-sm-alt op-6 d-inline">{{ $recipe->price }} BDT 
                                </h3>
                                @if($recipe->discount > 0)
                                <span class="badge badge-warning"><i class="fa-solid fa-fire"></i>&nbsp; {{ $recipe->discount }}% off</span>
                                @endif
                            </div>
                        </div>
                        <div class="item_right">
                            <form class="switch" action="{{ route('manager.recipe.toggle_on_menu') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="id" value={{ $recipe->id }}>
                                <input class="tgl tgl-ios" id="toggle_on_menu{{ $recipe->id }}" name="on_menu" type="checkbox" {{ $recipe->on_menu ? 'checked' : '' }} onchange="toggleOnMenu(this, {{ $recipe->id }})"/>
                                <label title="Remove or include item on the menu" class="tgl-btn" for="toggle_on_menu{{ $recipe->id }}"></label>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="dashboard_card_wrapper">
            <div class="card">
                <div class="card__icon__wrapper bg-info-light"><i class="card__icon fa-solid fa-coins text-info"></i></div>
                <div class="card__details">
                    <h6 class="card__title">{{ date('F') }}'s Sell</h6>
                    <h6 class="card__data text-info">{{ number_format($thisMonthsTotalSale, 0, '.', ',') }} TK</h6>
                </div>
            </div>
            <div class="card">
                <div class="card__icon__wrapper bg-success-light"><i class="card__icon fa-solid fa-stars text-success"></i></div>
                <div class="card__details">
                    <h6 class="card__title">{{ date('F') }}'s Revenue</h6>
                    <h6 class="card__data text-success">{{ number_format($thisMonthsTotalRevenue, 0, '.', ',') }} TK</h6>
                </div>
            </div>
            <div class="card">
                <div class="card__icon__wrapper bg-pink-light"><i class="card__icon fa-solid fa-coins text-pink"></i></div>
                <div class="card__details">
                    <h6 class="card__title">{{ date('Y') }}'s Sell</h6>
                    <h6 class="card__data text-pink">{{ number_format($thisYearsTotalSale, 0, '.', ',') }} TK</h6>
                </div>
            </div>
            <div class="card">
                <div class="card__icon__wrapper bg-danger-light"><i class="card__icon fa-solid fa-stars text-danger"></i></div>
                <div class="card__details">
                    <h6 class="card__title">{{ date('Y') }}'s Revenue</h6>
                    <h6 class="card__data text-danger">{{ number_format($thisYearsTotalRevenue, 0, '.', ',') }} TK</h6>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('exclusive_scripts')
<script>
    function openInvoice(invoiceId){
        let base_url = window.location.origin;
        //open invoice in a new window popup
        var popup = window.open(base_url + '/manager/receipt/' + invoiceId, '_blank', 'width=400, height=800, top=100, left=100, resizable=yes, scrollbars=yes');
        popup.focus();
        //reset and play notification sound from start
        let audio = document.getElementById('payment_sound');
        audio.pause();
        audio.currentTime = 0;
        audio.play();
    }

    function toggleOnMenu(element, recipeId){
        let base_url = window.location.origin;
        axios.post(base_url + '/manager/recipe/toggleOnMenu', {
            id: recipeId,
        })
        .then(function (response) {
            data = response.data;
            console.log(data);
            if(data.onMenu){
                document.getElementById('toggle_on_menu' + recipeId).checked = true;
                toastr.success(data.recipeName+" is now available!");
                let foodStatus = document.getElementById('food_availability_status' + recipeId);
                let foodIndex = document.getElementById('food_availability_index' + recipeId);
                if(foodStatus){
                    foodStatus.classList.remove('fa-circle-xmark', 'text-danger');
                    foodStatus.classList.add('fa-circle-check', 'text-success');

                    foodIndex.classList.remove('badge-danger');
                    foodIndex.classList.add('badge-info');
                }
            }else{
                document.getElementById('toggle_on_menu' + recipeId).checked = false;
                toastr.warning(data.recipeName+" is now unavailable!");
                let foodStatus = document.getElementById('food_availability_status' + recipeId);
                let foodIndex = document.getElementById('food_availability_index' + recipeId);
                if(foodStatus){
                    foodStatus.classList.remove('fa-circle-check', 'text-success');
                    foodStatus.classList.add('fa-circle-xmark', 'text-danger');

                    foodIndex.classList.remove('badge-info');
                    foodIndex.classList.add('badge-danger');
                }
            }
        })
        .catch(function (error) {
            console.log(error);
            toastr.error("Something went wrong!");
        });
    }

    
</script>
@endsection