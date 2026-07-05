<?php

namespace App\Http\Controllers;

use App\Models\Post;

class SavedPostController extends Controller
{
    public function store(Post $post)
    {
        $user = auth()->user();

        if ($post->isSavedBy($user)) {
            $user->savedPosts()->detach($post->id);
        } else {
            $user->savedPosts()->attach($post->id);
        }

        return back();
    }

    public function index()
    {
        $posts = auth()->user()->savedPosts()
            ->with('user', 'tags')
            ->withCount([
                'votes as upvotes_count'   => fn($q) => $q->where('type', 'up'),
                'votes as downvotes_count' => fn($q) => $q->where('type', 'down'),
                'comments as comments_count',
            ])
            ->latest('saved_posts.created_at')
            ->paginate(20);

        return view('posts.saved', ['posts' => $posts]);
    }
}