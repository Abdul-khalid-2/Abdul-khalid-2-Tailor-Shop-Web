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
                <h4 class="mb-3">Order Details</h4>
                <p class="mb-0">View complete order information</p>
            </div>
            <div class="d-flex">
                <a href="{{ route('orders.edit', ['id' => $id]) }}" class="btn btn-outline-info mr-2">
                    <i class="las la-edit"></i> Edit Order
                </a>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left"></i> Back to Orders
                </a>
            </div>
        </div>

        <!-- Order Header Card -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center mb-3">
                            <h4 class="mb-0 mr-3">Order #TS-{{ str_pad($id, 4, '0', STR_PAD_LEFT) }}</h4>
                            <span class="badge badge-warning">Pending</span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <small class="text-muted">Order Date</small>
                                    <div class="font-weight-bold">{{ now()->subDays($id)->format('d M, Y') }}</div>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Delivery Date</small>
                                    <div class="font-weight-bold">{{ now()->addDays($id + 3)->format('d M, Y') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <small class="text-muted">Customer</small>
                                    <div class="font-weight-bold">Customer {{ $id }}</div>
                                    <small class="text-muted">+92 300 123456{{ $id }}</small>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Branch</small>
                                    <div class="font-weight-bold">Main Branch</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Amount:</span>
                                <span class="font-weight-bold text-primary">Rs {{ number_format(5000 + ($id * 1500)) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Advance Paid:</span>
                                <span class="font-weight-bold text-success">Rs {{ number_format(2000 + ($id * 500)) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Balance Due:</span>
                                <span class="font-weight-bold text-danger">Rs {{ number_format(3000 + ($id * 1000)) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Payment Status:</span>
                                <span class="badge badge-warning">Partial</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details Tabs -->
        <div class="card shadow">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="orderTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="items-tab" data-toggle="tab" href="#items">
                            <i class="las la-tshirt mr-1"></i> Order Items
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="measurements-tab" data-toggle="tab" href="#measurements">
                            <i class="las la-ruler-combined mr-1"></i> Measurements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="fabrics-tab" data-toggle="tab" href="#fabrics">
                            <i class="las la-layer-group mr-1"></i> Fabrics
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tailor-tab" data-toggle="tab" href="#tailor">
                            <i class="las la-user-secret mr-1"></i> Tailor Assignment
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="payments-tab" data-toggle="tab" href="#payments">
                            <i class="las la-rupee-sign mr-1"></i> Payments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="history-tab" data-toggle="tab" href="#history">
                            <i class="las la-history mr-1"></i> Order History
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="orderTabsContent">
                    <!-- Order Items Tab -->
                    <div class="tab-pane fade show active" id="items" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Dress Type</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $dressTypes = ['Sherwani', 'Suit', 'Kurta', 'Shalwar Kameez', 'Gown', 'Lehenga'];
                                    $itemStatus = ['pending', 'cutting', 'stitching', 'ready', 'delivered'];
                                    $statusColors = ['warning', 'primary', 'secondary', 'success', 'dark'];
                                    @endphp
                                    @for($i = 1; $i <= 2; $i++)
                                        <tr>
                                        <td>{{ $i }}</td>
                                        <td class="font-weight-bold">{{ $dressTypes[($id + $i) % 6] }}</td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $i == 1 ? 'Embroidered silk sherwani with heavy work' : 'Formal business suit with 2-piece design' }}
                                            </small>
                                        </td>
                                        <td>1</td>
                                        <td>Rs {{ number_format(3000 + ($i * 1000)) }}</td>
                                        <td class="font-weight-bold">Rs {{ number_format(3000 + ($i * 1000)) }}</td>
                                        <td>
                                            @php $statusIndex = ($i % 5); @endphp
                                            <span class="badge badge-{{ $statusColors[$statusIndex] }}">
                                                {{ ucfirst($itemStatus[$statusIndex]) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewItemDetails({{ $i }})">
                                                <i class="las la-eye"></i>
                                            </button>
                                        </td>
                                        </tr>
                                        @endfor
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-right font-weight-bold">Subtotal:</td>
                                        <td class="font-weight-bold">Rs {{ number_format(6000 + ($id * 1500)) }}</td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right font-weight-bold">Fabric Cost:</td>
                                        <td class="font-weight-bold">Rs {{ number_format(1500) }}</td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right font-weight-bold">Stitching Charges:</td>
                                        <td class="font-weight-bold">Rs {{ number_format(1000) }}</td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right font-weight-bold">Total:</td>
                                        <td class="font-weight-bold text-primary">Rs {{ number_format(8500 + ($id * 1500)) }}</td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Measurements Tab -->
                    <div class="tab-pane fade" id="measurements" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Body Measurements (in cm)</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted">Height</label>
                                                <div class="font-weight-bold">170 cm</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted">Chest</label>
                                                <div class="font-weight-bold">42 cm</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted">Waist</label>
                                                <div class="font-weight-bold">38 cm</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted">Hips</label>
                                                <div class="font-weight-bold">44 cm</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted">Shoulder</label>
                                                <div class="font-weight-bold">18 cm</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted">Sleeve Length</label>
                                                <div class="font-weight-bold">60 cm</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Additional Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="text-muted">Fitting Preferences</label>
                                            <div class="font-weight-bold">Regular Fit, Slightly loose sleeves</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted">Special Instructions</label>
                                            <div>Extra pocket on inside, monogram on chest</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted">Measurement Taken By</label>
                                            <div class="font-weight-bold">Ali Ahmed</div>
                                            <small class="text-muted">On {{ now()->subDays(2)->format('d M, Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-outline-primary" onclick="updateMeasurements()">
                                <i class="las la-ruler-combined"></i> Update Measurements
                            </button>
                        </div>
                    </div>

                    <!-- Fabrics Tab -->
                    <div class="tab-pane fade" id="fabrics" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Fabric Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="text-muted">Fabric Type</label>
                                            <div class="font-weight-bold">Silk</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted">Color</label>
                                            <div class="font-weight-bold">Navy Blue</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted">Meter Required</label>
                                            <div class="font-weight-bold">3.5 m</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted">Rate per Meter</label>
                                            <div class="font-weight-bold">Rs 800</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted">Total Fabric Cost</label>
                                            <div class="font-weight-bold text-primary">Rs 2,800</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Fabric Status</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="text-muted">Current Status</label>
                                            <span class="badge badge-success">Received</span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted">Supplier</label>
                                            <div class="font-weight-bold">Silk Emporium</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted">Ordered Date</label>
                                            <div>{{ now()->subDays(5)->format('d M, Y') }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted">Received Date</label>
                                            <div>{{ now()->subDays(3)->format('d M, Y') }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted">Cutting Date</label>
                                            <div>{{ now()->subDays(1)->format('d M, Y') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tailor Assignment Tab -->
                    <div class="tab-pane fade" id="tailor" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Assigned Tailor</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar avatar-xl mr-3">
                                                <span class="avatar-title rounded-circle bg-primary text-white">
                                                    TA
                                                </span>
                                            </div>
                                            <div>
                                                <h5 class="mb-1">Tailor Ali</h5>
                                                <small class="text-muted">Sherwani Specialist</small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted">Phone</label>
                                                <div>+92 300 9876543</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted">Experience</label>
                                                <div>5 years</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted">Assigned Date</label>
                                                <div>{{ now()->subDays(2)->format('d M, Y') }}</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted">Expected Date</label>
                                                <div>{{ now()->addDays(3)->format('d M, Y') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Progress Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="text-muted">Current Stage</label>
                                            <span class="badge badge-primary">Cutting</span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted">Progress</label>
                                            <div class="progress mb-2">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 40%"></div>
                                            </div>
                                            <small class="text-muted">40% complete</small>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted">Stitching Charges</label>
                                            <div class="font-weight-bold">Rs 1,500</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted">Advance Paid to Tailor</label>
                                            <div class="font-weight-bold text-success">Rs 500</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted">Balance to Tailor</label>
                                            <div class="font-weight-bold text-danger">Rs 1,000</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="text-muted">Tailor Instructions</label>
                            <div class="bg-light p-3 rounded">
                                Please ensure perfect stitching on embroidery areas. Use double stitching on stress points. Add monogram on left chest pocket.
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-outline-primary mr-2" onclick="updateProgress()">
                                <i class="las la-sync-alt"></i> Update Progress
                            </button>
                            <button class="btn btn-outline-success" onclick="changeTailor()">
                                <i class="las la-user-plus"></i> Change Tailor
                            </button>
                        </div>
                    </div>

                    <!-- Payments Tab -->
                    <div class="tab-pane fade" id="payments" role="tabpanel">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Payment History</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Receipt #</th>
                                                        <th>Payment Method</th>
                                                        <th>Amount</th>
                                                        <th>Received By</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for($i = 1; $i <= 2; $i++)
                                                        <tr>
                                                        <td>{{ now()->subDays($i)->format('d M, Y') }}</td>
                                                        <td>REC-{{ str_pad($id * 10 + $i, 4, '0', STR_PAD_LEFT) }}</td>
                                                        <td>{{ $i == 1 ? 'Cash' : 'Bank Transfer' }}</td>
                                                        <td class="font-weight-bold text-success">Rs {{ number_format(1500 + ($i * 500)) }}</td>
                                                        <td>Staff {{ $i }}</td>
                                                        <td><span class="badge badge-success">Verified</span></td>
                                                        </tr>
                                                        @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Payment Summary</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="text-muted">Total Order Amount</label>
                                            <div class="font-weight-bold">Rs {{ number_format(8500 + ($id * 1500)) }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted">Total Paid</label>
                                            <div class="font-weight-bold text-success">Rs {{ number_format(2500) }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted">Balance Due</label>
                                            <div class="font-weight-bold text-danger">Rs {{ number_format(6000 + ($id * 1500)) }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted">Next Payment Due</label>
                                            <div class="font-weight-bold">{{ now()->addDays(2)->format('d M, Y') }}</div>
                                        </div>
                                        <hr>
                                        <button class="btn btn-primary btn-block" onclick="recordPayment()">
                                            <i class="las la-plus-circle"></i> Record New Payment
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order History Tab -->
                    <div class="tab-pane fade" id="history" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-success"></div>
                                        <div class="timeline-content">
                                            <div class="d-flex justify-content-between">
                                                <h6>Order Completed</h6>
                                                <small class="text-muted">Today, 10:30 AM</small>
                                            </div>
                                            <p>Order marked as delivered to customer</p>
                                            <small class="text-muted">By: Admin User</small>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-info"></div>
                                        <div class="timeline-content">
                                            <div class="d-flex justify-content-between">
                                                <h6>Progress Updated</h6>
                                                <small class="text-muted">Yesterday, 4:15 PM</small>
                                            </div>
                                            <p>Progress updated to 95% - Finishing stage</p>
                                            <small class="text-muted">By: Tailor Manager</small>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-primary"></div>
                                        <div class="timeline-content">
                                            <div class="d-flex justify-content-between">
                                                <h6>Tailor Assigned</h6>
                                                <small class="text-muted">3 days ago, 11:00 AM</small>
                                            </div>
                                            <p>Assigned to Tailor Ali for stitching</p>
                                            <small class="text-muted">By: Branch Manager</small>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-warning"></div>
                                        <div class="timeline-content">
                                            <div class="d-flex justify-content-between">
                                                <h6>Order Created</h6>
                                                <small class="text-muted">5 days ago, 2:30 PM</small>
                                            </div>
                                            <p>Order created with 2 items</p>
                                            <small class="text-muted">By: Sales Staff</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="card shadow mt-4">
            <div class="card-body text-center">
                <button class="btn btn-outline-primary mr-2" onclick="printOrder()">
                    <i class="las la-print"></i> Print Order
                </button>
                <button class="btn btn-outline-success mr-2" onclick="updateStatus()">
                    <i class="las la-sync-alt"></i> Update Status
                </button>
                <button class="btn btn-outline-info mr-2" onclick="sendNotification()">
                    <i class="las la-bell"></i> Notify Customer
                </button>
                <button class="btn btn-outline-danger" onclick="cancelOrder()">
                    <i class="las la-times-circle"></i> Cancel Order
                </button>
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
        function viewItemDetails(itemId) {
            alert('Viewing details for item #' + itemId);
            // In real app: Open item details modal
        }

        function updateMeasurements() {
            alert('Opening measurements update form');
            // In real app: window.location.href = `/orders/{{ $id }}/measurements/edit`;
        }

        function updateProgress() {
            alert('Opening progress update form');
            // In real app: Open progress update modal
        }

        function changeTailor() {
            alert('Opening tailor assignment form');
            // In real app: Open tailor assignment modal
        }

        function recordPayment() {
            alert('Opening payment recording form');
            // In real app: Open payment modal
        }

        function printOrder() {
            window.open('/orders/{{ $id }}/print', '_blank');
        }

        function updateStatus() {
            alert('Opening status update form');
            // In real app: Open status update modal
        }

        function sendNotification() {
            alert('Sending notification to customer');
            // In real app: AJAX call to send notification
        }

        function cancelOrder() {
            if (confirm('Are you sure you want to cancel this order?')) {
                alert('Order cancellation initiated');
                // In real app: AJAX call to cancel order
            }
        }
    </script>

    <style>
        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }

        .timeline-marker {
            position: absolute;
            left: -1.2rem;
            top: 0;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
        }

        .timeline-content {
            padding-left: 1rem;
        }
    </style>
    @endpush
</x-app-layout>