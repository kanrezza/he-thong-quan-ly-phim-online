<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, Movie $movie): RedirectResponse
    {
        $request->validate(['score' => 'required|integer|min:1|max:10']);

        $movie->ratings()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['score'   => $request->score]
        );

        $avg = $movie->ratings()->avg('score');
        $movie->update(['rating' => round($avg, 1)]);

        return back()->with('rating_success', 'Đánh giá của bạn đã được lưu!');
    }
}
