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
                <input type="hidden" id="productStatus">
                <div class="row mb-2">
                    <div class="col-12">
                        <form action="" class="dropzone mt-4 border-dashed" id="dropzone"
                            enctype="multipart/form-data"></form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-danger" id="declinedButton">Declined</button>
                <button class="btn btn-info" type="" id="boundButton">Bound</button>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="declinedBindingModal" tabindex="-1" aria-labelledby="declinedBindingModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="declinedBindingModalTitle">Binding Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div>
                        <textarea required="" class="form-control" rows="5" placeholder="Type a note..."
                            id="declinedNoteDescription" required></textarea>
                        <div class="invalid-feedback" id="noteDescriptionError"></div>
                    </div>
                    <input type="hidden" name="declinedLeadId" id="declinedLeadId">
                    <input type="hidden" name="declinedHiddenProductId" id="declinedHiddenProductId">
                    <input type="hidden" id="declinedHiddenTitle" name="declinedHiddenTitle">
                    <input type="hidden" id="userToNotify" name="userToNotify">
                    <input type="hidden" id="bindingProductStatus" name="bindingProductStatus">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-primary waves-effect waves-light"
                    id="declinedLogNote"><i class="ri-send-plane-fill"></i>Log Note</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#boundButton').on('click', function(e) {
            e.preventDefault();
            var id = $('#hiddenId').val();
            var productStatus = $('#productStatus').val();
            var parsedStatus = parseInt(productStatus, 10);
            var status = 11;
            switch (parsedStatus) {
                case 19:
                    status = 20;
                    break;
                case 12:
                    status = 11;
                    break;
                case 25:
                    status = 26;
                    break;
                default:
                    status = 11;
                    break;
            }
            $.ajax({
                url: "{{ route('save-bound-information') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                data: {
                    id: id,
                    productStatus: parsedStatus
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
                            status: status,
                            id: id
                        },
                        success: function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'has been saved',
                                icon: 'success'
                            }).then((result) => {
                                // if (result.isConfirmed) {
                                //     $('.boundProductTable').DataTable()
                                //         .ajax.reload();
                                //     $('.getConfimedProductTable')
                                //         .DataTable().ajax.reload();
                                //     $('#dataModal').modal('hide');
                                // }
                                location.reload();
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

        });

        $('#declinedLogNote').on('click', function(e) {
            e.preventDefault();
            var noteTitle = $('#declinedHiddenTitle').val();
            var productId = $('#declinedHiddenProductId').val();
            var leadId = $('#declinedLeadId').val();
            var noteDescription = $('#declinedNoteDescription').val();
            var userToNotify = $('#userToNotify').val();
            var bindingProductStatus = $('#bindingProductStatus').val();
            var status = 14;
            if (bindingProductStatus == 19) {
                status = 23;
            } else if (bindingProductStatus == 18) {
                status = 23;
            } else if (bindingProductStatus == 25) {
                status = 27;
            } else if (bindingProductStatus == 28) {
                status = 27;
            } else {
                status = 14;
            }

            $.ajax({
                url: "{{ route('create-notes') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                method: "POST",
                data: {
                    icon: 'error',
                    userToNotify: [userToNotify],
                    noteTitle: noteTitle,
                    noteDescription: noteDescription,
                    leadId: leadId,
                    status: 'Declined Binding'
                },
                success: function(data) {
                    // $productStatus = $product
                    $.ajax({
                        url: "{{ route('change-quotation-status') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        },
                        method: "POST",
                        data: {
                            id: productId,
                            status: status,
                        },
                        success: function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'has been saved',
                                icon: 'success'
                            }).then((result) => {
                                location.reload();
                                // if (result.isConfirmed) {
                                //     $('.getConfimedProductTable')
                                //         .DataTable().ajax.reload();
                                //     $('.incompleteBindingTable')
                                //         .DataTable().ajax.reload();
                                //     $('#declinedBindingModal')
                                //         .modal(
                                //             'hide')
                                // }
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
                error: function(jqXHR, testStatus, errorThrown) {

                }
            });
        });

    });
</script>
