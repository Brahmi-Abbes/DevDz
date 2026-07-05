<x-layout>
<div class="max-w-2xl mx-auto py-6 px-4">

    <div class="flex items-center gap-3 mb-6">
        <x-back-link href="/profile" label="Profile" />
        <h1 class="text-[15px] font-semibold text-slate-100">Saved posts</h1>
    </div>

    @forelse($posts as $post)
        <x-post-card :post="$post" />
    @empty
        <div class="text-center py-16">
            <p class="text-[14px] text-slate-500">No saved posts yet.</p>
            <a href="/" class="text-[13px] text-blue-400 hover:text-blue-300 transition-colors mt-2 inline-block">Browse the feed →</a>
        </div>
    @endforelse

</div>
</x-layout>