<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/select2/css/select2.min.css') }}">
    @endpush

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-3">Customer Profile</h4>
                <p class="mb-0">View and manage customer details</p>
            </div>
            <div>
                <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary mr-2">
                    <i class="las la-arrow-left mr-1"></i> Back to Customers
                </a>
                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary">
                    <i class="las la-edit mr-1"></i> Edit Profile
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Customer Info Column -->
            <div class="col-lg-4">
                <!-- Customer Card -->
                <div class="card shadow mb-4">
                    <div class="card-body text-center p-4">
                        <div class="avatar-upload mb-3">
                            <div class="avatar-preview mb-3">
                                <div style="width: 150px; height: 150px; margin: 0 auto; border-radius: 50%; background-color: #3b82f6; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
                                   @if(!empty($customer->profile_photo) && file_exists(public_path('backend/'.$customer->profile_photo)))
                                        <img src="{{ asset('backend/'.$customer->profile_photo) }}"
                                            class="rounded-circle"
                                            alt="{{ $customer->name }}"
                                            width="150"
                                            height="150">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=3B82F6&color=fff&size=40" 
                                        class="rounded-circle" 
                                        alt="{{ $customer->name }}">

                                    @endif
                                </div>
                            </div>
                            <div class="text-center">
                                <h3 class="mb-1">{{ $customer->name }}</h3>
                                <p class="text-muted mb-2">ID: CUS-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</p>
                                
                                <div class="mb-3">
                                    <p class="mb-1"><i class="las la-phone mr-2"></i> {{ $customer->phone }}</p>
                                    @if($customer->email)
                                        <p class="mb-1"><i class="las la-envelope mr-2"></i> {{ $customer->email }}</p>
                                    @endif
                                    @if($customer->address)
                                        <p class="mb-1"><i class="las la-map-marker mr-2"></i> {{ Str::limit($customer->address, 50) }}</p>
                                    @endif
                                    <p class="mb-1"><i class="las la-store mr-2"></i> {{ $customer->branch->name ?? 'No Branch' }}</p>
                                </div>
                                
                                @if($customer->reference)
                                    <div class="badge badge-info mb-2">Reference: {{ $customer->reference }}</div>
                                @endif
                                
                                <div class="mt-3">
                                    <span class="badge {{ $customer->orders()->count() > 5 ? 'badge-success' : ($customer->orders()->count() > 0 ? 'badge-info' : 'badge-secondary') }}">
                                        @if($customer->orders()->count() > 5)
                                            VIP Customer
                                        @elseif($customer->orders()->count() > 0)
                                            Regular Customer
                                        @else
                                            New Customer
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Customer Statistics</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="display-4 font-weight-bold text-primary">{{ $stats['total_orders'] }}</div>
                                <small class="text-muted">Total Orders</small>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="display-4 font-weight-bold text-success">Rs {{ number_format($stats['total_spent'], 0) }}</div>
                                <small class="text-muted">Total Spent</small>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="display-4 font-weight-bold text-info">Rs {{ number_format($stats['avg_order_value'], 0) }}</div>
                                <small class="text-muted">Avg. Order Value</small>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="display-4 font-weight-bold text-warning">{{ $stats['pending_orders'] }}</div>
                                <small class="text-muted">Pending Orders</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('orders.create') }}?customer={{ $customer->id }}" class="btn btn-success btn-block">
                                <i class="las la-plus-circle mr-2"></i> New Order
                            </a>
                            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary btn-block">
                                <i class="las la-edit mr-2"></i> Edit Profile
                            </a>
                            <button class="btn btn-info btn-block" onclick="sendMessage()">
                                <i class="las la-envelope mr-2"></i> Send Message
                            </button>
                            <a href="#" class="btn btn-outline-secondary btn-block" onclick="printProfile()">
                                <i class="las la-print mr-2"></i> Print Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Column -->
            <div class="col-lg-8">
                <!-- Tabs -->
                <div class="card shadow">
                    <div class="card-header border-bottom-0">
                        <ul class="nav nav-tabs" id="customerTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview">
                                    <i class="las la-info-circle mr-1"></i> Overview
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders">
                                    <i class="las la-shopping-cart mr-1"></i> Orders ({{ $customer->orders()->count() }})
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="measurements-tab" data-toggle="tab" href="#measurements">
                                    <i class="las la-ruler mr-1"></i> Measurements
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes">
                                    <i class="las la-sticky-note mr-1"></i> Notes
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="customerTabsContent">
                            <!-- Overview Tab -->
                            <div class="tab-pane fade show active" id="overview">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3 text-muted">Contact Information</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="120"><strong>Phone:</strong></td>
                                                <td>{{ $customer->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email:</strong></td>
                                                <td>{{ $customer->email ?? 'Not provided' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Address:</strong></td>
                                                <td>{{ $customer->address ?? 'Not provided' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Reference:</strong></td>
                                                <td>{{ $customer->reference ?? 'Not specified' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3 text-muted">Account Information</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="120"><strong>Branch:</strong></td>
                                                <td>{{ $customer->branch->name ?? 'No Branch' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Member Since:</strong></td>
                                                <td>{{ $customer->created_at->format('d M, Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Last Updated:</strong></td>
                                                <td>{{ $customer->updated_at->format('d M, Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Last Order:</strong></td>
                                                <td>
                                                    @if($stats['last_order'])
                                                        {{ $stats['last_order']->order_date->format('d M, Y') }}
                                                    @else
                                                        No orders yet
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                @if($customer->notes)
                                <div class="mt-4">
                                    <h6 class="mb-3 text-muted">Customer Notes</h6>
                                    <div class="bg-light p-3 rounded">
                                        {{ $customer->notes }}
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Orders Tab -->
                            <div class="tab-pane fade" id="orders">
                                @if($customer->orders()->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Order #</th>
                                                    <th>Date</th>
                                                    <th>Items</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Payment</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($customer->orders as $order)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $order->order_number }}</strong>
                                                    </td>
                                                    <td>{{ $order->order_date->format('d M, Y') }}</td>
                                                    <td>{{ $order->items->count() }} items</td>
                                                    <td class="font-weight-bold text-success">Rs {{ number_format($order->final_amount, 2) }}</td>
                                                    <td>
                                                        <span class="badge" style="background-color: {{ $order->status->color }}; color: white;">
                                                            {{ $order->status->name }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge" style="background-color: {{ $order->paymentStatus->color }}; color: white;">
                                                            {{ $order->paymentStatus->name }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                                            <i class="las la-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="las la-shopping-cart fa-3x text-muted mb-3"></i>
                                        <h5>No Orders Yet</h5>
                                        <p class="text-muted">This customer hasn't placed any orders yet.</p>
                                        <a href="{{ route('orders.create') }}?customer={{ $customer->id }}" class="btn btn-primary">
                                            <i class="las la-plus-circle mr-1"></i> Create First Order
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <!-- Measurements Tab -->
                            <div class="tab-pane fade" id="measurements">
                                @if($customer->measurementTemplates()->count() > 0)
                                    <div class="row">
                                        @foreach($customer->measurementTemplates as $template)
                                        <div class="col-md-6 mb-4">
                                            <div class="card border">
                                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0">{{ $template->template_name }}</h6>
                                                    @if($template->is_default)
                                                        <span class="badge badge-success">Default</span>
                                                    @endif
                                                </div>
                                                <div class="card-body">
                                                    <p class="text-muted mb-2"><small>{{ $template->dressType->name ?? 'General' }}</small></p>
                                                    <div class="row">
                                                        @foreach(json_decode($template->measurements, true) as $key => $value)
                                                            @if(!is_null($value))
                                                            <div class="col-6 mb-2">
                                                                <small class="text-muted d-block">{{ ucfirst(str_replace('_', ' ', $key)) }}</small>
                                                                <strong>{{ $value }} cm</strong>
                                                            </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    @if($template->notes)
                                                        <div class="mt-2">
                                                            <small class="text-muted">Notes:</small>
                                                            <p class="mb-0">{{ $template->notes }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="las la-ruler fa-3x text-muted mb-3"></i>
                                        <h5>No Measurement Templates</h5>
                                        <p class="text-muted">No measurement templates saved for this customer.</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Notes Tab -->
                            <div class="tab-pane fade" id="notes">
                                <div class="mb-3">
                                    <textarea class="form-control" rows="4" placeholder="Add a note about this customer..."></textarea>
                                    <button class="btn btn-primary mt-2">Add Note</button>
                                </div>
                                
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-primary"></div>
                                        <div class="timeline-content">
                                            <div class="d-flex justify-content-between">
                                                <strong>Customer Created</strong>
                                                <small class="text-muted">{{ $customer->created_at->format('d M, Y h:i A') }}</small>
                                            </div>
                                            <p class="mb-0">Customer profile was created by system</p>
                                        </div>
                                    </div>
                                    
                                    @if($customer->notes)
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-info"></div>
                                        <div class="timeline-content">
                                            <div class="d-flex justify-content-between">
                                                <strong>Customer Notes</strong>
                                                <small class="text-muted">Added on creation</small>
                                            </div>
                                            <p class="mb-0">{{ $customer->notes }}</p>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @foreach($customer->orders as $order)
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-success"></div>
                                        <div class="timeline-content">
                                            <div class="d-flex justify-content-between">
                                                <strong>New Order: {{ $order->order_number }}</strong>
                                                <small class="text-muted">{{ $order->created_at->format('d M, Y h:i A') }}</small>
                                            </div>
                                            <p class="mb-0">Order placed for Rs {{ number_format($order->final_amount, 2) }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/select2/js/select2.min.js') }}"></script>

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
            // Initialize DataTable for orders
            $('table').DataTable({
                pageLength: 10,
                responsive: true
            });
            
            // Tab activation
            $('#customerTabs a').on('click', function (e) {
                e.preventDefault();
                $(this).tab('show');
            });
        });
        
        function sendMessage() {
            alert('Opening message composer for {{ $customer->phone }}');
            // In real app: Open SMS or email composer
        }
        
        function printProfile() {
            window.print();
        }
    </script>
    
    <style>
        .card {
            border-radius: 0.5rem;
        }
        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            border-bottom: 2px solid transparent;
        }
        .nav-tabs .nav-link.active {
            color: #3b82f6;
            border-bottom: 2px solid #3b82f6;
            background: transparent;
        }
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
            left: -2rem;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            background: #6c757d;
        }
        .timeline-content {
            padding-left: 1rem;
        }
        .badge {
            font-size: 0.75em;
            font-weight: 500;
        }
    </style>

    @endpush
</x-app-layout>