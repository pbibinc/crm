<div class="row mb-3">
    <div class="col-6">
        <div class="row">
            <div class="col-6">
                <label for="">Select User:</label>
                <div>
                    <select name="makepaymentUserProfileDropdown" id="makepaymentUserProfileDropdown" class="form-select">
                        <option value="">Select User</option>
                        @foreach ($userProfiles as $userProfile)
                            <option value="{{ $userProfile->id }}">{{ $userProfile->fullAmericanName() }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">

        </div>
    </div>
</div>
<div class="row">
    <table id="quotedPolicyMakePayment" class="table table-bordered dt-responsive nowrap quotedPolicyMakePayment"
        style="width:100%;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th>Current Policy Number</th>
                <th>Company Name</th>
                <th>Product</th>
                <th>Previous Policy Cost</th>
                <th>Current Policy Cost</th>
                <th>Assigned To</th>
                <th>Payment Status</th>
                <th>Renewal Date</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>
{{-- @include('leads.appointed_leads.request-to-bind-form.renewal-request-to-bind-form', [
    'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
        $product->product,
        $lead->quoteLead->QuoteInformation->id),
]) --}}

@include('leads.appointed_leads.broker-forms.make-payment-form', compact('complianceOfficer'))
@include('leads.appointed_leads.log-activity.note-modal')
<div class="modal fade bs-example-modal-center" id="requestToBindModal" tabindex="-1" role="dialog"
    aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestToBindModalTitle">Upload Request To Bind Files</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="rtbForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <input type="file" class="form-control" id="files" name="files[]" multiple>
                        </div>
                    </div>

                    <input type="hidden" id="id" name="id" value="">
            </div>

            <div class="modal-footer">
                <input type="submit" name="sendRequesToBindFile" id="sendRequesToBindFile" value="Submit"
                    class="btn btn-success">
                <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.quotedPolicyMakePayment').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ route('renewal-make-payment-list') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function(d) {
                    d.userProfileDropdown = $('#makepaymentUserProfileDropdown').val();
                },
                method: "POST"
            },
            "columns": [{
                    data: 'current_policy_no',
                    name: 'current_policy_no'
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
                    data: 'current_policy_cost',
                    name: 'current_policy_cost'
                },
                {
                    data: 'assignedTo',
                    name: 'assignedTo'
                },
                {
                    data: 'paymentStatus',
                    name: 'paymentStatus'
                },
                {
                    data: 'expiration_date',
                    name: 'expiration_date'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        })

        $('#makepaymentUserProfileDropdown').on('change', function() {
            $('#quotedPolicyMakePayment').DataTable().draw();
        });

        $(document).on('click', '.processButton', function() {
            var id = $(this).attr('id');
            $('#id').val(id);
            $('#requestToBindModal').modal('show');
        });

        $('#sendRequesToBindFile').on('click', function(e) {
            e.preventDefault();
            var formData = new FormData($('#rtbForm')[0]);
            var id = $('#id').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                url: "{{ route('product-save-media') }}",
                method: "POST",
                data: formData,
                // dataType: "json",
                contentType: false,
                // cache: false,
                processData: false,
                success: function(data) {
                    $.ajax({
                        url: "{{ route('change-quotation-status') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        },
                        method: "POST",
                        data: {
                            status: 17,
                            id: id,
                            renewalStatus: 'true',
                            policyStatus: 'Renewal Request To Bind'
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
                },
                error: function(e) {
                    console.log(e);
                    Swal.fire({
                        title: 'Error',
                        text: 'Something went wrong',
                        icon: 'error'
                    });
                }
            });
        });

        $(document).on('click', '.resendButton', function() {
            var id = $(this).attr('id');
            var policyId = $(this).attr('data-policy-id');
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
                    $('#policyDetailId').val(policyId);
                    $('#selectedQuoteId').val(response.paymentInformation
                        .selected_quote_id);
                    $('#makePaymentModal').modal('show');
                }
            })
        });

        $(document).on('click', '.viewNoteButton', function() {
            var id = $(this).attr('id');
            var url = `/note/${id}/get-lead-note`;
            var departmentIds = [2, 3];
            $.ajax({
                url: url,
                type: "get",
                data: {
                    id: id
                },
                success: function(response) {
                    var html =
                        '<div class="scrollable" style="height: 500px; overflow-y: auto;">';
                    var notes = Array.isArray(response.notes) ? response.notes : Array
                        .isArray(response) ? response : [];
                    notes.forEach(function(note) {
                        var noteClass = '';
                        if (note.status === 'declined-make-payment' || note
                            .status === 'Declined Binding') {
                            noteClass = 'danger';
                        } else if (note.status === 'yet-another-status') {
                            noteClass = 'yet-another-class';
                        }
                        var senderOrReceiverClass = (response.userProfileId == note
                            .user_profile_id) ? 'sender' : 'receiver';
                        var userInfo = (response.userProfileId == note
                                .user_profile_id) ?
                            'sender-info' : '';
                        var marginLeft = (response.userProfileId != note
                                .user_profile_id) ?
                            'style="margin-left: 10px"' : '';

                        html += `<div class="message-box ${senderOrReceiverClass} p-3 rounded ${noteClass}">
                        <div><strong>${note.title}</strong></div>
                        <div class="message-content">${note.description}</div>
                    </div>
                    <div class="message-info ${userInfo}" ${marginLeft}>
                        <p class="note-date font-2 text-muted">sent by: ${note.user_profile.american_name} ${new Date(note.created_at).toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' })}</p>
                    </div>`;
                    });
                    $('#notesContainer').html(html);
                    $('#departmentIds').val(JSON.stringify(departmentIds));
                    $('#leadId').val(id);
                    $('#notesModal').modal('show');
                }
            });
        });
    });
</script>
