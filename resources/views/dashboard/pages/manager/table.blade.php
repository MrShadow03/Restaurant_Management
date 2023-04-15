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
            <div class="heading__left">
                <a href="#add_table" class="btn-sm btn-primary" onclick="setTableNumber({{ $max_table_number }})"><i class="fa-solid fa-chart-tree-map"></i>&nbsp; Add Table</a>
                <audio src="{{ asset('dashboard/audio/ding.mp3') }}" controls class="d-none" id="table_sound"></audio>
            </div>
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
                                <p class="fs-12 font-poppins text-info op-7">{{ $table->oldestOrder->created_at->diff(now())->format('%H:%I:%S') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="order_table_top_right">
                            <a href="#update_attendant" onclick="updateAttendant({{ json_encode($table) }})" class="btn-sm"><i class="order_table_icon fa-solid fa-user-pen"></i></a>
                        </div>
                    </div>
                    <div class="order_table_bottom">
                        <div class="oreder_table_bottom_left">
                            <a href="#ordered_menu" onclick="getOrders({{ json_encode($table) }})" class="{{ $table->status == 'free' ? 'd-none' : '' }} btn-sm btn-primary" id="bill_button{{ $table->id }}">Prepare Bill</a>
                        </div>
                        <div class="oreder_table_bottom_right">
                            <p class="text-sm-alt text-primary">{!! $table->user->name ?? '<i class="text-danger fa-solid fa-circle"></i> <span class="text-danger">Unattended</span>' !!}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- table add remodal --}}
    <div class="modal remodal" data-remodal-id="add_table" data-remodal-options="confirmOnEnter: true">
        <div class="modal_heading">
            <h2 class="modal_title"><i class="fa-regular fa-user"></i> &nbsp; Add a new table</h2>
            <button data-remodal-action="close"><i class="fa-light fa-times"></i></button>
        </div>
        <form class="modal__form" action="{{ route('manager.table.store') }}" method="POST" >
            @csrf
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Table Number</label>
                    <input type="number" name="table_number" id="table_number" class="input" placeholder="e.g. 1" required>
                </div>
                @error('name')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Attendant</label>
                    <select name="user_id" id="table_attendant" class="input" required>
                        <option value="" disabled selected>Select an Attendant</option>
                        @foreach ($attendants as $attendant)
                            <option value="{{ $attendant->id }}">{{ $attendant->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('user_id')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal_input_group_wrapper" style="position: relative; z-index: 0;">
                <div class="modal__input__group modal__button_group">
                    <button data-remodal-action="cancel" class="btn-sm">Cancel</button>
                    <button type="submit" class="btn-sm btn-primary" onclick="this.form.submit()">Add</button>
                </div>
            </div>
        </form>
    </div>

    <div class="modal remodal" data-remodal-id="update_attendant" data-remodal-options="confirmOnEnter: true">
        <div class="modal_heading">
            <h2 class="modal_title"><i class="fa-regular fa-user"></i> &nbsp; Select another attendant</h2>
            <button data-remodal-action="close"><i class="fa-light fa-times"></i></button>
        </div>
        <form class="modal__form" action="{{ route('manager.table.update_attendant') }}" method="POST" >
            @csrf
            @method('PATCH')
            <input type="hidden" name="table_id" id="table_id">
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Attendant</label>
                    <select name="user_id" id="update_table_attendant" class="input" required>
                        <option value="" disabled selected>Select an Attendant</option>
                        @foreach ($attendants as $attendant)
                            <option value="{{ $attendant->id }}">{{ $attendant->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('user_id')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal_input_group_wrapper" style="position: relative; z-index: 0;">
                <div class="modal__input__group modal__button_group">
                    <button data-remodal-action="cancel" class="btn-sm">Cancel</button>
                    <button type="submit" class="btn-sm btn-primary" onclick="update">Add</button>
                </div>
            </div>
        </form>
    </div>

    <div class="modal remodal pb-1" data-remodal-id="ordered_menu" id="orders_remodal">
        <div class="modal_heading">
            <h2 class="modal_title" id="orders_modal_title">Table-{{ $tables[0]->table_number }} Order</h2>
            <button data-remodal-action="close"><i class="fa-light fa-times"></i></button>
            <input type="hidden" name="table_id" id="table_id" value="{{ $tables[0]->id }}">
        </div>
        <div class="menu_wrapper" id="orders_wrapper">
        </div>
    </div>
@endsection

@section('exclusive_scripts')
<script>
    (function($){
        $(document).ready(function(){
            $('.data-table').DataTable({
                "processing": true,
                lengthMenu: [ [20, 10, 15, 25, 50], [20, 10, 15, 25, 50] ],
            });
            // socket.on('orderResponseFromKitchen', function(data){
            //     console.log(data);
            //     toastr.warning("New Order Received!");
            //     $('#order_recieved_sound')[0].play();
            // });
        });
    })(jQuery);
    //tom select in category
    tomSelect = new TomSelect('#table_attendant', {
        create: true,
        maxItems: 1,
    });
    tomSelect2 = new TomSelect('#update_table_attendant', {
        create: true,
        maxItems: 1,
    });
    function updateAttendant(table){
        //modal.open();
        //remove btn-primary class from update button
        $('#edit_submit').removeClass('btn-primary');

        //set table id
        $('#table_id').val(table.id);
        tomSelect2.addItem(table.user_id);
    }
    function addProduct(product){
        $('#add_edit_product').text('Add '+product.product_name);
        $('#add_product_id').val(product.id);
    }
    function subtractProduct(product){
        $('#subtract_edit_product').text('Subtract '+product.product_name);
        $('#subtract_product_id').val(product.id);
    }
    function updateButton(){
        //add btn-primary class to update button
        $('#edit_submit').addClass('btn-primary');
    }
    function setTableNumber(table_number){
        $('#table_number').val(table_number);
    }
    socket.on('updateTableStatusResponse', function(data) {
        let table_status = document.getElementById('status_indicator'+data.table_id);
        let bill_button = document.getElementById('bill_button'+data.table_id);
        if(data.status == 'occupied'){
            table_status.innerHTML = `<i class="fa-solid fa-circle text-success"></i><span>Occupied</span>`;
            bill_button.classList.remove('d-none');
        }else{
            table_status.innerHTML = `<i class="fa-solid fa-circle text-yellow"></i><span>Free</span>`;
            bill_button.classList.add('d-none');
        }
    })
    function getOrders(table){
        let base_url = window.location.origin;
        document.getElementById('orders_modal_title').innerHTML = 'Table-'+table.table_number+' Order';

        axios.get(base_url+`/manager/api/getOrders/${table.id}`).
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
            let total_price = 0;
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
                    html += '<span class="item_title text-md-alt text">' + item.recipe_name + ' </span>&nbsp<span class="text-sm-alt text-warning fw-600">x' + item.quantity + '</span>';
                    html += '<h3 class="item_subtitle text-sm-alt op-6">' + item.price + ' BDT</h3>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="item_right">';
                    html+= '<span class="mr-1 text-sm-alt text-primary">' + item.quantity*item.price + ' BDT</span>';
                    html += '</div>';
                    html += '</div>';

                    total_price += item.quantity*item.price;
                });
            });

            html += '<div class="item_wrapper" style="padding: .8rem 0;">';
            html += '<div class="item_left">';
            html += '<div class="item_content">';
            html += '<span class="item_title text-md-alt text"> Subtotal </span>';
            html += '</div>';
            html += '</div>';
            html += '<div class="item_right">';
            html+= '<span class="mr-1 text-sm-alt text-primary fw-600">' + total_price + ' BDT</span>';
            html += '</div>';
            html += '</div>';

            //append the menu
            orders_wrapper.innerHTML = html;
        }).catch(function(error){
            console.log(error);
        });
    }
    
</script>
@endsection

