<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        if (Auth::user()->role === 'admin') {
            // Admin sees all
        } elseif (Auth::user()->role === 'mitra') {
            // Mitra sees open tasks
            $query->whereIn('status', ['waiting_for_bid', 'bid_received']);
        } else {
            // User sees their own tasks
            $query->where('user_id', Auth::id());
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

        $tasks = $query->with('category', 'user')->latest()->paginate(10);
        $categories = ServiceCategory::all();

        return view('tasks.index', compact('tasks', 'categories'));
    }

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
            'location' => 'required|string',
            'destination_location' => 'nullable|string',
            'distance' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'budget' => 'required|numeric', // Backend will calculate min budget based on distance/duration
        ]);

        $category = \App\Models\ServiceCategory::find($request->category_id);
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
        
        $distance = floatval($request->distance);
        $duration = intval($request->duration);
        $hour = (int) now()->format('H');
        $surge = (($hour >= 7 && $hour < 9) || ($hour >= 16 && $hour < 19)) ? 1.3
               : (($hour >= 22 || $hour < 5) ? 1.2 : 1.0);
        $calculatedBudget = round(($rates['base'] + ($distance * $rates['perKm']) + ($duration * $rates['perJam'])) * $surge);
        
        $minBudget = floor($calculatedBudget * 0.8);
        $request->validate([
            'budget' => 'numeric|min:' . $minBudget
        ], [
            'budget.min' => 'Harga penawaran tidak boleh lebih rendah dari 80% harga sistem (Minimal Rp ' . number_format($minBudget, 0, ',', '.') . ')'
        ]);

        $finalBudget = $request->budget >= $minBudget ? $request->budget : $calculatedBudget;

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('tasks', 'public');
                $images[] = $path;
            }
        }

        $task = Task::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'budget' => $finalBudget,
            'location' => $request->location,
            'destination_location' => $request->destination_location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'distance' => $distance,
            'duration' => $duration,
            'images' => $images,
            'status' => 'waiting_for_bid',
        ]);

        \App\Models\ActivityLog::log('Task Creation', "Membuat tugas baru '{$request->title}' (ID: {$task->id})");

        return redirect()->route('tasks.show', $task)->with('success', 'Tugas berhasil dibuat!');
    }

    public function show(Task $task)
    {
        $task->load('user', 'category', 'bids.mitra', 'assignment.mitra', 'payment', 'review');
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        if (Auth::id() !== $task->user_id) {
            abort(403);
        }
        $categories = ServiceCategory::all();
        return view('tasks.edit', compact('task', 'categories'));
    }

    public function update(Request $request, Task $task)
    {
        if (Auth::id() !== $task->user_id) {
            abort(403);
        }

        $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'destination_location' => 'nullable|string',
            'distance' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $category = \App\Models\ServiceCategory::find($request->category_id);
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
        
        $distance = floatval($request->distance);
        $duration = intval($request->duration);
        $hour = (int) now()->format('H');
        $surge = (($hour >= 7 && $hour < 9) || ($hour >= 16 && $hour < 19)) ? 1.3
               : (($hour >= 22 || $hour < 5) ? 1.2 : 1.0);
        $calculatedBudget = round(($rates['base'] + ($distance * $rates['perKm']) + ($duration * $rates['perJam'])) * $surge);

        $images = $task->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('tasks', 'public');
                $images[] = $path;
            }
        }

        $task->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'budget' => $calculatedBudget,
            'location' => $request->location,
            'destination_location' => $request->destination_location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'distance' => $distance,
            'duration' => $duration,
            'images' => $images,
        ]);

        \App\Models\ActivityLog::log('Task Update', "Mengubah tugas '{$task->title}' (ID: {$task->id})");

        return redirect()->route('tasks.show', $task)->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroy(Task $task)
    {
        if (Auth::id() !== $task->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $title = $task->title;
        $task->delete();

        \App\Models\ActivityLog::log('Task Delete', "Menghapus tugas '{$title}'");

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil dihapus!');
    }

    public function getBidsData(Task $task)
    {
        if (Auth::id() !== $task->user_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $bids = $task->bids()
            ->where('status', 'pending')
            ->with(['mitra' => function($query) {
                $query->with('mitraProfile');
            }])
            ->get()
            ->map(function($bid) {
                return [
                    'id' => $bid->id,
                    'mitra_id' => $bid->mitra_id,
                    'mitra_name' => $bid->mitra->name,
                    'mitra_level' => $bid->mitra->level,
                    'mitra_level_badge' => $bid->mitra->level_badge,
                    'mitra_rating' => $bid->mitra->mitraProfile ? round($bid->mitra->mitraProfile->rating, 1) : 5.0,
                    'mitra_photo' => $bid->mitra->profile_photo_url,
                    'bid_amount' => (int) $bid->bid_amount,
                    'message' => $bid->message,
                    'accept_url' => route('bids.accept', $bid->id),
                    'reject_url' => route('bids.reject', $bid->id),
                ];
            });

        return response()->json([
            'success' => true,
            'task_status' => $task->status,
            'bids' => $bids
        ]);
    }
}
