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
                    <a href="{{ route('home') }}#about" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">about</a>
                    <a href="{{ route('home') }}#work" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">work</a>
                    <a href="{{ route('projects.index') }}" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors {{ request()->routeIs('projects.*') ? '!text-zinc-900 dark:!text-zinc-100' : '' }}">projects</a>
                    <a href="{{ route('blog.index') }}" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors {{ request()->routeIs('blog.*') ? '!text-zinc-900 dark:!text-zinc-100' : '' }}">thoughts</a>
                    <a href="{{ route('home') }}#contact" class="font-mono text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">contact</a>
                </div>
            </nav>
        </header>

        <main class="pt-20">
            {{ $slot }}
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
