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
                <h4 class="mb-1">Settings</h4>
                <p class="mb-0 text-muted">
                    @if($isSuperAdmin)
                        Manage shop configuration, branches, users, and order statuses
                    @else
                        Manage your branch shop information
                    @endif
                </p>
            </div>
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left mr-1"></i> Back to Dashboard
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="las la-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="las la-exclamation-circle mr-2"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        <div class="row">
            {{-- General Info --}}
            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card shadow h-100 border-left-primary">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-3">
                            <i class="las la-cog fa-2x text-primary"></i>
                        </div>
                        <h5 class="font-weight-bold">General Info</h5>
                        <p class="text-muted flex-grow-1">
                            Shop name, contact details, currency, receipts, and notifications
                        </p>
                        <a href="{{ route('settings.general') }}" class="btn btn-primary btn-block mt-2">
                            <i class="las la-edit mr-1"></i> Configure
                        </a>
                    </div>
                </div>
            </div>

            @if($isSuperAdmin)
                {{-- Branches --}}
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card shadow h-100 border-left-success">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <i class="las la-store fa-2x text-success"></i>
                            </div>
                            <h5 class="font-weight-bold">Branches</h5>
                            <p class="text-muted flex-grow-1">
                                Add and manage shop branches and their details
                            </p>
                            <a href="{{ route('branches.index') }}" class="btn btn-success btn-block mt-2">
                                <i class="las la-store mr-1"></i> Manage Branches
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Users --}}
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card shadow h-100 border-left-info">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <i class="las la-users fa-2x text-info"></i>
                            </div>
                            <h5 class="font-weight-bold">Users</h5>
                            <p class="text-muted flex-grow-1">
                                Manage Super Admin and Branch Admin accounts
                            </p>
                            <a href="{{ route('settings.users.index') }}" class="btn btn-info btn-block mt-2">
                                <i class="las la-user-cog mr-1"></i> Manage Users
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Order Statuses --}}
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card shadow h-100 border-left-warning">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <i class="las la-clipboard-list fa-2x text-warning"></i>
                            </div>
                            <h5 class="font-weight-bold">Order Statuses</h5>
                            <p class="text-muted flex-grow-1">
                                Configure order workflow statuses and display order
                            </p>
                            <a href="{{ route('settings.order-statuses.index') }}" class="btn btn-warning btn-block mt-2">
                                <i class="las la-list mr-1"></i> Manage Statuses
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('js')
        <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
        <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    @endpush

    <style>
        .border-left-primary  { border-left: 0.25rem solid #4e73df !important; }
        .border-left-success  { border-left: 0.25rem solid #1cc88a !important; }
        .border-left-info     { border-left: 0.25rem solid #36b9cc !important; }
        .border-left-warning  { border-left: 0.25rem solid #f6c23e !important; }
    </style>
</x-app-layout>
