<?php

namespace App\Http\Controllers;

use App\Models\OtpVerification;
use App\Services\Sms\SmsServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class PhoneVerificationController extends Controller
{
    protected $smsService;

    public function __construct(SmsServiceInterface $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Send OTP to user's phone number.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);

        $user = Auth::user();
        $phoneNumber = $request->phone_number;

        // Rate limiting check: check if there was a request in the last 60 seconds
        $lastOtp = OtpVerification::where('user_id', $user->id)->latest()->first();
        if ($lastOtp && $lastOtp->created_at->addSeconds(60)->isFuture()) {
            return back()->with('error', 'Tunggu 60 detik sebelum mengirim OTP lagi.');
        }

        // Generate 6-digit OTP
        $otp = sprintf("%06d", mt_rand(1, 999999));
        
        // Store OTP securely (hashed)
        OtpVerification::create([
            'user_id' => $user->id,
            'phone_number' => $phoneNumber,
            'otp_code' => Hash::make($otp),
            'expires_at' => now()->addMinutes(5),
            'attempts' => 0,
        ]);

        // Send SMS
        $this->smsService->send($phoneNumber, "Kode OTP Mas Tulung Mas Anda adalah: {$otp}. Berlaku selama 5 menit.");

        // Store phone number in session for verification
        session(['pending_phone_number' => $phoneNumber]);

        return back()->with('success', 'Kode OTP telah dikirim ke nomor Anda.');
    }

    /**
     * Verify OTP code.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $user = Auth::user();
        $otpRecord = OtpVerification::where('user_id', $user->id)
            ->where('phone_number', session('pending_phone_number'))
            ->latest()
            ->first();

        if (!$otpRecord) {
            return back()->with('error', 'Tidak ada data verifikasi ditemukan.');
        }

        // Check expiration
        if ($otpRecord->isExpired()) {
            return back()->with('error', 'Kode OTP sudah kadaluarsa. Silakan kirim ulang.');
        }

        // Check attempts
        if ($otpRecord->attempts >= 3) {
            return back()->with('error', 'Terlalu banyak percobaan. Silakan kirim OTP baru.');
        }

        // Increment attempts
        $otpRecord->increment('attempts');

        // Verify OTP
        if (Hash::check($request->otp, $otpRecord->otp_code)) {
            // Success: update user
            $user->update([
                'phone_number' => $otpRecord->phone_number,
                'phone_verified_at' => now(),
            ]);

            // Clean up session and records
            session()->forget('pending_phone_number');
            OtpVerification::where('user_id', $user->id)->delete();

            return back()->with('success', 'Nomor telepon berhasil diverifikasi!');
        }

        return back()->with('error', 'Kode OTP salah. Sisa percobaan: ' . (3 - $otpRecord->attempts));
    }
}
