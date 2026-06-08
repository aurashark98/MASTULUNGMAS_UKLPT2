<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\PartnerPortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    /**
     * GET /api/v1/portfolio
     * List portfolios for authenticated mitra.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'mitra') {
            return response()->json(['success' => false, 'message' => 'Hanya mitra yang memiliki portfolio.'], 403);
        }

        $portfolios = $user->portfolios()->latest()->paginate(9);

        return response()->json([
            'success' => true,
            'data'    => $portfolios->items(),
            'meta'    => [
                'current_page' => $portfolios->currentPage(),
                'last_page'    => $portfolios->lastPage(),
                'per_page'     => $portfolios->perPage(),
                'total'        => $portfolios->total(),
            ],
        ]);
    }

    /**
     * POST /api/v1/portfolio
     * Add a new portfolio item.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'mitra') {
            return response()->json(['success' => false, 'message' => 'Hanya mitra yang dapat menambah portfolio.'], 403);
        }

        $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'completed_date' => 'required|date',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('portfolios', 'public');
        }

        $portfolio = $user->portfolios()->create([
            'title'          => $request->title,
            'description'    => $request->description,
            'image_path'     => $imagePath,
            'completed_date' => $request->completed_date,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Portfolio berhasil ditambahkan.',
            'data'    => $portfolio,
        ], 201);
    }

    /**
     * PUT /api/v1/portfolio/{portfolio}
     * Update a portfolio item.
     */
    public function update(Request $request, PartnerPortfolio $portfolio)
    {
        $user = $request->user();

        if ($portfolio->partner_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Forbidden.'], 403);
        }

        $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
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

        return response()->json([
            'success' => true,
            'message' => 'Portfolio berhasil diperbarui.',
            'data'    => $portfolio->fresh(),
        ]);
    }

    /**
     * DELETE /api/v1/portfolio/{portfolio}
     * Delete a portfolio item.
     */
    public function destroy(Request $request, PartnerPortfolio $portfolio)
    {
        if ($portfolio->partner_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'Forbidden.'], 403);
        }

        if ($portfolio->image_path) {
            Storage::disk('public')->delete($portfolio->image_path);
        }

        $portfolio->delete();

        return response()->json([
            'success' => true,
            'message' => 'Portfolio berhasil dihapus.',
        ]);
    }
}
