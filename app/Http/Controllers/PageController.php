<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('welcome', [
            'categories' => ServiceCategory::all()
        ]);
    }

    public function layanan()
    {
        $categories = ServiceCategory::all();
        return view('pages.layanan', compact('categories'));
    }

    public function caraKerja()
    {
        return view('pages.cara-kerja');
    }

    public function tentangKami()
    {
        return view('pages.tentang-kami');
    }
}
