@props(['name', 'label', 'type' => 'text', 'value' => ''])

<div>
    <div class="inline-flex items-center gap-x-2 mb-1">
        <span class="w-2 h-2 bg-white inline-block"></span>
        <label class="font-bold" for="{{ $name }}">{{ $label }}</label>
    </div>
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ $type !== 'password' ? $value : '' }}"
        class="rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full focus:outline-none focus:border-blue-500/50 transition-colors {{ $errors->has($name) ? 'border-rose-500/50' : '' }}">
    @error($name)
        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
    @enderror
</div>