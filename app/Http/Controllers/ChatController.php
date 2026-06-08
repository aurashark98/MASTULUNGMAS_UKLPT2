<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $chatRooms = ChatRoom::where('user_id', $user->id)
            ->orWhere('mitra_id', $user->id)
            ->with(['task', 'user', 'mitra', 'messages' => function ($q) {
                $q->latest()->limit(1);
            }])
            ->get();

        return view('chat.index', compact('chatRooms'));
    }

    public function show(ChatRoom $chatRoom)
    {
        if (Auth::id() !== $chatRoom->user_id && Auth::id() !== $chatRoom->mitra_id) {
            abort(403);
        }

        // Mark messages as read
        Message::where('chat_room_id', $chatRoom->id)
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $chatRoom->load(['task', 'user', 'mitra', 'messages.sender']);

        return view('chat.show', compact('chatRoom'));
    }

    public function store(Request $request, ChatRoom $chatRoom)
    {
        if (Auth::id() !== $chatRoom->user_id && Auth::id() !== $chatRoom->mitra_id) {
            abort(403);
        }

        $request->validate([
            'message' => 'required_without:image|nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chats', 'public');
        }

        $message = Message::create([
            'chat_room_id' => $chatRoom->id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'image_path' => $imagePath,
            'is_read' => false,
        ]);

        // Send notification to the other participant
        $recipient = Auth::id() === $chatRoom->user_id ? $chatRoom->mitra : $chatRoom->user;
        $senderName = Auth::user()->name;
        $snippet = $request->message ? substr($request->message, 0, 50) : 'Mengirim sebuah gambar';
        
        $recipient->sendNotification(
            'new_message',
            "Pesan baru dari {$senderName}",
            $snippet,
            route('chat.show', $chatRoom)
        );

        return redirect()->route('chat.show', $chatRoom)->with('success', 'Pesan terkirim!');
    }
}
