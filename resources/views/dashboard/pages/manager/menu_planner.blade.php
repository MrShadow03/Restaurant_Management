@section('title')
<title>Profile | {{ auth()->user()->name }}</title>
@endsection
@extends('dashboard.app')
@section('main')
    <x-sidebar/>
    <div class="right_content" data-simplebar>
        <x-navbar />
        <div class="table_box d-flex" style="min-height: 100vh !important;">
            <div class="card card-column" data-simplebar style="width: 30% !important;">
                <div class="menu_heading">
                    <div class="modal_heading_left">
                        <h2 class="text-md-alt text-primary op-6 font-roboto"><i class="fa-light fa-calendar fs-16"></i> &nbsp; Todays Menu</h2>
                        <h2 class="text-sm-alt text-primary op-6 font-roboto"><i class="fa-light fa-clock fs-16"></i> &nbsp; {{ Carbon\Carbon::now()->format('dS F, Y') }}</h2>
                    </div>
                    <div class="modal_heading_right">
                        <button class="btn-sm btn-info" data-remodal-target="ordering_menu" onclick="getMenu({{ json_encode($recipes) }}, 'today')"><i class="fa-solid fa-list"></i></button>
                    </div>
                </div>
                @if ($plans->where('date', Carbon\Carbon::now()->format('Y-m-d'))->count() == 0)
                <div class="div-message text-center" style="margin-top: 10rem">
                    <h2 class="div-message-title fs-14 font-inter text-center text-sm-alt text-orange mb-2">Make plans for today!</h2>
                    <div class="button-group">
                        <button class="btn-sm btn-primary" data-remodal-target="ordering_menu" onclick="getMenu({{ json_encode($recipes) }}, 'today')"><i class="fa-solid fa-list"></i> &nbsp; Prepare Menu</button>
                    </div>
                </div>
                @else
                <div class="menu_wrapper">
                    @foreach ($plans->where('date', Carbon\Carbon::now()->format('Y-m-d')) as $plan)
                    <div class="item_wrapper">
                        <div class="item_left">
                            <div class="item_image">
                                <p id="food_availability_index{{ $plan->recipe->id }}" class="badge-index {{ $plan->recipe->on_menu ? 'badge-info' : 'badge-danger' }}"><i class="fa-solid fa-meat"></i></p>
                            </div>
                            <div class="item_content">
                                <h3 class="text-md-alt text-primary op-9">{{ $plan->recipe->recipe_name }} <i id="food_availability_status{{ $plan->recipe->id }}" class="fs-12 fa-solid {{ $plan->recipe->on_menu ? 'fa-circle-check text-success' : 'fa-circle-xmark text-danger' }}"></i></h3>
                                <h3 class="item_subtitle text-sm-alt op-6 d-inline">{{ $plan->recipe->price }} BDT 
                                </h3>
                                @if($plan->recipe->discount > 0)
                                <span class="badge badge-warning"><i class="fa-solid fa-fire"></i>&nbsp; {{ $plan->recipe->discount }}% off</span>
                                @endif
                            </div>
                        </div>
                        <div class="item_right">
                            <h3 class="text-md-alt text-primary op-9">x{{ $plan->quantity }}</h3>
                            {{-- <form class="switch" action="{{ route('manager.recipe.toggle_on_menu') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="id" value={{ $plan->recipe->id }}>
                                <input class="tgl tgl-ios" id="toggle_on_menu{{ $plan->recipe->id }}" name="on_menu" type="checkbox" {{ $plan->recipe->on_menu ? 'checked' : '' }} onchange="toggleOnMenu(this, {{ $plan->recipe->id }})"/>
                                <label title="Remove or include item on the menu" class="tgl-btn" for="toggle_on_menu{{ $plan->recipe->id }}"></label>
                            </form> --}}
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            <div class="card card-column" data-simplebar>
                <div class="menu_heading">
                    <div class="menu_heading_left">
                        <h2 class="text-md-alt text-primary op-6 font-roboto"><i class="fa-light fa-calendar fs-16"></i> &nbsp; Plans for tomorrow</h2>
                        <h2 class="text-sm-alt text-primary op-6 font-roboto"><i class="fa-light fa-clock fs-16"></i> &nbsp; {{ Carbon\Carbon::now()->addDay(1)->format('dS F, Y') }}</h2>
                    </div>
                    <div class="menu_heading_right">
                        <button class="btn-sm btn-info" data-remodal-target="ordering_menu" onclick="getMenu({{ json_encode($recipes) }}, 'tomorrow')"><i class="fa-solid fa-list"></i></button>
                    </div>
                </div>
                @if ($plans->where('date', Carbon\Carbon::now()->addDay(1)->format('Y-m-d'))->count() == 0)
                <div class="div-message text-center" style="margin-top: 10rem">
                    <h2 class="div-message-title fs-14 font-inter text-center text-sm-alt text-orange mb-2">Currently there are no plans for tomorrow!</h2>
                    <div class="button-group">
                        <button class="btn-sm btn-primary" data-remodal-target="ordering_menu" onclick="getMenu({{ json_encode($recipes) }}, 'tomorrow')"><i class="fa-solid fa-list"></i> &nbsp; Prepare Menu</button>
                        <button class="btn-sm"><i class="fa-solid fa-check-circle"></i> &nbsp; Same as today</button>
                    </div>
                </div>
                @else
                <div class="menu_wrapper">
                    @foreach ($plans->where('date', Carbon\Carbon::now()->addDay(1)->format('Y-m-d')) as $plan)
                    <div class="item_wrapper">
                        <div class="item_left">
                            <div class="item_image">
                                <p id="food_availability_index{{ $plan->recipe->id }}" class="badge-index {{ $plan->recipe->on_menu ? 'badge-info' : 'badge-danger' }}"><i class="fa-solid fa-meat"></i></p>
                            </div>
                            <div class="item_content">
                                <h3 class="text-md-alt text-primary op-9">{{ $plan->recipe->recipe_name }} <i id="food_availability_status{{ $plan->recipe->id }}" class="fs-12 fa-solid {{ $plan->recipe->on_menu ? 'fa-circle-check text-success' : 'fa-circle-xmark text-danger' }}"></i></h3>
                                <h3 class="item_subtitle text-sm-alt op-6 d-inline">{{ $plan->recipe->price }} BDT 
                                </h3>
                                @if($plan->recipe->discount > 0)
                                <span class="badge badge-warning"><i class="fa-solid fa-fire"></i>&nbsp; {{ $plan->recipe->discount }}% off</span>
                                @endif
                            </div>
                        </div>
                        <div class="item_right">
                            <h3 class="text-md-alt text-primary op-9">x{{ $plan->quantity }}</h3>
                            {{-- <form class="switch" action="{{ route('manager.recipe.toggle_on_menu') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="id" value={{ $plan->recipe->id }}>
                                <input class="tgl tgl-ios" id="toggle_on_menu{{ $plan->recipe->id }}" name="on_menu" type="checkbox" {{ $plan->recipe->on_menu ? 'checked' : '' }} onchange="toggleOnMenu(this, {{ $plan->recipe->id }})"/>
                                <label title="Remove or include item on the menu" class="tgl-btn" for="toggle_on_menu{{ $plan->recipe->id }}"></label>
                            </form> --}}
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="modal remodal" data-remodal-id="ordering_menu" id="ordering_remodal" data-remodal-options="hashTracking: false">
        <div class="modal_heading">
            <h2 class="modal_title" id="modal_title">Menu Planner</h2>
            <button data-remodal-action="close"><i class="fa-light fa-times"></i></button>
        </div>
        <div class="menu_wrapper" id="menu_wrapper" data-simplebar>
            <button data-remodal-action="close" class="btn-sm btn-primary mb-2">Close</button>
        </div>
    </div>
@endsection

@section('exclusive_scripts')
<script>
    function getMenu(menu, day){
        console.log(menu);
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

                    let classList = 'menu_quantity_input op-5';
                    html += `<input type="text" class="${classList}" id="menu_quantity_input${item.id}" value="0" oninput="changeTextColor(${item.id})" onchange="changeTextColor(${item.id})" style="width: 7rem;">`;

                    html += '<button onclick="incQuantity(' + item.id + ')" class="menu_quantity_btn"><i class="fa-light fa-plus"></i></button>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="item_right">';

                    let buttonClass = 'btn-sm btn-disabled';
                    let buttonText = 'Order';
                    html += `<button class="${buttonClass}" onclick="placeOrder(${item.id}, '${day}')" id="order_button${item.id}" disabled>${buttonText}</button>`;

                    html += '</div>';
                    html += '</div>';
                });
            });

            //append the menu
            menu_wrapper.innerHTML = html;

            getPlanCount(day);
    }

    function getPlanCount(day){
        axios.get(window.location.origin+`/manager/api/getPlanCount/${day}`).then(function(response){
            let data = response.data;
            console.log(data);
            if(data.length > 0){
                data.forEach(function(item){
                    let button = document.getElementById('order_button'+item.recipe_id);
                    let input = document.getElementById('menu_quantity_input'+item.recipe_id);
                    button.innerHTML = 'Sent';
                    button.classList.add('btn-success');
                    button.classList.remove('btn-disabled');
                    button.disabled = false;
                    input.value = item.quantity;
                    input.classList.remove('op-5');
                    input.classList.add('text-orange');
                });
            }
        }).catch(function(error){
            console.log(error);
        });
    }

    function incQuantity( id ){
        let order_button = document.getElementById('order_button'+id);
        if(order_button){
            let quantity = document.getElementById('menu_quantity_input'+id).value;
            quantity = parseInt(quantity)+1;
            order_button.classList.remove('btn-success');
            order_button.classList.remove('btn-danger');
            order_button.classList.remove('btn-disabled');
            order_button.disabled = false;
            document.getElementById('menu_quantity_input'+id).value = quantity;
            order_button.classList.add('btn-primary');
            order_button.innerHTML = 'Order';
            document.getElementById('menu_quantity_input'+id).classList.add('text-orange');
            document.getElementById('menu_quantity_input'+id).classList.remove('op-5');
        }
        
    }
    
    function decQuantity( id ){
        let order_button = document.getElementById('order_button'+id);

        if(order_button){
            let quantity = document.getElementById('menu_quantity_input'+id).value;
            order_button.classList.remove('btn-success');
            order_button.innerHTML = 'Order';
            order_button.classList.add('btn-primary');
            
            quantity = parseInt(quantity)-1;
            if( quantity < 0 ){
                quantity = 0;
            }
    
            document.getElementById('menu_quantity_input'+id).value = quantity;
    
            if( quantity == 0 ){
                order_button.classList.remove('btn-primary');
                order_button.classList.add('btn-danger');
                order_button.innerText = 'Remove';
                document.getElementById('menu_quantity_input'+id).classList.remove('text-orange');
                document.getElementById('menu_quantity_input'+id).classList.add('op-5');
            }
        }
    }

    function changeTextColor(recipeId){
        let input = document.getElementById('menu_quantity_input'+recipeId);
        console.log(recipeId, input.value);
        let button = document.getElementById('order_button'+recipeId);
        if(input.value > 0){
            input.classList.remove('op-5');
            input.classList.add('text-orange');
            button.classList.remove('btn-danger');
            button.classList.remove('btn-disabled');
            button.classList.add('btn-primary');
            button.innerHTML = 'Order';
            button.disabled = false;
        }else{
            input.classList.remove('text-orange');
            input.classList.add('op-5');
            button.classList.remove('btn-primary');
        }
    }

    function placeOrder(recipeId, day){
        let quantity = document.getElementById('menu_quantity_input'+recipeId).value;
        console.log(quantity, recipeId, day);

        // return;
        axios.post(window.location.origin+`/manager/api/storePlan`, {
            recipe_id: recipeId,
            quantity: quantity,
            day: day
        }).then(function(response){
            let data = response.data;
            console.log(data);
            getPlanCount(day);
            //if the order is placed then show toastr success
            data.status == 'success' ? toastr.success(data.message) : toastr.warning(data.message);

            // console.log(response);
            // return;
            
            // //if the order is deleted then show toastr warning
            // if(data.message == 'deleted'){
            //     document.getElementById('order_button'+data.recipe_id).classList.remove('btn-danger');
            //     document.getElementById('order_button'+data.recipe_id).innerHTML = 'Order';
            //     toastr.warning('Order deleted');

            //     //send to kitchen
            //     sendOrderToKitchen(response.data, 'remove');
            //     //update the table status
            //     updateTableStatus(response.data.table_id);
            //     return;
            // }
            // //if the recipe is not available then show toastr warning
            // if(data.message == 'not available'){
            //     document.getElementById('order_button'+data.recipe_id).classList.add('btn-danger');
            //     document.getElementById('order_button'+data.recipe_id).innerHTML = 'Unavailable';
            //     toastr.error('Recipe is not available');
            //     return;
            // }
            // if(data.message == 'empty'){
            //     document.getElementById('order_button'+data.recipe_id).classList.remove('btn-danger');
            //     document.getElementById('order_button'+data.recipe_id).innerHTML = 'Order';
            //     toastr.warning('Choose a quantity');
            //     return;
            // }


        }).catch(function(error){
            console.log(error);
        });
    }

</script>
    
@endsection

