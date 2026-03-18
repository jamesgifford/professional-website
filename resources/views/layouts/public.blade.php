@props(['title' => null, 'metaDescription' => null, 'metaImage' => null, 'ogType' => 'website', 'canonicalUrl' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head', [
            'title' => $title,
            'metaDescription' => $metaDescription,
            'metaImage' => $metaImage,
            'ogType' => $ogType,
            'canonicalUrl' => $canonicalUrl,
        ])
    </head>
    <body class="bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 antialiased">
        {{-- Blueprint dot grid --}}
        <div class="fixed inset-0 -z-[5] opacity-[0.03] dark:opacity-[0.06]"
             style="background-image: radial-gradient(circle, currentColor 1px, transparent 1px); background-size: 24px 24px;">
        </div>

        {{-- Navigation --}}
        <header class="fixed top-0 inset-x-0 z-50 bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md" x-data="{ open: false }">
            <nav class="mx-auto max-w-5xl flex items-center justify-between px-6 py-5">
                <a href="{{ route('home') }}" class="font-mono text-lg font-medium tracking-tight text-zinc-900 dark:text-zinc-100">
                    jg<span class="text-emerald-600 dark:text-emerald-400">.</span>
                </a>

                {{-- Desktop nav --}}
                <div class="hidden sm:flex items-center gap-6">
                    <a href="{{ route('home') }}#about" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">about</a>
                    <a href="{{ route('career') }}" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors {{ request()->routeIs('career') ? '!text-zinc-900 dark:!text-zinc-100' : '' }}">career</a>
                    <a href="{{ route('projects.index') }}" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors {{ request()->routeIs('projects.*') ? '!text-zinc-900 dark:!text-zinc-100' : '' }}">projects</a>
                    <a href="{{ route('blog.index') }}" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors {{ request()->routeIs('blog.*') ? '!text-zinc-900 dark:!text-zinc-100' : '' }}">thoughts</a>
                    <a href="#contact" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">contact</a>
                </div>

                {{-- Mobile hamburger --}}
                <button x-on:click="open = !open" class="sm:hidden p-1 text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors" aria-label="Toggle menu">
                    <svg x-show="!open" class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg x-show="open" x-cloak class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </nav>

            {{-- Mobile menu --}}
            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="sm:hidden border-t border-zinc-200 dark:border-zinc-800">
                <div class="mx-auto max-w-5xl flex flex-col gap-1 px-6 py-4">
                    <a href="{{ route('home') }}#about" x-on:click="open = false" class="font-mono text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors py-2">about</a>
                    <a href="{{ route('career') }}" x-on:click="open = false" class="font-mono text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors py-2 {{ request()->routeIs('career') ? '!text-zinc-900 dark:!text-zinc-100' : '' }}">career</a>
                    <a href="{{ route('projects.index') }}" x-on:click="open = false" class="font-mono text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors py-2 {{ request()->routeIs('projects.*') ? '!text-zinc-900 dark:!text-zinc-100' : '' }}">projects</a>
                    <a href="{{ route('blog.index') }}" x-on:click="open = false" class="font-mono text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors py-2 {{ request()->routeIs('blog.*') ? '!text-zinc-900 dark:!text-zinc-100' : '' }}">thoughts</a>
                    <a href="#contact" x-on:click="open = false" class="font-mono text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors py-2">contact</a>
                </div>
            </div>
        </header>

        <main class="pt-20">
            {{ $slot }}
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

        <script>
            document.querySelectorAll('.prose a').forEach(function (link) {
                if (link.hostname && link.hostname !== window.location.hostname) {
                    link.setAttribute('target', '_blank');
                    link.setAttribute('rel', 'noopener noreferrer');
                }
            });
        </script>
    </body>
</html>
