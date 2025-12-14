@props(['noPadding' => false])

<div {{ $attributes->merge(['class' => 'glass-panel rounded-3xl ' . ($noPadding ? '' : 'p-6')]) }}>
    {{ $slot }}
</div>
