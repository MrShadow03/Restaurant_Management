@section('title')
<title>Food Menu | Manager</title>
@endsection
@extends('dashboard.app')
@section('main')
    <x-sidebar/>
    <div class="right_content" data-simplebar>
        <x-navbar />
        <div class="heading">
            <h2 class="heading__title text-title">Food Items</h2>
            <div class="heading__left">
                <a href="#add_product" class="btn-sm btn-primary"><i class="fa-solid fa-burger-soda"></i>&nbsp; Add Item</a>
                {{-- <audio src="{{ asset('dashboard/audio/order_recieved2.mp3') }}" controls class="d-none" id="order_recieved_sound"></audio>
                <audio src="{{ asset('dashboard/audio/ding.mp3') }}" controls class="d-none" id="order_recieved_sound2"></audio>
                <audio src="{{ asset('dashboard/audio/order_recieved1.mp3') }}" controls class="d-none" id="order_recieved_sound3"></audio> --}}
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
                                                <img src="{{ asset('dashboard/img/food/default.png') }}" class="item_image item_image_sm" alt="">
                                            </div>
                                            <div class="table-column__content">
                                                <p class="table-column__subtitle pt-0">{{ $recipe->category }}</p>
                                                <h3 class="table-column__title table-column__product">{{ $recipe->recipe_name ?? '' }}</h3>
                                                <p class="table-column__subtitle d-inline"><i class="fa-regular fa-bangladeshi-taka-sign"></i> {{ $recipe->price }} BDT</p>
                                                @if($recipe->discount > 0)
                                                <span class="badge badge-warning"><i class="fa-solid fa-fire"></i>&nbsp; {{ $recipe->discount }}% off</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table-column">
                                        <div class="table-column__wrapper">
                                            <div class="table-column__content">
                                                <p class="table-column__status" id="on_menu_status{{ $recipe->id }}"><i class="fa-solid fa-circle-small" style="{{ $recipe->on_menu ? 'color: #43A047;' : 'color: #dc3545' }}"></i> {{ $recipe->on_menu ? "On the menu" : "Not on the menu" }}</p>
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
                                                    <input class="tgl tgl-ios" id="toggle_on_menu{{ $recipe->id }}" name="on_menu" type="checkbox" {{ $recipe->on_menu ? 'checked' : '' }} onchange="toggleOnMenu(this, {{ $recipe->id }})"/>
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
        <form class="modal__form" action="{{ route('manager.recipe.store') }}" method="POST">
            @csrf
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Item Name</label>
                    <input type="text" name="recipe_name" class="input" placeholder="e.g. Biryani 1:3" required>
                    @error('recipe_name')
                        <p class="input-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label title="E.g. Biryani 1:3's parent is Biryani half" class="modal__input__label" for="toggle_has_parent">Does this item have any parent item?</label>
                    <input class="tgl tgl-ios" id="toggle_has_parent" name="has_parent" type="checkbox" onchange="toggleHasParent(this)"/>
                    <label class="tgl-btn" for="toggle_has_parent"></label>
                </div>
            </div>
            <div class="modal__input__group d-none" id="parent_group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Parent Item Name</label>
                    <select name="parent_item_id" class="input tom-select">
                        <option value="" disabled selected>Select Parent Item</option>
                        @foreach ($recipes as $recipe)
                        <option value="{{ $recipe->id }}">{{ $recipe->recipe_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal__input__field">
                    <label class="modal__input__label"><i class="fa-solid fa-users"></i> &nbsp; For People</label>
                    <input type="number" name="for_people" id="for_people" class="input" placeholder="3">
                    @error('for_people')
                        <p class="input-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="modal__input__group" id="category_group">
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
                        <label class="modal__input__label">Making cost</label>
                        <input type="number" id="production_cost" name="production_cost" class="input" placeholder="Price">
                    </div>
                    @error('production_cost')
                    <p class="input-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="modal__input__group">
                    <div class="modal__input__field">
                        <label class="modal__input__label">Discount(%)</label>
                        <input type="number" name="discount" class="input" placeholder="e.g: 5 (optional)">
                    </div>
                    @error('discount')
                        <p class="input-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="modal__input__section" id="ingredient_section">
                    <h3 class="modal__input__section__title"><i class="fa-light fa-wheat"></i> &nbsp; Select Ingredients</h3>
                    <div class="modal__input__section__content" id="ingredients_input_wrapper">
                        <div class="modal__input__group" id="ingredient_input0" data-nth-child="0">
                            <div class="modal__input__field">
                                <select id="ingredient0" name="ingredient[0]['name']" class="lan-ban input tom-select" onchange="getMeasurementUnit(0, this.value, {{ json_encode($ingredients) }})" placeholder="Select Ingredient">
                                    <option value="" disabled selected>Select Ingredient</option>
                                    @foreach ($ingredients as $ingredient)
                                        <option value="{{ $ingredient->product_name }}">{{ $ingredient->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal__input__field">
                                <input oninput="calculateProductionCost({{ json_encode($ingredients) }})" step=".01" id="measurement_unit_input0" type="number" name="ingredient[0]['quantity']" class="quantity_input input pl-4" placeholder="Amount">
                                <span class="modal_input_icon fw-500" id="quantity_icon0" style="top: 11px; left: 10px; width: fit-content;">{{ $ingredient->measurement_unit }}</span>
                            </div>
                            <button type="button" id="remove_ingredient" class="btn-icon btn-disabled"><i class="fa-regular fa-times"></i></button>
                        </div>
                    </div>
                    <div class="modal__input__section__footer mt-1">
                        <button type="button" class="btn-sm btn-primary" onclick="addIngredient({{ json_encode($ingredients) }})"><i class="fa-regular fa-grid-2-plus"></i> &nbsp; Add More</button>
                    </div>
                </div>

                <div class="modal__input__group modal__button_group">
                    <button data-remodal-action="cancel" class="btn-sm">Cancel</button>
                    <button type="submit" class="btn btn-primary" onclick="this.form.submit()">Add</button>
                </div>
            </div>
        </form>
    </div>

    {{-- product edit remodal --}}
    <div class="modal remodal" data-remodal-id="edit_product_modal" data-remodal-options="confirmOnEnter: true">
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
                <div class="modal__input__field">
                    <label class="modal__input__label">Price (BDT)</label>
                    <input type="number" name="price" id="recipe_price" oninput="updateButton()" class="input" placeholder="Price">
                </div>
                @error('price')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal_input_group_wrapper" style="position: relative; z-index: 0;">
                {{-- <div class="modal__input__group">
                    <div class="modal__input__field">
                        <label class="modal__input__label">VAT(%)</label>
                        <input type="number" name="VAT" id="recipe_VAT" oninput="updateButton()" class="input" placeholder="e.g: 5 (optional)">
                    </div>
                    @error('VAT(%)')
                        <p class="input-error">{{ $message }}</p>
                    @enderror
                </div> --}}
                <div class="modal__input__group">
                    <div class="modal__input__field">
                        <label class="modal__input__label" title="Total Cost to produce the product">Production Cost</label>
                        <input type="number" name="production_cost" id="recipe_production_cost" class="input" oninput="updateButton()" placeholder="e.g 200">
                    </div>
                    @error('production_cost')
                        <p class="input-error">{{ $message }}</p>
                    @enderror
                    <div class="modal__input__field">
                        <label class="modal__input__label">Discount(%)</label>
                        <input type="number" name="discount" id="recipe_discount" class="input" oninput="updateButton()" placeholder="e.g: 5 (optional)">
                    </div>
                    @error('discount')
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
    function getCost(recipes){
        let hasParent = document.getElementById('toggle_has_parent').checked;
        let parentItemId = document.getElementById('parent_item_id').value;
        let forPeople = document.getElementById('for_people').value;
        let priceInput = document.getElementById('price');
        let productionCostInput = document.getElementById('production_cost');

        if(hasParent && parentItemId && forPeople){
            let parentItem = recipes.find(recipe => recipe.id == parentItemId);
            priceInput.value = parentItem.price * forPeople;
            productionCostInput.value = parentItem.production_cost * forPeople;
        }
    }
    function addIngredient(ingredients){
        let ingredientsInputWrapper = document.getElementById('ingredients_input_wrapper');
        // get the last ingredient input group
        let lastIngredienInputGroup = ingredientsInputWrapper.lastElementChild;
        // get the last ingredient data-nth-child value
        let lastGroupNumber = Number(lastIngredienInputGroup.dataset.nthChild)+1;

        let ingredient = document.createElement('div');
        ingredient.classList.add('modal__input__group');
        ingredient.id = `ingredient_input${lastGroupNumber}`;
        ingredient.dataset.nthChild = lastGroupNumber;

        // create an array to store the selected options
        let selectedOptions = [];

        // loop through all the previous ingredient inputs and add their selected options to the array
        for (let i = 0; i < lastGroupNumber; i++) {
            let selectElement = document.querySelector(`select[name="ingredient[${i}]['name']"]`);
            if (selectElement) {
                if (selectElement.value == ''){
                    toastr.error("Please select an ingredient first!");
                    return;
                }
                let selectedOption = selectElement.value;
                if (selectedOption) {
                    selectedOptions.push(selectedOption);
                }
            }
        }

        //filter the ingredients array to remove the selected options
        let filteredIngredients = ingredients.filter(ingredient => !selectedOptions.includes(ingredient.product_name));

        ingredient.innerHTML = `
            <div class="modal__input__field">
                <select id="ingredient_select${lastGroupNumber}" name="ingredient[${lastGroupNumber}]['name']" onchange="getMeasurementUnit(${lastGroupNumber}, this.value, {{ json_encode($ingredients) }})" class="input tom-select" required>
                    <option value="" disabled selected>Select Ingredient</option>
                    ${filteredIngredients.map(ingredient => `<option value="${ingredient.product_name}">${ingredient.product_name}</option>`).join('')}
                </select>
            </div>
            <div class="modal__input__field">
                <input oninput="calculateProductionCost({{ json_encode($ingredients) }})" type="number" step=".01" id="measurement_unit_input${lastGroupNumber}" name="ingredient[${lastGroupNumber}]['quantity']" class="quantity_input input pl-4" placeholder="Amount">
                <span class="modal_input_icon fw-500" id="quantity_icon${lastGroupNumber}" style="top: 11px; left: 10px; width: fit-content;">kg</span>
            </div>
            <button type="button" id="remove_ingredient${lastGroupNumber}" onclick="removeIngredient('ingredient_input${lastGroupNumber}', {{ json_encode($ingredients) }})" class="btn-icon btn-danger"><i class="fa-regular fa-times"></i></button>
        `;

        ingredientsInputWrapper.appendChild(ingredient);

        // get the new select element
        let newSelect = document.getElementById(`ingredient_select${lastGroupNumber}`);
        // initialize tom select
        let settings = {
            create: true,
            maxItems: 1,
        };
        new TomSelect(newSelect,settings);
    }
    function removeIngredient(ingredientId, ingredients){
        let ingredient = document.getElementById(ingredientId);
        ingredient.remove();

        calculateProductionCost(ingredients);
    }
    function getMeasurementUnit(nthChild, ingredientName, ingredients){
        let measurementUnitInput = document.querySelector(`#measurement_unit_input${nthChild}`);
        let measurementUnit = ingredients.find(ingredient => ingredient.product_name == ingredientName).measurement_unit;
        let quantityIcon = document.querySelector(`#quantity_icon${nthChild}`);
        
        quantityIcon.innerHTML = measurementUnit;

        calculateProductionCost(ingredients);
    }
    function toggleHasParent(checkBox){
        let parentGroup = document.getElementById('parent_group');
        let categoryGroup = document.getElementById('category_group');
        let ingredientSection = document.getElementById('ingredient_section');
        let addCategorySelect = document.getElementById('add_category');
        if (checkBox.checked){
            parentGroup.classList.remove('d-none');
            categoryGroup.classList.add('d-none');
            addCategorySelect.required = false;
            ingredientSection.classList.add('d-none');
        }else{
            parentGroup.classList.add('d-none');
            categoryGroup.classList.remove('d-none');
            addCategorySelect.required = true;
            ingredientSection.classList.remove('d-none');
        }
    }
    function calculateProductionCost(ingredients){
        let ingredientsInputWrapper = document.getElementById('ingredients_input_wrapper');
        let productionCostInput = document.getElementById('production_cost');
        
        let totalCost = 0;
        // for each child of the ingredients input wrapper get the ingredient name and quantity
        for (let i = 0; i < ingredientsInputWrapper.children.length; i++) {
            let child = ingredientsInputWrapper.children[i];

            
            let ingredientName = child.querySelector('select').value;
            let ingredientQuantity = Number(child.querySelector('.quantity_input').value);
            
            // console.log(child.querySelector('.quantity_input'));
            // console.log(ingredientName, ingredientQuantity);

            // if the ingredient name and quantity are not empty
            if (ingredientName && ingredientQuantity) {
            // get the ingredient object from the ingredients array
            let ingredient = ingredients.find(ingredient => ingredient.product_name == ingredientName);
            
            // calculate the ingredient cost
            let ingredientUnitCost = Math.round(ingredient.unit_cost);
            let ingredientCost = (ingredientQuantity) * ingredientUnitCost;

            console.log(ingredientQuantity + 'x' + ingredientUnitCost + '=' + ingredientCost);
            // add the ingredient cost to the total cost
            totalCost += ingredientCost;

            productionCostInput.value = Math.round(totalCost);
            }
        }
    }
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
        $('#recipe_discount').val(recipe.discount);
        $('#recipe_production_cost').val(recipe.production_cost);
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
    function toggleOnMenu(element, recipeId){
        let base_url = window.location.origin;
        axios.post(base_url + '/manager/recipe/toggleOnMenu', {
            id: recipeId,
        })
        .then(function (response) {
            data = response.data;
            console.log(data);
            if(data.onMenu){
                document.getElementById('toggle_on_menu' + recipeId).checked = true;
                toastr.success(data.recipeName+" is now available!");
                let onMenuStatusParent = document.getElementById('on_menu_status' + recipeId);
                if(onMenuStatusParent){
                    onMenuStatusParent.innerHTML = `<i class="fa-solid fa-circle-small" style="color: #43A047;"></i> On the menu`;
                }
            }else{
                document.getElementById('toggle_on_menu' + recipeId).checked = false;
                toastr.warning(data.recipeName+" is now unavailable!");
                let onMenuStatusParent = document.getElementById('on_menu_status' + recipeId);
                if(onMenuStatusParent){
                    onMenuStatusParent.innerHTML = `<i class="fa-solid fa-circle-small" style="color: #dc3545;"></i> Not on the menu`;
                }
            }
        })
        .catch(function (error) {
            console.log(error);
            toastr.error("Something went wrong!");
        });
    }
    document.querySelectorAll('.tom-select').forEach((el)=>{
        let settings = {
            create: true,
            maxItems: 1,
        };
        new TomSelect(el,settings);
    });
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

</script>
@endsection

