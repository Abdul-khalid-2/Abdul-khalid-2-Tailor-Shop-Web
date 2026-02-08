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
                <h4 class="mb-3">Add New Dress Type</h4>
            </div>
            <div>
                <a href="{{ route('dress-types.index') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left mr-1"></i> Back to List
                </a>
            </div>
        </div>

        <!-- Order Form -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('dress-types.store') }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Unique name for the dress type</small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Base Price (Rs) *</label>
                                    <input type="number" step="0.01" class="form-control @error('base_price') is-invalid @enderror" 
                                           name="base_price" value="{{ old('base_price') }}" required>
                                    @error('base_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Starting price for this dress type</small>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Estimated Days *</label>
                                    <input type="number" class="form-control @error('estimated_days') is-invalid @enderror" 
                                           name="estimated_days" value="{{ old('estimated_days', 7) }}" min="1" max="365" required>
                                    @error('estimated_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Estimated completion time in days</small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" name="is_active">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          name="description" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Optional description of the dress type</small>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="las la-save mr-1"></i> Save Dress Type
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="mb-0">Guidelines</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="las la-check text-success mr-2"></i>
                                <strong>Name:</strong> Should be unique and descriptive
                            </li>
                            <li class="mb-2">
                                <i class="las la-check text-success mr-2"></i>
                                <strong>Base Price:</strong> Consider fabric, labor, and complexity
                            </li>
                            <li class="mb-2">
                                <i class="las la-check text-success mr-2"></i>
                                <strong>Estimated Days:</strong> Include time for measurements, stitching, and fitting
                            </li>
                            <li class="mb-2">
                                <i class="las la-check text-success mr-2"></i>
                                <strong>Status:</strong> Set to inactive for seasonal or discontinued items
                            </li>
                            <li class="mb-2">
                                <i class="las la-check text-success mr-2"></i>
                                <strong>Description:</strong> Include style notes, suitable occasions, etc.
                            </li>
                        </ul>
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
</x-app-layout>