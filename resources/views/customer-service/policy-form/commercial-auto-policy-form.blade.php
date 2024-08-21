<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="commercialAutoPolicyForm">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Commercial Auto Policy Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="commercialAutoForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="commerciarlAutoPolicyNumber">Policy Number</label>
                            <input type="text" class="form-control" id="commerciarlAutoPolicyNumber"
                                name="commerciarlAutoPolicyNumber">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="commercialAutoInsuredInput">Insured</label>
                            <input type="text" class="form-control" id="commercialAutoInsuredInput"
                                name="commercialAutoInsuredInput" readonly>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="commercialAutoMarketInput">Market</label>
                            <select name="commercialAutoMarketInput" id="commercialAutoMarketInput" class="form-select"
                                required>
                                <option value="">Select Market</option>
                                @foreach ($markets as $market)
                                    <option value="{{ $market->name }}">{{ $market->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="commercialAutoCarrierInput">Carrier</label>
                            <select name="commercialAutoCarrierInput" id="commercialAutoCarrierInput"
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
                                <label class="form-label" for="commercialAutoPaymentTermInput">Payment Term</label>
                                <select class="form-select" aria-label="Default select example"
                                    id="commercialAutoPaymentTermInput" name="commercialAutoPaymentTermInput">
                                    <option value="">Open this select menu</option>
                                    <option value="PIF">PIF</option>
                                    <option value="Low down">Low down</option>
                                    <option value="Split PIF">Split PIF</option>
                                    <option value="Split low down">Split low down</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <label class="form-label">Any Auto</label>
                            <div class="square-switch">
                                <input type="checkbox" id="anyAuto" switch="info" name="anyAuto">
                                <label for="anyAuto" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Owned Autos Only</label>
                            <div class="square-switch">
                                <input type="checkbox" id="ownedAuto" switch="info" name="ownedAuto">
                                <label for="ownedAuto" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Scheduled Auto</label>
                            <div class="square-switch">
                                <input type="checkbox" id="scheduledAuto" switch="info" name="scheduledAuto">
                                <label for="scheduledAuto" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <label class="form-label">Hired Autos Only</label>
                            <div class="square-switch">
                                <input type="checkbox" id="hiredAutos" switch="info" name="hiredAutos">
                                <label for="hiredAutos" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Non-Owned Autos</label>
                            <div class="square-switch">
                                <input type="checkbox" id="nonOwned" switch="info" name="nonOwned">
                                <label for="nonOwned" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">

                        <div class="col-4">
                            <label class="form-label">Addl Insd:</label>
                            <div class="square-switch">
                                <input type="checkbox" id="commercialAddlInsd" switch="info"
                                    name="commercialAddlInsd">
                                <label for="commercialAddlInsd" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Subr Wvd:</label>
                            <div class="square-switch">
                                <input type="checkbox" id="commercialAutoSubrWvd" switch="info"
                                    name="commercialAutoSubrWvd">
                                <label for="commercialAutoSubrWvd" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="biPerPerson">Bodily Injury (Per Person)</label>
                            <input type="text" class="form-control input-mask text-left"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" id="biPerPerson" name="biPerPerson"
                                autocomplete="off" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="biPerAccident">Bodily Injury (Per accident)</label>
                            <input type="text" class="form-control input-mask text-left"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" id="biPerAccident"
                                name="biPerAccident" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="combineUnit">Combine S Unit</label>
                            <input type="text" class="form-control input-mask text-left"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" id="combineUnit" name="combineUnit"
                                autocomplete="off" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="propertyDamage">Property Damage</label>
                            <input type="text" class="form-control input-mask text-left"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" id="propertyDamage"
                                name="propertyDamage" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="blankLimits">Blank Limits</label>
                            <input type="text" class="form-control" id="blankLimits" name="newBlankLimits[]"
                                autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="blankValue">Blank Value</label>
                            <div class="input-group">
                                <input type="text" class="form-control input-mask text-left"
                                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                    inputmode="decimal" style="text-align: right;" id="blankValue"
                                    name="newBlankValue[]" autocomplete="off">
                                <button class="btn btn-outline-success addMore" type="button"
                                    id="addMore">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="commercialAutoEffectiveDate">Effective Date</label>
                            <input class="form-control" type="date" value="2011-08-19"
                                id="commercialAutoEffectiveDate" name="commercialAutoEffectiveDate">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="expirationDate">Expiration Date</label>
                            <input class="form-control" type="date" value="2011-08-19"
                                id="commercialAutoExpirationDate" name="commercialAutoExpirationDate">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12" id="commercialFileDiv">
                            <input type="file" name="file" id="file" class="form-control">
                        </div>
                    </div>
                    <input type="hidden" name="commercialAutoHiddenInputId" id="commercialAutoHiddenInputId">
                    <input type="hidden" name="commercialAutoHiddenQuoteId" id="commercialAutoHiddenQuoteId">
                    <input type="hidden" name="commercialAutoHiddenPolicyid" id="commercialAutoHiddenPolicyid">
                    {{-- <input type="hidden" name="commercialAutoAct" id=""> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="action_button" id="action_button" value="Add"
                        class="btn btn-primary ladda-button commercialAutoPolicyActionButton"
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
        $('#commercialAutoEffectiveDate').val(formattedDate);
        $('#commercialAutoEffectiveDate').on('change', function() {
            var effectiveDate = new Date($(this).val());
            var expirationDate = new Date(effectiveDate);

            expirationDate.setFullYear(effectiveDate.getFullYear() + 1);
            var formattedExpirationDate = expirationDate.toISOString().split('T')[0];
            $('#commercialAutoExpirationDate').val(formattedExpirationDate);
        });

        $('#commercialAutoForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            var action = $('.commercialAutoPolicyActionButton').val();
            var policyId = $('#commercialAutoHiddenPolicyid').val();
            var method = 'POST';
            if (action == 'update') {
                formData.append('_method', 'PUT');
                formData.delete('file'); // If you want to exclude the file input
            }
            var url = action == 'update' ? `{{ route('commercial-auto-policy.update', ':id') }}`
                .replace(':id', policyId) : "{{ route('commercial-auto-policy.store') }}";

            $.ajax({
                url: url,
                method: method,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false,
                dataType: "json",
                success: function(data) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Commercial Auto Policy has been added!',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#commercialAutoPolicyForm').modal('hide');
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
            });
        });


        $(document).on('hidden.bs.modal', '#commercialAutoPolicyForm', function() {
            $('#commercialAutoForm').trigger('reset');
        });

        $(document).on('click', '.addMore', function() {
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
                            <button class="btn btn-outline-success addMore" type="button">+</button>
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
    });
</script>
