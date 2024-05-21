<div class="row">
    <table id="creationOfPFA" class="table table-bordered dt-responsive nowrap creationOfPFA"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead style="background-color: #f0f0f0;">
            <th>Policy Number</th>
            <th>Company Name</th>
            <th>Product</th>
            <th>Total Cost</th>
            <th>Effective Date</th>
        </thead>
    </table>
</div>

<div class="modal fade" id="createPfaModal" tabindex="-1" aria-labelledby="createPfaModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPfaModalgModalTitle">Create Financing Agreement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="createPfaForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="form-label">Policy Number</label>
                                <input type="text" class="form-control" id="policyNumber" name="policyNumber"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="form-label">Product</label>
                                <input type="text" class="form-control" id="product" name="product" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="form-label">Financing Company</label>
                                <select name="financingCompany" id="financingCompany" class="form-control" required>
                                    <option value="">Select Financing Company</option>
                                    @foreach ($financeCompany as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="form-label">Monthly Payment</label>
                                <input type="text" class="form-control input-mask text-left"
                                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                    inputmode="decimal" style="text-align: right;" id="monthlyPayment"
                                    name="monthlyPayment">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Payment Start</label>
                                <input class="form-control" type="date" value="2011-08-19" id="paymentStart"
                                    name="paymentStart" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Due Date</label>
                                <input class="form-control" type="number" id="dueDate" min="1" max="31"
                                    name="dueDate" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="form-label">Upload File</label>
                                <input type="file" name="pfaFile" id="pfaFile" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="form-label">Auto Pay</label>
                                <div class="square-switch">
                                    <input type="checkbox" id="isAutoPay" switch="info" name="isAutoPay">
                                    <label for="isAutoPay" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="" id="payOptionLabel" hidden>Pay Option</label>
                            <select name="payOption" class="form-select" id="payOption" hidden>
                                <option value="">Select Payment Option</option>
                                <option value="Recurring ACH">Recurring ACH</option>
                                <option value="Recurring Credit Card">Recurring Credit Card</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="" id="autoPayFileLabel" hidden>Upload File</label>
                            <input type="file" name="autoPayFile" id="autoPayFile" class="form-control" hidden>
                        </div>
                    </div>
                    <input type="hidden" name="selectedQuoteId" id="selectedQuoteId">
                    <input type="hidden" name="autoPay" id="autoPay" value="0">
                    <input type="hidden" name="financialStatusId" id="financialStatusId" value="0">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var token = '{{ csrf_token() }}';
        $('.creationOfPFA').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('financing-aggreement.creation-of-pfa') }}",
                type: "POST",
            },
            columns: [{
                    data: 'policy_number',
                    name: 'policy_number'
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
                    data: 'full_payment',
                    name: 'full_payment'
                },
                {
                    data: 'effective_date',
                    name: 'effective_date'
                }
            ],
        });

        $('#isAutoPay').on('change', function() {
            if ($(this).is(':checked')) {
                $('#autoPay').val(1);
                $('#payOption').removeAttr('hidden', false);
                $('#autoPayFile').removeAttr('hidden', false);
                $('#payOptionLabel').removeAttr('hidden', false);
                $('#autoPayFileLabel').removeAttr('hidden', false);
            } else {
                $('#autoPay').val(0);
                $('#payOption').attr('hidden', true);
                $('#autoPayFile').attr('hidden', true);
                $('#payOptionLabel').attr('hidden', true);
                $('#autoPayFileLabel').attr('hidden', true);
            }
        });

        $(document).on('click', '.createPfa', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            var financingId = $(this).attr('data-financing-id');
            $.ajax({
                url: `{{ url('customer-service/financing/financing-agreement') }}/${id}/edit`,
                type: "GET",
                data: {
                    id: id,
                    financingId: financingId,
                    _token: token
                },
                success: function(response) {
                    $('#policyNumber').val(response.selectedQuote.quote_no);
                    $('#product').val(response.quoteProduct.product);
                    $('#createPfaModalgModalTitle').text(response.leads.company_name);
                    $('#monthlyPayment').val(response.selectedQuote.monthly_payment);
                    $('#selectedQuoteId').val(response.selectedQuote.id);
                    $('#financialStatusId').val(response.financialStatus.id);
                    $('#createPfaModal').modal('show');
                }
            })
        });

        $('#createPfaForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('financing-agreement.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire(
                        'Success!',
                        response.message,
                        'success'
                    ).then((result) => {
                        $('#createPfaModal').modal('hide');
                        location.reload();
                    })
                },
                error: function(response) {
                    Swal.fire(
                        'Error!',
                        response.responseJSON.message ||
                        'Financing Agreement Creation Failed!',
                        'error'
                    )
                }
            })
        });
    })
</script>
