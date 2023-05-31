@section('title')
<title>Inventory | Manager</title>
@endsection
@extends('dashboard.app')
@section('main')
    <x-sidebar/>
    <div class="right_content" data-simplebar>
        <x-navbar />
        <div class="heading">
            <h2 class="heading__title text-title">Products</h2>
            <div class="heading__left">
                <a href="#add_product" class="btn btn-primary">Add New <i class="fa-regular fa-square-plus"></i></a>
            </div>
        </div>
        <div>
            <div class="table_box">
                <div class="table-wrapper">
                    <table class="w-100 data-table">
                        <thead>
                            <tr class="heading-row">
                                <th class="heading-column">Product</th>
                                <th class="heading-column">Unit Price (BDT)</th>
                                <th class="heading-column">Total Expense</th>
                                <th class="heading-column">Last added</th>
                                <th class="heading-column"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="table-row">
                                    <td class="table-column">
                                        <div class="table-column__wrapper">
                                            <div class="table-column__image">
                                                <img src="{{ asset('dashboard/img/food/default.png') }}" alt="">
                                            </div>
                                            <div class="table-column__content">
                                                <h3 class="table-column__title table-column__product">{{ $product->product_name }}</h3>
                                                <p class="table-column__subtitle">{{ $product->available_units }} {{ $product->measurement_unit }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table-column">
                                        <div class="table-column__wrapper">
                                            <div class="table-column__content">
                                                <h3 class="table-column__title">{{ round($product->unit_cost) }}</h3>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table-column">
                                        <div class="table-column__wrapper">
                                            <div class="table-column__content">
                                                <h3 class="table-column__title">{{ $product->total_cost }}</h3>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table-column">
                                        <div class="table-column__wrapper">
                                            <div class="table-column__content">
                                                <h3 class="table-column__title">{{ $product->created_at->diffForHumans() }}</h3>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table-column">
                                        <div class="table-column__wrapper">
                                            <div class="table-column__content">
                                                <a href="#subtract_product_model" class="btn-sm" onclick="subtractProduct({{ json_encode($product) }})"><i class="fa-regular fa-minus"></i></a>
                                                <a href="#add_product_modal" class="btn-sm" onclick="addProduct({{ json_encode($product) }})"><i class="fa-regular fa-plus"></i></a>
                                                <a href="#edit_product_modal" title="Edit product" class="btn-sm" onclick="editProduct({{ json_encode($product) }})">Edit</a>
                                                <a href="{{ route('manager.inventory.destroy', $product->id) }}" title="Delete product" class="btn-sm" onclick="return confirm('This Will Delete this product')" ><i class="fa-regular fa-trash"></i></a>
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
    <div class="modal remodal" data-remodal-id="add_product" data-remodal-options="confirmOnEnter: true">
        <div class="modal_heading">
            <h2 class="modal_title">Add New Product</h2>
            <button data-remodal-action="close"><i class="fa-light fa-times"></i></button>
        </div>
        <form class="modal__form" action="{{ route('manager.inventory.store') }}" method="POST" >
            @csrf
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Product Name</label>
                    <input type="text" name="product_name" class="input" placeholder="Product Name" required>
                </div>
                @error('product_name')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Quantity</label>
                    <input type="number" step=".001" name="quantity" class="input" placeholder="Quantity">
                </div>
                @error('quantity')
                    <p class="input-error">{{ $message }}</p>
                @enderror
                <div class="modal__input__field">
                    <label class="modal__input__label">Unit</label>
                    <select name="measurement_unit" class="input" required>
                        <option value="" disabled selected>Measurement</option>
                        <option value="kg">kg</option>
                        <option value="ltr">ltr</option>
                        <option value="pcs">pcs</option>
                    </select>
                </div>
                @error('measurement_unit')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label" >Total Price (BDT)</label>
                    <input type="number" step=".01" name="total_cost" class="input" placeholder="Total Price" required>
                </div>
                @error('total_cost')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal__input__group modal__button_group">
                <button data-remodal-action="cancel" class="btn-sm">Cancel</button>
                <button type="submit" class="btn-sm btn-primary" onclick="this.form.submit()">Add</button>
            </div>
        </form>
    </div>

    {{-- product edit remodal --}}
    <div class="modal remodal" data-remodal-id="edit_product_modal" data-remodal-options="confirmOnEnter: true">
        <div class="modal_heading">
            <h2 class="modal_title" id="edit_product">Edit Product</h2>
            <button data-remodal-action="close"><i class="fa-light fa-times"></i></button>
        </div>
        <form class="modal__form" action="{{ route('manager.inventory.update') }}" method="POST" >
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="product_id">
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label" for="Product Name">Product Name</label>
                    <input type="text" name="product_name" id="product_name" class="input" placeholder="Product Name" oninput="updateButton()" required>
                </div>
                @error('product_name')
                    <p class="input-error">{{ $message }}</p>
                @enderror
                <div class="modal__input__field">
                    <label for="measurement_unit" class="modal__input__label">Unit</label>
                    <select name="measurement_unit" id="measurement_unit" class="input" oninput="updateButton()" required>
                        <option value="" disabled selected>Measurement</option>
                        <option value="kg">kg</option>
                        <option value="ltr">ltr</option>
                        <option value="pcs">pcs</option>
                    </select>
                </div>
                @error('measurement_unit')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal__input__group modal__button_group">
                <button data-remodal-action="cancel" class="btn-sm">Cancel</button>
                <button type="submit" id="edit_submit" class="btn-sm" onclick="this.form.submit()">Update</button>
            </div>
        </form>
    </div>
    
    <div class="modal remodal" data-remodal-id="add_product_modal" data-remodal-options="confirmOnEnter: true">
        <div class="modal_heading">
            <h2 class="modal_title" id="add_edit_product">Edit Product</h2>
            <button data-remodal-action="close"><i class="fa-light fa-times"></i></button>
        </div>
        <form class="modal__form" action="{{ route('manager.inventory.add') }}" method="POST" >
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="add_product_id">
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Quantity</label>
                    <input type="number" step=".001" name="quantity" class="input" id="add_quantity" placeholder="Quantity">
                </div>
                @error('quantity')
                    <p class="input-error">{{ $message }}</p>
                @enderror
                <div class="modal__input__field">
                    <label class="modal__input__label" >Total Price (BDT)</label>
                    <input type="number" step=".01" name="total_cost" class="input" id="add_total_cost" placeholder="Total Price" required>
                </div>
                @error('total_cost')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal__input__group modal__button_group">
                <button data-remodal-action="cancel" class="btn-sm">Cancel</button>
                <button type="submit" class="btn-sm btn-primary" onclick="this.form.submit()">Update</button>
            </div>
        </form>
    </div>
    
    <div class="modal remodal" data-remodal-id="subtract_product_model" data-remodal-options="confirmOnEnter: true">
        <div class="modal_heading">
            <h2 class="modal_title" id="subtract_edit_product">Edit Product</h2>
            <button data-remodal-action="close"><i class="fa-light fa-times"></i></button>
        </div>
        <form class="modal__form" action="{{ route('manager.inventory.subtract') }}" method="POST" >
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="subtract_product_id">
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Quantity</label>
                    <input type="number" step=".001" name="quantity" class="input" id="subtract_quantity" placeholder="Quantity">
                </div>
                @error('quantity')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal__input__group modal__button_group">
                <button data-remodal-action="cancel" class="btn-sm">Cancel</button>
                <button type="submit" class="btn-sm btn-primary" onclick="this.form.submit()">Update</button>
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
        });
    })(jQuery);
    function editProduct(product){
        //modal.open();
        //remove btn-primary class from update button
        $('#edit_submit').removeClass('btn-primary');
        $('#edit_product').text('Edit product details: '+product.product_name);
        $('#product_id').val(product.id);
        $('#product_name').val(product.product_name);
        $('#quantity').val(product.available_units);
        $('#measurement_unit').val(product.measurement_unit);
        $('#total_cost').val(product.total_cost);
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

