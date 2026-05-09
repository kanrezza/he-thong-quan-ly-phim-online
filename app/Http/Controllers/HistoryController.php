<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\WatchHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function index(): View
    {
        $histories = WatchHistory::with(['movie.category'])
            ->where('user_id', auth()->id())
            ->orderByDesc('watched_at')
            ->paginate(12);

        $categories = Category::all();
        return view('movies.history', compact('histories', 'categories'));
    }

    public function clear(): RedirectResponse
    {
        WatchHistory::where('user_id', auth()->id())->delete();
        return back()->with('history_msg', 'Đã xóa toàn bộ lịch sử xem.');
    }
}
