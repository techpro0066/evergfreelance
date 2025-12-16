<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuyCourse;
use App\Models\Payment;
use App\Models\Course;
use App\Services\PayMongoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    protected $payMongoService;

    public function __construct(PayMongoService $payMongoService)
    {
        $this->payMongoService = $payMongoService;
    }

    /**
     * Create payment intent and initialize checkout
     */
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'course_ids' => 'required|array',
            'course_ids.*' => 'exists:courses,id',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty'
            ], 400);
        }

        // Calculate total amount
        $totalAmount = 0;
        $courseIds = [];
        $courseTitles = [];
        
        foreach ($cart as $item) {
            $totalAmount += $item['price'];
            $courseIds[] = $item['id'];
            $courseTitles[] = $item['title'];
        }

        // Generate order reference
        $orderReference = $this->payMongoService->generateOrderReference();
        
        // Create payment intent
        $description = 'Payment for courses: ' . implode(', ', $courseTitles);
        // PayMongo requires all metadata values to be strings
        $metadata = [
            'user_id' => (string)Auth::id(),
            'order_reference' => $orderReference,
            'course_ids' => implode(',', $courseIds), // Convert array to comma-separated string
        ];

        $paymentIntent = $this->payMongoService->createPaymentIntent(
            $totalAmount,
            $description,
            $metadata
        );

        if (!$paymentIntent['success']) {
            return response()->json([
                'success' => false,
                'message' => $paymentIntent['message'] ?? 'Failed to create payment intent'
            ], 500);
        }

        // Store payment intent ID and order reference in session
        session()->put('payment_intent_id', $paymentIntent['payment_intent_id']);
        session()->put('order_reference', $orderReference);
        session()->put('checkout_amount', $totalAmount);

        return response()->json([
            'success' => true,
            'payment_intent_id' => $paymentIntent['payment_intent_id'],
            'client_key' => $paymentIntent['client_key'],
            'public_key' => config('services.paymongo.public_key', env('PAYMONGO_PUBLIC_KEY')), // Pass public key for SDK initialization
            'amount' => $totalAmount,
            'order_reference' => $orderReference,
        ]);
    }

    /**
     * Process payment after payment method is attached
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
        ]);

        // payment_method_id is optional - if not provided, we'll handle it differently
        $paymentMethodId = $request->payment_method_id ?? null;

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty'
            ], 400);
        }

        // Check if payment already exists for this payment intent
        $existingPayment = Payment::where('payment_intent_id', $request->payment_intent_id)->first();
        if ($existingPayment) {
            // Payment already processed, return success
            return response()->json([
                'success' => true,
                'message' => 'Payment already processed',
                'payment_status' => $existingPayment->status === 'paid' ? 'paid' : 'pending',
                'payment_intent_status' => $existingPayment->status,
                'order_reference' => $existingPayment->order_reference,
                'payment_method_attached' => !empty($existingPayment->payment_method_id),
            ]);
        }

        try {
            DB::beginTransaction();

            $paymentIntent = null;
            $status = 'pending';
            $paymentMethodType = 'card';
            $paymentMethodId = $request->payment_method_id;
            
            // If card details are provided, create payment method first
            if ($request->has('card_number')) {
                // Validate card details
                $request->validate([
                    'card_number' => 'required|string|min:13|max:19',
                    'card_exp_month' => 'required|integer|between:1,12',
                    'card_exp_year' => 'required|integer|min:2020',
                    'card_cvc' => 'required|string|min:3|max:4',
                    'card_name' => 'required|string|min:2',
                ]);

                // Create payment method with card details
                // PayMongo requires exp_month (1-12) and exp_year (4-digit) to be integers
                $expMonth = (int)$request->card_exp_month;
                $expYear = (int)$request->card_exp_year;
                
                // Validate month is between 1-12
                if ($expMonth < 1 || $expMonth > 12) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid expiry month. Month must be between 1 and 12.'
                    ], 400);
                }
                
                // Validate year is 4-digit and reasonable
                if ($expYear < 2020 || $expYear > 2100) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid expiry year.'
                    ], 400);
                }
                
                $cardData = [
                    'card_number' => $request->card_number,
                    'exp_month' => $expMonth,
                    'exp_year' => $expYear,
                    'cvc' => $request->card_cvc,
                ];
                
                Log::info('Creating payment method with card data', [
                    'exp_month' => $expMonth,
                    'exp_month_type' => gettype($expMonth),
                    'exp_year' => $expYear,
                    'exp_year_type' => gettype($expYear),
                ]);

                $billing = [
                    'name' => $request->card_name,
                    'email' => $request->billing_email ?? Auth::user()->email,
                ];

                $createPaymentMethodResult = $this->payMongoService->createPaymentMethod(
                    'card',
                    $cardData,
                    $billing
                );

                if (!$createPaymentMethodResult['success']) {
                    DB::rollBack();
                    // The PayMongoService already converts to user-friendly message
                    $errorMessage = $createPaymentMethodResult['message'] ?? 'Card is not valid';
                    $errorDetails = $createPaymentMethodResult['errors'] ?? [];
                    
                    Log::error('Failed to create payment method', [
                        'user_message' => $errorMessage,
                        'technical_message' => $createPaymentMethodResult['technical_message'] ?? null,
                        'errors' => $errorDetails
                    ]);
                    
                    return response()->json([
                        'success' => false,
                        'message' => $errorMessage,
                        'errors' => $errorDetails,
                    ], 400); // Changed to 400 (Bad Request) instead of 500
                }

                $paymentMethodId = $createPaymentMethodResult['payment_method_id'];
                Log::info('Payment method created', [
                    'payment_method_id' => $paymentMethodId
                ]);
            }

            // Attach payment method to payment intent
            if ($paymentMethodId) {
                $attachResult = $this->payMongoService->attachPaymentMethod(
                    $request->payment_intent_id,
                    $paymentMethodId
                );

                if (!$attachResult['success']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => $attachResult['message'] ?? 'Failed to attach payment method'
                    ], 500);
                }

                $paymentIntent = $attachResult['data'];
                $attributes = is_array($paymentIntent) ? ($paymentIntent['attributes'] ?? []) : ($paymentIntent->attributes ?? []);
                $status = $attributes['status'] ?? 'pending';
                $nextAction = $attributes['next_action'] ?? null;
                $paymentMethodType = $attributes['payment_method_allowed'][0] ?? 'card';
                
                // Log the status immediately after attachment
                Log::info('Payment method attached - status check', [
                    'payment_intent_id' => $request->payment_intent_id,
                    'status' => $status,
                    'status_type' => gettype($status),
                    'is_succeeded' => ($status === 'succeeded'),
                    'attributes_keys' => array_keys($attributes)
                ]);
                
                // Log attachment result
                Log::info('Payment method attached', [
                    'payment_intent_id' => $request->payment_intent_id,
                    'payment_method_id' => $paymentMethodId,
                    'status' => $status,
                    'next_action' => $nextAction ? 'required' : 'none'
                ]);

                // If next_action is required, redirect the user
                if ($nextAction && isset($nextAction['redirect']['url'])) {
                    DB::commit();
                    return response()->json([
                        'success' => true,
                        'message' => 'Payment requires additional authentication',
                        'payment_status' => 'pending',
                        'payment_intent_status' => $status,
                        'requires_action' => true,
                        'next_action' => [
                            'type' => 'redirect',
                            'redirect' => [
                                'url' => $nextAction['redirect']['url']
                            ]
                        ],
                    ]);
                }
            } else {
                // No payment method ID or card details provided
                Log::warning('No payment method ID or card details provided', [
                    'payment_intent_id' => $request->payment_intent_id
                ]);
            }

            // Get payment intent details
            $paymentIntentDetails = $this->payMongoService->getPaymentIntent($request->payment_intent_id);
            if (!$paymentIntentDetails['success']) {
                DB::rollBack();
                Log::error('Failed to retrieve payment intent: ' . ($paymentIntentDetails['message'] ?? 'Unknown error'));
                return response()->json([
                    'success' => false,
                    'message' => $paymentIntentDetails['message'] ?? 'Failed to retrieve payment details'
                ], 500);
            }

            $paymentIntentData = $paymentIntentDetails['data'];
            $attributes = is_array($paymentIntentData) ? ($paymentIntentData['attributes'] ?? []) : ($paymentIntentData->attributes ?? []);
            $finalStatus = $attributes['status'] ?? $status;
            
            // Log status determination
            Log::info('Payment status determination', [
                'payment_intent_id' => $request->payment_intent_id,
                'status_from_attach' => $status,
                'status_from_get' => $attributes['status'] ?? 'not_set',
                'final_status' => $finalStatus,
                'is_succeeded' => $finalStatus === 'succeeded'
            ]);
            
            // Get amount from payment intent or session
            $amount = 0;
            if (isset($attributes['amount'])) {
                $amount = $attributes['amount'] / 100; // Convert from cents
            } else {
                $amount = session()->get('checkout_amount', 0);
            }
            
            if ($amount <= 0) {
                DB::rollBack();
                Log::error('Invalid payment amount: ' . $amount);
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid payment amount'
                ], 400);
            }
            
            // Get or generate order reference
            $orderReference = session()->get('order_reference');
            if (!$orderReference) {
                // Generate unique order reference (retry if duplicate)
                $maxRetries = 5;
                $retryCount = 0;
                do {
                    $orderReference = $this->payMongoService->generateOrderReference();
                    $exists = Payment::where('order_reference', $orderReference)->exists();
                    $retryCount++;
                } while ($exists && $retryCount < $maxRetries);
                
                if ($exists) {
                    DB::rollBack();
                    Log::error('Failed to generate unique order reference after ' . $maxRetries . ' attempts');
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to generate order reference. Please try again.'
                    ], 500);
                }
            }
            
            // Log payment processing details
            Log::info('Processing payment', [
                'payment_intent_id' => $request->payment_intent_id,
                'payment_method_id' => $paymentMethodId,
                'status' => $finalStatus,
                'amount' => $amount,
                'cart_count' => count($cart),
                'order_reference' => $orderReference
            ]);

            // Create buy_course records
            $buyCourseIds = [];
            $cartCount = count($cart);
            
            if ($cartCount == 0) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty'
                ], 400);
            }
            
            foreach ($cart as $item) {
                // Check if user already purchased this course
                $existingPurchase = BuyCourse::where('user_id', Auth::id())
                    ->where('course_id', $item['id'])
                    ->where('payment_status', 'paid')
                    ->first();

                if ($existingPurchase) {
                    continue; // Skip if already purchased
                }

                try {
                    $paymentStatus = ($finalStatus === 'succeeded') ? 'paid' : 'pending';
                    
                    Log::info('Creating buy_course record', [
                        'user_id' => Auth::id(),
                        'course_id' => $item['id'],
                        'payment_status' => $paymentStatus,
                        'final_status' => $finalStatus,
                        'amount' => $cartCount > 0 ? ($amount / $cartCount) : $amount
                    ]);
                    
                    $buyCourse = BuyCourse::create([
                        'user_id' => Auth::id(),
                        'course_id' => $item['id'],
                        'status' => 'active',
                        'payment_intent_id' => $request->payment_intent_id,
                        'payment_status' => $paymentStatus,
                        'amount_paid' => $cartCount > 0 ? ($amount / $cartCount) : $amount, // Split amount per course
                        'payment_method' => $paymentMethodType,
                        'order_reference' => $orderReference . '-' . $item['id'],
                        'paid_at' => $finalStatus === 'succeeded' ? now() : null,
                    ]);

                    Log::info('Buy_course record created successfully', [
                        'buy_course_id' => $buyCourse->id,
                        'payment_status' => $buyCourse->payment_status
                    ]);

                    $buyCourseIds[] = $buyCourse->id;
                } catch (\Exception $e) {
                    Log::error('Failed to create buy_course record: ' . $e->getMessage());
                    Log::error('Buy_course creation error trace: ' . $e->getTraceAsString());
                    throw $e;
                }
            }
            
            if (empty($buyCourseIds)) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'All courses in cart are already purchased'
                ], 400);
            }

            // Create payment record
            $description = 'Payment for ' . count($cart) . ' course(s)';
            try {
                $payment = $this->payMongoService->createPaymentRecord(
                    Auth::id(),
                    $buyCourseIds[0] ?? null,
                    $request->payment_intent_id,
                    $amount,
                    $orderReference,
                    $description
                );
            } catch (\Exception $e) {
                Log::error('Failed to create payment record: ' . $e->getMessage());
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create payment record: ' . (config('app.debug') ? $e->getMessage() : 'Please try again')
                ], 500);
            }

            // Update payment status
            $updateStatus = $finalStatus === 'succeeded' ? 'paid' : 'pending';
            Log::info('Updating payment status', [
                'payment_intent_id' => $request->payment_intent_id,
                'status' => $updateStatus,
                'final_status' => $finalStatus,
                'buy_course_ids' => $buyCourseIds
            ]);
            
            $this->payMongoService->updatePaymentStatus(
                $request->payment_intent_id,
                $updateStatus,
                $paymentMethodId, // Use the variable, not request input
                $paymentMethodType
            );

            DB::commit();
            
            Log::info('Payment transaction committed successfully', [
                'payment_intent_id' => $request->payment_intent_id,
                'buy_course_count' => count($buyCourseIds),
                'payment_status' => $updateStatus
            ]);

            // Determine final response message
            $responseMessage = 'Payment is being processed';
            if ($finalStatus === 'succeeded') {
                $responseMessage = 'Payment successful!';
            } elseif ($finalStatus === 'awaiting_payment_method' && !$paymentMethodId) {
                $responseMessage = 'Please complete payment method selection';
            } elseif ($finalStatus === 'awaiting_next_action') {
                $responseMessage = 'Payment requires additional authentication';
            }

            // Clear cart and session data only if payment succeeded
            if ($finalStatus === 'succeeded') {
        session()->forget('cart');
                session()->forget('payment_intent_id');
                session()->forget('order_reference');
                session()->forget('checkout_amount');
            }

            // Get next_action if status is awaiting_next_action
            $nextAction = null;
            if ($finalStatus === 'awaiting_next_action') {
                $nextAction = $attributes['next_action'] ?? null;
            }

            return response()->json([
                'success' => true,
                'message' => $responseMessage,
                'payment_status' => $finalStatus === 'succeeded' ? 'paid' : 'pending',
                'payment_intent_status' => $finalStatus,
                'order_reference' => $orderReference,
                'payment_method_attached' => !empty($paymentMethodId),
                'next_action' => $nextAction,
                'requires_action' => $finalStatus === 'awaiting_next_action',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment processing error: ' . $e->getMessage());
            Log::error('Payment processing error trace: ' . $e->getTraceAsString());
            
            // Return detailed error in development, generic in production
            $errorMessage = config('app.debug') 
                ? $e->getMessage() . ' (Line: ' . $e->getLine() . ')'
                : 'An error occurred while processing payment. Please try again.';
            
            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'error_details' => config('app.debug') ? [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ] : null
            ], 500);
        }
    }

    /**
     * Verify payment status
     */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
        ]);

        $paymentIntent = $this->payMongoService->getPaymentIntent($request->payment_intent_id);
        
        if (!$paymentIntent['success']) {
            return response()->json([
                'success' => false,
                'message' => 'Payment intent not found'
            ], 404);
        }

        $data = $paymentIntent['data'];
        $attributes = is_array($data) ? ($data['attributes'] ?? []) : ($data->attributes ?? []);
        $status = $attributes['status'] ?? 'pending';
        $nextAction = $attributes['next_action'] ?? null;
        
        // Map PayMongo status to our payment status
        $paymentStatus = 'pending';
        if ($status === 'succeeded') {
            $paymentStatus = 'paid';
            // Update payment status in database
            $this->payMongoService->updatePaymentStatus(
                $request->payment_intent_id,
                'paid',
                null,
                null
            );
        } elseif ($status === 'awaiting_payment_method') {
            $paymentStatus = 'pending';
        } elseif ($status === 'awaiting_next_action') {
            $paymentStatus = 'pending';
            // 3D Secure or other authentication required
        } elseif ($status === 'processing') {
            $paymentStatus = 'pending';
        } elseif ($status === 'payment_failed' || $status === 'failed') {
            $paymentStatus = 'failed';
            $this->payMongoService->updatePaymentStatus(
                $request->payment_intent_id,
                'failed',
                null,
                null
            );
        }

        Log::info('Payment verification', [
            'payment_intent_id' => $request->payment_intent_id,
            'status' => $status,
            'payment_status' => $paymentStatus,
            'next_action' => $nextAction
        ]);

        return response()->json([
            'success' => true,
            'payment_status' => $paymentStatus,
            'status' => $status,
            'next_action' => $nextAction,
            'requires_action' => $status === 'awaiting_next_action',
        ]);
    }

    /**
     * Handle PayMongo webhook
     */
    public function webhook(Request $request)
    {
        // Verify webhook signature (implement based on PayMongo docs)
        // For now, we'll process the webhook
        
        $data = $request->input('data');
        
        if (!$data) {
            return response()->json(['error' => 'Invalid webhook data'], 400);
        }

        $eventType = $request->input('type', '');
        $attributes = $data['attributes'] ?? [];

        if ($eventType === 'payment_intent.succeeded' || $eventType === 'payment.succeeded') {
            $paymentIntentId = $attributes['payment_intent_id'] ?? $data['id'] ?? null;
            
            if ($paymentIntentId) {
                $paymentMethod = $attributes['payment_method'] ?? [];
                $paymentMethodType = is_array($paymentMethod) ? ($paymentMethod['type'] ?? null) : ($paymentMethod->type ?? null);
                
                $this->payMongoService->updatePaymentStatus(
                    $paymentIntentId,
                    'paid',
                    is_array($paymentMethod) ? ($paymentMethod['id'] ?? null) : ($paymentMethod->id ?? null),
                    $paymentMethodType
                );
            }
        } elseif ($eventType === 'payment_intent.payment_failed' || $eventType === 'payment.failed') {
            $paymentIntentId = $attributes['payment_intent_id'] ?? $data['id'] ?? null;
            
            if ($paymentIntentId) {
                $paymentMethod = $attributes['payment_method'] ?? [];
                $paymentMethodType = is_array($paymentMethod) ? ($paymentMethod['type'] ?? null) : ($paymentMethod->type ?? null);
                
                $this->payMongoService->updatePaymentStatus(
                    $paymentIntentId,
                    'failed',
                    is_array($paymentMethod) ? ($paymentMethod['id'] ?? null) : ($paymentMethod->id ?? null),
                    $paymentMethodType
                );
            }
        }

        return response()->json(['success' => true]);
    }
}
