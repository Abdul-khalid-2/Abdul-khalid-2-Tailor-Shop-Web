@props([
    'paginator',
    'label' => 'records',
])

@if($paginator->hasPages())
    <div {{ $attributes->merge(['class' => 'd-flex flex-wrap justify-content-between align-items-center']) }}>
        <small class="text-muted mb-2 mb-md-0">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} {{ $label }}
        </small>
        <div>{{ $paginator->links() }}</div>
    </div>
@endif
