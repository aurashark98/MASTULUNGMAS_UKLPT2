<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('task', 'user', 'mitra')->latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        $tasks = Task::all();
        $users = User::where('role', 'user')->get();
        $mitras = User::where('role', 'mitra')->get();
        return view('admin.reviews.create', compact('tasks', 'users', 'mitras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id',
            'mitra_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        Review::create([
            'task_id' => $request->task_id,
            'user_id' => $request->user_id,
            'mitra_id' => $request->mitra_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('admin.reviews.index')->with('success', 'Ulasan baru berhasil ditambahkan!');
    }

    public function edit(Review $review)
    {
        $tasks = Task::all();
        $users = User::where('role', 'user')->get();
        $mitras = User::where('role', 'mitra')->get();
        return view('admin.reviews.edit', compact('review', 'tasks', 'users', 'mitras'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id',
            'mitra_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review->update([
            'task_id' => $request->task_id,
            'user_id' => $request->user_id,
            'mitra_id' => $request->mitra_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('admin.reviews.index')->with('success', 'Ulasan berhasil diperbarui!');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Ulasan berhasil dihapus!');
    }
}
