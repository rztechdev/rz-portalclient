<?php

namespace App\Services\WhatsApp;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FlustraWhatsAppService
{
    protected string $apiUrl;
    protected string $apiKey;

    public function __construct()
    {
        try {
            $settings = \App\Models\CompanySetting::get();
            $this->apiUrl = !empty($settings->wa_api_url) ? $settings->wa_api_url : config('flustra.api_url', 'https://wa.flustra.id/api/v1/messages/text');
            $this->apiKey = !empty($settings->wa_api_key) ? $settings->wa_api_key : config('flustra.api_key', '');
        } catch (\Throwable $e) {
            $this->apiUrl = config('flustra.api_url', 'https://wa.flustra.id/api/v1/messages/text');
            $this->apiKey = config('flustra.api_key', '');
        }
    }

    /**
     * Normalize phone number to standard international format (628...).
     */
    public function normalizePhoneNumber(string $phone): string
    {
        $cleaned = preg_replace('/[^\d+]/', '', $phone);

        if (str_starts_with($cleaned, '+')) {
            $cleaned = substr($cleaned, 1);
        }

        if (str_starts_with($cleaned, '08')) {
            $cleaned = '628' . substr($cleaned, 2);
        } elseif (str_starts_with($cleaned, '8')) {
            $cleaned = '628' . substr($cleaned, 1);
        }

        return $cleaned;
    }

    /**
     * Send WhatsApp message via Flustra WA Gateway.
     */
    public function sendWhatsApp(string $to, string $message): array
    {
        $normalizedTo = $this->normalizePhoneNumber($to);

        if (empty($this->apiKey)) {
            Log::info("Portal Flustra WA [SIMULATED]: Message sent to {$normalizedTo}", [
                'message' => $message,
            ]);

            return [
                'success' => true,
                'status' => 'simulated_sent',
                'data' => ['simulated' => true],
            ];
        }

        try {
            $response = Http::withHeaders([
                'X-Api-Key' => $this->apiKey,
                'Accept' => 'application/json',
            ])->timeout(12)->post($this->apiUrl, [
                'to' => $normalizedTo,
                'message' => $message,
            ]);

            $responseBody = $response->json() ?? ['raw' => $response->body()];
            $isSuccess = $response->successful() && ($responseBody['success'] ?? true);

            return [
                'success' => $isSuccess,
                'status' => $isSuccess ? 'sent' : 'failed',
                'data' => $responseBody,
            ];
        } catch (\Throwable $e) {
            Log::error("Portal Flustra WA Gateway Exception: " . $e->getMessage(), [
                'to' => $normalizedTo,
            ]);

            return [
                'success' => false,
                'status' => 'failed',
                'message' => $e->getMessage(),
            ];
        }
    }
}
