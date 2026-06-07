<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaskBid;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskBidController extends Controller
{
    public function index()
    {
        $bids = TaskBid::with('task', 'mitra')->latest()->paginate(10);
        return view('admin.task_bids.index', compact('bids'));
    }

    public function create()
    {
        $tasks = Task::all();
        $mitras = User::where('role', 'mitra')->get();
        return view('admin.task_bids.create', compact('tasks', 'mitras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'mitra_id' => 'required|exists:users,id',
            'bid_amount' => 'required|numeric|min:0',
            'message' => 'nullable|string',
            'status' => 'required|string|in:pending,accepted,rejected',
        ]);

        TaskBid::create([
            'task_id' => $request->task_id,
            'mitra_id' => $request->mitra_id,
            'bid_amount' => $request->bid_amount,
            'message' => $request->message,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.task-bids.index')->with('success', 'Penawaran baru berhasil ditambahkan!');
    }

    public function edit(TaskBid $taskBid)
    {
        $tasks = Task::all();
        $mitras = User::where('role', 'mitra')->get();
        return view('admin.task_bids.edit', compact('taskBid', 'tasks', 'mitras'));
    }

    public function update(Request $request, TaskBid $taskBid)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'mitra_id' => 'required|exists:users,id',
            'bid_amount' => 'required|numeric|min:0',
            'message' => 'nullable|string',
            'status' => 'required|string|in:pending,accepted,rejected',
        ]);

        $taskBid->update([
            'task_id' => $request->task_id,
            'mitra_id' => $request->mitra_id,
            'bid_amount' => $request->bid_amount,
            'message' => $request->message,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.task-bids.index')->with('success', 'Penawaran berhasil diperbarui!');
    }

    public function destroy(TaskBid $taskBid)
    {
        $taskBid->delete();
        return redirect()->route('admin.task-bids.index')->with('success', 'Penawaran berhasil dihapus!');
    }
}
