@php
    use Illuminate\Support\Facades\DB;
    $business_details = App\Models\BusinessInformation::first();
    //split the business name from the first space
    $business_name = explode(' ', $business_details->name);

    //check for insufficient stock
    $insufficient_stock = App\Models\Inventory::where('available_units', '<=', DB::raw('warning_unit'))->count();

    //check for today's and tomorrow's planner
    $today_planner = App\Models\Plan::where('date', date('Y-m-d'))->count();
    $tomorrow_planner = App\Models\Plan::where('date', date('Y-m-d', strtotime('+1 day')))->count();

    $isAnyPlanEmpty = $today_planner && $tomorrow_planner;

@endphp
<div class="left_sidebar left_sidebar--expanded" id="sidebar">
    <div class="side_bar">
        <div class="header">
            <div class="logo">
                {{-- <img src="{{ asset('dashboard/img/logo.png') }}" alt=""> --}}
                <p class="op-9 text-yellow fw-500 fs-16">
                    <i class="fa-duotone fa-fork-knife"></i>
                    <span class="fs-14 fw-600 hidden-on-collapse"
                        style="text-transform:uppercase; letter-spacing: 1px; margin-left: 2rem;">{{ $business_name[0] }}</span>
                    <span class="fs-14 fw-300 text-white hidden-on-collapse"
                        style="text-transform:uppercase; letter-spacing: 1px;">{{ $business_name[1] ?? '' }}</span>
                </p>
            </div>
            <div class="menu_bars hidden-on-collapse">
                <i class="menu-cross fa-regular fa-arrow-left"></i>
            </div>
        </div>

        {{-- sidebar menu starts here --}}
        <ul class="nav_area mt-2">
            {{-- sidebar for students --}}
            @if (Auth::user()->role == 'admin')
                <li class="{{ 'manager/dashboard' == request()->path() ? 'sidebar-link--active' : '' }}"><a
                        class="menu__link" href="{{ route('admin.dashboard') }}"><i
                            class="menu_icon fa-regular fa-chart-mixed"></i>
                        <p class="sidebar-link-name hidden-on-collapse">Dashboard</p>
                    </a></li>
                <li class="{{ 'manager/staff' == request()->path() ? 'sidebar-link--active' : '' }}"><a
                        class="menu__link" href="{{ route('admin.staff') }}"><i
                            class="menu_icon fa-duotone fa-user"></i>
                        <p class="sidebar-link-name hidden-on-collapse">Staff</p>
                    </a></li>
                <li class="{{ str_contains(request()->path(), 'manager/report') ? 'sidebar-link--active' : '' }}"><a
                        class="menu__link toggle_btn" href="#"><i class="fa-duotone fa-chart-pie menu_icon"></i>
                        <p class="sidebar-link-name hidden-on-collapse">Reporting</p><i
                            class="sub_icon fa-regular fa-chevron-down hidden-on-collapse"></i>
                    </a>
                    <ul class="sub_menu {{ str_contains(request()->path(), 'manager/report') ? 'active' : '' }}"
                        style="{{ str_contains(request()->path(), 'manager/report') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{ 'manager/report/products' == request()->path() ? 'submenu__link--active' : '' }}"
                                href="{{ route('admin.report.products') }}"><i
                                    class="fa-duotone fa-message-dollar"></i>
                                <p class="sidebar-link-name hidden-on-collapse">Product Report</p>
                            </a></li>
                        <li><a class="{{ 'manager/report/sales' == request()->path() ? 'submenu__link--active' : '' }}"
                                href="{{ route('admin.report.sales') }}"><i class="fa-duotone fa-graduation-cap"></i>
                                <p class="sidebar-link-name hidden-on-collapse">Sales</p>
                            </a></li>
                        {{-- <li><a class="{{ 'manager/report/activities' == request()->path() ? 'submenu__link--active' : '' }}" href="#"><i class="fa-duotone fa-trash-can-clock"></i></i>Wastes</a></li> --}}
                    </ul>
                </li>
            @elseif (Auth::user()->role == 'manager')
                <li class="{{ 'manager/dashboard' == request()->path() ? 'sidebar-link--active' : '' }}"><a
                        class="menu__link" href="{{ route('manager.dashboard') }}"><i
                            class="menu_icon fa-regular fa-chart-mixed"></i>
                        <p class="sidebar-link-name hidden-on-collapse">Dashboard</p>
                    </a></li>
                <li class="{{ 'manager/table' == request()->path() ? 'sidebar-link--active' : '' }}"><a
                        class="menu__link" href="{{ route('manager.table') }}"><i
                            class="menu_icon fa-duotone fa-grid-2"></i>
                        <p class="sidebar-link-name hidden-on-collapse">Tables</p>
                    </a></li>
                <li class="{{ 'manager/staff' == request()->path() ? 'sidebar-link--active' : '' }}"><a
                        class="menu__link" href="{{ route('manager.staff') }}"><i
                            class="menu_icon fa-duotone fa-user"></i>
                        <p class="sidebar-link-name hidden-on-collapse">Staff</p>
                    </a></li>
                <li class="{{ 'manager/inventory' == request()->path() ? 'sidebar-link--active' : '' }} {{ $insufficient_stock ? 'notification-head-icon notification-head-danger' : '' }}"><a
                        class="menu__link" href="{{ route('manager.inventory') }}"><i
                            class="menu_icon fa-duotone fa-box-circle-check"></i>
                        <p class="sidebar-link-name hidden-on-collapse">Inventory</p>
                    </a></li>
                <li class="{{ 'manager/recipe' == request()->path() ? 'sidebar-link--active' : '' }}"><a
                        class="menu__link" href="{{ route('manager.recipe') }}"><i
                            class="menu_icon fa-duotone fa-burger-soda"></i>
                        <p class="sidebar-link-name hidden-on-collapse">Food Items</p>
                    </a></li>
                <li class="{{ 'manager/menu_planner' == request()->path() ? 'sidebar-link--active' : '' }} {{ $isAnyPlanEmpty == 0 ? 'notification-head-icon notification-head-danger' : '' }}"><a
                        class="menu__link" href="{{ route('manager.menu_planner') }}"><i
                            class="menu_icon fa-duotone fa-list-dropdown"></i>
                        <p class="sidebar-link-name hidden-on-collapse">Menu Planner</p>
                    </a></li>
                <li class="{{ str_contains(request()->path(), 'manager/report') ? 'sidebar-link--active' : '' }}"><a
                        class="menu__link toggle_btn" href="#"><i class="fa-duotone fa-chart-pie menu_icon"></i>
                        <p class="sidebar-link-name hidden-on-collapse">Reporting</p><i
                            class="sub_icon fa-regular fa-chevron-down hidden-on-collapse"></i>
                    </a>
                    <ul class="sub_menu {{ str_contains(request()->path(), 'manager/report') ? 'active' : '' }}"
                        style="{{ str_contains(request()->path(), 'manager/report') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{ 'manager/report/products' == request()->path() ? 'submenu__link--active' : '' }}"
                                href="{{ route('manager.report.products') }}"><i
                                    class="fa-duotone fa-message-dollar"></i>
                                <p class="sidebar-link-name hidden-on-collapse">Product Report</p>
                            </a></li>
                        <li><a class="{{ 'manager/report/sales' == request()->path() ? 'submenu__link--active' : '' }}"
                                href="{{ route('manager.report.sales') }}"><i class="fa-duotone fa-graduation-cap"></i>
                                <p class="sidebar-link-name hidden-on-collapse">Sales</p>
                            </a></li>
                        {{-- <li><a class="{{ 'manager/report/activities' == request()->path() ? 'submenu__link--active' : '' }}" href="#"><i class="fa-duotone fa-trash-can-clock"></i></i>Wastes</a></li> --}}
                    </ul>
                </li>
                <li class="{{ 'manager/setting' == request()->path() ? 'sidebar-link--active' : '' }}"><a
                        class="menu__link" href="{{ route('manager.setting') }}"><i
                            class="fa-duotone fa-gear menu_icon"></i>
                        <p class="sidebar-link-name hidden-on-collapse">Settings</p>
                    </a></li>
            @elseif (Auth::user()->role == 'staff')
                <li class="{{ 'staff/table' == request()->path() ? 'sidebar-link--active' : '' }}"><a
                        class="menu__link" href="{{ route('staff.table') }}"><i
                            class="menu_icon fa-duotone fa-grid-2"></i>
                        <p class="sidebar-link-name hidden-on-collapse">Tables</p>
                    </a></li>
            @elseif (Auth::user()->role == 'kitchen_staff')
                <li class="{{ 'kitchen_staff/recipe' == request()->path() ? 'sidebar-link--active' : '' }}"><a
                        class="menu__link" href="{{ route('kitchen_staff.recipe') }}"><i
                            class="menu_icon fa-duotone fa-grid-2"></i>
                        <p class="sidebar-link-name hidden-on-collapse">Food Items</p>
                    </a></li>
                <li class="{{ 'kitchen_staff/order' == request()->path() ? 'sidebar-link--active' : '' }}"><a
                        class="menu__link" href="{{ route('kitchen_staff.order') }}"><i
                            class="menu_icon fa-duotone fa-burger-soda"></i>
                        <p class="sidebar-link-name hidden-on-collapse">Orders</p>
                    </a></li>
                <li class="{{ 'kitchen_staff/menu_planner' == request()->path() ? 'sidebar-link--active' : '' }}"><a
                        class="menu__link" href="{{ route('kitchen_staff.menu_planner') }}"><i
                            class="menu_icon fa-light fa-list-dropdown"></i>
                        <p class="sidebar-link-name hidden-on-collapse">Menu Planner</p>
                    </a></li>
            @endif
        </ul>
    </div>
</div>
