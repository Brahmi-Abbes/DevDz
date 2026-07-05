<x-layout>

    <div class="max-w-2xl mx-auto py-6 px-4">
    <x-back-link href="/" label="Back" />

    <div class="bg-[#0d0f17] border border-slate-800 rounded-xl overflow-hidden mt-6 mb-4 shrink-0">
        <div class="p-5 border-b border-slate-800">
            <div class="flex items-start gap-3">

                <x-vote-buttons :post="$post" size="lg" />

                <div class="flex-1 min-w-0">
                    <div class="mb-3">
                        <x-post-meta :post="$post" />
                    </div>

                    <h1 class="text-[18px] font-bold text-white leading-snug mb-3">
                        {{ $post->title }}
                    </h1>

                    <p class="text-[14px] text-slate-400 leading-relaxed mb-4 whitespace-pre-wrap max-h-[30vh] overflow-y-auto [&::-webkit-scrollbar]:hidden">
                        {{ $post->body }}
                    </p>

                    <x-tag-list :tags="$post->tags" />
                </div>
            </div>
        </div>

        {{-- Actions bar --}}
        <div class="px-5 py-2.5 flex items-center gap-4 bg-slate-900/40">
            <span class="text-[12px] text-slate-600">
                {{ $post->comments->count() }} {{ Str::plural('comment', $post->comments->count()) }}
            </span>
            <x-save-button :post="$post" />
            @auth
                @if(auth()->id() === $post->user_id)
                    <div class="flex items-center gap-3 ml-auto">
                        <a href="/posts/{{ $post->id }}/edit"
                           class="text-[12px] text-slate-500 hover:text-slate-200 transition-colors">Edit</a>
                        <form method="POST" action="/posts/{{ $post->id }}">
                            @csrf @method('DELETE')
                            <button class="text-[12px] text-slate-500 hover:text-rose-400 transition-colors">Delete</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    {{-- Comments scrollable --}}
    <div class="flex-1 overflow-y-auto [&::-webkit-scrollbar]:hidden bg-[#0d0f17] border border-slate-800 rounded-t-xl border-b-0">
        @forelse($comments as $comment)
            <x-comment-card :comment="$comment" />
        @empty
            <p class="text-[13px] text-slate-600 text-center py-8">No comments yet. Be the first.</p>
        @endforelse
    </div>

    {{-- Comment form pinned --}}
    <div class="shrink-0 bg-[#0d0f17] border border-slate-800 rounded-b-xl">
        <x-comment-form :post="$post" />
    </div>

</div>
</x-layout>