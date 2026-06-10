@props([
    'title',
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'd-flex flex-wrap align-items-center justify-content-between mb-4']) }}>
    <div>
        <h4 class="mb-1">{{ $title }}</h4>
        @if($subtitle)
            <p class="mb-0 text-muted">{{ $subtitle }}</p>
        @endif
    </div>
    @if(isset($actions))
        <div class="d-flex flex-wrap align-items-center mt-2 mt-md-0">
            {{ $actions }}
        </div>
    @endif
</div>
