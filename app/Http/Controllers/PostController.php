<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\CommentReaction;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Post $post)
    {
        $post->loadCount([
            'votes as upvotes_count'   => fn($q) => $q->where('type', 'up'),
            'votes as downvotes_count' => fn($q) => $q->where('type', 'down'),
        ]);

        $comments = $post->comments()
            ->with('user')
            ->withCount([
                'reactions as likes_count'    => fn($q) => $q->where('type', 'like'),
                'reactions as dislikes_count' => fn($q) => $q->where('type', 'dislike'),
            ])
            ->latest()
            ->get();

        if (auth()->check()) {
            $userReactions = CommentReaction::where('user_id', auth()->id())
                ->whereIn('comment_id', $comments->pluck('id'))
                ->pluck('type', 'comment_id');

            $comments->each(fn($c) => $c->userReaction = $userReactions[$c->id] ?? null);
        }

        return view('posts.index', [
            'post'     => $post->load('user', 'tags'),
            'comments' => $comments,
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'body'  => ['required', 'string', 'min:10'],
            'type'  => ['required', 'in:project,job,question'],
            'tags'  => ['nullable', 'string', 'max:255'],
            'city'  => ['nullable', 'string', 'max:100'],
        ]);

        $post = auth()->user()->posts()->create([
            'title' => $attributes['title'],
            'body'  => $attributes['body'],
            'type'  => $attributes['type'],
            'city'  => $attributes['city'] ?? null,
        ]);

        $this->syncTags($post, $attributes['tags'] ?? null);

        return redirect('/')->with('success', 'Post published!');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit', [
            'post' => $post->load('tags'),
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $attributes = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'body'  => ['required', 'string', 'min:10'],
            'type'  => ['required', 'in:project,job,question'],
            'tags'  => ['nullable', 'string', 'max:255'],
        ]);

        $post->update([
            'title' => $attributes['title'],
            'body'  => $attributes['body'],
            'type'  => $attributes['type'],
        ]);

        $this->syncTags($post, $attributes['tags'] ?? null);

        return redirect('/posts/' . $post->id)->with('success', 'Post updated!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect('/')->with('success', 'Post deleted.');
    }

    private function syncTags(Post $post, ?string $tags): void
    {
        if (empty($tags)) {
            $post->tags()->detach();
            return;
        }

        $tagIds = collect(explode(',', $tags))
            ->map(fn($name) => strip_tags(trim(strtolower($name))))
            ->filter()
            ->map(fn($name) => Tag::firstOrCreate(['name' => $name])->id);

        $post->tags()->sync($tagIds);
    }
}