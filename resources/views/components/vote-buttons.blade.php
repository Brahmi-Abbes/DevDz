@props(['post', 'size' => 'sm'])

@php
    $score    = ($post->upvotes_count ?? 0) - ($post->downvotes_count ?? 0);
    $iconSize = $size === 'lg' ? 'w-4 h-4' : 'w-3.5 h-3.5';
    $padding  = $size === 'lg' ? 'p-1 rounded hover:bg-blue-400/10' : 'p-0.5 rounded';
    $textSize = $size === 'lg' ? 'text-[13px] font-semibold' : 'text-[11px] font-medium';
@endphp

<div class="flex flex-col items-center gap-1 shrink-0">
    @auth
        <form method="POST" action="/posts/{{ $post->id }}/upvote">
            @csrf
            <button type="submit" class="text-slate-600 hover:text-blue-400 transition-colors {{ $padding }}" title="Upvote">
                <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconSize }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
            </button>
        </form>
    @else
        <a href="/login" class="text-slate-700 hover:text-slate-500 transition-colors {{ $padding }}" title="Login to vote">
            <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconSize }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
        </a>
    @endauth

    <span class="{{ $textSize }} {{ $score > 0 ? 'text-blue-400' : ($score < 0 ? 'text-rose-400' : 'text-slate-600') }}">
        {{ $score }}
    </span>

    @auth
        <form method="POST" action="/posts/{{ $post->id }}/downvote">
            @csrf
            <button type="submit" class="text-slate-600 hover:text-rose-400 transition-colors {{ $padding }}" title="Downvote">
                <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconSize }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>
        </form>
    @else
        <a href="/login" class="text-slate-700 hover:text-slate-500 transition-colors {{ $padding }}" title="Login to vote">
            <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconSize }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </a>
    @endauth
</div>