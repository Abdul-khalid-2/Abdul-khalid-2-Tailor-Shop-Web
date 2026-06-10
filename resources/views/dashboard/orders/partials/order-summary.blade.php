<x-ui.card title="Order Summary" class="border-left-primary mb-0">
    <div class="d-flex justify-content-between mb-3">
        <span class="text-muted">Total Amount</span>
        <span class="font-weight-bold h5 mb-0" x-text="'Rs ' + totalAmount.toFixed(2)"></span>
    </div>
    <div class="d-flex justify-content-between mb-3">
        <span class="text-muted">Advance Paid</span>
        <span class="font-weight-bold" x-text="'Rs ' + (parseFloat(advancePaid) || 0).toFixed(2)"></span>
    </div>
    <hr>
    <div class="d-flex justify-content-between">
        <span class="font-weight-bold">Balance Due</span>
        <span class="font-weight-bold h5 mb-0" :class="balanceDue > 0 ? 'text-warning' : 'text-success'"
              x-text="'Rs ' + balanceDue.toFixed(2)"></span>
    </div>
</x-ui.card>
