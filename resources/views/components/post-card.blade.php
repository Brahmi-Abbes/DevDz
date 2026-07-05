@props(['post'])

@php
    $accents = [
        'project'  => 'border-l-blue-500',
        'job'      => 'border-l-emerald-500',
        'question' => 'border-l-amber-500',
    ];
    $accent = $accents[$post->type] ?? 'border-l-slate-700';
@endphp

<div class="flex gap-4 border-l-2 {{ $accent }} bg-[#0d0f17] hover:bg-[#0f1219] transition-colors rounded-r-xl mx-3 my-2 px-5 py-4 shadow-sm">

    {{-- Votes --}}
    <x-vote-buttons :post="$post" size="sm" />

    {{-- Content --}}
    <div class="flex-1 min-w-0">

        {{-- Meta + save --}}
        <div class="flex items-center justify-between mb-2.5">
            <x-post-meta :post="$post" />
            <x-save-button :post="$post" />
        </div>

        {{-- Title --}}
        <a href="/posts/{{ $post->id }}" class="block mb-1.5">
            <h4 class="text-[15px] font-bold text-white leading-snug hover:text-blue-400 transition-colors">
                {{ $post->title }}
            </h4>
        </a>

        {{-- Body --}}
        <p class="text-[13px] text-slate-500 leading-relaxed mb-3 line-clamp-2">
            {{ $post->body }}
        </p>

        {{-- Footer: tags + comments --}}
        <div class="flex items-center justify-between">
            <x-tag-list :tags="$post->tags->take(4)" />
            <a href="/posts/{{ $post->id }}"
               class="flex items-center gap-1.5 text-[11px] text-slate-600 hover:text-slate-300 transition-colors shrink-0 ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                {{ $post->comments_count ?? 0 }}
            </a>
        </div>

    </div>
</div>