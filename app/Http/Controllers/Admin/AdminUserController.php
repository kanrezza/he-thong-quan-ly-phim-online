<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        $users = User::where('role', 'user')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function ban(User $user): RedirectResponse
    {
        abort_if($user->role === 'admin', 403);
        $user->update(['status' => 'banned']);
        return back()->with('success', "Đã khóa tài khoản {$user->name}.");
    }

    public function unban(User $user): RedirectResponse
    {
        abort_if($user->role === 'admin', 403);
        $user->update(['status' => 'active']);
        return back()->with('success', "Đã mở khóa tài khoản {$user->name}.");
    }
}
