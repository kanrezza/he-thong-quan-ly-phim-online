<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use App\Models\Watchlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WatchlistController extends Controller
{
    public function index(): View
    {
        $items = Watchlist::with(['movie.category'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(12);

        $categories = Category::all();
        return view('movies.watchlist', compact('items', 'categories'));
    }

    public function toggle(Movie $movie): RedirectResponse
    {
        $exists = Watchlist::where('user_id', auth()->id())
            ->where('movie_id', $movie->id)
            ->first();

        if ($exists) {
            $exists->delete();
            $msg = 'Đã xóa khỏi danh sách yêu thích.';
        } else {
            Watchlist::create(['user_id' => auth()->id(), 'movie_id' => $movie->id]);
            $msg = 'Đã thêm vào danh sách yêu thích!';
        }

        return back()->with('watchlist_msg', $msg);
    }
}
