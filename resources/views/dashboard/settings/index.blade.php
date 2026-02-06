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
                                        @php
                                            $branches = [
                                                (object)['id' => 1, 'name' => 'Main Shop', 'code' => 'MAIN'],
                                                (object)['id' => 2, 'name' => 'Downtown Branch', 'code' => 'DOWN'],
                                                (object)['id' => 3, 'name' => 'Mall Outlet', 'code' => 'MALL'],
                                                (object)['id' => 4, 'name' => 'City Center', 'code' => 'CITY'],
                                            ];
                                        @endphp
                                        @foreach($branches as $branch)
                                        <a class="dropdown-item" href="{{ route('settings.branch', $branch->id) }}">
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
                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#lookupTablesModal">
                                    <i class="las la-database mr-1"></i> Manage
                                </button>
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
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#backupModal">
                                    <i class="las la-hdd mr-1"></i> Backup Now
                                </button>
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
                                <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#systemInfoModal">
                                    <i class="las la-info-circle mr-1"></i> View Info
                                </button>
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
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Setting Changes</h6>
                        <button class="btn btn-sm btn-outline-primary" onclick="refreshLogs()">
                            <i class="las la-redo-alt"></i> Refresh
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @for($i = 1; $i <= 5; $i++)
                            <div class="timeline-item mb-3">
                                <div class="timeline-marker bg-{{ ['primary', 'success', 'info', 'warning', 'danger'][$i-1] }}"></div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1">Setting Updated</h6>
                                        <small class="text-muted">{{ now()->subHours($i)->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1">Branch settings were updated for {{ ['Main Branch', 'Downtown', 'Mall Outlet', 'City Center', 'North Point'][$i-1] }}</p>
                                    <small class="text-muted">By: Admin User</small>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary btn-block text-left" onclick="clearCache()">
                                <i class="las la-broom mr-2"></i> Clear Cache
                            </button>
                            <button class="btn btn-outline-success btn-block text-left" onclick="optimizeDatabase()">
                                <i class="las la-tachometer-alt mr-2"></i> Optimize Database
                            </button>
                            <button class="btn btn-outline-info btn-block text-left" onclick="generateSystemReport()">
                                <i class="las la-file-alt mr-2"></i> Generate System Report
                            </button>
                            <button class="btn btn-outline-warning btn-block text-left" data-toggle="modal" data-target="#maintenanceModal">
                                <i class="las la-tools mr-2"></i> Maintenance Mode
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lookup Tables Modal -->
    <div class="modal fade" id="lookupTablesModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage Lookup Tables</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="las la-clipboard-list fa-3x text-primary mb-3"></i>
                                    <h5>Order Statuses</h5>
                                    <p class="text-muted">Manage order workflow statuses</p>
                                    <a href="#" class="btn btn-outline-primary btn-sm">Manage</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="las la-credit-card fa-3x text-success mb-3"></i>
                                    <h5>Payment Methods</h5>
                                    <p class="text-muted">Configure payment options</p>
                                    <a href="#" class="btn btn-outline-success btn-sm">Manage</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="las la-tshirt fa-3x text-info mb-3"></i>
                                    <h5>Dress Types</h5>
                                    <p class="text-muted">Manage dress types and pricing</p>
                                    <a href="#" class="btn btn-outline-info btn-sm">Manage</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="las la-tasks fa-3x text-warning mb-3"></i>
                                    <h5>Assignment Status</h5>
                                    <p class="text-muted">Tailor assignment statuses</p>
                                    <a href="#" class="btn btn-outline-warning btn-sm">Manage</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Backup Modal -->
    <div class="modal fade" id="backupModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Database Backup</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="backupForm">
                        <div class="form-group">
                            <label>Backup Type</label>
                            <select class="form-control" id="backupType">
                                <option value="full">Full Backup (Database + Files)</option>
                                <option value="database">Database Only</option>
                                <option value="files">Files Only</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Compression</label>
                            <select class="form-control" id="compressionType">
                                <option value="zip">ZIP Compression</option>
                                <option value="gzip">GZIP Compression</option>
                                <option value="none">No Compression</option>
                            </select>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="emailBackup">
                            <label class="form-check-label" for="emailBackup">Email backup to admin</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="createBackup()">
                        <i class="las la-download mr-1"></i> Create Backup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- System Info Modal -->
    <div class="modal fade" id="systemInfoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">System Information</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">Application Name</th>
                                <td>Tailor Shop Management System</td>
                            </tr>
                            <tr>
                                <th>Version</th>
                                <td>v1.0.0</td>
                            </tr>
                            <tr>
                                <th>Laravel Version</th>
                                <td>{{ app()->version() }}</td>
                            </tr>
                            <tr>
                                <th>PHP Version</th>
                                <td>{{ phpversion() }}</td>
                            </tr>
                            <tr>
                                <th>Database</th>
                                <td>{{ config('database.default') }}</td>
                            </tr>
                            <tr>
                                <th>Environment</th>
                                <td>{{ app()->environment() }}</td>
                            </tr>
                            <tr>
                                <th>Debug Mode</th>
                                <td>{{ config('app.debug') ? 'Enabled' : 'Disabled' }}</td>
                            </tr>
                            <tr>
                                <th>Timezone</th>
                                <td>{{ config('app.timezone') }}</td>
                            </tr>
                            <tr>
                                <th>Server Software</th>
                                <td>{{ $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Maintenance Modal -->
    <div class="modal fade" id="maintenanceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Maintenance Mode</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="maintenanceForm">
                        <div class="form-group">
                            <label>Maintenance Message</label>
                            <textarea class="form-control" rows="3" id="maintenanceMessage">System is currently under maintenance. Please try again later.</textarea>
                        </div>
                        <div class="form-group">
                            <label>Allowed IPs (comma separated)</label>
                            <input type="text" class="form-control" id="allowedIPs" placeholder="192.168.1.1, 127.0.0.1">
                            <small class="text-muted">Leave empty to allow all IPs (not recommended)</small>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="enableMaintenance">
                            <label class="form-check-label" for="enableMaintenance">Enable Maintenance Mode</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning" onclick="toggleMaintenance()">
                        <i class="las la-power-off mr-1"></i> Toggle Maintenance
                    </button>
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
            // Initialize dropdowns and other components
            $('.dropdown-toggle').dropdown();
            
            // Modal handling
            $('.modal').on('shown.bs.modal', function () {
                $(this).find('.form-control:first').focus();
            });
        });
        
        function refreshLogs() {
            alert('Refreshing activity logs...');
            // In real app: AJAX call to refresh logs
            setTimeout(() => {
                alert('Activity logs refreshed successfully!');
            }, 1000);
        }
        
        function clearCache() {
            if (confirm('Are you sure you want to clear all cache? This may improve performance.')) {
                alert('Clearing cache...');
                // In real app: AJAX call to clear cache
                setTimeout(() => {
                    alert('Cache cleared successfully!');
                }, 1500);
            }
        }
        
        function optimizeDatabase() {
            if (confirm('Optimize database tables? This can improve performance.')) {
                alert('Optimizing database...');
                // In real app: AJAX call to optimize database
                setTimeout(() => {
                    alert('Database optimized successfully!');
                }, 2000);
            }
        }
        
        function generateSystemReport() {
            alert('Generating system report...');
            // In real app: Generate and download report
            setTimeout(() => {
                alert('System report generated successfully!');
            }, 1500);
        }
        
        function createBackup() {
            const backupType = $('#backupType').val();
            const compressionType = $('#compressionType').val();
            const emailBackup = $('#emailBackup').prop('checked');
            
            alert('Creating ' + backupType + ' backup with ' + compressionType + ' compression... ' + (emailBackup ? '(Will email to admin)' : ''));
            // In real app: AJAX call to create backup
            $('#backupModal').modal('hide');
            
            setTimeout(() => {
                alert('Backup created successfully!');
            }, 2000);
        }
        
        function toggleMaintenance() {
            const enable = $('#enableMaintenance').prop('checked');
            const message = $('#maintenanceMessage').val();
            const allowedIPs = $('#allowedIPs').val();
            
            if (enable && !message.trim()) {
                alert('Please enter a maintenance message');
                return;
            }
            
            alert((enable ? 'Enabling' : 'Disabling') + ' maintenance mode...\nMessage: ' + message + (allowedIPs ? '\nAllowed IPs: ' + allowedIPs : ''));
            // In real app: AJAX call to toggle maintenance mode
            $('#maintenanceModal').modal('hide');
            
            setTimeout(() => {
                alert('Maintenance mode ' + (enable ? 'enabled' : 'disabled') + ' successfully!');
            }, 1500);
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
        .timeline {
            position: relative;
            padding-left: 2rem;
        }
        .timeline-item {
            position: relative;
            padding-bottom: 1rem;
        }
        .timeline-marker {
            position: absolute;
            left: -2rem;
            top: 0;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            background-color: #007bff;
        }
        .timeline-content {
            padding-left: 1rem;
        }
        .btn {
            border-radius: 0.375rem;
        }
        .modal-content {
            border-radius: 0.5rem;
            border: none;
        }
        .close {
            font-size: 1.5rem;
            font-weight: 300;
        }
        .dropdown-menu {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border: none;
            border-radius: 0.5rem;
        }
        .badge {
            font-size: 0.75em;
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
        .d-grid.gap-2 {
            gap: 0.5rem !important;
        }
        .table-borderless th {
            font-weight: 600;
            color: #6c757d;
        }
        .modal-body .card {
            transition: all 0.3s ease;
        }
        .modal-body .card:hover {
            transform: scale(1.05);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .fa-3x {
            font-size: 3rem;
        }
    </style>
    @endpush
</x-app-layout>