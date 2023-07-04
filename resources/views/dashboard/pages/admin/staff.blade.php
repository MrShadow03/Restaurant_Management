@section('title')
<title>Staff Control | Manager</title>
@endsection
@extends('dashboard.app')
@section('main')
    <x-sidebar/>
    <div class="right_content" data-simplebar>
        <x-navbar />
        <div class="heading">
            <h2 class="heading__title text-title">Staff Management</h2>
            <div class="heading__left">
                <a href="#add_product" class="btn-sm btn-primary"><i class="fa-solid fa-user"></i>&nbsp; Add Staff</a>
                <audio src="{{ asset('dashboard/audio/order_recieved2.mp3') }}" controls class="d-none" id="order_recieved_sound"></audio>
            </div>
        </div>
        <div>
            <div class="table_box">
                <div class="table-wrapper">
                    <table class="w-100 data-table">
                        <thead>
                            <tr class="heading-row">
                                <th class="heading-column">Name</th>
                                <th class="heading-column">Phone</th>
                                <th class="heading-column">Status</th>
                                <th class="heading-column"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staff as $person)
                                <tr class="table-row">
                                    <td class="table-column">
                                        <div class="table-column__wrapper">
                                            <div class="table-column__image">
                                                <img src="{{ asset('dashboard/img/staff/staff_default.png') }}" class="item_image item_image_md" alt="">
                                            </div>
                                            <div class="table-column__content">
                                                <h3 class="table-column__title table-column__product">{{ $person->name ?? '' }}</h3>
                                                <h3 class="table-column__subtitle">{{ ucwords(str_replace('_', ' ', $person->role)) ?? '' }}</h3>
                                                <p class="table-column__status mt-half"><i class="fa-solid fa-circle-small" style="{{ $person->status ? 'color: #43A047;' : 'color: #dc3545' }}"></i>{{ $person->status ? "Active" : "Inactive" }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table-column">
                                        <div class="table-column__wrapper">
                                            <div class="table-column__content">
                                                <p class="table-column__title">{{ $person->phone_number }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table-column">
                                        <div class="table-column__wrapper">
                                            <div class="table-column__content">
                                                <form class="switch" action="{{ route('admin.staff.toggle_status') }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="id" value={{ $person->id }}>
                                                    <input class="tgl tgl-ios" id="toggle_status{{ $person->id }}" name="status" type="checkbox" {{ $person->status ? 'checked' : '' }} onchange="this.form.submit()"/>
                                                    <label class="tgl-btn" for="toggle_status{{ $person->id }}"></label>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table-column">
                                        <div class="table-column__wrapper">
                                            <div class="table-column__content">
                                                <a href="#edit_product_modal" title="Edit product" class="btn-sm" onclick="editProduct({{ json_encode($person) }})">Edit</a>
                                                <a href="{{ route('admin.staff.destroy', $person->id) }}" title="Delete product" class="btn-sm" onclick="return confirm('This Will Delete this product')" ><i class="fa-regular fa-trash"></i></a>
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
            <h2 class="modal_title"><i class="fa-regular fa-user"></i> &nbsp; Add new staff</h2>
            <button data-remodal-action="close"><i class="fa-light fa-times"></i></button>
        </div>
        <form class="modal__form" action="{{ route('admin.staff.store') }}" method="POST" >
            @csrf
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Name</label>
                    <input type="text" name="name" class="input" placeholder="e.g. Abdur Rahman" required>
                </div>
                @error('name')
                    <p class="input-error">{{ $message }}</p>
                @enderror
                <div class="modal__input__field">
                    <label class="modal__input__label">Role</label>
                    <select name="role" class="input" required>
                        <option selected disabled>Role</option>
                        <option value="staff">Staff</option>
                        <option value="kitchen_staff">Kitchen Staff</option>
                    </select>
                </div>
                @error('role')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Phone</label>
                    <input type="text" name="phone_number" class="input" placeholder="e.g. 01712345678" pattern="01[3-9]\d{8}" title="Enter 11 digit valid phone number" required>
                    <i class="modal_input_icon fa-solid fa-phone"></i>
                </div>
                @error('phone_number')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Email</label>
                    <input type="email" name="email" class="input" placeholder="Email (Optional)">
                    <i class="modal_input_icon fa-solid fa-envelope"></i>
                </div>
                @error('email')
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
        <form class="modal__form" action="{{ route('admin.staff.update') }}" method="POST" >
            @csrf
            @method('PATCH')
            <input type="hidden" name="id" id="staff_id">
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Name</label>
                    <input type="text" name="name" class="input" oninput="updateButton()" id="name" placeholder="e.g. Abdur Rahman" required>
                </div>
                @error('name')
                    <p class="input-error">{{ $message }}</p>
                @enderror
                <div class="modal__input__field">
                    <label class="modal__input__label">Role</label>
                    <select name="role" class="input" oninput="updateButton()" id="role" required>
                        <option selected disabled>Role</option>
                        <option value="manager">Manager</option>
                        <option value="staff">Staff</option>
                        <option value="kitchen_staff">Kitchen Staff</option>
                    </select>
                </div>
                @error('role')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Phone</label>
                    <input type="text" name="phone_number" id="phone_number" class="input" oninput="updateButton()" placeholder="e.g. 01712345678" pattern="01[3-9]\d{8}" title="Enter 11 digit valid phone number" required>
                    <i class="modal_input_icon fa-solid fa-phone"></i>
                </div>
                @error('phone_number')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal__input__group">
                <div class="modal__input__field">
                    <label class="modal__input__label">Email</label>
                    <input type="email" name="email" id="email" class="input" oninput="updateButton()" placeholder="Email (Optional)">
                    <i class="modal_input_icon fa-solid fa-envelope"></i>
                </div>
                @error('email')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="modal__input__group modal__button_group">
                <button data-remodal-action="cancel" class="btn-sm">Cancel</button>
                <button type="submit" id="edit_submit" class="btn-sm" onclick="this.form.submit()">Update</button>
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

