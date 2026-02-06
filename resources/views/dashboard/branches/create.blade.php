<x-app-layout>
        @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    @endpush


    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-3">Add New Branch</h4>
                <p class="mb-0">Create a new branch for your tailor shop</p>
            </div>
            <div>
                <a href="{{ route('branches.index') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left mr-1"></i> Back to Branches
                </a>
            </div>
        </div>

        <!-- Branch Form -->
        <div class="row">
            <div class="col-lg-8">
                <form action="{{ route('branches.store') }}" method="POST" id="branchForm">
                    @csrf
                    
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
                                           placeholder="Enter branch name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Branch Code *</label>
                                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                                           placeholder="e.g., MAIN, DWN, MALL" value="{{ old('code') }}" required>
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
                                           value="{{ old('opening_date') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-check">
                                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" 
                                               {{ old('is_active', true) ? 'checked' : '' }}>
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
                                           placeholder="+92 300 1234567" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                           placeholder="branch@example.com" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                          rows="3" placeholder="Full address of the branch">{{ old('address') }}</textarea>
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
                                           placeholder="Manager's full name" value="{{ old('manager_name') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Manager Phone</label>
                                    <input type="tel" name="manager_phone" class="form-control" 
                                           placeholder="+92 300 1234567" value="{{ old('manager_phone') }}">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Manager Email</label>
                                <input type="email" name="manager_email" class="form-control" 
                                       placeholder="manager@example.com" value="{{ old('manager_email') }}">
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
                                           placeholder="09:00" value="{{ old('opening_time', '09:00') }}" required>
                                    @error('opening_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Closing Time *</label>
                                    <input type="text" name="closing_time" class="form-control timepicker @error('closing_time') is-invalid @enderror" 
                                           placeholder="18:00" value="{{ old('closing_time', '18:00') }}" required>
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
                                    @endphp
                                    @foreach($days as $day)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input type="checkbox" name="working_days[]" class="form-check-input" 
                                                   id="day_{{ strtolower($day) }}" value="{{ $day }}"
                                                   {{ in_array($day, old('working_days', $days)) ? 'checked' : '' }}>
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
                        <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                            <i class="las la-redo-alt"></i> Reset Form
                        </button>
                        <div>
                            <button type="button" class="btn btn-outline-primary mr-2" onclick="saveAsDraft()">
                                <i class="las la-save"></i> Save as Draft
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="las la-check-circle"></i> Create Branch
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Instructions -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-light py-3">
                        <h6 class="mb-0">Instructions</h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h6><i class="las la-info-circle"></i> Important Notes:</h6>
                            <ul class="mb-0 pl-3">
                                <li>Branch code must be unique</li>
                                <li>All active branches will appear in dropdowns</li>
                                <li>Each branch gets its own settings</li>
                                <li>Default settings will be created automatically</li>
                                <li>You can add manager details later</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-light py-3">
                        <h6 class="mb-0">Current Statistics</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @php
                                $stats = [
                                    'Total Branches' => \App\Models\Branch::count(),
                                    'Active Branches' => \App\Models\Branch::where('is_active', true)->count(),
                                    'Total Users' => \App\Models\User::count(),
                                    'Total Customers' => \App\Models\Customer::count(),
                                ];
                            @endphp
                            @foreach($stats as $label => $value)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>{{ $label }}</span>
                                <span class="badge badge-primary">{{ $value }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="card shadow">
                    <div class="card-header bg-light py-3">
                        <h6 class="mb-0">Quick Links</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('branches.index') }}" class="btn btn-outline-secondary btn-block text-left">
                                <i class="las la-list mr-2"></i> View All Branches
                            </a>
                            <a href="{{ route('settings.general') }}" class="btn btn-outline-primary btn-block text-left">
                                <i class="las la-cog mr-2"></i> System Settings
                            </a>
                            <a href="#" class="btn btn-outline-success btn-block text-left" onclick="generateBranchCode()">
                                <i class="las la-barcode mr-2"></i> Generate Branch Code
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('js')
     <!-- Backend Bundle JavaScript -->
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
        
        function resetForm() {
            if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
                document.getElementById('branchForm').reset();
                $('.timepicker').val('');
            }
        }
        
        function saveAsDraft() {
            alert('Branch saved as draft!');
            // In real app: AJAX call to save as draft
        }
        
        function generateBranchCode() {
            const name = $('input[name="name"]').val();
            if (!name) {
                alert('Please enter branch name first');
                return;
            }
            
            // Generate code from name (first 3 letters uppercase)
            let code = name.substring(0, 3).toUpperCase();
            
            // Add random number if needed
            if (code.length < 3) {
                code = code.padEnd(3, 'X');
            }
            
            // Add random number to make unique
            const randomNum = Math.floor(Math.random() * 90) + 10;
            code += randomNum;
            
            $('input[name="code"]').val(code);
            alert('Generated branch code: ' + code);
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
        .alert {
            border-radius: 0.375rem;
        }
    </style>
    @endpush
</x-app-layout>