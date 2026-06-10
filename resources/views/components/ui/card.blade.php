@props([
    'title' => null,
    'headerClass' => '',
    'bodyClass' => '',
    'footerClass' => '',
    'noPadding' => false,
    'shadow' => true,
    'border' => null,
])

@php
    $classes = collect([
        'card',
        $shadow ? 'shadow' : null,
        $border ? 'border-'.$border : null,
    ])->filter()->implode(' ');
@endphp

<div {{ $attributes->class([$classes]) }}>
    @if($title || isset($header))
        <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center {{ $headerClass }}">
            @if(isset($header))
                {{ $header }}
            @else
                <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
            @endif
        </div>
    @endif

    <div @class(['card-body', $bodyClass => filled($bodyClass), 'p-0' => $noPadding])>
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="card-footer {{ $footerClass }}">
            {{ $footer }}
        </div>
    @endif
</div>
