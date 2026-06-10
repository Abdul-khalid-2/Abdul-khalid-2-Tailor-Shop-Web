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
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    @endpush

    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1">Order Statuses</h4>
                <p class="mb-0 text-muted">Configure the order workflow statuses used across the app</p>
            </div>
            <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">
                <i class="las la-arrow-left mr-1"></i> Back to Settings
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="las la-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
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
                                        <span class="badge badge-{{ $badgeMap[$status->name] ?? 'secondary' }}">
                                            {{ $status->name }}
                                        </span>
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
                                        <button type="submit" form="{{ $formId }}" class="btn btn-sm btn-primary">Save</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <p class="text-muted small mt-3">
            Completed and Cancelled statuses are system-defined and cannot be deactivated.
        </p>
    </div>

    @push('js')
        <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
        <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>
