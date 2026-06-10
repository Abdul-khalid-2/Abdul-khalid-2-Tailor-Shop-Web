@props([
    'name' => null,
    'label' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => null,
    'required' => false,
    'help' => null,
    'valueKey' => 'id',
    'labelKey' => 'name',
])

@php
    $id = $attributes->get('id', $name);
    $hasError = isset($errors) && $name && $errors->has($name);
    $inputClass = 'form-control'.($hasError ? ' is-invalid' : '');
    $resolvedSelected = $name ? old($name, $selected) : $selected;
@endphp

@if($label)
    <x-ui.form.group :label="$label" :for="$id" :required="$required" :help="$help" :error="$name">
@endif

<select name="{{ $name }}" id="{{ $id }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => $inputClass]) }}>
    @if($placeholder)
        <option value="">{{ $placeholder }}</option>
    @endif
    @foreach($options as $key => $option)
        @php
            if (is_array($option) || is_object($option)) {
                $optValue = data_get($option, $valueKey);
                $optLabel = data_get($option, $labelKey);
            } elseif (is_string($key)) {
                $optValue = $key;
                $optLabel = $option;
            } else {
                $optValue = $option;
                $optLabel = $option;
            }
        @endphp
        <option value="{{ $optValue }}" @selected((string) $resolvedSelected === (string) $optValue)>
            {{ $optLabel }}
        </option>
    @endforeach
</select>

@if($label)
    </x-ui.form.group>
@elseif($name && $hasError)
    <x-ui.form.error :name="$name" />
@endif
