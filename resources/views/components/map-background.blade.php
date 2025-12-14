@props(['blur' => true, 'overlay' => true, 'game' => false])

<div class="absolute inset-0 map-bg {{ $game ? 'map-bg-game' : '' }} {{ $blur ? 'blur-sm scale-110' : '' }}"></div>
@if($overlay && !$game)
    <div class="absolute inset-0 bg-slate-900/60"></div>
@endif
