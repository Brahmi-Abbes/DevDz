<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $attributes = $request->validate([
            'body' => ['required', 'string', 'min:3', 'max:1000'],
        ]);

        $post->comments()->create([
            'body' => $attributes['body'],
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Comment posted!');
    }
    public function destroy(\App\Models\Comment $comment)
    {
        abort_if(auth()->id() !== $comment->user_id, 403);
        $comment->delete();
        return back();
    }
}