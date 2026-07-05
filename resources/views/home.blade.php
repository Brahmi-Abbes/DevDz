<x-layout>
    @foreach ($posts as $post)
        <x-post-card :$post />
    @endforeach
</x-layout>