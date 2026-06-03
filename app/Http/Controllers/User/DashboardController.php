<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $active_tasks = Task::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'waiting_for_bid', 'bid_received', 'bid_accepted', 'assigned', 'in_progress'])
            ->with('category', 'bids')
            ->latest()
            ->get();

        $task_history = Task::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled'])
            ->with('category')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact('active_tasks', 'task_history'));
    }
}
