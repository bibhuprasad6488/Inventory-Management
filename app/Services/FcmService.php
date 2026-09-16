<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FcmService
{
    /**
     * Send notification to an Expo Push Token
     */
    public function sendToToken(
        string $token,
        string $title,
        string $body,
        array $data = []
    ): array {
        try {

            $payload = [
                'to' => $token,
                'title' => $title,
                'body' => $body,
                'sound' => 'default',
                'data' => $data,
            ];

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip, deflate',
                'Content-Type' => 'application/json',
            ])->post(
                'https://exp.host/--/api/v2/push/send',
                $payload
            );

            $responseData = $response->json();

            if ($response->successful()) {

                return [
                    'success' => true,
                    'response' => $responseData,
                ];
            }

            Log::error('Expo Push Notification Error', [
                'status' => $response->status(),
                'response' => $responseData,
                'token' => $token,
            ]);

            return [
                'success' => false,
                'response' => $responseData,
            ];
        } catch (\Throwable $e) {

            Log::error('Expo Push Notification Exception', [
                'message' => $e->getMessage(),
                'token' => $token,
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function sendNotificaton($orderId, $userId)
    {
        $order = Order::with('retailer')->find($orderId);

        if (!$order) {
            Log::error('Order not found while sending notification email', ['order_id' => $orderId, 'user_id' => $userId,]);
            return false;
        }

        $toEmail = ['soumya.maastrix@gmail.com', 'bibhuprasad.maastrix@gmail.com'];
        $subject = 'New Order Notification';
        $body = "Hello Admin,\n\n"
            . "A new order has been placed.\n\n"
            . "Retailer Name: {$order->retailer->billing_name}\n"
            . "Email Address: {$order->retailer->email}\n"
            . "Phone: {$order->retailer->phone}\n"
            . "Order Number: {$order->order_number}\n"
            . "Order Date: " . now()->format('d M Y, h:i A')
            . "\n\n" . "Thank you for your business.\n\n"
            . "Regards,\n"
            . "Trumate Services";

        try {

            Mail::raw($body, function ($message) use ($toEmail, $subject) {
                $message->to($toEmail)
                    ->subject($subject);
            });

            Log::info('New Order Notification Email Sent Successfully', [
                'email' => $toEmail,
                'order_id' => $order->id,
                'order_number' => $order->order_number,
            ]);
            return true;
        } catch (\Throwable $th) {
            Log::error('Failed to Send New Order Notification Email', [
                'email' => $toEmail,
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'error' => $th->getMessage(),
            ]);
            return false;
        }
    }
}
