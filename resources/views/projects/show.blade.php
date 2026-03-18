<x-layouts::public
    :title="$project->name"
    :metaDescription="Str::limit(strip_tags($project->description), 160)"
    :metaImage="$project->featured_image_path ? asset($project->featured_image_path) : null"
    :canonicalUrl="route('projects.show', $project)"
>
    @push('json-ld')
        <script type="application/ld+json">
            {!! json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'SoftwareApplication',
                'name' => $project->name,
                'description' => Str::limit(strip_tags($project->description), 160),
                'author' => [
                    '@type' => 'Person',
                    'name' => 'James Gifford',
                    'url' => route('home'),
                ],
                'url' => route('projects.show', $project),
            ] + ($project->featured_image_path ? ['image' => asset($project->featured_image_path)] : []) + ($project->url ? ['installUrl' => $project->url] : []), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endpush

    <article class="px-6 py-16 sm:py-24">
        <div class="mx-auto max-w-3xl">
            {{-- Header --}}
            <header class="mb-12">
                <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-1 font-mono text-xs text-zinc-400 dark:text-zinc-600 hover:text-zinc-600 dark:hover:text-zinc-400 transition-colors mb-6 bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">
                    &larr; back to projects
                </a>
                <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight leading-tight bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5 w-fit">
                    {{ $project->name }}
                </h1>

                @if ($project->technologies)
                    <div class="mt-4 flex flex-wrap gap-2 bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5 w-fit">
                        @foreach ($project->technologies as $tech)
                            <span class="font-mono text-xs px-2 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">{{ $tech }}</span>
                        @endforeach
                    </div>
                @endif

                @if ($project->url)
                    <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 mt-4 font-mono text-sm text-emerald-600 dark:text-emerald-400 hover:underline underline-offset-4 bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">
                        <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                        visit project
                    </a>
                @endif
            </header>

            {{-- Featured Image --}}
            @if ($project->featured_image)
                <div class="mb-12 rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-800">
                    <img src="{{ asset($project->featured_image_path) }}" alt="" class="w-full aspect-[3/1] object-cover" />
                </div>
            @endif

            {{-- Screenshots --}}
            @if ($project->screenshots->count())
                <div class="mb-12 space-y-4">
                    @foreach ($project->screenshots as $screenshot)
                        <div class="rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-800">
                            <img
                                src="{{ asset($screenshot->path) }}"
                                alt="{{ $screenshot->alt_text ?? $project->name }}"
                                class="w-full"
                                loading="lazy"
                            />
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Description --}}
            <div class="prose prose-zinc dark:prose-invert max-w-none prose-headings:tracking-tight prose-a:text-emerald-600 dark:prose-a:text-emerald-400 prose-code:font-mono [&>*]:bg-zinc-50/80 [&>*]:dark:bg-zinc-950/80 [&>*]:backdrop-blur-md [&>*]:rounded-lg [&>*]:px-3 [&>*]:py-1.5 [&>pre]:px-5 [&>pre]:py-4 [&>blockquote]:px-5 [&>table]:p-5 [&_table]:w-full">
                {!! str($project->description)->markdown() !!}
            </div>

            {{-- Footer --}}
            <footer class="mt-16 pt-8 border-t border-zinc-200 dark:border-zinc-800">
                <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-1 font-mono text-xs text-zinc-400 dark:text-zinc-600 hover:text-zinc-600 dark:hover:text-zinc-400 transition-colors bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">
                    &larr; back to projects
                </a>
            </footer>
        </div>
    </article>

    @include('partials.contact')
</x-layouts::public>
