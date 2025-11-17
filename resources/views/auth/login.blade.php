{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
@extends('layouts.auth')

@section('title', 'Login - EverGreen Freelancing')

@section('styles')
<style>
    /* Login Section Restructure */
    .login-section {
        padding-top: 100px;
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    .login-container {
        width: 100%;
    }

    .login-row {
        display: flex;
        align-items: stretch;
        margin: 0;
        min-height: 700px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border-radius: 20px;
        overflow: hidden;
    }

    .login-col {
        flex: 1;
        padding: 0;
        display: flex;
    }

    /* Image Container */
    .image-container {
        position: relative;
        height: 100%;
        width: 100%;
        border-radius: 20px 0 0 20px;
        overflow: hidden;
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
        background-image: url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
        background-size: cover;
        background-position: center;
        animation: slideInLeft 1s ease-out;
    }

    /* Form Container */
    .form-container {
        background: var(--white);
        padding: 3rem 2.5rem;
        border-radius: 0 20px 20px 0;
        border: 1px solid rgba(0, 0, 0, 0.1);
        animation: slideInRight 1s ease-out 0.2s both;
        position: relative;
        overflow: hidden;
        height: 100%;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* Form Controls with Rounded Corners */
    .form-control {
        border-radius: 25px !important;
        padding: 0.875rem 1rem 0.875rem 3rem !important;
        border: 2px solid #e9ecef !important;
        transition: all 0.3s ease !important;
    }

    .form-control:focus {
        border-color: #505F3B !important;
        box-shadow: 0 0 0 3px rgba(80, 95, 59, 0.1) !important;
    }

    .input-group {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #505F3B;
        z-index: 10;
        pointer-events: none;
        font-size: 1.1rem;
    }

    .form-control:focus + .input-icon {
        color: #505F3B;
    }

    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #6C757D;
        cursor: pointer;
        z-index: 10;
        font-size: 1.1rem;
    }

    .password-toggle:hover {
        color: #505F3B;
    }

    /* Blue Button Styles */
    .btn-register-submit {
        background: #339CB5 !important;
        border: none !important;
        color: white !important;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(51, 156, 181, 0.3);
    }

    .btn-register-submit:hover {
        background: #2a7a8f !important;
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(51, 156, 181, 0.4);
    }

    .btn-register-submit:focus {
        background: #2a7a8f !important;
        border: none !important;
        color: white !important;
        box-shadow: 0 0 0 0.2rem rgba(51, 156, 181, 0.25);
    }

    /* Enhanced Forgot Password Link */
    .forgot-password-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #339CB5;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
        transition: all 0.3s ease;
        background: rgba(51, 156, 181, 0.1);
        border: 1px solid transparent;
    }

    .forgot-password-link:hover {
        color: #2a7a8f;
        background: rgba(51, 156, 181, 0.15);
        border-color: rgba(51, 156, 181, 0.2);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(51, 156, 181, 0.2);
        text-decoration: none;
    }

    .forgot-password-link:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(51, 156, 181, 0.15);
    }

    .forgot-password-link i {
        font-size: 0.8rem;
        transition: transform 0.3s ease;
    }

    .forgot-password-link:hover i {
        transform: rotate(-10deg);
    }

    /* Mobile Responsive */
    @media (max-width: 991.98px) {
        .login-row {
            flex-direction: column;
            min-height: auto;
        }

        .image-container {
            display: none;
        }

        .form-container {
            border-radius: 20px;
            height: auto;
            min-height: auto;
        }
    }

    @media (max-width: 767.98px) {
        .login-section {
            padding-top: 80px;
        }

        .form-container {
            padding: 2rem 1.5rem;
        }
    }

    @media (max-width: 575.98px) {
        .login-section {
            padding-top: 70px;
        }

        .form-container {
            padding: 1.5rem 1rem;
            border-radius: 15px;
        }
    }
</style>
@endsection

@section('content')
<section class="login-section m-5">
    <div class="login-container">
        <div class="login-row">
            <!-- Left Column - Image -->
            <div class="login-col">
                <div class="image-container">
                    <div class="image-overlay"></div>
                    <div class="image-content">
                        <h2 class="image-title">Welcome Back</h2>
                        <p class="image-subtitle">Continue your journey to becoming a successful freelancer</p>
                        <div class="features-list">
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Access your courses</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Track your progress</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Connect with community</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Get expert support</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Login Form -->
            <div class="login-col">
                <div class="form-container">
                    <div class="form-header">
                        <h1 class="form-title">Sign In to Your Account</h1>
                        <p class="form-subtitle">Welcome back! Please enter your details</p>
                    </div>
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="login-form" id="loginForm" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email">
                            </div>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                </div>
                                <a href="{{ route('password.request') }}" class="forgot-password-link">
                                    <i class="fas fa-key"></i>
                                    <span>Forgot password?</span>
                                </a>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-register-submit" style="background: #339CB5; border: none; color: white; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(51, 156, 181, 0.3);">
                            <span class="btn-text">Sign In</span>
                            <span class="btn-icon">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </button>
                    </form>

                    <div class="login-link">
                        <p>Don't have an account? <a href="{{ route('register') }}" class="login-link-text">Register here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Toggle password visibility
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const toggleBtn = field.parentNode.querySelector('.password-toggle');
        const icon = toggleBtn.querySelector('i');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection