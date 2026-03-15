<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head', [
            'title' => 'Software Engineer',
            'metaDescription' => 'James Gifford is a software engineer who builds clean, well-crafted web applications, backend systems, and developer tools.',
            'ogType' => 'website',
            'canonicalUrl' => route('home'),
        ])

        @push('json-ld')
            <script type="application/ld+json">
                {!! json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Person',
                    'name' => 'James Gifford',
                    'jobTitle' => 'Software Engineer',
                    'url' => route('home'),
                    'sameAs' => [
                        'https://github.com/jamesgifford',
                        'https://linkedin.com/in/jamesgifford',
                    ],
                ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
            </script>
        @endpush
    </head>
    <body class="bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 antialiased">
        {{-- Subtle dot grid background --}}
        <div class="fixed inset-0 -z-10 opacity-[0.03] dark:opacity-[0.06]"
             style="background-image: radial-gradient(circle, currentColor 1px, transparent 1px); background-size: 24px 24px;">
        </div>

        {{-- Navigation --}}
        <header class="fixed top-0 inset-x-0 z-50 bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md">
            <nav class="mx-auto max-w-5xl flex items-center justify-between px-6 py-5">
                <a href="{{ route('home') }}" class="font-mono text-lg font-medium tracking-tight text-zinc-900 dark:text-zinc-100">
                    jg<span class="text-emerald-600 dark:text-emerald-400">.</span>
                </a>
                <div class="flex items-center gap-6">
                    <a href="#about" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">about</a>
                    <a href="#work" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">work</a>
                    <a href="{{ route('projects.index') }}" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">projects</a>
                    <a href="{{ route('blog.index') }}" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">thoughts</a>
                    <a href="#contact" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">contact</a>
                </div>
            </nav>
        </header>

        <main>
            {{-- Hero --}}
            <section class="min-h-svh flex items-center px-6">
                <div class="mx-auto max-w-5xl w-full py-32">
                    <p class="font-mono text-xs text-emerald-600 dark:text-emerald-400 mb-4 tracking-wide">// hello, world</p>
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-semibold tracking-tight leading-[1.1]">
                        James Gifford
                    </h1>
                    <p class="mt-4 text-xl sm:text-2xl text-zinc-500 dark:text-zinc-400 font-light max-w-xl">
                        Software Engineer
                    </p>
                    <div class="mt-8 flex items-center gap-4">
                        <a href="#contact"
                           class="font-mono text-sm px-5 py-2.5 rounded bg-zinc-900 dark:bg-zinc-100 text-zinc-50 dark:text-zinc-900 hover:bg-zinc-700 dark:hover:bg-zinc-300 transition-colors">
                            get in touch
                        </a>
                        <a href="#about"
                           class="font-mono text-sm px-5 py-2.5 rounded border border-zinc-300 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 hover:border-zinc-500 dark:hover:border-zinc-500 transition-colors">
                            learn more
                        </a>
                    </div>

                    {{-- Terminal-style status line --}}
                    <div class="mt-16 font-mono text-xs text-zinc-400 dark:text-zinc-600 flex items-center gap-3">
                        <span class="inline-block size-1.5 rounded-full bg-emerald-500"></span>
                        <span>available for new projects</span>
                    </div>
                </div>
            </section>

            {{-- About --}}
            <section id="about" class="px-6 py-24 sm:py-32">
                <div class="mx-auto max-w-5xl">
                    <div class="grid lg:grid-cols-12 gap-12 lg:gap-16">
                        <div class="lg:col-span-4">
                            <p class="font-mono text-xs text-emerald-600 dark:text-emerald-400 mb-2 tracking-wide">// about</p>
                            <h2 class="text-3xl font-semibold tracking-tight">Background</h2>
                        </div>
                        <div class="lg:col-span-8 space-y-6 text-zinc-600 dark:text-zinc-400 leading-relaxed">
                            <p>
                                I'm a software engineer who enjoys building clean, well-crafted applications.
                                I focus on writing code that's maintainable, performant, and solves real problems.
                            </p>
                            <p>
                                Whether it's architecting a backend system, building interactive user interfaces,
                                or automating workflows, I bring a thoughtful approach to every project.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Work / Skills --}}
            <section id="work" class="px-6 py-24 sm:py-32 border-t border-zinc-200 dark:border-zinc-800">
                <div class="mx-auto max-w-5xl">
                    <div class="mb-12">
                        <p class="font-mono text-xs text-emerald-600 dark:text-emerald-400 mb-2 tracking-wide">// what I do</p>
                        <h2 class="text-3xl font-semibold tracking-tight">Areas of Focus</h2>
                    </div>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="group">
                            <div class="p-6 rounded-lg border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors h-full">
                                <div class="font-mono text-xs text-zinc-400 dark:text-zinc-600 mb-3">01</div>
                                <h3 class="text-lg font-medium mb-2">Web Applications</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                    Full-stack web development with modern frameworks and tools, from concept to deployment.
                                </p>
                            </div>
                        </div>
                        <div class="group">
                            <div class="p-6 rounded-lg border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors h-full">
                                <div class="font-mono text-xs text-zinc-400 dark:text-zinc-600 mb-3">02</div>
                                <h3 class="text-lg font-medium mb-2">Backend Systems</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                    Scalable APIs, data pipelines, and server-side architecture built for reliability.
                                </p>
                            </div>
                        </div>
                        <div class="group">
                            <div class="p-6 rounded-lg border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors h-full">
                                <div class="font-mono text-xs text-zinc-400 dark:text-zinc-600 mb-3">03</div>
                                <h3 class="text-lg font-medium mb-2">Developer Tools</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                    CLI tools, automation scripts, and integrations that make development smoother.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Contact --}}
            <section id="contact" class="px-6 py-24 sm:py-32 border-t border-zinc-200 dark:border-zinc-800">
                <div class="mx-auto max-w-5xl">
                    <div class="grid lg:grid-cols-12 gap-12 lg:gap-16">
                        <div class="lg:col-span-4">
                            <p class="font-mono text-xs text-emerald-600 dark:text-emerald-400 mb-2 tracking-wide">// contact</p>
                            <h2 class="text-3xl font-semibold tracking-tight">Let's Connect</h2>
                        </div>
                        <div class="lg:col-span-8">
                            <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed mb-8">
                                Have a project in mind or just want to chat? I'd love to hear from you.
                            </p>
                            <div class="flex flex-wrap gap-4">
                                <a href="mailto:james@jamesgifford.com"
                                   class="font-mono text-sm inline-flex items-center gap-2 px-5 py-2.5 rounded border border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 hover:border-zinc-400 dark:hover:border-zinc-600 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                    </svg>
                                    email
                                </a>
                                <a href="https://github.com/jamesgifford"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="font-mono text-sm inline-flex items-center gap-2 px-5 py-2.5 rounded border border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 hover:border-zinc-400 dark:hover:border-zinc-600 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                                    <svg class="size-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                                    </svg>
                                    github
                                </a>
                                <a href="https://linkedin.com/in/jamesgifford"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="font-mono text-sm inline-flex items-center gap-2 px-5 py-2.5 rounded border border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 hover:border-zinc-400 dark:hover:border-zinc-600 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                                    <svg class="size-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                    linkedin
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        {{-- Footer --}}
        <footer class="px-6 py-8 border-t border-zinc-200 dark:border-zinc-800">
            <div class="mx-auto max-w-5xl flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="font-mono text-xs text-zinc-400 dark:text-zinc-600">
                    &copy; {{ date('Y') }} James Gifford
                </p>
                <p class="font-mono text-xs text-zinc-400 dark:text-zinc-600">
                    Built with Laravel
                </p>
            </div>
        </footer>

        {{-- Dark mode toggle (fixed, lower-left) --}}
        <div class="fixed bottom-6 left-6 z-50" x-data>
            <flux:button
                variant="subtle"
                square
                x-on:click="$flux.dark = ! $flux.dark"
                aria-label="Toggle dark mode"
                class="!size-10 rounded-full border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-sm hover:border-zinc-400 dark:hover:border-zinc-600"
            >
                <flux:icon.sun x-show="$flux.dark" variant="mini" class="!size-4" />
                <flux:icon.moon x-show="! $flux.dark" variant="mini" class="!size-4" />
            </flux:button>
        </div>

        @fluxScripts
    </body>
</html>
