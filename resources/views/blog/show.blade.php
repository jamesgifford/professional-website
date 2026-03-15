<x-layouts::public
    :title="$post->title"
    :metaDescription="$post->excerpt"
    :metaImage="$post->featured_image ? Storage::disk('public')->url($post->featured_image) : null"
    ogType="article"
    :canonicalUrl="route('blog.show', $post)"
>
    @push('json-ld')
        <script type="application/ld+json">
            {!! json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => $post->title,
                'description' => $post->excerpt,
                'datePublished' => $post->published_at->toIso8601String(),
                'author' => [
                    '@type' => 'Person',
                    'name' => 'James Gifford',
                    'url' => route('home'),
                ],
                'url' => route('blog.show', $post),
            ] + ($post->featured_image ? ['image' => Storage::disk('public')->url($post->featured_image)] : []), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endpush

    <article class="px-6 py-16 sm:py-24">
        <div class="mx-auto max-w-3xl">
            {{-- Header --}}
            <header class="mb-12">
                <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-1 font-mono text-xs text-zinc-400 dark:text-zinc-600 hover:text-zinc-600 dark:hover:text-zinc-400 transition-colors mb-6">
                    &larr; back to thoughts
                </a>
                <time class="block font-mono text-xs text-emerald-600 dark:text-emerald-400 mb-3" datetime="{{ $post->published_at->toDateString() }}">
                    {{ $post->published_at->format('M j, Y') }}
                </time>
                <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight leading-tight">
                    {{ $post->title }}
                </h1>
            </header>

            {{-- Content --}}
            <div class="prose prose-zinc dark:prose-invert max-w-none prose-headings:tracking-tight prose-a:text-emerald-600 dark:prose-a:text-emerald-400 prose-code:font-mono">
                {!! str($post->body)->markdown() !!}
            </div>

            {{-- Footer --}}
            <footer class="mt-16 pt-8 border-t border-zinc-200 dark:border-zinc-800">
                <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-1 font-mono text-xs text-zinc-400 dark:text-zinc-600 hover:text-zinc-600 dark:hover:text-zinc-400 transition-colors">
                    &larr; back to thoughts
                </a>
            </footer>
        </div>
    </article>
</x-layouts::public>
