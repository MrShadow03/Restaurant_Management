@section('title')
<title>Admin-Login</title>
@endsection
@extends('dashboard.app')
@section('exclusive_styles')
@endsection
@section('main')
<div class="right_content">
    @props(['title','input_type','input_name'])
    <div class="login_box">
        <div class="login_title">
            <img src="{{ asset('/dashboard/img/logo.png') }}" alt="">
        </div>
        @error('email')
        <div class="text-center mt-2">
            <p class="badge badge-danger">{{ $message }}</p>
        </div>
        @enderror
        <p class="text-center text-primary font-inter text-sm-alt op-5">Welcome to Restaurant Inc</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="input_single">
                <label class="input_title animate_label" for="emailOrPhone">Phone</label>
                <input name="emailOrPhone" type="text"
                placeholder="Phone Number"class="input animate_input" value="{{ old('emailOrPhone') }}" required/>
                <i title="e.g: 01712345678" class="input-icon fa-solid fa-phone"></i>
            </div>
            <div class="input_single">
                <label class="input_title animate_label" for="password">Password</label>
                <input id="password" name="password" type="password" class="input animate_input"  placeholder="Password" required/>
                <i title="Toggle password view" class="input-icon fa-solid fa-eye" onmousedown="TogglePasswordView(this, 'password')" onmouseup="TogglePasswordView(this, 'password')"></i>
                @error('password')
                <p class="input_error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form_links">
                <a title="Forgot the password? Click this link." class="form_link" href="#">Forgot Password?</a>
            </div>                      
            <button class="btn btn-primary btn_submit w-100" type="submit">Login</button>
        </form>
        <p class="copyright_text text-center fs-10 mt-2 pt-2 text-primary op-5">&copy;2023 PepploBD All Rights Reserved</p>
    </div>
</div>
@endsection

@section('exclusive_scripts')
<script>
    defaultInputAnimation();
</script>
@endsection