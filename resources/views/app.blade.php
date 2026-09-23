<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title inertia>
        {{ config('app.name', 'Belajar & Bermain') }}
    </title>

    <!-- PWA -->
    <link
        rel="manifest"
        href="/build/manifest.webmanifest"
    >

    <meta
        name="theme-color"
        content="#08777b"
    >

    <meta
        name="mobile-web-app-capable"
        content="yes"
    >

    <meta
        name="apple-mobile-web-app-capable"
        content="yes"
    >

    <meta
        name="apple-mobile-web-app-status-bar-style"
        content="default"
    >

    <meta
        name="apple-mobile-web-app-title"
        content="Belajar & Bermain"
    >

    <!-- PWA ICON -->
    <link
        rel="icon"
        href="/icons/Logo192x192.png"
        sizes="192x192"
        type="image/png"
    >

    <link
        rel="apple-touch-icon"
        href="/icons/Logo192x192.png"
    >

    <!-- Fonts -->
    <link
        rel="preconnect"
        href="https://fonts.bunny.net"
    >

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
        rel="stylesheet"
    />

    <!-- Routes -->
    @routes

    <!-- Scripts -->
    @vite([
        'resources/js/app.js',
        "resources/js/Pages/{$page['component']}.vue"
    ])

    @inertiaHead

    <!-- PWA Service Worker Registration -->
    <script
        src="/build/registerSW.js"
        defer
    ></script>
</head>

<body class="font-sans antialiased">

    @inertia

</body>

</html>