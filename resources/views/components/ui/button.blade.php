@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
    'size' => '',
    'icon' => null,
    'iconPosition' => 'left',
])

@php
    $classes = collect([
        'btn',
        str_starts_with($variant, 'outline-') ? 'btn-'.$variant : 'btn-'.$variant,
        $size ? 'btn-'.$size : '',
        $attributes->get('class'),
    ])->filter()->implode(' ');
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->except('class')->merge(['class' => $classes]) }}>
        @if($icon && $iconPosition === 'left')<i class="{{ $icon }} mr-1"></i>@endif
        {{ $slot }}
        @if($icon && $iconPosition === 'right')<i class="{{ $icon }} ml-1"></i>@endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->except('class')->merge(['class' => $classes]) }}>
        @if($icon && $iconPosition === 'left')<i class="{{ $icon }} mr-1"></i>@endif
        {{ $slot }}
        @if($icon && $iconPosition === 'right')<i class="{{ $icon }} ml-1"></i>@endif
    </button>
@endif
