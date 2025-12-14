@props(['variant' => 'primary', 'size' => 'md'])

@php
$classes = match($variant) {
    'primary' => 'bg-emerald-500 hover:bg-emerald-400 text-white shadow-lg shadow-emerald-500/25',
    'primary-blue' => 'bg-blue-600 hover:bg-blue-500 text-white shadow-lg shadow-blue-600/20',
    'secondary' => 'bg-slate-700 hover:bg-slate-600 text-white',
    'ghost' => 'bg-slate-800 border border-slate-700 text-slate-300 hover:border-slate-500',
    default => 'bg-slate-700 text-white',
};

$sizeClasses = match($size) {
    'sm' => 'px-3 py-1 text-sm',
    'md' => 'px-4 py-2 text-base',
    'lg' => 'px-6 py-3 text-lg',
    'xl' => 'w-full px-8 py-4 text-xl',
    default => 'px-4 py-2',
};
@endphp

<button {{ $attributes->merge(['class' => "font-bold rounded-xl transition-all transform active:scale-95 {$classes} {$sizeClasses}"]) }}>
    {{ $slot }}
</button>
