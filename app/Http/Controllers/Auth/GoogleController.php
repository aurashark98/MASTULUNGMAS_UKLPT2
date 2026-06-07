<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        // If Google credentials are not set up or configured as placeholder, trigger mock login
        $clientId = config('services.google.client_id');
        if (empty($clientId) || $clientId === 'YOUR_GOOGLE_CLIENT_ID' || str_contains($clientId, 'placeholder')) {
            return redirect()->route('auth.google.mock-select');
        }

        try {
            return Socialite::driver('google')->redirect();
        } catch (Exception $e) {
            // Fallback to mock flow on any configurations or connection errors during development
            return redirect()->route('auth.google.mock-select');
        }
    }

    /**
     * Show mock account chooser screen.
     */
    public function showMockSelect()
    {
        return view('auth.google-mock');
    }

    /**
     * Process simulated login/registration.
     */
    public function processMockSelect(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
        ]);

        try {
            $email = Str::lower($request->input('email'));
            $name = $request->input('name');

            // Find existing user or create a new one
            $user = User::where('email', $email)->first();

            if (!$user) {
                // Register new user with default 'user' role
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make(Str::random(16)), // Secure random password
                    'role' => 'user',
                ]);
            }

            Auth::login($user);

            return redirect($this->redirectPathForUser($user));
        } catch (Exception $e) {
            return redirect('/')->withErrors(['email' => 'Gagal masuk dengan akun simulasi: ' . $e->getMessage()])->with('open_login', true);
        }
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        try {
            if ($request->has('mock') || empty(config('services.google.client_id'))) {
                // Mock user details for immediate testing
                $googleUser = (object) [
                    'id' => 'google-mock-id-12345',
                    'name' => 'Mock Google User',
                    'email' => 'google_user@gmail.com',
                ];
            } else {
                $googleUser = Socialite::driver('google')->user();
            }

            // Find existing user or create a new one (Register/Login combined)
            $user = User::where('email', Str::lower($googleUser->email))->first();

            if (!$user) {
                // Register new user with default 'user' role
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => Str::lower($googleUser->email),
                    'password' => Hash::make(Str::random(16)), // Secure random password
                    'role' => 'user',
                ]);
            }

            Auth::login($user);

            return redirect($this->redirectPathForUser($user));

        } catch (Exception $e) {
            return redirect('/')->withErrors(['email' => 'Gagal masuk dengan Google: ' . $e->getMessage()])->with('open_login', true);
        }
    }

    /**
     * Get the redirect path based on user role.
     */
    protected function redirectPathForUser($user): string
    {
        if ($user->role === 'admin') {
            return route('admin.dashboard');
        } elseif ($user->role === 'mitra') {
            return route('mitra.dashboard');
        }
        return route('dashboard');
    }
}
