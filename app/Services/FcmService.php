<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
}
