<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }} · DevDZ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#08090e] text-slate-200 h-screen overflow-hidden">

@php
    $isOwner = auth()->check() && auth()->id() === $user->id;
    $totalUpvotes = $user->posts->sum(fn($p) => $p->upvotes_count ?? 0);
@endphp

{{-- NAV --}}
<nav class="bg-[#0d0f17] border-b border-slate-800 h-12 flex items-center px-6 sticky top-0 z-50">
    <div class="flex items-center justify-between w-full max-w-5xl mx-auto">
        <a href="/" class="text-[15px] font-bold tracking-tight text-white shrink-0">
            Dev<span class="text-blue-500">DZ</span>
        </a>
        <div class="flex items-center gap-2">
            @auth
                <a href="/posts/create" class="text-[12px] font-semibold px-3 py-1.5 rounded-md bg-blue-600 hover:bg-blue-500 text-white transition-colors">+ Post</a>
                <a href="/users/{{ $user->id }}" class="text-[12px] text-slate-400 hover:text-white px-3 py-1.5 rounded-md hover:bg-white/5 transition-colors">{{ auth()->user()->name }}</a>
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button class="text-[12px] text-slate-500 hover:text-white px-3 py-1.5 rounded-md border border-slate-700 hover:bg-white/5 transition-colors cursor-pointer">Logout</button>
                </form>
            @endauth
            @guest
                <a href="/login" class="text-[12px] text-slate-400 hover:text-white px-3 py-1.5 rounded-md border border-slate-700 hover:bg-white/5 transition-colors">Login</a>
                <a href="/register" class="text-[12px] font-semibold px-3 py-1.5 rounded-md bg-blue-600 hover:bg-blue-500 text-white transition-colors">Register</a>
            @endguest
        </div>
    </div>
</nav>

{{-- BODY --}}
<div class="flex h-[calc(100vh-48px)] max-w-5xl mx-auto">

    {{-- LEFT — User info --}}
    <aside class="w-60 shrink-0 border-r border-slate-800 px-5 py-6 flex flex-col gap-5 overflow-y-auto [&::-webkit-scrollbar]:hidden">

        <div class="flex flex-col gap-3">
            <x-user-avatar :user="$user" size="xl" />
            <div>
                <h1 class="text-[17px] font-bold text-white">{{ $user->name }}</h1>
                @if($user->city)
                    <p class="text-[12px] text-slate-500 mt-0.5">{{ $user->city }}</p>
                @endif
            </div>
        </div>

        @if($user->bio)
            <p class="text-[13px] text-slate-400 leading-relaxed">{{ $user->bio }}</p>
        @endif

        <div class="flex flex-col gap-2">
            @if($user->github_url)
                <a href="{{ $user->github_url }}" target="_blank"
                   class="flex items-center gap-2 text-[12px] text-slate-500 hover:text-blue-400 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                    </svg>
                    {{ str_replace(['https://github.com/', 'https://www.github.com/'], '', $user->github_url) }}
                </a>
            @endif
            <div class="flex items-center gap-2 text-[12px] text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Joined {{ $user->created_at->format('M Y') }}
            </div>
        </div>

        <div class="flex flex-col gap-2 pt-3 border-t border-slate-800">
            <div class="flex justify-between text-[12px]">
                <span class="text-slate-500">Posts</span>
                <span class="text-slate-200 font-semibold">{{ $user->posts_count }}</span>
            </div>
            <div class="flex justify-between text-[12px]">
                <span class="text-slate-500">Upvotes received</span>
                <span class="text-slate-200 font-semibold">{{ $totalUpvotes }}</span>
            </div>
            @if($isOwner)
                <a href="/saved" class="flex justify-between text-[12px] hover:text-blue-400 transition-colors group">
                    <span class="text-slate-500 group-hover:text-blue-400 transition-colors">Saved posts</span>
                    <span class="text-blue-400 font-semibold">{{ auth()->user()->savedPosts()->count() }}</span>
                </a>
            @endif
        </div>

        @if($isOwner)
            <a href="/users/{{ $user->id }}/edit"
               class="flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-slate-700 text-[12px] text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit profile
            </a>
        @endif

    </aside>

    {{-- RIGHT — Posts --}}
    <div class="flex-1 min-w-0 flex flex-col">

        {{-- Tabs --}}
        <div class="flex border-b border-slate-800 shrink-0">
            @foreach(['all' => 'Posts', 'project' => 'Projects', 'job' => 'Jobs', 'question' => 'Questions'] as $value => $label)
                <a href="/users/{{ $user->id }}{{ $value !== 'all' ? '?type=' . $value : '' }}"
                   class="flex-1 text-center py-3 text-[12px] font-medium transition-colors border-b-2
                          {{ request()->get('type', 'all') === $value
                              ? 'text-white border-blue-500'
                              : 'text-slate-500 border-transparent hover:text-slate-300 hover:bg-white/3' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Feed --}}
        <div class="flex-1 overflow-y-auto [&::-webkit-scrollbar]:hidden">
            @forelse($posts as $post)
                <x-post-card :$post />
            @empty
                <div class="py-16 text-center">
                    <p class="text-[13px] text-slate-600">No posts yet.</p>
                </div>
            @endforelse
        </div>

    </div>

</div>

</body>
</html>