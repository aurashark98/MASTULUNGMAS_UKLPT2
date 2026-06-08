<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Review;
use App\Models\MitraProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class ReviewController extends Controller
{
    public function store(Request $request, Task $task)
    {
        if (Auth::id() !== $task->user_id) {
            abort(403);
        }

        if ($task->status !== 'completed') {
            return redirect()->route('tasks.show', $task)->with('error', 'Ulasan hanya dapat diberikan setelah tugas selesai dikerjakan.');
        }

        if (!$task->payment || $task->payment->status !== 'completed') {
            return redirect()->route('tasks.show', $task)->with('error', 'Silakan selesaikan pembayaran terlebih dahulu sebelum memberikan ulasan.');
        }

        if ($task->review) {
            return redirect()->route('tasks.show', $task)->with('error', 'Anda sudah memberikan ulasan untuk tugas ini.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $mitraId = $task->assignment->mitra_id;

        $review = Review::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'mitra_id' => $mitraId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Recalculate average rating for Mitra
        $avgRating = Review::where('mitra_id', $mitraId)->avg('rating');
        
        $profile = MitraProfile::where('user_id', $mitraId)->first();
        if ($profile) {
            $profile->update(['rating' => $avgRating]);
        }

        // Log Activity
        ActivityLog::log('Review Submission', "Memberikan ulasan bintang {$request->rating} untuk Mitra " . $task->assignment->mitra->name);

        // Notify Mitra
        $task->assignment->mitra->sendNotification(
            'new_review',
            'Ulasan Baru Diterima',
            "Konsumen memberikan ulasan bintang {$request->rating} untuk tugas '{$task->title}'.",
            route('tasks.show', $task)
        );

        return redirect()->route('tasks.show', $task)->with('success', 'Ulasan Anda berhasil dikirim! Terima kasih atas feedback Anda.');
    }
}
