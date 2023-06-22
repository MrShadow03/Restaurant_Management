@section('title')
<title>Profile | {{ auth()->user()->name }}</title>
@endsection
@extends('dashboard.app')
@section('main')
    <x-sidebar/>
    <div class="right_content" data-simplebar>
        <x-navbar />
        <div class="table_box d-flex">
            <div class="card card-column" data-simplebar style="width: 30% !important;">
                <div class="modal_heading">
                    <h2 class="text-sm-alt text-primary op-6 font-roboto"><i class="fa-light fa-calendar fs-16"></i> &nbsp; Todays Menu</h2>
                    <h2 class="text-sm-alt text-primary op-6 font-roboto"><i class="fa-light fa-clock fs-16"></i> &nbsp; {{ Carbon\Carbon::now()->format('dS F, Y') }}</h2>
                </div>
                <div class="menu_wrapper">
                    @foreach ($recipes as $recipe)
                    <div class="item_wrapper">
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
            <div class="card card-column" data-simplebar>
                <div class="modal_heading">
                    <h2 class="text-sm-alt text-primary op-6 font-roboto"><i class="fa-light fa-calendar fs-16"></i> &nbsp; Plans for tomorrow</h2>
                    <h2 class="text-sm-alt text-primary op-6 font-roboto"><i class="fa-light fa-clock fs-16"></i> &nbsp; {{ Carbon\Carbon::now()->addDay(1)->format('dS F, Y') }}</h2>
                </div>
                <div class="div-message text-center" style="margin-top: 10rem">
                    <h2 class="div-message-title fs-14 font-inter text-center text-sm-alt text-orange mb-2">Currently there are no plans for tomorrow!</h2>
                    <div class="button-group">
                        <button class="btn-sm btn-primary" data-remodal-target="ordering_menu" onclick="getMenu({{ json_encode($recipes) }})"><i class="fa-solid fa-list"></i> &nbsp; Prepare Menu</button>
                        <button class="btn-sm"><i class="fa-solid fa-check-circle"></i> &nbsp; Same as today</button>
                    </div>
                </div>
                {{-- <div class="menu_wrapper">
                    @foreach ($recipes as $recipe)
                    <div class="item_wrapper">
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
                </div> --}}
            </div>
        </div>
    </div>
    <div class="modal remodal" data-remodal-id="ordering_menu" id="ordering_remodal" data-remodal-options="hashTracking: false">
        <div class="modal_heading">
            <h2 class="modal_title" id="modal_title"></h2>
            <button data-remodal-action="close"><i class="fa-light fa-times"></i></button>
        </div>
        <div class="menu_wrapper" id="menu_wrapper" data-simplebar>
            <button data-remodal-action="close" class="btn-sm btn-primary mb-2">Close</button>
        </div>
    </div>
@endsection

@section('exclusive_scripts')
<script>
    function getMenu(menu){
        //clear menu wrapper
        let menu_wrapper = document.querySelector('#menu_wrapper');
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
                    html += `<h3 class="item_title text-md-alt text">${item.recipe_name} ${ !item.is_available ? '<span class="badge badge-danger">Unavailable</span>' : ''}</h3>`;
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

                    if(item.is_available){
                        let buttonClass = item.orderCount > 0 ? 'btn-sm btn-success' : 'btn-sm';
                        let buttonText = item.orderCount > 0 ? 'Ordered' : 'Order';
                        html += `<button class="${buttonClass}" onclick="placeOrder(${item.id})" id="order_button${item.id}">${buttonText}</button>`;
                    }

                    html += '</div>';
                    html += '</div>';
                });
            });

            //append the menu
            menu_wrapper.innerHTML = html;
        
        // let base_url = window.location.origin;
        // //get menu
        // axios.get(base_url+'/manager/api/getMenu/')
        // .then(function(response){
        //     //data
        //     let menu = response.data;
        //     console.log(menu);
        //     //clear menu wrapper
        //     let menu_wrapper = document.querySelector('#menu_wrapper');
        //     menu_wrapper.innerHTML = '';

        //     html = '';
        //     //get unique categories
        //     var uniqueCategories = [...new Set(menu.map(item => item.category))];
        //     //create the menu
        //     uniqueCategories.forEach(function(category) {
        //         var items = menu.filter(function(item) {
        //             return item.category === category;
        //         });

        //         items.forEach(function(item, index) {
        //             if (index === 0) {
        //                 html += '<h3 class="menu_category_title">' + category + '</h3>';
        //             }

        //             html += '<div class="item_wrapper">';
        //             html += '<div class="item_left">';
        //             html += '<div class="item_image">';
        //             html += `<img src="{{ asset('dashboard/img/food/default.png') }}" class="item_image item_image_md" alt="">`;
        //             html += '</div>';
        //             html += '<div class="item_content">';
        //             html += `<h3 class="item_title text-md-alt text">${item.recipe_name} ${ !item.is_available ? '<span class="badge badge-danger">Unavailable</span>' : ''}</h3>`;
        //             html += '<h3 class="item_subtitle text-sm-alt op-6">' + item.price + ' BDT</h3>';
        //             html += '<div class="menu_quantity_wrapper">';
        //             html += '<button onclick="decQuantity(' + item.id + ')" class="menu_quantity_btn"><i class="fa-light fa-minus"></i></button>';

        //             let classList = item.orderCount > 0 ? 'menu_quantity_input text-orange' : 'menu_quantity_input op-5';
        //             html += `<input type="text" class="${classList}" id="menu_quantity_input${item.id}" value="${item.orderCount}" readonly>`;

        //             html += '<button onclick="incQuantity(' + item.id + ')" class="menu_quantity_btn"><i class="fa-light fa-plus"></i></button>';
        //             html += '</div>';
        //             html += '</div>';
        //             html += '</div>';
        //             html += '<div class="item_right">';
 
        //             if(item.is_available){
        //                 let buttonClass = item.orderCount > 0 ? 'btn-sm btn-success' : 'btn-sm';
        //                 let buttonText = item.orderCount > 0 ? 'Ordered' : 'Order';
        //                 html += `<button class="${buttonClass}" onclick="placeOrder(${item.id})" id="order_button${item.id}">${buttonText}</button>`;
        //             }

        //             html += '</div>';
        //             html += '</div>';
        //         });
        //     });

        //     //append the menu
        //     menu_wrapper.innerHTML = html;
        // }).catch(function(error){
        //     console.log(error);
        // });
    };

</script>
    
@endsection

