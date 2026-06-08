<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class PartnerApiController extends Controller
{
    /**
     * GET /api/v1/partners
     * List verified mitra with filters.
     */
    public function index(Request $request)
    {
        $query = User::verifiedMitra()
            ->with(['mitraProfile', 'receivedReviews'])
            ->withCount(['assignments as completed_tasks_count' => function ($q) {
                $q->whereNotNull('completed_at');
            }]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('mitraProfile', function ($sq) use ($search) {
                      $sq->where('skills', 'like', "%{$search}%")
                         ->orWhere('bio', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('mitraProfile', function ($q) use ($request) {
                $q->where('skills', 'like', "%{$request->category}%");
            });
        }

        if ($request->filled('rating')) {
            $query->whereHas('mitraProfile', function ($q) use ($request) {
                $q->where('rating', '>=', $request->rating);
            });
        }

        if ($request->filled('online')) {
            $query->whereHas('mitraProfile', function ($q) {
                $q->where('is_online', true);
            });
        }

        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'rating' => $query->join('mitra_profiles', 'users.id', '=', 'mitra_profiles.user_id')
                              ->orderBy('mitra_profiles.rating', 'desc')
                              ->select('users.*'),
            'completed' => $query->orderBy('completed_tasks_count', 'desc'),
            default => $query->latest(),
        };

        $partners = $query->paginate(12);
        $authUser = $request->user();

        $items = collect($partners->items())->map(function ($partner) use ($authUser) {
            return [
                'id'                    => $partner->id,
                'name'                  => $partner->name,
                'profile_photo_url'     => $partner->profile_photo_url,
                'level'                 => $partner->level,
                'mitra_profile'         => $partner->mitraProfile,
                'completed_tasks_count' => $partner->completed_tasks_count,
                'avg_rating'            => $partner->receivedReviews->avg('rating'),
                'review_count'          => $partner->receivedReviews->count(),
                'is_favorite'           => $authUser ? $partner->isFavoriteOf($authUser->id) : false,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $items,
            'meta'    => [
                'current_page' => $partners->currentPage(),
                'last_page'    => $partners->lastPage(),
                'per_page'     => $partners->perPage(),
                'total'        => $partners->total(),
            ],
        ]);
    }

    /**
     * POST /api/v1/partners/{partner}/favorite
     * Toggle favorite status of a mitra.
     */
    public function toggleFavorite(Request $request, User $partner)
    {
        if ($partner->role !== 'mitra') {
            return response()->json(['success' => false, 'message' => 'User bukan mitra.'], 422);
        }

        $user       = $request->user();
        $isFavorite = $user->favoritePartners()->where('partner_id', $partner->id)->exists();

        if ($isFavorite) {
            $user->favoritePartners()->detach($partner->id);
            $message    = 'Dihapus dari favorit.';
            $nowFav     = false;
        } else {
            $user->favoritePartners()->attach($partner->id);
            $message    = 'Ditambahkan ke favorit.';
            $nowFav     = true;
        }

        return response()->json([
            'success'     => true,
            'message'     => $message,
            'is_favorite' => $nowFav,
        ]);
    }

    /**
     * GET /api/v1/partners/favorites
     * List favorite mitra for authenticated user.
     */
    public function favorites(Request $request)
    {
        $partners = $request->user()
            ->favoritePartners()
            ->with(['mitraProfile', 'receivedReviews'])
            ->withCount(['assignments as completed_tasks_count' => function ($q) {
                $q->whereNotNull('completed_at');
            }])
            ->paginate(12);

        return response()->json([
            'success' => true,
            'data'    => $partners->items(),
            'meta'    => [
                'current_page' => $partners->currentPage(),
                'last_page'    => $partners->lastPage(),
                'per_page'     => $partners->perPage(),
                'total'        => $partners->total(),
            ],
        ]);
    }
}
