<div class="row">
    <table id="makePaymentTable" class="table table-bordered dt-responsive nowrap makePaymentTable"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="" style="background-color: #f0f0f0;">
            <th>Company Name</th>
            <th>Product</th>
            <th>Status</th>
            <th>Action</th>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
@include('leads.appointed_leads.broker-forms.make-payment-form', compact('complianceOfficer'))
@include('leads.broker_leads.request-to-bind-form')
<script>
    $(document).ready(function() {
        $('.makePaymentTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-make-payment-list') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                }
            },
            columns: [{
                    data: 'companyName',
                    name: 'companyName'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
            order: [
                [2, 'asc']
            ],
        });

        $(document).on('click', '.companyName', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to change the status to 'Bound'?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                $.ajax({
                    url: "{{ route('change-quotation-status') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    },
                    method: "POST",
                    data: {
                        id: id,
                        status: 22,
                    },
                    success: function() {
                        Swal.fire({
                            title: 'Success',
                            text: 'has been saved',
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Something went wrong',
                            icon: 'error'
                        });
                    }
                })

            });
        });

        $(document).on('click', '.viewButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $.ajax({
                url: "{{ route('quoted-product-profile') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    window.location.href =
                        `{{ url('quoatation/broker-profile-view/${data.leadId}/${data.generalInformationId}/${data.productId}') }}`;
                }
            })
        });

        $(document).on('click', '.processButton', function(e) {
            var id = $(this).attr('id');
            $('#id').val(id);
            $('#requestToBindModal').modal('show');
        });

        $(document).on('click', '.resendButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $('#action').val('edit');
            $('#marketDropdown, #fullPayment, #downPayment').removeClass('input-error');
            $.ajax({
                url: "{{ route('get-payment-information') }}",
                method: "GET",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    var paymentMethod = response.paymentInformation.payment_method;
                    $('#paymentType').val(response.paymentInformation.payment_type);
                    $('#insuranceCompliance').val(response.paymentInformation
                        .compliance_by);
                    $('#market').val(response.market.name);
                    $('#firstName').val(response.generalInformation.firstname);
                    $('#companyName').val(response.lead.company_name);
                    $('#makePaymentEffectiveDate').val(response.quoteComparison
                        .effective_date);
                    $('#quoteNumber').val(response.quoteComparison.quote_no);
                    $('#paymentTerm').val(response.paymentInformation.payment_term);
                    $('#lastName').val(response.generalInformation.lastname);
                    $('#emailAddress').val(response.generalInformation.email_address);
                    // Set the payment method dropdown based on the fetched payment method
                    if (paymentMethod.toLowerCase() == 'checking') {
                        $('#paymentMethodMakePayment').val('Checking').trigger('change');
                    } else {
                        $('#paymentMethodMakePayment').val("Credit Card").trigger('change');
                        // Handling other card types
                        if (['Visa', 'Master Card', 'American Express'].includes(
                                paymentMethod)) {
                            $('#cardType').val(paymentMethod).trigger('change');
                        } else {
                            $('#cardType').val('Other').trigger('change');
                            $('#otherCard').val(paymentMethod);
                        }
                    }
                    $('#totalPremium').val(response.quoteComparison.full_payment);
                    $('#brokerFeeAmount').val(response.quoteComparison.broker_fee);
                    $('#chargedAmount').val(response.paymentInformation.amount_to_charged);
                    $('#note').val(response.paymentInformation.note);
                    $('#generalInformationId').val(response.generalInformation.id);
                    $('#leadsId').val(response.lead.id);
                    $('#quoteComparisonId').val(response.quoteComparison.id);
                    $('#paymentInformationId').val(response.paymentInformation.id);
                    $('#selectedQuoteId').val(response.paymentInformation
                        .selected_quote_id);
                    $('#makePaymentModal').modal('show');
                }
            });
        });

    });
</script>
