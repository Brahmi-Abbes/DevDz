<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'user_id', 'post_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function reactions()
    {
        return $this->hasMany(CommentReaction::class);
    }

    public function likes()
    {
        return $this->hasMany(CommentReaction::class)->where('type', 'like');
    }

    public function dislikes()
    {
        return $this->hasMany(CommentReaction::class)->where('type', 'dislike');
    }
}
