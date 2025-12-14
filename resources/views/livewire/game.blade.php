<div class="min-h-screen bg-slate-900 text-white w-full"
    x-data="{
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
    x-on:destroy="removeBeforeUnload()"
>
        {{-- Setup Screen --}}
        @if($screen === 'setup')
            <section class="min-h-screen flex items-center justify-center pt-16 relative">
                <x-map-background blur="true" overlay="true" />

                <div class="relative w-full max-w-2xl h-full md:h-auto md:max-h-[90vh] glass-panel md:rounded-3xl flex flex-col shadow-2xl overflow-hidden animate-fade-in">
                    {{-- Header --}}
                    <div class="p-6 border-b border-slate-700/50 md:flex items-center justify-between">
                        <a href="{{ route('home') }}" class="text-slate-400 hover:text-white flex items-center gap-2 text-sm font-medium transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Tillbaka
                        </a>
                        <h2 class="text-xl font-bold text-white">Inställningar Singleplayer</h2>
                        <div class="w-16"></div>
                    </div>

                    {{-- Scrollable Content --}}
                    <div class="flex-1 overflow-y-auto p-6 md:p-8 space-y-8">
                        {{-- Difficulty --}}
                        <div class="space-y-3">
                            <label class="text-xs uppercase tracking-wider text-slate-400 font-bold">Svårighetsgrad</label>
                            <div class="flex p-1 bg-slate-900/50 rounded-xl">
                                @foreach(\App\Enums\Difficulty::cases() as $diff)
                                    <button
                                        wire:click="$set('difficulty', '{{ $diff->value }}')"
                                        class="flex-1 py-2 text-sm font-medium rounded-lg transition-colors {{ $difficulty === $diff->value ? 'bg-emerald-500 text-white shadow-lg font-bold' : 'text-slate-400 hover:text-white' }}"
                                    >
                                        {{ $diff->label() }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Game Types (Chips) --}}
                        <div class="space-y-3">
                            <label class="text-xs uppercase tracking-wider text-slate-400 font-bold">Typ av platser</label>
                            <div class="flex flex-wrap gap-2">
                                {{-- Mixed --}}
                                <button
                                    wire:click="toggleGameType('{{ \App\Enums\PlaceType::Mixed->value }}')"
                                    class="px-4 py-2 rounded-full text-sm font-medium border transition-all {{ in_array(\App\Enums\PlaceType::Mixed->value, $gameTypes) ? 'bg-emerald-500/20 border-emerald-500/50 text-emerald-400 hover:bg-emerald-500 hover:text-white' : 'bg-slate-800 border-slate-700 text-slate-300 hover:border-slate-500' }}"
                                >
                                    {{ \App\Enums\PlaceType::Mixed->label() }}
                                </button>

                                {{-- Regular Types --}}
                                @foreach(\App\Enums\PlaceType::regularTypes() as $placeType)
                                    <button
                                        wire:click="toggleGameType('{{ $placeType->value }}')"
                                        class="px-4 py-2 rounded-full text-sm font-medium border transition-all {{ in_array($placeType->value, $gameTypes) ? 'bg-emerald-500/20 border-emerald-500/50 text-emerald-400 hover:bg-emerald-500 hover:text-white' : 'bg-slate-800 border-slate-700 text-slate-300 hover:border-slate-500' }}"
                                    >
                                        {{ $placeType->label() }}
                                    </button>
                                @endforeach

                                {{-- Wine Button (toggles submenu) --}}
                                <button
                                    x-on:click="$dispatch('toggle-wine-menu')"
                                    class="px-4 py-2 bg-slate-800 border border-slate-700 text-slate-300 rounded-full text-sm hover:border-slate-500 transition-all"
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
                                        wire:click="toggleGameType('{{ $wineType->value }}')"
                                        class="px-3 py-1 rounded-md text-xs font-medium border transition-all {{ in_array($wineType->value, $gameTypes) ? 'bg-emerald-500/20 border-emerald-500/50 text-emerald-400' : 'bg-slate-800 border-slate-700 text-slate-300 hover:border-slate-500' }}"
                                    >
                                        {{ $wineType->label() }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Sliders --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <label class="text-xs uppercase tracking-wider text-slate-400 font-bold">Antal Omgångar</label>
                                    <span class="text-emerald-400 font-bold">{{ $rounds }}</span>
                                </div>
                                <input
                                    type="range"
                                    wire:model.live="rounds"
                                    min="5"
                                    max="50"
                                    step="5"
                                    class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-emerald-500"
                                >
                            </div>

                            @if($timerEnabled)
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <label class="text-xs uppercase tracking-wider text-slate-400 font-bold">Tid per runda</label>
                                        <span class="text-emerald-400 font-bold">{{ $timerDuration }} sek</span>
                                    </div>
                                    <input
                                        type="range"
                                        wire:model.live="timerDuration"
                                        min="5"
                                        max="60"
                                        step="5"
                                        class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-emerald-500"
                                    >
                                </div>
                            @endif
                        </div>

                        {{-- Toggles --}}
                        <div class="flex flex-col gap-4">
                            <label class="flex items-center justify-between cursor-pointer group">
                                <span class="text-white group-hover:text-emerald-400 transition-colors">Tillåt Zoom</span>
                                <div class="relative">
                                    <input type="checkbox" wire:model="zoomEnabled" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                                </div>
                            </label>
                            <label class="flex items-center justify-between cursor-pointer group">
                                <span class="text-white group-hover:text-emerald-400 transition-colors">Tidsbegränsning</span>
                                <div class="relative">
                                    <input type="checkbox" wire:model.live="timerEnabled" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Footer Action --}}
                    <div class="p-6 border-t border-slate-700/50 bg-slate-900/40">
                        <x-glass-button variant="primary" size="xl" wire:click="startGame">
                            Starta Spelet!
                        </x-glass-button>
                    </div>
                </div>
            </section>
        @endif

        {{-- Game Screen --}}
        @if($screen === 'game')
            <div class="min-h-screen relative bg-slate-900" x-data="gameScreen()">
                {{-- MAP (Full Screen) --}}
                <div
                    id="map"
                    wire:ignore
                    class="absolute inset-0 w-full h-full z-0"
                    style="cursor: crosshair;"
                ></div>

                {{-- TOP BAR (Floating HUD) --}}
                <div class="absolute top-0 left-0 w-full pt-4 pb-4 px-4 bg-gradient-to-b from-slate-900/90 to-transparent pointer-events-none flex flex-col md:flex-row justify-between items-start md:items-center gap-4 z-10">
                    {{-- Left: Back + Round --}}
                    <div class="pointer-events-auto flex items-center gap-2">
                        <a href="{{ route('home') }}" class="p-2 bg-slate-800/80 backdrop-blur rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white border border-slate-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                        <div class="bg-slate-800/80 backdrop-blur px-3 py-2 rounded-lg border border-slate-700 text-sm font-medium text-slate-300">
                            Runda <span class="text-white">{{ $currentRound }}</span> / {{ $rounds }}
                        </div>
                    </div>

                    {{-- Center: Question Bubble --}}
                    <div class="pointer-events-auto bg-slate-900/90 backdrop-blur-md border border-slate-600 px-6 py-3 rounded-full shadow-2xl flex items-center gap-3 animate-fade-in mx-auto md:absolute md:left-1/2 md:transform md:-translate-x-1/2">
                        <span class="text-slate-400 text-sm font-semibold uppercase tracking-wider">Var ligger</span>
                        <span class="text-white text-lg md:text-xl font-bold">{{ $currentPlace['name'] ?? '' }}?</span>
                        @if($timerEnabled)
                            <div class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold text-xs shadow-lg" x-bind:class="getTimerClass()">
                                <span x-text="timeRemaining + 's'"></span>
                            </div>
                        @endif
                    </div>

                    {{-- Right: Score --}}
                    <div class="pointer-events-auto bg-slate-800/80 backdrop-blur px-4 py-2 rounded-lg border border-slate-700 flex flex-col items-end">
                        <span class="text-xs text-slate-400 uppercase">Poäng</span>
                        <span class="text-emerald-400 font-bold text-lg">{{ $totalScore }}</span>
                    </div>
                </div>

                {{-- Map Controls (Show Labels) --}}
                <div class="absolute bottom-24 left-4 z-10 pointer-events-auto bg-slate-800/90 backdrop-blur px-3 py-2 rounded-lg border border-slate-700">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model.live="showLabels" x-on:change="toggleLabels()" class="rounded accent-emerald-500">
                        <span class="text-white text-sm">Visa etiketter</span>
                    </label>
                </div>

                {{-- BOTTOM RESULT CARD (appears after guess) --}}
                @if($lastFeedback)
                    <div class="absolute bottom-6 left-0 w-full px-4 flex justify-center pointer-events-none z-10">
                        <div class="pointer-events-auto w-full max-w-md bg-slate-900/95 backdrop-blur-xl border border-slate-700 rounded-2xl shadow-2xl p-6 transform transition-all animate-fade-in">
                            <div class="text-center mb-4">
                                <span class="text-4xl font-black text-white block">
                                    {{ $lastFeedback['points'] }} p
                                    @if($lastFeedback['timeBonus'] > 0)
                                        <span class="text-2xl text-green-400">+{{ $lastFeedback['timeBonus'] }}</span>
                                    @endif
                                </span>
                                <span class="text-sm text-slate-400">{{ $lastFeedback['message'] }}</span>
                            </div>

                            {{-- Progress bar --}}
                            <div class="w-full bg-slate-800 h-2 rounded-full mb-6 overflow-hidden">
                                <div class="bg-emerald-500 h-full" style="width: {{ ($lastFeedback['points'] / 10) * 100 }}%"></div>
                            </div>

                            <x-glass-button variant="secondary" class="w-full" wire:click="continueToNextRound">
                                @if($currentRound >= $rounds)
                                    Se resultat
                                @else
                                    Nästa runda
                                @endif
                            </x-glass-button>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        {{-- Result Screen --}}
        @if($screen === 'result')
            <section class="min-h-screen flex items-center justify-center p-4 relative">
                <x-map-background blur="true" overlay="true" />

                <div class="relative w-full max-w-3xl glass-panel rounded-3xl shadow-2xl overflow-hidden animate-fade-in">
                    <div class="p-6 md:p-8">
                        {{-- Header --}}
                        <div class="text-center mb-6">
                            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-2">🎉 Grattis! 🎉</h2>
                            <div class="text-5xl md:text-6xl font-black bg-gradient-to-r from-emerald-500 to-cyan-500 bg-clip-text text-transparent my-4">
                                {{ $totalScore }}
                                @if($totalBonus > 0)
                                    <span class="text-3xl md:text-4xl text-green-400">+{{ $totalBonus }}</span>
                                @endif
                                <span class="text-2xl md:text-3xl text-slate-400">/ {{ $rounds * 10 }}</span>
                            </div>
                            <p class="text-lg md:text-xl text-slate-300">{{ $this->finalMessage }}</p>
                        </div>

                        {{-- Round History --}}
                        <div class="bg-slate-800/50 rounded-xl p-4 mb-6 overflow-x-auto">
                            <h3 class="text-white font-bold mb-3">Historik</h3>
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-slate-700">
                                        <th class="text-left py-2 px-3 text-slate-400 font-semibold">Plats</th>
                                        <th class="text-center py-2 px-3 text-slate-400 font-semibold">Poäng</th>
                                        @if($timerEnabled)
                                            <th class="text-center py-2 px-3 text-slate-400 font-semibold">Bonus</th>
                                            <th class="text-center py-2 px-3 text-slate-400 font-semibold">Tid</th>
                                        @endif
                                        <th class="text-center py-2 px-3 text-slate-400 font-semibold">Avstånd</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roundHistory as $index => $round)
                                        <tr class="border-b border-slate-800/50">
                                            <td class="py-2 px-3 text-white">{{ $round['place'] }}</td>
                                            <td class="text-center py-2 px-3">
                                                <span class="px-2 py-1 bg-slate-700 rounded text-emerald-400 font-bold">{{ $round['points'] }}</span>
                                            </td>
                                            @if($timerEnabled)
                                                <td class="text-center py-2 px-3">
                                                    @if($round['timeBonus'] > 0)
                                                        <span class="px-2 py-1 bg-green-500/20 text-green-400 rounded font-bold">+{{ $round['timeBonus'] }}</span>
                                                    @else
                                                        <span class="text-slate-500">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center py-2 px-3 text-slate-400">{{ $round['timeTaken'] }}s</td>
                                            @endif
                                            <td class="text-center py-2 px-3 text-slate-400">{{ $round['distance'] }} mil</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-col md:flex-row gap-3 justify-center">
                            <x-glass-button variant="primary" size="lg" wire:click="playAgain">
                                Spela igen
                            </x-glass-button>
                            <a href="{{ route('home') }}">
                                <x-glass-button variant="ghost" size="lg">
                                    Huvudmeny
                                </x-glass-button>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif
</div>
