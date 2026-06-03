<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->mitraProfile;

        $available_tasks = Task::where('status', 'waiting_for_bid')
            ->whereDoesntHave('bids', function($query) use ($user) {
                $query->where('mitra_id', $user->id);
            })
            ->with('category', 'user')
            ->latest()
            ->limit(10)
            ->get();

        $active_assignments = TaskAssignment::where('mitra_id', $user->id)
            ->whereHas('task', function($query) {
                $query->where('status', 'assigned')
                    ->orWhere('status', 'in_progress');
            })
            ->with('task.category', 'task.user')
            ->get();

        return view('mitra.dashboard', compact('profile', 'available_tasks', 'active_assignments'));
    }
}
