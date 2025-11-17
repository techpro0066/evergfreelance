<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('front/assets/images/logo.png') }}" alt="logo" class="logo">
            <span>EverGreen Freelancing</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="fas fa-bars menu-icon"></i>
            <i class="fas fa-times close-icon"></i>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about-us') ? 'active' : '' }}" href="{{ route('front.about.us') }}">About Us</a> 
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('courses') ? 'active' : (request()->is('courses/*') ? 'active' : '') }}" href="{{ route('front.courses') }}">Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('faq') ? 'active' : '' }}" href="{{ route('front.faq') }}">FAQ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ route('front.contact') }}">Contact</a>
                </li>
            </ul>
            
            <div class="navbar-nav">
                @auth
                    <a href="{{ route('front.checkout') }}" class="cart-btn {{ count(session()->get('cart', [])) > 0 ? '' : 'd-none' }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Cart</span>
                        <span class="cart-count">{{ count(session()->get('cart', [])) }}</span>
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary me-2">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-register">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>