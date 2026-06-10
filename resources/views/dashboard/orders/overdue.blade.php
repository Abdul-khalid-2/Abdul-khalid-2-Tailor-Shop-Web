<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    @endpush

    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1 text-danger">
                    <i class="las la-exclamation-triangle mr-1"></i> Overdue Orders
                </h4>
                <p class="mb-0 text-danger">These orders are past their delivery date and need attention</p>
            </div>
            <div>
                <a href="{{ route('orders.create') }}" class="btn btn-primary mr-2">
                    <i class="las la-plus mr-1"></i> New Order
                </a>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left mr-1"></i> All Orders
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="las la-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="las la-exclamation-circle fa-2x mr-3"></i>
            <div>
                <strong>Warning:</strong> The orders below have passed their delivery date and have not been marked as delivered.
            </div>
        </div>

        <div class="card shadow border-danger">
            <div class="card-body">
                @include('dashboard.orders.partials.orders-table', ['orders' => $orders])
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
        <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>
