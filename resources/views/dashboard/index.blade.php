@extends('dashboard')

@section('title', 'Dashboard - EverGreen Freelancing')

@section('content')
<div class="main-content">
    <!-- Topbar -->
    @include('dashboard.components.header')

    <!-- Page Content -->
    <main class="page-content">
        <!-- Dashboard Section -->
        <div id="dashboard-section" class="content-section active">
            <div class="row">
                <!-- Stats Cards -->
                @if(auth()->user()->role == 'admin')
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number">{{ $users - 1 }}</h3>
                                <p class="stat-label">Total Users</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number">{{ $courses }}</h3>
                                <p class="stat-label">Total Courses</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-xl-3 col-md-6 mb-4">
                        <a href="{{ route('front.courses') }}" class="text-decoration-none">
                            <div class="stat-card" style="cursor: pointer;">
                                <div class="stat-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div class="stat-content">
                                    <h3 class="stat-number">{{ $courses }}</h3>
                                    <p class="stat-label">Buy Courses</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
@endsection