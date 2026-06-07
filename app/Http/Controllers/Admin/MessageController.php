<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with('chatRoom', 'sender')->latest()->paginate(10);
        return view('admin.messages.index', compact('messages'));
    }

    public function create()
    {
        $rooms = ChatRoom::all();
        $users = User::all();
        return view('admin.messages.create', compact('rooms', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'chat_room_id' => 'required|exists:chat_rooms,id',
            'sender_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_read' => 'required|boolean',
        ]);

        $imagePath = $request->hasFile('image') ? $request->file('image')->store('chat', 'public') : null;

        Message::create([
            'chat_room_id' => $request->chat_room_id,
            'sender_id' => $request->sender_id,
            'message' => $request->message,
            'image_path' => $imagePath,
            'is_read' => $request->is_read,
        ]);

        return redirect()->route('admin.messages.index')->with('success', 'Pesan baru berhasil dikirim!');
    }

    public function edit(Message $message)
    {
        $rooms = ChatRoom::all();
        $users = User::all();
        return view('admin.messages.edit', compact('message', 'rooms', 'users'));
    }

    public function update(Request $request, Message $message)
    {
        $request->validate([
            'chat_room_id' => 'required|exists:chat_rooms,id',
            'sender_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_read' => 'required|boolean',
        ]);

        $data = [
            'chat_room_id' => $request->chat_room_id,
            'sender_id' => $request->sender_id,
            'message' => $request->message,
            'is_read' => $request->is_read,
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('chat', 'public');
        }

        $message->update($data);

        return redirect()->route('admin.messages.index')->with('success', 'Pesan berhasil diperbarui!');
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Pesan berhasil dihapus!');
    }
}
