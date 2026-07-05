<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevDZ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#08090e] text-slate-200 overflow-hidden h-screen">

    {{-- NAV --}}
    <nav class="bg-[#0d0f17] border-b border-white/[0.07] h-12 flex items-center px-6 sticky top-0 z-50">
        <div class="flex items-center justify-between w-full max-w-275 mx-auto">

            <a href="/" class="text-[15px] font-semibold tracking-tight text-slate-100 shrink-0">
                Dev<span class="text-blue-400">DZ</span>
            </a>

            {{-- Sort + Filter tabs --}}
            <div class="flex items-center gap-0.5">
                @foreach([
                    ['label' => 'Feed',      'href' => '/',                    'active' => request()->is('/') && !request()->has('type') && !request()->has('sort')],
                    ['label' => 'Projects',  'href' => '/?type=project',       'active' => request()->get('type') === 'project'],
                    ['label' => 'Jobs',      'href' => '/?type=job',           'active' => request()->get('type') === 'job'],
                    ['label' => 'Questions', 'href' => '/?type=question',      'active' => request()->get('type') === 'question'],
                ] as $tab)
                    <a href="{{ $tab['href'] }}"
                       class="text-[12px] px-3 py-1.5 rounded-md transition-colors {{ $tab['active'] ? 'text-blue-400 bg-blue-400/10' : 'text-slate-500 hover:text-slate-200 hover:bg-white/5' }}">
                        {{ $tab['label'] }}
                    </a>
                @endforeach

                @unless(request()->is('posts/create'))
                    {{-- Sort tabs --}}
                    <div class="w-px h-4 bg-white/10 mx-1"></div>
                    @foreach([['label' => 'Latest', 'sort' => 'latest'], ['label' => 'Top', 'sort' => 'top']] as $s)
                        <a href="{{ request()->fullUrlWithQuery(['sort' => $s['sort']]) }}"
                        class="text-[12px] px-3 py-1.5 rounded-md transition-colors {{ request()->get('sort', 'latest') === $s['sort'] ? 'text-slate-100 bg-white/5' : 'text-slate-500 hover:text-slate-200 hover:bg-white/5' }}">
                            {{ $s['label'] }}
                        </a>
                    @endforeach
                @endunless
            </div>
            <form action="/" method="GET" class="flex items-center">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search..."
                        class="bg-slate-800/60 border border-slate-700 rounded-lg pl-8 pr-3 py-1.5 text-[12px] text-slate-300 placeholder-slate-600 focus:outline-none focus:border-blue-500/60 transition-colors w-40 focus:w-56">
                </div>
            </form>

            <div class="flex items-center gap-2">
                @auth
                    @unless(request()->is('posts/create'))
                        <a href="/posts/create" class="text-[12px] font-medium px-3 py-1.5 rounded-md bg-blue-500 hover:bg-blue-400 text-white transition-colors">+ Post</a>
                    @endunless                    <a href="/users/{{ auth()->id() }}" class="text-[12px] text-slate-400 hover:text-slate-200 px-3 py-1.5 rounded-md hover:bg-white/5 transition-colors">{{ auth()->user()->name }}</a>
                    <form method="POST" action="/logout" class="inline">
                        @csrf
                        <button class="text-[12px] text-slate-500 hover:text-slate-200 px-3 py-1.5 rounded-md border border-white/10 hover:bg-white/5 transition-colors cursor-pointer">Logout</button>
                    </form>
                @endauth
                @guest
                    <a href="/login" class="text-[12px] text-slate-400 hover:text-slate-200 px-3 py-1.5 rounded-md border border-white/10 hover:bg-white/5 transition-colors">Login</a>
                    <a href="/register" class="text-[12px] font-medium px-3 py-1.5 rounded-md bg-blue-500 hover:bg-blue-400 text-white transition-colors">Register</a>
                @endguest
            </div>

        </div>
    </nav>

    {{-- BODY --}}
    <div class="flex h-[calc(100vh-48px)] max-w-275 mx-auto">

        @if(request()->is('/'))
        {{-- LEFT SIDEBAR --}}
        <aside class="w-50 shrink-0 border-r border-white/[0.07] py-4 px-3 flex flex-col gap-1 overflow-hidden">

            @php
                $navItems = [
                    ['label' => 'Feed',      'href' => '/',               'active' => request()->is('/') && !request()->has('type')],
                    ['label' => 'Projects',  'href' => '/?type=project',  'active' => request()->get('type') === 'project'],
                    ['label' => 'Jobs',      'href' => '/?type=job',      'active' => request()->get('type') === 'job'],
                    ['label' => 'Questions', 'href' => '/?type=question', 'active' => request()->get('type') === 'question'],
                ];
                $icons = [
                    'Feed'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
                    'Projects'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>',
                    'Jobs'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                    'Questions' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                ];
            @endphp

            @foreach($navItems as $item)
                <a href="{{ $item['href'] }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition-colors {{ $item['active'] ? 'text-slate-100 bg-white/5' : 'text-slate-500 hover:text-slate-200 hover:bg-white/5' }}">
                    <svg xmlns="http://www.zw3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">{!! $icons[$item['label']] !!}</svg>
                    {{ $item['label'] }}
                </a>
            @endforeach

            <div class="h-px bg-white/[0.07] my-2"></div>

            {{-- City search --}}
            <form action="/" method="GET" class="px-1">
                @if(request()->has('type'))
                    <input type="hidden" name="type" value="{{ request()->get('type') }}">
                @endif
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input
                        type="text"
                        name="city"
                        value="{{ request()->get('city') }}"
                        placeholder="Search city..."
                        class="w-full bg-white/4 border border-white/[0.07] rounded-lg pl-8 pr-3 py-1.5 text-[12px] text-slate-300 placeholder-slate-600 focus:outline-none focus:border-blue-500/50 transition-colors"
                    >
                </div>
            </form>

            @auth
                @unless(request()->is('posts/create'))
                    <div class="mt-auto pt-4">
                        <a href="/posts/create" class="...">+ New post</a>
                    </div>
                @endunless
            @endauth

        </aside>
        @endif

        {{-- FEED --}}
        <main class="flex-1 overflow-y-auto [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] scrollbar-none">
            <div class="flex flex-col gap-2 p-3">
                {{ $slot }}
            </div>
        </main>

        
    </div>

</body>
</html>
