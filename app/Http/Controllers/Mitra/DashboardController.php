<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\TaskBid;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->mitraProfile;

        // 1. Completed tasks count
        $completed_tasks_count = TaskAssignment::where('mitra_id', $user->id)
            ->whereHas('task', function($query) {
                $query->where('status', 'completed');
            })
            ->count();

        // 2. Active assignments (tasks that are accepted, assigned, or in progress)
        $active_assignments = TaskAssignment::where('mitra_id', $user->id)
            ->whereHas('task', function($query) {
                $query->whereIn('status', ['bid_accepted', 'assigned', 'in_progress']);
            })
            ->with('task.category', 'task.user')
            ->get();

        // 3. My placed bids (pending, rejected, or accepted but waiting for payment)
        $my_bids = TaskBid::where('mitra_id', $user->id)
            ->where(function ($query) {
                $query->whereIn('status', ['pending', 'rejected'])
                      ->orWhere(function ($q) {
                          $q->where('status', 'accepted')
                            ->whereHas('task', function ($taskQuery) {
                                $taskQuery->where('status', 'bid_accepted');
                            });
                      });
            })
            ->with('task.category', 'task.user')
            ->latest()
            ->get();

        // 4. Available tasks matching the Mitra's skills (only if online) and location radius
        $available_tasks = collect();
        if ($profile && $profile->is_online) {
            $available_tasks = $this->getAvailableTasksForMitra($user, $profile)->take(10);
        }

        $categories = ServiceCategory::orderBy('name')->get();

        // 5. Task History
        $task_history = TaskAssignment::where('mitra_id', $user->id)
            ->whereHas('task', function($query) {
                $query->whereIn('status', ['completed', 'paid', 'cancelled']);
            })
            ->with('task.category', 'task.user')
            ->latest('updated_at')
            ->take(10)
            ->get()
            ->map(fn($assignment) => $assignment->task);

        return view('mitra.dashboard', compact(
            'profile', 
            'available_tasks', 
            'active_assignments', 
            'my_bids', 
            'completed_tasks_count',
            'categories',
            'task_history'
        ));
    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km
        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);
        
        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);
             
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    private function getAvailableTasksForMitra($user, $profile)
    {
        if (!$profile || !$profile->is_online) {
            return collect();
        }

        $skills = $profile->skills ?? [];
        if (empty($skills)) {
            return collect();
        }

        // Get tasks in open statuses that the Mitra has not bid on (exclude if they have pending/accepted bids)
        $tasks = Task::whereIn('status', ['waiting_for_bid', 'bid_received'])
            ->whereDoesntHave('bids', function($query) use ($user) {
                $query->where('mitra_id', $user->id)
                      ->whereIn('status', ['pending', 'accepted']);
            })
            ->whereHas('category', function($query) use ($skills) {
                $query->whereIn('name', $skills);
            })
            ->with('category', 'user')
            ->get();

        // If Mitra doesn't have location yet, fallback to matching all tasks (by skills)
        $hasMitraCoords = !is_null($profile->latitude) && !is_null($profile->longitude);

        $matchedTasks = $tasks->filter(function($task) use ($profile, $hasMitraCoords) {
            // If either task or Mitra doesn't have coordinates, fallback to MATCH (skills-only matching)
            if (!$hasMitraCoords || is_null($task->latitude) || is_null($task->longitude)) {
                $task->distance_to_mitra = 0;
                return true;
            }

            $distance = $this->haversineDistance(
                $profile->latitude,
                $profile->longitude,
                $task->latitude,
                $task->longitude
            );

            // Add distance attribute to task so we can display it in UI
            $task->distance_to_mitra = $distance;

            // Allow matching for any task within a 20 km radius
            return $distance <= 20;
        });

        return $matchedTasks;
    }

    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $profile = Auth::user()->mitraProfile;
        if ($profile) {
            $profile->update([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Profil Mitra tidak ditemukan.'], 404);
    }

    public function checkIncomingTasks()
    {
        $user = Auth::user();
        $profile = $user->mitraProfile;

        if (!$profile || !$profile->is_online) {
            return response()->json([
                'success' => true,
                'tasks' => [],
                'bids' => []
            ]);
        }

        $tasks = $this->getAvailableTasksForMitra($user, $profile);

        // Map tasks for response
        $mappedTasks = $tasks->map(function($task) {
            return [
                'id' => $task->id,
                'title' => $task->title,
                'category_name' => $task->category ? $task->category->name : 'Layanan',
                'category_slug' => $task->category ? $task->category->slug : 'default',
                'budget' => (int) $task->budget,
                'location' => $task->location,
                'destination_location' => $task->destination_location,
                'distance_to_mitra' => round($task->distance_to_mitra, 2),
                'distance_between' => $task->distance, // task travel distance
                'bid_url' => route('mitra.tasks.bid', $task->id),
                'is_quick_help' => (bool)$task->is_quick_help,
                'accept_quick_help_url' => route('mitra.quick-help.accept', $task->id),
            ];
        });

        // Get Mitra's bids:
        // - pending: any pending bid (still waiting for user response)
        // - rejected: ONLY for tasks still open (waiting_for_bid), 
        //   so the mitra can re-bid. If the task is already assigned/completed 
        //   to someone else, the rejected bid is irrelevant — don't show popup.
        $bids = TaskBid::where('mitra_id', $user->id)
            ->whereIn('status', ['pending', 'rejected'])
            ->whereHas('task', function($q) {
                $q->whereIn('status', ['waiting_for_bid', 'bid_received']);
            })
            ->with('task.category')
            ->latest()
            ->get();

        $mappedBids = $bids->map(function($bid) {
            return [
                'id' => $bid->id,
                'task_id' => $bid->task_id,
                'task_title' => $bid->task->title,
                'bid_amount' => (int) $bid->bid_amount,
                'status' => $bid->status,
                'task_budget' => (int) $bid->task->budget,
                'bid_url' => route('mitra.tasks.bid', $bid->task_id),
            ];
        });

        return response()->json([
            'success' => true,
            'tasks' => $mappedTasks->values(),
            'bids' => $mappedBids->values()
        ]);
    }

    public function toggleStatus(Request $request)
    {
        $profile = Auth::user()->mitraProfile;
        if ($profile) {
            $profile->update(['is_online' => !$profile->is_online]);
            $status = $profile->is_online ? 'Online' : 'Offline';
            return redirect()->back()->with('success', "Status Anda sekarang {$status}.");
        }
        return redirect()->back()->with('error', 'Profil Mitra tidak ditemukan.');
    }

    public function startTask(Task $task)
    {
        $assignment = $task->assignment;
        if (!$assignment || $assignment->mitra_id !== Auth::id()) {
            abort(403);
        }

        $task->update(['status' => 'in_progress']);

        // Log Activity
        \App\Models\ActivityLog::log('Task Progress', "Mulai pengerjaan tugas '{$task->title}'");

        // Notify Task Owner
        $task->user->sendNotification(
            'task_in_progress',
            'Tugas Mulai Dikerjakan',
            "Mitra " . Auth::user()->name . " telah mulai mengerjakan tugas '{$task->title}'.",
            route('tasks.show', $task)
        );

        return redirect()->back()->with('success', 'Pekerjaan telah dimulai. Selamat bekerja!');
    }

    public function completeTask(Request $request, Task $task)
    {
        $assignment = $task->assignment;
        if (!$assignment || $assignment->mitra_id !== Auth::id()) {
            abort(403);
        }

        if ($task->is_quick_help) {
            $request->validate([
                'final_price' => 'required|numeric|min:' . $task->budget,
            ]);

            $finalPrice = $request->final_price;

            $task->update([
                'status' => 'completed',
                'budget' => $finalPrice,
            ]);
            $assignment->update(['completed_at' => now()]);

            // Add to Mitra's earnings
            $profile = Auth::user()->mitraProfile;
            if ($profile) {
                $profile->increment('earnings', $finalPrice);
            }

            \App\Models\ActivityLog::log('Task Completion', "Menyelesaikan Bantuan Cepat '{$task->title}'");

            $formattedPrice = number_format($finalPrice, 0, ',', '.');
            $task->user->sendNotification(
                'task_completed',
                'Bantuan Cepat Selesai & Lunas',
                "Mitra " . Auth::user()->name . " telah menyelesaikan bantuan cepat '{$task->title}' dan mengonfirmasi pembayaran tunai sebesar Rp {$formattedPrice}. Jangan lupa berikan ulasan Anda!",
                route('tasks.show', $task)
            );

            return redirect()->back()->with('success', 'Bantuan Cepat selesai & pembayaran tunai dikonfirmasi! Pendapatan telah dicatat.');
        } else {
            // Layanana Biasa
            $task->update(['status' => 'completed']);
            $assignment->update(['completed_at' => now()]);

            // Add to Mitra's earnings
            $profile = Auth::user()->mitraProfile;
            if ($profile) {
                $profile->increment('earnings', $task->budget);
            }

            \App\Models\ActivityLog::log('Task Completion', "Menyelesaikan pengerjaan tugas '{$task->title}'");

            $task->user->sendNotification(
                'task_completed',
                'Tugas Selesai Dikerjakan',
                "Mitra " . Auth::user()->name . " telah menandai tugas '{$task->title}' sebagai selesai. Silakan berikan ulasan Anda!",
                route('tasks.show', $task)
            );

            return redirect()->back()->with('success', 'Pekerjaan berhasil diselesaikan! Pendapatan Anda telah ditambahkan.');
        }
    }

    public function acceptQuickHelp(Task $task)
    {
        $mitra = Auth::user();
        
        if (!$task->is_quick_help || $task->status !== 'waiting_for_bid') {
            return response()->json([
                'success' => false,
                'message' => 'Bantuan cepat ini sudah diambil oleh mitra lain atau tidak valid.'
            ], 422);
        }

        // Update task status
        $task->update(['status' => 'assigned']);

        // Create assignment
        $task->assignment()->create([
            'mitra_id' => $mitra->id,
            'assigned_at' => now(),
        ]);

        // Create Chat Room
        $chatRoom = \App\Models\ChatRoom::firstOrCreate([
            'task_id' => $task->id,
            'user_id' => $task->user_id,
            'mitra_id' => $mitra->id,
        ]);

        // Log Activity
        \App\Models\ActivityLog::log('Quick Help Accepted', "Mitra {$mitra->name} menerima bantuan cepat '{$task->title}'");

        // Notify User
        $task->user->sendNotification(
            'quick_help_accepted',
            'Bantuan Cepat Diterima',
            "Mitra {$mitra->name} telah menerima permintaan Bantuan Cepat Anda dan sedang menuju lokasi.",
            route('tasks.show', $task)
        );

        return response()->json([
            'success' => true,
            'redirect_url' => route('chat.show', $chatRoom->id)
        ]);
    }
}
