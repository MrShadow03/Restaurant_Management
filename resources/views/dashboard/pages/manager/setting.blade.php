@section('title')
<title>Profile | {{ auth()->user()->name }}</title>
@endsection
@extends('dashboard.app')
@section('main')
    <x-sidebar/>
    <div class="right_content" data-simplebar>
        <x-navbar />
        <div class="table_box table-xs">
            <div class="table-wrapper">
                <h1 class="text-title-alt text-primary pb-2 border-bottom">Settings & Profile</h1>
                    <div class="menu_wrapper">
                        <form class="item_wrapper item-wrapper--profile" action="{{ route('manager.setting.update') }}" method="POST">
                            @csrf
                            <div class="item_left">
                                <div class="item_content w-100">
                                    <p class="text-md-alt text-primary pb-1">Business Details</p>
                                    <p class="text-sm-alt text-orange">Update Business Information</p>
                                    <p class="text-sm-alt text-primary pb-1 op-6">These informations are used throughout the software (e.g Invoice & UI)</p>
                                    <div class="modal__form modal__form--profile">
                                        <div class="modal__input__group">
                                            <div class="modal__input__field">
                                                <input type="text" oninput="changeButtonStyle(this ,'business_details_button')" name="name" class="input" placeholder="Business name" value="{{ $business_details->name }}" required>
                                                @error('name')
                                                    <p class="input-error">{{ $message }}</p>
                                                @enderror
                                            </div> 
                                        </div>
                                        <div class="modal__input__group">
                                            <div class="modal__input__field">
                                                <input type="text" oninput="changeButtonStyle(this ,'business_details_button')" name="phone_number" class="input" placeholder="Phone number" value="{{ $business_details->phone_number }}" required>
                                                <i class="modal_input_icon fa-solid fa-phone"></i>
                                            </div>
                                        </div>
                                        <div class="modal__input__group">
                                            <div class="modal__input__field">
                                                <input type="text" oninput="changeButtonStyle(this ,'business_details_button')" name="address" class="input" placeholder="Address"  value="{{ $business_details->address }}" required>
                                                <i class="modal_input_icon fa-solid fa-location-dot"></i>
                                            </div>
                                        </div>
                                        <div class="modal__input__group">
                                            <div class="modal__input__field">
                                                <input type="email" oninput="changeButtonStyle(this ,'business_details_button')" name="email" class="input" placeholder="Email (optional)" value="{{ $business_details->email ?? ''}}">
                                                <i class="modal_input_icon fa-solid fa-envelope"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item_right">
                                <button id="business_details_button" type="submit" class="mt-1 btn-sm btn-disabled"><i class="fa-solid fa-save"></i> &nbsp; Save</button>
                            </div>
                        </form>
                        <form class="item_wrapper item-wrapper--profile" onsubmit="checkPassword(event)" action="{{ route('manager.profile.update') }}" method="POST" style="padding: 1.5rem 0;">
                            @csrf
                            <div class="item_left">
                                <div class="item_content w-100">
                                    <p class="text-md-alt text-primary pb-1">Password and Security</p>
                                    <p class="text-sm-alt text-orange">Change Username and Password</p>
                                    <p class="text-sm-alt text-primary pb-1 op-6">Provide username and password to change</p>
                                    <div class="modal__form modal__form--profile">
                                        <div class="modal__input__group">
                                            <div class="modal__input__field">
                                                <input type="text" name="name" oninput="changeButtonStyle(this ,'profile_button')" class="input" placeholder="Username" value="{{ auth()->user()->name }}" required>
                                                <i class="modal_input_icon fa-solid fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="modal__input__group">
                                            <div class="modal__input__field">
                                                <input type="password" id="password" pattern="^(?!\s)[\S]{8,}$" name="password" oninput="changeButtonStyle(this ,'profile_button')" class="input" placeholder="New password" required>
                                                <i class="modal_input_icon fa-solid fa-key"></i>
                                            </div>
                                        </div>
                                        <div class="modal__input__group">
                                            <div class="modal__input__field">
                                                <input type="password" id="password_confirmation" pattern="^(?!\s)[\S]{8,}$" name="password_confirmation" oninput="confirmPasswordMatch(this.value, 'password')" class="input" placeholder="Re-type password" required>
                                                <p id="password_error" class="input_error d-none">Passwords Doesn't Match</p>
                                                <i class="modal_input_icon fa-solid fa-key"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item_right">
                                <button id="profile_button" type="submit" class="mt-1 btn-sm btn-disabled"><i class="fa-solid fa-save"></i> &nbsp; Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
        </form>
    </div>

@endsection

@section('exclusive_scripts')
<script>
    function changeButtonStyle(input, button_id){
        if(input.value.length > 0){
            document.getElementById(button_id).classList.remove('btn-disabled');
            document.getElementById(button_id).classList.add('btn-primary');
        }else{
            document.getElementById(button_id).classList.remove('btn-primary');
            document.getElementById(button_id).classList.add('btn-disabled');
        }
    }

    function confirmPasswordMatch(confirmedPassword, password_id){
        let password_error = document.getElementById('password_error');
        let password = document.getElementById(password_id).value;
        if(confirmedPassword != password){
            password_error.classList.remove('d-none');
        }else{
            password_error.classList.add('d-none');
        }
    }

    function checkPassword(event){
        event.preventDefault();
        let password_error = document.getElementById('password_error');
        let password = document.getElementById('password').value;
        let password_confirmation = document.getElementById('password_confirmation').value;
        if(password != password_confirmation){
            toastr.error('Passwords Doesn\'t Match');
            password_error.classList.remove('d-none');
        }else{
            event.target.submit();
        }
    }
</script>
@endsection

