<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'body', 'type', 'city'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function upvotes()
    {
        return $this->hasMany(Vote::class)->where('type', 'up');
    }

    public function downvotes()
    {
        return $this->hasMany(Vote::class)->where('type', 'down');
    }
    public function savedBy()
{
    return $this->belongsToMany(User::class, 'saved_posts');
}
    public function isSavedBy(User $user): bool
    {
        return $this->savedBy()->where('user_id', $user->id)->exists();
    }

}