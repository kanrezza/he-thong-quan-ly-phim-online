<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Movie $movie): RedirectResponse
    {
        $request->validate(['content' => 'required|string|max:1000']);

        $movie->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back()->with('comment_success', 'Đã thêm bình luận!');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        abort_if(
            auth()->id() !== $comment->user_id && auth()->user()->role !== 'admin',
            403
        );
        $comment->delete();
        return back()->with('comment_success', 'Đã xóa bình luận!');
    }
}
