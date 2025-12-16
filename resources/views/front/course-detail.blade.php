@extends('layouts.front')

@section('title', 'Course Detail | EverGreen Freelancing')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        /* Hero Section */
        .course-hero {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
            padding: 120px 0 60px;
            position: relative;
            overflow: hidden;
        }

        .course-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover;
            opacity: 0.1;
            z-index: 1;
        }

        .course-hero-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        .course-breadcrumb {
            margin-bottom: 2rem;
        }

        .course-breadcrumb a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .course-breadcrumb a:hover {
            color: white;
        }

        .course-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .course-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .course-meta {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
        }

        .meta-item i {
            font-size: 1.2rem;
        }

        /* Course Content */
        .course-content {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .course-container {
            max-width: 1200px;
            margin: 0 auto;
        }

                .course-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 3rem;
        }

        /* Main Content */
        .main-content {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 1.5rem;
        }

        .course-detail-description {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #6c757d;
            margin-bottom: 2rem;
        }

        /* What You'll Learn */
        .learning-objectives {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .learning-list {
            list-style: none;
            padding: 0;
        }

        .learning-list li {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 1rem;
            color: #495057;
        }

        .learning-list li i {
            color: #28a745;
            font-size: 1.2rem;
            margin-top: 0.2rem;
        }

        /* Curriculum */
        .curriculum-section {
            margin-bottom: 2rem;
        }

        .curriculum-item {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .curriculum-header {
            background: #f8f9fa;
            padding: 1.5rem;
            cursor: pointer;
            transition: background 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .curriculum-header:hover {
            background: #e9ecef;
        }

        .curriculum-title {
            font-weight: 600;
            color: var(--primary-dark);
            margin: 0;
        }

        .curriculum-duration {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .curriculum-content {
            padding: 1.5rem;
            border-top: 1px solid #e9ecef;
            display: none;
        }

        .curriculum-content.show {
            display: block;
        }

        .lesson-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f8f9fa;
        }

        .lesson-item:last-child {
            border-bottom: none;
        }

        .lesson-title {
            font-weight: 500;
            color: #495057;
        }

        .lesson-duration {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Instructor */
        .instructor-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .instructor-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .instructor-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }

        .instructor-details h4 {
            margin: 0 0 0.5rem 0;
            color: var(--primary-dark);
        }

        .instructor-title {
            color: #339CB5;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .instructor-stats {
            display: flex;
            gap: 1rem;
            font-size: 0.9rem;
            color: #6c757d;
        }

        /* Reviews */
        .reviews-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .review-item {
            border-bottom: 1px solid #e9ecef;
            padding: 1.5rem 0;
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .reviewer-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .reviewer-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .reviewer-name {
            font-weight: 600;
            color: var(--primary-dark);
        }

        .review-date {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .review-rating {
            color: #ffd700;
        }

        .review-text {
            color: #495057;
            line-height: 1.6;
        }

        /* Floating Cart Button */
        .floating-cart-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 15px 25px;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 8px 25px rgba(51, 156, 181, 0.3);
            z-index: 1000;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .floating-cart-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(51, 156, 181, 0.4);
        }
        
        .floating-cart-btn.remove-state:hover {
            box-shadow: 0 12px 35px rgba(220, 53, 69, 0.4);
        }

        .floating-cart-btn .price {
            font-size: 1.2rem;
            font-weight: 700;
        }

        .floating-cart-btn .original-price {
            text-decoration: line-through;
            font-size: 0.9rem;
            opacity: 0.8;
            margin-right: 5px;
        }

        .floating-cart-btn .current-price {
            color: #fff;
        }

        .floating-cart-btn .cart-icon {
            font-size: 1.3rem;
        }

        /* Purchased Course Button */
        .floating-cart-btn.purchased-course-btn {
            background: linear-gradient(135deg, #28a745, #20c997);
            cursor: pointer;
        }

        .floating-cart-btn.purchased-course-btn:hover {
            background: linear-gradient(135deg, #218838, #1ea080);
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(40, 167, 69, 0.4);
        }

        .purchased-cart {
            background: #28a745 !important;
            color: white !important;
            cursor: pointer;
        }

        .purchased-cart:hover {
            background: #218838 !important;
        }

                /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .course-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .floating-cart-btn {
                bottom: 20px;
                right: 20px;
                padding: 12px 20px;
                font-size: 1rem;
            }

            .course-title {
                font-size: 2.5rem;
            }

            .course-meta {
                flex-direction: column;
                gap: 1rem;
            }
        }

        @media (max-width: 767.98px) {
            .course-hero {
                padding: 100px 0 40px;
            }

            .course-title {
                font-size: 2rem;
            }

            .main-content {
                padding: 2rem;
            }

            .instructor-info {
                flex-direction: column;
                text-align: center;
            }
        }

                /* ===== SIMPLE & CLEAN COURSE DESCRIPTION STYLING ===== */
        
        /* Simple Course Description Styling */
        .course-detail-description {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #495057;
            margin-bottom: 2rem;
            background: #ffffff;
            padding: 2rem;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        .course-detail-description:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            transition: all 0.3s ease;
        }

        /* Course Description Typography */
        .course-detail-description p {
            margin-bottom: 1.2rem;
            color: #495057;
        }

        .course-detail-description p:last-child {
            margin-bottom: 0;
        }

        .course-detail-description strong {
            color: #339CB5;
            font-weight: 600;
        }

        .course-detail-description em {
            color: #6c757d;
            font-style: italic;
        }

        /* Course Description Links */
        .course-detail-description a {
            color: #339CB5;
            text-decoration: none;
            font-weight: 500;
            border-bottom: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .course-detail-description a:hover {
            color: #2a7a8f;
            border-bottom-color: #2a7a8f;
        }

        /* Course Description Lists */
        .course-detail-description ul,
        .course-detail-description ol {
            margin: 1.2rem 0;
            padding-left: 1.5rem;
        }

        .course-detail-description li {
            margin-bottom: 0.6rem;
            line-height: 1.6;
            color: #495057;
        }

        .course-detail-description ul li {
            list-style-type: none;
            position: relative;
        }

        .course-detail-description ul li::before {
            content: '✓';
            color: #28a745;
            font-weight: bold;
            position: absolute;
            left: -1.5rem;
            font-size: 1rem;
        }

        /* Course Description Blockquotes */
        .course-detail-description blockquote {
            background: #f8f9fa;
            border-left: 4px solid #339CB5;
            margin: 1.5rem 0;
            padding: 1rem 1.5rem;
            border-radius: 0 8px 8px 0;
            font-style: italic;
            color: #6c757d;
        }

        /* Course Description Code Blocks */
        .course-detail-description code {
            background: #f8f9fa;
            color: #e83e8c;
            padding: 0.2rem 0.4rem;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
            border: 1px solid #e9ecef;
        }

        .course-detail-description pre {
            background: #f8f9fa;
            color: #495057;
            padding: 1rem;
            border-radius: 8px;
            overflow-x: auto;
            margin: 1rem 0;
            border: 1px solid #e9ecef;
        }

        /* Course Description Tables */
        .course-detail-description table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
        }

        .course-detail-description th {
            background: #339CB5;
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }

        .course-detail-description td {
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
            color: #495057;
        }

        .course-detail-description tr:hover {
            background: #f8f9fa;
        }

        /* Responsive Course Description */
        @media (max-width: 768px) {
            .course-detail-description {
                font-size: 1rem;
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .course-detail-description blockquote {
                margin: 1rem 0;
                padding: 0.75rem 1rem;
            }

            .course-detail-description table {
                font-size: 0.9rem;
            }

            .course-detail-description th,
            .course-detail-description td {
                padding: 0.75rem;
            }
        }

        .add-course{
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .add-course:hover{
            background: linear-gradient(135deg, #20c997, #17a2b8);
        }
        
        .remove-course{
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        .remove-course:hover{
            background: linear-gradient(135deg, #962c37, #962c37);
        }

        /* Video Player Section */
        .course-video-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        .video-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .video-wrapper {
            background: #000;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            position: relative;
            padding-top: 56.25%; /* 16:9 Aspect Ratio */
            height: 0;
        }

        .video-wrapper video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #000;
        }

        .video-section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .video-section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .video-section-title i {
            color: #339CB5;
            font-size: 2rem;
        }

        .video-section-subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            max-width: 600px;
            margin: 0 auto;
        }

        .video-controls-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            padding: 2rem;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .video-wrapper:hover .video-controls-overlay {
            opacity: 1;
        }

        .video-play-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80px;
            height: 80px;
            background: rgba(51, 156, 181, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            opacity: 0;
            pointer-events: none;
        }

        .video-wrapper:hover .video-play-overlay {
            opacity: 1;
            pointer-events: auto;
        }

        .video-play-overlay:hover {
            background: rgba(51, 156, 181, 1);
            transform: translate(-50%, -50%) scale(1.1);
        }

        .video-play-overlay i {
            color: white;
            font-size: 2rem;
            margin-left: 5px;
        }

        .course-video-player::-webkit-media-controls-panel {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .course-video-player::-webkit-media-controls-play-button {
            background-color: #339CB5;
            border-radius: 50%;
        }

        .course-video-player::-webkit-media-controls-current-time-display,
        .course-video-player::-webkit-media-controls-time-remaining-display {
            color: white;
        }

        /* Responsive Video */
        @media (max-width: 991.98px) {
            .course-video-section {
                padding: 60px 0;
            }

            .video-section-title {
                font-size: 2rem;
            }

            .video-section-subtitle {
                font-size: 1rem;
            }
        }

        @media (max-width: 767.98px) {
            .course-video-section {
                padding: 40px 0;
            }

            .video-section-title {
                font-size: 1.75rem;
                flex-direction: column;
                gap: 0.5rem;
            }

            .video-section-title i {
                font-size: 1.5rem;
            }

            .video-wrapper {
                border-radius: 15px;
            }
        }
    </style>
@endsection

@section('content')
    <section class="course-hero">
        <div class="container">
            <div class="course-hero-content">
                <div class="course-breadcrumb">
                    <a href="{{ asset('/') }}">Home</a> / 
                    <a href="{{ route('front.courses') }}">Courses</a> / 
                    <span>{{ $course->title }}</span>
                </div>
                
                <h1 class="course-title">{{ $course->title }}</h1>
                <p class="course-subtitle">{{ $course->header }}</p>
                
                <div class="course-meta">
                    <div class="meta-item">
                        <i class="fas fa-users"></i>
                        <span>15,000+ students enrolled</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-certificate"></i>
                        <span>Certificate of completion</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    @if(!is_null($course->video) && $course->video != '')
    <!-- Course Video Section -->
    <section class="course-video-section">
        <div class="video-container">
            <div class="video-section-header">
                <h2 class="video-section-title">
                    <i class="fas fa-play-circle"></i>
                    Course Preview Video
                </h2>
                <p class="video-section-subtitle">
                    Watch this preview to get a glimpse of what you'll learn in this course
                </p>
            </div>
            <div class="video-wrapper">
                <video 
                    controls 
                    controlsList="nodownload"
                    poster="{{ asset($course->thumbnail) }}"
                    preload="metadata"
                    class="course-video-player">
                    <source src="{{ asset($course->video) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="video-play-overlay">
                    <i class="fas fa-play"></i>
                </div>
            </div>
        </div>
    </section>
    @endif

    <section class="course-content">
        <div class="container">
            <div class="course-container">
                <div class="course-grid">
                    <!-- Main Content -->
                    <div class="main-content">
                        <!-- Course Description -->
                        <div class="section-title">About This Course</div>
                        <div class="row course-detail-description">
                            {!! $course->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if($isPurchased)
        <a href="{{ route('dashboard.my.courses.show', $course->slug) }}" class="floating-cart-btn purchased-course-btn">
            <i class="fas fa-check-circle cart-icon"></i>
            <div class="price">
                <span class="current-price">Purchased</span>
                <span class="enroll-now">View Course</span>
            </div>
        </a>
    @else
        <button class="floating-cart-btn {{ session()->has('cart') && in_array($course->id, array_column(session()->get('cart'), 'id')) ? 'remove-course' : 'add-course' }}" data-id="{{ $course->id }}">
            <i class="fas {{ session()->has('cart') && in_array($course->id, array_column(session()->get('cart'), 'id')) ? 'fa-trash' : 'fa-shopping-cart' }} cart-icon"></i>
            <div class="price">
                <span class="current-price">₱{{ $course->price }}</span>
                <span class="enroll-now">{{ session()->has('cart') && in_array($course->id, array_column(session()->get('cart'), 'id')) ? 'Remove from Cart' : 'Enroll Now' }}</span>
            </div>
        </button>
    @endif
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function(){
            setInterval(function(){
                checkStatus();
            }, 1000);

            // Video player enhancements
            var videoPlayer = document.querySelector('.course-video-player');
            if(videoPlayer) {
                // Add loading state
                videoPlayer.addEventListener('loadstart', function() {
                    this.style.opacity = '0.7';
                });

                videoPlayer.addEventListener('canplay', function() {
                    this.style.opacity = '1';
                });

                // Handle video errors gracefully
                videoPlayer.addEventListener('error', function() {
                    console.error('Video loading error');
                    var wrapper = this.closest('.video-wrapper');
                    if(wrapper) {
                        wrapper.innerHTML = '<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; text-align: center;"><i class="fas fa-exclamation-triangle" style="font-size: 3rem; margin-bottom: 1rem;"></i><p>Video could not be loaded. Please try again later.</p></div>';
                    }
                });

                // Prevent right-click download (additional protection)
                videoPlayer.addEventListener('contextmenu', function(e) {
                    e.preventDefault();
                    return false;
                });

                // Add keyboard shortcuts
                videoPlayer.addEventListener('keydown', function(e) {
                    // Space bar to play/pause
                    if(e.code === 'Space') {
                        e.preventDefault();
                        if(this.paused) {
                            this.play();
                        } else {
                            this.pause();
                        }
                    }
                });

                // Custom play button overlay click handler
                var playOverlay = document.querySelector('.video-play-overlay');
                if(playOverlay) {
                    playOverlay.addEventListener('click', function() {
                        if(videoPlayer.paused) {
                            videoPlayer.play();
                        } else {
                            videoPlayer.pause();
                        }
                    });
                }

                // Show/hide play overlay based on video state
                videoPlayer.addEventListener('play', function() {
                    if(playOverlay) {
                        playOverlay.style.opacity = '0';
                        playOverlay.style.pointerEvents = 'none';
                    }
                });

                videoPlayer.addEventListener('pause', function() {
                    if(playOverlay && !videoPlayer.ended) {
                        playOverlay.style.opacity = '1';
                        playOverlay.style.pointerEvents = 'auto';
                    }
                });
            }
        });
        toastr.options = {
            "positionClass": "toast-top-center", 
            "timeOut": "3000"
        }
        $(document).on('click', '.add-course', function(){
            if(@json(auth()->check())){
                var courseId = $(this).data('id');
                var button = $(this).find('i');
                var cart = $(this);
                $.ajax({
                    url: "{{ route('front.add.to.cart') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        course_id: courseId
                    },
                    success: function(response){
                        if(response.success){
                            button.addClass('fa-trash');
                            button.removeClass('fa-shopping-cart');
                            cart.addClass('remove-course');
                            cart.removeClass('add-course');
                            cart.find('.enroll-now').text('Remove from Cart');

                            $('.cart-count').text(response.cartCount);

                            if(response.cartCount == 0){
                                $('.cart-btn').addClass('d-none');
                            }
                            else{
                                $('.cart-btn').removeClass('d-none');
                            }

                            toastr.success(response.message);

                        }
                        else{
                            if(response.already_purchased){
                                // Course already purchased - show warning and redirect option
                                toastr.warning(response.message);
                                // Optionally redirect to course page after 2 seconds
                                setTimeout(function(){
                                    window.location.href = "{{ route('dashboard.my.courses.show', $course->slug) }}";
                                }, 2000);
                            } else {
                                toastr.info(response.message);
                            }
                        }
                    },
                    error: function(xhr, status, error){
                        toastr.error(xhr.responseText);
                    }
                });
            }
            else{
                window.location.href = "{{ route('login') }}";
            }
        });

        $(document).on('click', '.remove-course', function(){
            var courseId = $(this).data('id');
            var button = $(this).find('i');
            var cart = $(this);
            $.ajax({
                url: "{{ route('front.remove.from.cart') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    course_id: courseId
                },
                success: function(response){
                    if(response.success){
                        button.addClass('fa-shopping-cart');
                        button.removeClass('fa-trash');
                        cart.addClass('add-course');
                        cart.removeClass('remove-course');
                        cart.find('.enroll-now').text('Enroll Now');

                        $('.cart-count').text(response.cartCount);

                        if(response.cartCount == 0){
                            $('.cart-btn').addClass('d-none');
                        }
                        else{
                            $('.cart-btn').removeClass('d-none');
                        }

                        toastr.success(response.message);
                    }
                    else{
                        toastr.info(response.message);
                    }
                },
                error: function(xhr, status, error){
                    toastr.error(xhr.responseText);
                }
            });
        });

        function checkStatus(){
            if(@json(auth()->check())){
                $('.floating-cart-btn').each(function(){
                    var courseId = $(this).data('id');
                    var cart_btn = $(this);
                    
                    $.ajax({
                        url: "{{ route('front.check.status') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            course_id: courseId
                        },
                        success: function(response){
                            if(response.success){
                                if(response.already_purchased){
                                    // Course already purchased - replace button with purchased link
                                    if(!cart_btn.hasClass('purchased-course-btn')){
                                        var courseSlug = '{{ $course->slug }}';
                                        var purchasedHtml = '<a href="/dashboard/mycourses/' + courseSlug + '" class="floating-cart-btn purchased-course-btn">' +
                                            '<i class="fas fa-check-circle cart-icon"></i>' +
                                            '<div class="price">' +
                                            '<span class="current-price">Purchased</span>' +
                                            '<span class="enroll-now">View Course</span>' +
                                            '</div>' +
                                            '</a>';
                                        cart_btn.replaceWith(purchasedHtml);
                                    }
                                }
                                else if(response.message == 'Course in cart'){
                                    cart_btn.addClass('remove-course');
                                    cart_btn.removeClass('add-course');
                                    cart_btn.find('.enroll-now').text('Remove from Cart');
                                    cart_btn.find('i').addClass('fa-trash');
                                    cart_btn.find('i').removeClass('fa-shopping-cart');
                                    $('.cart-count').text(response.cartCount);
                                    if(response.cartCount == 0){
                                        $('.cart-btn').addClass('d-none');
                                    }
                                    else{
                                        $('.cart-btn').removeClass('d-none');
                                    }
                                }
                                else if(response.message == 'Course not in cart'){ 
                                    cart_btn.addClass('add-course');
                                    cart_btn.removeClass('remove-course');
                                    cart_btn.find('.enroll-now').text('Enroll Now');
                                    cart_btn.find('i').addClass('fa-shopping-cart');
                                    cart_btn.find('i').removeClass('fa-trash');
                                    $('.cart-count').text(response.cartCount);
                                    if(response.cartCount == 0){
                                        $('.cart-btn').addClass('d-none');
                                    }
                                    else{
                                        $('.cart-btn').removeClass('d-none');
                                    }
                                }
                            }
                        }
                    });
                });
            }
        }
    </script>
@endsection