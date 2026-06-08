<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * GET /api/v1/chat
     * List all chat rooms for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'mitra') {
            $rooms = ChatRoom::where('mitra_id', $user->id)
                ->with('task', 'user', 'mitra', 'messages')
                ->latest()
                ->get();
        } else {
            $rooms = ChatRoom::where('user_id', $user->id)
                ->with('task', 'user', 'mitra', 'messages')
                ->latest()
                ->get();
        }

        return response()->json([
            'success' => true,
            'data'    => $rooms,
        ]);
    }

    /**
     * GET /api/v1/chat/{chatRoom}/messages
     * Get messages in a chat room.
     */
    public function messages(Request $request, ChatRoom $chatRoom)
    {
        $user = $request->user();

        if ($chatRoom->user_id !== $user->id && $chatRoom->mitra_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Forbidden.'], 403);
        }

        $messages = $chatRoom->messages()->with('sender')->latest()->paginate(30);

        return response()->json([
            'success' => true,
            'data'    => $messages->items(),
            'meta'    => [
                'current_page' => $messages->currentPage(),
                'last_page'    => $messages->lastPage(),
                'per_page'     => $messages->perPage(),
                'total'        => $messages->total(),
            ],
        ]);
    }

    /**
     * POST /api/v1/chat/{chatRoom}/messages
     * Send a message to a chat room.
     */
    public function store(Request $request, ChatRoom $chatRoom)
    {
        $user = $request->user();

        if ($chatRoom->user_id !== $user->id && $chatRoom->mitra_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Forbidden.'], 403);
        }

        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $message = Message::create([
            'chat_room_id' => $chatRoom->id,
            'sender_id'    => $user->id,
            'message'      => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dikirim.',
            'data'    => $message->load('sender'),
        ], 201);
    }
}
