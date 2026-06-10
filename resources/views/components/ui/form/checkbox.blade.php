@props([
    'name',
    'label',
    'checked' => false,
    'value' => '1',
    'help' => null,
])

@php
    $id = $attributes->get('id', $name);
    $isChecked = old($name, $checked);
@endphp

<div class="custom-control custom-checkbox {{ $attributes->get('wrapperClass', 'mb-2') }}">
    <input type="checkbox" class="custom-control-input" id="{{ $id }}" name="{{ $name }}"
           value="{{ $value }}" @checked($isChecked)>
    <label class="custom-control-label" for="{{ $id }}">{{ $label }}</label>
    @if($help)
        <small class="form-text text-muted d-block">{{ $help }}</small>
    @endif
</div>
