<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}</title>

@if (filled($metaDescription ?? null))
    <meta name="description" content="{{ $metaDescription }}" />
@endif

<link rel="canonical" href="{{ $canonicalUrl ?? url()->current() }}" />

{{-- Open Graph --}}
<meta property="og:site_name" content="{{ config('app.name') }}" />
<meta property="og:title" content="{{ filled($title ?? null) ? $title.' - '.config('app.name') : config('app.name') }}" />
<meta property="og:type" content="{{ $ogType ?? 'website' }}" />
<meta property="og:url" content="{{ $canonicalUrl ?? url()->current() }}" />
@if (filled($metaDescription ?? null))
    <meta property="og:description" content="{{ $metaDescription }}" />
@endif
@if (filled($metaImage ?? null))
    <meta property="og:image" content="{{ $metaImage }}" />
@endif

{{-- Twitter Card --}}
<meta name="twitter:card" content="{{ filled($metaImage ?? null) ? 'summary_large_image' : 'summary' }}" />
<meta name="twitter:title" content="{{ filled($title ?? null) ? $title.' - '.config('app.name') : config('app.name') }}" />
@if (filled($metaDescription ?? null))
    <meta name="twitter:description" content="{{ $metaDescription }}" />
@endif
@if (filled($metaImage ?? null))
    <meta name="twitter:image" content="{{ $metaImage }}" />
@endif

@stack('json-ld')

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|jetbrains-mono:400,500" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
