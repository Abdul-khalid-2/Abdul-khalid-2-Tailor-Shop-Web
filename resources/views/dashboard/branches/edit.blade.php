<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    @endpush

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-3">Edit Branch</h4>
                <p class="mb-0">Update branch information</p>
            </div>
            <div>
                <a href="{{ route('branches.show', $branch) }}" class="btn btn-outline-secondary mr-2">
                    <i class="las la-times mr-1"></i> Cancel
                </a>
            </div>
        </div>

        <!-- Branch Form -->
        <div class="row">
            <div class="col-lg-8">
                <form action="{{ route('branches.update', $branch) }}" method="POST" id="branchForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Information -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light py-3">
                            <h6 class="mb-0">Basic Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Branch Name *</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           placeholder="Enter branch name" value="{{ old('name', $branch->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Branch Code *</label>
                                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                                           placeholder="e.g., MAIN, DWN, MALL" value="{{ old('code', $branch->code) }}" required>
                                    <small class="text-muted">Unique code for the branch</small>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Opening Date</label>
                                    <input type="date" name="opening_date" class="form-control" 
                                           value="{{ old('opening_date', $branch->opening_date ? $branch->opening_date->format('Y-m-d') : '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-check">
                                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" 
                                               {{ old('is_active', $branch->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Active Branch</label>
                                    </div>
                                    <small class="text-muted">Active branches can receive orders</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light py-3">
                            <h6 class="mb-0">Contact Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                           placeholder="+92 300 1234567" value="{{ old('phone', $branch->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                           placeholder="branch@example.com" value="{{ old('email', $branch->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                          rows="3" placeholder="Full address of the branch">{{ old('address', $branch->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Branch Manager -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light py-3">
                            <h6 class="mb-0">Branch Manager</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Manager Name</label>
                                    <input type="text" name="manager_name" class="form-control" 
                                           placeholder="Manager's full name" value="{{ old('manager_name', $branch->manager_name) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Manager Phone</label>
                                    <input type="tel" name="manager_phone" class="form-control" 
                                           placeholder="+92 300 1234567" value="{{ old('manager_phone', $branch->manager_phone) }}">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Manager Email</label>
                                <input type="email" name="manager_email" class="form-control" 
                                       placeholder="manager@example.com" value="{{ old('manager_email', $branch->manager_email) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Operating Hours -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light py-3">
                            <h6 class="mb-0">Operating Hours</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Opening Time *</label>
                                    <input type="text" name="opening_time" class="form-control timepicker @error('opening_time') is-invalid @enderror" 
                                           placeholder="09:00" value="{{ old('opening_time', $branch->opening_time) }}" required>
                                    @error('opening_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Closing Time *</label>
                                    <input type="text" name="closing_time" class="form-control timepicker @error('closing_time') is-invalid @enderror" 
                                           placeholder="18:00" value="{{ old('closing_time', $branch->closing_time) }}" required>
                                    @error('closing_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Working Days</label>
                                <div class="row">
                                    @php
                                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                        $selectedDays = old('working_days', $branch->working_days ?? $days);
                                    @endphp
                                    @foreach($days as $day)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input type="checkbox" name="working_days[]" class="form-check-input" 
                                                   id="day_{{ strtolower($day) }}" value="{{ $day }}"
                                                   {{ is_array($selectedDays) && in_array($day, $selectedDays) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="day_{{ strtolower($day) }}">{{ $day }}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='{{ route('branches.show', $branch) }}'">
                            <i class="las la-times"></i> Cancel
                        </button>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="las la-check-circle"></i> Update Branch
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Branch Info -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-light py-3">
                        <h6 class="mb-0">Branch Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="avatar mb-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($branch->name) }}&background=3B82F6&color=fff&size=100" 
                                     class="rounded-circle" 
                                     alt="{{ $branch->name }}">
                            </div>
                            <h5>{{ $branch->name }}</h5>
                            <p class="text-muted">{{ $branch->code }}</p>
                        </div>
                        
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Status</span>
                                <span class="badge badge-{{ $branch->is_active ? 'success' : 'secondary' }}">
                                    {{ $branch->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Total Users</span>
                                <span class="badge badge-primary">{{ $branch->users_count }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Total Customers</span>
                                <span class="badge badge-success">{{ $branch->customers_count }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Total Orders</span>
                                <span class="badge badge-info">{{ $branch->orders_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-light py-3">
                        <h6 class="mb-0">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('branches.show', $branch) }}" class="btn btn-outline-secondary btn-block text-left">
                                <i class="las la-eye mr-2"></i> View Details
                            </a>
                            <a href="{{ route('settings.branch', $branch) }}" class="btn btn-outline-primary btn-block text-left">
                                <i class="las la-cog mr-2"></i> Branch Settings
                            </a>
                            <form action="{{ route('branches.toggle-status', $branch) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-{{ $branch->is_active ? 'danger' : 'success' }} btn-block text-left">
                                    <i class="las la-power-off mr-2"></i> 
                                    {{ $branch->is_active ? 'Deactivate Branch' : 'Activate Branch' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Last Updated -->
                <div class="card shadow">
                    <div class="card-header bg-light py-3">
                        <h6 class="mb-0">Last Updated</h6>
                    </div>
                    <div class="card-body">
                        <div class="small">
                            @if($branch->updatedBy)
                            <div class="mb-2">
                                <label class="text-muted">Updated By:</label>
                                <div>{{ $branch->updatedBy->name }}</div>
                            </div>
                            @endif
                            <div>
                                <label class="text-muted">Updated At:</label>
                                <div>{{ $branch->updated_at->format('d M, Y h:i A') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('js')
    <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize timepicker
            $('.timepicker').timepicker({
                showMeridian: false,
                minuteStep: 5,
                defaultTime: false
            });
            
            // Form validation
            $('#branchForm').submit(function(e) {
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
                
                if (!valid) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                }
            });
        });
    </script>
    
    <style>
        .card {
            border-radius: 0.5rem;
        }
        .card-header.bg-light {
            background-color: #f8f9fa !important;
            border-bottom: 1px solid #e9ecef;
        }
        .avatar {
            width: 100px;
            height: 100px;
            margin: 0 auto;
        }
        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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