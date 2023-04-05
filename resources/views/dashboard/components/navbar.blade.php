@php
    $user = Auth::user();
    //see user image exists or not
    if (!Storage::disk('public')->exists($user->image)) {
        $user_image = 'https://ui-avatars.com/api/?name='.$user->name.'&color=7F9CF5&background=EBF4FF&size=256&font-size=0.33&bold=true';
    }else{
        $user_image = asset('storage/'.$user->image);
    }
@endphp
@props(['search'])
<div class="top_head">
    <div class="bars sidebar_control_button">
        <i class="fa-solid fa-bars fa-beat"></i>
    </div>
    @if (isset($search))
        <div class="search"><input class="search_input" type="text"><i class="las la-search"></i></div>
    @endif
    <div class="social_link">
        <div class="message"><i class="fa-regular fa-bell"></i></div>
        <div class="profile">
            <img class="profile_img" src="{{ $user_image }}" alt="img">
            <div class="profile_area">
                <div class="img_area">
                    <img src="{{ $user_image }}" alt="img">
                    <div class="img_text">
                        <p>{{Auth::user()->name ?? 'John Doe' }}</p>
                        <p>{{ Auth::user()->email ?? 'the_doe' }}</p>
                    </div>
                </div>
                <div class="profile_sub_item">
                    <i class="fa-regular fa-circle-user"></i>
                    <a href="#">Profile</a>
                </div>
                <div class="profile_sub_item">
                    <i class="fa-regular fa-bell"></i>
                    <a href="#">Notices</a>
                </div>
                <div class="profile_sub_item">
                    <i class="fa-regular fa-gear"></i>
                    <a href="#">Settings</a>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="profile_sub_item" onclick="event.preventDefault(); this.closest('form').submit();">
                    @csrf
                    <i class="fa-regular fa-power-off"></i>
                    <a href="#" >Logout</a>
                </form>
            </div>
        </div>
    </div>                
</div>