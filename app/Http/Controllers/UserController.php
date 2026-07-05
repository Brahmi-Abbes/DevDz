<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class UserController extends Controller
{
    public function show(User $user, Request $request)
    {
        $totalUpvotes = $user->posts()->withCount([
            'votes as upvotes_count' => fn($q) => $q->where('type', 'up'),
        ])->get()->sum('upvotes_count');

        $query = $user->posts()
            ->withCount([
                'votes as upvotes_count'   => fn($q) => $q->where('type', 'up'),
                'votes as downvotes_count' => fn($q) => $q->where('type', 'down'),
                'comments as comments_count',
            ])
            ->with('user', 'tags');

        if ($request->type && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        $posts = $query->latest()->paginate(20);

        return view('users.profile', [
            'user'         => $user->loadCount('posts'),
            'posts'        => $posts,
            'totalUpvotes' => $totalUpvotes,
        ]);
    }

    public function edit(User $user)
    {
        abort_if(auth()->id() !== $user->id, 403);

        return view('users.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        abort_if(auth()->id() !== $user->id, 403);

        $attributes = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'bio'              => ['nullable', 'string', 'max:500'],
            'city'             => ['nullable', 'string', 'max:100'],
            'github_url'       => ['nullable', 'url', 'max:255', 'regex:/^https:\/\/(www\.)?github\.com\/.+/'],
            'avatar'           => ['nullable', 'image', 'max:2048'],
            'current_password' => ['nullable', 'required_with:password'],
            'password'         => ['nullable', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $attributes['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } else {
            unset($attributes['avatar']);
        }

        if (!empty($attributes['current_password'])) {
            if (!Hash::check($attributes['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $attributes['password'] = Hash::make($attributes['password']);
        } else {
            unset($attributes['password']);
        }

        unset($attributes['current_password'], $attributes['password_confirmation']);

        $user->fill($attributes)->save();

        return redirect('/users/' . $user->id)->with('success', 'Profile updated.');
    }
}