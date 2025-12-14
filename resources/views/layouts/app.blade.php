<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <link rel="icon" type="image/x-icon" href="/favicon.ico" />
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png" />
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>GeoPinner - Hitta platsen!</title>

        <!-- PWA Meta Tags -->
        <meta name="theme-color" content="#1e3a8a" />
        <meta name="description" content="Hitta platser runt om i världen! Ett interaktivt geografispel." />
        <meta name="mobile-web-app-capable" content="yes" />
        <link rel="manifest" href="/manifest.json" />

        <!-- Apple Touch Icons -->
        <link rel="apple-touch-icon" href="/icons/icon-192.png" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <meta name="apple-mobile-web-app-title" content="Geopinner" />

        <!-- Leaflet CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

        <!-- Google Fonts - Inter -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app-livewire.js'])
        @livewireStyles
    </head>
    <body class="antialiased bg-slate-900 text-white">
        {{ $slot }}

        <!-- Leaflet JS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        @livewireScripts
    </body>
</html>
