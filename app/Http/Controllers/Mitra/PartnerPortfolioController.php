<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\PartnerPortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PartnerPortfolioController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $portfolios = Auth::user()->portfolios()->latest()->paginate(9);
        return view('mitra.portfolios.index', compact('portfolios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'completed_date' => 'required|date',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('portfolios', 'public');
        }

        Auth::user()->portfolios()->create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'completed_date' => $request->completed_date,
        ]);

        return redirect()->back()->with('success', 'Portfolio berhasil ditambahkan!');
    }

    public function update(Request $request, PartnerPortfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'completed_date' => 'required|date',
        ]);

        $data = $request->only(['title', 'description', 'completed_date']);

        if ($request->hasFile('image')) {
            if ($portfolio->image_path) {
                Storage::disk('public')->delete($portfolio->image_path);
            }
            $data['image_path'] = $request->file('image')->store('portfolios', 'public');
        }

        $portfolio->update($data);

        return redirect()->back()->with('success', 'Portfolio berhasil diperbarui!');
    }

    public function destroy(PartnerPortfolio $portfolio)
    {
        $this->authorize('delete', $portfolio);

        if ($portfolio->image_path) {
            Storage::disk('public')->delete($portfolio->image_path);
        }

        $portfolio->delete();

        return redirect()->back()->with('success', 'Portfolio berhasil dihapus!');
    }
}
