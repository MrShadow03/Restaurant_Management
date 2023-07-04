@php
    function addLeadingZero($number){
        return $number < 10 ? '0'.$number : $number;
    }
    //get the max table number
    $max_table_number = $tables->max('table_number')+1;
@endphp
@section('title')
<title>Tables & Payments | Manager</title>
@endsection
@extends('dashboard.app')
@section('main')
    <x-sidebar/>
    <div class="right_content" data-simplebar>
        <x-navbar />
        <div class="heading">
            <h2 class="heading__title text-title">Table Management</h2>
            <div class="heading__left">
                <button data-remodal-target="add_table" class="btn-sm btn-primary" onclick="setTableNumber({{ $max_table_number }})"><i class="fa-solid fa-chart-tree-map"></i>&nbsp; Add Table</button>
                <audio src="{{ asset('dashboard/audio/interface-option.wav') }}" controls class="d-none" id="payment_sound"></audio>
            </div>
        </div>
        <div>
            <div class="order_table_wrapper">
                @foreach ($tables as $table)
                <div class="order_table {{ $table->status == 'occupied' ? 'order_table_time' : '' }}" data-table-id="{{ $table->id }}" id="order_table{{ $table->id }}">
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
                                <p class="fs-14 font-poppins text-info op-7" id="time-table-{{ $table->id }}" data-oldest-order-time="{{ $table->oldestOrder->created_at }}">{{ $table->oldestOrder->created_at->diff(now())->format('%H:%I:%S') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="order_table_top_right">
                            <button title="Change table {{ $table->table_number }}'s attendant" data-remodal-target="update_attendant" class="btn-icon hover_info" onclick="updateAttendant({{ json_encode($table) }})"><i class="order_table_icon fa-regular fa-repeat"></i></button>
                            <button onclick="deleteTable({{ $table->id }})" class="btn-icon hover_danger"><i class="order_table_icon fa-light fa-trash"></i></button>
                        </div>
                    </div>
                    <div class="order_table_bottom">
                        <div class="order_table_bottom_left">
                            <button data-remodal-target="ordered_menu" onclick="getOrders({{ json_encode($table) }})" class="{{ $table->status == 'free' ? 'd-none' : '' }} btn-sm btn-primary" id="bill_button{{ $table->id }}">Prepare Bill</button>
                        </div>
                        <div class="order_table_bottom_right">
                            <p class="text-sm-alt text-primary">{!! $table->user->name ?? '<i class="text-danger fa-solid fa-circle"></i> <span class="text-danger">Unattended</span>' !!}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- table add remodal --}}
    <div class="modal remodal" data-remodal-id="add_table" data-remodal-options="confirmOnEnter: true, hashTracking: false">
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

    {{-- update attendant remodal --}}
    <div class="modal remodal" data-remodal-id="update_attendant" data-remodal-options="confirmOnEnter: true, hashTracking: false">
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
    
    {{-- ordered menu remodal --}}
    <div class="modal remodal pb-1" data-remodal-id="ordered_menu" id="orders_remodal" data-remodal-options="hashTracking: false">
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
        let order_table = document.getElementById('order_table'+data.table_id);
        if(data.status == 'occupied'){
            order_table.classList.add('order_table_time');
            table_status.innerHTML = `<i class="fa-solid fa-circle text-success"></i><span>Occupied</span><p class="fs-14 font-poppins text-info op-7" id="time-table-${data.table_id}" data-oldest-order-time="${data.oldestOrderTime}">New Order!</p>`;
            bill_button.classList.remove('d-none');
        }else{
            order_table.classList.remove('order_table_time');
            table_status.innerHTML = `<i class="fa-solid fa-circle text-yellow"></i><span>Free</span>`;
            bill_button.classList.add('d-none');
        }
    })
    function getOrders(table){
        let base_url = window.location.origin;
        document.getElementById('orders_modal_title').innerHTML = 'Table-'+table.table_number+' Bill';

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
                    html += '<span class="item_title text-md-alt text">' + item.recipe_name + ' </span>&nbsp<span class="text-sm-alt text-warning fw-600">x' + item.quantity + '</span><br>';

                    //determine the price
                    let price = item.price;
                    console.log(item.discount);
                    if(item.discount > 0){
                        price = item.price - (item.price * (item.discount/100));
                        html += '<span class="text-crossed item_subtitle text-sm-alt op-6">' + item.price + '</span><span class="text-sm-alt op-6">- '+item.discount+'% |</span>';
                    }
                    
                    html += '<span class="item_subtitle text-sm-alt op-6"> ' + Math.round(price) + ' BDT</span>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="item_right">';
                    html+= '<span class="mr-1 text-sm-alt text-primary">' + Math.round(item.quantity*price) + ' BDT</span>';
                    html += '</div>';
                    html += '</div>';

                    total_price += item.quantity*price;
                });
            });

            total_price = Math.floor(total_price);

            html += '<div class="item_wrapper" style="padding: .8rem 0;">';
            html += '<div class="item_left">';
            html += '<div class="item_content">';
            html += '<span class="item_title text-md-alt text"> Subtotal </span>';
            html += '</div>';
            html += '</div>';
            html += '<div class="item_right" id="subtotal_parent' + table.id + '">';
            html+= '<span class="mr-1 text-sm-alt text-primary fw-600" id="subtotal' + table.id + '">' + total_price + ' BDT</span>';
            html += '</div>';
            html += '</div>';
            
            //create a form to add discount, username and contact number
            html += `<form action="{{ route('manager.payment') }}" onsubmit="processPayment(event, this)" method="POST" id="discount_form" class="modal__form border-top">`;
            html += '@csrf';
            html += '<input type="hidden" id="payment_table_id" name="table_id" value="'+table.id+'">';
            html += '<div class="modal__input__group">';
            html += '<div class="modal__input__field">';
            html += '<label for="discount" class="modal__input__label">Discount(%)</label>';
            html += '<input type="number" step=".01" min="0" oninput="updateTotal(this.value, ' + table.id + ', ' + total_price + ')" max="100" name="discount" id="discount" class="modal__input__input input" placeholder="Discount % (optional)">';
            html += '</div>';
            html += '<div class="modal__input__field">';
            html += '<label for="paid" class="modal__input__label">Paid</label>';
            html += '<input type="number" min="0" name="paid" id="paid" class="modal__input__input input" placeholder="Paid">';
            html += '</div>';
            html += '</div>';
            html += '<div class="modal__input__group">';
            html += '<div class="modal__input__field">';
            html += '<label for="username" class="modal__input__label">Customer Name</label>';
            html += `<input title="Can only have letters and spaces" type="text" pattern="^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$" name="customer_name" id="customer_name" class="modal__input__input input" placeholder="Customer name (optional)">`;
            html += '</div>';
            html += '<div class="modal__input__field">';
            html += '<label for="contact_number" class="modal__input__label">Contact Number</label>';
            html += '<input type="text" name="customer_contact" pattern="01[3-9]\\d{8}" title="Enter 11 digit valid phone number" id="contact_number" class="modal__input__input input" placeholder="Contact Number (optional)">';
            html += '</div>';
            html += '</div>';
            html += '<div class="modal_input_group_wrapper" style="position: relative; z-index: 0;">';
            html += '<div class="modal__input__group modal__button_group">';
            html += '<button data-remodal-action="cancel" class="btn-sm">Cancel</button>';
            html += '<button type="submit" class="btn-sm btn-primary" >Bill</button>';
            html += '</div>';
            html += '</div>';
            html += '</form>';

            //append the menu
            orders_wrapper.innerHTML = html;
        }).catch(function(error){
            console.log(error);
        });
    }
    //process the payment
    function processPayment(e, form){
        e.preventDefault();

        let base_url = window.location.origin;
        let table_id = document.getElementById('payment_table_id').value;
        let paid = document.getElementById('paid').value;
        let discount = document.getElementById('discount').value;
        let customer_name = document.getElementById('customer_name').value;
        let customer_contact = document.getElementById('contact_number').value;

        console.log(table_id, paid, discount, customer_name, customer_contact);

        //make an axios request to process the payment
        axios.post(form.action, {
            table_id: form.table_id.value,
            paid: paid,
            discount: discount,
            customer_name: customer_name,
            customer_contact: customer_contact
        }).then(function(response){
            console.log(response);
            if(response.data.message == 'Payment successful'){
                //close the modal
                let instance = $('[data-remodal-id=ordered_menu]').remodal();
                instance.close();
                //update table status
                let status_indicator = document.getElementById('status_indicator' + table_id);
                status_indicator.innerHTML = '<i class="text-yellow fa-solid fa-circle"></i><span>Free</span>';
                let bill_button = document.getElementById('bill_button' + table_id);
                bill_button.classList.add('d-none');

                //emit an event to update the table
                socket.emit('paymentDone', table_id);
                //open invoice in a new window popup
                var popup = window.open(base_url + '/manager/receipt/' + response.data.invoiceId, '_blank', 'width=400, height=800, top=100, left=100, resizable=yes, scrollbars=yes');
                popup.focus();
                //reset and play notification sound from start
                let audio = document.getElementById('payment_sound');
                audio.pause();
                audio.currentTime = 0;
                audio.play();
            }
        }).catch(function(error){
            console.log(error);
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
    function updateTotal(value, tableId, price){
        //if value is a number and not empty and greater than 0
        let totalPriceParent = document.getElementById('subtotal_parent' + tableId);
        let totalPriceSpan = document.getElementById('subtotal' + tableId);
        let discountedPrice = document.getElementById('discounted_price' + tableId);
        if(!isNaN(value) && value != '' && value > 0 && value <= 100){
            //get the total element
            if(totalPriceParent && totalPriceSpan){
                totalPriceSpan.classList.add('text-crossed');
                totalPriceSpan.innerHTML = price;
                //if there is no discount element, create one
                if(discountedPrice){
                    discountedPrice.innerHTML = Math.round(price - (price * (value / 100)))+ ' BDT';
                }else{
                    let span = document.createElement('span');
                    span.classList.add('text-sm-alt','text-success');
                    span.id = 'discounted_price' + tableId;
                    span.innerHTML = Math.round(price - (price * (value / 100)))+ ' BDT';
                    totalPriceParent.appendChild(span);
                }
            }
        }else{
            if(totalPriceParent && totalPriceSpan){
                totalPriceSpan.classList.remove('text-crossed');
                totalPriceSpan.innerHTML = price + ' BDT';
                if(discountedPrice){
                    discountedPrice.remove();
                }
            }
        }
    }
    // call the updateTime function for each table every second
    setInterval(function() {
        // loop through all the tables
        var tables = document.querySelectorAll('.order_table_time');
        for (var i = 0; i < tables.length; i++) {
            var tableId = tables[i].getAttribute('data-table-id');
            updateTime(tableId);
        }
    }, 1000);
    //deleting table
    function deleteTable(tableId){
        //first show a confirmation message
        if(!confirm('Are you sure you want to delete this table?')){
            return;
        }
        //get the table
        let table = document.getElementById('order_table' + tableId);
        //get the base url
        let base_url = window.location.origin;
        //make an axios request to delete the table
        axios.get(base_url+`/manager/table/destroy/${tableId}`)
        .then(function(response){
            //if the table has order and cannot be deleted
            if(response.data.message == 'Table has order'){
                //show an error message
                toastr.error('This table has orders and cannot be deleted.');
                return;
            }

            //if the table is deleted successfully
            if(response.data.message == 'Table deleted'){
                //remove the table from the dom
                table && table.remove();
                //emit an event to update the table
                socket.emit('tableDeleted', response.data.tableId);
            }
        }).catch(function(error){
            console.log(error);
        });
    }
    
</script>
@endsection
