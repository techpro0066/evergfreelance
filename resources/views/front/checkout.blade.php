@extends('layouts.front')

@section('title', 'Checkout | EverGreen Freelancing')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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

        /* Credit Card Section */
        .credit-card-section {
            margin: 2rem 0;
            padding: 2rem;
            background: #f8f9fa;
            border-radius: 15px;
            border: 2px solid #e9ecef;
        }

        .credit-card-section h3 {
            margin-bottom: 1.5rem;
            color: var(--primary-dark);
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
        }

        .cart-item-remove:hover {
            background: #dc3545;
            color: white;
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
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 2rem;
        }

        .checkout-btn:hover {
            background: linear-gradient(135deg, #2a7a8f, #1f5f6f);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(51, 156, 181, 0.3);
        }

        .checkout-btn:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
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
            .checkout-title {
                font-size: 2.5rem;
            }

            .checkout-form-section,
            .order-summary-section {
                padding: 2rem;
            }

            .order-summary-section {
                position: static;
                margin-top: 2rem;
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

                                <!-- Credit Card Fields -->
                                <div class="credit-card-section">
                                    <h3 class="form-label">Credit/Debit Card Details</h3>
                                    
                                    <div class="form-group">
                                        <label for="cardNumber" class="form-label">Card Number *</label>
                                        <input type="text" class="form-control" id="cardNumber" name="cardNumber" required placeholder="1234 5678 9012 3456" maxlength="19">
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="expiryDate" class="form-label">Expiry Date *</label>
                                                <input type="text" class="form-control" id="expiryDate" name="expiryDate" required placeholder="MM/YY" maxlength="5">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cvv" class="form-label">CVV *</label>
                                                <input type="text" class="form-control" id="cvv" name="cvv" required placeholder="123" maxlength="4">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="cardName" class="form-label">Name on Card *</label>
                                        <input type="text" class="form-control" id="cardName" name="cardName" required placeholder="Enter name as it appears on card">
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
                                            <div class="cart-item-price">${{ $item['price'] }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Price Breakdown -->
                            <div class="price-breakdown">
                                <div class="price-row">
                                    <span>Total:</span>
                                    <span class="total-price">${{ $total }}</span>
                                </div>
                            </div>

                            <button type="button" class="checkout-btn">
                                <i class="fas fa-lock me-2"></i>
                                <span class="checkout-btn-text">Complete Purchase</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    toastr.options = {
        "positionClass": "toast-top-center", 
        "timeOut": "3000"
    }
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

                        $('.total-price').text('$' + response.cart_total);

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

    function validate()
    {
        var isValid = true;
        $('.text-danger').remove();
        $('.is-invalid').removeClass('is-invalid');
        
        $('input').each(function(){
            if($(this).val() == ''){
                isValid = false;
                $(this).addClass('is-invalid');
                $(this).closest('.form-group').append('<div class="text-danger my-2">This field is required.</div>');
            }
        });
        return isValid;
    }

    $(document).on('click', '.checkout-btn', function(){
        if(!validate()){
            return;
        }

        console.log('checkout');

        $(this).prop('disabled', true);
        $(this).find('i').addClass('fa-spinner fa-spin').removeClass('fa-lock');
        $(this).find('.checkout-btn-text').text('Processing...');

        
        $.ajax({
            url: "{{ route('checkout') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response){
                if(response.success){

                    toastr.success(response.message);

                    window.location.href = "{{ route('dashboard') }}";

                }
                else{
                    toastr.info(response.message);
                    $(this).prop('disabled', false);
                    $(this).find('i').removeClass('fa-spinner fa-spin').addClass('fa-lock');
                    $(this).find('.checkout-btn-text').text('Complete Purchase');
                }
            },
            error: function(xhr, status, error){
                toastr.error(xhr.responseText);
                $(this).prop('disabled', false);
                $(this).find('i').removeClass('fa-spinner fa-spin').addClass('fa-lock');
                $(this).find('.checkout-btn-text').text('Complete Purchase');
            }
        });
    });
</script>
@endsection