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
                <audio src="{{ asset('dashboard/audio/order_recieved2.mp3') }}" controls class="d-none" id="order_recieved_sound"></audio>
            </div>
        </div>
        <div>
            <div class="order_table_wrapper">
                @foreach ($tables as $table)
                <div class="order_table">
                    <div class="order_table_title">{{ addLeadingZero($table->table_number) }}</div>
                    <div class="order_table_top">
                        <div class="order_table_top_left">
                            <div class="status_indicator">
                                <i class="text-yellow fa-solid fa-circle-small"></i>
                                <span>Free</span>
                            </div>
                        </div>
                        <div class="order_table_top_right">
                            <a href="#" class="btn-sm"><i class="order_table_icon fa-solid fa-user-pen"></i></a>
                        </div>
                    </div>
                    <div class="order_table_bottom">
                        <div class="oreder_table_bottom_left">
                            <div class="btn-sm btn-primary">Prepare Bill</div>
                        </div>
                        <div class="oreder_table_bottom_right">
                            <p class="text-sm-alt text-primary">{{ $table->user->name }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- table add remodal --}}
    <div class="modal remodal" data-remodal-id="add_table">
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
@endsection

@section('exclusive_scripts')
<script>
    (function($){
        $(document).ready(function(){
            $('.data-table').DataTable({
                "processing": true,
                lengthMenu: [ [20, 10, 15, 25, 50], [20, 10, 15, 25, 50] ],
            });

            socket.on('orderResponseFromKitchen', function(data){
                console.log(data);
                toastr.warning("New Order Received!");
                $('#order_recieved_sound')[0].play();
            });

        });
    })(jQuery);

    //tom select in category
    tomSelect = new TomSelect('#table_attendant', {
        create: true,
        maxItems: 1,
    });

    function editProduct(staff){
        //modal.open();
        //remove btn-primary class from update button
        $('#edit_submit').removeClass('btn-primary');
        $('#edit_product').text('Update '+staff.name);
        $('#staff_id').val(staff.id);
        $('#name').val(staff.name);
        $('#role').val(staff.role);
        $('#phone_number').val(staff.phone_number);
        $('#email').val(staff.email);
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
    
</script>
@endsection

