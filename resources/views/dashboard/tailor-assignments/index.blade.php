resources\views\dashboard\tailor-assignments\index.blade.php
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
                <h4 class="mb-3">Tailor Assignments</h4>
                <p class="mb-0">Manage and track assignments to tailors</p>
            </div>
            <div>
                <a href="{{ route('tailors.index') }}" class="btn btn-outline-secondary mr-2">
                    <i class="las la-arrow-left"></i> Tailors
                </a>
                <button class="btn btn-primary" onclick="assignNewOrder()">
                    <i class="las la-plus-circle mr-1"></i> New Assignment
                </button>
            </div>
        </div>

        <!-- Assignment Stats -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Active Assignments</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">42</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2">15 tailors</span>
                                    <span>working</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-tasks fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Due Today</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-danger mr-2"><i class="las la-clock"></i> </span>
                                    <span>Urgent</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-exclamation-circle fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    In Progress</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">24</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-info mr-2">57%</span>
                                    <span>of total</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-spinner fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Completed Today</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 20%</span>
                                    <span>from yesterday</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Actions -->
        <div class="card shadow mb-4">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <input type="text" class="form-control" placeholder="Search assignments..." id="assignmentSearch">
                    </div>
                    <div class="col-md-9">
                        <div class="d-flex justify-content-end flex-wrap">
                            <div class="mr-3 mb-2">
                                <select class="form-control form-control-sm" id="filterStatus">
                                    <option value="">All Status</option>
                                    <option value="assigned">Assigned</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="delayed">Delayed</option>
                                </select>
                            </div>
                            <div class="mr-3 mb-2">
                                <select class="form-control form-control-sm" id="filterTailor">
                                    <option value="">All Tailors</option>
                                    @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">Tailor {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mr-3 mb-2">
                                <input type="text" class="form-control form-control-sm" id="dateRange" placeholder="Date Range">
                            </div>
                            <div class="mb-2">
                                <button class="btn btn-sm btn-outline-secondary" onclick="exportAssignments()">
                                    <i class="las la-download"></i> Export
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assignments Table -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Assignments List</h6>
                <div>
                    <button class="btn btn-sm btn-outline-warning mr-2" onclick="sendReminders()">
                        <i class="las la-bell"></i> Send Reminders
                    </button>
                    <button class="btn btn-sm btn-outline-success" onclick="bulkUpdate()">
                        <i class="las la-sync-alt"></i> Bulk Update
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="assignmentsTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="50">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>Assignment #</th>
                                <th>Order</th>
                                <th>Tailor</th>
                                <th>Assigned Date</th>
                                <th>Expected Date</th>
                                <th>Status</th>
                                <th>Progress</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 1; $i <= 12; $i++)
                            @php
                                $statuses = [
                                    ['text' => 'Assigned', 'color' => 'primary'],
                                    ['text' => 'In Progress', 'color' => 'info'],
                                    ['text' => 'Completed', 'color' => 'success'],
                                    ['text' => 'Delayed', 'color' => 'danger']
                                ];
                                $status = $statuses[$i % 4];
                                $progress = rand(20, 95);
                                $assignedDate = now()->subDays(rand(1, 10));
                                $expectedDate = $assignedDate->copy()->addDays(rand(3, 7));
                                $amount = rand(800, 2500);
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" class="assignmentCheckbox" value="{{ $i }}">
                                </td>
                                <td>A-00{{ 100 + $i }}</td>
                                <td>
                                    <div class="font-weight-bold">TS-001{{ 20 + $i }}</div>
                                    <small class="text-muted">Customer {{ $i }}</small>
                                    <div class="small">Sherwani</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm mr-2">
                                            <span class="avatar-title rounded-circle bg-info text-white">
                                                T{{ $i % 5 + 1 }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">Tailor {{ $i % 5 + 1 }}</div>
                                            {{-- Undefined variable $specializations <small class="text-muted">{{ $specializations[($i % 5 + 1) % 6] }}</small> --}}
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $assignedDate->format('d M, Y') }}</td>
                                <td>
                                    @if($expectedDate->isPast())
                                    <span class="badge badge-danger">{{ $expectedDate->format('d M') }}</span>
                                    @elseif($expectedDate->diffInDays() <= 1)
                                    <span class="badge badge-warning">{{ $expectedDate->format('d M') }}</span>
                                    @else
                                    <span class="text-muted">{{ $expectedDate->format('d M') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $status['color'] }}">{{ $status['text'] }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar bg-{{ $progress > 80 ? 'success' : ($progress > 50 ? 'info' : 'warning') }}" 
                                                 style="width: {{ $progress }}%">
                                            </div>
                                        </div>
                                        <div class="ml-2 small">{{ $progress }}%</div>
                                    </div>
                                </td>
                                <td class="font-weight-bold text-success">
                                    ₹ {{ number_format($amount) }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-info" onclick="updateProgress({{ $i }})">
                                            <i class="las la-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewDetails({{ $i }})">
                                            <i class="las la-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" onclick="markComplete({{ $i }})" {{ $status['text'] == 'Completed' ? 'disabled' : '' }}>
                                            <i class="las la-check"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Upcoming Deadlines -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">Upcoming Deadlines</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @for($i = 1; $i <= 4; $i++)
                            <div class="col-md-3 mb-3">
                                <div class="card border-left-{{ $i == 1 ? 'danger' : 'warning' }} h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="font-weight-bold text-{{ $i == 1 ? 'danger' : 'warning' }}">
                                                    {{ now()->addDays($i)->format('d M') }}
                                                </div>
                                                <div class="small text-muted">{{ $i == 1 ? 'Tomorrow' : 'In ' . $i . ' days' }}</div>
                                            </div>
                                            <div class="text-right">
                                                <div class="h5 mb-0">{{ rand(2, 5) }}</div>
                                                <div class="small text-muted">assignments</div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <div class="progress" style="height: 5px;">
                                                <div class="progress-bar bg-{{ $i == 1 ? 'danger' : 'warning' }}" style="width: {{ rand(60, 90) }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Progress Modal -->
    <div class="modal fade" id="progressModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Assignment Progress</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="progressForm">
                        <div class="form-group">
                            <label>Progress Percentage</label>
                            <input type="range" class="form-control-range" min="0" max="100" value="50" id="progressRange">
                            <div class="text-center mt-2">
                                <span id="progressValue" class="h4 font-weight-bold text-primary">50%</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" id="updateStatus">
                                <option value="assigned">Assigned</option>
                                <option value="in_progress" selected>In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="delayed">Delayed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Notes</label>
                            <textarea class="form-control" id="progressNotes" rows="3" placeholder="Add progress notes..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveProgress()">
                        <i class="las la-save mr-1"></i> Update
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>

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
            // Initialize DataTable
            var table = $('#assignmentsTable').DataTable({
                pageLength: 10,
                order: [[5, 'asc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search assignments..."
                }
            });
            
            // Custom search
            $('#assignmentSearch').on('keyup', function() {
                table.search(this.value).draw();
            });
            
            // Filter by status
            $('#filterStatus').change(function() {
                table.column(6).search(this.value).draw();
            });
            
            // Filter by tailor
            $('#filterTailor').change(function() {
                // Custom filtering for tailor column
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        const tailorFilter = $('#filterTailor').val();
                        if (!tailorFilter) return true;
                        
                        const tailorCell = data[3]; // Tailor column
                        return tailorCell.includes('Tailor ' + tailorFilter);
                    }
                );
                table.draw();
                $.fn.dataTable.ext.search.pop();
            });
            
            // Date range picker
            $('#dateRange').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')]
                },
                startDate: moment().subtract(30, 'days'),
                endDate: moment()
            });
            
            // Select all checkbox
            $('#selectAll').click(function() {
                $('.assignmentCheckbox').prop('checked', this.checked);
            });
            
            // Progress range update
            $('#progressRange').on('input', function() {
                $('#progressValue').text($(this).val() + '%');
            });
        });
        
        function assignNewOrder() {
            alert('Opening new assignment form...');
            // In real app: Open assignment modal
        }
        
        function updateProgress(assignmentId) {
            $('#progressModal').modal('show');
            // In real app: Load assignment details
        }
        
        function saveProgress() {
            alert('Progress updated successfully!');
            $('#progressModal').modal('hide');
        }
        
        function viewDetails(assignmentId) {
            alert('Viewing assignment #' + assignmentId + ' details...');
            // In real app: Open details modal or page
        }
        
        function markComplete(assignmentId) {
            if (confirm('Mark this assignment as completed?')) {
                alert('Assignment marked as completed!');
                // In real app: AJAX call to update status
            }
        }
        
        function sendReminders() {
            const selected = $('.assignmentCheckbox:checked');
            if (selected.length === 0) {
                alert('Please select assignments to send reminders');
                return;
            }
            alert('Sending reminders for ' + selected.length + ' assignments...');
        }
        
        function bulkUpdate() {
            const selected = $('.assignmentCheckbox:checked');
            if (selected.length === 0) {
                alert('Please select assignments to update');
                return;
            }
            alert('Opening bulk update for ' + selected.length + ' assignments...');
        }
        
        function exportAssignments() {
            alert('Exporting assignments data...');
            // In real app: Generate and download export
        }
    </script>
    @endpush
</x-app-layout>