@extends('layouts.front')

@section('title', 'Contact | EverGreen Freelancing')

@section('css')
    <style>
        /* Hero Section */
        .contact-hero {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
            padding: 120px 0 60px;
            position: relative;
            overflow: hidden;
        }

        .contact-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover;
            opacity: 0.1;
            z-index: 1;
        }

        .contact-hero-content {
            position: relative;
            z-index: 2;
            color: white;
            text-align: center;
        }

        .contact-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .contact-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        /* Contact Content */
        .contact-content {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .contact-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Contact Form */
        .contact-form-section {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 3rem;
        }

        .form-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 2rem;
            text-align: center;
        }

        .contact-form {
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #339CB5;
            box-shadow: 0 0 0 3px rgba(51, 156, 181, 0.1);
            outline: none;
        }

        .form-control.textarea {
            min-height: 120px;
            resize: vertical;
        }

        .submit-btn {
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #2a7a8f, #1f5f6f);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(51, 156, 181, 0.3);
        }

        /* Contact Info */
        .contact-info-section {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 3rem;
        }

        .info-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 2rem;
            text-align: center;
        }

        .contact-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .contact-info-item {
            text-align: center;
            padding: 2rem;
            border-radius: 15px;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }

        .contact-info-item:hover {
            background: white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .contact-info-item i {
            font-size: 3rem;
            color: #339CB5;
            margin-bottom: 1rem;
        }

        .contact-info-item h4 {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
        }

        .contact-info-item p {
            color: #6c757d;
            margin-bottom: 0;
        }

        .contact-info-item a {
            color: #339CB5;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .contact-info-item a:hover {
            color: #2a7a8f;
        }

        /* Map Section */
        .map-section {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .map-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 2rem;
            text-align: center;
        }

        .map-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .map-iframe {
            width: 100%;
            height: 400px;
            border: none;
        }

        /* Success Message */
        .success-message {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            text-align: center;
            display: none;
        }

        /* Enhanced Active Navbar */
        .navbar-nav .nav-link.active {
            color: #339CB5 !important;
            font-weight: 700;
            position: relative;
            background: linear-gradient(135deg, rgba(51, 156, 181, 0.1), rgba(42, 122, 143, 0.1));
            border-radius: 8px;
            padding: 8px 16px !important;
            margin: 0 4px;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link.active::before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 3px;
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            border-radius: 2px;
        }

        .navbar-nav .nav-link.active:hover {
            background: linear-gradient(135deg, rgba(51, 156, 181, 0.15), rgba(42, 122, 143, 0.15));
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(51, 156, 181, 0.2);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .contact-title {
                font-size: 2.5rem;
            }

            .contact-form-section,
            .contact-info-section,
            .map-section {
                padding: 2rem;
            }

            .contact-info-grid {
                grid-template-columns: 1fr;
            }

            .map-iframe {
                height: 300px;
            }

            .navbar-nav .nav-link.active {
                margin: 4px 0;
                text-align: center;
            }

            .navbar-nav .nav-link.active::before {
                width: 60%;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Contact Hero -->
    <section class="contact-hero">
        <div class="container">
            <div class="contact-hero-content">
                <h1 class="contact-title">Get In Touch</h1>
                <p class="contact-subtitle">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
            </div>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="contact-content">
        <div class="container">
            <div class="contact-container">
                
                <!-- Contact Form -->
                <div class="contact-form-section">
                    <h2 class="form-title">Send Us a Message</h2>
                    <form class="contact-form" id="contactForm">
                        <div class="success-message" id="successMessage">
                            <i class="fas fa-check-circle"></i> Thank you! Your message has been sent successfully. We'll get back to you soon.
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstName" class="form-label">First Name *</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastName" class="form-label">Last Name *</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                        
                        <div class="form-group">
                            <label for="subject" class="form-label">Subject *</label>
                            <select class="form-control" id="subject" name="subject" required>
                                <option value="">Select a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="course">Course Information</option>
                                <option value="technical">Technical Support</option>
                                <option value="billing">Billing & Payment</option>
                                <option value="partnership">Partnership</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message" class="form-label">Message *</label>
                            <textarea class="form-control textarea" id="message" name="message" rows="5" required placeholder="Tell us how we can help you..."></textarea>
                        </div>
                        
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane me-2"></i>
                            Send Message
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('scripts')

@endsection