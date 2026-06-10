@props([
    'href' => null,
    'type' => 'button',
    'icon',
    'variant' => 'outline-primary',
    'size' => 'sm',
    'title' => null,
])

@php
    $classes = 'btn btn-'.$size.' btn-'.$variant;
@endphp

@if($href)
    <a href="{{ $href }}" title="{{ $title }}" {{ $attributes->merge(['class' => $classes]) }}>
        <i class="{{ $icon }}"></i>
    </a>
@else
    <button type="{{ $type }}" title="{{ $title }}" {{ $attributes->merge(['class' => $classes]) }}>
        <i class="{{ $icon }}"></i>
    </button>
@endif
