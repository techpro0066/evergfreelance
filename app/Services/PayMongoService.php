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
            $errorMessage = 'API request failed';
            
            // Extract direct error message from PayMongo gateway
            if (isset($error['errors']) && is_array($error['errors']) && count($error['errors']) > 0) {
                // Try to get the detail first (most descriptive), then message, then code
                $errorMessage = $error['errors'][0]['detail'] 
                    ?? $error['errors'][0]['message'] 
                    ?? $error['errors'][0]['code'] 
                    ?? 'API request failed';
            } elseif (isset($error['message'])) {
                $errorMessage = $error['message'];
            }
            
            \Log::error('PayMongo API error', [
                'endpoint' => $endpoint,
                'method' => $method,
                'status' => $response->status(),
                'error_message' => $errorMessage,
                'error' => $error
            ]);
            
            return [
                'success' => false,
                'message' => $errorMessage,
                'errors' => $error['errors'] ?? [],
                'status' => $response->status(),
            ];
        } catch (Exception $e) {
            \Log::error('PayMongo request exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'complete_error' => $e,
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
                'complete_error' => $e,
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
                'complete_error' => $e,
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
                'complete_error' => $e,
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
                'complete_error' => $e,
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

