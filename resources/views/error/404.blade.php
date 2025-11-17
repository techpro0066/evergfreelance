<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | EverGreen Freelancing</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('front/assets/images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    
    <style>
        /* 404 Page Specific Styles */
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        
        .error-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 2rem 1rem;
        }
        
        .error-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            position: relative;
            z-index: 2;
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .error-code {
            font-size: 8rem;
            font-weight: 900;
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            line-height: 1;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
        
        .error-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }
        
        .error-description {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
            animation: fadeInUp 0.8s ease-out 0.4s both;
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
        
        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 2rem;
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(51, 156, 181, 0.3);
        }
        
        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #2a7a8f, #1f5f6f);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(51, 156, 181, 0.4);
            color: white;
        }
        
        .btn-secondary-custom {
            background: transparent;
            border: 2px solid #339CB5;
            color: #339CB5;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-secondary-custom:hover {
            background: #339CB5;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(51, 156, 181, 0.3);
        }
        
        .search-box {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            width: 100%;
            max-width: 400px;
            margin: 0 auto 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            animation: fadeInUp 0.8s ease-out 0.8s both;
        }
        
        .search-box:focus-within {
            border-color: #339CB5;
            box-shadow: 0 0 0 0.2rem rgba(51, 156, 181, 0.25);
        }
        
        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            flex: 1;
            font-size: 1rem;
            color: #333;
        }
        
        .search-box input::placeholder {
            color: #6c757d;
        }
        
        .search-box button {
            background: #339CB5;
            border: none;
            color: white;
            padding: 0.5rem;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .search-box button:hover {
            background: #2a7a8f;
            transform: scale(1.1);
        }
        
        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        
        .floating-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-element:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .floating-element:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }
        
        .floating-element:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 80%;
            left: 20%;
            animation-delay: 4s;
        }
        
        .floating-element:nth-child(4) {
            width: 100px;
            height: 100px;
            top: 10%;
            right: 20%;
            animation-delay: 1s;
        }
        
        .floating-element:nth-child(5) {
            width: 70px;
            height: 70px;
            top: 40%;
            left: 5%;
            animation-delay: 3s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }
        
        .logo-section {
            margin-bottom: 2rem;
            animation: fadeInUp 0.8s ease-out 0.1s both;
        }
        
        .logo-section img {
            max-width: 120px;
            height: auto;
            margin-bottom: 1rem;
        }
        
        .helpful-links {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e9ecef;
            animation: fadeInUp 0.8s ease-out 1s both;
        }
        
        .helpful-links h5 {
            color: #333;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .helpful-links ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
        }
        
        .helpful-links li a {
            color: #339CB5;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            background: rgba(51, 156, 181, 0.1);
        }
        
        .helpful-links li a:hover {
            background: #339CB5;
            color: white;
            transform: translateY(-2px);
        }
        
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .error-content {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }
            
            .error-code {
                font-size: 6rem;
            }
            
            .error-title {
                font-size: 2rem;
            }
            
            .error-description {
                font-size: 1.1rem;
            }
            
            .error-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .btn-primary-custom,
            .btn-secondary-custom {
                width: 100%;
                max-width: 250px;
                justify-content: center;
            }
            
            .search-box {
                max-width: 100%;
            }
            
            .helpful-links ul {
                flex-direction: column;
                align-items: center;
            }
        }
        
        @media (max-width: 576px) {
            .error-content {
                padding: 1.5rem 1rem;
            }
            
            .error-code {
                font-size: 5rem;
            }
            
            .error-title {
                font-size: 1.8rem;
            }
            
            .error-description {
                font-size: 1rem;
            }
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .error-content {
                background: rgba(30, 30, 30, 0.95);
                color: #fff;
            }
            
            .error-title {
                color: #fff;
            }
            
            .error-description {
                color: #ccc;
            }
            
            .search-box {
                background: rgba(255, 255, 255, 0.1);
                border-color: rgba(255, 255, 255, 0.2);
            }
            
            .search-box input {
                color: #fff;
            }
            
            .search-box input::placeholder {
                color: #aaa;
            }
            
            .helpful-links {
                border-top-color: rgba(255, 255, 255, 0.2);
            }
            
            .helpful-links h5 {
                color: #fff;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <!-- Floating Background Elements -->
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        
        <!-- Error Content -->
        <div class="error-content">
            <!-- Logo Section -->
            <div class="logo-section">
                <img src="{{ asset('front/assets/images/logo.png') }}" alt="EverGreen Freelancing" class="logo">
            </div>
            
            <!-- Error Code -->
            <div class="error-code">404</div>
            
            <!-- Error Title -->
            <h1 class="error-title">Oops! Page Not Found</h1>
            
            <!-- Error Description -->
            <p class="error-description">
                The page you're looking for seems to have vanished into the digital void. 
                Don't worry, even the best freelancers sometimes take a wrong turn!
            </p>
            
            <!-- Action Buttons -->
            <div class="error-actions">
                <a href="{{ asset('/') }}" class="btn-primary-custom">
                    <i class="fas fa-home"></i>
                    Go Home
                </a>
                <a href="{{ route('front.courses') }}" class="btn-secondary-custom">
                    <i class="fas fa-graduation-cap"></i>
                    Browse Courses
                </a>

                @if(auth()->check())
                    <a href="{{ route('dashboard') }}" class="btn-secondary-custom">
                        <i class="fas fa-user"></i>
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-secondary-custom">
                        <i class="fas fa-user"></i>
                        Go to Login
                    </a>
                    <a href="{{ route('register') }}" class="btn-secondary-custom">
                        <i class="fas fa-user"></i>
                        Go to Register
                    </a>
                @endif
            </div>
            
            <!-- Helpful Links -->
            <div class="helpful-links">
                <h5>Popular Pages</h5>
                <ul>
                    <li><a href="{{ asset('/') }}">Home</a></li>
                    <li><a href="{{ route('front.courses') }}">Courses</a></li>
                    <li><a href="{{ route('front.about.us') }}">About Us</a></li>
                    <li><a href="{{ route('front.contact') }}">Contact</a></li>
                    <li><a href="{{ route('front.faq') }}">FAQ</a></li>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
