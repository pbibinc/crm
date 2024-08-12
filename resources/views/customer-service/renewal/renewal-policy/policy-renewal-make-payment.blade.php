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
    });
</script>
