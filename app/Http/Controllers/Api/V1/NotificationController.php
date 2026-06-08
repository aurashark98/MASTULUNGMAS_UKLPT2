<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * GET /api/v1/notifications
     * List notifications for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $notifications = DB::table('notifications')
            ->where('notifiable_id', $user->id)
            ->where('notifiable_type', 'App\Models\User')
            ->orderByDesc('created_at')
            ->paginate(20);

        $items = collect($notifications->items())->map(function ($n) {
            $data = json_decode($n->data, true);
            return [
                'id'         => $n->id,
                'type'       => $data['type'] ?? null,
                'title'      => $data['title'] ?? null,
                'message'    => $data['message'] ?? null,
                'url'        => $data['url'] ?? null,
                'read_at'    => $n->read_at,
                'created_at' => $n->created_at,
            ];
        });

        return response()->json([
            'success'      => true,
            'data'         => $items,
            'unread_count' => DB::table('notifications')
                ->where('notifiable_id', $user->id)
                ->whereNull('read_at')
                ->count(),
            'meta'         => [
                'current_page' => $notifications->currentPage(),
                'last_page'    => $notifications->lastPage(),
                'per_page'     => $notifications->perPage(),
                'total'        => $notifications->total(),
            ],
        ]);
    }

    /**
     * POST /api/v1/notifications/mark-all-read
     * Mark all notifications as read.
     */
    public function markAllRead(Request $request)
    {
        $user = $request->user();

        DB::table('notifications')
            ->where('notifiable_id', $user->id)
            ->where('notifiable_type', 'App\Models\User')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi telah ditandai sebagai dibaca.',
        ]);
    }
}
