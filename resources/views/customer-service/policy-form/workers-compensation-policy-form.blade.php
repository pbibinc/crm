<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="workersCompensationModalForm">
    <div class="modal-dialog modal-dialog-centered modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Workers Compensation Policy Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="workersCompensationForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="workersCompensationPolicyNumber">Policy Number</label>
                            <input type="text" class="form-control" id="workersCompensationPolicyNumber"
                                name="workersCompensationPolicyNumber">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="workersCompensationInsuredInput">Insured</label>
                            <input type="text" class="form-control" id="workersCompensationInsuredInput"
                                name="workersCompensationInsuredInput">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="workersCompensationMarketInput">Market</label>
                            <select name="workersCompensationMarketInput" id="workersCompensationMarketInput"
                                class="form-select">
                                <option value="">Select Market</option>
                                @foreach ($markets as $market)
                                    <option value="{{ $market->name }}">{{ $market->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="workersCompensationCarrierInput">Carrier</label>
                            <select name="workersCompensationCarrierInput" id="workersCompensationCarrierInput"
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
                                <label class="form-label" for="workersCompensationPaymentTermInput">Payment Term</label>
                                <select class="form-select" aria-label="Default select example"
                                    id="workersCompensationPaymentTermInput" name="workersCompensationPaymentTermInput"
                                    required>
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
                            <label class="form-label">Subr Wvd:</label>
                            <div class="square-switch">
                                <input type="checkbox" id="workersCompSubrWvd" switch="info" name="workersCompSubrWvd">
                                <label for="workersCompSubrWvd" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Per Statute:</label>
                            <div class="square-switch">
                                <input type="checkbox" id="workersPerstatute" switch="info" name="workersPerstatute">
                                <label for="workersPerstatute" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="">Employer's Liability:</label>
                        <div class="col-4">
                            <label class="form-label" for="">EACH ACCIDENT</label>
                            <input type="text" class="form-control input-mask text-left"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" id="elEachAccident" name="elEachAccident"
                                required autocomplete="off">
                        </div>
                        <div class="col-4">
                            <label class="form-label" for="">DISEASE-POLICY LIMIT</label>
                            <input type="text" class="form-control input-mask text-left"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" id="elDiseasePolicyLimit"
                                name="elDiseasePolicyLimit" required autocomplete="off">
                        </div>
                        <div class="col-4">
                            <label class="form-label" for="">DISEASE-EACH EMPLOYEE</label>
                            <input type="text" class="form-control input-mask text-left"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" id="elDiseaseEachEmployee"
                                name="elDiseaseEachEmployee" required autocomplete="off">
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
                                <button class="btn btn-outline-success addMore" type="button"
                                    id="addMore">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="workersCompensationEffectiveDate">Effective Date</label>
                            <input class="form-control" type="date" value="2011-08-19"
                                id="workersCompensationEffectiveDate" name="workersCompensationEffectiveDate">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="workersCompensationExpirationDate">Expiration Date</label>
                            <input class="form-control" type="date" value="2011-08-19"
                                id="workersCompensationExpirationDate" name="workersCompensationExpirationDate">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <input type="file" id="file" name="file"
                                class="form-control workersCompensationPolicyFormFile">
                        </div>
                    </div>
                    <input type="hidden" name="workersCompensationHiddenInputId"
                        id="workersCompensationHiddenInputId">
                    <input type="hidden" name="workersCompensationHiddenQuoteId"
                        id="workersCompensationHiddenQuoteId">
                    <input type="hidden" name="workersCompensationHiddenPolicyId"
                        id="workersCompensationHiddenPolicyId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" value="Submit"
                    class="btn btn-primary ladda-button workersCompensationPolicyActionButton"
                    data-style="expand-right">
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).on('click', '.workersCompaddMore', function() {
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
                            <button class="btn btn-outline-success workersCompaddMore" type="button">+</button>
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

        $('#workersCompensationForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var policyId = $('#workersCompensationHiddenPolicyId').val();
            var action = $('.workersCompensationPolicyActionButton').val();
            if (action == 'Update') {
                formData.append('_method', 'PUT');
            }
            var url = action == 'Update' ? `{{ route('workers-compensation-policy.update', ':id') }}`
                .replace(':id', policyId) : "{{ route('workers-compensation-policy.store') }}";
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false,
                dataType: "json",
                success: function(data) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Workers Compensation Policy has been added!',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#workersCompensationModalForm').modal('hide');
                        location.reload();
                    });
                },
                error: function(data) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }
            })
        });
        var today = new Date();

        var formattedDate = today.getFullYear() + '-' +
            ('0' + (today.getMonth() + 1)).slice(-2) + '-' +
            ('0' + today.getDate()).slice(-2);

        $('#workersCompensationEffectiveDate').val(formattedDate);

        $('#workersCompensationEffectiveDate').on('change', function() {
            var effectiveDate = new Date($(this).val());
            var expirationDate = new Date(effectiveDate);

            expirationDate.setFullYear(effectiveDate.getFullYear() + 1);
            var formattedExpirationDate = expirationDate.toISOString().split('T')[0];
            $('#workersCompensationExpirationDate').val(formattedExpirationDate);
        });

        $(document).on('hidden.bs.modal', '#workersCompensationModalForm', function() {
            $('#workersCompensationForm').trigger('reset');
        });
    });
</script>
