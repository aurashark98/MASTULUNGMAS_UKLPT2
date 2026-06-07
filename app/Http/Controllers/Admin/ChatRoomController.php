<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class ChatRoomController extends Controller
{
    public function index()
    {
        $rooms = ChatRoom::with('task', 'user', 'mitra')->latest()->paginate(10);
        return view('admin.chat_rooms.index', compact('rooms'));
    }

    public function create()
    {
        $tasks = Task::all();
        $users = User::where('role', 'user')->get();
        $mitras = User::where('role', 'mitra')->get();
        return view('admin.chat_rooms.create', compact('tasks', 'users', 'mitras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id',
            'mitra_id' => 'required|exists:users,id',
        ]);

        ChatRoom::create([
            'task_id' => $request->task_id,
            'user_id' => $request->user_id,
            'mitra_id' => $request->mitra_id,
        ]);

        return redirect()->route('admin.chat-rooms.index')->with('success', 'Ruang obrolan baru berhasil ditambahkan!');
    }

    public function edit(ChatRoom $chatRoom)
    {
        $tasks = Task::all();
        $users = User::where('role', 'user')->get();
        $mitras = User::where('role', 'mitra')->get();
        return view('admin.chat_rooms.edit', compact('chatRoom', 'tasks', 'users', 'mitras'));
    }

    public function update(Request $request, ChatRoom $chatRoom)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id',
            'mitra_id' => 'required|exists:users,id',
        ]);

        $chatRoom->update([
            'task_id' => $request->task_id,
            'user_id' => $request->user_id,
            'mitra_id' => $request->mitra_id,
        ]);

        return redirect()->route('admin.chat-rooms.index')->with('success', 'Ruang obrolan berhasil diperbarui!');
    }

    public function destroy(ChatRoom $chatRoom)
    {
        $chatRoom->delete();
        return redirect()->route('admin.chat-rooms.index')->with('success', 'Ruang obrolan berhasil dihapus!');
    }
}
