@props([
    'action',
    'message' => 'Delete this record?',
    'title' => 'Delete',
])

<form action="{{ $action }}" method="POST" class="d-inline"
      onsubmit="return confirm(@js($message))">
    @csrf
    @method('DELETE')
    <x-ui.icon-button type="submit" icon="las la-trash" variant="outline-danger" :title="$title" />
</form>
