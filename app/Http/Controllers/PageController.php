<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        if (auth()->check() && auth()->user()->role === 'mitra') {
            return redirect()->route('mitra.dashboard');
        }

        $totalUsers = \App\Models\User::count();
        $totalMitra = \App\Models\MitraProfile::where('is_verified', true)->count();
        $totalCompletedTasks = \App\Models\Task::where('status', 'completed')->count();
        $avgRating = \App\Models\Review::avg('rating') ?: 5.0;
        $satisfactionRate = number_format(($avgRating / 5.0) * 100, 0);

        return view('welcome', [
            'categories' => ServiceCategory::all(),
            'totalUsers' => $totalUsers,
            'totalMitra' => $totalMitra,
            'totalCompletedTasks' => $totalCompletedTasks,
            'satisfactionRate' => $satisfactionRate,
        ]);
    }

    public function layanan()
    {
        if (auth()->check() && auth()->user()->role === 'mitra') {
            return redirect()->route('mitra.dashboard');
        }
        $categories = ServiceCategory::all();
        return view('pages.layanan', compact('categories'));
    }

    public function caraKerja()
    {
        if (auth()->check() && auth()->user()->role === 'mitra') {
            return redirect()->route('mitra.dashboard');
        }
        return view('pages.cara-kerja');
    }

    public function tentangKami()
    {
        if (auth()->check() && auth()->user()->role === 'mitra') {
            return redirect()->route('mitra.dashboard');
        }
        return view('pages.tentang-kami');
    }
}
