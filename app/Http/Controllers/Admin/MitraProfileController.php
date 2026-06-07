<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MitraProfile;
use App\Models\User;
use Illuminate\Http\Request;

class MitraProfileController extends Controller
{
    public function index()
    {
        $profiles = MitraProfile::with('user')->latest()->paginate(10);
        return view('admin.mitra_profiles.index', compact('profiles'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('mitraProfile')->get();
        return view('admin.mitra_profiles.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:mitra_profiles,user_id',
            'ktp_photo' => 'nullable|image|max:2048',
            'profile_photo' => 'nullable|image|max:2048',
            'skills' => 'required|array|min:1',
            'skills.*' => 'string',
            'bio' => 'required|string|min:10',
            'is_verified' => 'required|boolean',
            'rating' => 'required|numeric|min:0|max:5',
            'earnings' => 'required|numeric|min:0',
        ]);

        $ktpPath = $request->hasFile('ktp_photo') ? $request->file('ktp_photo')->store('mitra/ktp', 'public') : null;
        $profilePhotoPath = $request->hasFile('profile_photo') ? $request->file('profile_photo')->store('mitra/profile_photos', 'public') : null;

        $profile = MitraProfile::create([
            'user_id' => $request->user_id,
            'ktp_path' => $ktpPath,
            'profile_photo_path' => $profilePhotoPath,
            'skills' => $request->skills,
            'bio' => $request->bio,
            'is_verified' => $request->is_verified,
            'rating' => $request->rating,
            'earnings' => $request->earnings,
        ]);

        $user = $profile->user;
        if (intval($request->is_verified) === 1) {
            if ($user) {
                $user->update(['role' => 'mitra']);
            }
            return redirect()->route('admin.mitra-profiles.index')->with('success', 'Profil Mitra baru berhasil dibuat dan diverifikasi!');
        } else {
            $profile->delete();
            if ($user) {
                $user->update(['role' => 'user']);
            }
            return redirect()->route('admin.mitra-profiles.index')->with('success', 'Profil Mitra baru diatur ke Tidak Terverifikasi dan dihapus agar pengguna dapat mendaftar ulang.');
        }
    }

    public function edit(MitraProfile $mitraProfile)
    {
        $users = User::all();
        return view('admin.mitra_profiles.edit', compact('mitraProfile', 'users'));
    }

    public function update(Request $request, MitraProfile $mitraProfile)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:mitra_profiles,user_id,' . $mitraProfile->id,
            'ktp_photo' => 'nullable|image|max:2048',
            'profile_photo' => 'nullable|image|max:2048',
            'skills' => 'required|array|min:1',
            'skills.*' => 'string',
            'bio' => 'required|string|min:10',
            'is_verified' => 'required|boolean',
            'rating' => 'required|numeric|min:0|max:5',
            'earnings' => 'required|numeric|min:0',
        ]);

        $data = [
            'user_id' => $request->user_id,
            'skills' => $request->skills,
            'bio' => $request->bio,
            'is_verified' => $request->is_verified,
            'rating' => $request->rating,
            'earnings' => $request->earnings,
        ];

        if ($request->hasFile('ktp_photo')) {
            $data['ktp_path'] = $request->file('ktp_photo')->store('mitra/ktp', 'public');
        }

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo_path'] = $request->file('profile_photo')->store('mitra/profile_photos', 'public');
        }

        $mitraProfile->update($data);

        $user = $mitraProfile->user;
        if (intval($request->is_verified) === 1) {
            if ($user) {
                $user->update(['role' => 'mitra']);
            }
            return redirect()->route('admin.mitra-profiles.index')->with('success', 'Profil Mitra berhasil diperbarui!');
        } else {
            $mitraProfile->delete();
            if ($user) {
                $user->update(['role' => 'user']);
            }
            return redirect()->route('admin.mitra-profiles.index')->with('success', 'Profil Mitra diubah menjadi Tidak Terverifikasi (Dihapus agar pengguna dapat mendaftar ulang).');
        }
    }

    public function destroy(MitraProfile $mitraProfile)
    {
        $user = $mitraProfile->user;
        $mitraProfile->delete();

        // If the profile is deleted, change the user's role back to 'user'
        if ($user) {
            $user->update(['role' => 'user']);
        }

        return redirect()->route('admin.mitra-profiles.index')->with('success', 'Profil Mitra berhasil dihapus!');
    }
}
