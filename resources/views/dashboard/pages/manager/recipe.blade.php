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
            <div class="heading__left">
                <a href="#add_product" class="btn-sm btn-primary"><i class="fa-solid fa-burger-soda"></i>&nbsp; Add Item</a>
                <audio src="{{ asset('dashboard/audio/order_recieved2.mp3') }}" controls class="d-none" id="order_recieved_sound"></audio>
                <audio src="{{ asset('dashboard/audio/ding.mp3') }}" controls class="d-none" id="order_recieved_sound2"></audio>
                <audio src="{{ asset('dashboard/audio/order_recieved1.mp3') }}" controls class="d-none" id="order_recieved_sound3"></audio>
            </div>
        </div>
        <div>
            <div class="table_box">
                <div class="table-wrapper">
                    <table class="w-100 data-table">
                        <thead>
                            <tr class="heading-row">
                                <th class="heading-column">Product</th>
                                <th class="heading-column">Status</th>
                                <th class="heading-column">Include on Menu</th>
                                <th class="heading-column"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recipes as $recipe)
                                <tr class="table-row">
                                    <td class="table-column">
                                        <div class="table-column__wrapper">
                                            <div class="table-column__image">
                                                <img src="{{ asset('dashboard/img/food/default.png') }}" class="item_image item_image_md" alt="">
                                            </div>
                                            <div class="table-column__content">
                                                <p class="table-column__subtitle pt-0">{{ $recipe->category }}</p>
                                                <h3 class="table-column__title table-column__product">{{ $recipe->recipe_name ?? '' }}</h3>
                                                <p class="table-column__subtitle"><i class="fa-regular fa-bangladeshi-taka-sign"></i> {{ $recipe->price }} BDT</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table-column">
                                        <div class="table-column__wrapper">
                                            <div class="table-column__content">
                                                <p class="table-column__status"><i class="fa-solid fa-circle-small" style="{{ $recipe->on_menu ? 'color: #43A047;' : 'color: #dc3545' }}"></i> {{ $recipe->on_menu ? "On the menu" : "Not on the menu" }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table-column">
                                        <div class="table-column__wrapper">
                                            <div class="table-column__content">
                                                <form class="switch" action="{{ route('manager.recipe.toggle_on_menu') }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="id" value={{ $recipe->id }}>
                                                    <input class="tgl tgl-ios" id="toggle_on_menu{{ $recipe->id }}" name="on_menu" type="checkbox" {{ $recipe->on_menu ? 'checked' : '' }} onchange="this.form.submit()"/>
                                                    <label class="tgl-btn" for="toggle_on_menu{{ $recipe->id }}"></label>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table-column">
                                        <div class="table-column__wrapper">
                                            <div class="table-column__content">
                                                <a href="#edit_product_modal" title="Edit product" class="btn-sm" onclick="editProduct({{ json_encode($recipe) }})">Edit</a>
                                                <a href="{{ route('manager.recipe.destroy', $recipe->id) }}" title="Delete product" class="btn-sm" onclick="return confirm('This Will Delete this product')" ><i class="fa-regular fa-trash"></i></a>
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

    {{-- product add remodal --}}
    <div class="modal remodal" data-remodal-id="add_product">
        <div class="modal_heading">
            <h2 class="modal_title"><i class="fa-regular fa-fork-knife"></i> &nbsp; New Item</h2>
            <button data-remodal-action="close"><i class="fa-light fa-times"></i></button>
        </div>
        <form class="modal__form" action="{{ route('manager.recipe.store') }}" method="POST" >
            @csrf
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Item Name</label>
                    <input type="text" name="recipe_name" class="input" placeholder="e.g. Biryani 1:3" required>
                </div>
                @error('recipe_name')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Category</label>
                    <select name="category" id="add_category" class="input" required>
                        <option value="" disabled selected>Select or Create Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                @error('category')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal_input_group_wrapper" style="position: relative; z-index: 0;">
                <div class="modal__input__group">
                    <div class="modal__input__field">
                        <label class="modal__input__label">Price (BDT)</label>
                        <input type="number" name="price" class="input" placeholder="Price">
                    </div>
                    @error('price')
                    <p class="input-error">{{ $message }}</p>
                    @enderror
                    <div class="modal__input__field">
                        <label class="modal__input__label">VAT(%)</label>
                        <input type="number" name="VAT" class="input" placeholder="e.g: 5 (optional)">
                        {{-- <i class="modal_input_icon fa-regular fa-percent"></i> --}}
                    </div>
                    @error('VAT(%)')
                        <p class="input-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="modal__input__group modal__button_group">
                    <button data-remodal-action="cancel" class="btn-sm">Cancel</button>
                    <button type="submit" class="btn-sm btn-primary" onclick="this.form.submit()">Add</button>
                </div>
            </div>
        </form>
    </div>

    {{-- product edit remodal --}}
    <div class="modal remodal" data-remodal-id="edit_product_modal">
        <div class="modal_heading">
            <h2 class="modal_title" id="edit_product">Edit Product</h2>
            <button data-remodal-action="close"><i class="fa-light fa-times"></i></button>
        </div>
        <form class="modal__form" action="{{ route('manager.recipe.update') }}" method="POST" >
            @csrf
            @method('PATCH')
            <input type="hidden" name="id" id="recipe_id">
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Item Name</label>
                    <input type="text" name="recipe_name" id="recipe_name" oninput="updateButton()" class="input" placeholder="e.g. Biryani 1:3" required>
                </div>
                @error('recipe_name')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Category</label>
                    <select name="category" id="recipe_category" oninput="updateButton()" class="input recipe_category" required>
                        <option value="" disabled selected>Select or Create Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                @error('category')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal_input_group_wrapper" style="position: relative; z-index: 0;">
                <div class="modal__input__group">
                    <div class="modal__input__field">
                        <label class="modal__input__label">Price (BDT)</label>
                        <input type="number" name="price" id="recipe_price" oninput="updateButton()" class="input" placeholder="Price">
                    </div>
                    @error('price')
                    <p class="input-error">{{ $message }}</p>
                    @enderror
                    <div class="modal__input__field">
                        <label class="modal__input__label">VAT(%)</label>
                        <input type="number" name="VAT" id="recipe_VAT" oninput="updateButton()" class="input" placeholder="e.g: 5 (optional)">
                        {{-- <i class="modal_input_icon fa-regular fa-percent"></i> --}}
                    </div>
                    @error('VAT(%)')
                        <p class="input-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="modal__input__group modal__button_group">
                    <button data-remodal-action="cancel" class="btn-sm">Cancel</button>
                    <button type="submit" id="edit_submit" class="btn-sm" onclick="this.form.submit()">Update</button>
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
    tomSelect = new TomSelect('#add_category', {
        create: true,
        maxItems: 1,
    });
    tomSelect2 = new TomSelect('#recipe_category', {
        create: true,
        maxItems: 1,
    });

    function editProduct(recipe){
        //modal.open();
        //remove btn-primary class from update button
        $('#edit_submit').removeClass('btn-primary');
        $('#edit_product').text('Edit Item: '+recipe.recipe_name);
        $('#recipe_id').val(recipe.id);
        $('#recipe_name').val(recipe.recipe_name);
        tomSelect2.clear();
        tomSelect2.addItem(recipe.category);
        $('#recipe_price').val(recipe.price);
        $('#recipe_VAT').val(recipe.VAT);
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

