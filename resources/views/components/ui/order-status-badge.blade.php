@props(['order'])

@php
    $statusName = $order->status?->name ?? 'Unknown';
    $variant = match ($statusName) {
        'Pending'     => 'warning',
        'In Progress' => 'primary',
        'Ready'       => 'success',
        'Delivered'   => 'secondary',
        'Cancelled'   => 'danger',
        default       => 'secondary',
    };
@endphp

<x-ui.badge :variant="$variant" {{ $attributes }}>
    {{ $statusName }}
</x-ui.badge>
