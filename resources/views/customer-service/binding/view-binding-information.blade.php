<div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalTitle">Binding Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="companyName">Company Name:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="companyName">
                        </h6>

                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="insuredName">Insured Name:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="insuredName">
                        </h6>
                    </div>

                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="state">State:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="state"></h6>

                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="market">Market:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="market"></h6>
                    </div>

                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="product">Product:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="product"></h6>

                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="totalPolicyCost">Total Policy Cost:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="totalPolicyCost"></h6>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="policyNum">Policy Num:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="policyNum"></h6>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="effectiveDate">Effective Date</label>
                    </div>
                    <div class="col-9">
                        <h6 id="bindingEffectiveDate"></h6>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="paymentType">Payment Type</label>
                    </div>
                    <div class="col-9">
                        <h6 id="paymentType"></h6>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="paymentApprovedBy">Payment Approved by:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="paymentApprovedBy"></h6>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="inovoiceNumber">Invoice Number:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="inovoiceNumber"></h6>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label for="paymentAprrovedDate">Date:</label>
                    </div>
                    <div class="col-9">
                        <h6 id="paymentAprrovedDate"></h6>
                    </div>
                </div>
                <input type="hidden" id="hiddenId">

                <div class="row mb-2">
                    <div class="col-12">
                        <form action="" class="dropzone mt-4 border-dashed" id="dropzone"
                            enctype="multipart/form-data"></form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-info" type="" id="boundButton">Bound</button>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#boundButton').on('click', function(e) {
            e.preventDefault();
            console.log('test this code');
            var id = $('#hiddenId').val();

            $.ajax({
                url: "{{ route('save-bound-information') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                data: {
                    id: id
                },
                success: function() {
                    $.ajax({
                        url: "{{ route('change-quotation-status') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        },
                        method: "POST",
                        data: {
                            status: 11,
                            id: id
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
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Something went wrong',
                        icon: 'error'
                    });
                }
            })

        })
    });
</script>