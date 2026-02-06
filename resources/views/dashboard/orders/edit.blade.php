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
                <h4 class="mb-3">Edit Order #TS-{{ str_pad($id, 4, '0', STR_PAD_LEFT) }}</h4>
                <p class="mb-0">Update order information and details</p>
            </div>
            <div class="d-flex">
                <a href="{{ route('orders.show', ['id' => $id]) }}" class="btn btn-outline-secondary mr-2">
                    <i class="las la-eye"></i> View Order
                </a>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                    <i class="las la-arrow-left"></i> Back to Orders
                </a>
            </div>
        </div>

        <!-- Order Edit Form -->
        <div class="row">
            <div class="col-lg-12">
                <form id="editOrderForm">
                    <!-- Basic Information -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Basic Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Order Number</label>
                                    <input type="text" class="form-control" value="TS-{{ str_pad($id, 4, '0', STR_PAD_LEFT) }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Order Status</label>
                                    <select class="form-control">
                                        <option value="pending" selected>Pending</option>
                                        <option value="confirmed">Confirmed</option>
                                        <option value="in-progress">In Progress</option>
                                        <option value="ready">Ready</option>
                                        <option value="delivered">Delivered</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Customer</label>
                                    <select class="form-control">
                                        <option value="1" selected>Customer {{ $id }}</option>
                                        <option value="2">Customer 2</option>
                                        <option value="3">Customer 3</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Branch</label>
                                    <select class="form-control">
                                        <option value="1" selected>Main Branch</option>
                                        <option value="2">North Branch</option>
                                        <option value="3">South Branch</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Order Date</label>
                                    <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime('-' . $id . ' days')) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Delivery Date</label>
                                    <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime('+' . ($id + 3) . ' days')) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Order Items</h6>
                            <button type="button" class="btn btn-sm btn-primary" onclick="addNewItem()">
                                <i class="las la-plus"></i> Add Item
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="orderItemsTable">
                                    <thead>
                                        <tr>
                                            <th>Dress Type</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Price (Rs)</th>
                                            <th>Total (Rs)</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $dressTypes = ['Sherwani', 'Suit', 'Kurta', 'Shalwar Kameez', 'Gown', 'Lehenga'];
                                        @endphp
                                        @for($i = 1; $i <= 2; $i++)
                                            <tr>
                                            <td>
                                                <select class="form-control form-control-sm">
                                                    @foreach($dressTypes as $index => $type)
                                                    <option value="{{ $index + 1 }}" {{ ($id + $i) % 6 == $index ? 'selected' : '' }}>
                                                        {{ $type }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    value="{{ $i == 1 ? 'Embroidered silk sherwani' : 'Formal business suit' }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" value="1" min="1">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm"
                                                    value="{{ 3000 + ($i * 1000) }}" step="0.01">
                                            </td>
                                            <td class="font-weight-bold item-total">
                                                Rs {{ number_format(3000 + ($i * 1000)) }}
                                            </td>
                                            <td>
                                                <select class="form-control form-control-sm">
                                                    <option value="pending" {{ $i % 2 == 0 ? 'selected' : '' }}>Pending</option>
                                                    <option value="cutting">Cutting</option>
                                                    <option value="stitching">Stitching</option>
                                                    <option value="ready">Ready</option>
                                                    <option value="delivered">Delivered</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeItem(this)">
                                                    <i class="las la-trash"></i>
                                                </button>
                                            </td>
                                            </tr>
                                            @endfor
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-right font-weight-bold">Subtotal:</td>
                                            <td id="subtotal" class="font-weight-bold">Rs {{ number_format(6000 + ($id * 1500)) }}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Measurements -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Measurements (in cm)</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Height</label>
                                    <input type="number" step="0.1" class="form-control" value="170">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Chest</label>
                                    <input type="number" step="0.1" class="form-control" value="42">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Waist</label>
                                    <input type="number" step="0.1" class="form-control" value="38">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Hips</label>
                                    <input type="number" step="0.1" class="form-control" value="44">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Shoulder</label>
                                    <input type="number" step="0.1" class="form-control" value="18">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Sleeve Length</label>
                                    <input type="number" step="0.1" class="form-control" value="60">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Pant Length</label>
                                    <input type="number" step="0.1" class="form-control" value="100">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Inseam</label>
                                    <input type="number" step="0.1" class="form-control" value="80">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Special Instructions</label>
                                <textarea class="form-control" rows="2">Extra pocket on inside, monogram on chest</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Fabric Details -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Fabric Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Fabric Type</label>
                                    <select class="form-control">
                                        <option value="silk" selected>Silk</option>
                                        <option value="cotton">Cotton</option>
                                        <option value="linen">Linen</option>
                                        <option value="wool">Wool</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Color</label>
                                    <input type="text" class="form-control" value="Navy Blue">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Meter Required</label>
                                    <input type="number" step="0.01" class="form-control" value="3.5">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Rate per Meter (Rs)</label>
                                    <input type="number" step="0.01" class="form-control" value="800">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Fabric Cost (Rs)</label>
                                    <input type="number" step="0.01" class="form-control" value="2800" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Fabric Status</label>
                                    <select class="form-control">
                                        <option value="pending">Pending</option>
                                        <option value="ordered">Ordered</option>
                                        <option value="received" selected>Received</option>
                                        <option value="cut">Cut</option>
                                        <option value="delivered">Delivered</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tailor Assignment -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Tailor Assignment</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Assign to Tailor</label>
                                    <select class="form-control">
                                        <option value="">Select Tailor</option>
                                        <option value="1" selected>Tailor Ali (Sherwani Specialist)</option>
                                        <option value="2">Tailor Ahmed (Suit Expert)</option>
                                        <option value="3">Tailor Fatima (Ladies Wear)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Assignment Status</label>
                                    <select class="form-control">
                                        <option value="assigned" selected>Assigned</option>
                                        <option value="in-progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                        <option value="delayed">Delayed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Assigned Date</label>
                                    <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime('-2 days')) }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Expected Date</label>
                                    <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime('+3 days')) }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Stitching Charges (Rs)</label>
                                    <input type="number" step="0.01" class="form-control" value="1500">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tailor Instructions</label>
                                <textarea class="form-control" rows="2">Please ensure perfect stitching on embroidery areas. Use double stitching on stress points.</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Payment -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Pricing & Payment</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Items Total (Rs)</label>
                                    <input type="number" step="0.01" class="form-control" value="{{ 6000 + ($id * 1500) }}" id="itemsTotal">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Fabric Cost (Rs)</label>
                                    <input type="number" step="0.01" class="form-control" value="2800" id="fabricCost">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Stitching Charges (Rs)</label>
                                    <input type="number" step="0.01" class="form-control" value="1500" id="stitchingCharges">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Additional Charges (Rs)</label>
                                    <input type="number" step="0.01" class="form-control" value="0" id="additionalCharges">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Discount (Rs)</label>
                                    <input type="number" step="0.01" class="form-control" value="0" id="discount">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Total Amount (Rs)</label>
                                    <input type="number" step="0.01" class="form-control font-weight-bold text-primary"
                                        value="{{ 8500 + ($id * 1500) }}" id="totalAmount" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Advance Paid (Rs)</label>
                                    <input type="number" step="0.01" class="form-control" value="2500" id="advancePaid">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Balance Due (Rs)</label>
                                    <input type="number" step="0.01" class="form-control font-weight-bold text-danger"
                                        value="{{ 6000 + ($id * 1500) }}" id="balanceDue" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Payment Status</label>
                                    <select class="form-control" id="paymentStatus">
                                        <option value="pending">Pending</option>
                                        <option value="partial" selected>Partial</option>
                                        <option value="paid">Paid</option>
                                        <option value="overdue">Overdue</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Next Payment Due Date</label>
                                    <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime('+2 days')) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Notes</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Customer Notes</label>
                                <textarea class="form-control" rows="2" placeholder="Customer preferences and requests...">Customer wants delivery before the wedding date. Please ensure perfect finishing.</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Internal Notes</label>
                                <textarea class="form-control" rows="2" placeholder="Internal notes for staff...">VIP customer, handle with care. Priority order.</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-outline-danger" onclick="deleteOrder()">
                                <i class="las la-trash"></i> Delete Order
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                <i class="las la-redo-alt"></i> Reset Changes
                            </button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline-primary mr-2" onclick="saveAsDraft()">
                                <i class="las la-save"></i> Save Draft
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="las la-check-circle"></i> Update Order
                            </button>
                        </div>
                    </div>
                </form>
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
        // Calculate totals
        function calculateTotals() {
            let itemsTotal = parseFloat($('#itemsTotal').val()) || 0;
            let fabricCost = parseFloat($('#fabricCost').val()) || 0;
            let stitchingCharges = parseFloat($('#stitchingCharges').val()) || 0;
            let additionalCharges = parseFloat($('#additionalCharges').val()) || 0;
            let discount = parseFloat($('#discount').val()) || 0;
            let advancePaid = parseFloat($('#advancePaid').val()) || 0;

            let subtotal = itemsTotal + fabricCost + stitchingCharges + additionalCharges;
            let totalAmount = subtotal - discount;
            let balanceDue = totalAmount - advancePaid;

            $('#totalAmount').val(totalAmount.toFixed(2));
            $('#balanceDue').val(balanceDue.toFixed(2));

            // Update payment status based on amounts
            if (balanceDue <= 0) {
                $('#paymentStatus').val('paid');
            } else if (advancePaid > 0) {
                $('#paymentStatus').val('partial');
            } else {
                $('#paymentStatus').val('pending');
            }
        }

        // Initialize calculations
        $(document).ready(function() {
            calculateTotals();

            // Update totals when inputs change
            $('#itemsTotal, #fabricCost, #stitchingCharges, #additionalCharges, #discount, #advancePaid').on('input', calculateTotals);

            // Item row calculations
            $('#orderItemsTable tbody').on('input', 'input', function() {
                const row = $(this).closest('tr');
                const quantity = parseFloat(row.find('input[type="number"]').eq(0).val()) || 0;
                const price = parseFloat(row.find('input[type="number"]').eq(1).val()) || 0;
                const total = quantity * price;
                row.find('.item-total').text('Rs ' + total.toFixed(2));
                updateSubtotal();
            });
        });

        // Update subtotal
        function updateSubtotal() {
            let subtotal = 0;
            $('#orderItemsTable tbody tr').each(function() {
                const totalText = $(this).find('.item-total').text();
                const total = parseFloat(totalText.replace('Rs ', '')) || 0;
                subtotal += total;
            });
            $('#subtotal').text('Rs ' + subtotal.toFixed(2));
            $('#itemsTotal').val(subtotal);
            calculateTotals();
        }

        // Add new item
        function addNewItem() {
            const newRow = `
                <tr>
                    <td>
                        <select class="form-control form-control-sm">
                            <option value="1">Sherwani</option>
                            <option value="2">Suit</option>
                            <option value="3">Kurta</option>
                            <option value="4">Shalwar Kameez</option>
                            <option value="5">Gown</option>
                            <option value="6">Lehenga</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" placeholder="Item description">
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm" value="1" min="1">
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm" value="3000" step="0.01">
                    </td>
                    <td class="font-weight-bold item-total">
                        Rs 3000.00
                    </td>
                    <td>
                        <select class="form-control form-control-sm">
                            <option value="pending">Pending</option>
                            <option value="cutting">Cutting</option>
                            <option value="stitching">Stitching</option>
                            <option value="ready">Ready</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeItem(this)">
                            <i class="las la-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#orderItemsTable tbody').append(newRow);
            updateSubtotal();
        }

        // Remove item
        function removeItem(button) {
            if ($('#orderItemsTable tbody tr').length > 1) {
                if (confirm('Remove this item from order?')) {
                    $(button).closest('tr').remove();
                    updateSubtotal();
                }
            } else {
                alert('Order must have at least one item');
            }
        }

        // Form submission
        $('#editOrderForm').submit(function(e) {
            e.preventDefault();
            if (confirm('Update order with changes?')) {
                alert('Order updated successfully!');
                window.location.href = "{{ route('orders.show', ['id' => $id]) }}";
            }
        });

        // Save as draft
        function saveAsDraft() {
            alert('Changes saved as draft!');
        }

        // Reset form
        function resetForm() {
            if (confirm('Reset all changes?')) {
                location.reload();
            }
        }

        // Delete order
        function deleteOrder() {
            if (confirm('Are you sure you want to delete this order? This action cannot be undone.')) {
                alert('Order deletion requested!');
                // In real app: window.location.href = "/orders/{{ $id }}/delete";
            }
        }
    </script>
    @endpush
</x-app-layout>