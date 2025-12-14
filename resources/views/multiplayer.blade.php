<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <link rel="icon" type="image/x-icon" href="/favicon.ico" />
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png" />
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Multiplayer - GeoPinner</title>

        <meta name="theme-color" content="#1e3a8a" />
        <meta name="description" content="Spela GeoPinner tillsammans med en vän!" />

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .multiplayer-container {
                background: #ffffff;
                border-radius: 20px;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
                max-width: 900px;
                width: 100%;
                overflow: hidden;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .multiplayer-header {
                background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
                color: white;
                padding: 50px 40px;
                text-align: center;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                position: relative;
                overflow: hidden;
            }

            .multiplayer-header::before {
                content: '';
                position: absolute;
                top: -50%;
                right: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
                animation: pulse 8s ease-in-out infinite;
            }

            @keyframes pulse {
                0%, 100% { transform: scale(1) rotate(0deg); opacity: 0.3; }
                50% { transform: scale(1.2) rotate(180deg); opacity: 0.6; }
            }

            .multiplayer-header-content {
                position: relative;
                z-index: 1;
            }

            .multiplayer-title {
                font-size: 3em;
                font-weight: 800;
                margin-bottom: 12px;
                letter-spacing: -0.03em;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }

            .multiplayer-subtitle {
                font-size: 1.2em;
                opacity: 0.95;
                font-weight: 400;
            }

            .back-link {
                position: absolute;
                top: 20px;
                left: 20px;
                color: white;
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 8px;
                font-weight: 600;
                transition: all 0.2s ease;
                padding: 8px 16px;
                border-radius: 8px;
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(10px);
                z-index: 2;
            }

            .back-link:hover {
                background: rgba(255, 255, 255, 0.25);
                transform: translateX(-4px);
            }

            .lobby-content {
                padding: 60px 40px;
            }

            .lobby-cards {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
                gap: 32px;
                margin-bottom: 40px;
            }

            .lobby-card {
                background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                border: 2px solid #e2e8f0;
                border-radius: 16px;
                padding: 40px 32px;
                text-align: center;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .lobby-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%);
                transform: scaleX(0);
                transition: transform 0.3s ease;
            }

            .lobby-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 20px 40px -12px rgba(99, 102, 241, 0.3);
                border-color: #c7d2fe;
            }

            .lobby-card:hover::before {
                transform: scaleX(1);
            }

            .card-icon {
                font-size: 4em;
                margin-bottom: 16px;
                display: block;
            }

            .card-title {
                font-size: 1.8em;
                font-weight: 700;
                color: #1e293b;
                margin-bottom: 12px;
            }

            .card-description {
                font-size: 1em;
                color: #64748b;
                margin-bottom: 28px;
                line-height: 1.6;
            }

            .form-group {
                margin-bottom: 20px;
                text-align: left;
            }

            .form-label {
                display: block;
                font-size: 0.9em;
                font-weight: 600;
                color: #475569;
                margin-bottom: 8px;
                letter-spacing: 0.01em;
            }

            .form-input {
                width: 100%;
                padding: 14px 18px;
                font-size: 1.05em;
                border: 2px solid #e2e8f0;
                border-radius: 10px;
                background: white;
                color: #1e293b;
                font-weight: 500;
                transition: all 0.2s ease;
                font-family: inherit;
            }

            .form-input:focus {
                outline: none;
                border-color: #6366f1;
                box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            }

            .form-input::placeholder {
                color: #94a3b8;
            }

            .form-input.code-input {
                text-align: center;
                text-transform: uppercase;
                font-size: 1.4em;
                letter-spacing: 0.15em;
                font-weight: 700;
                font-family: 'Courier New', monospace;
            }

            .primary-btn {
                width: 100%;
                padding: 16px 32px;
                font-size: 1.1em;
                font-weight: 700;
                color: white;
                background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
                border: none;
                border-radius: 10px;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
            }

            .primary-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
            }

            .primary-btn:active {
                transform: translateY(0);
            }

            .divider {
                display: flex;
                align-items: center;
                text-align: center;
                color: #94a3b8;
                font-size: 0.9em;
                font-weight: 600;
                margin: 24px 0;
            }

            .divider::before,
            .divider::after {
                content: '';
                flex: 1;
                border-bottom: 2px solid #e2e8f0;
            }

            .divider span {
                padding: 0 16px;
                background: white;
            }

            .info-box {
                background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
                border: 2px solid #bfdbfe;
                border-radius: 12px;
                padding: 24px;
                text-align: left;
            }

            .info-box-title {
                font-size: 1.1em;
                font-weight: 700;
                color: #1e40af;
                margin-bottom: 12px;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .info-box-list {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .info-box-list li {
                padding: 8px 0;
                padding-left: 28px;
                position: relative;
                color: #1e40af;
                font-size: 0.95em;
                line-height: 1.5;
            }

            .info-box-list li::before {
                content: '✓';
                position: absolute;
                left: 0;
                font-weight: 700;
                color: #6366f1;
            }

            /* Waiting Room Styles */
            .waiting-room {
                padding: 60px 40px;
            }

            .waiting-room-header {
                text-align: center;
                margin-bottom: 48px;
            }

            .game-code-display {
                background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                border: 2px solid #e2e8f0;
                border-radius: 16px;
                padding: 32px;
                display: inline-block;
                min-width: 320px;
            }

            .game-code-label {
                font-size: 0.9em;
                font-weight: 600;
                color: #64748b;
                margin-bottom: 12px;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            .game-code {
                font-size: 3.5em;
                font-weight: 800;
                color: #6366f1;
                letter-spacing: 0.15em;
                font-family: 'Courier New', monospace;
                margin: 12px 0;
                text-shadow: 0 2px 4px rgba(99, 102, 241, 0.2);
            }

            .game-code-hint {
                font-size: 0.95em;
                color: #64748b;
                margin-top: 12px;
            }

            .players-section {
                margin-bottom: 40px;
            }

            .players-title {
                font-size: 1.3em;
                font-weight: 700;
                color: #1e293b;
                margin-bottom: 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .player-count {
                font-size: 0.9em;
                color: #6366f1;
                background: #ede9fe;
                padding: 4px 16px;
                border-radius: 20px;
            }

            .players-list {
                display: grid;
                gap: 12px;
            }

            .player-item {
                background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
                border: 2px solid #e2e8f0;
                border-radius: 12px;
                padding: 16px 20px;
                display: flex;
                align-items: center;
                gap: 16px;
                transition: all 0.2s ease;
                animation: slideInPlayer 0.3s ease-out;
            }

            @keyframes slideInPlayer {
                from {
                    opacity: 0;
                    transform: translateX(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            .player-item:hover {
                border-color: #cbd5e1;
                transform: translateX(4px);
            }

            .player-color {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                border: 3px solid white;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            }

            .player-info {
                flex: 1;
            }

            .player-name {
                font-size: 1.1em;
                font-weight: 600;
                color: #1e293b;
            }

            .player-badge {
                display: inline-block;
                font-size: 0.7em;
                font-weight: 600;
                color: #6366f1;
                background: #ede9fe;
                padding: 2px 10px;
                border-radius: 12px;
                margin-left: 8px;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            .waiting-room-actions {
                text-align: center;
            }

            .start-game-btn {
                background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                color: white;
                padding: 18px 60px;
                font-size: 1.3em;
                font-weight: 700;
                border: none;
                border-radius: 12px;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
            }

            .start-game-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 24px rgba(16, 185, 129, 0.4);
            }

            .start-game-btn:active {
                transform: translateY(0);
            }

            .waiting-message {
                font-size: 1.1em;
                color: #64748b;
                padding: 20px;
                font-weight: 500;
            }

            /* Multiplayer Game Screen Styles */
            .mp-game-screen {
                padding: 20px 40px 40px;
            }

            .mp-game-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
                gap: 20px;
            }

            .mp-round-info {
                font-size: 0.9em;
                font-weight: 600;
                color: #6366f1;
                background: #ede9fe;
                padding: 8px 16px;
                border-radius: 20px;
            }

            .mp-question {
                flex: 1;
                font-size: 1.8em;
                font-weight: 700;
                color: #1e293b;
                text-align: center;
            }

            .mp-timer {
                font-size: 1.2em;
                font-weight: 700;
                color: white;
                background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
                padding: 8px 20px;
                border-radius: 20px;
                min-width: 80px;
                text-align: center;
            }

            .mp-players-status {
                display: flex;
                gap: 12px;
                margin-bottom: 20px;
                padding: 16px;
                background: #f8fafc;
                border-radius: 12px;
                border: 1px solid #e2e8f0;
            }

            .mp-player-status {
                flex: 1;
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 12px 16px;
                background: white;
                border-radius: 10px;
                border: 2px solid #e2e8f0;
                transition: all 0.3s ease;
            }

            .mp-player-status.guessed {
                border-color: #10b981;
                background: #f0fdf4;
            }

            .mp-player-color-dot {
                width: 16px;
                height: 16px;
                border-radius: 50%;
                border: 2px solid white;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
            }

            .mp-player-name {
                flex: 1;
                font-weight: 600;
                color: #1e293b;
            }

            .mp-player-status-icon {
                font-size: 1.2em;
            }

            .mp-map-container {
                width: 100%;
                height: 500px;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 16px rgba(0,0,0,0.1);
                border: 1px solid #e2e8f0;
                margin-bottom: 20px;
            }

            #mpMap {
                width: 100%;
                height: 100%;
                cursor: crosshair;
            }

            .mp-feedback {
                padding: 24px;
                border-radius: 12px;
                background: #f8fafc;
                border: 2px solid #e2e8f0;
            }

            @media (max-width: 768px) {
                .multiplayer-header {
                    padding: 40px 24px;
                }

                .multiplayer-title {
                    font-size: 2em;
                }

                .multiplayer-subtitle {
                    font-size: 1em;
                }

                .lobby-content {
                    padding: 40px 24px;
                }

                .lobby-cards {
                    grid-template-columns: 1fr;
                    gap: 24px;
                }

                .lobby-card {
                    padding: 32px 24px;
                }

                .back-link {
                    top: 12px;
                    left: 12px;
                    padding: 6px 12px;
                    font-size: 0.9em;
                }
            }
        </style>
    </head>
    <body>
        <div class="multiplayer-container">
            <div class="multiplayer-header">
                <a href="{{ route('home') }}" class="back-link">
                    <span>←</span>
                    <span>Tillbaka</span>
                </a>
                <div class="multiplayer-header-content">
                    <h1 class="multiplayer-title">Multiplayer</h1>
                    <p class="multiplayer-subtitle">Spela GeoPinner tillsammans med en vän!</p>
                </div>
            </div>

            <div class="lobby-content">
                <div class="lobby-cards">
                    <!-- Create Game Card -->
                    <div class="lobby-card">
                        <span class="card-icon">🎮</span>
                        <h2 class="card-title">Skapa nytt spel</h2>
                        <p class="card-description">Starta ett nytt spel och få en delbar spelkod att skicka till din vän</p>

                        <form id="createGameForm">
                            <div class="form-group">
                                <label for="hostName" class="form-label">Ditt namn</label>
                                <input
                                    type="text"
                                    id="hostName"
                                    name="name"
                                    class="form-input"
                                    placeholder="Ange ditt namn"
                                    maxlength="20"
                                    required
                                />
                            </div>

                            <div class="form-group">
                                <label for="difficulty" class="form-label">Svårighetsgrad</label>
                                <select id="difficulty" name="difficulty" class="form-input">
                                    @foreach (\App\Enums\Difficulty::cases() as $difficulty)
                                        <option
                                            value="{{ $difficulty->value }}"
                                            @selected($difficulty === \App\Enums\Difficulty::Medium)
                                        >
                                            {{ $difficulty->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="rounds" class="form-label">Antal rundor</label>
                                <select id="rounds" name="rounds" class="form-input">
                                    @foreach (\App\Enums\NumRound::cases() as $numRound)
                                        <option
                                            value="{{ $numRound->value }}"
                                            @selected($numRound === \App\Enums\NumRound::Ten)
                                        >
                                            {{ $numRound->value }} rundor
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" style="color: #1f2937; font-weight: 600;">Speltyper</label>
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: #374151;">
                                        <input
                                            type="checkbox"
                                            name="gameTypes"
                                            value="{{ \App\Enums\PlaceType::Mixed->value }}"
                                            checked
                                            style="width: 18px; height: 18px; cursor: pointer;"
                                        >
                                        <span>{{ \App\Enums\PlaceType::Mixed->label() }}</span>
                                    </label>
                                    @foreach (\App\Enums\PlaceType::regularTypes() as $placeType)
                                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: #374151;">
                                            <input
                                                type="checkbox"
                                                name="gameTypes"
                                                value="{{ $placeType->value }}"
                                                style="width: 18px; height: 18px; cursor: pointer;"
                                            >
                                            <span>{{ $placeType->label() }}</span>
                                        </label>
                                    @endforeach
                                    @foreach (\App\Enums\PlaceType::wineTypes() as $placeType)
                                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: #374151;">
                                            <input
                                                type="checkbox"
                                                name="gameTypes"
                                                value="{{ $placeType->value }}"
                                                style="width: 18px; height: 18px; cursor: pointer;"
                                            >
                                            <span>{{ $placeType->label() }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="timerDuration" class="form-label" style="color: #1f2937; font-weight: 600;">Tidsgräns per runda</label>
                                <select id="timerDuration" name="timerDuration" class="form-input">
                                    @foreach (\App\Enums\TimeDuration::cases() as $timeDuration)
                                        <option
                                            value="{{ $timeDuration->value }}"
                                            @selected($timeDuration === \App\Enums\TimeDuration::TenSeconds)
                                        >
                                            {{ $timeDuration->value }} sekunder
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;color:#374151">
                                    <input type="checkbox" id="showLabels" name="showLabels" style="width: 18px; height: 18px; cursor: pointer;">
                                    <span>Visa platsetiketter</span>
                                </label>
                            </div>

                            <button type="submit" class="primary-btn">
                                Skapa spel
                            </button>
                        </form>
                    </div>

                    <!-- Join Game Card -->
                    <div class="lobby-card">
                        <span class="card-icon">🔗</span>
                        <h2 class="card-title">Gå med i spel</h2>
                        <p class="card-description">Har du fått en spelkod? Ange den här för att gå med i spelet</p>

                        <form id="joinGameForm">
                            <div class="form-group">
                                <label for="playerName" class="form-label">Ditt namn</label>
                                <input
                                    type="text"
                                    id="playerName"
                                    name="name"
                                    class="form-input"
                                    placeholder="Ange ditt namn"
                                    maxlength="20"
                                    required
                                />
                            </div>

                            <div class="form-group">
                                <label for="gameCode" class="form-label">Spelkod</label>
                                <input
                                    type="text"
                                    id="gameCode"
                                    name="code"
                                    class="form-input code-input"
                                    placeholder="A1B2C3"
                                    maxlength="6"
                                    required
                                />
                            </div>

                            <button type="submit" class="primary-btn">
                                Gå med
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="info-box">
                    <div class="info-box-title">
                        <span>ℹ️</span>
                        <span>Hur fungerar multiplayer?</span>
                    </div>
                    <ul class="info-box-list">
                        <li>Spelvärden skapar ett spel och får en 6-teckens spelkod</li>
                        <li>Dela koden med din vän så de kan gå med</li>
                        <li>Båda spelarna gissar var varje plats ligger</li>
                        <li>Efter varje runda ser ni varandras gissningar</li>
                        <li>Tidsbegränsning är alltid aktiverad i multiplayer</li>
                        <li>Spelaren med flest poäng vinner!</li>
                    </ul>
                </div>
            </div>

            <!-- Waiting Room (hidden by default) -->
            <div class="waiting-room hidden" id="waitingRoom">
                <div class="waiting-room-header">
                    <div class="game-code-display">
                        <div class="game-code-label">Spelkod</div>
                        <div class="game-code" id="waitingRoomCode">ABC123</div>
                        <div class="game-code-hint">Dela denna kod med din vän!</div>
                    </div>
                </div>

                <div class="players-section">
                    <h3 class="players-title">
                        <span>Spelare</span>
                        <span class="player-count" id="playerCount">0/6</span>
                    </h3>
                    <div class="players-list" id="playersList">
                        <!-- Players will be added dynamically -->
                    </div>
                </div>

                <div class="waiting-room-actions">
                    <button class="start-game-btn hidden" id="startGameBtn">
                        Starta spelet!
                    </button>
                    <div class="waiting-message hidden" id="waitingMessage">
                        Väntar på att värden ska starta spelet...
                    </div>
                </div>
            </div>

            <!-- Multiplayer Game Screen (hidden by default) -->
            <div class="mp-game-screen hidden" id="mpGameScreen">
                <div class="mp-game-header">
                    <div class="mp-round-info">
                        <span class="mp-round-number">Runda <span id="mpCurrentRound">1</span>/<span id="mpTotalRounds">10</span></span>
                    </div>
                    <div class="mp-question" id="mpQuestion">
                        Var ligger Stockholm?
                    </div>
                    <div class="mp-timer" id="mpTimer">
                        30s
                    </div>
                </div>

                <div class="mp-players-status" id="mpPlayersStatus">
                    <!-- Player status indicators will be added here -->
                </div>

                <div class="mp-map-container">
                    <div id="mpMap"></div>
                </div>

                <div class="mp-feedback hidden" id="mpFeedback">
                    <!-- Round results will be shown here -->
                </div>
            </div>

            <!-- Winner Screen (hidden by default) -->
            <div id="winnerScreen" class="hidden" style="padding: 40px 20px; max-width: 600px; margin: 0 auto;">
                <div id="winnerContent">
                    <!-- Winner content will be populated by JavaScript -->
                </div>
            </div>
        </div>

        <footer class="footer">
            <p>
                Skapad av <a href="https://github.com/viirre" target="_blank" rel="noopener noreferrer">Victor Eliasson</a>
                ·
                <a href="https://adaptivemedia.se" target="_blank" rel="noopener noreferrer">Adaptive Media</a>
            </p>
        </footer>

        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <script>
            // Get CSRF token from meta tag (we'll add it to the head)
            function getCsrfToken() {
                return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            }

            // Show error message
            function showError(message) {
                alert('❌ Fel: ' + message);
            }

            // Show waiting room
            async function showWaitingRoom(gameCode, isHost) {
                // Hide lobby, show waiting room
                document.querySelector('.lobby-content').classList.add('hidden');
                document.getElementById('waitingRoom').classList.remove('hidden');

                // Set game code
                document.getElementById('waitingRoomCode').textContent = gameCode;

                // Show appropriate action for host/non-host
                if (isHost) {
                    document.getElementById('startGameBtn').classList.remove('hidden');
                    document.getElementById('waitingMessage').classList.add('hidden');
                } else {
                    document.getElementById('startGameBtn').classList.add('hidden');
                    document.getElementById('waitingMessage').classList.remove('hidden');
                }

                // Load current players
                await loadPlayers(gameCode);

                // Subscribe to game channel for real-time updates
                subscribeToGameChannel(gameCode);
            }

            // Load players list
            async function loadPlayers(gameCode) {
                try {
                    const response = await fetch(`/api/games/${gameCode}/players`);
                    const data = await response.json();

                    if (response.ok) {
                        renderPlayers(data.players);
                    }
                } catch (error) {
                    console.error('Error loading players:', error);
                }
            }

            // Render players list
            function renderPlayers(players) {
                const playersList = document.getElementById('playersList');
                const playerCount = document.getElementById('playerCount');

                playersList.innerHTML = '';
                playerCount.textContent = `${players.length}/6`;

                players.forEach(player => {
                    const playerItem = document.createElement('div');
                    playerItem.className = 'player-item';
                    playerItem.innerHTML = `
                        <div class="player-color" style="background-color: ${player.color}"></div>
                        <div class="player-info">
                            <div class="player-name">
                                ${player.name}
                                ${player.is_host ? '<span class="player-badge">Värd</span>' : ''}
                            </div>
                        </div>
                    `;
                    playersList.appendChild(playerItem);
                });
            }

            // Global map instance for multiplayer game
            let mpMap = null;
            let currentRoundData = null;
            let allPlayers = [];
            let timerInterval = null;
            let timeRemaining = 0;

            // Subscribe to game channel via Echo
            function subscribeToGameChannel(gameCode) {
                window.Echo.channel(`game.${gameCode}`)
                    .listen('.PlayerJoined', (data) => {
                        console.log('Player joined:', data);
                        loadPlayers(gameCode);
                    })
                    .listen('.GameStarted', (data) => {
                        console.log('Game started:', data);
                    })
                    .listen('.RoundStarted', (data) => {
                        console.log('Round started:', data);
                        startRound(data.round, data.game);
                    })
                    .listen('.GuessSubmitted', (data) => {
                        console.log('Guess submitted:', data);
                        handleGuessSubmitted(data);
                    })
                    .listen('.RoundCompleted', (data) => {
                        console.log('Round completed:', data);
                        showRoundResults(data);
                    })
                    .listen('.GameCompleted', (data) => {
                        console.log('Game completed:', data);
                        showWinnerScreen(data);
                    });

                console.log(`Subscribed to game.${gameCode} channel`);
            }

            // Start a new round
            async function startRound(roundData, gameData) {
                // Reset round state
                hasGuessedThisRound = false;
                userMarker = null;

                // Store round data
                currentRoundData = roundData;

                // Load current players
                const gameCode = sessionStorage.getItem('gameCode');
                const response = await fetch(`/api/games/${gameCode}/players`);
                const data = await response.json();
                if (response.ok) {
                    allPlayers = data.players;
                }

                // Hide waiting room, show game screen
                document.getElementById('waitingRoom').classList.add('hidden');
                document.getElementById('mpGameScreen').classList.remove('hidden');

                // Update round info
                document.getElementById('mpCurrentRound').textContent = roundData.number;
                document.getElementById('mpTotalRounds').textContent = gameData.total_rounds;
                document.getElementById('mpQuestion').textContent = `Var ligger ${roundData.place.name}?`;

                // Clear feedback
                document.getElementById('mpFeedback').innerHTML = '';
                document.getElementById('mpFeedback').classList.add('hidden');

                // Initialize map if needed
                if (!mpMap) {
                    mpMap = L.map('mpMap', {
                        center: [20, 0],
                        zoom: 2,
                        minZoom: 2,
                        maxZoom: 10,
                        worldCopyJump: true,
                    });

                    // Determine tile layer based on showLabels setting
                    const showLabels = gameData.show_labels || false;
                    const tileUrl = showLabels
                        ? 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png'
                        : 'https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}{r}.png';

                    L.tileLayer(tileUrl, {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                        subdomains: 'abcd',
                        maxZoom: 19
                    }).addTo(mpMap);

                    // Handle map click
                    mpMap.on('click', function(e) {
                        handleMpMapClick(e);
                    });
                } else {
                    // Clear all markers and layers from previous round
                    mpMap.eachLayer(function(layer) {
                        if (layer instanceof L.Marker || layer instanceof L.CircleMarker || layer instanceof L.Polyline) {
                            mpMap.removeLayer(layer);
                        }
                    });
                }

                // Reset map view
                mpMap.setView([20, 0], 2);

                // Render player status
                renderPlayerStatus(allPlayers);

                // Start countdown timer
                startTimer(gameData);
            }

            // Start countdown timer
            function startTimer(gameData) {
                // Clear any existing timer
                if (timerInterval) {
                    clearInterval(timerInterval);
                }

                // Get timer duration from game settings (default 30s)
                const gameCode = sessionStorage.getItem('gameCode');

                // We need to get the game settings to know the timer duration
                // For now, we'll extract it from gameData if available, otherwise default to 30
                const timerDuration = gameData?.timer_duration || 30;
                timeRemaining = timerDuration;

                // Update display immediately
                updateTimerDisplay();

                // Start countdown
                timerInterval = setInterval(() => {
                    timeRemaining--;
                    updateTimerDisplay();

                    // Time's up
                    if (timeRemaining <= 0) {
                        clearInterval(timerInterval);
                        timerInterval = null;

                        // If player hasn't guessed yet, disable further guessing
                        if (!hasGuessedThisRound) {
                            // Could auto-submit a random guess or just disable the map
                            // For now, just show a message
                            const feedbackDiv = document.getElementById('mpFeedback');
                            feedbackDiv.classList.remove('hidden');
                            feedbackDiv.innerHTML = `
                                <div style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 12px; border-radius: 8px;">
                                    ⏱️ Tiden är slut! Väntar på andra spelare...
                                </div>
                            `;
                        }
                    }
                }, 1000);
            }

            // Update timer display
            function updateTimerDisplay() {
                const timerEl = document.getElementById('mpTimer');
                if (timerEl) {
                    // Show time remaining with color coding
                    if (timeRemaining <= 5) {
                        timerEl.style.color = '#ef4444'; // Red for last 5 seconds
                    } else if (timeRemaining <= 10) {
                        timerEl.style.color = '#f59e0b'; // Orange for last 10 seconds
                    } else {
                        timerEl.style.color = '#8b5cf6'; // Purple (default)
                    }
                    timerEl.textContent = `${timeRemaining}s`;
                }
            }

            // Render player status indicators
            function renderPlayerStatus(players) {
                const container = document.getElementById('mpPlayersStatus');
                container.innerHTML = '';

                players.forEach(player => {
                    const statusDiv = document.createElement('div');
                    statusDiv.className = 'mp-player-status';
                    statusDiv.id = `player-status-${player.id}`;
                    statusDiv.innerHTML = `
                        <div class="mp-player-color-dot" style="background-color: ${player.color}"></div>
                        <div class="mp-player-name">${player.name}</div>
                        <div class="mp-player-status-icon">⏳</div>
                    `;
                    container.appendChild(statusDiv);
                });
            }

            // Handle map click in multiplayer game
            let hasGuessedThisRound = false;
            let userMarker = null;

            async function handleMpMapClick(e) {
                if (hasGuessedThisRound) {
                    return; // Already guessed
                }

                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                // Add user marker
                if (userMarker) {
                    mpMap.removeLayer(userMarker);
                }

                const userIcon = L.icon({
                    iconUrl: '/pin_user.png',
                    iconSize: [16, 40],
                    iconAnchor: [10, 40],
                });

                userMarker = L.marker([lat, lng], { icon: userIcon }).addTo(mpMap);

                // Submit guess
                try {
                    const playerId = sessionStorage.getItem('playerId');
                    const roundId = currentRoundData.id;

                    const response = await fetch('/api/games/guess', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken(),
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            round_id: roundId,
                            player_id: playerId,
                            lat: lat,
                            lng: lng,
                        }),
                    });

                    const data = await response.json();

                    if (response.ok) {
                        hasGuessedThisRound = true;

                        // Stop the timer
                        if (timerInterval) {
                            clearInterval(timerInterval);
                            timerInterval = null;
                        }

                        // Update own status icon to checkmark
                        const statusIcon = document.querySelector(`#player-status-${playerId} .mp-player-status-icon`);
                        if (statusIcon) {
                            statusIcon.textContent = '✓';
                            statusIcon.style.color = '#10b981';
                        }

                        // Show feedback
                        const feedbackDiv = document.getElementById('mpFeedback');
                        feedbackDiv.classList.remove('hidden');
                        feedbackDiv.innerHTML = `
                            <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 12px; border-radius: 8px;">
                                <strong>Gissning skickad!</strong> Du fick ${data.guess.score} poäng
                                (avstånd: ${Math.round(data.guess.distance)} km)
                            </div>
                        `;

                        if (data.round_complete) {
                            feedbackDiv.innerHTML += `
                                <div style="margin-top: 8px; color: #8b5cf6;">
                                    Väntar på att alla spelare ska gissa...
                                </div>
                            `;
                        }
                    } else {
                        const errorMessage = data.errors?.round_id?.[0] || data.message || 'Kunde inte skicka gissning';
                        alert(errorMessage);
                    }
                } catch (error) {
                    console.error('Error submitting guess:', error);
                    alert('Något gick fel. Försök igen.');
                }
            }

            // Handle when another player submits a guess
            function handleGuessSubmitted(data) {
                // Update the status icon for the player who guessed
                const statusIcon = document.querySelector(`#player-status-${data.player.id} .mp-player-status-icon`);
                if (statusIcon) {
                    statusIcon.textContent = '✓';
                    statusIcon.style.color = '#10b981';
                }

                // Update feedback if waiting for others
                const feedbackDiv = document.getElementById('mpFeedback');
                if (hasGuessedThisRound) {
                    feedbackDiv.innerHTML = `
                        <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 12px; border-radius: 8px;">
                            <strong>Väntar på andra spelare...</strong>
                            ${data.guesses_count} av ${data.total_players} har gissat
                        </div>
                    `;
                }
            }

            // Show round results with all pins
            function showRoundResults(data) {
                // Clear existing markers except user's guess marker
                // The user marker is kept to show their guess

                const placeData = data.round.place;

                // Add the correct location marker
                const placeIcon = L.icon({
                    iconUrl: '/pin_place.png',
                    iconSize: [16, 40],
                    iconAnchor: [10, 40],
                });

                L.marker([placeData.lat, placeData.lng], { icon: placeIcon }).addTo(mpMap);

                // Add all players' guess markers with colored circles
                data.guesses.forEach(guess => {
                    const playerId = guess.player.id;
                    const currentPlayerId = parseInt(sessionStorage.getItem('playerId'));

                    // Skip current player's marker (already shown)
                    if (playerId === currentPlayerId) {
                        return;
                    }

                    // Add other players' markers with their colors
                    const circleMarker = L.circleMarker([guess.lat, guess.lng], {
                        radius: 10,
                        fillColor: guess.player.color,
                        color: '#fff',
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.8
                    }).addTo(mpMap);

                    // Add popup with player info
                    circleMarker.bindPopup(`
                        <strong>${guess.player.name}</strong><br>
                        Poäng: ${guess.score}<br>
                        Avstånd: ${Math.round(guess.distance)} km
                    `);
                });

                // Draw lines from each guess to the correct location
                data.guesses.forEach(guess => {
                    L.polyline([
                        [guess.lat, guess.lng],
                        [placeData.lat, placeData.lng]
                    ], {
                        color: guess.player.color,
                        weight: 2,
                        opacity: 0.5,
                        dashArray: '5, 10'
                    }).addTo(mpMap);
                });

                // Update feedback to show round results
                const feedbackDiv = document.getElementById('mpFeedback');
                let resultHTML = `
                    <div style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6; padding: 16px; border-radius: 8px;">
                        <h3 style="margin: 0 0 12px 0; font-size: 18px;">Runda ${data.round.number} avslutad!</h3>
                        <p style="margin: 0 0 12px 0;">Platsen var: <strong>${placeData.name}</strong></p>
                        <div style="background: white; border-radius: 6px; padding: 12px; margin-top: 12px;">
                            <div style="font-weight: 600; margin-bottom: 8px; color: #1f2937;">Poängställning:</div>
                `;

                // Sort players by total score descending
                const sortedPlayers = [...data.players].sort((a, b) => b.total_score - a.total_score);

                sortedPlayers.forEach((player, index) => {
                    const guessForPlayer = data.guesses.find(g => g.player.id === player.id);
                    const roundScore = guessForPlayer ? guessForPlayer.score : 0;

                    resultHTML += `
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #e5e7eb;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="color: #6b7280; font-size: 14px;">${index + 1}.</span>
                                <div style="width: 12px; height: 12px; border-radius: 50%; background-color: ${player.color};"></div>
                                <span style="color: #1f2937; font-weight: 500;">${player.name}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <span style="color: #6b7280; font-size: 14px;">+${roundScore}</span>
                                <span style="color: #1f2937; font-weight: 600;">${player.total_score} poäng</span>
                            </div>
                        </div>
                    `;
                });

                resultHTML += `
                        </div>
                        <button id="nextRoundBtn" style="
                            margin-top: 16px;
                            width: 100%;
                            padding: 12px;
                            background: #8b5cf6;
                            color: white;
                            border: none;
                            border-radius: 6px;
                            font-weight: 600;
                            cursor: pointer;
                        " onmouseover="this.style.background='#7c3aed'" onmouseout="this.style.background='#8b5cf6'">
                            Nästa runda
                        </button>
                    </div>
                `;

                feedbackDiv.innerHTML = resultHTML;

                // Add event listener for next round button
                document.getElementById('nextRoundBtn').addEventListener('click', async function() {
                    const btn = this;
                    btn.disabled = true;
                    btn.textContent = 'Laddar...';

                    try {
                        const gameId = sessionStorage.getItem('gameId');
                        const playerId = sessionStorage.getItem('playerId');

                        const response = await fetch('/api/games/next-round', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': getCsrfToken(),
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                game_id: gameId,
                                player_id: playerId,
                            }),
                        });

                        const data = await response.json();

                        if (response.ok) {
                            if (data.game_complete) {
                                // Game is complete - wait for GameCompleted event
                                console.log('Game completed, waiting for event...');
                            } else {
                                // Next round will start via RoundStarted event
                                console.log('Next round starting...');
                            }
                        } else {
                            const errorMessage = data.message || 'Kunde inte starta nästa runda';
                            alert(errorMessage);
                            btn.disabled = false;
                            btn.textContent = 'Nästa runda';
                        }
                    } catch (error) {
                        console.error('Error starting next round:', error);
                        alert('Något gick fel. Försök igen.');
                        btn.disabled = false;
                        btn.textContent = 'Nästa runda';
                    }
                });
            }

            // Show winner screen
            function showWinnerScreen(data) {
                // Hide game screen, show winner screen
                document.getElementById('mpGameScreen').classList.add('hidden');
                document.getElementById('winnerScreen').classList.remove('hidden');

                const winner = data.winner;
                const players = data.players;

                let winnerHTML = `
                    <div style="text-align: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                        <h1 style="font-size: 48px; margin: 0 0 16px 0;">🏆</h1>
                        <h2 style="font-size: 32px; margin: 0 0 8px 0; font-weight: 700;">Spelet är slut!</h2>
                        <p style="font-size: 18px; margin: 0 0 32px 0; opacity: 0.9;">
                            ${data.total_rounds} ${data.total_rounds === 1 ? 'runda' : 'rundor'} spelade
                        </p>

                        ${winner ? `
                            <div style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 12px; padding: 24px; margin-bottom: 32px;">
                                <div style="font-size: 20px; margin-bottom: 12px; opacity: 0.9;">Vinnare</div>
                                <div style="display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 8px;">
                                    <div style="width: 24px; height: 24px; border-radius: 50%; background-color: ${winner.color}; border: 3px solid white;"></div>
                                    <div style="font-size: 36px; font-weight: 700;">${winner.name}</div>
                                </div>
                                <div style="font-size: 28px; font-weight: 600;">${winner.total_score} poäng</div>
                            </div>
                        ` : ''}

                        <div style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 12px; padding: 24px;">
                            <div style="font-size: 20px; margin-bottom: 16px; font-weight: 600;">Slutställning</div>
                `;

                players.forEach((player) => {
                    const medal = player.position === 1 ? '🥇' : player.position === 2 ? '🥈' : player.position === 3 ? '🥉' : '';
                    winnerHTML += `
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; margin-bottom: 8px; background: rgba(255,255,255,0.1); border-radius: 8px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <span style="font-size: 24px; width: 32px;">${medal || player.position + '.'}</span>
                                <div style="width: 16px; height: 16px; border-radius: 50%; background-color: ${player.color}; border: 2px solid white;"></div>
                                <span style="font-size: 18px; font-weight: 500;">${player.name}</span>
                            </div>
                            <span style="font-size: 20px; font-weight: 600;">${player.total_score}</span>
                        </div>
                    `;
                });

                winnerHTML += `
                        </div>

                        <div style="margin-top: 32px; display: flex; gap: 12px; justify-content: center;">
                            <a href="/multiplayer" style="
                                display: inline-block;
                                padding: 14px 32px;
                                background: white;
                                color: #667eea;
                                text-decoration: none;
                                border-radius: 8px;
                                font-weight: 600;
                                font-size: 16px;
                                transition: transform 0.2s;
                            " onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                Spela igen
                            </a>
                            <a href="/" style="
                                display: inline-block;
                                padding: 14px 32px;
                                background: rgba(255,255,255,0.2);
                                color: white;
                                text-decoration: none;
                                border-radius: 8px;
                                font-weight: 600;
                                font-size: 16px;
                                transition: transform 0.2s;
                            " onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                Huvudmeny
                            </a>
                        </div>
                    </div>
                `;

                document.getElementById('winnerContent').innerHTML = winnerHTML;

                // Clear session storage
                sessionStorage.removeItem('gameId');
                sessionStorage.removeItem('gameCode');
                sessionStorage.removeItem('playerId');
                sessionStorage.removeItem('playerName');
                sessionStorage.removeItem('playerColor');
                sessionStorage.removeItem('isHost');
            }

            // Create game form handler
            document.getElementById('createGameForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Skapar spel...';
                submitBtn.disabled = true;

                try {
                    const name = document.getElementById('hostName').value;
                    const difficulty = document.getElementById('difficulty').value;
                    const rounds = parseInt(document.getElementById('rounds').value);
                    const timerDuration = parseInt(document.getElementById('timerDuration').value);
                    const showLabels = document.getElementById('showLabels').checked;

                    // Get selected game types
                    const gameTypeCheckboxes = document.querySelectorAll('input[name="gameTypes"]:checked');
                    const gameTypes = Array.from(gameTypeCheckboxes).map(cb => cb.value);

                    // Validate at least one game type is selected
                    if (gameTypes.length === 0) {
                        showError('Välj minst en speltyp');
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                        return;
                    }

                    const response = await fetch('/api/games/create', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken(),
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            name,
                            settings: {
                                difficulty,
                                rounds,
                                gameTypes,
                                timerEnabled: true,
                                timerDuration,
                                showLabels
                            }
                        }),
                    });

                    const data = await response.json();

                    if (response.ok) {
                        // Store player info
                        sessionStorage.setItem('playerId', data.player.id);
                        sessionStorage.setItem('playerName', data.player.name);
                        sessionStorage.setItem('playerColor', data.player.color);
                        sessionStorage.setItem('gameId', data.game.id);
                        sessionStorage.setItem('gameCode', data.game.code);
                        sessionStorage.setItem('isHost', 'true');

                        showWaitingRoom(data.game.code, true);
                    } else {
                        const errorMessage = data.errors?.name?.[0] || data.message || 'Kunde inte skapa spel';
                        showError(errorMessage);
                    }
                } catch (error) {
                    showError('Något gick fel. Försök igen.');
                    console.error('Error creating game:', error);
                } finally {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                }
            });

            // Join game form handler
            document.getElementById('joinGameForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Går med...';
                submitBtn.disabled = true;

                try {
                    const name = document.getElementById('playerName').value;
                    const code = document.getElementById('gameCode').value.toUpperCase();

                    const response = await fetch('/api/games/join', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken(),
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ name, code }),
                    });

                    const data = await response.json();

                    if (response.ok) {
                        // Store player info
                        sessionStorage.setItem('playerId', data.player.id);
                        sessionStorage.setItem('playerName', data.player.name);
                        sessionStorage.setItem('playerColor', data.player.color);
                        sessionStorage.setItem('gameId', data.game.id);
                        sessionStorage.setItem('gameCode', data.game.code);
                        sessionStorage.setItem('isHost', 'false');

                        showWaitingRoom(data.game.code, false);
                    } else {
                        const errorMessage = data.errors?.code?.[0] || data.errors?.name?.[0] || data.message || 'Kunde inte gå med i spel';
                        showError(errorMessage);
                    }
                } catch (error) {
                    showError('Något gick fel. Försök igen.');
                    console.error('Error joining game:', error);
                } finally {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                }
            });

            // Auto-uppercase game code input
            document.getElementById('gameCode').addEventListener('input', function(e) {
                e.target.value = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            });

            // Start Game button handler
            document.getElementById('startGameBtn').addEventListener('click', async function() {
                const submitBtn = this;
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Startar...';
                submitBtn.disabled = true;

                try {
                    const gameCode = sessionStorage.getItem('gameCode');
                    const playerId = sessionStorage.getItem('playerId');

                    const response = await fetch('/api/games/start', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken(),
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            code: gameCode,
                            player_id: parseInt(playerId)
                        }),
                    });

                    const data = await response.json();

                    if (response.ok) {
                        console.log('Game started successfully!', data);
                        // The GameStarted event will trigger the transition for all players
                    } else {
                        const errorMessage = data.errors?.code?.[0] || data.errors?.player_id?.[0] || data.message || 'Kunde inte starta spelet';
                        showError(errorMessage);
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    }
                } catch (error) {
                    showError('Något gick fel. Försök igen.');
                    console.error('Error starting game:', error);
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                }
            });
        </script>
    </body>
</html>
