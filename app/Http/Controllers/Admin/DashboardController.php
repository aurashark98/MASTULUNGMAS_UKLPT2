<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_mitra' => User::where('role', 'mitra')->count(),
            'total_tasks' => Task::count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
        ];

        $recent_tasks = Task::with('user', 'category')->latest()->limit(5)->get();
        $unverified_mitra = User::whereHas('mitraProfile', function($query) {
                $query->where('is_verified', false);
            })
            ->with('mitraProfile')
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_tasks', 'unverified_mitra'));
    }

    public function verifyMitra(User $user)
    {
        if ($user->mitraProfile) {
            $user->mitraProfile->update(['is_verified' => true]);
        }
        $user->update(['role' => 'user']);
        return redirect()->back()->with('success', 'Mitra berhasil diverifikasi!');
    }

    public function rejectMitra(User $user)
    {
        if ($user->mitraProfile) {
            $user->mitraProfile->delete();
        }
        $user->update(['role' => 'user']);
        return redirect()->back()->with('success', 'Pengajuan Mitra berhasil ditolak!');
    }
}
