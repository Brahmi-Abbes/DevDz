<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function upvote(Request $request, Post $post)
    {
        return $this->vote($post, 'up');
    }

    public function downvote(Request $request, Post $post)
    {
        abort_if(!auth()->check(), 401);
        return $this->vote($post, 'down');
    }

    private function vote(Post $post, string $type)
    {
        $existing = Vote::where('user_id', auth()->id())
                        ->where('post_id', $post->id)
                        ->first();

        if ($existing) {
            if ($existing->type === $type) {
                $existing->delete();
            } else {
                $existing->type = $type;
                $existing->save();
            }
        } else {
            Vote::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
                'type'    => $type,
            ]);
        }

        return back();
    }
}