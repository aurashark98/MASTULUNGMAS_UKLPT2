<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('user', 'category')->latest()->paginate(10);
        return view('admin.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->get();
        $categories = ServiceCategory::all();
        return view('admin.tasks.create', compact('users', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:service_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'status' => 'required|string|in:pending,assigned,completed,cancelled',
        ]);

        Task::create([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'budget' => $request->budget,
            'location' => $request->location,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.tasks.index')->with('success', 'Tugas baru berhasil ditambahkan!');
    }

    public function show(Task $task)
    {
        $task->load('user', 'category', 'bids.mitra', 'assignment.mitra');
        return view('admin.tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $users = User::where('role', 'user')->get();
        $categories = ServiceCategory::all();
        return view('admin.tasks.edit', compact('task', 'users', 'categories'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:service_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'status' => 'required|string|in:pending,assigned,completed,cancelled',
        ]);

        $task->update([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'budget' => $request->budget,
            'location' => $request->location,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.tasks.index')->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.tasks.index')->with('success', 'Tugas berhasil dihapus!');
    }
}
