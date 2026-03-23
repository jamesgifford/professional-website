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
        @include('partials.nav')

        <main class="pt-28">
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
