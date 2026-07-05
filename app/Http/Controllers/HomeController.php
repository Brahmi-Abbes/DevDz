<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
     public function index()
    {
        $query = Post::with('user', 'tags')
            ->withCount([
                'votes as upvotes_count'   => fn($q) => $q->where('type', 'up'),
                'votes as downvotes_count' => fn($q) => $q->where('type', 'down'),
                'comments as comments_count',
            ]);

        if (request('sort') === 'top') {
            $query->orderByRaw('(upvotes_count - downvotes_count) DESC');
        } else {
            $query->latest();
        }

        if (request('type')) {
            $query->where('type', request('type'));
        }

        if (request('city')) {
            $query->where('city', 'like', '%' . request('city') . '%');
        }

        if (request('tag')) {
            $query->whereHas('tags', fn($q) => $q->where('name', request('tag')));
        }
        if (request('search')) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('body', 'like', '%' . request('search') . '%');
            });
        }

        return view('home', [
            'posts' => $query->paginate(20)->withQueryString(),
        ]);

    }
}
