<?php

namespace App\Services\Sms;

interface SmsServiceInterface
{
    /**
     * Send SMS to a specific phone number.
     *
     * @param string $phoneNumber
     * @param string $message
     * @return bool
     */
    public function send(string $phoneNumber, string $message): bool;
}
