<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminMovieController extends Controller
{
    public function index(): View
    {
        $movies = Movie::with('categories')->latest()->paginate(15);
        return view('admin.movies.index', compact('movies'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('admin.movies.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'categories'   => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'type'         => 'required|in:Phim lẻ,Phim bộ,Chiếu rạp',
            'year'         => 'nullable|integer|min:1900|max:2100',
            'country'      => 'nullable|string|max:100',
            'actors'       => 'nullable|string',
            'poster'       => 'nullable|image|max:4096',
            'video_url'    => 'nullable|string|max:500',
            'status'       => 'required|in:active,inactive',
            'episodes'                  => 'nullable|array',
            'episodes.*.episode_number' => 'required_with:episodes.*|integer|min:1',
            'episodes.*.title'          => 'nullable|string|max:255',
            'episodes.*.video_url'      => 'nullable|string|max:500',
            'episodes.*.duration'       => 'nullable|integer|min:1',
        ]);

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $data['category_id'] = $data['categories'][0] ?? null;

        $movie = Movie::create(\Arr::except($data, ['categories', 'episodes']));
        $movie->categories()->sync($data['categories']);

        if ($request->type === 'Phim bộ' && !empty($data['episodes'])) {
            foreach ($data['episodes'] as $ep) {
                $movie->episodes()->create([
                    'episode_number' => $ep['episode_number'],
                    'title'          => $ep['title'] ?? "Tập {$ep['episode_number']}",
                    'video_url'      => $ep['video_url'] ?? '',
                    'duration'       => $ep['duration'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.movies.index')->with('success', 'Thêm phim thành công!');
    }

    public function edit(Movie $movie): View
    {
        $categories = Category::all();
        $movie->load('categories', 'episodes');
        return view('admin.movies.edit', compact('movie', 'categories'));
    }

    public function update(Request $request, Movie $movie): RedirectResponse
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'categories'   => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'type'         => 'required|in:Phim lẻ,Phim bộ,Chiếu rạp',
            'year'         => 'nullable|integer|min:1900|max:2100',
            'country'      => 'nullable|string|max:100',
            'actors'       => 'nullable|string',
            'poster'       => 'nullable|image|max:4096',
            'video_url'    => 'nullable|string|max:500',
            'status'       => 'required|in:active,inactive',
            'episodes'                  => 'nullable|array',
            'episodes.*.episode_number' => 'required_with:episodes.*|integer|min:1',
            'episodes.*.title'          => 'nullable|string|max:255',
            'episodes.*.video_url'      => 'nullable|string|max:500',
            'episodes.*.duration'       => 'nullable|integer|min:1',
        ]);

        if ($request->hasFile('poster')) {
            if ($movie->poster) {
                Storage::disk('public')->delete($movie->poster);
            }
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $data['category_id'] = $data['categories'][0] ?? null;

        $movie->update(\Arr::except($data, ['categories', 'episodes']));
        $movie->categories()->sync($data['categories']);

        $movie->episodes()->delete();
        if ($request->type === 'Phim bộ' && !empty($data['episodes'])) {
            foreach ($data['episodes'] as $ep) {
                $movie->episodes()->create([
                    'episode_number' => $ep['episode_number'],
                    'title'          => $ep['title'] ?? "Tập {$ep['episode_number']}",
                    'video_url'      => $ep['video_url'] ?? '',
                    'duration'       => $ep['duration'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.movies.index')->with('success', 'Cập nhật phim thành công!');
    }

    public function destroy(Movie $movie): RedirectResponse
    {
        if ($movie->poster) {
            Storage::disk('public')->delete($movie->poster);
        }
        $movie->episodes()->delete();
        $movie->categories()->detach();
        $movie->delete();

        return redirect()->route('admin.movies.index')->with('success', 'Đã xóa phim!');
    }
}
