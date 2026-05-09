<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TopRatedController extends Controller
{
    public function index(Request $request): View
    {
        $period = $request->query('period', 'all');

        $movies = match ($period) {
            'week'  => $this->topByPeriod(now()->subWeek()),
            'month' => $this->topByPeriod(now()->subMonth()),
            'year'  => Movie::with('category')
                            ->where('status', 'active')
                            ->where('year', now()->year)
                            ->where('rating', '>', 0)
                            ->orderByDesc('rating')
                            ->paginate(20),
            default => Movie::with('category')
                            ->where('status', 'active')
                            ->where('rating', '>', 0)
                            ->orderByDesc('rating')
                            ->paginate(20),
        };

        $categories = Category::all();
        return view('movies.top-rated', compact('movies', 'period', 'categories'));
    }

    private function topByPeriod($since)
    {
        return Movie::with('category')
            ->select('movies.*')
            ->selectRaw('AVG(ratings.score) as period_avg, COUNT(ratings.id) as period_count')
            ->join('ratings', 'movies.id', '=', 'ratings.movie_id')
            ->where('movies.status', 'active')
            ->where('ratings.created_at', '>=', $since)
            ->groupBy('movies.id')
            ->orderByDesc('period_avg')
            ->paginate(20);
    }
}
