@props([
    'amount',
    'decimals' => 2,
    'symbol' => 'Rs',
    'highlight' => false,
])

<span {{ $attributes->merge([
    'class' => $highlight && (float) $amount > 0 ? 'text-warning font-weight-bold' : '',
]) }}>
    {{ $symbol }} {{ number_format((float) $amount, $decimals) }}
</span>
