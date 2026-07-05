@props(['action', 'title', 'submit'])

<div class="max-w-2xl mx-auto space-y-6 py-10 px-4">
    <h1 class="text-center text-3xl font-bold">{{ $title }}</h1>

    <form method="POST" action="{{ $action }}" class="space-y-6">
        @csrf
        {{ $slot }}
        <button class="bg-blue-600 hover:bg-blue-500 rounded py-2 px-6 font-bold transition-colors">
            {{ $submit }}
        </button>
    </form>
</div>