@props(['post'])

@php
    $saved = auth()->check() && $post->isSavedBy(auth()->user());
@endphp

@auth
    <form method="POST" action="/posts/{{ $post->id }}/save">
        @csrf
        <button type="submit" title="{{ $saved ? 'Unsave' : 'Save' }}"
            class="transition-colors {{ $saved ? 'text-blue-400 hover:text-slate-500' : 'text-slate-600 hover:text-blue-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                fill="{{ $saved ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
            </svg>
        </button>
    </form>
@else
    <a href="/login" title="Login to save"
        class="text-slate-700 hover:text-slate-500 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
        </svg>
    </a>
@endauth