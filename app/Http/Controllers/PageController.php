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
        return view('welcome', [
            'categories' => ServiceCategory::all()
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
