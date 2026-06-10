@props(['name', 'bag' => null])

@php
    $errors = $bag ? $bag->get($name) : (isset($errors) ? $errors->get($name) : []);
@endphp

@if(!empty($errors))
    <div {{ $attributes->merge(['class' => 'invalid-feedback d-block']) }}>
        {{ is_array($errors) ? $errors[0] : $errors }}
    </div>
@endif
