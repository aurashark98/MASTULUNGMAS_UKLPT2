<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = DB::table('notifications')
            ->where('notifiable_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($notification) {
                $notification->data = json_decode($notification->data, true);
                return $notification;
            });

        return view('notifications.index', compact('notifications'));
    }

    public function markAllRead()
    {
        DB::table('notifications')
            ->where('notifiable_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return redirect()->back()->with('success', 'Semua notifikasi ditandai telah dibaca.');
    }
}
