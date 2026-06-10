@props([
    'label',
    'value',
    'icon' => null,
    'color' => 'primary',
    'href' => null,
    'sublabel' => null,
])

@php
    $borderClass = 'border-left-'.$color;
    $textClass   = 'text-'.$color;
@endphp

@php $tag = $href ? 'a' : 'div'; @endphp
<{{ $tag }}
    @if($href) href="{{ $href }}" class="text-decoration-none" @endif
>
    <div {{ $attributes->merge(['class' => "card {$borderClass} shadow h-100 py-2"]) }}>
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold {{ $textClass }} text-uppercase mb-1">{{ $label }}</div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $value }}</div>
                    @if($sublabel)
                        <div class="mt-2 mb-0 text-muted text-xs">{{ $sublabel }}</div>
                    @endif
                </div>
                @if($icon)
                    <div class="col-auto">
                        <i class="{{ $icon }} fa-2x {{ $textClass }}"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
</{{ $tag }}>
