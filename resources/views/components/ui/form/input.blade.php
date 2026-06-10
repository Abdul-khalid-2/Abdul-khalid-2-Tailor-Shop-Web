@props([
    'type' => 'text',
    'name' => null,
    'label' => null,
    'value' => null,
    'required' => false,
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
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
               value="{{ $type !== 'password' ? $resolvedValue : '' }}"
               {{ $required ? 'required' : '' }}
               {{ $attributes->merge(['class' => $inputClass]) }}>
    </x-ui.form.group>
@else
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
           value="{{ $type !== 'password' ? $resolvedValue : '' }}"
           {{ $required ? 'required' : '' }}
           {{ $attributes->merge(['class' => $inputClass]) }}>
    @if($name && $hasError)
        <x-ui.form.error :name="$name" />
    @endif
@endif
