@php
    $badgeMap = [
        'Pending'     => 'warning',
        'In Progress' => 'primary',
        'Ready'       => 'success',
        'Delivered'   => 'secondary',
        'Cancelled'   => 'danger',
    ];
@endphp

<x-app-layout>
    <x-ui.assets />
    <x-ui.styles />

    <div class="container-fluid">
        <x-ui.page-header title="Order Statuses" subtitle="Configure the order workflow statuses used across the app">
            <x-slot:actions>
                <x-ui.button :href="route('settings.index')" variant="outline-secondary" icon="las la-arrow-left">Back to Settings</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.session-alerts />

        <x-ui.card :noPadding="true">
            <x-ui.table :hover="false">
                <thead class="thead-light">
                    <tr>
                        <th width="60">Order</th>
                        <th>Name</th>
                        <th>Preview</th>
                        <th>Color</th>
                        <th class="text-center">Active</th>
                        <th class="text-center">Completed</th>
                        <th class="text-center">Cancelled</th>
                        <th width="100">Save</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statuses as $status)
                        @php $formId = 'status-form-'.$status->id; @endphp
                        <form id="{{ $formId }}" action="{{ route('settings.order-statuses.update', $status) }}" method="POST" class="d-none">
                            @csrf
                            @method('PUT')
                        </form>
                        <tr>
                            <td>
                                <input type="number" form="{{ $formId }}" name="sort_order" class="form-control form-control-sm"
                                       value="{{ $status->sort_order }}" min="0">
                            </td>
                            <td>
                                <input type="text" form="{{ $formId }}" name="name" class="form-control form-control-sm"
                                       value="{{ $status->name }}" required>
                            </td>
                            <td>
                                <x-ui.badge :variant="$badgeMap[$status->name] ?? 'secondary'">{{ $status->name }}</x-ui.badge>
                            </td>
                            <td>
                                <input type="color" form="{{ $formId }}" name="color" class="form-control form-control-sm"
                                       value="{{ $status->color }}">
                            </td>
                            <td class="text-center align-middle">
                                <input type="checkbox" form="{{ $formId }}" name="is_active" value="1"
                                       {{ $status->is_active ? 'checked' : '' }}
                                       {{ $status->is_completed || $status->is_cancelled ? 'disabled' : '' }}>
                            </td>
                            <td class="text-center align-middle">
                                @if($status->is_completed)<i class="las la-check text-success"></i>@else — @endif
                            </td>
                            <td class="text-center align-middle">
                                @if($status->is_cancelled)<i class="las la-check text-danger"></i>@else — @endif
                            </td>
                            <td class="text-center align-middle">
                                <x-ui.button type="submit" form="{{ $formId }}" size="sm">Save</x-ui.button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </x-ui.table>
        </x-ui.card>

        <p class="text-muted small mt-3">
            Completed and Cancelled statuses are system-defined and cannot be deactivated.
        </p>
    </div>
</x-app-layout>
