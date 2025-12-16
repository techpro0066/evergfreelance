@extends('layouts.front')

@section('title', 'Checkout | EverGreen Freelancing')

@section('css')
    <style>
        /* Hero Section */
        .checkout-hero {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
            padding: 120px 0 60px;
            position: relative;
            overflow: hidden;
        }

        .checkout-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover;
            opacity: 0.1;
            z-index: 1;
        }

        .checkout-hero-content {
            position: relative;
            z-index: 2;
            color: white;
            text-align: center;
        }

        .checkout-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .checkout-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        /* Checkout Content */
        .checkout-content {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .checkout-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Checkout Form */
        .checkout-form-section {
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

        /* Payment Method Section */
        .payment-method-section {
            margin: 2rem 0;
            padding: 0;
        }

        .payment-method-header {
            margin-bottom: 1.5rem;
        }

        .payment-method-header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
        }

        .payment-method-header p {
            color: #6c757d;
            font-size: 0.95rem;
            margin: 0;
        }

        .payment-method-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .payment-method-option {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.25rem 1.5rem;
            border: 2.5px solid #e9ecef;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: white;
            min-height: 80px;
        }

        .payment-method-option:hover {
            border-color: #339CB5;
            background: linear-gradient(135deg, rgba(51, 156, 181, 0.05), rgba(42, 122, 143, 0.05));
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(51, 156, 181, 0.15);
        }

        .payment-method-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .payment-method-option input[type="radio"]:checked + .payment-option-content {
            color: #339CB5;
        }

        .payment-method-option input[type="radio"]:checked ~ .payment-option-content {
            color: #339CB5;
        }

        .payment-method-option:has(input[type="radio"]:checked) {
            border-color: #339CB5;
            background: linear-gradient(135deg, rgba(51, 156, 181, 0.1), rgba(42, 122, 143, 0.1));
            box-shadow: 0 4px 16px rgba(51, 156, 181, 0.2);
        }

        .payment-option-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            width: 100%;
            transition: all 0.3s ease;
        }

        .payment-option-content i {
            font-size: 2rem;
            color: #6c757d;
            transition: all 0.3s ease;
        }

        .payment-method-option:has(input[type="radio"]:checked) .payment-option-content i {
            color: #339CB5;
            transform: scale(1.1);
        }

        .payment-option-content span {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--primary-dark);
            transition: all 0.3s ease;
        }

        .payment-method-option:has(input[type="radio"]:checked) .payment-option-content span {
            color: #339CB5;
        }

        /* Card Element Container */
        .card-element-container {
            margin-top: 2rem;
            padding: 0;
        }

        .card-element-wrapper {
            background: #f8f9fa;
            border-radius: 16px;
            padding: 2rem;
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-input-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e9ecef;
        }

        .card-element-label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            color: var(--primary-dark);
            font-size: 1rem;
            margin: 0;
        }

        .card-element-label i {
            color: #339CB5;
            font-size: 1.2rem;
        }

        .card-input-container {
            position: relative;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 0;
            min-height: 60px;
            border: none !important;
            box-shadow: none !important;
            transition: all 0.3s ease;
        }

        /* Card Input Fields Styling */
        .card-input {
            font-size: 16px;
            color: var(--primary-dark);
            padding: 1rem;
            border: 2px solid #e9ecef;
            background: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: 400;
            line-height: 1.5;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .card-input:focus {
            outline: none;
            border-color: #339CB5;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(51, 156, 181, 0.1);
        }

        .card-input::placeholder {
            color: #adb5bd;
            opacity: 0.7;
            font-weight: 400;
        }

        .card-input.is-invalid {
            border-color: #dc3545;
        }

        .card-input.is-valid {
            border-color: #28a745;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .card-error-message {
            margin-top: 1rem;
            font-size: 0.875rem;
            min-height: 24px;
            padding: 0.75rem 1rem;
            background: #fff5f5;
            border-left: 4px solid #dc3545;
            border-radius: 8px;
            color: #dc3545;
            font-weight: 500;
            display: none;
        }

        .card-error-message:not(:empty) {
            display: block;
        }

        /* Payment Status Messages */
        .payment-status-message {
            margin-bottom: 1.5rem;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideDown 0.3s ease-out;
        }

        .payment-status-message.success {
            background: #d4edda;
            border-left: 4px solid #28a745;
            color: #155724;
        }

        .payment-status-message.error {
            background: #f8d7da;
            border-left: 4px solid #dc3545;
            color: #721c24;
        }

        .payment-status-message.warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            color: #856404;
        }

        .payment-status-message.info {
            background: #d1ecf1;
            border-left: 4px solid #17a2b8;
            color: #0c5460;
        }

        .payment-status-message .message-icon {
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .payment-status-message.success .message-icon::before {
            content: '\f00c'; /* fa-check */
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
        }

        .payment-status-message.error .message-icon::before {
            content: '\f06a'; /* fa-exclamation-circle */
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
        }

        .payment-status-message.warning .message-icon::before {
            content: '\f071'; /* fa-exclamation-triangle */
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
        }

        .payment-status-message.info .message-icon::before {
            content: '\f05a'; /* fa-info-circle */
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Order Summary */
        .order-summary-section {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 100px;
        }

        .summary-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 2rem;
            text-align: center;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 1rem;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-title {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 0.25rem;
        }

        .cart-item-price {
            color: #339CB5;
            font-weight: 600;
        }

        .cart-item-remove {
            color: #dc3545;
            cursor: pointer;
            padding: 0.5rem;
            transition: all 0.3s ease;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
        }

        .cart-item-remove:hover {
            background: #dc3545;
            color: white;
            transform: scale(1.1);
        }

        .price-breakdown {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #e9ecef;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .price-row.total {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--primary-dark);
            border-top: 1px solid #e9ecef;
            padding-top: 1rem;
            margin-top: 1rem;
        }

        .checkout-btn {
            background: linear-gradient(135deg, #339CB5, #2a7a8f);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
            margin-top: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(51, 156, 181, 0.3);
        }

        .checkout-btn:hover:not(:disabled) {
            background: linear-gradient(135deg, #2a7a8f, #1f5f6f);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(51, 156, 181, 0.4);
        }

        .checkout-btn:active:not(:disabled) {
            transform: translateY(0);
            box-shadow: 0 4px 15px rgba(51, 156, 181, 0.3);
        }

        .checkout-btn:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
            opacity: 0.6;
        }

        .checkout-btn i {
            font-size: 1.1rem;
        }

        /* Disabled state styling */
        .checkout-btn:disabled {
            position: relative;
        }

        .checkout-btn:disabled::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            pointer-events: none;
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

        /* Loading State */
        #payment-loading {
            text-align: center;
            padding: 2rem;
            color: #339CB5;
        }

        #payment-loading i {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        /* Security Badge */
        .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
            padding: 1rem;
            background: rgba(51, 156, 181, 0.05);
            border-radius: 12px;
            color: #339CB5;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .security-badge i {
            font-size: 1.1rem;
        }

        /* Mobile Responsive */
        @media (max-width: 992px) {
            .checkout-container {
                padding: 0 1rem;
            }

            .order-summary-section {
                position: static;
                margin-top: 2rem;
            }
        }

        @media (max-width: 768px) {
            .checkout-hero {
                padding: 100px 0 40px;
            }

            .checkout-title {
                font-size: 2rem;
            }

            .checkout-subtitle {
                font-size: 1rem;
            }

            .checkout-content {
                padding: 40px 0;
            }

            .checkout-form-section {
                padding: 1.5rem;
                border-radius: 16px;
            }

            .order-summary-section {
                padding: 1.5rem;
                border-radius: 16px;
            }

            .form-title {
                font-size: 1.5rem;
            }

            .card-element-wrapper {
                padding: 1.5rem;
            }

            .card-input-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
                margin-bottom: 1rem;
            }

            .card-input-container {
                padding: 0;
            }

            .cart-item {
                padding: 0.75rem 0;
            }

            .cart-item-image {
                width: 50px;
                height: 50px;
            }

            .checkout-btn {
                padding: 0.875rem 1.5rem;
                font-size: 1rem;
            }

            .navbar-nav .nav-link.active {
                margin: 4px 0;
                text-align: center;
            }

            .navbar-nav .nav-link.active::before {
                width: 60%;
            }
        }

        @media (max-width: 576px) {
            .checkout-title {
                font-size: 1.75rem;
            }

            .checkout-form-section,
            .order-summary-section {
                padding: 1.25rem;
            }

            .payment-method-header h3 {
                font-size: 1.25rem;
            }

            .card-element-wrapper {
                padding: 1.25rem;
            }

            .card-input-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
                margin-bottom: 1rem;
            }

            .card-input-container {
                padding: 0;
                min-height: 55px;
            }

            .summary-title {
                font-size: 1.25rem;
            }

            .price-row.total {
                font-size: 1.1rem;
            }
        }
    </style>
@endsection

@section('content')
    <section class="checkout-hero">
        <div class="container">
            <div class="checkout-hero-content">
                <h1 class="checkout-title">Complete Your Purchase</h1>
                <p class="checkout-subtitle">Secure checkout process. Your information is protected with bank-level security.</p>
            </div>
        </div>
    </section>
    
    <section class="checkout-content">
        <div class="container">
            <div class="checkout-container">
                <div class="row">
                    <!-- Checkout Form -->
                    <div class="col-lg-8">
                        <div class="checkout-form-section">
                            <h2 class="form-title">Payment Information</h2>
                            <form id="checkoutForm">
                                <div class="success-message" id="successMessage">
                                    <i class="fas fa-check-circle"></i> Thank you! Your order has been placed successfully. You'll receive a confirmation email shortly.
                                </div>

                                <!-- PayMongo Payment Form -->
                                <div class="payment-method-section">
                                    <div class="payment-method-header">
                                        <h3><i class="fas fa-credit-card me-2"></i>Card Payment</h3>
                                        <p>Enter your card details to complete your purchase securely</p>
                                    </div>

                                    <!-- Payment Status Messages -->
                                    <div id="payment-status-message" class="payment-status-message" style="display: none;" role="alert">
                                        <i class="message-icon"></i>
                                        <span class="message-text"></span>
                                    </div>
                                    
                                    <!-- Card Payment Form -->
                                    <div id="card-payment-form" class="card-element-container">
                                        <div class="card-element-wrapper">
                                            <div class="card-input-header">
                                                <label class="card-element-label">
                                                    <i class="fas fa-credit-card"></i>
                                                    Card Details
                                                </label>
                                            </div>
                                            
                                            <!-- Card Number -->
                                            <div class="form-group mb-3">
                                                <label for="card_number" class="form-label">Card Number</label>
                                                <input type="text" 
                                                       id="card_number" 
                                                       name="card_number" 
                                                       class="form-control card-input" 
                                                       placeholder="1234 5678 9012 3456"
                                                       maxlength="19"
                                                       autocomplete="cc-number"
                                                       required>
                                                <div class="invalid-feedback"></div>
                                            </div>

                                            <!-- Expiry and CVV Row -->
                                    <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="card_expiry" class="form-label">Expiry Date</label>
                                                    <input type="text" 
                                                           id="card_expiry" 
                                                           name="card_expiry" 
                                                           class="form-control card-input" 
                                                           placeholder="MM/YY"
                                                           maxlength="5"
                                                           autocomplete="cc-exp"
                                                           required>
                                                    <div class="invalid-feedback"></div>
                                            </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="card_cvc" class="form-label">CVV</label>
                                                    <input type="text" 
                                                           id="card_cvc" 
                                                           name="card_cvc" 
                                                           class="form-control card-input" 
                                                           placeholder="123"
                                                           maxlength="4"
                                                           autocomplete="cc-csc"
                                                           required>
                                                    <div class="invalid-feedback"></div>
                                        </div>
                                            </div>

                                            <!-- Cardholder Name -->
                                            <div class="form-group mb-3">
                                                <label for="card_name" class="form-label">Cardholder Name</label>
                                                <input type="text" 
                                                       id="card_name" 
                                                       name="card_name" 
                                                       class="form-control card-input" 
                                                       placeholder="John Doe"
                                                       value="{{ Auth::user()->name }}"
                                                       autocomplete="cc-name"
                                                       required>
                                                <div class="invalid-feedback"></div>
                                            </div>

                                            <div id="card-errors" class="card-error-message" role="alert"></div>
                                        </div>
                                        <div class="security-badge">
                                            <i class="fas fa-lock"></i>
                                            <span>Your payment information is secure and encrypted</span>
                                        </div>
                                    </div>
                                    
                                    <div id="payment-loading" style="display: none;">
                                        <i class="fas fa-spinner fa-spin"></i>
                                        <p>Initializing secure payment...</p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-4">
                        <div class="order-summary-section">
                            <h3 class="summary-title">Order Summary</h3>
                            
                            <!-- Cart Items -->
                            <div id="cartItems">
                                @foreach($cart as $item)
                                    <div class="cart-item">
                                        <div class="cart-item-remove" data-id="{{ $item['id'] }}">
                                            <i class="fas fa-trash"></i>
                                        </div>
                                        <img src="{{ asset($item['thumbnail']) }}" alt="{{ $item['title'] }}" class="cart-item-image">
                                        <div class="cart-item-details">
                                            <div class="cart-item-title">{{ $item['title'] }}</div>
                                            <div class="cart-item-price">₱{{ $item['price'] }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Price Breakdown -->
                            <div class="price-breakdown">
                                <div class="price-row">
                                    <span>Subtotal:</span>
                                    <span>₱{{ number_format($total, 2) }}</span>
                                </div>
                                <div class="price-row">
                                    <span>Processing Fee:</span>
                                    <span>₱0.00</span>
                                </div>
                                <div class="price-row total">
                                    <span>Total Amount:</span>
                                    <span class="total-price">₱{{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <button type="button" class="checkout-btn" id="payButton" disabled>
                                <i class="fas fa-lock me-2"></i>
                                <span class="checkout-btn-text">Complete Purchase</span>
                            </button>
                            
                            <div class="security-badge mt-3">
                                <i class="fas fa-shield-alt"></i>
                                <span>Secure checkout powered by PayMongo</span>
                            </div>
                            
                            <input type="hidden" id="payment_intent_id" value="">
                            <input type="hidden" id="client_key" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    let paymentIntentId = '';
    let isCardValid = false;
    let cardComplete = false;

    // Show inline message function (replaces toastr)
    function showMessage(message, type = 'info') {
        if (!message || (typeof message !== 'string' && typeof message !== 'number')) {
            console.warn('showMessage called with invalid message:', message);
            return;
        }
        
        const messageEl = $('#payment-status-message');
        const textEl = messageEl.find('.message-text');
        
        if (messageEl.length === 0) {
            console.error('Payment status message element not found!');
            // Fallback: alert the message
            alert(String(message));
            return;
        }
        
        // Remove all type classes
        messageEl.removeClass('success error warning info');
        
        // Add the appropriate type class
        messageEl.addClass(type);
        
        // Set message text - ensure it's a string
        const messageText = String(message).trim();
        textEl.text(messageText);
        
        // Show the message with animation
        messageEl.stop(true, true).slideDown(300);
        
        // Scroll to message if it's not visible
        setTimeout(function() {
            const offset = messageEl.offset();
            if (offset) {
                $('html, body').animate({
                    scrollTop: offset.top - 100
                }, 300);
            }
        }, 100);
        
        // Only auto-hide success messages (after redirect delay)
        // Error and warning messages stay visible until user tries again
        if (type === 'success') {
            // Success messages will redirect, so no need to hide
            // They'll disappear when page redirects
        } else if (type === 'info') {
            // Info messages can auto-hide after a delay
            setTimeout(function() {
                messageEl.slideUp(300);
            }, 5000);
        }
        // Error and warning messages stay visible - no auto-hide
        
        // Log for debugging
        console.log('Showing message:', type, messageText);
    }

    // Hide message function - Clear previous messages
    function hideMessage() {
        const messageEl = $('#payment-status-message');
        if (messageEl.length > 0) {
            // Clear message text
            messageEl.find('.message-text').text('');
            // Remove all type classes
            messageEl.removeClass('success error warning info');
            // Hide the message
            messageEl.slideUp(300);
        }
    }

    // Initialize payment on page load
    $(document).ready(function() {
        // Disable button initially
        $('#payButton').prop('disabled', true);
        initializePayment();
        setupCardInputs();
    });

    // Setup card input fields with strict validation
    function setupCardInputs() {
        // Format card number (add spaces every 4 digits)
        $('#card_number').on('input', function() {
            var value = $(this).val().replace(/\s/g, '').replace(/\D/g, ''); // Remove spaces and non-digits
            var formatted = value.match(/.{1,4}/g)?.join(' ') || value;
            $(this).val(formatted);
            validateCardInputs();
        });

        // Format and validate expiry date (MM/YY) - Prevent invalid dates
        $('#card_expiry').on('input', function(e) {
            var value = $(this).val().replace(/\D/g, ''); // Remove all non-digits
            
            // Prevent invalid month (01-12)
            if (value.length >= 1) {
                var firstDigit = parseInt(value[0]);
                if (firstDigit > 1 && value.length === 1) {
                    // If first digit is 2-9, it's invalid (can't be 20-99)
                    $(this).val('');
                    return;
                }
            }
            
            if (value.length >= 2) {
                var month = parseInt(value.substring(0, 2));
                // If month is invalid (00, 13-99), prevent it
                if (month === 0 || month > 12) {
                    // Keep only first digit
                    value = value.substring(0, 1);
                }
            }
            
            // Format as MM/YY
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            } else {
                value = value.substring(0, 2);
            }
            
            $(this).val(value);
            
            // Validate expiry date in real-time
            validateExpiryDate();
            validateCardInputs();
        });

        // Validate CVV - Only numbers, 3-4 digits
        $('#card_cvc').on('input', function() {
            var value = $(this).val().replace(/\D/g, ''); // Remove all non-digits
            
            // Limit to 4 digits max
            if (value.length > 4) {
                value = value.substring(0, 4);
            }
            
            $(this).val(value);
            validateCardInputs();
        });

        // Prevent paste of invalid characters in CVV
        $('#card_cvc').on('paste', function(e) {
            e.preventDefault();
            var pastedText = (e.originalEvent.clipboardData || window.clipboardData).getData('text');
            var numbersOnly = pastedText.replace(/\D/g, '').substring(0, 4);
            $(this).val(numbersOnly);
            validateCardInputs();
        });

        // Validate cardholder name
        $('#card_name').on('input', function() {
            validateCardInputs();
        });

        // Validate all inputs on blur
        $('.card-input').on('blur', function() {
            if ($(this).attr('id') === 'card_expiry') {
                validateExpiryDate();
            }
            validateCardInputs();
        });

        // Prevent invalid keypress in expiry date
        $('#card_expiry').on('keypress', function(e) {
            var char = String.fromCharCode(e.which);
            var currentValue = $(this).val().replace(/\D/g, '');
            
            // Only allow digits
            if (!/\d/.test(char)) {
                e.preventDefault();
                return false;
            }
            
            // If first digit is 1, allow 0-2 for second digit (10-12)
            if (currentValue.length === 1 && currentValue[0] === '1') {
                if (char > '2') {
                    e.preventDefault();
                    return false;
                }
            }
            
            // If first digit is 0, allow 1-9 for second digit (01-09)
            if (currentValue.length === 1 && currentValue[0] === '0') {
                if (char === '0') {
                    e.preventDefault();
                    return false;
                }
            }
            
            // If first digit is 2-9, prevent (can't be 20-99)
            if (currentValue.length === 0 && parseInt(char) > 1) {
                e.preventDefault();
                return false;
            }
        });

        // Prevent invalid keypress in CVV
        $('#card_cvc').on('keypress', function(e) {
            // Only allow digits
            if (!/\d/.test(String.fromCharCode(e.which))) {
                e.preventDefault();
                return false;
            }
        });
    }

    // Validate expiry date specifically
    function validateExpiryDate() {
        var cardExpiry = $('#card_expiry').val();
        var displayError = $('#card_expiry').next('.invalid-feedback');
        
        if (!cardExpiry) {
            $('#card_expiry').removeClass('is-valid is-invalid');
            return false;
        }
        
        var expiryRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
        if (!expiryRegex.test(cardExpiry)) {
            $('#card_expiry').addClass('is-invalid').removeClass('is-valid');
            if (cardExpiry.length === 5) {
                displayError.text('Invalid expiry date format');
            }
            return false;
        }
        
        // Check if expiry is in the past or too far in the future
        var parts = cardExpiry.split('/');
        var month = parseInt(parts[0]);
        var year = parseInt('20' + parts[1]);
        var expiryDate = new Date(year, month, 0); // Last day of expiry month
        var today = new Date();
        today.setHours(0, 0, 0, 0);
        var maxFutureDate = new Date();
        maxFutureDate.setFullYear(maxFutureDate.getFullYear() + 20); // Max 20 years in future
        
        if (expiryDate < today) {
            $('#card_expiry').addClass('is-invalid').removeClass('is-valid');
            displayError.text('Card has expired');
            return false;
        }
        
        if (expiryDate > maxFutureDate) {
            $('#card_expiry').addClass('is-invalid').removeClass('is-valid');
            displayError.text('Invalid expiry date');
            return false;
        }
        
        $('#card_expiry').addClass('is-valid').removeClass('is-invalid');
        displayError.text('');
        return true;
    }

    // Validate all card inputs
    function validateCardInputs() {
        var cardNumber = $('#card_number').val().replace(/\s/g, '');
        var cardExpiry = $('#card_expiry').val();
        var cardCvc = $('#card_cvc').val();
        var cardName = $('#card_name').val().trim();

        var isValid = true;
        var errorMessage = '';

        // Validate card number (13-19 digits)
        if (cardNumber.length < 13 || cardNumber.length > 19 || !/^\d+$/.test(cardNumber)) {
            isValid = false;
            $('#card_number').addClass('is-invalid').removeClass('is-valid');
        } else {
            $('#card_number').addClass('is-valid').removeClass('is-invalid');
        }

        // Validate expiry date
        if (!validateExpiryDate()) {
            isValid = false;
        }

        // Validate CVV (3-4 digits, numbers only)
        if (cardCvc.length < 3 || cardCvc.length > 4 || !/^\d+$/.test(cardCvc)) {
            isValid = false;
            $('#card_cvc').addClass('is-invalid').removeClass('is-valid');
            if (cardCvc.length > 0) {
                $('#card_cvc').next('.invalid-feedback').text('CVV must be 3-4 digits');
            }
        } else {
            $('#card_cvc').addClass('is-valid').removeClass('is-invalid');
            $('#card_cvc').next('.invalid-feedback').text('');
        }

        // Validate cardholder name
        if (cardName.length < 2) {
            isValid = false;
            $('#card_name').addClass('is-invalid').removeClass('is-valid');
            if (cardName.length > 0) {
                $('#card_name').next('.invalid-feedback').text('Cardholder name must be at least 2 characters');
            }
        } else {
            $('#card_name').addClass('is-valid').removeClass('is-invalid');
            $('#card_name').next('.invalid-feedback').text('');
        }

        // Display error message if any field is invalid
        if (!isValid) {
            $('#card-errors').text('Please fill in all card details correctly').show();
        } else {
            $('#card-errors').text('').hide();
        }

        isCardValid = isValid;
        cardComplete = isValid && cardNumber.length >= 13 && cardExpiry.length === 5 && cardCvc.length >= 3 && cardName.length >= 2;
        updateButtonState();
    }

    // Update button state based on validation
    function updateButtonState() {
        $('#payButton').prop('disabled', !(isCardValid && cardComplete && paymentIntentId));
    }

    // Initialize payment intent
    function initializePayment() {
        $('#payment-loading').show();
        
        var courseIds = [];
        @foreach($cart as $item)
            courseIds.push({{ $item['id'] }});
        @endforeach

        $.ajax({
            url: "{{ route('checkout.create.payment.intent') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                course_ids: courseIds
            },
            success: function(response){
                if(response.success){
                    paymentIntentId = response.payment_intent_id;
                    
                    $('#payment_intent_id').val(paymentIntentId);
                    
                    // Show payment form
                    $('#payment-loading').hide();
                    
                    // Update button state after payment intent is created
                    updateButtonState();
                }
                else{
                    showMessage(response.message || 'Failed to initialize payment', 'error');
                    $('#payment-loading').hide();
                    $('#payButton').prop('disabled', true);
                }
            },
            error: function(xhr, status, error){
                showMessage('Failed to initialize payment. Please refresh the page.', 'error');
                $('#payment-loading').hide();
            }
        });
    }


    // Handle cart item removal
    $(document).on('click', '.cart-item-remove', function(){
        var courseId = $(this).data('id');
        var cart = $(this).closest('.cart-item');
        $.ajax({
            url: "{{ route('front.checkout.remove.from.cart') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                course_id: courseId
            },
            success: function(response){
                if(response.success){
                    if(response.cart_count == 0){
                        window.location.href = "{{ route('front.courses') }}";
                    }
                    else{
                        cart.remove();
                        $('.cart-count').text(response.cart_count);
                        $('.total-price').text('₱' + parseFloat(response.cart_total).toFixed(2));
                        $('.cart-btn').removeClass('d-none');
                    }
                    showMessage(response.message, 'success');
                }
                else{
                    showMessage(response.message, 'info');
                }
            },
            error: function(xhr, status, error){
                showMessage('Failed to remove item from cart', 'error');
            }
        });
    });

    // Handle payment button click
    $(document).on('click', '#payButton', function(){
        var $btn = $(this);
        
        // Clear any previous error messages when user tries again
        hideMessage();
        
        if (!paymentIntentId) {
            showMessage('Payment not initialized. Please refresh the page.', 'error');
            return;
        }

        if (!isCardValid || !cardComplete) {
            showMessage('Please fill in all card details correctly.', 'error');
            return;
        }

        $btn.prop('disabled', true);
        $btn.find('i').addClass('fa-spinner fa-spin').removeClass('fa-lock');
        $btn.find('.checkout-btn-text').text('Processing...');

        processCardPayment($btn);
    });

    // Process card payment - Collect card details and send to server
    function processCardPayment($btn) {
        // Clear any previous error messages
        hideMessage();
        
        if (!paymentIntentId) {
            showMessage('Payment intent not initialized. Please refresh the page.', 'error');
            resetButton($btn);
            return;
    }

        // Collect card details from form
        var cardNumber = $('#card_number').val().replace(/\s/g, '');
        var cardExpiry = $('#card_expiry').val();
        var cardCvc = $('#card_cvc').val();
        var cardName = $('#card_name').val().trim();

        // Validate card details
        if (!cardNumber || cardNumber.length < 13 || cardNumber.length > 19) {
            showMessage('Please enter a valid card number', 'error');
            $('#card_number').focus();
            resetButton($btn);
            return;
        }

        // Validate expiry date format and check if expired
        if (!cardExpiry || !/^(0[1-9]|1[0-2])\/\d{2}$/.test(cardExpiry)) {
            showMessage('Please enter a valid expiry date (MM/YY)', 'error');
            $('#card_expiry').focus();
            resetButton($btn);
            return;
        }

        // Check if card has expired
        var expiryParts = cardExpiry.split('/');
        var expMonth = parseInt(expiryParts[0]);
        var expYear = parseInt('20' + expiryParts[1]);
        var expiryDate = new Date(expYear, expMonth, 0);
        var today = new Date();
        if (expiryDate < today) {
            showMessage('Card has expired. Please use a valid card.', 'error');
            $('#card_expiry').focus();
            resetButton($btn);
            return;
        }

        // Validate CVV (must be 3-4 digits, numbers only)
        if (!cardCvc || cardCvc.length < 3 || cardCvc.length > 4 || !/^\d+$/.test(cardCvc)) {
            showMessage('Please enter a valid CVV (3-4 digits)', 'error');
            $('#card_cvc').focus();
            resetButton($btn);
            return;
        }

        if (!cardName || cardName.length < 2) {
            showMessage('Please enter cardholder name', 'error');
            $('#card_name').focus();
            resetButton($btn);
            return;
        }

        // Parse expiry date - Ensure integers
        var expiryParts = cardExpiry.split('/');
        var expMonth = parseInt(expiryParts[0], 10); // Base 10 to ensure integer
        var expYear = parseInt('20' + expiryParts[1], 10); // Base 10 to ensure integer
        
        // Validate parsed values
        if (isNaN(expMonth) || isNaN(expYear)) {
            showMessage('Invalid expiry date format', 'error');
            $('#card_expiry').focus();
            resetButton($btn);
            return;
        }

        console.log('Processing payment with card details...');
        console.log('Payment Intent ID:', paymentIntentId);
        console.log('Card Number:', cardNumber.substring(0, 4) + '****' + cardNumber.substring(cardNumber.length - 4));

        // Send card details to server for processing
        $.ajax({
            url: "{{ route('checkout.process.payment') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                payment_intent_id: paymentIntentId,
                card_number: cardNumber,
                card_exp_month: expMonth,
                card_exp_year: expYear,
                card_cvc: cardCvc,
                card_name: cardName,
                billing_email: '{{ Auth::user()->email }}'
            },
            success: function(response) {
                console.log('Payment processing response:', response);
                
                if (response.success) {
                    if (response.payment_status === 'paid') {
                        showMessage(response.message || 'Payment successful!', 'success');
                        setTimeout(function() {
                            window.location.href = "{{ route('dashboard') }}";
                        }, 2000);
                    } else if (response.requires_action && response.next_action) {
                        // Handle 3D Secure or other authentication
                        console.log('Payment requires action:', response.next_action);
                        if (response.next_action.type === 'redirect' && response.next_action.redirect?.url) {
                            showMessage('Redirecting for secure authentication...', 'info');
                            setTimeout(function() {
                                window.location.href = response.next_action.redirect.url;
                            }, 1500);
                        } else {
                            verifyPaymentStatus(paymentIntentId, $btn);
                        }
                    } else {
                        // Payment pending, verify status
                        verifyPaymentStatus(paymentIntentId, $btn);
                    }
                } else {
                    // Extract user-friendly error message from server
                    // Server already converts PayMongo technical errors to user-friendly messages
                    var errorMsg = 'Card is not valid';
                    
                    if (response.message) {
                        // Server already provides user-friendly message
                        errorMsg = response.message;
                    } else if (response.errors && Array.isArray(response.errors) && response.errors.length > 0) {
                        // Fallback: try to extract from errors array
                        // But prefer user-friendly message from server
                        errorMsg = response.errors[0].detail || response.errors[0].message || errorMsg;
                    }
                    
                    console.error('Payment error:', errorMsg, response);
                    // Always show error messages in red
                    showMessage(errorMsg, 'error');
                    resetButton($btn);
                }
            },
            error: function(xhr, status, error) {
                console.error('Payment processing error:', xhr, status, error);
                var errorMsg = 'Card is not valid';
                
                // Try to extract user-friendly error message from server response
                if (xhr.responseJSON) {
                    // Server already converts PayMongo errors to user-friendly messages
                    if (xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON.errors && Array.isArray(xhr.responseJSON.errors) && xhr.responseJSON.errors.length > 0) {
                        // Fallback: extract from errors array
                        if (typeof xhr.responseJSON.errors[0] === 'string') {
                            errorMsg = xhr.responseJSON.errors[0];
                        } else if (xhr.responseJSON.errors[0].detail) {
                            errorMsg = xhr.responseJSON.errors[0].detail;
                        } else if (xhr.responseJSON.errors[0].message) {
                            errorMsg = xhr.responseJSON.errors[0].message;
                        }
                    } else if (xhr.responseJSON.error) {
                        errorMsg = xhr.responseJSON.error;
                    }
                } else if (xhr.responseText) {
                    try {
                        var parsed = JSON.parse(xhr.responseText);
                        if (parsed.message) {
                            errorMsg = parsed.message;
                        } else if (parsed.errors && parsed.errors.length > 0) {
                            errorMsg = parsed.errors[0].detail || parsed.errors[0].message || errorMsg;
                        }
                    } catch (e) {
                        // If not JSON, use response text if short
                        if (xhr.responseText.length < 200) {
                            errorMsg = xhr.responseText;
                        }
                    }
                }
                
                console.error('Extracted error message:', errorMsg);
                // Always show error messages in red
                showMessage(errorMsg, 'error');
                resetButton($btn);
            }
        });
    }


    // Process payment on server after client-side confirmation
    function processPaymentOnServer(paymentIntentId, paymentMethodId, $btn) {
        verificationAttempts = 0; // Reset verification attempts counter
        
        $.ajax({
            url: "{{ route('checkout.process.payment') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                payment_intent_id: paymentIntentId,
                payment_method_id: paymentMethodId
            },
            success: function(response){
                console.log('Payment processing response:', response);
                
                if(response.success){
                    if(response.payment_status === 'paid'){
                        showMessage(response.message || 'Payment successful!', 'success');
                        setTimeout(function(){
                    window.location.href = "{{ route('dashboard') }}";
                        }, 2000);
                    } else if(response.requires_action && response.next_action){
                        // Handle 3D Secure or other authentication
                        console.log('Payment requires action:', response.next_action);
                        showMessage('Payment requires additional authentication. Please complete the verification.', 'warning');
                        
                        // Handle 3D Secure authentication if required
                        // Poll for status updates
                        verifyPaymentStatus(paymentIntentId, $btn);
                    } else {
                        // Payment pending, verify status
                        console.log('Payment status:', response.payment_intent_status);
                        if(response.payment_intent_status === 'processing'){
                            showMessage('Payment is being processed. Please wait...', 'info');
                        } else {
                            showMessage('Payment is being processed. Verifying status...', 'info');
                        }
                        verifyPaymentStatus(paymentIntentId, $btn);
                    }
                }
                else{
                    showMessage(response.message || 'Payment processing failed', 'error');
                    resetButton($btn);
                }
            },
            error: function(xhr, status, error){
                console.error('Payment processing error:', xhr.responseJSON);
                var errorMsg = 'Payment processing failed';
                if(xhr.responseJSON && xhr.responseJSON.message){
                    errorMsg = xhr.responseJSON.message;
                }
                showMessage(errorMsg, 'error');
                resetButton($btn);
            }
        });
    }

    // Verify payment status
    let verificationAttempts = 0;
    const maxVerificationAttempts = 30; // 60 seconds max (30 attempts * 2 seconds)
    
    function verifyPaymentStatus(paymentIntentId, $btn) {
        verificationAttempts++;
        
        if (verificationAttempts > maxVerificationAttempts) {
            showMessage('Payment verification timeout. Please check your payment status or contact support.', 'error');
            resetButton($btn);
            return;
        }
        
        $.ajax({
            url: "{{ route('checkout.verify.payment') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                payment_intent_id: paymentIntentId
            },
            success: function(response){
                console.log('Payment verification response:', response);
                
                if(response.success && response.payment_status === 'paid'){
                    showMessage('Payment successful!', 'success');
                    setTimeout(function(){
                        window.location.href = "{{ route('dashboard') }}";
                    }, 2000);
                } else if(response.payment_status === 'failed'){
                    showMessage('Payment failed. Please try again with a different payment method.', 'error');
                    resetButton($btn);
                } else if(response.requires_action){
                    showMessage('Payment requires additional authentication. Please complete the verification.', 'warning');
                    // Continue checking
                    setTimeout(function(){
                        verifyPaymentStatus(paymentIntentId, $btn);
                    }, 2000);
                } else {
                    // Still processing
                    if (verificationAttempts % 5 === 0) {
                        showMessage('Payment is being processed. Please wait... (Attempt ' + verificationAttempts + '/' + maxVerificationAttempts + ')', 'info');
                    }
                    setTimeout(function(){
                        verifyPaymentStatus(paymentIntentId, $btn);
                    }, 2000);
                }
            },
            error: function(xhr, status, error){
                console.error('Payment verification error:', xhr.responseJSON);
                if (verificationAttempts >= 5) {
                    showMessage('Failed to verify payment status. Please check your payment or contact support.', 'error');
                    resetButton($btn);
                } else {
                    // Retry on error
                    setTimeout(function(){
                        verifyPaymentStatus(paymentIntentId, $btn);
                    }, 2000);
                }
            }
        });
    }


    // Reset button state
    function resetButton($btn) {
        $btn.prop('disabled', false);
        $btn.find('i').removeClass('fa-spinner fa-spin').addClass('fa-lock');
        $btn.find('.checkout-btn-text').text('Complete Purchase');
            }
</script>
@endsection