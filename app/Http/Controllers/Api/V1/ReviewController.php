<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * POST /api/v1/tasks/{task}/review
     * Submit a review for a completed task.
     */
    public function store(Request $request, Task $task)
    {
        $user = $request->user();

        if ($user->id !== $task->user_id) {
            return response()->json(['success' => false, 'message' => 'Forbidden.'], 403);
        }

        if (!in_array($task->status, ['completed', 'paid'])) {
            return response()->json(['success' => false, 'message' => 'Tugas belum selesai.'], 422);
        }

        if ($task->review) {
            return response()->json(['success' => false, 'message' => 'Anda sudah memberikan ulasan untuk tugas ini.'], 422);
        }

        if (!$task->assignment) {
            return response()->json(['success' => false, 'message' => 'Tidak ada mitra yang ditugaskan.'], 422);
        }

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review = Review::create([
            'task_id'  => $task->id,
            'user_id'  => $user->id,
            'mitra_id' => $task->assignment->mitra_id,
            'rating'   => $request->rating,
            'comment'  => $request->comment,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ulasan berhasil dikirim.',
            'data'    => $review->load('user', 'mitra'),
        ], 201);
    }
}
