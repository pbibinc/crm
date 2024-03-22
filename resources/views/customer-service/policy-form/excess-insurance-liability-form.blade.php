<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="excessInsurancePolicyFormModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excess Insurance Liability Policy Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="excessInsurancePolicyForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="excessInsuranceNumber">Policy Number</label>
                            <input type="text" class="form-control" id="excessInsuranceNumber"
                                name="excessInsuranceNumber">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="excessInsuranceInsuredInput">Insured</label>
                            <input type="text" class="form-control" id="excessInsuranceInsuredInput"
                                name="excessInsuranceInsuredInput">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="excessInsuranceMarketInput">Market</label>
                            <select name="excessInsuranceMarketInput" id="excessInsuranceMarketInput"
                                class="form-select">
                                <option value="">Select Market</option>
                                @foreach ($markets as $market)
                                    <option value="{{ $market->name }}">{{ $market->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="excessInsuranceCarrierInput">Carrier</label>
                            <select name="excessInsuranceCarrierInput" id="excessInsuranceCarrierInput"
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
                                <label class="form-label" for="excessInsurancePaymentTermInput">Payment Term</label>
                                <select class="form-select" aria-label="Default select example"
                                    id="excessInsurancePaymentTermInput" name="excessInsurancePaymentTermInput">
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
                            <label class="form-label">Umbrella Liab:</label>
                            <div class="square-switch">
                                <input type="checkbox" id="excessInsuranceUmbrellaLiabl" switch="info"
                                    name="excessInsuranceUmbrellaLiabl">
                                <label for="excessInsuranceUmbrellaLiabl" data-on-label="Yes"
                                    data-off-label="No"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Excess Liability:</label>
                            <div class="square-switch">
                                <input type="checkbox" id="excessInsuranceExcessLiability" switch="info"
                                    name="excessInsuranceExcessLiability">
                                <label for="excessInsuranceExcessLiability" data-on-label="Yes"
                                    data-off-label="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label">Occur:</label>
                            <div class="square-switch">
                                <input type="checkbox" id="excessInsuranceOccur" switch="info"
                                    name="excessInsuranceOccur">
                                <label for="excessInsuranceOccur" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Claims-Made:</label>
                            <div class="square-switch">
                                <input type="checkbox" id="excessInsuranceClaimsMade" switch="info"
                                    name="excessInsuranceClaimsMade">
                                <label for="excessInsuranceClaimsMade" data-on-label="Yes"
                                    data-off-label="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Ded:</label>
                            <div class="square-switch">
                                <input type="checkbox" id="excessInsuranceDed" switch="info"
                                    name="excessInsuranceDed">
                                <label for="excessInsuranceDed" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Retention:</label>
                            <div class="square-switch">
                                <input type="checkbox" id="excessInsuranceRetention" switch="info"
                                    name="excessInsuranceRetention">
                                <label for="excessInsuranceRetention" data-on-label="Yes"
                                    data-off-label="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label">Addl Insd:</label>
                            <div class="square-switch">
                                <input type="checkbox" id="excessInsuranceAddlInsd" switch="info"
                                    name="excessInsuranceAddlInsd">
                                <label for="excessInsuranceAddlInsd" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Subr Wvd:</label>
                            <div class="square-switch">
                                <input type="checkbox" id="excessInsuranceSubrWvd" switch="info"
                                    name="excessInsuranceSubrWvd">
                                <label for="excessInsuranceSubrWvd" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="excessInsuranceEachOccurrence">Each Occurrence</label>
                            <input type="text" class="form-control input-mask text-left"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" id="excessInsuranceEachOccurrence"
                                name="excessInsuranceEachOccurrence">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="excessInsuranceAggregate">Aggregate</label>
                            <input type="text" class="form-control input-mask text-left"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" id="excessInsuranceAggregate"
                                name="excessInsuranceAggregate">
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
                                <button class="btn btn-outline-success excessLiabilityaddMore" type="button"
                                    id="builderRiskaddMore">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="excessInsuranceEffectiveDate">Effective Date</label>
                            <input class="form-control" type="date" value="2011-08-19"
                                id="excessInsuranceEffectiveDate" name="excessInsuranceEffectiveDate">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="excessInsuranceExpirationDate">Expiration Date</label>
                            <input class="form-control" type="date" value="2011-08-19"
                                id="excessInsuranceExpirationDate" name="excessInsuranceExpirationDate">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <input type="file" name="file" id="file" class="form-control">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="excessInsuranceHiddenInputId" id="excessInsuranceHiddenInputId">
                <input type="hidden" name="excessInsuranceHiddenQuoteId" id="excessInsuranceHiddenQuoteId">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="action_button" id="action_button" value="Add"
                        class="btn btn-primary ladda-button" data-style="expand-right">
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(e) {
        var today = new Date();

        var formattedDate = today.getFullYear() + '-' +
            ('0' + (today.getMonth() + 1)).slice(-2) + '-' +
            ('0' + today.getDate()).slice(-2);

        $('#excessInsuranceEffectiveDate').val(formattedDate);

        $(document).on('click', '.excessLiabilityaddMore', function() {
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
                            <button class="btn btn-outline-success builderRiskaddMore" type="button">+</button>
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

        function updateCheckboxStatesExcessliability() {
            var liabilityIsAnyChecked = $('#excessInsuranceUmbrellaLiabl').is(':checked') ||
                $('#excessInsuranceExcessLiability').is(':checked');

            var occurClaimsMadeIsAnyChecked = $('#excessInsuranceOccur').is(':checked') || $(
                    '#excessInsuranceClaimsMade')
                .is(':checked');

            $('#excessInsuranceUmbrellaLiabl').prop('disabled', liabilityIsAnyChecked && !$(
                '#excessInsuranceUmbrellaLiabl').is(':checked'))
            $('#excessInsuranceExcessLiability').prop('disabled', liabilityIsAnyChecked && !$(
                '#excessInsuranceExcessLiability').is(':checked'))
            $('#excessInsuranceOccur').prop('disabled', occurClaimsMadeIsAnyChecked && !$(
                '#excessInsuranceOccur').is(':checked'))
            $('#excessInsuranceClaimsMade').prop('disabled', occurClaimsMadeIsAnyChecked && !$(
                '#excessInsuranceClaimsMade').is(':checked'))
        }

        $('#excessInsuranceUmbrellaLiabl, #excessInsuranceExcessLiability, #excessInsuranceClaimsMade, #excessInsuranceOccur')
            .change(function() {
                updateCheckboxStatesExcessliability();
            });

        $('#excessInsuranceEffectiveDate').on('change', function() {
            var effectiveDate = new Date($(this).val());
            var expirationDate = new Date(effectiveDate);
            expirationDate.setFullYear(effectiveDate.getFullYear() + 1);
            var formattedExpirationDate = expirationDate.toISOString().split('T')[0];
            $('#excessInsuranceExpirationDate').val(formattedExpirationDate);
        });

        $('#excessInsurancePolicyForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('excess-insurance-policy.store') }}",
                method: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#action_button').attr('disabled', 'disabled');
                    $('#action_button').html('Sending...');
                },
                success: function(data) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Tools Equipment Policy has been added!',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        // if (result.isConfirmed) {
                        //     $('#excessInsurancePolicyFormModal').modal('hide');
                        //     $('.boundProductTable').DataTable().ajax.reload();
                        //     $('.newPolicyList').DataTable().ajax.reload();
                        // }
                        $('#excessInsurancePolicyFormModal').modal('hide');
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

    })
</script>
