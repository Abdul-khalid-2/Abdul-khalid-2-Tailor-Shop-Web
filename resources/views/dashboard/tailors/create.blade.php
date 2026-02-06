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
                <h4 class="mb-3">Add New Tailor</h4>
                <p class="mb-0">Register a new tailor to your team</p>
            </div>
            <div>
                <a href="{{ route('tailors.index') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left mr-1"></i> Back to Tailors
                </a>
            </div>
        </div>

        <!-- Tailor Form -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-body">
                        <form id="tailorForm">
                            <!-- Personal Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Personal Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Full Name *</label>
                                            <input type="text" class="form-control" placeholder="Enter tailor's full name" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tailor ID</label>
                                            <input type="text" class="form-control" value="T-{{ str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT) }}" readonly>
                                            <small class="text-muted">Auto-generated</small>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">CNIC Number *</label>
                                            <input type="text" class="form-control" placeholder="XXXXX-XXXXXXX-X" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Phone Number *</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">+92</span>
                                                </div>
                                                <input type="tel" class="form-control" placeholder="300 1234567" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Emergency Contact</label>
                                            <input type="tel" class="form-control" placeholder="Emergency phone number">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" class="form-control" placeholder="tailor@example.com">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Gender</label>
                                            <select class="form-control">
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Employment Details -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Employment Details</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Employment Type *</label>
                                            <select class="form-control select2" id="employmentType" required>
                                                <option value="">Select Type</option>
                                                <option value="permanent">Permanent</option>
                                                <option value="contract">Contract</option>
                                                <option value="freelance">Freelance</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Joining Date *</label>
                                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Branch *</label>
                                            <select class="form-control select2" required>
                                                <option value="">Select Branch</option>
                                                <option value="1">Main Shop</option>
                                                <option value="2">Downtown Branch</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Shift Timing</label>
                                            <select class="form-control">
                                                <option value="morning">Morning (9 AM - 5 PM)</option>
                                                <option value="evening">Evening (1 PM - 9 PM)</option>
                                                <option value="full">Full Day (9 AM - 9 PM)</option>
                                                <option value="flexible">Flexible</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div id="salarySection">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Monthly Salary (₹)</label>
                                                <input type="number" class="form-control" placeholder="25000" id="monthlySalary">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Commission Rate (%)</label>
                                                <input type="number" class="form-control" min="0" max="50" value="5">
                                                <small class="text-muted">Percentage per order</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="contractSection" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Contract Duration (Months)</label>
                                                <input type="number" class="form-control" placeholder="6" id="contractDuration">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Rate per Order (₹)</label>
                                                <input type="number" class="form-control" placeholder="1000" id="ratePerOrder">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Specialization & Skills -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Specialization & Skills</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Specializations *</label>
                                        <select class="form-control select2" multiple="multiple" id="specializations" required>
                                            <option value="sherwani">Sherwani</option>
                                            <option value="suit">Suit</option>
                                            <option value="kurta">Kurta</option>
                                            <option value="shalwar_kameez">Shalwar Kameez</option>
                                            <option value="gown">Gown</option>
                                            <option value="lehenga">Lehenga</option>
                                            <option value="blouse">Blouse</option>
                                            <option value="abaya">Abaya</option>
                                            <option value="kids_wear">Kids Wear</option>
                                            <option value="formal_wear">Formal Wear</option>
                                            <option value="casual_wear">Casual Wear</option>
                                            <option value="traditional_wear">Traditional Wear</option>
                                        </select>
                                        <small class="text-muted">Select all dress types this tailor specializes in</small>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Experience (Years)</label>
                                            <input type="number" class="form-control" min="0" max="50" value="5">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Skill Level</label>
                                            <select class="form-control">
                                                <option value="beginner">Beginner (0-2 years)</option>
                                                <option value="intermediate">Intermediate (2-5 years)</option>
                                                <option value="advanced" selected>Advanced (5-10 years)</option>
                                                <option value="expert">Expert (10+ years)</option>
                                                <option value="master">Master Tailor</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Additional Skills</label>
                                        <textarea class="form-control" rows="3" placeholder="Any additional skills like embroidery, bead work, etc..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Address & Contact -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Address & Contact</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Address Line 1</label>
                                            <input type="text" class="form-control" placeholder="House #, Street">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Address Line 2</label>
                                            <input type="text" class="form-control" placeholder="Area, Sector">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control" placeholder="City">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">State/Province</label>
                                            <input type="text" class="form-control" placeholder="State">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">ZIP/Postal Code</label>
                                            <input type="text" class="form-control" placeholder="Postal Code">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Bank Account Details (Optional)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Bank Account Number">
                                            <div class="input-group-append">
                                                <input type="text" class="form-control" placeholder="Bank Name">
                                            </div>
                                        </div>
                                        <small class="text-muted">For salary payments</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Additional Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Daily Capacity (Orders)</label>
                                            <input type="number" class="form-control" min="1" max="10" value="3">
                                            <small class="text-muted">Maximum orders per day</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-control">
                                                <option value="active" selected>Active</option>
                                                <option value="inactive">Inactive</option>
                                                <option value="on_leave">On Leave</option>
                                                <option value="training">Training</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Notes</label>
                                        <textarea class="form-control" rows="3" placeholder="Any additional notes about this tailor..."></textarea>
                                    </div>
                                    
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="sendCredentials">
                                        <label class="form-check-label" for="sendCredentials">Send login credentials via SMS/Email</label>
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
                                        <i class="las la-check-circle"></i> Add Tailor
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Tailor Photo -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Tailor Photo</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="avatar-upload mb-3">
                            <div class="avatar-preview mb-3">
                                <div id="imagePreview" style="width: 150px; height: 150px; margin: 0 auto; border-radius: 50%; background-color: #f8f9fa; border: 2px dashed #dee2e6; display: flex; align-items: center; justify-content: center;">
                                    <i class="las la-user-secret fa-3x text-muted"></i>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="tailorPhoto" accept="image/*" onchange="previewImage(this)">
                                    <label class="custom-file-label" for="tailorPhoto">Choose photo</label>
                                </div>
                            </div>
                            <small class="text-muted d-block mt-2">Max size: 2MB, Formats: JPG, PNG</small>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Team Statistics</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Total Tailors</span>
                                <span class="badge badge-primary">18</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Active Today</span>
                                <span class="badge badge-success">15</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Available Capacity</span>
                                <span class="badge badge-info">82%</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Avg. Completion</span>
                                <span class="badge badge-warning">3.2 days</span>
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
                            <a href="{{ route('tailor-assignments.index') }}" class="btn btn-outline-primary btn-block text-left">
                                <i class="las la-tasks mr-2"></i> Manage Assignments
                            </a>
                            <a href="#" class="btn btn-outline-success btn-block text-left" onclick="generateIDCard()">
                                <i class="las la-id-card mr-2"></i> Generate ID Card
                            </a>
                            <a href="#" class="btn btn-outline-info btn-block text-left" onclick="viewSchedule()">
                                <i class="las la-calendar-alt mr-2"></i> View Schedule
                            </a>
                            <a href="{{ route('tailors.index') }}" class="btn btn-outline-secondary btn-block text-left">
                                <i class="las la-list mr-2"></i> View All Tailors
                            </a>
                        </div>
                    </div>
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
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap'
            });
            
            // File input label
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
            
            // Employment type change
            $('#employmentType').change(function() {
                if (this.value === 'permanent') {
                    $('#salarySection').show();
                    $('#contractSection').hide();
                } else if (this.value === 'contract' || this.value === 'freelance') {
                    $('#salarySection').hide();
                    $('#contractSection').show();
                } else {
                    $('#salarySection').hide();
                    $('#contractSection').hide();
                }
            });
            
            // Form submission
            $('#tailorForm').submit(function(e) {
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
                
                if (!valid) {
                    alert('Please fill in all required fields.');
                    return;
                }
                
                // Specializations validation
                const specializations = $('#specializations').val();
                if (!specializations || specializations.length === 0) {
                    alert('Please select at least one specialization.');
                    $('#specializations').addClass('is-invalid');
                    return;
                }
                
                // Simulate form submission
                alert('Tailor added successfully!');
                window.location.href = "{{ route('tailors.index') }}";
            });
        });
        
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        function resetForm() {
            if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
                document.getElementById('tailorForm').reset();
                $('#imagePreview').html('<i class="las la-user-secret fa-3x text-muted"></i>');
                $('.custom-file-label').removeClass('selected').html('Choose photo');
                $('.select2').val(null).trigger('change');
                $('#salarySection').show();
                $('#contractSection').hide();
            }
        }
        
        function saveAsDraft() {
            alert('Tailor saved as draft!');
            // In real app: AJAX call to save as draft
        }
        
        function generateIDCard() {
            alert('Generating tailor ID card...');
            // In real app: Generate ID card PDF
        }
        
        function viewSchedule() {
            alert('Opening tailor schedule...');
            // In real app: Open schedule view
        }
    </script>
    @endpush
    
    <style>
        .avatar-upload {
            position: relative;
        }
        .avatar-preview {
            position: relative;
        }
        .custom-file-label.selected::after {
            content: "" !important;
        }
        #salarySection, #contractSection {
            transition: all 0.3s ease;
        }
    </style>
</x-app-layout>