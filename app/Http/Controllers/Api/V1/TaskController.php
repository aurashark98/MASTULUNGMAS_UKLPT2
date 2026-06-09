<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\ServiceCategory;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Pricing table per category slug (same as frontend JS).
     */
    private function calculateBudget(string $slug, float $distance, int $duration): float
    {
        $pricing = [
            'kurir'        => ['base' => 5000,  'perKm' => 3500, 'perJam' => 5000],
            'asisten'      => ['base' => 20000, 'perKm' => 2000, 'perJam' => 15000],
            'antre'        => ['base' => 15000, 'perKm' => 1000, 'perJam' => 10000],
            'teknis'       => ['base' => 25000, 'perKm' => 3000, 'perJam' => 20000],
            'kebersihan'   => ['base' => 25000, 'perKm' => 2500, 'perJam' => 15000],
            'belanja'      => ['base' => 10000, 'perKm' => 2000, 'perJam' => 8000],
            'angkut-barang'=> ['base' => 20000, 'perKm' => 4000, 'perJam' => 15000],
        ];

        // Match slug to key
        $matched = null;
        foreach ($pricing as $key => $rates) {
            if (str_contains($slug, $key)) {
                $matched = $rates;
                break;
            }
        }

        if (!$matched) {
            $matched = ['base' => 15000, 'perKm' => 3000, 'perJam' => 10000];
        }

        // Surge pricing
        $hour = (int) now()->format('H');
        $surge = 1.0;
        if (($hour >= 7 && $hour < 9) || ($hour >= 16 && $hour < 19)) {
            $surge = 1.3;
        } elseif ($hour >= 22 || $hour < 5) {
            $surge = 1.2;
        }

        $budget = $matched['base'] + ($distance * $matched['perKm']) + ($duration * $matched['perJam']);
        return round($budget * $surge);
    }

    /**
     * GET /api/v1/tasks
     * List tasks based on user role, with optional filters.
     */
    public function index(Request $request)
    {
        $user  = $request->user();
        $query = Task::query()->with('category', 'user');

        if ($user->role === 'mitra') {
            $query->whereIn('status', ['waiting_for_bid', 'bid_received']);
        } elseif ($user->role === 'user') {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tasks = $query->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data'    => $tasks->items(),
            'meta'    => [
                'current_page' => $tasks->currentPage(),
                'last_page'    => $tasks->lastPage(),
                'per_page'     => $tasks->perPage(),
                'total'        => $tasks->total(),
            ],
        ]);
    }

    /**
     * POST /api/v1/tasks
     * Create a new task.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id'          => 'required|exists:service_categories,id',
            'title'                => 'required|string|max:255',
            'description'          => 'required|string',
            'location'             => 'required|string',
            'destination_location' => 'nullable|string',
            'duration'             => 'required|integer|min:1',
            'images.*'             => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'budget'               => 'required|numeric',
        ]);

        $category = ServiceCategory::find($request->category_id);
        $slug     = $category ? $category->slug : 'default';
        $calculatedBudget   = $this->calculateBudget($slug, floatval($request->distance), intval($request->duration));

        $minBudget = floor($calculatedBudget * 0.8);
        $request->validate([
            'budget' => 'min:' . $minBudget
        ], [
            'budget.min' => 'Harga penawaran tidak boleh lebih rendah dari 80% harga sistem (Minimal Rp ' . number_format($minBudget, 0, ',', '.') . ')'
        ]);

        $finalBudget = $request->budget >= $minBudget ? $request->budget : $calculatedBudget;

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('tasks', 'public');
            }
        }

        $task = Task::create([
            'user_id'              => $request->user()->id,
            'category_id'          => $request->category_id,
            'title'                => $request->title,
            'description'          => $request->description,
            'budget'               => $finalBudget,
            'location'             => $request->location,
            'destination_location' => $request->destination_location,
            'distance'             => floatval($request->distance),
            'duration'             => intval($request->duration),
            'images'               => $images,
            'status'               => 'waiting_for_bid',
        ]);

        ActivityLog::log('Task Creation', "API: Membuat tugas baru '{$task->title}' (ID: {$task->id})");

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dibuat.',
            'data'    => $task->load('category', 'user'),
        ], 201);
    }

    /**
     * GET /api/v1/tasks/{task}
     * Get task detail.
     */
    public function show(Task $task)
    {
        $task->load('user', 'category', 'bids.mitra', 'assignment.mitra', 'payment', 'review');

        return response()->json([
            'success' => true,
            'data'    => $task,
        ]);
    }

    /**
     * PUT /api/v1/tasks/{task}
     * Update a task.
     */
    public function update(Request $request, Task $task)
    {
        if ($request->user()->id !== $task->user_id) {
            return response()->json(['success' => false, 'message' => 'Forbidden.'], 403);
        }

        $request->validate([
            'category_id'          => 'required|exists:service_categories,id',
            'title'                => 'required|string|max:255',
            'description'          => 'required|string',
            'location'             => 'required|string',
            'destination_location' => 'nullable|string',
            'distance'             => 'required|numeric|min:0',
            'duration'             => 'required|integer|min:1',
            'budget'               => 'required|numeric',
        ]);

        $category = ServiceCategory::find($request->category_id);
        $slug     = $category ? $category->slug : 'default';
        $calculatedBudget   = $this->calculateBudget($slug, floatval($request->distance), intval($request->duration));

        $minBudget = floor($calculatedBudget * 0.8);
        $request->validate([
            'budget' => 'min:' . $minBudget
        ], [
            'budget.min' => 'Harga penawaran tidak boleh lebih rendah dari 80% harga sistem (Minimal Rp ' . number_format($minBudget, 0, ',', '.') . ')'
        ]);

        $finalBudget = $request->budget >= $minBudget ? $request->budget : $calculatedBudget;

        $task->update([
            'category_id'          => $request->category_id,
            'title'                => $request->title,
            'description'          => $request->description,
            'budget'               => $finalBudget,
            'location'             => $request->location,
            'destination_location' => $request->destination_location,
            'distance'             => floatval($request->distance),
            'duration'             => intval($request->duration),
        ]);

        ActivityLog::log('Task Update', "API: Mengubah tugas '{$task->title}' (ID: {$task->id})");

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil diperbarui.',
            'data'    => $task->fresh()->load('category', 'user'),
        ]);
    }

    /**
     * DELETE /api/v1/tasks/{task}
     * Delete a task.
     */
    public function destroy(Request $request, Task $task)
    {
        $user = $request->user();
        if ($user->id !== $task->user_id && $user->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Forbidden.'], 403);
        }

        $title = $task->title;
        $task->delete();

        ActivityLog::log('Task Delete', "API: Menghapus tugas '{$title}'");

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dihapus.',
        ]);
    }
}
