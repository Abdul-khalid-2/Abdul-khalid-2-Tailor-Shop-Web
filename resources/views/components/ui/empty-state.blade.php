@props([
    'icon' => 'las la-inbox',
    'title' => 'No records found',
    'colspan' => 1,
    'asRow' => false,
])

@if($asRow)
    <tr>
        <td colspan="{{ $colspan }}" class="text-center text-muted py-5">
            @if($icon)<i class="{{ $icon }} fa-2x mb-2 d-block"></i>@endif
            <p class="mb-0">{{ $title }}</p>
            @if(isset($action))<div class="mt-3">{{ $action }}</div>@endif
        </td>
    </tr>
@else
    <div {{ $attributes->merge(['class' => 'text-center text-muted py-5']) }}>
        @if($icon)<i class="{{ $icon }} fa-3x mb-3 d-block"></i>@endif
        <p class="mb-0">{{ $title }}</p>
        @if(isset($action))<div class="mt-3">{{ $action }}</div>@endif
    </div>
@endif
