<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/daterangepicker/daterangepicker.css') }}">
    @endpush

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-3">System Settings</h4>
                <p class="mb-0">Manage all system configurations and branch settings</p>
            </div>
            <div>
                <a href="{{ route('branches.index') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left mr-1"></i> Back to Branches
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="las la-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="las la-exclamation-circle mr-2"></i> Please fix the following errors:
                <ul class="mb-0 pl-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Settings Cards -->
        <div class="row">
            <!-- General Settings -->
            <div class="col-xl-4 col-lg-6 mb-4">
                <div class="card border-left-primary shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    General Settings</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Main Configuration</div>
                                <p class="text-muted mt-2 mb-3">Shop details, currency, notifications, and system defaults</p>
                                <a href="{{ route('settings.general') }}" class="btn btn-primary btn-sm">
                                    <i class="las la-cog mr-1"></i> Configure
                                </a>
                            </div>
                            <div class="col-auto">
                                <i class="las la-cogs fa-3x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Branch Settings -->
            <div class="col-xl-4 col-lg-6 mb-4">
                <div class="card border-left-success shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Branch Settings</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Individual Branch Config</div>
                                <p class="text-muted mt-2 mb-3">Custom settings for each branch location</p>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                                        <i class="las la-store mr-1"></i> Select Branch
                                    </button>
                                    <div class="dropdown-menu">
                                        @foreach($branches as $branch)
                                        <a class="dropdown-item" href="{{ route('settings.branch', $branch) }}">
                                            <i class="las la-cog mr-2"></i> {{ $branch->name }}
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-store fa-3x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lookup Tables -->
            <div class="col-xl-4 col-lg-6 mb-4">
                <div class="card border-left-info shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Lookup Tables</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">System Data</div>
                                <p class="text-muted mt-2 mb-3">Order statuses, payment methods, dress types, etc.</p>
                                <a href="{{ route('settings.lookups') }}" class="btn btn-info btn-sm">
                                    <i class="las la-database mr-1"></i> Manage
                                </a>
                            </div>
                            <div class="col-auto">
                                <i class="las la-database fa-3x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup & Restore -->
            <div class="col-xl-4 col-lg-6 mb-4">
                <div class="card border-left-warning shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Backup & Restore</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Data Management</div>
                                <p class="text-muted mt-2 mb-3">Backup database, restore data, export/import</p>
                                <a href="{{ route('settings.backup') }}" class="btn btn-warning btn-sm">
                                    <i class="las la-hdd mr-1"></i> Backup Now
                                </a>
                            </div>
                            <div class="col-auto">
                                <i class="las la-hdd fa-3x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Management -->
            <div class="col-xl-4 col-lg-6 mb-4">
                <div class="card border-left-danger shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    User Management</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Roles & Permissions</div>
                                <p class="text-muted mt-2 mb-3">Manage users, roles, permissions, and access controls</p>
                                <a href="{{ route('users.index') }}" class="btn btn-danger btn-sm">
                                    <i class="las la-users mr-1"></i> Manage Users
                                </a>
                            </div>
                            <div class="col-auto">
                                <i class="las la-users fa-3x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="col-xl-4 col-lg-6 mb-4">
                <div class="card border-left-secondary shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    System Info</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">About & Version</div>
                                <p class="text-muted mt-2 mb-3">System version, PHP info, server details</p>
                                <a href="{{ route('settings.system-info') }}" class="btn btn-secondary btn-sm">
                                    <i class="las la-info-circle mr-1"></i> View Info
                                </a>
                            </div>
                            <div class="col-auto">
                                <i class="las la-info-circle fa-3x text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header bg-light py-3">
                        <h6 class="mb-0">System Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted mb-2">General Settings</h6>
                                        @if($mainSettings)
                                            <span class="badge badge-success">Configured</span>
                                            <p class="text-muted mt-2 small">
                                                Updated: {{ $mainSettings->updated_at->format('d M, Y h:i A') }}
                                            </p>
                                        @else
                                            <span class="badge badge-warning">Not Configured</span>
                                            <a href="{{ route('settings.general') }}" class="btn btn-sm btn-outline-primary mt-2">
                                                Setup Now
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted mb-2">Branch Settings</h6>
                                        @php
                                            $configuredBranches = $branches->filter(function($branch) {
                                                return $branch->setting;
                                            })->count();
                                        @endphp
                                        <span class="badge badge-{{ $configuredBranches > 0 ? 'success' : 'warning' }}">
                                            {{ $configuredBranches }}/{{ $branches->count() }} Configured
                                        </span>
                                        <p class="text-muted mt-2 small">
                                            {{ $branches->count() - $configuredBranches }} need setup
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted mb-2">Notifications</h6>
                                        @if($mainSettings && $mainSettings->sms_notifications && $mainSettings->email_notifications)
                                            <span class="badge badge-success">All Enabled</span>
                                        @elseif($mainSettings && ($mainSettings->sms_notifications || $mainSettings->email_notifications))
                                            <span class="badge badge-info">Partial</span>
                                        @else
                                            <span class="badge badge-warning">Disabled</span>
                                        @endif
                                        <p class="text-muted mt-2 small">
                                            Configure in General Settings
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted mb-2">Receipt System</h6>
                                        @if($mainSettings && $mainSettings->receipt_prefix && $mainSettings->next_receipt_number)
                                            <span class="badge badge-success">Active</span>
                                            <p class="text-muted mt-2 small">
                                                Next #: {{ $mainSettings->receipt_prefix }}-{{ $mainSettings->next_receipt_number }}
                                            </p>
                                        @else
                                            <span class="badge badge-warning">Setup Required</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Recent Setting Changes</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Setting</th>
                                        <th>Changed By</th>
                                        <th>Date & Time</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($branches->where('setting') as $branch)
                                        @if($branch->setting->updated_at)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="las la-store mr-2 text-success"></i>
                                                    {{ $branch->name }}
                                                </div>
                                            </td>
                                            <td>
                                                @if($branch->setting->updatedBy)
                                                    {{ $branch->setting->updatedBy->name }}
                                                @else
                                                    System
                                                @endif
                                            </td>
                                            <td>{{ $branch->setting->updated_at->format('d M, Y h:i A') }}</td>
                                            <td><span class="badge badge-success">Branch</span></td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    
                                    @if($mainSettings && $mainSettings->updated_at)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="las la-cogs mr-2 text-primary"></i>
                                                General Settings
                                            </div>
                                        </td>
                                        <td>
                                            @if($mainSettings->updatedBy)
                                                {{ $mainSettings->updatedBy->name }}
                                            @else
                                                System
                                            @endif
                                        </td>
                                        <td>{{ $mainSettings->updated_at->format('d M, Y h:i A') }}</td>
                                        <td><span class="badge badge-primary">General</span></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('js')
    <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Table Treeview JavaScript -->
    <script src="{{ asset('backend/assets/js/table-treeview.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('backend/assets/js/customizer.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('backend/assets/js/chart-custom.js') }}"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize dropdowns
            $('.dropdown-toggle').dropdown();
        });
    </script>
    
    <style>
        .card {
            border-radius: 0.5rem;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }
        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }
        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }
        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }
        .border-left-danger {
            border-left: 0.25rem solid #e74a3b !important;
        }
        .border-left-secondary {
            border-left: 0.25rem solid #858796 !important;
        }
        .btn {
            border-radius: 0.375rem;
        }
        .badge {
            font-size: 0.75em;
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
        .table th {
            font-weight: 600;
            color: #6c757d;
            border-top: none;
        }
    </style>
    @endpush
</x-app-layout>