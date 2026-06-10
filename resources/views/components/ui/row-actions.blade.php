@props([
    'view' => null,
    'edit' => null,
    'delete' => null,
    'deleteMessage' => 'Delete this record?',
])

<div {{ $attributes->merge(['class' => 'text-center']) }}>
    @if($view)
        <x-ui.icon-button :href="$view" icon="las la-eye" variant="outline-primary" title="View" />
    @endif
    @if($edit)
        <x-ui.icon-button :href="$edit" icon="las la-edit" variant="outline-secondary" title="Edit" />
    @endif
    @if($delete)
        <x-ui.confirm-delete :action="$delete" :message="$deleteMessage" />
    @endif
    {{ $slot }}
</div>
