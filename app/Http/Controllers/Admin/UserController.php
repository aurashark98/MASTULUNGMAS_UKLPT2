<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('mitraProfile')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'username' => ['nullable', 'string', 'max:255', 'unique:users'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'string', 'in:user,mitra,admin'],
            'address' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'username' => $request->username,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'address' => $request->address,
        ]);

        if ($user->role === 'mitra') {
            $user->mitraProfile()->create([
                'is_verified' => true,
                'skills' => [],
                'bio' => 'Profil Mitra dibuat oleh Admin.',
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'username' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'string', 'in:user,mitra,admin'],
            'address' => ['nullable', 'string'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => strtolower($request->email),
            'username' => $request->username,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'address' => $request->address,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Sync Mitra Profile based on the new role
        if ($user->role !== 'mitra') {
            if ($user->mitraProfile) {
                $user->mitraProfile->delete();
            }
        } else {
            if ($user->mitraProfile) {
                $user->mitraProfile->update(['is_verified' => true]);
            } else {
                $user->mitraProfile()->create([
                    'is_verified' => true,
                    'skills' => [],
                    'bio' => 'Profil Mitra dibuat oleh Admin.',
                ]);
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'Informasi pengguna berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}
