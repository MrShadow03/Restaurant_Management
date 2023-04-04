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
            <img src="{{ asset('/backend/img/logo.png') }}" alt="">
            <h2>Portal Login</h2>
        </div>
        @error('email')
        <div class="text-center mt-2">
            <p class="badge badge-danger">{{ $message }}</p>
        </div>
        @enderror
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="input_single">
                <label class="input_title animate_label" for="email_or_phone">Email or Phone</label>
                <input name="email" type="text"
                placeholder="Email or Phone"class="input animate_input" value="{{ old('email_or_phone') }}" required/>
                <i title="example@mail.com" class="input-icon fa-solid fa-envelope"></i>
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