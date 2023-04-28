@section('title')
<title>Food Orders | Kitchen</title>
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
        <div class="menu_wrapper menu_wrapper--kitchen bg-white" data-table-id="{{ $table->id }}" id="table{{ $table->id }}">
            <div class="menu_title">
                <h2 class="menu_title_text">Table {{ $table->table_number }}</h2>
                <span class="font-poppins fs-12 text-warning" id="time-table-{{ $table->id }}" data-oldest-order-time="{{ $table->oldestOrder->created_at }}" >{{ $table->oldestOrder->created_at->diff(now())->format('%H:%I:%S') }}</span>
            </div>
            @php
                $ordersByCategory = $table->orders->groupBy('recipe.category');
            @endphp
            <div class="orders_wrapper" id="orders_wrapper{{ $table->id }}">
            @foreach ($ordersByCategory as $category => $orders)
                {{-- <h3 class="menu_category_title">{{ $category }}</h3> --}}
                @foreach ($orders as $order)
                    <div class="item_wrapper border-bottom" id="item{{ $table->id }}{{ $order->recipe->id }}" style="padding: .8rem 0;">
                        <div class="item_left">
                            <div class="item_image">
                                <img src="{{ asset('dashboard/img/food/default.png') }}" class="item_image_sm" alt="food">
                            </div>
                            <div class="item_content">
                                <h3 class="item_title text-md-alt text">{{ $order->recipe->recipe_name }} <span class="text-sm-alt fw-600 text-orange">x{{ $order->quantity }}</span></h3>
                                <h3 class="item_subtitle text-sm-alt op-6">{{ $order->recipe->price }} BDT</h3>
                            </div>
                        </div>
                        <div class="item_right">
                            @if ($order->status == 'cooking')
                            <button onclick="changeOrderStatus({{ $table->id }}, {{ $order->id }} , 'ready')" class="btn-sm btn-info">Ready</button>
                            @elseif ($order->status == 'ready')
                            <i class="fa-regular fa-check text-success fs-18" title="Food is Ready"></i>
                            <button onclick="changeOrderStatus({{ $table->id }}, {{ $order->id }} , 'cooking')" class="btn-icon btn-info ml-1"><i class="fa-regular fa-repeat"></i></button>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endforeach
            </div>
        </div>
        @endif
        @endforeach
        </div>
    </div>

    <audio controls class="d-none" id="notification1" src="{{ asset('dashboard/audio/notification1.mp3') }}"></audio>
    <audio controls class="d-none" id="notification2" src="{{ asset('dashboard/audio/notification2.mp3') }}"></audio>

    <div class="modal remodal" data-remodal-id="open_menu_remodal">
        <div class="modal_heading">
            <h2 class="modal_title" id="edit_product">Menu Status</h2>
            <button data-remodal-action="close"><i class="fa-light fa-times"></i></button>
        </div>
        <div class="menu_wrapper">
            @foreach ($recipes->unique('category') as $category)
            @foreach ($recipes->where('category', $category->category) as $recipe)
            @if ($loop->first)
            <h3 class="menu_category_title">{{ $category->category }}</h3>
            @endif
            <div class="item_wrapper border-bottom" style="padding: .8rem 0;">
                <div class="item_left">
                    <div class="item_image">
                        <img src="{{ asset('dashboard/img/food/default.png') }}" class="item_image_sm" alt="food">
                    </div>
                    <div class="item_content">
                        <h3 class="item_title text-md-alt text">{{ $recipe->recipe_name }} <span id="food_availability_status{{ $recipe->id }}" class="badge badge-success">Available</span></h3>
                        <h3 class="item_subtitle text-sm-alt op-6">{{ $recipe->price }} BDT</h3>
                    </div>
                </div>
                <div class="item_right">
                    <form class="switch" action="{{ route('kitchen_staff.recipe.toggle_availability') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value={{ $recipe->id }}>
                        <input class="tgl tgl-ios" id="toggle_is_available{{ $recipe->id }}" name="is_available" type="checkbox" {{ $recipe->is_available ? 'checked' : '' }} onchange="toggleAvailability(this, {{ $recipe->id }})"/>
                        <label class="tgl-btn" for="toggle_is_available{{ $recipe->id }}"></label>
                    </form>
                </div>
            </div>
            @endforeach
            @endforeach
        </div>
    </div>

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
                document.getElementById('food_availability_status' + recipe_id).classList.remove('badge-danger');
                document.getElementById('food_availability_status' + recipe_id).classList.add('badge-success');
                document.getElementById('food_availability_status' + recipe_id).innerText = `Available`;
            }else{
                document.getElementById('toggle_is_available' + recipe_id).checked = false;
                toastr.warning(data.recipe_name+" is now unavailable!");
                document.getElementById('food_availability_status' + recipe_id).classList.remove('badge-success');
                document.getElementById('food_availability_status' + recipe_id).classList.add('badge-danger');
                document.getElementById('food_availability_status' + recipe_id).innerText = `Not Available`;
            }
        })
        .catch(function (error) {
            console.log(error);
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

        // adjust the elapsed time to the timezone of Dhaka
        elapsed.toLocaleString('en-US', { timeZone: 'Asia/Dhaka' });
        // format the time elapsed as a string
        var hours = elapsed.getUTCHours().toString().padStart(2, '0');
        var minutes = elapsed.getUTCMinutes().toString().padStart(2, '0');
        var seconds = elapsed.getUTCSeconds().toString().padStart(2, '0');
        var timeString = hours + ':' + minutes + ':' + seconds;
        // update the element with the new time elapsed
        timeElement.innerHTML = timeString;
    }
    //recive order from stuff
    socket.on('orderFromStuff', function(data){
        //get the orders for the table
        //with promise to wait for the orders to be added
        console.log(data);
        getOrders(data.order.table_id).then(function(){
            //play sound
            var audio1 = document.getElementById("notification1");
            var audio2 = document.getElementById("notification2");

            if(data.type == 'add'){
                audio1.currentTime = 0;
                audio1.play();
            }else{
                audio2.currentTime = 0;
                audio2.play();
            }

            //add bounce animation class
            let item = document.getElementById('item'+data.order.table_id+data.order.recipe_id);

            console.log('item'+data.order.table_id+data.order.recipe_id);

            if(item){
                item.classList.add('color_bounce');
                setTimeout(function(){
                    item.classList.remove('color_bounce');
                }, 1000);
            }
        })
    })
    socket.on('paymentDoneResponse', function(table_id){
        let table = document.getElementById('table'+table_id);
        if(table){
            table.remove();
        }
    });
    function getOrders(table_id){
        return new Promise((resolve, reject) => {
            //get the base url
            let base_url = window.location.origin;
    
            //get the orders for the table
            axios.get(base_url+`/kitchen_staff/api/getOrders/${table_id}`).
            then(function(response){
    
                let orders = response.data.orders;
    
                //get the table
                let table = document.getElementById('table'+table_id);
    
                //if table exists and ordercount is 0, remove table
                if(table && orders.length == 0){
                    table.remove();
                    return;
                }
                
                //if table doesn't exist, create it
                if(table == null){
                    createTable(table_id,response.data);
                }
    
                //set the time elapsed
                var timeElement = document.getElementById('time-table-' + table_id);
                timeElement && timeElement.setAttribute('data-oldest-order-time', response.data.oldestOrderTime);
    
                //clear orders wrapper
                let orders_wrapper = document.querySelector('#orders_wrapper'+table_id);
                if(orders_wrapper){
                    orders_wrapper.innerHTML = '';
                }
    
                html = '';
                //get unique categories
                var uniqueCategories = [...new Set(orders.map(item => item.category))];
    
                //create the orders
                uniqueCategories.forEach(function(category) {
                    var items = orders.filter(function(item) {
                        return item.category === category;
                    });
    
                    items.forEach(function(item, index) {
                        // if (index === 0) {
                        //     html += '<h3 class="menu_category_title">' + category + '</h3>';
                        // }
                        html += `<div class="item_wrapper border-bottom" id="item${table_id}${item.recipe_id}" style="padding: .8rem 0;">`;
                        html += '<div class="item_left">';
                        html += '<div class="item_image">';
                        html += `<img src="{{ asset('dashboard/img/food/default.png') }}" class="item_image_sm" alt="">`;
                        html += '</div>';
                        html += '<div class="item_content">';
                        html += '<h3 class="item_title text-md-alt text">' + item.recipe_name + ' <span class="text-sm-alt fw-600 text-orange">x' + item.quantity + '</span></h3>';
                        html += '<h3 class="item_subtitle text-sm-alt op-6">' + item.price + ' BDT</h3>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="item_right">';
    
                        if(item.status == 'cooking'){
                            html += `<button class="btn-sm btn-info" onclick="changeOrderStatus(${table_id}, ${item.id}, 'ready')">Ready</button>`;
                        }else if(item.status == 'ready'){
                            html += `<i class="fa-regular fa-check text-success fs-18" title="Food is Ready"></i>`;
                            html += `<button class="btn-icon btn-info ml-1" onclick="changeOrderStatus(${table_id}, ${item.id}, 'cooking')"><i class="fa-regular fa-repeat"></i></button>`;
                        }
    
                        // let buttonClass = item.orderCount > 0 ? 'btn-sm btn-success' : 'btn-sm';
                        // let buttonText = item.orderCount > 0 ? 'Ordered' : 'Order';
                        html += '</div>';
                        html += '</div>';
                    });
                });
    
                //append the menu
                orders_wrapper.innerHTML = html;

                resolve(true);
            }).catch(function(error){
                console.log(error);
            });
        });
    }

    function createTable(table_id, data){
        let table = document.createElement('div');
        table.setAttribute('class', 'menu_wrapper menu_wrapper--kitchen bg-white');
        table.setAttribute('id', 'table'+table_id);
        table.setAttribute('data-table-id', table_id);

        let table_header = document.createElement('div');
        table_header.setAttribute('class', 'menu_title');

        let table_title_text = document.createElement('h2');
        table_title_text.setAttribute('class', 'menu_title_text');
        table_title_text.innerHTML = 'Table '+data.tableNumber;

        let table_time = document.createElement('span');
        table_time.setAttribute('class', 'font-poppins fs-12 text-warning');
        table_time.setAttribute('id', 'time-table-'+table_id);
        table_time.setAttribute('data-oldest-order-time', data.oldestOrderTime);
        table_time.innerHTML = '00:00:00';

        table_header.appendChild(table_title_text);
        table_header.appendChild(table_time);

        let orders_wrapper = document.createElement('div');
        orders_wrapper.setAttribute('class', 'orders_wrapper');
        orders_wrapper.setAttribute('id', 'orders_wrapper'+table_id);

        table.appendChild(table_header);
        table.appendChild(orders_wrapper);

        let table_wrapper = document.querySelector('.order_table_wrapper--kitchen');

        table_wrapper.appendChild(table);
    }
    //change order status
    function changeOrderStatus(table_id, order_id, status){
        let base_url = window.location.origin;
        axios.post(base_url+`/kitchen_staff/change_status`, {
            order_id: order_id,
            status: status
        }).
        then(function(response){
            //get the orders for the table
            getOrders(table_id)

            //emit the order status change
            socket.emit('responseToStaff', response.data);

        }).catch(function(error){
            console.log(error);
        });
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
    
    
</script>
@endsection

