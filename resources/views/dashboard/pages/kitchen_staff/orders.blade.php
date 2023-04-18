@section('title')
<title>Admin-Teacher</title>
@endsection
@extends('dashboard.app')
@section('main')
    <x-sidebar/>
    <div class="right_content">
        <x-navbar />
        <div class="heading">
            <h2 class="heading__title text-title">Food Items</h2>
            <a href="#open_menu_remodal" class="btn-sm btn-primary">Food Status</a>
        </div>
        <div class="order_table_wrapper order_table_wrapper--kitchen">
        @foreach ($tables as $table)
        @if ($table->orders->count() > 0)
        <div class="menu_wrapper menu_wrapper--kitchen bg-white" id="orders_wrapper" data-table-id="{{ $table->id }}">
            <div class="menu_title">
                <h2 class="menu_title_text">Table {{ $table->table_number }}</h2>
                <span class="font-poppins fs-12 text-warning" id="time-table-{{ $table->id }}" data-oldest-order-time="{{ $table->oldestOrder->created_at }}" >{{ $table->oldestOrder->created_at->diff(now())->format('%H:%I:%S') }}</span>
            </div>
            @php
                $ordersByCategory = $table->orders->groupBy('recipe.category');
            @endphp
            @foreach ($ordersByCategory as $category => $orders)
                {{-- <h3 class="menu_category_title">{{ $category }}</h3> --}}
                @foreach ($orders as $item)
                    <div class="item_wrapper border-bottom" style="padding: .8rem 0;">
                        <div class="item_left">
                            <div class="item_image">
                                <img src="{{ asset('dashboard/img/food/default.png') }}" class="item_image_sm" alt="food">
                            </div>
                            <div class="item_content">
                                <h3 class="item_title text-md-alt text">{{ $item->recipe->recipe_name }} <span class="text-sm-alt text-orange">x3</span></h3>
                                <h3 class="item_subtitle text-sm-alt op-6">{{ $item->recipe->price }} BDT</h3>
                            </div>
                        </div>
                        <div class="item_right">
                            <div class="btn-sm btn-info">Ready</div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
        @endif
        @endforeach
        </div>
    </div>

    {{-- <div class="modal remodal" data-remodal-id="open_menu_remodal">
        <div class="modal_heading">
            <h2 class="modal_title" id="edit_product">Edit Product</h2>
            <button data-remodal-action="close"><i class="fa-light fa-times"></i></button>
        </div>
        <div class="table_box">
            <div class="table-wrapper">
                <table class="w-100 data-table">
                    <thead>
                        <tr class="heading-row">
                            <th class="heading-column text-left">Product</th>
                            <th class="heading-column text-left">Availability</th>
                            <th class="heading-column"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recipes as $recipe)
                            <tr class="table-row">
                                <td class="table-column">
                                    <div class="table-column__wrapper">
                                        <div class="table-column__image">
                                            <img src="{{ asset('dashboard/img/food/default.png') }}" class="item_image item_image_sm" alt="">
                                        </div>
                                        <div class="table-column__content">
                                            <p class="table-column__subtitle pt-0">{{ $recipe->category }}</p>
                                            <h3 class="table-column__title table-column__product">{{ $recipe->recipe_name ?? '' }}</h3>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-column">
                                    <div class="table-column__wrapper">
                                        <div class="table-column__content" id="avaiability_status_indicator{{ $recipe->id }}">
                                            <p class="table-column__status"><i class="fa-solid fa-circle-small" style="{{ $recipe->is_available ? 'color: #43A047;' : 'color: #dc3545' }}"></i> {{ $recipe->is_available ? "Available" : "Not Available" }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-column">
                                    <div class="table-column__wrapper">
                                        <div class="table-column__content">
                                            <form class="switch" action="{{ route('kitchen_staff.recipe.toggle_availability') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value={{ $recipe->id }}>
                                                <input class="tgl tgl-ios" id="toggle_is_available{{ $recipe->id }}" name="is_available" type="checkbox" {{ $recipe->is_available ? 'checked' : '' }} onchange="toggleAvailability(this, {{ $recipe->id }})"/>
                                                <label class="tgl-btn" for="toggle_is_available{{ $recipe->id }}"></label>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}

@endsection

@section('exclusive_scripts')
<script>
    function toggleAvailability(element, recipe_id){
        let base_url = window.location.origin;
        axios.post(base_url + '/kitchen_staff/recipe/toggle_availability', {
            recipe_id: recipe_id,
        })
        .then(function (response) {
            data = response.data;
            if(data.is_available){
                document.getElementById('toggle_is_available' + recipe_id).checked = true;
                toastr.success(data.recipe_name+" is now available!");
                document.getElementById('avaiability_status_indicator' + recipe_id).innerHTML = `<p class="table-column__status"><i class="fa-solid fa-circle-small" style="color: #43A047;"></i> Available</p>`;
            }else{
                document.getElementById('toggle_is_available' + recipe_id).checked = false;
                toastr.warning(data.recipe_name+" is now unavailable!");
                document.getElementById('avaiability_status_indicator' + recipe_id).innerHTML = `<p class="table-column__status"><i class="fa-solid fa-circle-small" style="color: #dc3545;"></i> Not Available</p>`;
            }
        })
        .catch(function (error) {
            toastr.error("Something went wrong!");
        });
    }

    // define a function to update the time elapsed for a specific table
    function updateTime(tableId) {
        // get the element that contains the time elapsed
        var timeElement = document.getElementById('time-table-' + tableId);
        // get the current time and the time when the oldest order was created
        var now = new Date();
        var oldestOrderTime = new Date(timeElement.getAttribute('data-oldest-order-time'));
        // calculate the time elapsed
        var diff = now.getTime() - oldestOrderTime.getTime();
        var elapsed = new Date(diff);
        // subtract 6 hours from the hours value
        elapsed.setUTCHours(elapsed.getUTCHours() - 6);
        // format the time elapsed as a string
        var hours = elapsed.getUTCHours().toString().padStart(2, '0');
        var minutes = elapsed.getUTCMinutes().toString().padStart(2, '0');
        var seconds = elapsed.getUTCSeconds().toString().padStart(2, '0');
        var timeString = hours + ':' + minutes + ':' + seconds;
        // update the element with the new time elapsed
        timeElement.innerHTML = timeString;
    }

    // call the updateTime function for each table every second
    setInterval(function() {
        // loop through all the tables
        var tables = document.querySelectorAll('.menu_wrapper--kitchen');
        for (var i = 0; i < tables.length; i++) {
            var tableId = tables[i].getAttribute('data-table-id');
            updateTime(tableId);
        }
    }, 1000);
    // (function($){
    //     $(document).ready(function(){
    //         $('.data-table').DataTable({
    //             "processing": true,
    //             lengthMenu: [ [20, 10, 15, 25, 50], [20, 10, 15, 25, 50] ],
    //         });

    //         socket.on('orderResponseFromKitchen', function(data){
    //             console.log(data);
    //             toastr.warning("New Order Received!");
    //             $('#order_recieved_sound')[0].play();
    //         });

    //     });
    // })(jQuery);
    
</script>
@endsection

