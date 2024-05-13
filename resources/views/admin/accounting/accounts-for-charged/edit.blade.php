<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormTitle">Payment Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editPaymentChargedForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-12">
                            <label for="paymentType">Invoice Number:</label>
                            <input type="text" class="form-control" id="invoiceNumber" name="invoiceNumber">
                        </div>
                    </div>
                    <input type="hidden" value="" id="paymentChargedId" name="paymentChargedId">
                    <input type="hidden" name="paymentType" id="paymentType">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                <input type="submit" class="btn btn-success">
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#editPaymentChargedForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: "{{ route('payment-charged.update') }}",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Payment has been updated!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#modalForm').modal('hide');
                            $('#accountsCharged').DataTable().ajax.reload();
                        }
                    })

                }
            })
        });
    })
</script>
