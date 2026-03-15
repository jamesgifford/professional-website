<x-layouts::public title="Projects" metaDescription="Software projects built by James Gifford, including web applications, backend systems, and developer tools." canonicalUrl="{{ route('projects.index') }}">
    <section class="px-6 py-16 sm:py-24">
        <div class="mx-auto max-w-5xl">
            <div class="mb-12">
                <p class="font-mono text-xs text-emerald-600 dark:text-emerald-400 mb-2 tracking-wide">// projects</p>
                <h1 class="text-4xl font-semibold tracking-tight">Projects</h1>
                <p class="mt-3 text-zinc-500 dark:text-zinc-400">Things I've built.</p>
            </div>

            <div class="space-y-8">
                @forelse ($projects as $project)
                    <article class="group">
                        <a href="{{ route('projects.show', $project) }}" class="block rounded-lg border border-zinc-200 dark:border-zinc-800 overflow-hidden hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors">
                            @if ($project->featured_image)
                                <img src="{{ Storage::disk('public')->url($project->featured_image) }}" alt="" class="w-full aspect-[3/1] object-cover" />
                            @endif
                            <div class="p-6">
                                <h2 class="text-xl font-medium group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                    {{ $project->name }}
                                </h2>
                                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed line-clamp-2">
                                    {{ Str::limit(strip_tags($project->description), 200) }}
                                </p>
                                @if ($project->technologies)
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @foreach ($project->technologies as $tech)
                                            <span class="font-mono text-xs px-2 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">{{ $tech }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </a>
                    </article>
                @empty
                    <div class="text-center py-16">
                        <p class="text-zinc-500 dark:text-zinc-400">No projects yet. Check back soon!</p>
                    </div>
                @endforelse
            </div>

            @if ($projects->hasPages())
                <nav class="mt-12 flex items-center justify-between">
                    @if ($projects->previousPageUrl())
                        <a href="{{ $projects->previousPageUrl() }}" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">&larr; newer</a>
                    @else
                        <span></span>
                    @endif

                    @if ($projects->nextPageUrl())
                        <a href="{{ $projects->nextPageUrl() }}" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">older &rarr;</a>
                    @endif
                </nav>
            @endif
        </div>
    </section>
</x-layouts::public>
