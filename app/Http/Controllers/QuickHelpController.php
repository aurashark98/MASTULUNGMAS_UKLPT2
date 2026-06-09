<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuickHelpController extends Controller
{
    private function getWeeklyQuotaCount($userId)
    {
        $startOfWeek = now()->startOfWeek(); // Senin pukul 00:00
        return Task::where('user_id', $userId)
            ->where('is_quick_help', true)
            ->where('created_at', '>=', $startOfWeek)
            ->count();
    }

    public function checkQuota()
    {
        $userId = Auth::id();
        $quotaCount = $this->getWeeklyQuotaCount($userId);

        return response()->json([
            'success' => true,
            'quota_count' => $quotaCount,
            'available' => $quotaCount < 2
        ]);
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $quotaCount = $this->getWeeklyQuotaCount($userId);

        if ($quotaCount >= 2) {
            return response()->json([
                'success' => false,
                'message' => 'Kuota mingguan Bantuan Cepat Anda sudah habis (maksimal 2 kali per minggu).'
            ], 429);
        }

        $request->validate([
            'location' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'urgency_level' => 'required|in:low,medium,high',
        ]);

        // Calculate Pricing using first available category (or fallback)
        $category = ServiceCategory::first();
        $slug = $category ? $category->slug : 'default';

        $pricing = [
            'kurir'         => ['base' => 5000,  'perKm' => 3500, 'perJam' => 5000],
            'asisten'       => ['base' => 20000, 'perKm' => 2000, 'perJam' => 15000],
            'antre'         => ['base' => 15000, 'perKm' => 1000, 'perJam' => 10000],
            'teknis'        => ['base' => 25000, 'perKm' => 3000, 'perJam' => 20000],
            'kebersihan'    => ['base' => 25000, 'perKm' => 2500, 'perJam' => 15000],
            'belanja'       => ['base' => 10000, 'perKm' => 2000, 'perJam' => 8000],
            'angkut-barang' => ['base' => 20000, 'perKm' => 4000, 'perJam' => 15000],
        ];

        $rates = collect($pricing)->first(fn($v, $k) => str_contains($slug, $k))
            ?? ['base' => 15000, 'perKm' => 3000, 'perJam' => 10000];

        $distance = 0;
        $duration = 1; // Default 1 jam pengerjaan darurat
        $hour = (int) now()->format('H');
        $surge = (($hour >= 7 && $hour < 9) || ($hour >= 16 && $hour < 19)) ? 1.3
               : (($hour >= 22 || $hour < 5) ? 1.2 : 1.0);

        // Urgency Multiplier
        $urgencyMultiplier = match ($request->urgency_level) {
            'high' => 2.0,
            'medium' => 1.5,
            default => 1.0,
        };

        $baseCalculation = ($rates['base'] + ($distance * $rates['perKm']) + ($duration * $rates['perJam'])) * $surge;
        $calculatedBudget = round($baseCalculation * $urgencyMultiplier);
        
        $urgencyLabel = match ($request->urgency_level) {
            'high' => '(Sangat Darurat)',
            'medium' => '(Prioritas)',
            default => '(Normal)',
        };

        // Create Task
        $task = Task::create([
            'user_id' => $userId,
            'category_id' => $category ? $category->id : 1,
            'title' => "Bantuan Cepat {$urgencyLabel}",
            'description' => "Membutuhkan bantuan darurat secepatnya di lokasi: " . $request->location,
            'budget' => $calculatedBudget,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'distance' => $distance,
            'duration' => $duration,
            'status' => 'waiting_for_bid',
            'is_quick_help' => true,
        ]);

        \App\Models\ActivityLog::log('Quick Help Request', "Membuat permintaan Bantuan Cepat baru (ID: {$task->id})");

        return response()->json([
            'success' => true,
            'task_id' => $task->id,
            'status' => $task->status,
        ]);
    }

    public function checkStatus(Task $task)
    {
        if (Auth::id() !== $task->user_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $chatRoom = $task->chatRoom;

        return response()->json([
            'success' => true,
            'status' => $task->status,
            'chat_room_id' => $chatRoom ? $chatRoom->id : null
        ]);
    }

    public function cancel(Task $task)
    {
        if (Auth::id() !== $task->user_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($task->status === 'waiting_for_bid' || $task->status === 'bid_received') {
            $task->update(['status' => 'cancelled']);
            \App\Models\ActivityLog::log('Quick Help Cancelled', "Membatalkan Bantuan Cepat '{$task->title}'");
            return response()->json(['success' => true]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Permintaan sudah diproses atau tidak dapat dibatalkan.'
        ], 422);
    }
}
