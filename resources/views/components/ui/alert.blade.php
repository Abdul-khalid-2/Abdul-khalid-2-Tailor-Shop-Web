@props([
    'type' => 'success',
    'dismissible' => true,
    'icon' => null,
])

@php
    $defaultIcons = [
        'success' => 'las la-check-circle',
        'danger'  => 'las la-exclamation-circle',
        'warning' => 'las la-exclamation-triangle',
        'info'    => 'las la-info-circle',
        'primary' => 'las la-info-circle',
    ];
    $iconClass = $icon ?? ($defaultIcons[$type] ?? 'las la-info-circle');
@endphp

<div {{ $attributes->merge([
    'class' => 'alert alert-'.$type.($dismissible ? ' alert-dismissible fade show' : ''),
    'role' => 'alert',
]) }}>
    <i class="{{ $iconClass }} mr-2"></i>
    {{ $slot }}
    @if($dismissible)
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    @endif
</div>
