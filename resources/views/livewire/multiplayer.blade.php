<div class="min-h-screen bg-slate-900 text-white w-full"
    x-data="{
        ...multiplayerScreen(),
        beforeUnloadHandler: null,
        setupBeforeUnload() {
            this.beforeUnloadHandler = (e) => {
                e.preventDefault();
                e.returnValue = '';
                return '';
            };
            window.addEventListener('beforeunload', this.beforeUnloadHandler);
        },
        removeBeforeUnload() {
            if (this.beforeUnloadHandler) {
                window.removeEventListener('beforeunload', this.beforeUnloadHandler);
                this.beforeUnloadHandler = null;
            }
        }
    }"
    x-init="
        // Initialize multiplayer screen
        if (typeof init === 'function') init();

        // Watch screen changes for beforeunload handler
        $watch('$wire.screen', (screen) => {
            if (screen === 'game') {
                setupBeforeUnload();
            } else {
                removeBeforeUnload();
            }
        });

        // Initialize on mount if already in game screen
        if ($wire.screen === 'game') {
            setupBeforeUnload();
        }
    "
    x-on:destroy="
        if (typeof destroy === 'function') destroy();
        removeBeforeUnload();
    "
>
        {{-- Lobby Screen --}}
        @if($screen === 'lobby')
            <section class="min-h-screen flex items-center justify-center p-4 relative">
                <x-map-background blur="true" overlay="true" />

                <div class="relative w-full max-w-5xl glass-panel rounded-3xl flex flex-col shadow-2xl overflow-hidden animate-fade-in">
                    {{-- Header --}}
                    <div class="p-6 border-b border-slate-700/50 md:flex items-center justify-between">
                        <a href="{{ route('home') }}" class="text-slate-400 hover:text-white flex items-center gap-2 text-sm font-medium transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Tillbaka
                        </a>
                        <div class="flex flex-col items-center">
                            <h2 class="text-xl font-bold text-white">Multiplayer</h2>
                            <span class="text-xs text-blue-400">Spela tillsammans med en vän!</span>
                        </div>
                        <div class="w-16"></div>
                    </div>

                    <div class="flex flex-col md:flex-row">
                        {{-- Left: Create Game --}}
                        <div class="flex-1 p-8 border-b md:border-b-0 md:border-r border-slate-700/50 flex flex-col">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-3 rounded-lg bg-blue-500/20 text-blue-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white">Skapa nytt spel</h3>
                                    <p class="text-xs text-slate-400">Starta ett spel och få en kod</p>
                                </div>
                            </div>

                            <form wire:submit.prevent="createGame" class="space-y-4 flex-1">
                                <div class="space-y-1">
                                    <label class="text-xs text-slate-400 font-bold uppercase">Ditt Namn</label>
                                    <input type="text" wire:model="hostName" placeholder="Ange ditt namn" maxlength="20" required class="w-full bg-slate-800 border border-slate-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-xs text-slate-400 font-bold uppercase">Rundor</label>
                                        <select wire:model="rounds" class="w-full bg-slate-800 border border-slate-600 rounded-lg px-3 py-2 text-white text-sm">
                                            @foreach(\App\Enums\NumRound::cases() as $num)
                                                <option value="{{ $num->value }}">{{ $num->value }} Rundor</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-xs text-slate-400 font-bold uppercase">Svårighet</label>
                                        <select wire:model="difficulty" class="w-full bg-slate-800 border border-slate-600 rounded-lg px-3 py-2 text-white text-sm">
                                            @foreach(\App\Enums\Difficulty::cases() as $diff)
                                                <option value="{{ $diff->value }}">{{ $diff->label() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-xs text-slate-400 font-bold uppercase">Tid per runda</label>
                                        <select wire:model="timerDuration" class="w-full bg-slate-800 border border-slate-600 rounded-lg px-3 py-2 text-white text-sm">
                                            @foreach(\App\Enums\TimeDuration::cases() as $duration)
                                                <option value="{{ $duration->value }}">{{ $duration->value }} sekunder</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label class="text-xs text-slate-400 font-bold uppercase">Typ av platser</label>
                                    <div class="flex flex-wrap gap-2">
                                        {{-- Mixed --}}
                                        <button
                                            type="button"
                                            wire:click="toggleGameType('{{ \App\Enums\PlaceType::Mixed->value }}')"
                                            class="px-3 py-1 rounded-md text-xs font-medium border transition-all {{ in_array(\App\Enums\PlaceType::Mixed->value, $gameTypes) ? 'bg-blue-500/20 border-blue-500/50 text-blue-400 hover:bg-blue-500 hover:text-white' : 'bg-slate-800 border-slate-700 text-slate-300 hover:border-slate-500' }}"
                                        >
                                            {{ \App\Enums\PlaceType::Mixed->label() }}
                                        </button>

                                        {{-- Regular Types --}}
                                        @foreach(\App\Enums\PlaceType::regularTypes() as $placeType)
                                            <button
                                                type="button"
                                                wire:click="toggleGameType('{{ $placeType->value }}')"
                                                class="px-3 py-1 rounded-md text-xs font-medium border transition-all {{ in_array($placeType->value, $gameTypes) ? 'bg-blue-500/20 border-blue-500/50 text-blue-400 hover:bg-blue-500 hover:text-white' : 'bg-slate-800 border-slate-700 text-slate-300 hover:border-slate-500' }}"
                                            >
                                                {{ $placeType->label() }}
                                            </button>
                                        @endforeach

                                        {{-- Wine Button (toggles submenu) --}}
                                        <button
                                            type="button"
                                            x-on:click="$dispatch('toggle-wine-menu')"
                                            class="px-3 py-1 bg-slate-800 border border-slate-700 text-slate-300 rounded-md text-xs hover:border-slate-500 transition-all"
                                        >
                                            Viner
                                        </button>
                                    </div>

                                    {{-- Wine Submenu --}}
                                    <div
                                        x-data="{ showWine: false }"
                                        x-on:toggle-wine-menu.window="showWine = !showWine"
                                        x-show="showWine"
                                        x-cloak
                                        class="flex flex-wrap gap-2 mt-2 pl-4 border-l-2 border-slate-700"
                                    >
                                        @foreach(\App\Enums\PlaceType::wineTypes() as $wineType)
                                            <button
                                                type="button"
                                                wire:click="toggleGameType('{{ $wineType->value }}')"
                                                class="px-2 py-1 rounded text-xs font-medium border transition-all {{ in_array($wineType->value, $gameTypes) ? 'bg-blue-500/20 border-blue-500/50 text-blue-400' : 'bg-slate-800 border-slate-700 text-slate-300 hover:border-slate-500' }}"
                                            >
                                                {{ $wineType->label() }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <x-glass-button variant="primary-blue" class="w-full mt-6" type="submit">
                                    Skapa Spel
                                </x-glass-button>
                            </form>
                        </div>

                        {{-- Right: Join Game --}}
                        <div class="flex-1 p-8 flex flex-col bg-slate-800/30">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-3 rounded-lg bg-emerald-500/20 text-emerald-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white">Gå med i spel</h3>
                                    <p class="text-xs text-slate-400">Har du fått en kod?</p>
                                </div>
                            </div>

                            <form wire:submit="joinGame" class="space-y-4 flex-1">
                                <div class="space-y-1">
                                    <label class="text-xs text-slate-400 font-bold uppercase">Ditt Namn</label>
                                    <input type="text" wire:model="playerName" placeholder="Ange ditt namn" maxlength="20" required class="w-full bg-slate-800 border border-slate-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                                </div>

                                <div class="space-y-1">
                                    <label class="text-xs text-slate-400 font-bold uppercase">Spelkod</label>
                                    <input type="text" wire:model="gameCode" placeholder="T.ex. SKTNGR" maxlength="6" required class="w-full bg-slate-800 border border-slate-600 rounded-lg px-4 py-3 text-white text-center font-mono text-lg tracking-widest uppercase focus:ring-2 focus:ring-emerald-500 focus:outline-none placeholder-slate-600">
                                </div>

                                <x-glass-button variant="secondary" class="w-full mt-6 hover:bg-emerald-600" type="submit">
                                    Gå med
                                </x-glass-button>
                            </form>
                        </div>
                    </div>

                    {{-- Info Footer --}}
                    <div class="p-4 bg-blue-900/20 border-t border-blue-900/50 text-xs text-blue-200 flex flex-wrap gap-4 justify-center">
                        <span>ℹ️ Spelvärden skapar ett spel och får en 6-teckens spelkod</span>
                        <span>• Dela koden med din vän</span>
                        <span>• Spelaren med flest poäng vinner!</span>
                    </div>
                </div>
            </section>
        @endif

        {{-- Waiting Room --}}
        @if($screen === 'waiting')
            <section class="min-h-screen flex items-center justify-center p-4 relative">
                <x-map-background blur="true" overlay="true" />

                <div class="relative w-full max-w-2xl glass-panel rounded-3xl shadow-2xl overflow-hidden animate-fade-in">
                    <div class="p-6 md:p-8">
                        {{-- Game Code --}}
                        <div class="text-center mb-8">
                            <div class="glass-panel rounded-2xl p-6 inline-block">
                                <div class="text-sm text-slate-400 mb-2">Spelkod</div>
                                <div class="text-5xl font-bold text-blue-400 tracking-widest font-mono">
                                    {{ $sessionGameCode }}
                                </div>
                                <div class="text-sm text-slate-400 mt-2">
                                    Dela denna kod med din vän!
                                </div>
                            </div>
                        </div>

                        {{-- Player List --}}
                        <div class="bg-slate-800/50 rounded-xl p-6 mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-bold text-white">Spelare</h3>
                                <span class="px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-sm font-bold">{{ count($players) }}/6</span>
                            </div>

                            <div class="space-y-2">
                                @foreach($players as $player)
                                    <div class="flex items-center gap-3 p-3 bg-slate-700/50 rounded-lg">
                                        <div
                                            class="w-10 h-10 rounded-full border-2 border-white/20"
                                            style="background-color: {{ $player['color'] ?? '#6366f1' }}"
                                        ></div>
                                        <div class="flex-1">
                                            <div class="font-semibold text-white">{{ $player['name'] }}</div>
                                        </div>
                                        @if($player['is_host'] ?? false)
                                            <span class="px-2 py-1 bg-purple-500/20 text-purple-400 rounded text-xs font-bold">Värd</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Start Button or Waiting Message --}}
                        <div class="text-center">
                            @if($isHost)
                                <x-glass-button variant="primary-blue" size="xl" wire:click="startGame">
                                    Starta spelet!
                                </x-glass-button>
                            @else
                                <p class="text-slate-400 text-lg">
                                    Väntar på att värden ska starta spelet...
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Game Screen --}}
        @if($screen === 'game')
            <div class="min-h-screen relative bg-slate-900">
                {{-- MAP (Full Screen) --}}
                <div id="mpMap" wire:ignore class="absolute inset-0 w-full h-full z-0" style="cursor: crosshair;"></div>

                {{-- TOP BAR (Floating HUD) --}}
                <div class="absolute top-0 left-0 w-full pt-4 pb-2 px-4 bg-gradient-to-b from-slate-900 to-transparent pointer-events-none z-10">
                    <div class="max-w-4xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
                        {{-- Round info + Exit button --}}
                        <div class="flex items-center gap-2 pointer-events-auto">
                            <a href="{{ route('home') }}" class="p-1 bg-slate-800/80 rounded hover:bg-slate-700 text-slate-400 hover:text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                            <div class="bg-slate-800/80 backdrop-blur px-3 py-1 rounded-full border border-slate-700 text-xs text-slate-300">
                                Runda {{ $currentRound }} / {{ $totalRounds }}
                            </div>
                        </div>

                        {{-- Question --}}
                        <div class="pointer-events-auto bg-blue-600/90 backdrop-blur-md px-6 py-2 rounded-full shadow-lg flex items-center gap-3">
                            <span class="text-blue-100 text-xs font-semibold uppercase">Hitta</span>
                            <span class="text-white text-lg font-bold">{{ $currentPlace['name'] ?? '' }}</span>
                            <div class="px-2 py-0.5 bg-black/20 rounded text-xs text-white font-mono">
                                <span x-text="timeRemaining + 's'" x-bind:class="getTimerClass()"></span>
                            </div>
                        </div>

                        {{-- Game Code (Small) --}}
                        <div class="pointer-events-auto bg-slate-800/80 backdrop-blur px-3 py-1 rounded border border-slate-700 text-xs text-slate-400 font-mono">
                            KOD: <span class="text-white font-bold">{{ $sessionGameCode }}</span>
                        </div>
                    </div>
                </div>

                {{-- PLAYERS LIST (Floating Overlay) --}}
                <div class="absolute top-32 left-4 right-4 md:left-auto md:right-4 md:w-64 flex flex-col gap-2 pointer-events-none z-10">
                    @foreach($players as $player)
                        <div class="pointer-events-auto bg-slate-900/90 backdrop-blur border-l-4 rounded-r-lg p-3 shadow-lg flex items-center justify-between {{ $player['id'] == $sessionPlayerId ? 'border-red-500' : 'border-blue-500' }}">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full" style="background-color: {{ $player['color'] ?? '#6366f1' }}"></div>
                                <span class="font-bold text-white text-sm">{{ $player['name'] }}{{ $player['id'] == $sessionPlayerId ? ' (Du)' : '' }}</span>
                            </div>
                            <span class="text-xs text-slate-400">{{ $hasGuessed ? 'Klar! ✓' : 'Gissar... ⏳' }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- Waiting feedback --}}
                @if($hasGuessed && !$showingRoundResults)
                    <div class="absolute bottom-6 left-0 right-0 px-4 flex justify-center pointer-events-none z-10">
                        <div class="pointer-events-auto bg-slate-900/95 backdrop-blur-xl border border-slate-700 rounded-2xl shadow-2xl p-6 animate-fade-in text-center">
                            <p class="text-white text-lg font-bold">Gissning skickad!</p>
                            <p class="text-slate-400 text-sm">Väntar på andra spelare...</p>
                        </div>
                    </div>
                @endif

                {{-- SCOREBOARD OVERLAY (Visible between rounds) --}}
                @if($showingRoundResults && !empty($roundHistory[count($roundHistory) - 1] ?? null))
                    @php
                        $lastRound = $roundHistory[count($roundHistory) - 1];
                    @endphp
                    <div class="absolute bottom-6 left-0 right-0 px-4 md:px-0 flex justify-center pointer-events-none z-10">
                        <div class="pointer-events-auto w-full max-w-2xl bg-slate-900/95 backdrop-blur-xl border border-slate-700 rounded-t-2xl md:rounded-2xl shadow-2xl overflow-hidden animate-fade-in">
                            <div class="p-4 bg-slate-800/50 border-b border-slate-700 flex justify-between items-center">
                                <h3 class="text-white font-bold">Resultat - Runda {{ $currentRound }}</h3>
                            </div>

                            <div class="p-0">
                                @foreach($lastRound['guesses'] ?? [] as $index => $guess)
                                    <div class="flex items-center justify-between p-4 border-b border-slate-800 {{ $index === 0 ? 'bg-slate-800/30' : '' }}">
                                        <div class="flex items-center gap-3">
                                            <div class="w-3 h-3 rounded-full" style="background-color: {{ $guess['player']['color'] }}"></div>
                                            <span class="text-white font-medium">{{ $guess['player']['name'] }}</span>
                                            @if($index === 0)
                                                <span class="px-2 py-0.5 bg-emerald-500/20 text-emerald-400 text-[10px] rounded uppercase font-bold">Vinnare</span>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <div class="text-white font-bold">{{ $guess['score'] }} p</div>
                                            <div class="text-xs text-slate-500">
                                                @if($guess['distance'] > 50000)
                                                    -
                                                @else
                                                    {{ number_format($guess['distance'], 0) }} km
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="p-4 bg-slate-900 flex justify-center">
                                <x-glass-button variant="primary-blue" wire:click="nextRound">
                                    Nästa runda
                                </x-glass-button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        {{-- Result Screen --}}
        @if($screen === 'result')
            <section class="min-h-screen flex items-center justify-center p-4 relative">
                <x-map-background blur="true" overlay="true" />

                <div class="relative w-full max-w-2xl glass-panel rounded-3xl p-8 shadow-2xl text-center animate-fade-in">
                    {{-- Trophy --}}
                    <div class="text-6xl mb-4">🏆</div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white my-8">Spelet är slut!</h1>

                    {{-- Winner Box --}}
                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 rounded-2xl p-8 mb-8 shadow-lg">
                        <p class="text-white/80 text-sm uppercase tracking-wide mb-3">Vinnare</p>
                        @if(!empty($players))
                            @php
                                $winner = collect($players)->sortByDesc(fn($p) => $p['total_score'] ?? 0)->first();
                            @endphp
                            <div class="flex items-center justify-center gap-4 mb-3">
                                <div
                                    class="w-12 h-12 rounded-full border-4 border-white shadow-lg"
                                    style="background-color: {{ $winner['color'] ?? '#6366f1' }}"
                                ></div>
                                <div class="text-4xl font-bold text-white">{{ $winner['name'] ?? 'N/A' }}</div>
                            </div>
                            <div class="text-3xl font-bold text-white">{{ $winner['total_score'] ?? 0 }} poäng</div>
                        @endif
                    </div>

                    {{-- Final Standings --}}
                    <div class="bg-slate-800/50 rounded-2xl p-6 mb-8">
                        <h2 class="text-xl font-bold text-white mb-4">Slutställning</h2>
                        <div class="space-y-2">
                            @foreach($players as $index => $player)
                                <div class="flex items-center justify-between p-4 bg-slate-700/50 rounded-xl hover:bg-slate-700/70 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="text-2xl w-8">
                                            @if($index === 0) 🥇
                                            @elseif($index === 1) 🥈
                                            @elseif($index === 2) 🥉
                                            @else {{ $index + 1 }}.
                                            @endif
                                        </span>
                                        <div
                                            class="w-4 h-4 rounded-full border-2 border-white/20"
                                            style="background-color: {{ $player['color'] ?? '#6366f1' }}"
                                        ></div>
                                        <span class="font-semibold text-white">{{ $player['name'] }}</span>
                                    </div>
                                    <span class="text-xl font-bold text-white">{{ $player['total_score'] ?? 0 }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col md:flex-row gap-3 justify-center">
                        <a href="{{ route('multiplayer.v2') }}">
                            <x-glass-button variant="primary-blue" size="lg" class="w-full md:w-auto">
                                Spela igen
                            </x-glass-button>
                        </a>
                        <a href="{{ route('home') }}">
                            <x-glass-button variant="ghost" size="lg" class="w-full md:w-auto">
                                Huvudmeny
                            </x-glass-button>
                        </a>
                    </div>
                </div>
            </section>
        @endif
    </div>
</div>
