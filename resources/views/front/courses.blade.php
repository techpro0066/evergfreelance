@extends('layouts.front')

@section('title', 'Courses | EverGreen Freelancing')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        /* Hero Banner */
        .courses-hero {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .courses-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover;
            opacity: 0.1;
            z-index: 1;
        }

        .courses-hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
        }

        .courses-hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .courses-hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .courses-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-top: 3rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            display: block;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* Course Cards Section */
        .courses-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .courses-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Course Card */
        .course-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            height: 100%;
            position: relative;
        }

        .course-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .course-image-container {
            position: relative;
            height: 250px;
            overflow: hidden;
        }

        .course-image {
            width: 100%;
            height: 100%;
            /* object-fit: cover; */
            transition: transform 0.4s ease;
        }

        .course-card:hover .course-image {
            transform: scale(1.1);
        }

        .course-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 2;
        }

        .course-badge.popular {
            background: linear-gradient(135deg, #ffd700, #ffed4e);
            color: #333;
        }

        .course-badge.new {
            background: linear-gradient(135deg, #00d2d3, #54a0ff);
        }

        .course-content {
            padding: 2rem;
        }

        .course-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 1rem;
            line-height: 1.3;
            height: 4rem !important;
            overflow: hidden;
        }

        .course-description {
            font-size: 1rem;
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            height: 80px;
            overflow: hidden;
        }

        .course-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e9ecef;
        }

        .course-duration {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .course-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stars {
            color: #ffd700;
        }

        .rating-text {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .course-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #339CB5;
            margin-bottom: 1rem;
        }

        .course-price .original {
            text-decoration: line-through;
            color: #6c757d;
            font-size: 1rem;
            margin-right: 0.5rem;
        }

        .course-actions {
            display: flex;
            gap: 1rem;
        }

        .btn-details {
            flex: 1;
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        .btn-details:hover {
            background: linear-gradient(135deg, #2a7a8f, #1f5f6f);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(51, 156, 181, 0.3);
        }

        .cart{
            border: none;
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 50px;
        }

        .btn-cart {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .btn-cart:hover {
            background: linear-gradient(135deg, #20c997, #17a2b8);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-cart.added {
            background: linear-gradient(135deg, #6c757d, #495057);
        }

        .remove-cart{
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        .remove-cart:hover{
            background: linear-gradient(135deg, #962c37, #962c37);
        }

        /* Filter Section */
        .filter-section {
            background: white;
            padding: 2rem 0;
            margin-bottom: 3rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .filter-container {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            color: #6c757d;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            border-color: #339CB5;
            color: white;
        }

        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .courses-hero-title {
                font-size: 2.5rem;
            }

            .courses-stats {
                gap: 2rem;
            }

            .stat-number {
                font-size: 2rem;
            }
        }

        @media (max-width: 767.98px) {
            .courses-hero {
                padding: 100px 0 60px;
            }

            .courses-hero-title {
                font-size: 2rem;
            }

            .courses-stats {
                flex-direction: column;
                gap: 1rem;
            }

            .course-actions {
                flex-direction: column;
            }

            .filter-container {
                flex-direction: column;
                align-items: center;
            }

            /* Mobile Filter Improvements */
            .filter-section {
                position: sticky;
                top: 80px;
                z-index: 100;
                margin-bottom: 2rem;
                padding: 1rem 0;
                border-radius: 0;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .filter-container {
                flex-direction: row;
                gap: 1rem;
                padding: 0 1rem;
                overflow-x: auto;
                justify-content: flex-start;
                -webkit-overflow-scrolling: touch;
            }

            .filter-btn {
                white-space: nowrap;
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
                min-width: auto;
                flex-shrink: 0;
            }

            /* Add padding to courses section to account for sticky filter */
            .courses-section {
                padding-top: 2rem;
            }
        }

        #toast-container.toast-top-center {
            top: 20px;   /* adjust margin */
        }

        #toast-container > .toast-success {
            background-color: #2d862d !important; /* darker green */
            color: #fff !important; /* keep text white */
        }
    </style>
@endsection

@section('content')
    <section class="courses-hero">
        <div class="container">
            <div class="courses-hero-content">
                <h1 class="courses-hero-title">Master the Art of Freelancing</h1>
                <p class="courses-hero-subtitle">Transform your skills into a thriving freelance career with our expert-led courses</p>
                
                <div class="courses-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $courses->count() }}</span>
                        <span class="stat-label">Expert Courses</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">50K+</span>
                        <span class="stat-label">Students Enrolled</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">98%</span>
                        <span class="stat-label">Success Rate</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="courses-section">
        <div class="container">
            <div class="courses-container">
                <div class="section-header">
                    <h2 class="section-title">Featured Courses</h2>
                    <p class="section-subtitle">Choose from our comprehensive collection of courses designed to help you succeed in the freelance world</p>
                </div>

                <div class="row" id="coursesGrid">
                    @foreach($courses as $course)
                        <div class="col-lg-4 col-md-6 mb-4" data-category="digital-marketing">
                            <div class="course-card">
                                <div class="course-image-container">
                                    <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}" class="course-image">
                                </div>
                                <div class="course-content">
                                    <h3 class="course-title">{{ $course->title }}</h3>
                                    <div class="course-description">{{ Str::limit($course->header, 150) }}</div>

                                    <div class="course-price">
                                        <span>${{ $course->price }}</span>
                                    </div>

                                    <div class="course-actions">
                                        <a href="{{ route('front.course.detail', $course->slug) }}" class="btn-details">View Details</a>
                                        <button class="cart {{ session()->has('cart') && in_array($course->id, array_column(session()->get('cart'), 'id')) ? 'remove-cart' : 'btn-cart' }}" data-id="{{ $course->id }}">
                                            <i class="{{ session()->has('cart') && in_array($course->id, array_column(session()->get('cart'), 'id')) ? 'fas fa-trash' : 'fas fa-shopping-cart' }}"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function(){
            setInterval(function(){
                checkStatus();
            }, 1000);
        });

        toastr.options = {
            "positionClass": "toast-top-center", 
            "timeOut": "3000"
        }
        $(document).on('click', '.btn-cart', function(){
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
                            cart.addClass('remove-cart');
                            cart.removeClass('btn-cart');

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
            }
            else{
                window.location.href = "{{ route('login') }}";
            }
        });

        $(document).on('click', '.remove-cart', function(){
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
                        cart.addClass('btn-cart');
                        cart.removeClass('remove-cart');
                        
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
                $('.btn-cart').each(function(){
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
                                if(response.message == 'Course in cart'){
                                    cart_btn.addClass('remove-cart');
                                    cart_btn.removeClass('btn-cart');
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
                                    cart_btn.addClass('btn-cart');
                                    cart_btn.removeClass('remove-cart');
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