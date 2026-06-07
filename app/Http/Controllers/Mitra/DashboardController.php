<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\TaskBid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->mitraProfile;

        // 1. Completed tasks count
        $completed_tasks_count = TaskAssignment::where('mitra_id', $user->id)
            ->whereHas('task', function($query) {
                $query->where('status', 'completed');
            })
            ->count();

        // 2. Active assignments (tasks that are accepted, assigned, or in progress)
        $active_assignments = TaskAssignment::where('mitra_id', $user->id)
            ->whereHas('task', function($query) {
                $query->whereIn('status', ['bid_accepted', 'assigned', 'in_progress']);
            })
            ->with('task.category', 'task.user')
            ->get();

        // 3. My placed bids (which are pending or rejected)
        $my_bids = TaskBid::where('mitra_id', $user->id)
            ->whereIn('status', ['pending', 'rejected'])
            ->with('task.category', 'task.user')
            ->latest()
            ->get();

        // 4. Available tasks matching the Mitra's skills (only if online)
        $available_tasks = collect();
        if ($profile && $profile->is_online) {
            $skills = $profile->skills ?? [];
            
            $available_tasks = Task::where('status', 'waiting_for_bid')
                ->whereDoesntHave('bids', function($query) use ($user) {
                    $query->where('mitra_id', $user->id);
                })
                ->whereHas('category', function($query) use ($skills) {
                    $query->whereIn('name', $skills);
                })
                ->with('category', 'user')
                ->latest()
                ->limit(10)
                ->get();
        }

        return view('mitra.dashboard', compact(
            'profile', 
            'available_tasks', 
            'active_assignments', 
            'my_bids', 
            'completed_tasks_count'
        ));
    }

    public function toggleStatus(Request $request)
    {
        $profile = Auth::user()->mitraProfile;
        if ($profile) {
            $profile->update(['is_online' => !$profile->is_online]);
            $status = $profile->is_online ? 'Online' : 'Offline';
            return redirect()->back()->with('success', "Status Anda sekarang {$status}.");
        }
        return redirect()->back()->with('error', 'Profil Mitra tidak ditemukan.');
    }

    public function startTask(Task $task)
    {
        $assignment = $task->assignment;
        if (!$assignment || $assignment->mitra_id !== Auth::id()) {
            abort(403);
        }

        $task->update(['status' => 'in_progress']);
        return redirect()->back()->with('success', 'Pekerjaan telah dimulai. Selamat bekerja!');
    }

    public function completeTask(Task $task)
    {
        $assignment = $task->assignment;
        if (!$assignment || $assignment->mitra_id !== Auth::id()) {
            abort(403);
        }

        $task->update(['status' => 'completed']);
        $assignment->update(['completed_at' => now()]);

        // Add to Mitra's earnings
        $profile = Auth::user()->mitraProfile;
        if ($profile) {
            $profile->increment('earnings', $task->budget);
        }

        return redirect()->back()->with('success', 'Pekerjaan berhasil diselesaikan! Pendapatan Anda telah ditambahkan.');
    }
}
