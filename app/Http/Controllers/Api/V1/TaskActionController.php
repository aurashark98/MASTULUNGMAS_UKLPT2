<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskActionController extends Controller
{
    /**
     * POST /api/v1/tasks/{task}/start
     * Mitra starts a task.
     */
    public function start(Request $request, Task $task)
    {
        $user = $request->user();

        if ($user->role !== 'mitra') {
            return response()->json(['success' => false, 'message' => 'Forbidden.'], 403);
        }

        if (!$task->assignment || $task->assignment->mitra_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Anda bukan mitra yang ditugaskan.'], 403);
        }

        if ($task->status !== 'in_progress') {
            return response()->json(['success' => false, 'message' => 'Tugas tidak dapat dimulai dari status ini.'], 422);
        }

        $task->assignment->update(['status' => 'started']);

        $task->user->sendNotification(
            'task_started',
            'Tugas Dimulai!',
            "Mitra mulai mengerjakan tugas '{$task->title}'.",
            route('tasks.show', $task)
        );

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dimulai.',
            'data'    => $task->fresh()->load('assignment.mitra'),
        ]);
    }

    /**
     * POST /api/v1/tasks/{task}/complete
     * Mitra marks a task as complete.
     */
    public function complete(Request $request, Task $task)
    {
        $user = $request->user();

        if ($user->role !== 'mitra') {
            return response()->json(['success' => false, 'message' => 'Forbidden.'], 403);
        }

        if (!$task->assignment || $task->assignment->mitra_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Anda bukan mitra yang ditugaskan.'], 403);
        }

        if ($task->status !== 'in_progress') {
            return response()->json(['success' => false, 'message' => 'Tugas tidak dalam status in_progress.'], 422);
        }

        $task->update(['status' => 'completed']);
        $task->assignment->update(['status' => 'completed']);

        $task->user->sendNotification(
            'task_completed',
            'Tugas Selesai!',
            "Mitra telah menyelesaikan tugas '{$task->title}'. Silakan lakukan pembayaran.",
            route('tasks.pay', $task)
        );

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil diselesaikan.',
            'data'    => $task->fresh()->load('assignment.mitra'),
        ]);
    }
}
