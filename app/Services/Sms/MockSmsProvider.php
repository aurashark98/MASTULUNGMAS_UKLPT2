<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Log;

class MockSmsProvider implements SmsServiceInterface
{
    /**
     * Mock sending SMS by logging it.
     */
    public function send(string $phoneNumber, string $message): bool
    {
        Log::info("SMS Mock Sent to {$phoneNumber}: {$message}");
        return true;
    }
}
