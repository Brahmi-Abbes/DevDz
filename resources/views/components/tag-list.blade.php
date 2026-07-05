@props(['tags', 'size' => 'sm'])

@if($tags->isNotEmpty())
    <div class="flex flex-wrap gap-1.5">
        @foreach($tags as $tag)
            <a href="/?tag={{ $tag->name }}"
               class="text-[11px] text-slate-600 hover:text-slate-300 px-2 py-0.5 rounded-full
                      bg-white/3 border border-white/6 hover:border-white/12 transition-colors">
                #{{ $tag->name }}
            </a>
        @endforeach
    </div>
@endif
