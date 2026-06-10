@props([
    'name' => null,
    'label' => null,
    'value' => null,
    'required' => false,
    'rows' => 3,
    'help' => null,
])

@php
    $id = $attributes->get('id', $name);
    $hasError = isset($errors) && $name && $errors->has($name);
    $inputClass = 'form-control'.($hasError ? ' is-invalid' : '');
    $resolvedValue = $name ? old($name, $value) : $value;
@endphp

@if($label)
    <x-ui.form.group :label="$label" :for="$id" :required="$required" :help="$help" :error="$name">
        <textarea name="{{ $name }}" id="{{ $id }}" rows="{{ $rows }}"
                  {{ $required ? 'required' : '' }}
                  {{ $attributes->merge(['class' => $inputClass]) }}>{{ $resolvedValue }}</textarea>
    </x-ui.form.group>
@else
    <textarea name="{{ $name }}" id="{{ $id }}" rows="{{ $rows }}"
              {{ $required ? 'required' : '' }}
              {{ $attributes->merge(['class' => $inputClass]) }}>{{ $resolvedValue }}</textarea>
    @if($name && $hasError)
        <x-ui.form.error :name="$name" />
    @endif
@endif
