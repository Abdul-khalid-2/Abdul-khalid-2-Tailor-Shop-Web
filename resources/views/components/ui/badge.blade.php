@props([
    'variant' => 'secondary',
    'pill' => false,
])

<span {{ $attributes->merge([
    'class' => 'badge badge-'.$variant.($pill ? ' badge-pill' : ''),
]) }}>
    {{ $slot }}
</span>
