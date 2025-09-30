<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaymobService
{
    protected $publicKey;
    protected $secretKey;
    protected $integrationId;
    protected $integrationId2;
    protected $notificationUrl;
    protected $redirectionUrl;


    public function __construct()
    {
        $this->publicKey = env('PAYMOB_PUBLIC_KEY');
        $this->secretKey = env('PAYMOB_SECRET_KEY');
        
        $this->integrationId = env('PAYMOB_INTEGRATION_ID');
        $this->integrationId2 = env('PAYMOB_INTEGRATION_ID2');

        $this->notificationUrl = env('PAYMOB_NOTIFICATION_URL');
        $this->redirectionUrl = env('PAYMOB_REDIRECTION_URL');
    }



    public function createPaymentIntent($amount, $billing_data, $invoiceId, $items, $payment_methods = null)
    {
        $payload = [
          'amount' => $amount,
          'payment_methods' => $payment_methods ?? [
            (int)$this->integrationId,
            (int)$this->integrationId2,
          ],
          'currency' => 'EGP',
          'billing_data' => $billing_data,
          'items' => $items,
          'redirection_url' => $this->redirectionUrl . '?invoice_id=' . $invoiceId,
          'notification_url' => $this->notificationUrl,
          'special_reference' => $invoiceId,
        ];
        return $payload;
    }


    public function checkout($payload)
    {
        $paymentIntent = $this->createPaymentIntent(
            $payload['amount'],
            $payload['billing_data'],
            $payload['invoiceId'],
            $payload['items'],
            $payload['payment_methods'] ?? null
        );
        
        $publicKey = $this->publicKey;
        
        $response = Http::withHeaders([
            'Authorization' => 'Token ' . $this->secretKey,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://accept.paymob.com/v1/intention/', $paymentIntent);

        $data = $response->json();

        if ($response->failed() || !isset($data['client_secret'])) {
            return [
                'status' => false,
                'message' => 'Failed to create payment intent',
                'details' => $data,
            ];
        }
        return [
            'data' => $data,
            'client_secret' => $data['client_secret'],
            'unified_checkout_url' => "https://accept.paymob.com/unifiedcheckout/?publicKey={$publicKey}&clientSecret={$data['client_secret']}",
        ];
    }




}