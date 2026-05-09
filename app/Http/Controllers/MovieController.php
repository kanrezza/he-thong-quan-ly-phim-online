<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use App\Models\WatchHistory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::all();
        $query      = trim((string) $request->query('q', ''));
        $catSlug    = $request->query('cat', '');

        $moviesQuery = Movie::with('category')
            ->where('status', 'active')
            ->latest();

        if ($query !== '') {
            $moviesQuery->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhere('type', 'like', "%{$query}%")
                    ->orWhereHas('categories', fn ($q) => $q->where('name', 'like', "%{$query}%"))
                    ->orWhereHas('category', fn ($q) => $q->where('name', 'like', "%{$query}%"));
            });
        }

        if ($catSlug === 'phim-bo') {
            $moviesQuery->where('type', 'Phim bộ');
        } elseif ($catSlug === 'phim-le') {
            $moviesQuery->where('type', 'Phim lẻ');
        } elseif ($catSlug === 'chieu-rap') {
            $moviesQuery->where('type', 'Chiếu rạp');
        } elseif ($catSlug !== '') {
            $moviesQuery->where(function ($q) use ($catSlug) {
                $q->whereHas('categories', fn ($q) => $q->where('slug', $catSlug))
                  ->orWhereHas('category', fn ($q) => $q->where('slug', $catSlug));
            });
        }

        $movies   = $moviesQuery->paginate(12)->withQueryString();
        $featured = ($catSlug !== '' || $query !== '')
            ? $movies->first()
            : Movie::with('category')->where('status', 'active')->latest()->first();

        return view('movies.index', compact('categories', 'movies', 'query', 'featured', 'catSlug'));
    }

    public function show(Movie $movie): View
    {
        abort_if($movie->status !== 'active', 404);

        $movie->load(['category', 'episodes', 'comments.user', 'ratings']);

        $userRating   = null;
        $inWatchlist  = false;

        if (auth()->check()) {
            $userId = auth()->id();

            $userRating = $movie->ratings()->where('user_id', $userId)->value('score');

            $inWatchlist = $movie->watchlist()->where('user_id', $userId)->exists();

            // Ghi lịch sử xem
            WatchHistory::updateOrCreate(
                ['user_id' => $userId, 'movie_id' => $movie->id],
                ['watched_at' => now()]
            );
        }

        return view('movies.show', compact('movie', 'userRating', 'inWatchlist'));
    }
}
