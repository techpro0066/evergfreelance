@extends('dashboard')

@section('title', 'Profile - EverGreen Freelancing')
@section('css')
<style>
    .profile-section {
        padding: 2rem 0;
    }
    
    .profile-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .profile-header {
        background: linear-gradient(135deg, #339CB5, #2a7a8f);
        color: white;
        padding: 2rem;
        text-align: center;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.3);
        margin: 0 auto 1rem;
        overflow: hidden;
        position: relative;
    }
    
    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .avatar-edit {
        position: absolute;
        bottom: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        border: none;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .avatar-edit:hover {
        background: rgba(0, 0, 0, 0.9);
        transform: scale(1.1);
    }
    
    .profile-name {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .profile-role {
        opacity: 0.9;
        font-size: 0.9rem;
    }
    
    .profile-body {
        padding: 2rem;
    }
    
    .form-section {
        margin-bottom: 2rem;
    }
    
    .form-section h4 {
        color: #333;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f0f0f0;
        font-weight: 600;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #555;
        margin-bottom: 0.5rem;
    }
    
    .form-control {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #339CB5;
        box-shadow: 0 0 0 0.2rem rgba(51, 156, 181, 0.25);
    }
    
    .password-field {
        position: relative;
    }
    
    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #6c757d;
        cursor: pointer;
        font-size: 1.1rem;
    }
    
    .password-toggle:hover {
        color: #339CB5;
    }
    
    .btn-update {
        background: linear-gradient(135deg, #339CB5, #2a7a8f);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-update:hover {
        background: linear-gradient(135deg, #2a7a8f, #1f5f6f);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(51, 156, 181, 0.3);
        color: white;
    }
    
    .btn-cancel {
        background: #6c757d;
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-right: 1rem;
    }
    
    .btn-cancel:hover {
        background: #5a6268;
        transform: translateY(-2px);
        color: white;
    }
    
    .alert {
        border-radius: 8px;
        border: none;
    }
    
    .alert-success {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
    }
    
    .alert-danger {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
    }
    
    .back-btn {
        background: none;
        border: none;
        color: #339CB5;
        font-size: 1.1rem;
        padding: 0.5rem;
        border-radius: 50%;
        transition: all 0.3s ease;
        margin-right: 1rem;
    }
    
    .back-btn:hover {
        background: rgba(51, 156, 181, 0.1);
        color: #2a7a8f;
    }
    
    @media (max-width: 768px) {
        .profile-header {
            padding: 1.5rem;
        }
        
        .profile-body {
            padding: 1.5rem;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
        }
    }
</style>
@endsection
@section('content')
<div class="main-content">
    @include('dashboard.components.header')
    <main class="page-content">
        <div class="profile-section">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xl-6">
                        <div class="profile-card">
                            <!-- Profile Header -->
                            <div class="profile-header">
                                <div class="profile-avatar">
                                    <img src="{{asset('portal/images/user.png')}}" alt="Profile Picture" id="profileImage">
                                </div>
                                <div class="profile-name" id="displayName">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</div>
                                <div class="profile-role">{{ucfirst(auth()->user()->role)}}</div>
                            </div>
                            
                            <!-- Profile Body -->
                            <div class="profile-body">
                                <!-- Alert Messages -->
                                <div id="alertContainer"></div>
                                
                                <!-- Personal Information Form -->
                                <div class="form-section">
                                    <h4><i class="fas fa-user-edit me-2"></i>Personal Information</h4>
                                    <form id="personalInfoForm" method="POST" action="{{route('profile.update')}}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="firstName" class="form-label">First Name</label>
                                                    <input type="text" class="form-control" id="firstName" name="firstName" value="{{auth()->user()->first_name ?? old('firstName')}}">
                                                    @error('firstName')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lastName" class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" id="lastName" name="lastName" value="{{auth()->user()->last_name ?? old('lastName')}}">
                                                    @error('lastName')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{auth()->user()->email ?? old('email')}}" readonly style="pointer-events: none; background-color: #f0f0f0;">
                                            <small class="text-muted">Email address cannot be changed</small>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-update">
                                                <i class="fas fa-save me-2"></i>Update Information
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- Password Change Form -->
                                <div class="form-section">
                                    <h4><i class="fas fa-lock me-2"></i>Change Password</h4>
                                    <form id="passwordForm" method="POST" action="{{route('profile.changePassword')}}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="currentPassword" class="form-label">Current Password</label>
                                            <div class="password-field">
                                                <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}">
                                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="newPassword" class="form-label">New Password</label>
                                            <div class="password-field">
                                                <input type="password" class="form-control" id="new_password" name="new_password">
                                                <button type="button" class="password-toggle" onclick="togglePassword('new_password')">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                                @error('new_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                            <div class="password-field">
                                                <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password">
                                                <button type="button" class="password-toggle" onclick="togglePassword('confirm_new_password')">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                                @error('confirm_new_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-update">
                                                <i class="fas fa-key me-2"></i>Change Password
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts')
    @if(session('success'))
        <script>
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": 3000,
            }
            toastr.success("{{session('success')}}", "Success");
        </script>
    @endif
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