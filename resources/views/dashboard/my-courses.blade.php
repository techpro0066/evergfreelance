@extends('dashboard')

@section('title', 'My Courses - EverGreen Freelancing')

@section('css')
    <style>
        /* User Courses Page Specific Styles */
        .user-courses-section {
            padding: 2rem 0;
        }
        
        .page-header {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .page-title {
            color: #333;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            color: #666;
            font-size: 0.95rem;
        }
        
        .stats-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-left: 4px solid #339CB5;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            margin-bottom: 1rem;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .course-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
        }
        
        .course-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        .course-image {
            width: 100%;
            height: 200px;
            object-fit: fill;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        }
        
        .course-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(51, 156, 181, 0.9);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }
        
        .course-content {
            padding: 1.5rem;
        }
        
        .course-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }
        
        .course-description {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .course-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #e9ecef;
        }
        
        .course-category {
            background: #e9ecef;
            color: #495057;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .course-progress {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #666;
        }
        
        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            margin: 1rem 0;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #339CB5, #2a7a8f);
            border-radius: 4px;
            transition: width 0.3s ease;
        }
        
        .course-actions {
            display: flex;
            gap: 0.75rem;
        }
        
        .btn-course {
            flex: 1;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-continue {
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            color: white;
        }
        
        .btn-continue:hover {
            background: linear-gradient(135deg, #2a7a8f, #1f5f6f);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(51, 156, 181, 0.3);
            color: white;
        }
        
        .btn-view {
            background: #f8f9fa;
            color: #495057;
            border: 2px solid #e9ecef;
        }
        
        .btn-view:hover {
            background: #e9ecef;
            color: #495057;
            transform: translateY(-2px);
        }
        
        .filter-section {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .filter-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .filter-label {
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
        }
        
        .filter-select {
            padding: 0.5rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            background: white;
            color: #495057;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            min-width: 150px;
        }
        
        .filter-select:focus {
            border-color: #339CB5;
            box-shadow: 0 0 0 0.2rem rgba(51, 156, 181, 0.25);
            outline: none;
        }
        
        .search-box {
            position: relative;
            flex: 1;
            min-width: 250px;
        }
        
        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            border-color: #339CB5;
            box-shadow: 0 0 0 0.2rem rgba(51, 156, 181, 0.25);
            outline: none;
        }
        
        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 1rem;
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .empty-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: #6c757d;
        }
        
        .empty-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .empty-description {
            color: #666;
            margin-bottom: 2rem;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .btn-browse {
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-browse:hover {
            background: linear-gradient(135deg, #2a7a8f, #1f5f6f);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(51, 156, 181, 0.3);
            color: white;
        }
        
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .user-courses-section {
                padding: 1rem 0;
            }
            
            .page-header {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .stats-overview {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 1rem;
                margin-bottom: 1.5rem;
            }
            
            .stat-card {
                padding: 1rem;
            }
            
            .stat-number {
                font-size: 1.5rem;
            }
            
            .courses-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .filter-section {
                padding: 1rem;
                margin-bottom: 1.5rem;
            }
            
            .filter-controls {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }
            
            .filter-group {
                width: 100%;
            }
            
            .filter-select {
                width: 100%;
                min-width: auto;
            }
            
            .search-box {
                min-width: auto;
            }
            
            .course-actions {
                flex-direction: column;
            }
            
            .btn-course {
                width: 100%;
            }
        }
        
        @media (max-width: 576px) {
            .page-header {
                padding: 1rem;
            }
            
            .page-title {
                font-size: 1.3rem;
            }
            
            .stats-overview {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .stat-card {
                padding: 0.75rem;
            }
            
            .stat-icon {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
            
            .stat-number {
                font-size: 1.3rem;
            }
            
            .course-content {
                padding: 1rem;
            }
            
            .course-title {
                font-size: 1.1rem;
            }
            
            .empty-state {
                padding: 2rem 1rem;
            }
            
            .empty-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
            
            .empty-title {
                font-size: 1.3rem;
            }
        }
        
        /* Animation for course cards */
        .course-card {
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Staggered animation for multiple cards */
        .course-card:nth-child(1) { animation-delay: 0.1s; }
        .course-card:nth-child(2) { animation-delay: 0.2s; }
        .course-card:nth-child(3) { animation-delay: 0.3s; }
        .course-card:nth-child(4) { animation-delay: 0.4s; }
        .course-card:nth-child(5) { animation-delay: 0.5s; }
        .course-card:nth-child(6) { animation-delay: 0.6s; }
    </style>
@endsection

@section('content')
<div class="main-content">
    <!-- Topbar -->
    @include('dashboard.components.header')

    <main class="page-content">
        <div class="user-courses-section">
            <div class="container-fluid">

                <!-- Courses Grid -->
                <div class="courses-grid" id="coursesGrid">
                    @foreach($buyCourses as $buyCourse)
                        <div class="course-card" data-category="programming" data-status="in-progress">
                            <img src="{{asset($buyCourse->course->thumbnail)}}" alt="{{$buyCourse->course->title}}" class="course-image">
                            <div class="course-content">
                                <h3 class="course-title">{{$buyCourse->course->title}}</h3>
                                <p class="course-description">{{$buyCourse->course->header}}</p>
                                <div class="course-actions">
                                    <a href="{{ route('dashboard.my.courses.show', $buyCourse->course->slug) }}" class="btn-course btn-continue">
                                        <i class="fas fa-play"></i>
                                        Open
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Empty State (Hidden by default) -->
                <div class="empty-state" id="emptyState" style="display: none;">
                    <div class="empty-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="empty-title">No courses found</h3>
                    <p class="empty-description">It looks like you don't have any courses matching your current filters. Try adjusting your search criteria or browse our course catalog.</p>
                    <a href="../courses.html" class="btn-browse">
                        <i class="fas fa-search"></i>
                        Browse Courses
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection