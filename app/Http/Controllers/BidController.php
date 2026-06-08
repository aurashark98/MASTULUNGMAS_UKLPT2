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

        $bid = TaskBid::create([
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

        // Log Activity
        \App\Models\ActivityLog::log('Bid Submission', "Mengirim penawaran sebesar Rp " . number_format($request->bid_amount, 0, ',', '.') . " untuk tugas '{$task->title}'");

        // Notify Task Owner
        $task->user->sendNotification(
            'new_bid',
            'Penawaran Baru',
            "Mitra " . Auth::user()->name . " mengirimkan penawaran untuk tugas '{$task->title}'",
            route('tasks.show', $task)
        );

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

        // Create Chat Room automatically
        \App\Models\ChatRoom::firstOrCreate([
            'task_id' => $task->id,
            'user_id' => $task->user_id,
            'mitra_id' => $bid->mitra_id,
        ]);

        // Log Activity
        \App\Models\ActivityLog::log('Bid Acceptance', "Menerima penawaran dari Mitra {$bid->mitra->name} untuk tugas '{$task->title}'");

        // Notify Mitra
        $bid->mitra->sendNotification(
            'bid_accepted',
            'Penawaran Diterima',
            "Penawaran Anda untuk tugas '{$task->title}' telah diterima. Silakan mulai pengerjaan.",
            route('tasks.show', $task)
        );

        // Notify Task Owner (Task Assigned)
        Auth::user()->sendNotification(
            'task_assigned',
            'Tugas Ditugaskan',
            "Tugas '{$task->title}' telah berhasil ditugaskan ke Mitra {$bid->mitra->name}.",
            route('tasks.show', $task)
        );

        return redirect()->route('tasks.show', $task)->with('success', 'Penawaran diterima!');
    }
}
