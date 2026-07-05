<x-layout>
<div class="max-w-xl mx-auto py-8 px-4">

    <div class="flex items-center gap-3 mb-6">
        <x-back-link href="/posts/{{ $post->id }}" label="Back" />
        <h1 class="text-[15px] font-semibold text-slate-100">Edit post</h1>
    </div>

    <x-composer action="/posts/{{ $post->id }}" method="PUT" :post="$post" />

</div>
</x-layout>