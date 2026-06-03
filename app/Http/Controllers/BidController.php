<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskBid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'bid_amount' => 'required|numeric|min:0',
            'message' => 'nullable|string',
        ]);

        TaskBid::create([
            'task_id' => $task->id,
            'mitra_id' => Auth::id(),
            'bid_amount' => $request->bid_amount,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        // Update task status if it's the first bid
        if ($task->status === 'waiting_for_bid') {
            $task->update(['status' => 'bid_received']);
        }

        return redirect()->route('tasks.show', $task)->with('success', 'Penawaran berhasil dikirim!');
    }

    public function accept(TaskBid $bid)
    {
        $task = $bid->task;
        
        if (Auth::id() !== $task->user_id) {
            abort(403);
        }

        $bid->update(['status' => 'accepted']);
        
        // Reject other bids
        $task->bids()->where('id', '!=', $bid->id)->update(['status' => 'rejected']);
        
        // Update task status
        $task->update(['status' => 'bid_accepted']);

        // Create assignment
        $task->assignment()->create([
            'mitra_id' => $bid->mitra_id,
            'assigned_at' => now(),
        ]);

        return redirect()->route('tasks.show', $task)->with('success', 'Penawaran diterima!');
    }
}
