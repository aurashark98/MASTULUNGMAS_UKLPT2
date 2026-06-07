<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validateWithBag('updatePassword', [
            'otp' => ['required', 'string'],
        ]);

        $otp = $request->input('otp');
        $sessionOtp = session('password_change_otp');
        $expiresAt = session('password_change_otp_expires_at');

        if (!$sessionOtp || !$expiresAt || now()->isAfter($expiresAt) || $otp !== (string)$sessionOtp) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'otp' => ['Kode verifikasi OTP salah atau telah kedaluwarsa.'],
            ])->errorBag('updatePassword');
        }

        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        session()->forget(['password_change_otp', 'password_change_otp_expires_at']);

        return back()->with('status', 'password-updated');
    }
}
