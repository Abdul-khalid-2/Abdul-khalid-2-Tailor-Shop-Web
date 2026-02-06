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
                <h4 class="mb-3">Add New Customer</h4>
                <p class="mb-0">Create a new customer profile for your tailor shop</p>
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
                        <form id="customerForm">
                            <!-- Basic Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Basic Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Full Name *</label>
                                            <input type="text" class="form-control" placeholder="Enter customer name" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Customer ID</label>
                                            <input type="text" class="form-control" value="CUS-{{ str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT) }}" readonly>
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
                                                <input type="tel" class="form-control" placeholder="300 1234567" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" class="form-control" placeholder="customer@example.com">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Gender</label>
                                            <select class="form-control">
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control">
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
                                        <label class="form-label">Nearest Landmark</label>
                                        <input type="text" class="form-control" placeholder="e.g., Near Mall, Opposite Bank">
                                    </div>
                                </div>
                            </div>

                            <!-- Business Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Business Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Branch *</label>
                                            <select class="form-control select2" required>
                                                <option value="">Select Branch</option>
                                                <option value="1" selected>Main Shop</option>
                                                <option value="2">Downtown Branch</option>
                                                <option value="3">Mall Outlet</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Reference/Source</label>
                                            <select class="form-control select2">
                                                <option value="">Select Source</option>
                                                <option value="walk_in">Walk-in</option>
                                                <option value="referral">Referral</option>
                                                <option value="social_media">Social Media</option>
                                                <option value="website">Website</option>
                                                <option value="advertisement">Advertisement</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Customer Type</label>
                                            <select class="form-control">
                                                <option value="regular">Regular Customer</option>
                                                <option value="vip">VIP Customer</option>
                                                <option value="corporate">Corporate Customer</option>
                                                <option value="walk_in">Walk-in Customer</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Discount Rate (%)</label>
                                            <input type="number" class="form-control" min="0" max="50" value="0">
                                            <small class="text-muted">Special discount for this customer</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Measurement Templates -->
                            <div class="card mb-4">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Measurement Templates</h6>
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addMeasurementTemplate()">
                                        <i class="las la-plus"></i> Add Template
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div id="measurementTemplates">
                                        <div class="template-item mb-3">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Dress Type</label>
                                                    <select class="form-control">
                                                        <option value="">Select Dress Type</option>
                                                        <option value="sherwani">Sherwani</option>
                                                        <option value="suit">Suit</option>
                                                        <option value="kurta">Kurta</option>
                                                        <option value="gown">Gown</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Template Name</label>
                                                    <input type="text" class="form-control" placeholder="e.g., Wedding Sherwani">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 mb-2">
                                                    <input type="number" class="form-control" placeholder="Height (cm)">
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <input type="number" class="form-control" placeholder="Chest (cm)">
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <input type="number" class="form-control" placeholder="Waist (cm)">
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <input type="number" class="form-control" placeholder="Hips (cm)">
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="defaultTemplate">
                                                <label class="form-check-label" for="defaultTemplate">Set as default template</label>
                                            </div>
                                        </div>
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
                                            <label class="form-label">Occupation</label>
                                            <input type="text" class="form-control" placeholder="e.g., Business, Doctor, Student">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Anniversary Date</label>
                                            <input type="date" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Special Notes</label>
                                        <textarea class="form-control" rows="3" placeholder="Any special notes about this customer..."></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Preferred Communication</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="smsPreferred">
                                            <label class="form-check-label" for="smsPreferred">SMS</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="emailPreferred">
                                            <label class="form-check-label" for="emailPreferred">Email</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="whatsappPreferred">
                                            <label class="form-check-label" for="whatsappPreferred">WhatsApp</label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="sendWelcome">
                                        <label class="form-check-label" for="sendWelcome">Send welcome message to customer</label>
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
                                        <i class="las la-check-circle"></i> Create Customer
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Customer Photo -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Customer Photo</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="avatar-upload mb-3">
                            <div class="avatar-preview mb-3">
                                <div id="imagePreview" style="width: 150px; height: 150px; margin: 0 auto; border-radius: 50%; background-color: #f8f9fa; border: 2px dashed #dee2e6; display: flex; align-items: center; justify-content: center;">
                                    <i class="las la-user fa-3x text-muted"></i>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customerPhoto" accept="image/*" onchange="previewImage(this)">
                                    <label class="custom-file-label" for="customerPhoto">Choose photo</label>
                                </div>
                            </div>
                            <small class="text-muted d-block mt-2">Max size: 2MB, Formats: JPG, PNG</small>
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
                                <span>Total Customers</span>
                                <span class="badge badge-primary">248</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>New This Month</span>
                                <span class="badge badge-success">28</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Active Customers</span>
                                <span class="badge badge-info">185</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Repeat Rate</span>
                                <span class="badge badge-warning">65%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="card shadow">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Quick Links</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('orders.create') }}" class="btn btn-outline-primary btn-block text-left">
                                <i class="las la-plus-circle mr-2"></i> Create New Order
                            </a>
                            <a href="#" class="btn btn-outline-success btn-block text-left" data-toggle="modal" data-target="#sendMessageModal">
                                <i class="las la-envelope mr-2"></i> Send Welcome Message
                            </a>
                            <a href="#" class="btn btn-outline-info btn-block text-left" onclick="generateCustomerCard()">
                                <i class="las la-id-card mr-2"></i> Generate Customer Card
                            </a>
                            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary btn-block text-left">
                                <i class="las la-list mr-2"></i> View All Customers
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Send Message Modal -->
    <div class="modal fade" id="sendMessageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Send Welcome Message</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="messageForm">
                        <div class="form-group">
                            <label>Message Template</label>
                            <select class="form-control" id="messageTemplate">
                                <option value="">Custom Message</option>
                                <option value="welcome">Welcome to Our Tailor Shop!</option>
                                <option value="welcome_discount">Welcome with 10% Discount</option>
                                <option value="special_welcome">VIP Welcome Message</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control" id="messageContent" rows="4" placeholder="Type your welcome message here...">
                                Dear Customer,

                                Welcome to our tailor shop! We're excited to have you as our valued customer.

                                Best regards,
                                Tailor Shop Team
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label>Send Via</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sendSMS" checked>
                                <label class="form-check-label" for="sendSMS">SMS</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sendEmail">
                                <label class="form-check-label" for="sendEmail">Email</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sendWhatsApp">
                                <label class="form-check-label" for="sendWhatsApp">WhatsApp</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="sendWelcomeMessage()">
                        <i class="las la-paper-plane mr-1"></i> Send Message
                    </button>
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
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap'
            });
            
            // File input label
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
            
            // Message template change
            $('#messageTemplate').change(function() {
                const templates = {
                    'welcome': 'Dear Customer,\n\nWelcome to our tailor shop! We\'re excited to have you as our valued customer.\n\nBest regards,\nTailor Shop Team',
                    'welcome_discount': 'Dear Customer,\n\nWelcome to our tailor shop! As a special welcome gift, you get 10% discount on your first order.\n\nBest regards,\nTailor Shop Team',
                    'special_welcome': 'Dear Valued Customer,\n\nWelcome to our premium tailor shop experience! We look forward to serving you with our best craftsmanship.\n\nWarm regards,\nTailor Shop Team'
                };
                
                if (this.value && templates[this.value]) {
                    $('#messageContent').val(templates[this.value]);
                }
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
                
                if (!valid) {
                    alert('Please fill in all required fields.');
                    return;
                }
                
                // Simulate form submission
                alert('Customer created successfully!');
                window.location.href = "{{ route('customers.index') }}";
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
        
        function addMeasurementTemplate() {
            const templateHtml = `
                <div class="template-item mb-3 border-top pt-3">
                    <button type="button" class="btn btn-sm btn-outline-danger float-right" onclick="removeTemplate(this)">
                        <i class="las la-times"></i>
                    </button>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dress Type</label>
                            <select class="form-control">
                                <option value="">Select Dress Type</option>
                                <option value="sherwani">Sherwani</option>
                                <option value="suit">Suit</option>
                                <option value="kurta">Kurta</option>
                                <option value="gown">Gown</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Template Name</label>
                            <input type="text" class="form-control" placeholder="e.g., Wedding Sherwani">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <input type="number" class="form-control" placeholder="Height (cm)">
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="number" class="form-control" placeholder="Chest (cm)">
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="number" class="form-control" placeholder="Waist (cm)">
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="number" class="form-control" placeholder="Hips (cm)">
                        </div>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="defaultTemplateNew">
                        <label class="form-check-label" for="defaultTemplateNew">Set as default template</label>
                    </div>
                </div>
            `;
            
            $('#measurementTemplates').append(templateHtml);
        }
        
        function removeTemplate(button) {
            $(button).closest('.template-item').remove();
        }
        
        function resetForm() {
            if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
                document.getElementById('customerForm').reset();
                $('#imagePreview').html('<i class="las la-user fa-3x text-muted"></i>');
                $('.custom-file-label').removeClass('selected').html('Choose photo');
                // Keep only first measurement template
                $('.template-item:not(:first)').remove();
                $('.select2').val(null).trigger('change');
            }
        }
        
        function saveAsDraft() {
            alert('Customer saved as draft!');
            // In real app: AJAX call to save as draft
        }
        
        function sendWelcomeMessage() {
            const message = $('#messageContent').val();
            const viaSMS = $('#sendSMS').prop('checked');
            const viaEmail = $('#sendEmail').prop('checked');
            const viaWhatsApp = $('#sendWhatsApp').prop('checked');
            
            let methods = [];
            if (viaSMS) methods.push('SMS');
            if (viaEmail) methods.push('Email');
            if (viaWhatsApp) methods.push('WhatsApp');
            
            alert('Sending welcome message via: ' + methods.join(', '));
            $('#sendMessageModal').modal('hide');
        }
        
        function generateCustomerCard() {
            alert('Generating customer loyalty card...');
            // In real app: Generate customer card PDF
        }
    </script>
    
    <style>
        .avatar-upload {
            position: relative;
        }
        .avatar-preview {
            position: relative;
        }
        .template-item {
            position: relative;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .custom-file-label.selected::after {
            content: "" !important;
        }
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
        .d-grid.gap-2 {
            gap: 0.5rem !important;
        }
        .modal-content {
            border-radius: 0.5rem;
            border: none;
        }
        .close {
            font-size: 1.5rem;
            font-weight: 300;
        }
    </style>
    @endpush
</x-app-layout>