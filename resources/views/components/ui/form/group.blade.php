@props([
    'label' => null,
    'for' => null,
    'required' => false,
    'help' => null,
    'error' => null,
])

<div {{ $attributes->merge(['class' => 'form-group']) }}>
    @if($label)
        <x-ui.form.label :for="$for" :required="$required">{{ $label }}</x-ui.form.label>
    @endif

    {{ $slot }}

    @if($help)
        <small class="form-text text-muted">{{ $help }}</small>
    @endif

    @if($error)
        <x-ui.form.error :name="$error" />
    @endif
</div>
