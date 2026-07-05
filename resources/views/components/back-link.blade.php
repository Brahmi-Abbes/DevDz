@props(['href' => '/', 'label' => 'Back'])

<a href="{{ $href }}"
   class="inline-flex items-center gap-2 text-[12px] text-slate-500 hover:text-slate-300 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    {{ $label }}
</a>