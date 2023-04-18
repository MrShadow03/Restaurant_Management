@php
    function addLeadingZero($number){
        return $number < 10 ? '0'.$number : $number;
    }
    //get the max table number
    $max_table_number = $tables->max('table_number')+1;
@endphp
@section('title')
<title>Admin-Teacher</title>
@endsection
@extends('dashboard.app')
@section('main')
    <x-sidebar/>
    <div class="right_content">
        <x-navbar />
        <div class="heading">
            <h2 class="heading__title text-title">Table Management</h2>
        </div>
        <div>
            <div class="order_table_wrapper">
                @foreach ($tables as $table)
                <div class="order_table">
                    <div class="order_table_title">{{ addLeadingZero($table->table_number) }}</div>
                    <div class="order_table_top">
                        <div class="order_table_top_left">
                            <div class="status_indicator" id="status_indicator{{ $table->id }}">
                                @if ($table->status == 'free')
                                <i class="text-yellow fa-solid fa-circle"></i>
                                <span>Free</span>
                                @else
                                <i class="text-success fa-solid fa-circle"></i>
                                <span>Occupied</span>
                                @endif
                            </div>
                        </div>
                        <div class="order_table_top_right">
                        </div>
                    </div>
                    <div class="order_middle">
                    </div>
                    <div class="order_table_bottom">
                        <div class="oreder_table_bottom_left">
                            <a href="#ordering_menu" class="btn-sm btn-primary" onclick="getMenu({{ json_encode($table) }})">Take Order</a>
                        </div>
                        <div class="oreder_table_bottom_right">
                            <a href="#ordered_menu" id="ordered_menu_button{{ $table->id }}" class="{{ $table->status == 'free' ? 'd-none' : '' }} btn-sm btn-info" onclick="getOrders({{ json_encode($table) }})">View Orders</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="modal remodal" data-remodal-id="ordering_menu" id="ordering_remodal">
        <div class="modal_heading">
            <h2 class="modal_title" id="modal_title">Table-{{ $tables[0]->table_number }} Order</h2>
            <button data-remodal-action="close"><i class="fa-light fa-times"></i></button>
            <input type="hidden" name="table_id" id="table_id" value="{{ $tables[0]->id }}">
        </div>
        <div class="menu_wrapper">
            @foreach ($menu->unique('category') as $category)
            @foreach ($menu->where('category', $category->category) as $item)
            @if ($loop->first)
            <h3 class="menu_category_title">{{ $category->category }}</h3>
            @endif
            <div class="item_wrapper item_wrapper-stripes">
                <div class="item_left">
                    <div class="item_image">
                        <img src="{{ asset('dashboard/img/food/default.png') }}" class="item_image item_image_md" alt="">
                    </div>
                    <div class="item_content">
                        <h3 class="item_title text-md-alt text">{{ $item->recipe_name }}</h3>
                        <h3 class="item_subtitle text-sm-alt op-6">{{ $item->price }} BDT</h3>
                        <div class="menu_quantity_wrapper">
                            <button onclick="decQuantity({{ $item->id }})" class="menu_quantity_btn"><i class="fa-light fa-minus"></i></button>
                            <input type="text" class="menu_quantity_input op-5" id="menu_quantity_input{{ $item->id }}" value="0" readonly>
                            <button onclick="incQuantity({{ $item->id }})" class="menu_quantity_btn"><i class="fa-light fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="item_right">
                    <button class="btn-sm" onclick="placeOrder({{ $item->id }})" id="order_button{{ $item->id }}">Order</button>
                </div>
            </div>
            @endforeach
            @endforeach
        </div>
    </div>

    <div class="modal remodal pb-1" data-remodal-id="ordered_menu" id="orders_remodal">
        <div class="modal_heading">
            <h2 class="modal_title" id="orders_modal_title">Table-{{ $tables[0]->table_number }} Order</h2>
            <button data-remodal-action="close"><i class="fa-light fa-times"></i></button>
            <input type="hidden" name="table_id" id="table_id" value="{{ $tables[0]->id }}">
        </div>
        <div class="menu_wrapper" id="orders_wrapper">
            @foreach ($menu->unique('category') as $category)
            @foreach ($menu->where('category', $category->category) as $item)
            @if ($loop->first)
            <h3 class="menu_category_title">{{ $category->category }}</h3>
            @endif
            <div class="item_wrapper border-bottom" style="padding: .8rem 0;">
                <div class="item_left">
                    <div class="item_image">
                        <img src="{{ asset('dashboard/img/food/default.png') }}" class="item_image_sm" alt="food">
                    </div>
                    <div class="item_content">
                        <h3 class="item_title text-md-alt text">{{ $item->recipe_name }}</h3>
                        <h3 class="item_subtitle text-sm-alt op-6">{{ $item->price }} BDT</h3>
                    </div>
                </div>
                <div class="item_right">
                    <span class="badge badge-info">x3</span>
                </div>
            </div>
            @endforeach
            @endforeach
        </div>
    </div>
@endsection

@section('exclusive_scripts')
<script>
    let base_url = window.location.origin;
    
    function getMenu( table ){
        //set table id and title
        document.getElementById('table_id').value = table.id;
        document.getElementById('modal_title').innerHTML = 'Table-'+table.table_number+' Order';

        //get menu
        axios.get(base_url+'/staff/api/getMenu/'+table.id)
        .then(function(response){
            //data
            let menu = response.data;
            //clear menu wrapper
            let menu_wrapper = document.querySelector('.menu_wrapper');
            menu_wrapper.innerHTML = '';

            html = '';
            //get unique categories
            var uniqueCategories = [...new Set(menu.map(item => item.category))];
            //create the menu
            uniqueCategories.forEach(function(category) {
                var items = menu.filter(function(item) {
                    return item.category === category;
                });

                items.forEach(function(item, index) {
                    if (index === 0) {
                        html += '<h3 class="menu_category_title">' + category + '</h3>';
                    }

                    html += '<div class="item_wrapper">';
                    html += '<div class="item_left">';
                    html += '<div class="item_image">';
                    html += `<img src="{{ asset('dashboard/img/food/default.png') }}" class="item_image item_image_md" alt="">`;
                    html += '</div>';
                    html += '<div class="item_content">';
                    html += '<h3 class="item_title text-md-alt text">' + item.recipe_name + '</h3>';
                    html += '<h3 class="item_subtitle text-sm-alt op-6">' + item.price + ' BDT</h3>';
                    html += '<div class="menu_quantity_wrapper">';
                    html += '<button onclick="decQuantity(' + item.id + ')" class="menu_quantity_btn"><i class="fa-light fa-minus"></i></button>';

                    let classList = item.orderCount > 0 ? 'menu_quantity_input text-orange' : 'menu_quantity_input op-5';
                    html += `<input type="text" class="${classList}" id="menu_quantity_input${item.id}" value="${item.orderCount}" readonly>`;

                    html += '<button onclick="incQuantity(' + item.id + ')" class="menu_quantity_btn"><i class="fa-light fa-plus"></i></button>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="item_right">';

                    let buttonClass = item.orderCount > 0 ? 'btn-sm btn-success' : 'btn-sm';
                    let buttonText = item.orderCount > 0 ? 'Ordered' : 'Order';
                    html += `<button class="${buttonClass}" onclick="placeOrder(${item.id})" id="order_button${item.id}">${buttonText}</button>`;
                    html += '</div>';
                    html += '</div>';
                });
            });

            //append the menu
            menu_wrapper.innerHTML = html;

        }).catch(function(error){
            console.log(error);
        });
    }

    function placeOrder(recipe_id){
        let table_id = document.getElementById('table_id').value;
        let quantity = document.getElementById('menu_quantity_input'+recipe_id).value;

        axios.post(base_url+`/staff/api/storeOrder`, {
            table_id: table_id,
            recipe_id: recipe_id,
            quantity: quantity
        }).then(function(response){
            let data = response.data;
            console.log(data);
            
            //if the order is deleted then show toastr warning
            if(data.message == 'deleted'){
                document.getElementById('order_button'+data.recipe_id).classList.remove('btn-danger');
                document.getElementById('order_button'+data.recipe_id).innerHTML = 'Order';
                toastr.warning('Order deleted');

                updateTableStatus(response.data.table_id);
                return;
            }
            if(data.message == 'empty'){
                document.getElementById('order_button'+data.recipe_id).classList.remove('btn-danger');
                document.getElementById('order_button'+data.recipe_id).innerHTML = 'Order';
                toastr.warning('Choose a quantity');
                return;
            }

            //if the oreder is placed then update the button
            let button = document.getElementById('order_button'+response.data.recipe_id);
            button.innerHTML = 'Ordered';
            button.classList.add('btn-success');

            updateTableStatus(response.data.table_id);

        }).catch(function(error){
            console.log(error);
        });
    }

    function getOrders(table){
        document.getElementById('orders_modal_title').innerHTML = 'Table-'+table.table_number+' Order';

        axios.get(base_url+`/staff/api/getOrders/${table.id}`).
        then(function(response){
            //data
            let orders = response.data.orders;
            //clear orders wrapper
            let orders_wrapper = document.querySelector('#orders_wrapper');
            orders_wrapper.innerHTML = '';

            html = '';
            //get unique categories
            var uniqueCategories = [...new Set(orders.map(item => item.category))];

            console.log(uniqueCategories);
            //create the orders
            uniqueCategories.forEach(function(category) {
                var items = orders.filter(function(item) {
                    return item.category === category;
                });

                items.forEach(function(item, index) {
                    if (index === 0) {
                        html += '<h3 class="menu_category_title">' + category + '</h3>';
                    }

                    html += '<div class="item_wrapper border-bottom" style="padding: .8rem 0;">';
                    html += '<div class="item_left">';
                    html += '<div class="item_image">';
                    html += `<img src="{{ asset('dashboard/img/food/default.png') }}" class="item_image_sm" alt="">`;
                    html += '</div>';
                    html += '<div class="item_content">';
                    html += '<span class="item_title text-md-alt text">' + item.recipe_name + ' </span>';
                    html += '<h3 class="item_subtitle text-sm-alt op-6">' + item.price + ' BDT</h3>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="item_right">';

                    let buttonClass = item.orderCount > 0 ? 'btn-sm btn-success' : 'btn-sm';
                    let buttonText = item.orderCount > 0 ? 'Ordered' : 'Order';
                    html += '<span class="mr-1 text-sm-alt text-primary fw-600">x' + item.quantity + '</span>';
                    html += '</div>';
                    html += '</div>';
                });
            });

            //append the menu
            orders_wrapper.innerHTML = html;
        }).catch(function(error){
            console.log(error);
        });
    }
    
    function incQuantity( id ){
        let quantity = document.getElementById('menu_quantity_input'+id).value;
        quantity = parseInt(quantity)+1;
        document.getElementById('order_button'+id).classList.remove('btn-success');
        document.getElementById('order_button'+id).classList.remove('btn-danger');
        document.getElementById('menu_quantity_input'+id).value = quantity;
        document.getElementById('order_button'+id).classList.add('btn-primary');
        document.getElementById('order_button'+id).innerHTML = 'Order';
        document.getElementById('menu_quantity_input'+id).classList.add('text-orange');
        document.getElementById('menu_quantity_input'+id).classList.remove('op-5');
        
    }
    
    function decQuantity( id ){
        let quantity = document.getElementById('menu_quantity_input'+id).value;
        document.getElementById('order_button'+id).classList.remove('btn-success');
        document.getElementById('order_button'+id).innerHTML = 'Order';
        document.getElementById('order_button'+id).classList.add('btn-primary');
        
        quantity = parseInt(quantity)-1;
        if( quantity < 0 ){
            quantity = 0;
        }

        document.getElementById('menu_quantity_input'+id).value = quantity;

        if( quantity == 0 ){
            document.getElementById('order_button'+id).classList.remove('btn-primary');
            document.getElementById('order_button'+id).classList.add('btn-danger');
            document.getElementById('order_button'+id).innerText = 'Remove';
            document.getElementById('menu_quantity_input'+id).classList.remove('text-orange');
            document.getElementById('menu_quantity_input'+id).classList.add('op-5');
        }
    }

    function updateTableStatus(table_id){
        axios.get(base_url+`/staff/api/getOrders/${table_id}`).
        then(function(response){
            let data = response.data;
            console.log(data);
            let table_status = document.getElementById('status_indicator'+table_id);
            let ordered_menu_button = document.getElementById('ordered_menu_button'+table_id);
            if(response.data.orders.length > 0){
                table_status.innerHTML = `<i class="fa-solid fa-circle text-success"></i><span>Occupied</span>`;
                ordered_menu_button.classList.remove('d-none');
                //broadcast the table status
                socket.emit('updateTableStatus', {
                    table_id: table_id,
                    oldestOrderTime: data.oldestOrderTime,
                    status: 'occupied',
                });

            }else{
                table_status.innerHTML = `<i class="fa-solid fa-circle text-yellow"></i><span>Free</span>`;
                ordered_menu_button.classList.add('d-none');
                //broadcast the table status
                socket.emit('updateTableStatus', {
                    table_id: table_id,
                    oldestOrderTime: null,
                    status: 'free'
                });
            }
        }).catch(function(error){
            console.log(error);
        });
    }

</script>
@endsection

