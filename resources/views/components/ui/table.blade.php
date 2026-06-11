@props([
    'hover' => true,
    'bordered' => true,
    'striped' => false,
    'small' => false,
    'responsive' => true,
    'wide' => false,
])

@php
    $tableClass = collect([
        'table',
        'ui-table',
        'mb-0',
        $hover ? 'table-hover' : '',
        $bordered ? 'table-bordered' : '',
        $striped ? 'table-striped' : '',
        $small ? 'table-sm' : '',
    ])->filter()->implode(' ');

    $wrapClass = collect([
        'ui-table-wrap',
        $wide ? 'ui-table-wrap--wide' : '',
    ])->filter()->implode(' ');
@endphp

@if($responsive)
    <div class="{{ $wrapClass }}">
@endif
        <table {{ $attributes->merge(['class' => $tableClass]) }}>
            {{ $slot }}
        </table>
@if($responsive)
    </div>
@endif
