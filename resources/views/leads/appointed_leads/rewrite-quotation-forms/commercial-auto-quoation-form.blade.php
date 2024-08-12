<style>
    .input-error {
        border: 1px solid red;
        /* or background-color: #ffcccc; for a red background */
    }
</style>
<div class="row mb-2">
    <div class="col-6 title-card">
        <h4 class="card-title mb-0" style="color: #ffffff">Commercial Auto Policy Quoation Form</h4>
    </div>
    <div class="d-flex justify-content-between">
        <div>
        </div>
        <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addQuoteModal" id="create_record">
            ADD QUOTE
        </a>
    </div>
</div>

<div class="row">
    <table id="qoutation-table" class="table table-bordered dt-responsive nowrap"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>Market</th>
                <th>Full Payment</th>
                <th>Down Payment</th>
                <th>Monthly Payment</th>
                <th>Broker Fee</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="modal fade" id="addQuoteModal" tabindex="-1" aria-labelledby="addQuoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuoteModalLabel">Add Position</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="quotationForm">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-12">
                            <label for="marketDropdown">Market</label>
                            <select name="marketDropdown" id="marketDropdown" class="form-select">
                                <option value="">Select Market</option>
                                @foreach ($quationMarket as $market)
                                    <option value={{ $market->id }}>{{ $market->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="fullPayment" class="form-label">Full Payment</label>
                            <input type="text" class="form-control" id="fullPayment" name="fullPayment" required>
                        </div>
                        <div class="col-6">
                            <label for="downPayment" class="form-label">Down Payment</label>
                            <input type="text" class="form-control" id="downPayment" name="downPayment" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="monthlyPayment" class="form-label">Monthly Payment</label>
                            <input type="text" class="form-control" id="monthlyPayment" name="monthlyPayment"
                                required>
                        </div>
                        <div class="col-6">
                            <label for="brokerFee" class="form-label">Broker Fee</label>
                            <input type="text" class="form-control" id="brokerFee" name="brokerFee" required>
                        </div>
                    </div>
                    <input type="hidden" name="action" id="action" value="add">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="productId" id="productId" value="{{ $quoteProduct->id }}">
                    <input type="hidden" name="recommended" id="recommended_hidden" value="1" />
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" class="form-check-input" id="reccomended" checked="">
                    <label class="form-check-label" for="reccomended">Reccomend this Quote</label>
                </div>
                <div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="action_button" id="action_button" value="Add"
                        class="btn btn-primary">
                </div>
            </div>
            </form>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        var id = {{ $quoteProduct->id }};
        $('#qoutation-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                url: "{{ route('get-general-liabilities-quotation-table') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                }
            },
            columns: [{
                    data: 'market_name',
                    name: 'market_name'
                },
                {
                    data: 'full_payment',
                    name: 'full_payment'
                },
                {
                    data: 'down_payment',
                    name: 'down_payment'
                },
                {
                    data: 'monthly_payment',
                    name: 'monthly_payment'
                },
                {
                    data: 'broker_fee',
                    name: 'broker_fee'
                },
                {
                    data: 'renewal_action_dropdown',
                    name: 'renewal_action_dropdown',
                    orderable: false
                }
            ]
        });

        //checkbox for recommended
        $('#reccomended').change(function() {
            if ($(this).is(':checked')) {
                $('#recommended_hidden').val(1);
            } else {
                $('#recommended_hidden').val(0);
            }
        });

        //deletion of quote
        $(document).on('click', '.deleteButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete-quotation-comparison') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'has been deleted',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#qoutation-table').DataTable().ajax
                                        .reload();
                                }
                            })
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error',
                                text: 'Something went wrong',
                                icon: 'error'
                            });
                        }
                    })
                }
            });
        });

        $(document).on('click', '#create_record', function(e) {
            e.preventDefault();
            $('#action').val('add');
            $('#marketDropdown, #fullPayment, #downPayment').removeClass('input-error');
            $('#addQuoteModal').modal('show');
            $('#action_button').val('Add');
        });
        //edit button functionalities
        $(document).on('click', '.editButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $('#action').val('edit');
            $('#marketDropdown, #fullPayment, #downPayment').removeClass('input-error');
            $.ajax({
                url: "{{ route('edit-quotation-comparison') }}",
                method: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    $('#marketDropdown').val(String(response.data.quotation_market_id));
                    $('#fullPayment').val(response.data.full_payment);
                    $('#downPayment').val(response.data.down_payment);
                    $('#monthlyPayment').val(response.data.monthly_payment);
                    $('#brokerFee').val(response.data.broker_fee);
                    $('#hidden_id').val(response.data.id);
                    $('#productId').val(response.data.quotation_product_id);
                    $('#action_button').val('Update');
                    if (response.data.recommended == 1) {
                        $('#reccomended').prop('checked', true);
                    } else {
                        $('#reccomended').prop('checked', false);
                    }
                    $('#addQuoteModal').modal('show');
                }
            });

        });


        //SUBMISSION OF FORM WITH VALIDATION FOR FULL PAYMENT AND DOWN PAYMENT


        //submition of form
        $('#quotationForm').on('submit', function(event) {
            event.preventDefault();
            var action_url = '';
            $('#marketDropdown, #fullPayment, #downPayment').removeClass('input-error');
            let fullPayment = parseFloat($('#fullPayment').val()) || 0;
            let downPayment = parseFloat($('#downPayment').val()) || 0;

            if ($('#action').val() == 'add') {
                action_url = "{{ route('save-quotation-comparison') }}";
            }

            if ($('#action').val() == 'edit') {
                action_url = "{{ route('update-quotation-comparison') }}";
            }
            if (fullPayment < downPayment) {
                $('#fullPayment').addClass('input-error');
                $('#downPayment').addClass('input-error');
            } else {
                $.ajax({
                    url: action_url,
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Quotation Comparison has been saved',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            $('#addQuoteModal').modal('hide');
                            $('#qoutation-table').DataTable().ajax.reload();
                        });
                    },
                    error: function(data) {
                        var errors = data.responseJSON.errors;
                        console.log(data);
                        if (data.status == 422) {
                            Swal.fire({
                                title: 'Error',
                                text: data.responseJSON.error,
                                icon: 'error'
                            });
                            $('#marketDropdown').addClass('input-error');
                        }
                        if (errors) {
                            $.each(errors, function(key, value) {
                                $('#' + key).addClass('input-error');
                                $('#' + key + '_error').html(value);
                            });
                        }
                    }
                });
            }
        });



        //
        $('#brokerFee').on('focus', function() {
            let currentBrokerFee = parseFloat($(this).val()) || 0;
            $(this).data('lastBrokerFee', currentBrokerFee);
        });

        //code for dynami input changing the value
        $('#brokerFee').on('input', function() {
            const currentBrokerFee = parseFloat($(this).val()) || 0;
            const lastBrokerFee = $(this).data('lastBrokerFee') || 0;

            let fullPayment = parseFloat($('#fullPayment').val()) || 0;
            let downPayment = parseFloat($('#downPayment').val()) || 0;

            //subtract last broker fee and add new broker fee
            fullPayment = fullPayment - lastBrokerFee + currentBrokerFee;
            downPayment = downPayment - lastBrokerFee + currentBrokerFee;

            // Update their values
            $('#fullPayment').val(fullPayment);
            $('#downPayment').val(downPayment);

            // Update the last broker fee for the next change
            $(this).data('lastBrokerFee', currentBrokerFee);
        });

        //function for resetting the input inside modal
        $('#addQuoteModal').on('hide.bs.modal', function() {
            // Reset the content of the modal
            $(this).find('form').trigger('reset'); // Reset all form fields
            // If there are other elements to clear, handle them here
            $('#marketDropdown, #fullPayment, #downPayment').removeClass('input-error');
        });
    });
</script>
