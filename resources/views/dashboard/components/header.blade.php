<header class="topbar">
    <div class="topbar-left">
        <button id="mobileSidebarToggle" class="mobile-sidebar-toggle d-lg-none">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="page-title">{{ request()->is('dashboard') ? 'Dashboard' : (request()->is('admin/courses') ? 'Courses' : (request()->is('admin/courses/module/*') ? 'Modules' : (request()->is('dashboard/mycourses') ? 'My Courses' : 'Profile'))) }}</h1>
    </div>
    
    <div class="topbar-right">
        <div class="topbar-actions">
            <div class="user-dropdown">
                <button class="user-avatar" id="userDropdownToggle">
                    <img src="{{asset('portal/images/user.png')}}" alt="Admin User" class="avatar-img">
                </button>
                
                <div class="dropdown-menu" id="userDropdown">
                    <a href="{{ route('profile') }}" class="dropdown-item {{ request()->is('profile') ? 'active' : '' }}">
                        <i class="fas fa-user"></i>
                        Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="#" class="dropdown-item logout-item" onclick="this.closest('form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>