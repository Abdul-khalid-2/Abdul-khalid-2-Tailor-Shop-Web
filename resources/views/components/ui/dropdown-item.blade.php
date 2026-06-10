@props([
    'href' => '#',
    'icon' => null,
    'danger' => false,
])

<a href="{{ $href }}" {{ $attributes->merge([
    'class' => 'dropdown-item'.($danger ? ' text-danger' : ''),
]) }}>
    @if($icon)<i class="{{ $icon }} mr-2"></i>@endif
    {{ $slot }}
</a>
