<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\BuyCourse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Exception;

class PayMongoService
{
    protected $secretKey;
    protected $publicKey;
    protected $baseUrl = 'https://api.paymongo.com/v1';

    public function __construct()
    {
        $this->secretKey = config('services.paymongo.secret_key', env('PAYMONGO_SECRET_KEY'));
        $this->publicKey = config('services.paymongo.public_key', env('PAYMONGO_PUBLIC_KEY'));
    }

    /**
     * Convert PayMongo technical error messages to user-friendly messages
     */
    protected function getUserFriendlyErrorMessage($technicalMessage)
    {
        $errorMappings = [
            // Card number errors
            'details.card_number format is invalid' => 'Card number is not valid',
            'details.card_number is required' => 'Card number is required',
            'card_number format is invalid' => 'Card number is not valid',
            'card number format is invalid' => 'Card number is not valid',
            'Please use PayMongo test cards only when creating test transactions' => 'Card number is not valid for testing',
            'livemode_mismatched' => 'Card number is not valid for testing',
            
            // Expiry date errors
            'details.exp_month should be an integer' => 'Expiry date is not valid',
            'details.exp_year should be an integer' => 'Expiry date is not valid',
            'details.exp_month is required' => 'Expiry date is required',
            'details.exp_year is required' => 'Expiry date is required',
            'exp_month should be an integer' => 'Expiry date is not valid',
            'exp_year should be an integer' => 'Expiry date is not valid',
            
            // CVV errors
            'details.cvc is required' => 'CVV is required',
            'details.cvc format is invalid' => 'CVV is not valid',
            'cvc is required' => 'CVV is required',
            'cvc format is invalid' => 'CVV is not valid',
            
            // Card validation errors
            'card validation failed' => 'Card details are not valid',
            'card declined' => 'Card was declined. Please try a different card',
            'insufficient funds' => 'Insufficient funds. Please try a different card',
            'expired card' => 'Card has expired. Please use a valid card',
            'invalid card' => 'Card is not valid',
            'invalid card number' => 'Card number is not valid',
            
            // Payment method errors
            'payment method creation failed' => 'Failed to process card details',
            'failed to create payment method' => 'Failed to process card details',
            
            // Generic errors
            'api_key_invalid' => 'Payment system error. Please contact support',
            'parameter_required' => 'Please fill in all required card details',
            'parameter_data_type_invalid' => 'Card details are not valid',
        ];
        
        // Check for exact match first
        if (isset($errorMappings[$technicalMessage])) {
            return $errorMappings[$technicalMessage];
        }
        
        // Check for partial matches (case-insensitive)
        $lowerMessage = strtolower($technicalMessage);
        foreach ($errorMappings as $key => $value) {
            if (stripos($lowerMessage, strtolower($key)) !== false) {
                return $value;
            }
        }
        
        // Check for common patterns
        if (stripos($lowerMessage, 'card_number') !== false || stripos($lowerMessage, 'card number') !== false) {
            return 'Card number is not valid';
        }
        
        if (stripos($lowerMessage, 'exp_month') !== false || stripos($lowerMessage, 'exp_year') !== false || stripos($lowerMessage, 'expiry') !== false) {
            return 'Expiry date is not valid';
        }
        
        if (stripos($lowerMessage, 'cvc') !== false || stripos($lowerMessage, 'cvv') !== false) {
            return 'CVV is not valid';
        }
        
        if (stripos($lowerMessage, 'card') !== false) {
            return 'Card is not valid';
        }
        
        // Default user-friendly message
        return 'Payment processing failed. Please check your card details and try again.';
    }

    /**
     * Make authenticated request to PayMongo API
     */
    protected function makeRequest($method, $endpoint, $data = [])
    {
        try {
            if (empty($this->secretKey)) {
                \Log::error('PayMongo secret key is not configured');
                return [
                    'success' => false,
                    'message' => 'PayMongo secret key is not configured. Please check your .env file.',
                ];
            }

            $url = $this->baseUrl . $endpoint;
            $auth = base64_encode($this->secretKey . ':');

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $auth,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->{strtolower($method)}($url, $data);

            if ($response->successful()) {
                $responseData = $response->json();
                return [
                    'success' => true,
                    'data' => $responseData['data'] ?? $responseData,
                ];
            }

            $error = $response->json();
            $technicalErrorMessage = 'API request failed';
            
            if (isset($error['errors']) && is_array($error['errors']) && count($error['errors']) > 0) {
                $technicalErrorMessage = $error['errors'][0]['detail'] ?? $error['errors'][0]['message'] ?? 'API request failed';
            } elseif (isset($error['message'])) {
                $technicalErrorMessage = $error['message'];
            }
            
            // Convert technical error to user-friendly message
            $userFriendlyMessage = $this->getUserFriendlyErrorMessage($technicalErrorMessage);
            
            \Log::error('PayMongo API error', [
                'endpoint' => $endpoint,
                'method' => $method,
                'status' => $response->status(),
                'technical_error' => $technicalErrorMessage,
                'user_friendly_error' => $userFriendlyMessage,
                'error' => $error
            ]);
            
            return [
                'success' => false,
                'message' => $userFriendlyMessage,
                'technical_message' => $technicalErrorMessage, // Keep for logging/debugging
                'errors' => $error['errors'] ?? [],
                'status' => $response->status(),
            ];
        } catch (Exception $e) {
            \Log::error('PayMongo request exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Create a payment intent for checkout
     */
    public function createPaymentIntent($amount, $description, $metadata = [])
    {
        try {
            // Convert amount to cents (PayMongo uses smallest currency unit)
            $amountInCents = (int)($amount * 100);

            // Ensure all metadata values are strings (PayMongo requirement)
            $flatMetadata = [];
            foreach ($metadata as $key => $value) {
                if (is_array($value)) {
                    $flatMetadata[$key] = implode(',', $value);
                } elseif (is_object($value)) {
                    $flatMetadata[$key] = json_encode($value);
                } else {
                    $flatMetadata[$key] = (string)$value;
                }
            }

            $payload = [
                'data' => [
                    'attributes' => [
                        'amount' => $amountInCents,
                        'payment_method_allowed' => ['card', 'gcash', 'grab_pay'],
                        'payment_method_options' => [
                            'card' => [
                                'request_three_d_secure' => 'automatic',
                            ],
                        ],
                        'currency' => 'PHP',
                        'description' => $description,
                        'metadata' => $flatMetadata,
                    ],
                ],
            ];

            $result = $this->makeRequest('POST', '/payment_intents', $payload);

            if ($result['success']) {
                return [
                    'success' => true,
                    'payment_intent_id' => $result['data']['id'],
                    'client_key' => $result['data']['attributes']['client_key'],
                    'data' => $result['data'],
                ];
            }

            return $result;
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Create a payment method
     */
    public function createPaymentMethod($type, $cardData, $billing = [])
    {
        try {
            $payload = [
                'data' => [
                    'attributes' => [
                        'type' => $type,
                        'details' => $cardData,
                        'billing' => $billing,
                    ],
                ],
            ];

            $result = $this->makeRequest('POST', '/payment_methods', $payload);

            if ($result['success']) {
                return [
                    'success' => true,
                    'payment_method_id' => $result['data']['id'],
                    'data' => $result['data'],
                ];
            }

            return $result;
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Attach payment method to payment intent
     */
    public function attachPaymentMethod($paymentIntentId, $paymentMethodId)
    {
        try {
            $payload = [
                'data' => [
                    'attributes' => [
                        'payment_method' => $paymentMethodId,
                    ],
                ],
            ];

            $result = $this->makeRequest('POST', "/payment_intents/{$paymentIntentId}/attach", $payload);

            if ($result['success']) {
                return [
                    'success' => true,
                    'data' => (object)$result['data'],
                ];
            }

            return $result;
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Retrieve payment intent
     */
    public function getPaymentIntent($paymentIntentId)
    {
        try {
            $result = $this->makeRequest('GET', "/payment_intents/{$paymentIntentId}");

            if ($result['success']) {
                return [
                    'success' => true,
                    'data' => (object)$result['data'],
                ];
            }

            return $result;
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Create payment record in database
     */
    public function createPaymentRecord($userId, $buyCourseId, $paymentIntentId, $amount, $orderReference, $description = null)
    {
        try {
            return Payment::create([
                'user_id' => $userId,
                'buy_course_id' => $buyCourseId,
                'payment_intent_id' => $paymentIntentId,
                'status' => 'pending',
                'amount' => $amount,
                'currency' => 'PHP',
                'order_reference' => $orderReference,
                'description' => $description,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to create payment record: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus($paymentIntentId, $status, $paymentMethodId = null, $paymentMethodType = null)
    {
        \Log::info('Updating payment status', [
            'payment_intent_id' => $paymentIntentId,
            'status' => $status,
            'payment_method_id' => $paymentMethodId,
            'payment_method_type' => $paymentMethodType
        ]);
        
        $payment = Payment::where('payment_intent_id', $paymentIntentId)->first();
        
        if ($payment) {
            $payment->update([
                'status' => $status,
                'payment_method_id' => $paymentMethodId,
                'payment_method_type' => $paymentMethodType,
                'paid_at' => $status === 'paid' ? now() : null,
            ]);

            \Log::info('Payment record updated', [
                'payment_id' => $payment->id,
                'status' => $payment->status
            ]);

            // Update all buy_courses associated with this payment intent
            $buyCourses = BuyCourse::where('payment_intent_id', $paymentIntentId)->get();
            
            \Log::info('Found buy_courses to update', [
                'count' => $buyCourses->count(),
                'payment_intent_id' => $paymentIntentId
            ]);
            
            foreach ($buyCourses as $buyCourse) {
                $buyCourse->update([
                    'payment_status' => $status,
                    'payment_method' => $paymentMethodType,
                    'paid_at' => $status === 'paid' ? now() : null,
                ]);
                
                \Log::info('Buy_course updated', [
                    'buy_course_id' => $buyCourse->id,
                    'course_id' => $buyCourse->course_id,
                    'payment_status' => $buyCourse->payment_status,
                    'user_id' => $buyCourse->user_id
                ]);
            }
        } else {
            \Log::warning('Payment record not found for payment_intent_id', [
                'payment_intent_id' => $paymentIntentId
            ]);
        }

        return $payment;
    }

    /**
     * Generate unique order reference
     */
    public function generateOrderReference()
    {
        return 'ORD-' . strtoupper(Str::random(10)) . '-' . time();
    }
}

