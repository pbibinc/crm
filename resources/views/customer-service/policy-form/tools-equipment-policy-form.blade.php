<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="toolsEquipmentPolicyFormModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tools Equipment Policy Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="toolsEquipmentForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="toolsEquipmentPolicyNumber">Policy Number</label>
                            <input type="text" class="form-control" id="toolsEquipmentPolicyNumber"
                                name="toolsEquipmentPolicyNumber">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="toolsEquipmentInsuredInput">Insured</label>
                            <input type="text" class="form-control" id="toolsEquipmentInsuredInput"
                                name="toolsEquipmentInsuredInput">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="toolsEquipmentMarketInput">Market</label>
                            <select name="toolsEquipmentMarketInput" id="toolsEquipmentMarketInput" class="form-select"
                                required>
                                <option value="">Select Market</option>
                                @foreach ($markets as $market)
                                    <option value="{{ $market->name }}">{{ $market->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="toolsEquipmentCarrierInput">Carrier</label>
                            <select name="toolsEquipmentCarrierInput" id="toolsEquipmentCarrierInput"
                                class="form-select" required>
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
                                <label class="form-label" for="toolsEquipmentPaymentTermInput">Payment Term</label>
                                <select class="form-select" aria-label="Default select example"
                                    id="toolsEquipmentPaymentTermInput" name="toolsEquipmentPaymentTermInput" required>
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
                                <input type="checkbox" id="toolsEquipmentAddlInsd" switch="info"
                                    name="toolsEquipmentAddlInsd">
                                <label for="toolsEquipmentAddlInsd" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Subr Wvd:</label>
                            <div class="square-switch">
                                <input type="checkbox" id="toolsEquipmentSubrWvd" switch="info"
                                    name="toolsEquipmentSubrWvd">
                                <label for="toolsEquipmentSubrWvd" data-on-label="Yes" data-off-label="No"></label>
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
                                <button class="btn btn-outline-success toolsEquipmentaddMore" type="button"
                                    id="toolsEquipmentaddMore">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="toolsEquipmentEffectiveDate">Effective Date</label>
                            <input class="form-control" type="date" value="2011-08-19"
                                id="toolsEquipmentEffectiveDate" name="toolsEquipmentEffectiveDate">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="toolsEquipmentExpirationDate">Expiration Date</label>
                            <input class="form-control" type="date" value="2011-08-19"
                                id="toolsEquipmentExpirationDate" name="toolsEquipmentExpirationDate">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12" id='toolsEquipmentFileDiv'>
                            <input type="file" name="file" id="file"
                                class="form-control toolsEquipmentPolicyFormFile">
                        </div>
                    </div>
                    <input type="hidden" name="toolsEquipmentHiddenInputId" id="toolsEquipmentHiddenInputId">
                    <input type="hidden" name="toolsEquipmentHiddenQuoteId" id="toolsEquipmentHiddenQuoteId">
                    <input type="hidden" name="toolsEquipmentHiddenPolicyId" id="toolsEquipmentHiddenPolicyId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="action_button" id="action_button" value="Add"
                        class="btn btn-primary ladda-button toolsEquipmentPolicyFornActionButton"
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

        $('#toolsEquipmentEffectiveDate').val(formattedDate);

        $('#toolsEquipmentEffectiveDate').on('change', function() {
            var effectiveDate = new Date($(this).val());
            var expirationDate = new Date(effectiveDate);

            expirationDate.setFullYear(effectiveDate.getFullYear() + 1);
            var formattedExpirationDate = expirationDate.toISOString().split('T')[0];
            $('#toolsEquipmentExpirationDate').val(formattedExpirationDate);
        });

        $('#toolsEquipmentForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var action = $('.toolsEquipmentPolicyFornActionButton').val();
            var policyId = $('#toolsEquipmentHiddenPolicyId').val();
            var url = action == 'Update' ?
                `{{ route('tools-equipment-policy.update', ':id') }}`.replace(':id', policyId) :
                "{{ route('tools-equipment-policy.store') }}";
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
                        text: 'Tools Equipment Policy has been added!',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        // if (result.isConfirmed) {
                        //     $('#toolsEquipmentPolicyFormModal').modal('hide');
                        //     $('.boundProductTable').DataTable().ajax.reload();
                        //     $('.newPolicyList').DataTable().ajax.reload();
                        // }
                        $('#toolsEquipmentPolicyFormModal').modal('hide');
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

        $(document).on('click', '.toolsEquipmentaddMore', function() {
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
                            <button class="btn btn-outline-success toolsEquipmentaddMore" type="button">+</button>
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

        $(document).on('hidden.bs.modal', '#toolsEquipmentPolicyFormModal', function() {
            $('#toolsEquipmentForm')[0].reset();
        });
    })
</script>
