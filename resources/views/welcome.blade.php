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
        {{-- Blueprint dot grid --}}
        <div class="fixed inset-0 -z-[5] opacity-[0.03] dark:opacity-[0.06]"
             style="background-image: radial-gradient(circle, currentColor 1px, transparent 1px); background-size: 24px 24px;">
        </div>

        {{-- Navigation --}}
        @include('partials.nav')

        <main>
            {{-- Hero --}}
            <section class="min-h-svh flex items-center px-6">
                <div class="mx-auto max-w-5xl w-full py-32">
                    <p class="font-mono text-xs text-emerald-600 dark:text-emerald-400 mb-4 tracking-wide bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5 w-fit">// hello, world</p>
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-semibold tracking-tight leading-[1.1] bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-2 w-fit">
                        James Gifford
                    </h1>
                    <p class="mt-4 text-xl sm:text-2xl text-zinc-500 dark:text-zinc-400 font-light max-w-xl bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5 w-fit">
                        Software Engineer
                    </p>
                    <div class="mt-8 flex items-center gap-4 bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-2 w-fit">
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
                    <div class="mt-16 font-mono text-sm text-zinc-400 dark:text-zinc-600 flex items-center gap-3 bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5 w-fit">
                        <span class="relative inline-flex size-2.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75" style="animation-duration: 2s;"></span>
                            <span class="relative inline-flex size-2.5 rounded-full bg-emerald-500"></span>
                        </span>
                        <span>available for new projects</span>
                    </div>
                </div>
            </section>

            {{-- About --}}
            <section id="about" class="px-6 py-24 sm:py-32">
                <div class="mx-auto max-w-5xl">
                    <div class="grid lg:grid-cols-12 gap-12 lg:gap-16">
                        <div class="lg:col-span-4">
                            <p class="font-mono text-xs text-emerald-600 dark:text-emerald-400 mb-2 tracking-wide bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5 w-fit">// about</p>
                            <h2 class="text-3xl font-semibold tracking-tight bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5 w-fit">My Background</h2>
                        </div>
                        <div class="lg:col-span-8 space-y-6 text-zinc-600 dark:text-zinc-400 leading-relaxed">
                            <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">
                                I'm a software engineer with 20 years of experience building web applications, mostly for startups and SaaS companies. I've worked on calendar platforms used by hundreds of thousands of businesses, music databases serving over 100 million users, lead generation tools, e-commerce systems, and job boards for medical staffing.
                            </p>
                            <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">
                                My primary stack is PHP and Laravel, but I've worked across the full stack throughout my career: JavaScript, TypeScript, React, Vue, MySQL, Redis, Stripe integrations, background job queues, database schema design at scale. I care more about choosing the right tool for the problem than being loyal to any one technology.
                            </p>
                            <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">
                                Most recently I founded Progravity, a software company where I'm building my own SaaS products. The first is Mentioned, a brand monitoring tool that tracks where businesses appear online, including in AI-generated search results, which is a space that's changing fast and that most existing tools haven't caught up with yet.
                            </p>
                            <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">
                                I've also been leaning heavily into AI-assisted development, not as a replacement for engineering judgment, but as a way to move faster on the mechanical parts and spend more time on the decisions that actually matter. I've written about that experience on this site.
                            </p>
                            <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">
                                I'm currently open to remote senior engineering or technical leadership roles, particularly at early-stage startups where I can have a broad impact. If that sounds like your team, I'd love to hear from you.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Work --}}
            <section id="work" class="px-6 py-24 sm:py-32 border-t border-zinc-200 dark:border-zinc-800">
                <div class="mx-auto max-w-5xl">
                    <div class="mb-12">
                        <p class="font-mono text-xs text-emerald-600 dark:text-emerald-400 mb-2 tracking-wide bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5 w-fit">// work</p>
                        <h2 class="text-3xl font-semibold tracking-tight bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5 w-fit">What I Do</h2>
                    </div>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="group">
                            <div class="p-6 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-zinc-50/95 dark:bg-zinc-950/95 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors h-full">
                                <div class="font-mono text-xs text-zinc-400 dark:text-zinc-600 mb-3">01</div>
                                <h3 class="text-lg font-medium mb-2">Product Development</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                    End-to-end development of software from concept and architecture through billing, launch, and iteration.
                                </p>
                            </div>
                        </div>
                        <div class="group">
                            <div class="p-6 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-zinc-50/95 dark:bg-zinc-950/95 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors h-full">
                                <div class="font-mono text-xs text-zinc-400 dark:text-zinc-600 mb-3">02</div>
                                <h3 class="text-lg font-medium mb-2">System Architecture & Design</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                    Planning and building systems that are maintainable today and scalable tomorrow. Experienced in platform modernization and large-scale refactoring.
                                </p>
                            </div>
                        </div>
                        <div class="group">
                            <div class="p-6 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-zinc-50/95 dark:bg-zinc-950/95 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors h-full">
                                <div class="font-mono text-xs text-zinc-400 dark:text-zinc-600 mb-3">03</div>
                                <h3 class="text-lg font-medium mb-2">Full-Stack Web Development</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                    Building complete web applications from database to UI, with a focus on clean architecture and reliable delivery.
                                </p>
                            </div>
                        </div>
                        <div class="group">
                            <div class="p-6 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-zinc-50/95 dark:bg-zinc-950/95 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors h-full">
                                <div class="font-mono text-xs text-zinc-400 dark:text-zinc-600 mb-3">04</div>
                                <h3 class="text-lg font-medium mb-2">API Design & Integration</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                    Designing developer-friendly APIs and integrating with third-party services, payment processors, and data providers.
                                </p>
                            </div>
                        </div>
                        <div class="group">
                            <div class="p-6 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-zinc-50/95 dark:bg-zinc-950/95 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors h-full">
                                <div class="font-mono text-xs text-zinc-400 dark:text-zinc-600 mb-3">05</div>
                                <h3 class="text-lg font-medium mb-2">Database Design & Optimization</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                    Schema design, query performance tuning, and data modeling for applications managing millions to billions of records.
                                </p>
                            </div>
                        </div>
                        <div class="group">
                            <div class="p-6 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-zinc-50/95 dark:bg-zinc-950/95 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors h-full">
                                <div class="font-mono text-xs text-zinc-400 dark:text-zinc-600 mb-3">06</div>
                                <h3 class="text-lg font-medium mb-2">Billing & Subscription Systems</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                    Implementing subscription billing, plan management, payment processing, and the self-service experiences that reduce support overhead.
                                </p>
                            </div>
                        </div>
                        <div class="group">
                            <div class="p-6 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-zinc-50/95 dark:bg-zinc-950/95 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors h-full">
                                <div class="font-mono text-xs text-zinc-400 dark:text-zinc-600 mb-3">07</div>
                                <h3 class="text-lg font-medium mb-2">Background Processing & Data Pipelines</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                    Designing asynchronous systems for data ingestion, scheduled enrichment, rate-limited API orchestration, and long-running workflows.
                                </p>
                            </div>
                        </div>
                        <div class="group">
                            <div class="p-6 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-zinc-50/95 dark:bg-zinc-950/95 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors h-full">
                                <div class="font-mono text-xs text-zinc-400 dark:text-zinc-600 mb-3">08</div>
                                <h3 class="text-lg font-medium mb-2">AI-Assisted Development</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                    Integrating AI tools into professional development workflows to accelerate delivery without sacrificing architectural quality.
                                </p>
                            </div>
                        </div>
                        <div class="group">
                            <div class="p-6 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-zinc-50/95 dark:bg-zinc-950/95 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors h-full">
                                <div class="font-mono text-xs text-zinc-400 dark:text-zinc-600 mb-3">09</div>
                                <h3 class="text-lg font-medium mb-2">Legacy Modernization</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                    Bringing aging codebases into the present by improving reliability, performance, and developer experience without starting from scratch.
                                </p>
                            </div>
                        </div>
                        <div class="group">
                            <div class="p-6 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-zinc-50/95 dark:bg-zinc-950/95 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors h-full">
                                <div class="font-mono text-xs text-zinc-400 dark:text-zinc-600 mb-3">10</div>
                                <h3 class="text-lg font-medium mb-2">Technical Leadership & Mentorship</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                    Leading small engineering teams, establishing code review and documentation practices, and helping junior developers grow.
                                </p>
                            </div>
                        </div>
                        <div class="group">
                            <div class="p-6 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-zinc-50/95 dark:bg-zinc-950/95 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors h-full">
                                <div class="font-mono text-xs text-zinc-400 dark:text-zinc-600 mb-3">11</div>
                                <h3 class="text-lg font-medium mb-2">Software Consultancy</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                    Advising businesses on technical strategy, architecture decisions, and build-vs-buy tradeoffs for web-based products.
                                </p>
                            </div>
                        </div>
                        <div class="group">
                            <div class="p-6 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-zinc-50/95 dark:bg-zinc-950/95 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors h-full">
                                <div class="font-mono text-xs text-zinc-400 dark:text-zinc-600 mb-3">12</div>
                                <h3 class="text-lg font-medium mb-2">Remote Team Engineering</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                                    Building effective engineering workflows for distributed teams with documentation-first practices, async communication, and self-directed delivery.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @include('partials.contact')
        </main>

        {{-- Footer --}}
        <footer class="relative px-6 py-8 bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md">
            <div class="absolute inset-x-0 -top-6 h-6 pointer-events-none bg-gradient-to-b from-transparent to-zinc-50/80 dark:to-zinc-950/80 backdrop-blur-[1px]" aria-hidden="true"></div>
            <div class="mx-auto max-w-5xl flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="font-mono text-xs text-zinc-400 dark:text-zinc-600">
                    &copy; {{ date('Y') }} James Gifford
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
