<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        if ($request->user()->role === 'mitra') {
            return redirect()->route('mitra.dashboard');
        }
        return view('profile.edit', [
            'user' => $request->user(),
            'categories' => \App\Models\ServiceCategory::all(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        if ($request->user()->role === 'mitra') {
            return redirect()->route('mitra.dashboard');
        }
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Show the Mitra registration form.
     */
    public function showRegisterMitra(Request $request)
    {
        $user = $request->user();

        // If user already registered, redirect to profile edit
        if ($user->mitraProfile) {
            return redirect()->route('profile.edit');
        }

        return view('profile.register-mitra', [
            'user' => $user,
            'categories' => \App\Models\ServiceCategory::all(),
        ]);
    }

    /**
     * Upgrade user to Mitra.
     */
    public function upgradeToMitra(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        if ($user->mitraProfile()->exists()) {
            return Redirect::route('profile.edit')->with('error', 'Anda sudah mendaftar sebagai Mitra.');
        }

        $request->validate([
            'ktp_photo' => ['required', 'image', 'max:2048'],
            'profile_photo' => ['required', 'image', 'max:2048'],
            'skills' => ['required', 'array', 'min:1'],
            'skills.*' => ['string'],
            'bio' => ['required', 'string', 'min:10'],
        ]);

        $ktpPath = $request->file('ktp_photo')->store('mitra/ktp', 'public');
        $profilePhotoPath = $request->file('profile_photo')->store('mitra/profile_photos', 'public');

        $user->mitraProfile()->create([
            'ktp_path' => $ktpPath,
            'profile_photo_path' => $profilePhotoPath,
            'skills' => $request->input('skills'),
            'bio' => $request->input('bio'),
            'is_verified' => false,
        ]);

        return Redirect::route('profile.edit')->with('status', 'registered-as-mitra');
    }

    /**
     * Switch user role between user and mitra.
     */
    public function switchRole(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        if (!$user->mitraProfile || !$user->mitraProfile->is_verified) {
            return Redirect::route('profile.edit')->with('error', 'Anda belum terverifikasi sebagai Mitra.');
        }

        if ($user->role === 'user') {
            $user->role = 'mitra';
            $user->save();
            return Redirect::route('mitra.dashboard')->with('success', 'Mode Mitra diaktifkan.');
        } elseif ($user->role === 'mitra') {
            $user->role = 'user';
            $user->save();
            return Redirect::route('dashboard')->with('success', 'Mode Pengguna diaktifkan.');
        }

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Send password OTP to user.
     */
    public function sendPasswordOTP(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        
        $otp = rand(100000, 999999);
        
        session([
            'password_change_otp' => $otp,
            'password_change_otp_expires_at' => now()->addMinutes(10)
        ]);

        $responseData = [
            'success' => true,
            'message' => 'Kode OTP berhasil dikirim ke email Anda.'
        ];

        if (config('app.env') === 'local' || config('mail.default') === 'log') {
            $responseData['dev_otp'] = $otp;
        }

        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\PasswordOTPMail($otp));
            return response()->json($responseData);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal mengirim email OTP, OTP dicatat di log: ' . $otp . '. Error: ' . $e->getMessage());
            
            $responseData['message'] = 'Kode OTP berhasil dibuat (Periksa log/email Anda).';
            return response()->json($responseData);
        }
    }
}
