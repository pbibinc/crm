<table id="renewalReminderTable" class="table table-bordered dt-responsive nowrap" style="width: 100%;">
    <thead>
        <tr style="background-color: #f0f0f0;">
            <th>Policy Number</th>
            <th>Company Name</th>
            <th>Product</th>
            <th>Previous Policy Price</th>
            <th>Renewal Date</th>
            <th>Sent Email Reminder</th>
            <th>Action</th>
        </tr>
    </thead>
</table>

<div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true" id="setRenewalReminderEmail">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Renewal Reminder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="date-container">
                    <div class="row"> <label for="">Date</label></div>
                    <div class="row mb-3">
                        <div class="col-10">

                            <input class="form-control date-time-input" type="datetime-local" id="dateTime">
                        </div>

                        <div class="col-1">
                            <button type="button" class="btn btn-success" id="addDate">+</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="quotationProductId" hidden>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light"
                    id="submitRenewalReminder">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#renewalReminderTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ route('renewal.get-renewal-reminder') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columns": [{
                    data: 'policy_no',
                    name: 'policy_no'
                },
                {
                    data: 'company_name',
                    name: 'company_name'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'previous_policy_price',
                    name: 'previous_policy_price'
                },
                {
                    data: 'expiration_date',
                    name: 'expiration_date'
                },
                {
                    data: 'emailSentCount',
                    name: 'emailSentCount'
                },
                {
                    data: 'action',
                    name: 'action',
                }

            ]
        });

        $(document).on('click', '.renewalReminder', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to process this renewal!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, process it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('customer-service/change-policy-status') }}/" + id,
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                            status: 'Renewal Quote'
                        },
                        success: function(data) {
                            Swal.fire(
                                'Success!',
                                'Renewal Processed Successfully.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            })
                        }
                    });
                }
            });
        });

        $(document).on('click', '.sentEmailButton', function(e) {
            e.preventDefault();
            $('#quotationProductId').val($(this).data('product-id'));
            $('#setRenewalReminderEmail').modal('show');
        });

        $('#addDate').click(function() {
            var newDateInput = '<div class="row mb-3">' +
                '<div class="col-10">' +
                '<input class="form-control date-time-input" type="datetime-local">' +
                '</div>' +
                '<div class="col-2">' +
                '<button type="button" class="btn btn-danger removeDate">-</button>' +
                '</div>' +
                '</div>';
            $('.date-container').append(newDateInput);
        });

        // Use event delegation for dynamically added elements
        $('.date-container').on('click', '.removeDate', function() {
            $(this).closest('.row').remove(); // Remove the closest row div to the button clicked
        });

        $('#submitRenewalReminder').on('click', function() {
            var dataTime = $('#dateTime').val();
            var dateTimeValues = $('.date-time-input').map(function() {
                return $(this).val();
            }).get();
            $.ajax({
                url: "{{ route('messages.store') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    dateTime: dateTimeValues,
                    productId: $('#quotationProductId').val(),
                    templateId: 2,
                    type: 'Renewal Reminder'
                },
                success: function(data) {
                    Swal.fire(
                        'Success!',
                        'Renewal Email Sent Successfully.',
                        'success'
                    ).then((result) => {
                        location.reload();
                    })
                },
                error: function(data) {
                    Swal.fire(
                        'Error!',
                        'Renewal Email Not Sent.',
                        'error'
                    ).then((result) => {
                        // location.reload();
                    })
                }
            })
        });

    })
</script>
