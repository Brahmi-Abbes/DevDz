@props(['post'])

@auth
    <div class="border-t border-slate-800 bg-[#08090e] p-4">
        <form method="POST" action="/posts/{{ $post->id }}/comments">
            @csrf
            <div class="flex gap-3">
                <x-user-avatar :user="auth()->user()" size="sm" />
                <div class="flex-1">
                    <textarea name="body" rows="2" placeholder="Write a comment..."
                        class="w-full bg-slate-800/60 border border-slate-700 rounded-lg px-3 py-2 text-[13px] text-slate-300 placeholder-slate-600 resize-none focus:outline-none focus:border-blue-500/50 transition-colors leading-relaxed"
                    >{{ old('body') }}</textarea>
                    @error('body')
                        <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                    <div class="flex justify-end mt-2">
                        <button type="submit" class="px-4 py-1.5 rounded-full bg-blue-600 hover:bg-blue-500 text-white text-[12px] font-medium transition-colors">
                            Comment
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@else
    <div class="border-t border-slate-800 py-4 text-center">
        <p class="text-[13px] text-slate-500">
            <a href="/login" class="text-blue-400 hover:text-blue-300 transition-colors">Login</a> to comment
        </p>
    </div>
@endauth