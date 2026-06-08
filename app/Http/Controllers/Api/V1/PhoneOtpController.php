<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\OtpVerification;
use App\Services\Sms\SmsServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PhoneOtpController extends Controller
{
    protected $smsService;

    public function __construct(SmsServiceInterface $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * POST /api/v1/phone/send-otp
     * Send OTP to given phone number.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);

        $user        = $request->user();
        $phoneNumber = $request->phone_number;

        // Rate limiting: 60s between requests
        $lastOtp = OtpVerification::where('user_id', $user->id)->latest()->first();
        if ($lastOtp && $lastOtp->created_at->addSeconds(60)->isFuture()) {
            return response()->json([
                'success' => false,
                'message' => 'Tunggu 60 detik sebelum mengirim OTP lagi.',
            ], 429);
        }

        $otp = sprintf('%06d', mt_rand(1, 999999));

        OtpVerification::create([
            'user_id'      => $user->id,
            'phone_number' => $phoneNumber,
            'otp_code'     => Hash::make($otp),
            'expires_at'   => now()->addMinutes(5),
            'attempts'     => 0,
        ]);

        $this->smsService->send($phoneNumber, "Kode OTP Mas Tulung Mas Anda adalah: {$otp}. Berlaku selama 5 menit.");

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP telah dikirim ke nomor Anda.',
        ]);
    }

    /**
     * POST /api/v1/phone/verify-otp
     * Verify OTP code.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'otp'          => 'required|string|size:6',
        ]);

        $user      = $request->user();
        $otpRecord = OtpVerification::where('user_id', $user->id)
            ->where('phone_number', $request->phone_number)
            ->latest()
            ->first();

        if (!$otpRecord) {
            return response()->json(['success' => false, 'message' => 'Tidak ada data verifikasi ditemukan.'], 404);
        }

        if ($otpRecord->isExpired()) {
            return response()->json(['success' => false, 'message' => 'Kode OTP sudah kadaluarsa. Silakan kirim ulang.'], 422);
        }

        if ($otpRecord->attempts >= 3) {
            return response()->json(['success' => false, 'message' => 'Terlalu banyak percobaan. Silakan kirim OTP baru.'], 429);
        }

        $otpRecord->increment('attempts');

        if (!Hash::check($request->otp, $otpRecord->otp_code)) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP salah. Sisa percobaan: ' . (3 - $otpRecord->attempts),
            ], 422);
        }

        $user->update([
            'phone_number'      => $otpRecord->phone_number,
            'phone_verified_at' => now(),
        ]);

        OtpVerification::where('user_id', $user->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Nomor telepon berhasil diverifikasi!',
            'data'    => [
                'phone_number'      => $user->phone_number,
                'phone_verified_at' => $user->phone_verified_at,
            ],
        ]);
    }
}
