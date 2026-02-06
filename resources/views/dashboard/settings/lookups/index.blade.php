<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    @endpush

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-3">Lookup Tables</h4>
                <p class="mb-0">Manage system reference data and configurations</p>
            </div>
            <div>
                <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left mr-1"></i> Back to Settings
                </a>
            </div>
        </div>

        <!-- Lookup Tables Cards -->
        <div class="row">
            <!-- Order Statuses -->
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100">
                    <div class="card-body">
                        <div class="text-center">
                            <i class="las la-clipboard-list fa-3x text-primary mb-3"></i>
                            <h5>Order Statuses</h5>
                            <p class="text-muted">Manage order workflow statuses</p>
                            <div class="mt-3">
                                <span class="badge badge-primary">{{ \App\Models\OrderStatus::count() }} Statuses</span>
                            </div>
                            <a href="#" class="btn btn-outline-primary btn-sm mt-3">
                                <i class="las la-cog mr-1"></i> Manage
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100">
                    <div class="card-body">
                        <div class="text-center">
                            <i class="las la-credit-card fa-3x text-success mb-3"></i>
                            <h5>Payment Methods</h5>
                            <p class="text-muted">Configure payment options</p>
                            <div class="mt-3">
                                <span class="badge badge-success">{{ \App\Models\PaymentMethod::count() }} Methods</span>
                            </div>
                            <a href="#" class="btn btn-outline-success btn-sm mt-3">
                                <i class="las la-cog mr-1"></i> Manage
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dress Types -->
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100">
                    <div class="card-body">
                        <div class="text-center">
                            <i class="las la-tshirt fa-3x text-info mb-3"></i>
                            <h5>Dress Types</h5>
                            <p class="text-muted">Manage dress types and pricing</p>
                            <div class="mt-3">
                                <span class="badge badge-info">{{ \App\Models\DressType::count() }} Types</span>
                            </div>
                            <a href="{{ route('dress-types.index') }}" class="btn btn-outline-info btn-sm mt-3">
                                <i class="las la-cog mr-1"></i> Manage
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignment Statuses -->
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100">
                    <div class="card-body">
                        <div class="text-center">
                            <i class="las la-tasks fa-3x text-warning mb-3"></i>
                            <h5>Assignment Status</h5>
                            <p class="text-muted">Tailor assignment statuses</p>
                            <div class="mt-3">
                                <span class="badge badge-warning">{{ \App\Models\AssignmentStatus::count() }} Statuses</span>
                            </div>
                            <a href="#" class="btn btn-outline-warning btn-sm mt-3">
                                <i class="las la-cog mr-1"></i> Manage
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Statuses -->
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100">
                    <div class="card-body">
                        <div class="text-center">
                            <i class="las la-money-check-alt fa-3x text-danger mb-3"></i>
                            <h5>Payment Statuses</h5>
                            <p class="text-muted">Manage payment status types</p>
                            <div class="mt-3">
                                <span class="badge badge-danger">{{ \App\Models\PaymentStatus::count() }} Statuses</span>
                            </div>
                            <a href="#" class="btn btn-outline-danger btn-sm mt-3">
                                <i class="las la-cog mr-1"></i> Manage
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fabric Types -->
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card border-left-secondary shadow h-100">
                    <div class="card-body">
                        <div class="text-center">
                            <i class="las la-cut fa-3x text-secondary mb-3"></i>
                            <h5>Fabric Types</h5>
                            <p class="text-muted">Manage fabric categories</p>
                            <div class="mt-3">
                                <span class="badge badge-secondary">5+ Types</span>
                            </div>
                            <a href="#" class="btn btn-outline-secondary btn-sm mt-3">
                                <i class="las la-cog mr-1"></i> Manage
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Expense Categories -->
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card border-left-dark shadow h-100">
                    <div class="card-body">
                        <div class="text-center">
                            <i class="las la-receipt fa-3x text-dark mb-3"></i>
                            <h5>Expense Categories</h5>
                            <p class="text-muted">Manage expense categories</p>
                            <div class="mt-3">
                                <span class="badge badge-dark">8+ Categories</span>
                            </div>
                            <a href="#" class="btn btn-outline-dark btn-sm mt-3">
                                <i class="las la-cog mr-1"></i> Manage
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Categories -->
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100">
                    <div class="card-body">
                        <div class="text-center">
                            <i class="las la-shopping-bag fa-3x text-info mb-3"></i>
                            <h5>Product Categories</h5>
                            <p class="text-muted">Manage product classifications</p>
                            <div class="mt-3">
                                <span class="badge badge-info">3 Categories</span>
                            </div>
                            <a href="#" class="btn btn-outline-info btn-sm mt-3">
                                <i class="las la-cog mr-1"></i> Manage
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header bg-light py-3">
                        <h6 class="mb-0">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <button class="btn btn-outline-primary btn-block" onclick="seedLookupData()">
                                    <i class="las la-seedling mr-2"></i> Seed Default Data
                                </button>
                                <small class="text-muted d-block mt-1">Populate with default values</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <button class="btn btn-outline-success btn-block" onclick="exportLookupData()">
                                    <i class="las la-file-export mr-2"></i> Export All Data
                                </button>
                                <small class="text-muted d-block mt-1">Export lookup tables to CSV</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <button class="btn btn-outline-warning btn-block" onclick="refreshCache()">
                                    <i class="las la-sync mr-2"></i> Refresh Cache
                                </button>
                                <small class="text-muted d-block mt-1">Clear and reload cache</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header bg-light py-3">
                        <h6 class="mb-0">Lookup Tables Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Table Name</th>
                                        <th>Description</th>
                                        <th>Record Count</th>
                                        <th>Last Updated</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>order_statuses</td>
                                        <td>Order workflow status definitions</td>
                                        <td>{{ \App\Models\OrderStatus::count() }}</td>
                                        <td>{{ \App\Models\OrderStatus::max('updated_at') ? \App\Models\OrderStatus::max('updated_at')->format('Y-m-d H:i') : 'N/A' }}</td>
                                        <td><span class="badge badge-success">Active</span></td>
                                    </tr>
                                    <tr>
                                        <td>payment_statuses</td>
                                        <td>Payment status definitions</td>
                                        <td>{{ \App\Models\PaymentStatus::count() }}</td>
                                        <td>{{ \App\Models\PaymentStatus::max('updated_at') ? \App\Models\PaymentStatus::max('updated_at')->format('Y-m-d H:i') : 'N/A' }}</td>
                                        <td><span class="badge badge-success">Active</span></td>
                                    </tr>
                                    <tr>
                                        <td>payment_methods</td>
                                        <td>Available payment methods</td>
                                        <td>{{ \App\Models\PaymentMethod::count() }}</td>
                                        <td>{{ \App\Models\PaymentMethod::max('updated_at') ? \App\Models\PaymentMethod::max('updated_at')->format('Y-m-d H:i') : 'N/A' }}</td>
                                        <td><span class="badge badge-success">Active</span></td>
                                    </tr>
                                    <tr>
                                        <td>assignment_statuses</td>
                                        <td>Tailor assignment statuses</td>
                                        <td>{{ \App\Models\AssignmentStatus::count() }}</td>
                                        <td>{{ \App\Models\AssignmentStatus::max('updated_at') ? \App\Models\AssignmentStatus::max('updated_at')->format('Y-m-d H:i') : 'N/A' }}</td>
                                        <td><span class="badge badge-success">Active</span></td>
                                    </tr>
                                    <tr>
                                        <td>dress_types</td>
                                        <td>Dress type definitions with pricing</td>
                                        <td>{{ \App\Models\DressType::count() }}</td>
                                        <td>{{ \App\Models\DressType::max('updated_at') ? \App\Models\DressType::max('updated_at')->format('Y-m-d H:i') : 'N/A' }}</td>
                                        <td><span class="badge badge-success">Active</span></td>
                                    </tr>
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
    
    <script>
        function seedLookupData() {
            if (confirm('Seed default lookup data? This will add missing default values.')) {
                // In real app: AJAX call to seed data
                alert('Seeding default data...');
                setTimeout(() => {
                    alert('Default data seeded successfully!');
                    location.reload();
                }, 1500);
            }
        }
        
        function exportLookupData() {
            alert('Exporting lookup data to CSV...');
            // In real app: Generate and download CSV
            setTimeout(() => {
                alert('Data exported successfully!');
            }, 1500);
        }
        
        function refreshCache() {
            if (confirm('Refresh lookup cache? This will clear and reload all cached data.')) {
                alert('Refreshing cache...');
                // In real app: AJAX call to refresh cache
                setTimeout(() => {
                    alert('Cache refreshed successfully!');
                }, 1500);
            }
        }
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
        .border-left-dark {
            border-left: 0.25rem solid #5a5c69 !important;
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
            background-color: #f8f9fa;
        }
    </style>
    @endpush
</x-app-layout>