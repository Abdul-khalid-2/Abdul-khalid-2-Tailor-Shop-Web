@props([
    'action',
    'method' => 'GET',
    'name' => 'search',
    'placeholder' => 'Search...',
    'value' => null,
    'col' => 'col-md-5',
])

@php
    $value = $value ?? request($name);
@endphp

<div class="{{ $col }} mb-3 mb-md-0">
    <form method="{{ $method }}" action="{{ $action }}">
        {{ $preserve ?? '' }}
        <div class="input-group">
            <input type="text"
                   name="{{ $name }}"
                   class="form-control"
                   placeholder="{{ $placeholder }}"
                   value="{{ $value }}">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" title="Search">
                    <i class="las la-search"></i>
                </button>
            </div>
        </div>
    </form>
</div>
