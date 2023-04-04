<div class="left_nevbar">
    <div class="side_bar">
        <div class="header">                    
            <div class="logo">
                <img src="{{ asset('backend/img/logo.png') }}" alt="">
                <p class="ml-2 op-6 text-white fw-500 fs-16">School<span class="text-white fw-200">Management</span></p>
            </div>
            <div class="menu_bars">
                <i class="menu-cross fa-solid fa-times"></i>
            </div>                                       
        </div>
        {{-- sidebar menu starts here --}}
        <ul class="nav_area mt-2">
            {{-- sidebar for students --}}
            <li><a href="#"><i class="menu_icon fa-light fa-user"></i>Dashboard</a></li>
            <li><a href="#"><i class="menu_icon fa-light fa-calendar-days"></i>Routine</a></li>
            <li><a href="#"><i class="menu_icon fa-light fa-bell"></i>Results</a></li>
            <li><a href="#"><i class="menu_icon fa-light fa-book-alt"></i>Syllabus</a></li>
            <li><a href="#"><i class="menu_icon fa-light fa-calendar"></i>Calendar</a></li>
            <li><a class="toggle_btn" href="#"><i class="fa-duotone fa-gear menu_icon"></i>Settings & Permissions<i class="las sub_icon la-angle-down"></i></a>
                <ul class="sub_menu">
                    <li><a href="#"><i class="fa-light fa-user-unlock"></i>Result Permissions</a></li>
                    <li><a href="#"><i class="fa-light fa-gears"></i>Advance Settings</a></li>
                    <li><a href="#"><i class="fa-light fa-box-archive"></i>Archive</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>