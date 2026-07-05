@props(['user', 'size' => 'md'])

@php
    $sizes = [
        'sm' => 'w-6 h-6 text-[9px]',
        'md' => 'w-8 h-8 text-[11px]',
        'lg' => 'w-10 h-10 text-[13px]',
        'xl' => 'w-16 h-16 text-[20px]',
    ];

    $avatarColors = ['bg-blue-500','bg-violet-500','bg-emerald-600','bg-amber-500','bg-rose-500'];
    $color = $avatarColors[$user->id % count($avatarColors)];

    $initials = collect(explode(' ', $user->name))
        ->map(fn($w) => strtoupper($w[0]))
        ->take(2)
        ->implode('');
@endphp

@if($user->avatar)
    <img src="{{ Storage::url($user->avatar) }}"
         alt="{{ $user->name }}"
         class="{{ $sizes[$size] }} rounded-full object-cover shrink-0">
@else
    <div class="{{ $sizes[$size] }} {{ $color }} rounded-full flex items-center justify-center font-semibold text-white shrink-0">
        {{ $initials }}
    </div>
@endif