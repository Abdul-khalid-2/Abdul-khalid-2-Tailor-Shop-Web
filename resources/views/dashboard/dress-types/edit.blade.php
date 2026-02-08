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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Edit Dress Type: {{ $dressType->name }}</h4>
            <a href="{{ route('dress-types.index') }}" class="btn btn-secondary">
                <i class="las la-arrow-left mr-1"></i> Back to List
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('dress-types.update', $dressType) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name', $dressType->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Unique name for the dress type</small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control" value="{{ $dressType->slug }}" readonly>
                                    <small class="text-muted">Auto-generated from name</small>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Base Price (Rs) *</label>
                                    <input type="number" step="0.01" class="form-control @error('base_price') is-invalid @enderror" 
                                           name="base_price" value="{{ old('base_price', $dressType->base_price) }}" required>
                                    @error('base_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Starting price for this dress type</small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Estimated Days *</label>
                                    <input type="number" class="form-control @error('estimated_days') is-invalid @enderror" 
                                           name="estimated_days" value="{{ old('estimated_days', $dressType->estimated_days) }}" 
                                           min="1" max="365" required>
                                    @error('estimated_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Estimated completion time in days</small>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" name="is_active">
                                        <option value="1" {{ $dressType->is_active ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$dressType->is_active ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Created</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $dressType->created_at->format('M d, Y h:i A') }} by {{ $dressType->createdBy->name ?? 'N/A' }}" 
                                           readonly>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          name="description" rows="3">{{ old('description', $dressType->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Optional description of the dress type</small>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @if($dressType->orderItems()->exists())
                                    <div class="alert alert-warning mb-0">
                                        <i class="las la-exclamation-triangle mr-2"></i>
                                        This dress type has {{ $dressType->orderItems()->count() }} orders. 
                                        Editing may affect existing orders.
                                    </div>
                                    @endif
                                </div>
                                <div class="d-flex">
                                    <a href="{{ route('dress-types.index') }}" class="btn btn-secondary mr-2">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="las la-save mr-1"></i> Update Dress Type
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Order Statistics -->
                <div class="card shadow mt-4">
                    <div class="card-header">
                        <h6 class="mb-0">Order Statistics</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="h4 mb-1">{{ $dressType->orderItems()->count() }}</div>
                                    <div class="text-muted">Total Orders</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="h4 mb-1">
                                        @php
                                            $monthlyOrders = $dressType->orderItems()
                                                ->whereHas('order', function($q) {
                                                    $q->whereMonth('order_date', now()->month)
                                                      ->whereYear('order_date', now()->year);
                                                })->count();
                                        @endphp
                                        {{ $monthlyOrders }}
                                    </div>
                                    <div class="text-muted">This Month</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="h4 mb-1">
                                        @php
                                            $totalRevenue = $dressType->orderItems()
                                                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                                                ->where('orders.status_id', '!=', 6) // Not cancelled
                                                ->sum('order_items.total');
                                        @endphp
                                        Rs {{ number_format($totalRevenue) }}
                                    </div>
                                    <div class="text-muted">Total Revenue</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="mb-0">Quick Information</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <th>ID:</th>
                                <td>DT-{{ str_pad($dressType->id, 3, '0', STR_PAD_LEFT) }}</td>
                            </tr>
                            <tr>
                                <th>Slug:</th>
                                <td>{{ $dressType->slug }}</td>
                            </tr>
                            <tr>
                                <th>Current Price:</th>
                                <td class="text-success font-weight-bold">
                                    Rs {{ number_format($dressType->base_price, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <th>Delivery Time:</th>
                                <td>{{ $dressType->estimated_days }} days</td>
                            </tr>
                            <tr>
                                <th>Created:</th>
                                <td>
                                    {{ $dressType->created_at->format('M d, Y') }}<br>
                                    <small>by {{ $dressType->createdBy->name ?? 'N/A' }}</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Last Updated:</th>
                                <td>
                                    {{ $dressType->updated_at->format('M d, Y') }}<br>
                                    <small>by {{ $dressType->updatedBy->name ?? 'N/A' }}</small>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="card shadow mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Danger Zone</h6>
                    </div>
                    <div class="card-body">
                        @if($dressType->orderItems()->exists())
                            <div class="alert alert-danger">
                                <i class="las la-exclamation-circle mr-2"></i>
                                Cannot delete this dress type because it has 
                                {{ $dressType->orderItems()->count() }} associated orders.
                            </div>
                            <button class="btn btn-danger btn-block" disabled>
                                <i class="las la-trash mr-1"></i> Delete Dress Type
                            </button>
                        @else
                            <form action="{{ route('dress-types.destroy', $dressType) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this dress type? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-block">
                                    <i class="las la-trash mr-1"></i> Delete Dress Type
                                </button>
                            </form>
                        @endif
                        
                        <hr class="my-3">
                        
                        <button type="button" class="btn btn-warning btn-block" onclick="toggleDressTypeStatus()">
                            @if($dressType->is_active)
                                <i class="las la-ban mr-1"></i> Deactivate Dress Type
                            @else
                                <i class="las la-check mr-1"></i> Activate Dress Type
                            @endif
                        </button>
                    </div>
                </div>
                
                <div class="card shadow mt-4">
                    <div class="card-header">
                        <h6 class="mb-0">Recent Orders</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $recentOrders = $dressType->orderItems()
                                ->with(['order.customer'])
                                ->latest()
                                ->limit(5)
                                ->get();
                        @endphp
                        
                        @if($recentOrders->count() > 0)
                            @foreach($recentOrders as $orderItem)
                                <div class="mb-3 pb-3 border-bottom">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="font-weight-bold">
                                                Order #{{ $orderItem->order->order_number }}
                                            </div>
                                            <small class="text-muted">
                                                {{ $orderItem->order->customer->name }}
                                            </small>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-success font-weight-bold">
                                                Rs {{ number_format($orderItem->total) }}
                                            </div>
                                            <small class="text-muted">
                                                {{ $orderItem->order->order_date->format('M d') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if($dressType->orderItems()->count() > 5)
                                <a href="{{ route('orders.index', ['dress_type' => $dressType->id]) }}" 
                                   class="btn btn-sm btn-outline-primary btn-block">
                                    View All Orders
                                </a>
                            @endif
                        @else
                            <div class="text-center text-muted py-3">
                                <i class="las la-clipboard-list fa-2x mb-2"></i>
                                <div>No orders yet</div>
                            </div>
                        @endif
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


    @endpush
    <script>
        function toggleDressTypeStatus() {
            if (confirm('Are you sure you want to change the status of this dress type?')) {
                $.ajax({
                    url: '{{ route("dress-types.toggle-status", $dressType) }}',
                    type: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        alert('Error updating status');
                    }
                });
            }
        }
        
        // Auto-generate slug from name
        document.querySelector('input[name="name"]').addEventListener('input', function(e) {
            const slugField = document.querySelector('input[name="slug"]');
            if (slugField) {
                const slug = e.target.value
                    .toLowerCase()
                    .replace(/[^\w\s]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/--+/g, '-');
                slugField.value = slug;
            }
        });
    </script>
</x-app-layout>