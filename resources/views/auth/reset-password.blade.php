{{-- <x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}


@extends('layouts.auth')

@section('title', 'Reset Password - EverGreen Freelancing')

@section('content')
    <style>
        /* Reset Password Section Restructure */
        .reset-password-section {
            padding-top: 100px;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .reset-password-container {
            width: 100%;
        }

        .reset-password-row {
            display: flex;
            align-items: stretch;
            margin: 0;
            min-height: 700px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            overflow: hidden;
        }

        .reset-password-col {
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

        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .reset-password-row {
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
            .reset-password-section {
                padding-top: 80px;
            }

            .form-container {
                padding: 2rem 1.5rem;
            }
        }

        @media (max-width: 575.98px) {
            .reset-password-section {
                padding-top: 70px;
            }

            .form-container {
                padding: 1.5rem 1rem;
                border-radius: 15px;
            }
        }
    </style>

    <section class="reset-password-section m-5">
        <div class="reset-password-container">
            <div class="reset-password-row">
                <!-- Left Column - Image -->
                <div class="reset-password-col">
                    <div class="image-container">
                        <div class="image-overlay"></div>
                        <div class="image-content">
                            <h2 class="image-title">Create New Password</h2>
                            <p class="image-subtitle">Choose a strong password to keep your account secure</p>
                            <div class="features-list">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Secure password reset</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Quick and easy process</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Instant account access</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>24/7 support available</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Reset Password Form -->
                <div class="reset-password-col">
                    <div class="form-container">
                        <div class="form-header">
                            <h1 class="form-title">Set New Password</h1>
                            <p class="form-subtitle">Create a strong password for your account</p>
                        </div>

                        <form class="reset-password-form" id="resetPasswordForm" method="POST" action="{{ route('password.store') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <input type="hidden" name="email" value="{{ $request->email }}">
                            <div class="form-group mb-3">
                                <label for="newPassword" class="form-label">New Password</label>
                                <div class="input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="newPassword" name="password" placeholder="Enter your new password">
                                    <button type="button" class="password-toggle" onclick="togglePassword('newPassword')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" placeholder="Confirm your new password">
                                    <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-register-submit" style="background: #339CB5; border: none; color: white; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(51, 156, 181, 0.3);">
                                <span class="btn-text">Reset Password</span>
                                <span class="btn-icon">
                                    <i class="fas fa-key"></i>
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