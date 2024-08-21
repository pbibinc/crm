<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="businessOwnersPolicyFormModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Business Owners Policy Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="businessOwnersPolicyForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="businessOwnersNumber">Policy Number</label>
                            <input type="text" class="form-control" id="businessOwnersNumber"
                                name="businessOwnersNumber">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="businessOwnersInsuredInput">Insured</label>
                            <input type="text" class="form-control" id="businessOwnersInsuredInput"
                                name="businessOwnersInsuredInput">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="businessOwnersMarketInput">Market</label>
                            <select name="businessOwnersMarketInput" id="businessOwnersMarketInput" class="form-select">
                                <option value="">Select Market</option>
                                @foreach ($markets as $market)
                                    <option value="{{ $market->name }}">{{ $market->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="businessOwnersCarrierInput">Carrier</label>
                            <select name="businessOwnersCarrierInput" id="businessOwnersCarrierInput"
                                class="form-select">
                                <option value="">Select Carrier</option>
                                @foreach ($carriers as $carrier)
                                    <option value="{{ $carrier->name }}">{{ $carrier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="businessOwnersPaymentTermInput">Payment Term</label>
                                <select class="form-select" aria-label="Default select example"
                                    id="businessOwnersPaymentTermInput" name="businessOwnersPaymentTermInput">
                                    <option selected="">Open this select menu</option>
                                    <option value="PIF">PIF</option>
                                    <option value="Low down">Low down</option>
                                    <option value="Split PIF">Split PIF</option>
                                    <option value="Split low down">Split low down</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label">Addl Insd:</label>
                            <div class="square-switch">
                                <input type="checkbox" id="businessOwnersAddlInsd" switch="info"
                                    name="businessOwnersAddlInsd">
                                <label for="businessOwnersAddlInsd" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Subr Wvd:</label>
                            <div class="square-switch">
                                <input type="checkbox" id="businessOwnersSubrWvd" switch="info"
                                    name="businessOwnersSubrWvd">
                                <label for="businessOwnersSubrWvd" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="blankLimits">Blank Limits</label>
                            <input type="text" class="form-control" id="blankLimits" name="newBlankLimits[]">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="blankValue">Blank Value</label>
                            <div class="input-group">
                                <input type="text" class="form-control input-mask text-left"
                                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                    inputmode="decimal" style="text-align: right;" id="blankValue"
                                    name="newBlankValue[]">
                                <button class="btn btn-outline-success businessOwnersSubrWvdaddMore" type="button"
                                    id="businessOwnersSubrWvdaddMore">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="businessOwnersEffectiveDate">Effective Date</label>
                            <input class="form-control" type="date" value="2011-08-19"
                                id="businessOwnersEffectiveDate" name="businessOwnersEffectiveDate">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="businessOwnersExpirationDate">Expiration Date</label>
                            <input class="form-control" type="date" value="2011-08-19"
                                id="businessOwnersExpirationDate" name="businessOwnersExpirationDate">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12" id="businessOwnersFileDiv">
                            <input type="file" name="file" id="file"
                                class="form-control businessOwnersPolicyFile">
                        </div>
                    </div>
                    <input type="hidden" name="businessOwnersHiddenInputId" id="businessOwnersHiddenInputId">
                    <input type="hidden" name="businessOwnersHiddenQuoteId" id="businessOwnersHiddenQuoteId">
                    <input type="hidden" name="businessOwnersPolicyId" id="businessOwnersPolicyId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="action_button" id="action_button" value="Add"
                        class="btn btn-primary ladda-button businessOwnersPolicyActionButton"
                        data-style="expand-right">
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var today = new Date();

        var formattedDate = today.getFullYear() + '-' +
            ('0' + (today.getMonth() + 1)).slice(-2) + '-' +
            ('0' + today.getDate()).slice(-2);

        $('#businessOwnersEffectiveDate').val(formattedDate);
        $('#businessOwnersEffectiveDate').on('change', function() {
            var effectiveDate = new Date($(this).val());
            var expirationDate = new Date(effectiveDate);

            expirationDate.setFullYear(effectiveDate.getFullYear() + 1);
            var formattedExpirationDate = expirationDate.toISOString().split('T')[0];
            $('#businessOwnersExpirationDate').val(formattedExpirationDate);
        });

        $('#businessOwnersPolicyForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var id = $('#businessOwnersPolicyId').val();
            var action = $('.businessOwnersPolicyActionButton').val();
            var url = action == 'Update' ? "{{ route('business-owner-policy.update', ':id') }}".replace(
                    ':id', id) :
                "{{ route('business-owner-policy.store') }}";
            var method = 'POST';
            if (action == 'Update') {
                formData.append('_method', 'PUT');
                formData.delete('file'); // If you want to exclude the file input
            }
            $.ajax({
                url: url,
                type: method,
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false,
                dataType: "json",
                success: function(data) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Business Owners Policy has been added!',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        // if (result.isConfirmed) {
                        //     $('#businessOwnersPolicyFormModal').modal('hide');
                        //     $('.boundProductTable').DataTable().ajax.reload();
                        //     $('.newPolicyList').DataTable().ajax.reload();
                        // }
                        $('#businessOwnersPolicyFormModal').modal('hide');
                        location.reload();
                    });
                },
                error: function(data) {
                    console.log(data);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }
            })
        });

        $(document).on('click', '.businessOwnersSubrWvdaddMore', function() {
            var newRowHtml = `
            <div class="row mb-2">
                <div class="col-6">
                    <label class="form-label">New Blank Limits</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="newBlankLimits[]">
                    </div>
                </div>
                <div class="col-6">
                    <label class="form-label">New Blank Value</label>
                    <div class="input-group">
                        <input type="text" class="form-control input-mask text-left"  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                    inputmode="decimal" style="text-align: right;" name="newBlankValue[]">
                            <button class="btn btn-outline-success businessOwnersSubrWvdaddMore" type="button">+</button>
                            <button class="btn btn-outline-danger deleteRow" type="button">-</button>
                    </div>
                </div>
            </div>
           `;
            // Append the new row to the container
            $(this).closest('.row.mb-2').after(newRowHtml);
            // Re-initialize input masks for new inputs, if necessary
            // $(".input-mask").inputmask();
            $(".input-mask").inputmask({
                'alias': 'numeric',
                'groupSeparator': ',',
                'digits': 2,
                'digitsOptional': false,
                'prefix': '$ ',
                'placeholder': '0'
            });
        });

        $(document).on('click', '.deleteRow', function() {
            $(this).closest('.row.mb-2').remove();
        });

        $(document).on('hide.bs.modal', '#businessOwnersPolicyFormModal', function() {
            $('#businessOwnersPolicyForm')[0].reset();
        });
    })
</script>
