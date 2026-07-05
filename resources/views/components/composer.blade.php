@props(['action', 'method' => 'POST', 'post' => null])

<form method="POST" action="{{ $action }}" class="bg-white/2 border border-white/[0.07] rounded-xl overflow-hidden">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    {{-- Type tabs --}}
    <div class="flex border-b border-white/[0.07]">
        @foreach(['project' => 'Project', 'job' => 'Job', 'question' => 'Question'] as $value => $label)
            <label class="flex-1 relative cursor-pointer">
                <input type="radio" name="type" value="{{ $value }}"
                       class="sr-only peer"
                       {{ old('type', $post?->type ?? 'project') === $value ? 'checked' : '' }}>
                <div class="text-center py-3 text-[12px] font-medium text-slate-500
                            peer-checked:text-blue-400 peer-checked:border-b-2 peer-checked:border-blue-400
                            hover:text-slate-300 hover:bg-white/2 transition-all border-b-2 border-transparent">
                    {{ $label }}
                </div>
            </label>
        @endforeach
    </div>

    {{-- Avatar + fields --}}
    <div class="flex gap-3 p-4">
        <x-user-avatar :user="auth()->user()" size="lg" />
        <div class="flex-1 flex flex-col gap-3">
            <x-composer-field name="title" placeholder="What's your post about?" :rows="2" :value="$post?->title ?? ''" />
            <div class="h-px bg-white/5"></div>
            <x-composer-field name="body" placeholder="Add more details, context, or links..." :rows="5" :value="$post?->body ?? ''" />
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="flex items-center justify-between px-4 py-3 border-t border-white/[0.07] bg-white/1">
        <div class="flex items-center gap-2 flex-1 mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            <input type="text" name="tags"
                value="{{ old('tags', $post?->tags->pluck('name')->implode(', ')) }}"
                placeholder="laravel, php, remote..."
                class="flex-1 bg-transparent text-[12px] text-slate-400 placeholder-slate-600 focus:outline-none">
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <div class="flex items-center gap-1.5 bg-white/4 border border-white/[0.07] rounded-lg px-2.5 py-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <input type="text" name="city"
                    value="{{ old('city', auth()->user()?->city) }}"
                    placeholder="City"
                    class="bg-transparent text-[12px] text-slate-400 placeholder-slate-600 focus:outline-none w-20">
            </div>
            <button type="submit" class="px-4 py-1.5 rounded-full bg-blue-500 hover:bg-blue-400 text-white text-[12px] font-medium transition-colors">
                {{ $post ? 'Save' : 'Publish' }}
            </button>
        </div>
    </div>

</form>