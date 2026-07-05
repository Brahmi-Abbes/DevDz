<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use App\Models\Post;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     * 
     */
    protected $fillable = [
        'name',
        'email', 
        'password',
        'bio',
        'github_url',
        'avatar',
        'city',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function savedPosts()
    {
        return $this->belongsToMany(Post::class, 'saved_posts');
    }
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
