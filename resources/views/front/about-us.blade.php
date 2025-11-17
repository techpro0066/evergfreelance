@extends('layouts.front')

@section('title', 'About Us | EverGreen Freelancing')

@section('css')
    <style>
        /* Hero Banner */
        .hero-banner {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover;
            opacity: 0.1;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .breadcrumb-nav {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            display: inline-block;
        }

        .breadcrumb-nav a {
            color: white;
            text-decoration: none;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .breadcrumb-nav a:hover {
            opacity: 1;
        }

        /* Owner Section */
        .owner-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .owner-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .owner-row {
            display: flex;
            align-items: center;
            gap: 4rem;
        }

        .owner-image-container {
            flex: 0 0 400px;
            position: relative;
        }

        .owner-frame {
            position: relative;
            padding: 20px;
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(51, 156, 181, 0.3);
            transform: rotate(-2deg);
            transition: transform 0.3s ease;
        }

        .owner-frame:hover {
            transform: rotate(0deg) scale(1.02);
        }

        .owner-frame::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: linear-gradient(45deg, #ffd700, #ffed4e, #ffd700);
            border-radius: 25px;
            z-index: -1;
            animation: borderGlow 3s ease-in-out infinite alternate;
        }

        @keyframes borderGlow {
            0% { opacity: 0.7; }
            100% { opacity: 1; }
        }

        .owner-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .owner-content {
            flex: 1;
        }

        .owner-name {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 1rem;
        }

        .owner-title {
            font-size: 1.25rem;
            color: #339CB5;
            margin-bottom: 2rem;
            font-weight: 600;
        }

        .owner-quote {
            font-size: 1.5rem;
            font-style: italic;
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 2rem;
            position: relative;
            padding-left: 2rem;
        }

        .owner-quote::before {
            content: '"';
            position: absolute;
            left: 0;
            top: -10px;
            font-size: 4rem;
            color: #339CB5;
            font-family: serif;
        }

        .owner-description {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #6c757d;
            margin-bottom: 2rem;
        }

        .owner-stats {
            display: flex;
            gap: 2rem;
            margin-top: 2rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #339CB5;
            display: block;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Video Section */
        .video-section {
            padding: 80px 0;
            background: white;
        }

        .video-container {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .video-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 1rem;
        }

        .video-subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 3rem;
        }

        .video-wrapper {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            background: #000;
        }

        .video-player {
            width: 100%;
            height: 450px;
            background: #000;
        }

        /* Mission & Vision */
        .mission-vision {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .mission-card, .vision-card {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            height: 100%;
            transition: transform 0.3s ease;
        }

        .mission-card:hover, .vision-card:hover {
            transform: translateY(-5px);
        }

        .mission-icon, .vision-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .mission-icon i, .vision-icon i {
            color: white;
            font-size: 2rem;
        }

        .mission-title, .vision-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 1rem;
        }

        .mission-text, .vision-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #6c757d;
        }

        /* Values Section */
        .values-section {
            padding: 80px 0;
            background: white;
        }

        .values-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            text-align: center;
            margin-bottom: 3rem;
        }

        .value-card {
            text-align: center;
            padding: 2rem;
            border-radius: 15px;
            background: #f8f9fa;
            transition: all 0.3s ease;
            height: 100%;
        }

        .value-card:hover {
            background: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .value-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .value-icon i {
            color: white;
            font-size: 1.5rem;
        }

        .value-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 1rem;
        }

        .value-description {
            font-size: 1rem;
            color: #6c757d;
            line-height: 1.6;
        }

        /* Team Section */
        .team-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .team-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            text-align: center;
            margin-bottom: 3rem;
        }

        .team-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .team-card:hover {
            transform: translateY(-10px);
        }

        .team-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .team-info {
            padding: 2rem;
            text-align: center;
        }

        .team-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
        }

        .team-role {
            font-size: 1rem;
            color: #339CB5;
            margin-bottom: 1rem;
        }

        .team-description {
            font-size: 0.9rem;
            color: #6c757d;
            line-height: 1.6;
        }

        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .owner-row {
                flex-direction: column;
                gap: 2rem;
            }

            .owner-image-container {
                flex: none;
                width: 100%;
                max-width: 400px;
            }

            .owner-name {
                font-size: 2rem;
            }

            .owner-quote {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 767.98px) {
            .hero-banner {
                padding: 100px 0 60px;
            }

            .hero-title {
                font-size: 2rem;
            }

            .owner-stats {
                flex-direction: row;
                gap: 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }

            .stat-item {
                flex: 1;
                min-width: 100px;
            }

            .video-placeholder {
                height: 300px;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Banner -->
    <section class="hero-banner">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">About EverGreen Freelancing</h1>
                <p class="hero-subtitle">Empowering individuals to build successful freelance careers through expert-led education and mentorship</p>
            </div>
        </div>
    </section>

    <!-- Owner Section -->
    <section class="owner-section">
        <div class="container">
            <div class="owner-container">
                <div class="owner-row">
                    <div class="owner-image-container">
                        <div class="owner-frame">
                            <img src="{{ asset('front/assets/images/owner.jpg') }}" alt="Founder & CEO" class="owner-image">
                        </div>
                    </div>
                    <div class="owner-content">
                        <h2 class="owner-name">Sarah Johnson</h2>
                        <p class="owner-title">Founder & CEO, EverGreen Freelancing</p>
                        
                        <blockquote class="owner-quote">
                            "Success in freelancing isn't just about skills—it's about mindset, strategy, and continuous learning. At EverGreen, we don't just teach; we transform lives by empowering individuals to build sustainable, fulfilling freelance careers."
                        </blockquote>
                        
                        <p class="owner-description">
                            With over 15 years of experience in the freelance industry, Sarah has helped thousands of individuals transition from traditional employment to successful freelance careers. Her passion for education and commitment to student success has made EverGreen Freelancing a trusted name in online education.
                        </p>
                        
                        <div class="owner-stats">
                            <div class="stat-item">
                                <span class="stat-number">15+</span>
                                <span class="stat-label">Years Experience</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">10K+</span>
                                <span class="stat-label">Students Helped</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">95%</span>
                                <span class="stat-label">Success Rate</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Section -->
    <section class="video-section">
        <div class="container">
            <div class="video-container">
                <h2 class="video-title">Message from Our Founder</h2>
                <p class="video-subtitle">Hear directly from Sarah about our mission and vision for the future of freelancing education</p>
                
                                <div class="video-wrapper">
                    <video class="video-player" controls poster="{{ asset('front/assets/images/logo.jpg') }}">
                        <source src="{{ asset('videos/about-us.mp4') }}" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="mission-vision">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="mission-card">
                        <div class="mission-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="mission-title">Our Mission</h3>
                        <p class="mission-text">
                            To democratize access to quality freelancing education and empower individuals worldwide to build successful, sustainable freelance careers through comprehensive training, mentorship, and ongoing support.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="vision-card">
                        <div class="vision-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3 class="vision-title">Our Vision</h3>
                        <p class="vision-text">
                            To become the world's leading platform for freelancing education, creating a global community of successful freelancers who inspire and support the next generation of independent professionals.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
        <div class="container">
            <h2 class="values-title">Our Core Values</h2>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h4 class="value-title">Excellence</h4>
                        <p class="value-description">We maintain the highest standards in our educational content and delivery methods.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4 class="value-title">Community</h4>
                        <p class="value-description">We foster a supportive community where learners can connect and grow together.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h4 class="value-title">Innovation</h4>
                        <p class="value-description">We continuously innovate our teaching methods and course content.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4 class="value-title">Passion</h4>
                        <p class="value-description">We are passionate about helping others achieve their freelance dreams.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection