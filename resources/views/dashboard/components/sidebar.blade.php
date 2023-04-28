@php
    $business_details = App\Models\BusinessInformation::first();
    //split the business name from the first space
    $business_name = explode(' ', $business_details->name);
@endphp
<div class="left_nevbar">
    <div class="side_bar">
        <div class="header">                    
            <div class="logo">
                {{-- <img src="{{ asset('dashboard/img/logo.png') }}" alt=""> --}}
                <p class="ml-2 op-9 text-yellow fw-500 fs-16">
                    <i class="fa-duotone fa-fork-knife"></i>
                    <span class="fs-14 fw-600" style="text-transform:uppercase; letter-spacing: 1px; margin-left: 1rem;">{{ $business_name[0] }}</span>
                    <span class="fs-14 fw-300 text-white" style="text-transform:uppercase; letter-spacing: 1px;">{{ $business_name[1] ?? '' }}</span>
                </p>
            </div>
            <div class="menu_bars">
                <i class="menu-cross fa-solid fa-times"></i>
            </div>                                       
        </div>
        {{-- sidebar menu starts here --}}
        <ul class="nav_area mt-2">
            {{-- sidebar for students --}}
            @if (Auth::user()->role == 'admin')
            <li><a href="#"><i class="menu_icon fa-light fa-chart-mixed"></i>Dashboard</a></li>
            <li><a href="{{ route('admin.inventory') }}"><i class="menu_icon fa-regular fa-box-circle-check"></i></i>Inventory</a></li>
            @elseif (Auth::user()->role == 'manager')
            <li><a href="{{ route('manager.dashboard') }}"><i class="menu_icon fa-regular fa-chart-mixed"></i></i>Dashboard</a></li>
            <li><a href="{{ route('manager.table') }}"><i class="menu_icon fa-light fa-grid-2"></i></i>Tables</a></li>
            <li><a href="{{ route('manager.staff') }}"><i class="menu_icon fa-light fa-user"></i>Staff</a></li>
            <li><a href="{{ route('manager.inventory') }}"><i class="menu_icon fa-light fa-box-circle-check"></i></i>Inventory</a></li>
            <li><a href="{{ route('manager.recipe') }}"><i class="menu_icon fa-light fa-burger-soda"></i></i>Food Items</a></li>
            <li><a href="{{ route('manager.setting') }}"><i class="fa-duotone fa-gear menu_icon"></i>Settings</a></li>
            @elseif (Auth::user()->role == 'staff')
            <li><a href="{{ route('staff.table') }}"><i class="menu_icon fa-light fa-grid-2"></i></i>Tables</a></li>
            @elseif (Auth::user()->role == 'kitchen_staff')
            <li><a href="{{ route('kitchen_staff.recipe') }}"><i class="menu_icon fa-light fa-grid-2"></i></i>Food Items</a></li>
            <li><a href="{{ route('kitchen_staff.order') }}"><i class="menu_icon fa-light fa-burger-soda"></i></i>Orders</a></li>
            @endif
        </ul>
    </div>
</div>