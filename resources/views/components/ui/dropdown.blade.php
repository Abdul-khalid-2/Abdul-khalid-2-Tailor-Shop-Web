@props([
    'label',
    'variant' => 'outline-secondary',
    'size' => 'sm',
    'icon' => null,
    'align' => 'right',
])

@php
    $menuClass = $align === 'right' ? 'dropdown-menu-right' : '';
@endphp

<div {{ $attributes->merge(['class' => 'dropdown d-inline-block']) }}>
    <button class="btn btn-{{ $size }} btn-{{ $variant }} dropdown-toggle" type="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        @if($icon)<i class="{{ $icon }} mr-1"></i>@endif
        {{ $label }}
    </button>
    <div class="dropdown-menu {{ $menuClass }}">
        {{ $slot }}
    </div>
</div>
