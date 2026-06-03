<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function create()
    {
        $categories = ServiceCategory::all();
        return view('tasks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'location' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('tasks', 'public');
                $images[] = $path;
            }
        }

        Task::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'budget' => $request->budget,
            'location' => $request->location,
            'images' => $images,
            'status' => 'waiting_for_bid',
        ]);

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil dibuat!');
    }

    public function show(Task $task)
    {
        $task->load('user', 'category', 'bids.mitra');
        return view('tasks.show', compact('task'));
    }
}
