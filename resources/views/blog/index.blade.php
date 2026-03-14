<x-layouts::public title="Thoughts">
    <section class="px-6 py-16 sm:py-24">
        <div class="mx-auto max-w-5xl">
            <div class="mb-12">
                <p class="font-mono text-xs text-emerald-600 dark:text-emerald-400 mb-2 tracking-wide">// thoughts</p>
                <h1 class="text-4xl font-semibold tracking-tight">Thoughts</h1>
                <p class="mt-3 text-zinc-500 dark:text-zinc-400">On software, engineering, and building things.</p>
            </div>

            <div class="space-y-8">
                @forelse ($posts as $post)
                    <article class="group">
                        <a href="{{ route('blog.show', $post) }}" class="block rounded-lg border border-zinc-200 dark:border-zinc-800 overflow-hidden hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors">
                            @if ($post->featured_image)
                                <img src="{{ Storage::disk('public')->url($post->featured_image) }}" alt="" class="w-full aspect-[3/1] object-cover" />
                            @endif
                            <div class="p-6">
                                <div class="flex items-center gap-3 mb-3">
                                    <time class="font-mono text-xs text-zinc-400 dark:text-zinc-600" datetime="{{ $post->published_at->toDateString() }}">
                                        {{ $post->published_at->format('M j, Y') }}
                                    </time>
                                </div>
                                <h2 class="text-xl font-medium group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                    {{ $post->title }}
                                </h2>
                                @if ($post->excerpt)
                                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                        {{ $post->excerpt }}
                                    </p>
                                @endif
                                <span class="inline-block mt-4 font-mono text-xs text-emerald-600 dark:text-emerald-400">read more &rarr;</span>
                            </div>
                        </a>
                    </article>
                @empty
                    <div class="text-center py-16">
                        <p class="text-zinc-500 dark:text-zinc-400">Nothing here yet. Check back soon!</p>
                    </div>
                @endforelse
            </div>

            @if ($posts->hasPages())
                <nav class="mt-12 flex items-center justify-between">
                    @if ($posts->previousPageUrl())
                        <a href="{{ $posts->previousPageUrl() }}" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">&larr; newer</a>
                    @else
                        <span></span>
                    @endif

                    @if ($posts->nextPageUrl())
                        <a href="{{ $posts->nextPageUrl() }}" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">older &rarr;</a>
                    @endif
                </nav>
            @endif
        </div>
    </section>
</x-layouts::public>
