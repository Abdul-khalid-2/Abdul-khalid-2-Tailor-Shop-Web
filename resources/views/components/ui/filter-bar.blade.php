@props([
    'class' => 'mb-4',
])

<x-ui.card :shadow="true" :class="$class" bodyClass="py-3">
    <div class="row align-items-center">
        {{ $slot }}
    </div>
</x-ui.card>
