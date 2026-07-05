<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReaction;

class CommentReactionController extends Controller
{
    public function like(Comment $comment)
    {
        abort_if(!auth()->check(), 401);
        return $this->react($comment, 'like');
    }

    public function dislike(Comment $comment)
    {
        return $this->react($comment, 'dislike');
    }

    private function react(Comment $comment, string $type)
    {
        $existing = CommentReaction::where('user_id', auth()->id())
                                   ->where('comment_id', $comment->id)
                                   ->first();

        if ($existing) {
            if ($existing->type === $type) {
                $existing->delete();
            } else {
                $existing->type = $type;
                $existing->save();
            }
        } else {
            CommentReaction::create([
                'user_id'    => auth()->id(),
                'comment_id' => $comment->id,
                'type'       => $type,
            ]);
        }

        return back();
    }
}