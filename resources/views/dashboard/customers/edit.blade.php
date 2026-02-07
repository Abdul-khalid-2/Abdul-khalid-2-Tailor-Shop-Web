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
                <h4 class="mb-3">Edit Customer: {{ $customer->name }}</h4>
                <p class="mb-0">Update customer profile information</p>
            </div>
            <div>
                <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left mr-1"></i> Back to Customers
                </a>
            </div>
        </div>

        <!-- Customer Form -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('customers.update', $customer->id) }}" method="POST" id="customerForm">
                            @csrf
                            @method('PUT')
                            
                            <!-- Basic Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Basic Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Full Name *</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                                placeholder="Enter customer name" value="{{ old('name', $customer->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Customer ID</label>
                                            <input type="text" class="form-control" value="CUS-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}" readonly>
                                            <small class="text-muted">Auto-generated</small>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Phone Number *</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">+92</span>
                                                </div>
                                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                                    placeholder="300 1234567" value="{{ old('phone', $customer->phone) }}" required>
                                            </div>
                                            @error('phone')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                                placeholder="customer@example.com" value="{{ old('email', $customer->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Branch *</label>
                                            <select name="branch_id" class="form-control select2 @error('branch_id') is-invalid @enderror" required>
                                                <option value="">Select Branch</option>
                                                @foreach($branches as $branch)
                                                    <option value="{{ $branch->id }}" {{ old('branch_id', $customer->branch_id) == $branch->id ? 'selected' : '' }}>
                                                        {{ $branch->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('branch_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Reference/Source</label>
                                            <input type="text" name="reference" class="form-control" 
                                                placeholder="How did they hear about us?" value="{{ old('reference', $customer->reference) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Details -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Contact Details</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                            rows="3" placeholder="Full address including city and area">{{ old('address', $customer->address) }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Additional Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Notes</label>
                                        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                                            rows="3" placeholder="Any special notes about this customer...">{{ old('notes', $customer->notes) }}</textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Created At</label>
                                            <input type="text" class="form-control" value="{{ $customer->created_at->format('d M, Y h:i A') }}" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Last Updated</label>
                                            <input type="text" class="form-control" value="{{ $customer->updated_at->format('d M, Y h:i A') }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-outline-secondary">
                                    <i class="las la-times"></i> Cancel
                                </a>
                                <div>
                                    <button type="button" class="btn btn-outline-danger mr-2" onclick="confirmDelete()">
                                        <i class="las la-trash"></i> Delete Customer
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="las la-check-circle"></i> Update Customer
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        <!-- Delete Form -->
                        <form id="deleteForm" action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Customer Summary -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Customer Summary</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="avatar-upload mb-3">
                            <div class="avatar-preview mb-3">
                                <div id="imagePreview" style="width: 150px; height: 150px; margin: 0 auto; border-radius: 50%; background-color: #f8f9fa; border: 2px solid #dee2e6; display: flex; align-items: center; justify-content: center;">
                                    <i class="las la-user fa-3x text-primary"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <h5 class="mb-1">{{ $customer->name }}</h5>
                                <p class="text-muted mb-1">ID: CUS-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</p>
                                <p class="mb-2"><i class="las la-phone mr-1"></i> {{ $customer->phone }}</p>
                                @if($customer->email)
                                    <p class="mb-2"><i class="las la-envelope mr-1"></i> {{ $customer->email }}</p>
                                @endif
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
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Total Orders</span>
                                <span class="badge badge-primary">{{ $customer->orders()->count() }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Total Spent</span>
                                <span class="badge badge-success">Rs {{ number_format($customer->orders()->sum('final_amount'), 2) }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Last Order</span>
                                <span class="badge badge-info">
                                    @if($customer->orders()->exists())
                                        {{ $customer->orders()->latest()->first()->order_date->format('d M') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Member Since</span>
                                <span class="badge badge-warning">{{ $customer->created_at->format('d M, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="card shadow">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-outline-primary btn-block text-left">
                                <i class="las la-eye mr-2"></i> View Profile
                            </a>
                            <a href="{{ route('orders.create') }}?customer={{ $customer->id }}" class="btn btn-outline-success btn-block text-left">
                                <i class="las la-plus-circle mr-2"></i> Create New Order
                            </a>
                            <a href="#" class="btn btn-outline-info btn-block text-left">
                                <i class="las la-file-alt mr-2"></i> View All Orders
                            </a>
                            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary btn-block text-left">
                                <i class="las la-list mr-2"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/select2/js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap'
            });
            
            // Form submission
            $('#customerForm').submit(function(e) {
                e.preventDefault();
                
                // Form validation
                const requiredFields = $(this).find('[required]');
                let valid = true;
                
                requiredFields.each(function() {
                    if (!$(this).val().trim()) {
                        valid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
                
                if (valid) {
                    this.submit();
                } else {
                    alert('Please fill in all required fields.');
                }
            });
        });
        
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this customer? This action cannot be undone.')) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
    
    <style>
        .card {
            border-radius: 0.5rem;
        }
        .card-header.bg-light {
            background-color: #f8f9fa !important;
            border-bottom: 1px solid #e9ecef;
        }
        .btn {
            border-radius: 0.375rem;
        }
        .form-control {
            border-radius: 0.375rem;
        }
        .badge {
            font-size: 0.75em;
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
        .list-group-item {
            border: none;
            padding: 0.75rem 0;
        }
    </style>

    @endpush
</x-app-layout>