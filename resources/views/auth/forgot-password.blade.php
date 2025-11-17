{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}


@extends('layouts.auth')

@section('title', 'Forgot Password - EverGreen Freelancing')

@section('styles')
    <style>
        /* Forgot Password Section Restructure */
        .forgot-password-section {
            padding-top: 100px;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .forgot-password-container {
            width: 100%;
        }

        .forgot-password-row {
            display: flex;
            align-items: stretch;
            margin: 0;
            min-height: 700px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            overflow: hidden;
        }

        .forgot-password-col {
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

        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .forgot-password-row {
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
            .forgot-password-section {
                padding-top: 80px;
            }

            .form-container {
                padding: 2rem 1.5rem;
            }
        }

        @media (max-width: 575.98px) {
            .forgot-password-section {
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
    <section class="forgot-password-section m-5">
        <div class="forgot-password-container">
            <div class="forgot-password-row">
                <!-- Left Column - Image -->
                <div class="forgot-password-col">
                    <div class="image-container">
                        <div class="image-overlay"></div>
                        <div class="image-content">
                            <h2 class="image-title">Reset Your Password</h2>
                            <p class="image-subtitle">Don't worry! It happens to the best of us. We'll help you get back to your account.</p>
                            <div class="features-list">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Quick and secure process</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Email verification</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Instant reset link</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>24/7 support available</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Forgot Password Form -->
                <div class="forgot-password-col">
                    <div class="form-container">
                        <div class="form-header">
                            <h1 class="form-title">Forgot Your Password?</h1>
                            <p class="form-subtitle">Enter your email address and we'll send you a link to reset your password</p>
                        </div>

                        <form class="forgot-password-form" id="forgotPasswordForm" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <x-auth-session-status class="mb-4 text-success" :status="session('status')" />
                            <div class="form-group mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address">
                                </div>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-register-submit" style="background: #339CB5; border: none; color: white; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(51, 156, 181, 0.3);">
                                <span class="btn-text">Send Reset Link</span>
                                <span class="btn-icon">
                                    <i class="fas fa-paper-plane"></i>
                                </span>
                            </button>
                        </form>

                        <div class="login-link">
                            <p>Remember your password? <a href="{{ route('login') }}" class="login-link-text">Sign in here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection