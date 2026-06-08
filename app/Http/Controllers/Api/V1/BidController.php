<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskBid;
use Illuminate\Http\Request;

class BidController extends Controller
{
    /**
     * POST /api/v1/tasks/{task}/bid
     * Mitra submits a bid on a task.
     */
    public function store(Request $request, Task $task)
    {
        $user = $request->user();

        if ($user->role !== 'mitra') {
            return response()->json(['success' => false, 'message' => 'Hanya mitra yang dapat mengajukan penawaran.'], 403);
        }

        if (!in_array($task->status, ['waiting_for_bid', 'bid_received'])) {
            return response()->json(['success' => false, 'message' => 'Tugas ini tidak dapat menerima penawaran.'], 422);
        }

        $existing = TaskBid::where('task_id', $task->id)->where('mitra_id', $user->id)->first();
        if ($existing) {
            return response()->json(['success' => false, 'message' => 'Anda sudah mengajukan penawaran untuk tugas ini.'], 422);
        }

        $request->validate([
            'bid_amount' => 'required|numeric|min:1000',
            'message'    => 'required|string|max:500',
        ]);

        $bid = TaskBid::create([
            'task_id'    => $task->id,
            'mitra_id'   => $user->id,
            'bid_amount' => $request->bid_amount,
            'message'    => $request->message,
            'status'     => 'pending',
        ]);

        $task->update(['status' => 'bid_received']);

        $task->user->sendNotification(
            'bid_received',
            'Penawaran Baru!',
            "{$user->name} mengajukan penawaran untuk tugas '{$task->title}'.",
            route('tasks.show', $task)
        );

        return response()->json([
            'success' => true,
            'message' => 'Penawaran berhasil dikirim.',
            'data'    => $bid->load('mitra'),
        ], 201);
    }

    /**
     * POST /api/v1/bids/{bid}/accept
     * User accepts a bid.
     */
    public function accept(Request $request, TaskBid $bid)
    {
        $user = $request->user();
        $task = $bid->task;

        if ($user->id !== $task->user_id) {
            return response()->json(['success' => false, 'message' => 'Forbidden.'], 403);
        }

        if ($task->status !== 'bid_received') {
            return response()->json(['success' => false, 'message' => 'Tugas tidak dalam status penerimaan penawaran.'], 422);
        }

        // Reject all other bids
        TaskBid::where('task_id', $task->id)
            ->where('id', '!=', $bid->id)
            ->update(['status' => 'rejected']);

        $bid->update(['status' => 'accepted']);
        $task->update(['status' => 'in_progress']);

        // Create task assignment
        \App\Models\TaskAssignment::create([
            'task_id'  => $task->id,
            'mitra_id' => $bid->mitra_id,
            'status'   => 'assigned',
        ]);

        // Create chat room
        \App\Models\ChatRoom::firstOrCreate([
            'task_id'  => $task->id,
            'user_id'  => $task->user_id,
            'mitra_id' => $bid->mitra_id,
        ]);

        $bid->mitra->sendNotification(
            'bid_accepted',
            'Penawaran Diterima!',
            "Penawaran Anda untuk tugas '{$task->title}' telah diterima.",
            route('tasks.show', $task)
        );

        return response()->json([
            'success' => true,
            'message' => 'Penawaran berhasil diterima.',
            'data'    => $bid->load('mitra', 'task'),
        ]);
    }
}
