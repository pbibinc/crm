<div class="modal fade" tabindex="-1" aria-labelledby="generalLiabilitiesPolicyForm" aria-hidden="true"
    id="generalLiabilitiesPolicyForm">
    <div class="modal-dialog modal-dialog-centered modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">General Liabilities Policy Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="generalLiabilitiesForm" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="glPolicyNumber">Policy Number</label>
                                <input class="form-control" id="glPolicyNumber" name="glPolicyNumber" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="glInsuredInput">Insured</label>
                                <input type="text" class="form-control" id="glInsuredInput" name="glInsuredInput"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="glMarketInput">Market</label>
                                <select name="glMarketInput" id="glMarketInput" class="form-select" required>
                                    <option value="">Select Market</option>
                                    @foreach ($markets as $market)
                                        <option value="{{ $market->name }}">{{ $market->name }}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" class="form-control" id="marketInput" name="marketInput" required> --}}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="carrierInput">Carrier</label>
                                <select name="carriersInput" id="carriersInput" class="form-select" required>
                                    <option value="">Select Carrier</option>
                                    @foreach ($carriers as $carrier)
                                        <option value="{{ $carrier->name }}">{{ $carrier->name }}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" class="form-control" id="insurerInput" name="carrierInput"
                                    required> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="glPaymentTermInput">Payment Term</label>
                                <select class="form-select" aria-label="Default select example" id="glPaymentTermInput"
                                    name="glPaymentTermInput" required>
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
                        <div class="col-2">
                            <div class="form-group">
                                <label class="form-label">Commercial GL</label>
                                <div class="square-switch">
                                    <input type="checkbox" id="commercialGl" switch="info" name="commercialGl">
                                    <label for="commercialGl" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="form-label">Claims Made</label>
                                <div class="square-switch">
                                    <input type="checkbox" id="claimsMade" switch="info" name="claimsMade">
                                    <label for="claimsMade" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="form-label">Occur</label>
                                <div class="square-switch">
                                    <input type="checkbox" id="occur" switch="info" name="occur">
                                    <label for="occur" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="form-label">Addl Insd</label>
                                <div class="square-switch">
                                    <input type="checkbox" id="glAddlInsd" switch="info" name="v">
                                    <label for="glAddlInsd" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="form-label">Subr Wvd</label>
                                <div class="square-switch">
                                    <input type="checkbox" id="glSubrWvd" switch="info" name="glSubrWvd">
                                    <label for="glSubrWvd" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="">GEN'L AGGREGATE LIMIT APPLIES PER:</label>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">Policy</label>
                                <div class="square-switch">
                                    <input type="checkbox" id="policy" switch="info" name="policy">
                                    <label for="policy" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">Project</label>
                                <div class="square-switch">
                                    <input type="checkbox" id="project" switch="info" name="project">
                                    <label for="project" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">Loc</label>
                                <div class="square-switch">
                                    <input type="checkbox" id="loc" switch="info" name="loc">
                                    <label for="loc" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="eachOccurence">Each Occurence</label>
                                <input type="text" class="form-control input-mask text-left"
                                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                    inputmode="decimal" style="text-align: right;" id="eachOccurence"
                                    name="eachOccurence" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="rentedDmg">DMG To Rented</label>
                                <input type="text" class="form-control input-mask text-left"
                                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                    inputmode="decimal" style="text-align: right;" id="rentedDmg" name="rentedDmg"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="medExp">Med Exp</label>
                                <input type="text" class="form-control input-mask text-left"
                                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                    inputmode="decimal" style="text-align: right;" id="medExp" name="medExp"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="perAdvInjury">Per & Adv Injury</label>
                                <input type="text" class="form-control input-mask text-left"
                                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                    inputmode="decimal" style="text-align: right;" id="perAdvInjury"
                                    name="perAdvInjury" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="genAggregate">Gen Aggregate</label>
                                <input type="text" class="form-control input-mask text-left"
                                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                    inputmode="decimal" style="text-align: right;" id="genAggregate"
                                    name="genAggregate" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="medExp">Comp/OP</label>
                                <input type="text" class="form-control input-mask text-left"
                                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                    inputmode="decimal" style="text-align: right;" id="comp" name="comp"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="effectiveDate">Effective Date</label>
                                <input class="form-control " type="date" value="2011-08-19" id="glEffectiveDate"
                                    name="effectiveDate">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="expirationDate">Expiration Date</label>
                                <input class="form-control" type="date" value="2011-08-19" id="expirationDate"
                                    name="expirationDate">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="attachedFiles" id="attachedFileLabel">Attached File <i
                                        class="ri-attachment-line"></i></label>
                                <input type="file" class="form-control" id="attachedFiles" name="attachedFiles"
                                    multiple>
                            </div>
                        </div>
                        <div class="col-6">
                            {{-- <div class="form-group">
                                <label class="form-label" for="statusDropdowm"
                                    id="statusDropdownLabel">Status</label>
                                <select class="form-select" aria-label="Default select example" id="statusDropdowm"
                                    name="statusDropdowm">
                                    <option selected="">Open this select menu</option>
                                    <option value="Cancelled">Cancelled</option>
                                    <option value="Declined">Declined</option>
                                    <option value="Endorsing">Endorsing</option>
                                    <option value="Issued">Issued</option>
                                    <option value="Notice Of Cancellation">Notice Of Cancellation</option>
                                    <option value="Renewal Issued">Renewal Issued</option>
                                    <option value="Renewal Notice of Cancellation">Renewal Notice of Cancellation
                                    </option>
                                </select>
                            </div> --}}
                        </div>
                    </div>
                    <input type="hidden" id="glHiddenInputId" name="glHiddenInputId">
                    <input type="hidden" name="glHiddenQuoteId" id="hiddenQuoteId">
                    <input type="hidden" name="glHiddenSelectedQuoteId" id="glHiddenSelectedQuoteId">
                    <input type="hidden" name="glHiddenPolicyId" id="glHiddenPolicyId">
                    <input type="hidden" name="generalLiabilityAction" id="generalLiabilityAction">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect waves-light"
                        data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="saveGeneralLiabilitiesPolicyForm"
                        id="saveGeneralLiabilitiesPolicyForm" value="Submit" class="btn btn-success ladda-button"
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

        $('#effectiveDate').val(formattedDate);

        $('#effectiveDate').on('change', function() {
            var effectiveDate = new Date($(this).val());
            var expirationDate = new Date(effectiveDate);
            expirationDate.setFullYear(effectiveDate.getFullYear() + 1);
            var formattedExpirationDate = expirationDate.toISOString().split('T')[0];
            $('#expirationDate').val(formattedExpirationDate);
        });

        function updateCheckboxStates() {
            var isAnyChecked = $('#policy').is(':checked') || $('#project').is(':checked') || $('#loc').is(
                ':checked');
            $('#policy').prop('disabled', isAnyChecked && !$('#policy').is(':checked'));
            $('#project').prop('disabled', isAnyChecked && !$('#project').is(':checked'));
            $('#loc').prop('disabled', isAnyChecked && !$('#loc').is(':checked'));
        }

        // Attach change event listeners to the checkboxes
        $('#policy, #project, #loc').change(function() {
            updateCheckboxStates();
        });

        updateCheckboxStates();

        // $('#generalLiabilitiesForm').on('submit', function(e) {
        //     e.preventDefault();
        //     var formData = new FormData(this);
        //     var action = $('#generalLiabilityAction').val();
        //     var policyId = $('#glHiddenPolicyId').val();
        //     var url = action == 'edit' ? "route('binding.update-general-liabilities-policy', ':id')"
        //         .replace(':id', policyId) :
        //         "{{ route('binding.save-general-liabilities-policy') }}";
        //     var method = action == 'edit' ? 'PUT' : 'POST';
        //     console.log(action);
        //     formData.append('media', $('#attachedFile')[0].files[0]);
        //     $.ajax({
        //         url: url,
        //         type: method,
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         data: formData,
        //         processData: false, // Prevent jQuery from processing the data
        //         contentType: false,
        //         dataType: "json",
        //         success: function(data) {
        //             Swal.fire({
        //                 title: 'Success!',
        //                 text: 'General Liability Policy Form has been saved.',
        //                 icon: 'success',
        //             }).then(function() {
        //                 // $('#generalLiabilitiesPolicyForm').modal('hide');
        //                 // $('.boundProductTable').DataTable().ajax.reload();
        //                 // $('.newPolicyList').DataTable().ajax.reload();
        //                 $('#generalLiabilitiesPolicyForm').modal('hide');
        //                 location.reload();
        //             });
        //         },
        //         error: function(data) {
        //             alert('error');
        //         }
        //     });
        // });

        $('#generalLiabilitiesForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var action = $('#generalLiabilityAction').val();
            var policyId = $('#glHiddenPolicyId').val();

            // Define the URL based on the action
            var url = action == 'edit' ?
                `{{ route('binding.update-general-liabilities-policy', ':id') }}`
                .replace(':id', policyId) :
                "{{ route('binding.save-general-liabilities-policy') }}";

            var method = 'POST';

            // Append the file to formData only if it exists and is required
            var fileInput = $('#attachedFile')[0];
            if (fileInput && fileInput.files && fileInput.files[0]) {
                formData.append('media', fileInput.files[0]);
                console.log('File appended:', fileInput.files[0].name);
            } else {
                console.error('No file selected or file input not found.');
            }

            if (action == 'edit') {
                formData.append('_method', 'PUT');
            }

            // AJAX request to submit the form data
            $.ajax({
                url: url,
                method: method,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Let the browser set the Content-Type
                dataType: "json",
                success: function(data) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'General Liability Policy Form has been saved.',
                        icon: 'success',
                    }).then(function() {
                        $('#generalLiabilitiesPolicyForm').modal('hide');
                        location
                            .reload(); // Reloading the current page to reflect changes
                    });
                },
                error: function(data) {
                    alert('Error occurred while saving the form.');
                }
            });

        });


    });
</script>
