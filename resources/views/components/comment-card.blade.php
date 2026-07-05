@props(['comment'])

<div class="flex gap-3 px-4 py-3 border-b border-slate-800/60 last:border-0">
    <x-user-avatar :user="$comment->user" size="sm" />
    <div class="flex-1 min-w-0">

        <div class="flex items-center gap-2 mb-1">
            <a href="/users/{{ $comment->user->id }}" class="text-[12px] font-medium text-slate-300 hover:text-white transition-colors">{{ $comment->user->name }}</a>
            <span class="text-slate-700">·</span>
            <span class="text-[11px] text-slate-600">{{ $comment->created_at->diffForHumans() }}</span>
            @auth
                @if(auth()->id() === $comment->user_id)
                    <form method="POST" action="/comments/{{ $comment->id }}" class="ml-auto">
                        @csrf @method('DELETE')
                        <button class="text-[11px] text-slate-700 hover:text-rose-400 transition-colors">Delete</button>
                    </form>
                @endif
            @endauth
        </div>

        <p class="text-[13px] text-slate-400 leading-relaxed mb-2">{{ $comment->body }}</p>

        <div class="flex items-center gap-3">
            @auth
                <form method="POST" action="/comments/{{ $comment->id }}/like">
                    @csrf
                    <button type="submit" class="flex items-center gap-1 text-[11px] transition-colors {{ ($comment->userReaction ?? null) === 'like' ? 'text-blue-400' : 'text-slate-600 hover:text-blue-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                        </svg>
                        {{ $comment->likes_count ?? 0 }}
                    </button>
                </form>
                <form method="POST" action="/comments/{{ $comment->id }}/dislike">
                    @csrf
                    <button type="submit" class="flex items-center gap-1 text-[11px] transition-colors {{ ($comment->userReaction ?? null) === 'dislike' ? 'text-rose-400' : 'text-slate-600 hover:text-rose-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018c.163 0 .326.02.485.06L17 4m-7 10v2a2 2 0 002 2h.095c.5 0 .905-.405.905-.905 0-.714.211-1.412.608-2.006L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/>
                        </svg>
                        {{ $comment->dislikes_count ?? 0 }}
                    </button>
                </form>
            @else
                <span class="text-[11px] text-slate-600">{{ $comment->likes_count ?? 0 }} likes</span>
            @endauth
        </div>

    </div>
</div>