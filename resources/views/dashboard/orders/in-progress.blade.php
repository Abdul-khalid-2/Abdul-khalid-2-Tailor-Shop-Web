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
                <h4 class="mb-3">Orders In Progress</h4>
                <p class="mb-0">Orders currently being worked on by tailors</p>
            </div>
            <div>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary mr-2">
                    <i class="las la-arrow-left"></i> All Orders
                </a>
                <button class="btn btn-info" onclick="updateProgress()">
                    <i class="las la-sync-alt"></i> Update Progress
                </button>
            </div>
        </div>

        <!-- Progress Status Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Cutting Stage</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">6</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-cut fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    Stitching Stage</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-tshirt fa-2x text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Finishing Stage</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">4</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-magic fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Behind Schedule</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-exclamation-triangle fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-info">In Progress Orders</h6>
                <div>
                    <button class="btn btn-sm btn-outline-info mr-2" onclick="generateProgressReport()">
                        <i class="las la-file-download"></i> Progress Report
                    </button>
                    <button class="btn btn-sm btn-outline-success" onclick="markMultipleReady()">
                        <i class="las la-check-double"></i> Mark as Ready
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="progressOrdersTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Dress Type</th>
                                <th>Tailor</th>
                                <th>Stage</th>
                                <th>Progress</th>
                                <th>Start Date</th>
                                <th>Expected</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 1; $i <= 10; $i++)
                            @php
                                $stages = [
                                    ['name' => 'Cutting', 'color' => 'primary', 'progress' => rand(20, 40)],
                                    ['name' => 'Stitching', 'color' => 'secondary', 'progress' => rand(50, 80)],
                                    ['name' => 'Finishing', 'color' => 'info', 'progress' => rand(85, 95)]
                                ];
                                $stage = $stages[$i % 3];
                                $expectedDays = rand(1, 5);
                            @endphp
                            <tr>
                                <td>TS-00{{ 140 + $i }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm mr-2">
                                            <span class="avatar-title rounded-circle bg-success text-white">
                                                C{{ $i }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">Customer {{ $i }}</div>
                                            <small class="text-muted">Due: {{ now()->addDays($expectedDays)->format('d M') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php $types = ['Sherwani', 'Suit', 'Kurta', 'Gown']; @endphp
                                    {{ $types[$i % 4] }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xs mr-2">
                                            <span class="avatar-title rounded-circle bg-warning text-white">
                                                T{{ $i }}
                                            </span>
                                        </div>
                                        <div>
                                            <div>Tailor {{ $i }}</div>
                                            <small class="text-muted">{{ $stage['progress'] }}% done</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $stage['color'] }}">{{ $stage['name'] }}</span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-{{ $stage['color'] }}" 
                                             role="progressbar" 
                                             style="width: {{ $stage['progress'] }}%">
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $stage['progress'] }}% complete</small>
                                </td>
                                <td>{{ now()->subDays(rand(1, 7))->format('d M') }}</td>
                                <td>
                                    @if($expectedDays <= 2)
                                    <span class="badge badge-success">{{ $expectedDays }} days</span>
                                    @elseif($expectedDays <= 4)
                                    <span class="badge badge-warning">{{ $expectedDays }} days</span>
                                    @else
                                    <span class="badge badge-danger">{{ $expectedDays }} days</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-info" onclick="updateOrderProgress({{ $i }})">
                                            <i class="las la-edit"></i> Update
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" onclick="markOrderReady({{ $i }})">
                                            <i class="las la-check"></i> Ready
                                        </button>
                                        <a href="{{ route('orders.show', ['id' => $i]) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="las la-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Progress Modal -->
    <div class="modal fade" id="progressModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Order Progress</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="progressForm">
                        <div class="form-group">
                            <label>Select Stage</label>
                            <select class="form-control" id="progressStage">
                                <option value="cutting">Cutting</option>
                                <option value="stitching">Stitching</option>
                                <option value="finishing">Finishing</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Progress Percentage</label>
                            <input type="range" class="form-control-range" min="0" max="100" id="progressRange">
                            <div class="text-center">
                                <span id="progressValue" class="font-weight-bold">50%</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Notes</label>
                            <textarea class="form-control" id="progressNotes" rows="3" placeholder="Add progress notes..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveProgress()">Save Progress</button>
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
            $('#progressOrdersTable').DataTable({
                pageLength: 10,
                order: [[6, 'desc']]
            });
            
            // Progress range update
            $('#progressRange').on('input', function() {
                $('#progressValue').text($(this).val() + '%');
            });
        });
        
        function updateProgress() {
            alert('Updating progress for all orders...');
            // In real app: AJAX call to refresh progress
        }
        
        function updateOrderProgress(orderId) {
            $('#progressModal').modal('show');
            // In real app: Load order details
        }
        
        function saveProgress() {
            alert('Progress updated successfully!');
            $('#progressModal').modal('hide');
        }
        
        function markOrderReady(orderId) {
            if (confirm('Mark this order as Ready for Delivery?')) {
                alert('Order marked as Ready!');
                // In real app: AJAX call to update status
            }
        }
        
        function markMultipleReady() {
            alert('Marking multiple orders as ready...');
            // In real app: Show selection modal
        }
        
        function generateProgressReport() {
            alert('Generating progress report...');
            // In real app: Generate and download report
        }
    </script>
    @endpush
</x-app-layout>