@props([
    'hover' => true,
    'bordered' => true,
    'striped' => false,
    'small' => false,
    'responsive' => true,
])

@php
    $tableClass = collect([
        'table',
        'mb-0',
        $hover ? 'table-hover' : '',
        $bordered ? 'table-bordered' : '',
        $striped ? 'table-striped' : '',
        $small ? 'table-sm' : '',
    ])->filter()->implode(' ');
@endphp

@if($responsive)
    <div class="table-responsive">
@endif
        <table {{ $attributes->merge(['class' => $tableClass]) }}>
            {{ $slot }}
        </table>
@if($responsive)
    </div>
@endif
