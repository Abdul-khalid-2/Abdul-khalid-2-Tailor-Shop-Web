@props([
    'tabs' => [],
    'active' => null,
    'preserve' => [],
    'col' => 'col-md-7',
])

@php
    $active = $active ?? request()->route()?->getName();
@endphp

<div class="{{ $col }}">
    <ul class="nav nav-pills flex-wrap">
        @foreach($tabs as $routeName => $label)
            <li class="nav-item mr-1 mb-1">
                <a class="nav-link {{ $active === $routeName ? 'active' : '' }}"
                   href="{{ route($routeName, $preserve) }}">
                    {{ $label }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
