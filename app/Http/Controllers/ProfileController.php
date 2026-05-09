<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user'       => $request->user(),
            'categories' => Category::all(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone'           => ['nullable', 'string', 'max:20'],
            'bio'             => ['nullable', 'string', 'max:500'],
            'favorite_genres' => ['nullable', 'array'],
            'favorite_genres.*' => ['string', 'max:100'],
            'favorite_movies' => ['nullable', 'string', 'max:500'],
            'avatar'          => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('profile.edit')->with('success', 'Đã cập nhật hồ sơ cá nhân.');
    }
}
