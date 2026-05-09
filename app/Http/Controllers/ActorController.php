<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActorController extends Controller
{
    public function index(): View
    {
        $movies = Movie::where('status', 'active')
            ->whereNotNull('actors')
            ->where('actors', '!=', '')
            ->get(['actors']);

        $actors = collect();
        foreach ($movies as $movie) {
            $names = array_map('trim', explode(',', $movie->actors));
            foreach ($names as $name) {
                if ($name !== '') {
                    $actors->push($name);
                }
            }
        }

        $actors = $actors->filter()
            ->countBy()
            ->sortByDesc(fn ($count) => $count)
            ->map(fn ($count, $name) => ['name' => $name, 'count' => $count]);

        $categories = Category::all();
        return view('actors.index', compact('actors', 'categories'));
    }

    public function show(string $name): View
    {
        $movies = Movie::with('category')
            ->where('status', 'active')
            ->where('actors', 'like', '%' . $name . '%')
            ->latest()
            ->get();

        $categories = Category::all();
        return view('actors.show', compact('name', 'movies', 'categories'));
    }
}
