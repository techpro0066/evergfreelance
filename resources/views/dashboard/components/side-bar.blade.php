
<nav id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <img src="{{asset('front/assets/images/logo.png')}}" alt="EverGreen Freelancing" class="logo">
            <span class="brand-text">EverGreen Freelancing</span>
        </div>
        <button id="sidebarToggle" class="sidebar-toggle d-lg-none">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <ul class="sidebar-nav">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" data-section="dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        @if(auth()->user()->role == 'admin')
            <li class="nav-item">
                <a href="{{ route('admin.courses') }}" class="nav-link {{ request()->is('admin/courses*') ? 'active' : '' }}" data-section="courses">
                    <i class="fas fa-book"></i>
                    <span>Courses</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users') }}" class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}" data-section="users">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
        @endif

        @if(auth()->user()->role == 'user' && auth()->user()->buyCourses->count() > 0)
            <li class="nav-item">
                <a href="{{ route('dashboard.my.courses') }}" class="nav-link {{ request()->is('dashboard/mycourses') ? 'active' : '' }}" data-section="my-courses">
                    <i class="fas fa-book"></i>
                    <span>My Courses</span>
                </a>
            </li>
        @endif
    </ul>
</nav>