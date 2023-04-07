@section('title')
<title>Admin-Teacher</title>
@endsection
@extends('dashboard.app')
@section('main')
    <x-sidebar/>
    <div class="right_content">
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
                                <td class="heading-column text-title-column">Product</td>
                                <th class="heading-column text-title-column">Unit Price</th>
                                <th class="heading-column text-title-column">Last added</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="table-row">
                                    <td class="table-column">
                                        <div class="table-column__wrapper">
                                            <div class="table-column__image">
                                                <img src="{{ asset('backend/img/teacher.png') }}" alt="">
                                            </div>
                                            <div class="table-column__content">
                                                <h3 class="table-column__title">{{ $product->product_name }}</h3>
                                                <p class="table-column__subtitle">{{ $product->available_units }} {{ $product->measurement_unit }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table-column">
                                        <div class="table-column__wrapper">
                                            <div class="table-column__content">
                                                <h3 class="table-column__title">{{ $product->unit_cost }} BDT</h3>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal remodal" data-remodal-id="add_product">
        <div class="modal_heading">
            <h2 class="modal_title">Add New Product</h2>
            <button data-remodal-action="close"><i class="fa-light fa-times"></i></button>
        </div>
        <form class="modal__form" action="{{ route('manager.inventory.store') }}" method="POST" >
            @csrf
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label" for="Product Name">Product Name</label>
                    <input type="text" name="product_name" id="product_name" class="input" placeholder="Product Name" required>
                </div>
                @error('product_name')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label for="quantity" class="modal__input__label">Quantity</label>
                    <input type="number" step=".001" name="quantity" id="quantity" class="input" placeholder="Quantity">
                </div>
                @error('quantity')
                    <p class="input-error">{{ $message }}</p>
                @enderror
                <div class="modal__input__field">
                    <label for="measurement_unit" class="modal__input__label">Unit</label>
                    <select name="measurement_unit" id="measurement_unit" class="input" required>
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
                    <label class="modal__input__label" for="Unit Price">Unit Price (BDT)</label>
                    <input type="number" step=".01" name="unit_cost" id="unit_cost" class="input" placeholder="Unit Price" required>
                </div>
                @error('unit_cost')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal__input__group modal__button_group">
                <button data-remodal-action="cancel" class="btn-sm">Cancel</button>
                <button type="submit" class="btn-sm btn-primary" onclick="this.form.submit()">Add</button>
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
</script>
@endsection

