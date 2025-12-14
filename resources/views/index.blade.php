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

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div class="header-title">
                    <img src="/logo.svg" alt="GeoPinner Logo" class="header-logo" />
                    <h1>GeoPinner</h1>
                </div>
                <p class="subtitle">Hitta platser runt om i världen!</p>
                <div class="flex justify-center gap-x-2 mt-6">
                    <a class="cursor-pointer block tab border hover:bg-gray-100 bg-gray-300 py-2 p-4 rounded text-black">Single Player
                    </a>
                    <a
                        href="{{ route('multiplayer') }}"
                        class="cursor-pointer block tab border hover:bg-gray-100 bg-gray-300 py-2 p-4 rounded text-black"
                    >Multi Player</a>
                </div>
            </div>

            <!-- Setup Screen -->
            <div class="setup-screen" id="setupScreen">
                <div class="option-group">
                    <label>Svårighetsgrad:</label>
                    <div class="pill-group">
                        @foreach (\App\Enums\Difficulty::cases() as $difficulty)
                            <button
                                @class([
                                    'pill-btn',
                                    'selected' => $difficulty === \App\Enums\Difficulty::Medium
                                ])
                                data-difficulty="{{ $difficulty->value }}"
                            >
                                {{ $difficulty->label() }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="option-group">
                    <label>Speltyp:</label>
                    <div class="pill-group">
                        <button
                            @class([
                                'pill-btn',
                                'selected'
                            ])
                            data-gametype="{{ \App\Enums\PlaceType::Mixed->value }}"
                        >{{ \App\Enums\PlaceType::Mixed->label() }}</button>
                        @foreach (\App\Enums\PlaceType::regularTypes() as $placeType)
                            <button
                                @class([
                                    'pill-btn',
                                ])
                                data-gametype="{{ $placeType->value }}"
                            >{{ $placeType->label() }}</button>
                        @endforeach
                        <button class="pill-btn" id="vinerToggle">Viner</button>
                    </div>
                    <div class="pill-group wine-submenu" id="wineSubmenu" style="display: none;">
                        @foreach (\App\Enums\PlaceType::wineTypes() as $placeType)
                            <button
                                class="pill-btn" data-gametype="{{ $placeType->value }}"
                            >{{ $placeType->label() }}</button>
                        @endforeach
                    </div>
                </div>

                <div class="option-group">
                    <label for="roundsSelect">Antal omgångar:</label>
                    <select id="roundsSelect" class="select-control">
                        @foreach (\App\Enums\NumRound::cases() as $numRound)
                            <option value="{{ $numRound->value }}" @selected($numRound === \App\Enums\NumRound::Ten)>
                                {{ $numRound->value }} platser
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="option-group">
                    <label for="zoomToggle">Tillåt zoom:</label>
                    <label class="toggle-switch">
                        <input type="checkbox" id="zoomToggle" checked>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="option-group">
                    <label for="timerToggle">Tidsbegränsning:</label>
                    <label class="toggle-switch">
                        <input type="checkbox" id="timerToggle" checked>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="option-group" id="timerDurationContainer">
                    <label for="timerDurationSelect">Tid per runda:</label>
                    <select id="timerDurationSelect" class="select-control">
                        @foreach (\App\Enums\TimeDuration::cases() as $timeDuration)
                            <option
                                value="{{ $numRound->value }}" @selected($timeDuration === \App\Enums\TimeDuration::TenSeconds)>
                                {{ $timeDuration->value }} sekunder
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="start-btn" id="startBtn">Starta spelet!</button>
            </div>

            <!-- Game Screen -->
            <div class="game-screen hidden" id="gameScreen">
                <div class="game-info">
                    <div class="info-item">
                        <div class="info-label">Runda</div>
                        <div class="info-value" id="currentRound">1</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Poäng</div>
                        <div class="info-value" id="currentScore">0</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Max poäng</div>
                        <div class="info-value" id="maxScore">100</div>
                    </div>
                </div>

                <div class="question-box" id="questionBox">
                    <span class="question-text">Var ligger Paris?</span>
                    <span class="timer-display hidden" id="timerDisplay">60s</span>
                </div>

                <div class="map-container">
                    <div id="map"></div>
                    <div class="map-label-toggle">
                        <label class="toggle-switch">
                            <input type="checkbox" id="toggleLabelsCheckbox">
                            <span class="toggle-slider"></span>
                            <span class="toggle-label">Platsetiketter</span>
                        </label>
                    </div>
                </div>

                <div id="feedbackContainer"></div>
            </div>

            <!-- Result Screen -->
            <div class="result-screen hidden" id="resultScreen">
                <div class="results">
                    <h2>🎉 Grattis! 🎉</h2>
                    <div class="final-score" id="finalScore">0</div>
                    <div class="score-message" id="scoreMessage">Fantastiskt resultat!</div>

                    <div class="round-results" id="roundResults"></div>

                    <button class="play-again-btn" id="playAgainBtn">Spela igen!</button>
                </div>
            </div>
        </div>

        <footer class="footer">
            <p>
                Skapad av <a href="https://github.com/viirre" target="_blank" rel="noopener noreferrer">Victor
                    Eliasson</a>
                ·
                <a href="https://adaptivemedia.se" target="_blank" rel="noopener noreferrer">Adaptive Media</a>
            </p>
        </footer>

        <div id="app"></div>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <!-- Service Worker Registration -->
        <script>
            {{-- TODO: fix --}}
            // if ('serviceWorker' in navigator) {
            //     window.addEventListener('load', () => {
            //         navigator.serviceWorker.register('/sw.js')
            //             .then((registration) => {
            //                 console.log('SW registered:', registration);
            //             })
            //             .catch((error) => {
            //                 console.log('SW registration failed:', error);
            //             });
            //     });
            // }
        </script>
    </body>
</html>
