<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Movie;
use App\Models\Rating;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalUsers'   => User::where('role', 'user')->count(),
            'totalAdmins'  => User::where('role', 'admin')->count(),
            'activeUsers'  => User::where('status', 'active')->where('role', 'user')->count(),
            'bannedUsers'  => User::where('status', 'banned')->count(),
            'totalMovies'  => Movie::count(),
            'activeMovies' => Movie::where('status', 'active')->count(),
            'totalComments'=> Comment::count(),
            'totalRatings' => Rating::count(),
        ]);
    }
}
