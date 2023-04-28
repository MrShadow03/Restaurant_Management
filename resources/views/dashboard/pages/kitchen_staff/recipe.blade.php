@section('title')
<title>Available Foods | Kitchen</title>
@endsection
@extends('dashboard.app')
@section('main')
    <x-sidebar/>
    <div class="right_content">
        <x-navbar />
        <div class="heading">
            <h2 class="heading__title text-title">Food Items</h2>
            {{-- <a href="#open_menu_remodal" class="btn-sm btn-primary"></a> --}}
        </div>
        <div>
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

