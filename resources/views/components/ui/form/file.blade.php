@props([
    'name' => null,
    'label' => null,
    'required' => false,
    'accept' => null,
    'help' => null,
])

@php
    $id = $attributes->get('id', $name);
    $hasError = isset($errors) && $name && $errors->has($name);
    $inputClass = 'form-control-file'.($hasError ? ' is-invalid' : '');
@endphp

@if($label)
    <x-ui.form.group :label="$label" :for="$id" :required="$required" :help="$help" :error="$name">
        <input type="file" name="{{ $name }}" id="{{ $id }}"
               @if($accept) accept="{{ $accept }}" @endif
               {{ $required ? 'required' : '' }}
               {{ $attributes->merge(['class' => $inputClass]) }}>
    </x-ui.form.group>
@else
    <input type="file" name="{{ $name }}" id="{{ $id }}"
           @if($accept) accept="{{ $accept }}" @endif
           {{ $required ? 'required' : '' }}
           {{ $attributes->merge(['class' => $inputClass]) }}>
    @if($name && $hasError)
        <x-ui.form.error :name="$name" />
    @endif
@endif
