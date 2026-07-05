@props(['name', 'placeholder', 'rows' => 3, 'value' => ''])

<div>
    <textarea
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        class="w-full bg-transparent text-slate-300 text-[13px] placeholder-slate-600 resize-none focus:outline-none leading-relaxed
               {{ $name === 'title' ? 'text-slate-100 text-[15px] font-medium' : '' }}"
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
    @enderror
</div>
