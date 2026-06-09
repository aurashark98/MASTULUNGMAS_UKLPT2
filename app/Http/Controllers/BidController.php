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
        $minBid = $task->budget * 0.8; // Batas minimal penawaran 80% dari harga sistem
        
        $request->validate([
            'bid_amount' => 'required|numeric|min:' . $minBid,
            'message' => 'nullable|string',
        ], [
            'bid_amount.min' => 'Harga penawaran tidak boleh terlalu jauh di bawah estimasi (Minimal Rp ' . number_format($minBid, 0, ',', '.') . ')'
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
        $task->user->notify(new \App\Notifications\NewBidNotification($bid));

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
        
        // Update task status to bid_accepted (waiting for payment)
        $task->update([
            'status' => 'bid_accepted',
            'budget' => $bid->bid_amount, // update budget to agreed price
        ]);

        // NOTE: Assignment is created AFTER payment, not here.

        // Log Activity
        \App\Models\ActivityLog::log('Bid Acceptance', "Menerima penawaran dari Mitra {$bid->mitra->name} untuk tugas '{$task->title}'");

        // Notify Mitra that bid was accepted, pending payment
        $bid->mitra->notify(new \App\Notifications\BidAcceptedNotification($bid));

        // Redirect straight to payment page
        return redirect()->route('tasks.pay', $task)
            ->with('success', 'Penawaran dari ' . $bid->mitra->name . ' diterima! Selesaikan pembayaran untuk memulai tugas.');
    }

    public function reject(TaskBid $bid)
    {
        $task = $bid->task;
        
        if (Auth::id() !== $task->user_id) {
            if (request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            abort(403);
        }

        $bid->update(['status' => 'rejected']);

        $hasPendingBids = $task->bids()->where('status', 'pending')->exists();
        if (!$hasPendingBids) {
            $task->update(['status' => 'waiting_for_bid']);
        }

        // Log Activity
        \App\Models\ActivityLog::log('Bid Rejection', "Menolak penawaran dari Mitra {$bid->mitra->name} untuk tugas '{$task->title}'");

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('tasks.show', $task)->with('success', 'Penawaran ditolak!');
    }
}
