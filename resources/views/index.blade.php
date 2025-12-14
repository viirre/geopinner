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

    <!-- Google Fonts - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app-livewire.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-slate-900 text-white">
    <section class="w-full min-h-screen flex items-center justify-center relative overflow-hidden">
        <!-- Background -->
        <x-map-background blur="true" overlay="true" />

        <div class="relative z-10 w-full max-w-5xl px-4 flex flex-col items-center animate-fade-in">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <div class="bg-gradient-to-tr from-emerald-500 to-cyan-500 p-3 rounded-2xl shadow-lg shadow-emerald-500/20">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-white">GeoPinner</h1>
                </div>
                <p class="text-slate-300 text-lg md:text-xl font-light">Hitta platser runt om i världen – ju närmre du gissar, desto mer poäng!</p>
            </div>

            <!-- Game Mode Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full mb-12">
                <!-- Single Player Card -->
                <a href="{{ route('game.v2') }}" class="group relative glass-panel p-8 rounded-3xl text-left transition-all hover:bg-slate-800/90 hover:-translate-y-1 hover:border-emerald-500/50 cursor-pointer">
                    <div class="absolute top-6 right-6 opacity-20 group-hover:opacity-100 group-hover:scale-110 transition-all">
                        <svg class="w-16 h-16 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2 group-hover:text-emerald-400">Single Player</h2>
                    <p class="text-slate-400 mb-6 group-hover:text-slate-300">Testa dina egna kunskaper. Slå ditt personbästa.</p>
                    <span class="inline-flex items-center text-emerald-400 font-semibold">
                        Starta spel
                        <span class="ml-2 group-hover:translate-x-1 transition-transform">→</span>
                    </span>
                </a>

                <!-- Multiplayer Card -->
                <a href="{{ route('multiplayer.v2') }}" class="group relative glass-panel p-8 rounded-3xl text-left transition-all hover:bg-slate-800/90 hover:-translate-y-1 hover:border-blue-500/50 cursor-pointer">
                    <div class="absolute top-6 right-6 opacity-20 group-hover:opacity-100 group-hover:scale-110 transition-all">
                        <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2 group-hover:text-blue-400">Multiplayer</h2>
                    <p class="text-slate-400 mb-6 group-hover:text-slate-300">Utmana en vän i realtid. Vem hittar snabbast?</p>
                    <span class="inline-flex items-center text-blue-400 font-semibold">
                        Gå med eller skapa
                        <span class="ml-2 group-hover:translate-x-1 transition-transform">→</span>
                    </span>
                </a>
            </div>

            <!-- Features Footer -->
            <div class="w-full flex flex-wrap justify-center gap-4 text-sm text-slate-400">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Olika speltyper (Städer, Vin, Öar)
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Tidsbegränsning
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Interaktiv Karta
                </span>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-6 text-center text-sm text-slate-300 dark:text-slate-400">
        <div class="flex items-center justify-center gap-2">
            <div>Skapad av <a href="https://github.com/viirre" target="_blank" rel="noopener noreferrer" class="text-blue-600 dark:text-blue-400 hover:underline">Victor Eliasson</a></div>
            <div>·</div>
            <div><a href="https://adaptivemedia.se" target="_blank" rel="noopener noreferrer" class="text-blue-600 dark:text-blue-400 hover:underline">Adaptive Media</a></div>
            <div><a href="/pacman.html"><svg fill="#FFFF00" width="16px" height="16px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12,23a10.927,10.927,0,0,0,7.778-3.222,1,1,0,0,0,0-1.414L13.414,12l6.364-6.364a1,1,0,0,0,0-1.414A11,11,0,1,0,12,23ZM12,3a8.933,8.933,0,0,1,5.618,1.967l-6.325,6.326a1,1,0,0,0,0,1.414l6.325,6.326A9,9,0,1,1,12,3Zm11,9a2,2,0,1,1-2-2A2,2,0,0,1,23,12ZM8,7a2,2,0,1,1,2,2A2,2,0,0,1,8,7Z"/></svg></a></div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
