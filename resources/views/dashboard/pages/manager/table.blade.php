@section('title')
<title>Admin-Teacher</title>
@endsection
@extends('dashboard.app')
@section('main')
    <x-sidebar/>
    <div class="right_content">
        <x-navbar />
        <div class="heading">
            <h2 class="heading__title text-title">Staff Management</h2>
            <div class="heading__left">
                <a href="#add_product" class="btn-sm btn-primary"><i class="fa-solid fa-user"></i>&nbsp; Add Table</a>
                <audio src="{{ asset('dashboard/audio/order_recieved2.mp3') }}" controls class="d-none" id="order_recieved_sound"></audio>
            </div>
        </div>
        <div>
            <div class="order_table_wrapper">
                <div class="order_table">
                    <div class="order_table_title">01</div>
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
                            <div class="btn-sm">Orders</div>
                        </div>
                        <div class="oreder_table_bottom_right">
                            <div class="btn-sm btn-primary">Bill</div>
                        </div>
                    </div>
                </div>
                <div class="order_table">
                    <div class="order_table_title">01</div>
                    <div class="order_table_top">
                        <div class="order_table_top_left">
                            <span></span>
                        </div>
                        <div class="order_table_top_right">
                            <i class="order_table_icon fa-solid fa-user-pen"></i>
                        </div>
                    </div>
                    <div class="order_table_bottom">
                        <div class="oreder_table_bottom_left">
                            <div class="btn-sm">Orders</div>
                        </div>
                        <div class="oreder_table_bottom_right">
                            <div class="btn-sm btn-primary">Bill</div>
                        </div>
                    </div>
                </div>
            </div>
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

            socket.on('orderResponseFromKitchen', function(data){
                console.log(data);
                toastr.warning("New Order Received!");
                $('#order_recieved_sound')[0].play();
            });

        });
    })(jQuery);

    //tom select in category
    tomSelect = new TomSelect('#add_category', {
        create: true,
        maxItems: 1,
    });
    tomSelect2 = new TomSelect('#recipe_category', {
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
    
</script>
@endsection

