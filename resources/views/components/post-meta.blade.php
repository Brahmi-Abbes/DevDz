@props(['post'])

@php
    $badgeStyles = [
        'project'  => 'text-blue-400',
        'job'      => 'text-emerald-400',
        'question' => 'text-amber-400',
    ];
    $badge = $badgeStyles[$post->type] ?? 'text-slate-400';
@endphp

<div class="flex items-center justify-between w-full">
    <div class="flex items-center gap-2 min-w-0">
        <a href="/users/{{ $post->user->id }}">
            <x-user-avatar :user="$post->user" size="sm" />
        </a>
        <a href="/users/{{ $post->user->id }}"
           class="text-[13px] font-semibold text-slate-200 hover:text-white transition-colors truncate">
            {{ $post->user->name }}
        </a>
        @if($post->city ?? $post->user->city)
            <span class="text-slate-600">·</span>
            <span class="text-[12px] text-slate-500">{{ $post->city ?? $post->user->city }}</span>
        @endif
        <span class="text-slate-600">·</span>
        <span class="text-[11px] text-slate-500 shrink-0">{{ $post->created_at->diffForHumans() }}</span>
    </div>
    <span class="text-[11px] font-semibold {{ $badge }} uppercase tracking-widest shrink-0 ml-3">
        {{ $post->type }}
    </span>
</div>