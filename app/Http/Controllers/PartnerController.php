<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::verifiedMitra()
            ->with(['mitraProfile', 'receivedReviews'])
            ->withCount(['assignments as completed_tasks_count' => function ($q) {
                $q->whereNotNull('completed_at');
            }]);

        // Search by Name or Skill
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('mitraProfile', function($sq) use ($search) {
                      $sq->where('skills', 'like', "%{$search}%")
                         ->orWhere('bio', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Category
        if ($request->filled('category')) {
            $query->whereHas('mitraProfile', function($q) use ($request) {
                $q->where('skills', 'like', "%{$request->category}%");
            });
        }

        // Filter by Rating
        if ($request->filled('rating')) {
            $query->whereHas('mitraProfile', function($q) use ($request) {
                $q->where('rating', '>=', $request->rating);
            });
        }

        // Filter by Online Status
        if ($request->filled('online')) {
            $query->whereHas('mitraProfile', function($q) {
                $q->where('is_online', true);
            });
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        match($sort) {
            'rating' => $query->join('mitra_profiles', 'users.id', '=', 'mitra_profiles.user_id')
                             ->orderBy('mitra_profiles.rating', 'desc')
                             ->select('users.*'),
            'completed' => $query->orderBy('completed_tasks_count', 'desc'),
            'newest' => $query->latest(),
            default => $query->latest(),
        };

        $partners = $query->paginate(12)->withQueryString();
        $categories = ServiceCategory::all();

        return view('partners.index', compact('partners', 'categories'));
    }

    public function toggleFavorite(User $partner)
    {
        if ($partner->role !== 'mitra') {
            return back()->with('error', 'User bukan mitra.');
        }

        $user = Auth::user();
        $isFavorite = $user->favoritePartners()->where('partner_id', $partner->id)->exists();

        if ($isFavorite) {
            $user->favoritePartners()->detach($partner->id);
            $message = 'Dihapus dari favorit.';
        } else {
            $user->favoritePartners()->attach($partner->id);
            $message = 'Ditambahkan ke favorit.';
        }

        return back()->with('success', $message);
    }

    public function favorites()
    {
        $partners = Auth::user()->favoritePartners()
            ->with(['mitraProfile', 'receivedReviews'])
            ->withCount(['assignments as completed_tasks_count' => function ($q) {
                $q->whereNotNull('completed_at');
            }])
            ->paginate(12);

        return view('partners.favorites', compact('partners'));
    }
}
