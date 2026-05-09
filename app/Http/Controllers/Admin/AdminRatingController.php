<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminRatingController extends Controller
{
    public function index(): View
    {
        $ratings = Rating::with(['user', 'movie'])
            ->latest()
            ->paginate(20);

        return view('admin.ratings.index', compact('ratings'));
    }

    public function destroy(Rating $rating): RedirectResponse
    {
        $movie = $rating->movie;
        $rating->delete();

        if ($movie) {
            $avg = $movie->ratings()->avg('score');
            $movie->update(['rating' => $avg ? round($avg, 1) : 0]);
        }

        return back()->with('success', 'Đã xóa đánh giá.');
    }
}
