<table id="policyListTable" class="table table-bordered dt-responsive nowrap"
    style="border-collapse: collapse; width: 100%;">
    <thead style="background-color: #f0f0f0;">
        <tr>
            <th>Expiration Date</th>
            <th>Policy Number</th>
            <th>Product</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
</table>



{{-- modal for upload viewing and deletion of file --}}
<div class="modal fade" id="uploadPolicyFile" tabindex="-1" aria-labelledby="addQuoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadPolicyFileModalTitle">File Upload</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" class="dropzone mt-4 border-dashed" id="policyFileDropZone"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="policyId" value="">
                </form>

            </div>
        </div>
    </div>
</div>

{{-- policy form --}}

@include('customer-service.policy-form.general-liabilities-policy-form', compact('carriers', 'markets'))
@include('customer-service.policy-form.workers-compensation-policy-form', compact('carriers', 'markets'))
@include('customer-service.policy-form.tools-equipment-policy-form', compact('carriers', 'markets'))
@include('customer-service.policy-form.business-owners-policy-form', compact('carriers', 'markets'))
@include('customer-service.policy-form.builders-risk-policy-form', compact('carriers', 'markets'))
@include('customer-service.policy-form.excess-insurance-liability-form', compact('carriers', 'markets'))

@include('customer-service.policy-form.commercial-auto-policy-form', compact('carriers', 'markets'))

@include('customer-service.policy.renewal-form')
@include('customer-service.policy.cancellation-report-modal')
<script>
    Dropzone.autoDiscover = false;
    var policyDropzone;
    $(document).ready(function() {
        var id = {{ $leadId }};
        $('#policyListTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                url: "{{ route('client-policy-list') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                }
            },
            columns: [{
                    data: 'effectiveDate',
                    name: 'effectiveDate'
                },
                {
                    data: 'policy_number',
                    name: 'policy_number'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                // {
                //     data: 'market',
                //     name: 'market'
                // },
                // {
                //     data: 'total_cost',
                //     name: 'total_cost'
                // },
                {
                    data: 'policyStatus',
                    name: 'policyStatus'
                },
                {
                    data: 'action',
                    name: 'action',
                }
            ],
        });

        policyDropzone = new Dropzone("#policyFileDropZone", {
            url: "{{ route('update-file-policy') }}",
            autoProcessQueue: true, // Prevent automatic upload
            clickable: true, // Allow opening file dialog on click
            maxFiles: 1, //
            init: function() {
                this.on("addedfile", function(file) {
                    file.previewElement.addEventListener("click", function() {
                        var url = "{{ env('APP_FORM_LINK') }}";
                        var fileUrl = url + file.url;
                        Swal.fire({
                            title: 'File Options',
                            text: 'Choose an action for the file',
                            showDenyButton: true,
                            confirmButtonText: `Download`,
                            denyButtonText: `View`,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var downloadLink = document.createElement(
                                    "a");
                                downloadLink.href = fileUrl;
                                downloadLink.download = file.name;
                                document.body.appendChild(downloadLink);
                                downloadLink.click();
                                document.body.removeChild(downloadLink);
                            } else if (result.isDenied) {
                                window.open(fileUrl, '_blank');
                            }
                        });


                    });
                });
                this.on('sending', function(file, xhr, formData) {
                    formData.append('id', $('#policyId').val());
                });
                this.on('success', function(file, response) {
                    swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then(() => {
                        $('#uploadPolicyFile').modal('hide');
                        $('.policyList').DataTable().ajax.reload();
                    });
                    // if (this.files.length > 0) {
                    //     this.removeFile(this.files[0]);
                    // }
                });
            }
        });

        function addPoliciesFile(file) {
            var mockFile = {
                id: file.id,
                name: file.basename,
                size: parseInt(file.size),
                type: file.type,
                status: Dropzone.ADDED,
                url: file.filepath // URL to the file's location
            };
            policyDropzone.emit("addedfile", mockFile);
            // myDropzone.emit("thumbnail", mockFile, file.filepath); // If you have thumbnails
            policyDropzone.emit("complete", mockFile);
        };

        $('#uploadPolicyFile').on('hide.bs.modal', function() {
            $(".dropzone .dz-preview").remove(); // This removes file previews from the DOM
            policyDropzone.files.length = 0;
        });

        $(document).on('click', '.viewButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $.ajax({
                url: "{{ route('get-policy-information') }}",
                type: "POST",
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response);
                    if (response.product.product == 'General Liability') {
                        $('#glPolicyNumber').val(response.policy_detail.policy_number).attr(
                            'readonly', true);
                        $('#glInsuredInput').val(response.lead.company_name).attr(
                            'readonly', true);
                        $('#glMarketInput').val(response.policy_detail.market).prop(
                            'disabled', true);
                        $('#carriersInput').val(response.policy_detail.carrier).prop(
                            'disabled', true);
                        $('#glPaymentTermInput').val(response.paymentInformation
                            .payment_term).prop(
                            'disabled', true);
                        $('#commercialGl').prop('checked', response.productPolicyInformation
                            .is_commercial_gl == 1).prop('disabled', true);
                        $('#claimsMade').prop('checked', response.productPolicyInformation
                            .is_claims_made == 1).prop('disabled', true);
                        $('#occur').prop('checked', response.productPolicyInformation
                            .is_occur == 1).prop('disabled', true);
                        $('#glSubrWvd').prop('checked', response.productPolicyInformation
                            .is_subr_wvd == 1).prop('disabled', true);
                        $('#policy').prop('checked', response.productPolicyInformation
                            .is_policy == 1).prop('disabled', true);
                        $('#project').prop('checked', response.productPolicyInformation
                            .is_project == 1).prop('disabled', true);
                        $('#loc').prop('checked', response.productPolicyInformation
                            .is_loc == 1).prop('disabled', true);
                        $('#eachOccurence').val(response.productPolicyInformation
                            .each_occurence).attr(
                            'readonly', true);
                        $('#rentedDmg').val(response.productPolicyInformation
                            .damage_to_rented).attr(
                            'readonly', true);
                        $('#medExp').val(response.productPolicyInformation
                            .medical_expenses).attr(
                            'readonly', true);
                        $('#perAdvInjury').val(response.productPolicyInformation
                            .per_adv_injury).attr(
                            'readonly', true);
                        $('#genAggregate').val(response.productPolicyInformation
                            .product_comp).attr(
                            'readonly', true);
                        $('#comp').val(response.productPolicyInformation
                            .gen_aggregate).attr(
                            'readonly', true);
                        $('#glEffectiveDate').val(response.policy_detail.effective_date)
                            .attr(
                                'readonly', true);
                        $('#expirationDate').val(response.policy_detail
                            .expiration_date).attr(
                            'readonly', true);
                        $('#attachedFileLabel').attr('hidden', true);
                        $('#attachedFiles').attr('hidden', true);
                        $('#statusDropdownLabel').attr('hidden', true);
                        $('#statusDropdowm').prop('hidden', true);
                        $('#saveGeneralLiabilitiesPolicyForm').attr('hidden', true);
                        $('#generalLiabilitiesPolicyForm').modal('show');
                    }
                    if (response.product.product == 'Commercial Auto') {
                        $('#commerciarlAutoPolicyNumber').val(response.policy_detail
                                .policy_number)
                            .attr('readonly', true);
                        $('#commercialAutoInsuredInput').val(response.lead
                            .company_name).attr('readonly', true);
                        $('#commercialAutoMarketInput').val(response.policy_detail.market)
                            .prop('disabled', true);
                        $('#commercialAutoCarrierInput').val(response.policy_detail.carrier)
                            .prop('disabled', true);
                        $('#commercialAutoPaymentTermInput').val(response.paymentInformation
                            .payment_term).prop('disabled', true);
                        $('#anyAuto').prop('checked', response.productPolicyInformation
                            .is_any_auto == 1).prop('disabled', true);
                        $('#ownedAuto').prop('checked', response.productPolicyInformation
                            .is_owned_auto == 1).prop('disabled', true);
                        $('#scheduledAuto').prop('checked', response
                            .productPolicyInformation
                            .is_scheduled_auto == 1).prop('disabled', true);
                        $('#hiredAutos').prop('checked', response
                            .productPolicyInformation
                            .is_hired_auto == 1).prop('disabled', true);
                        $('#nonOwned').prop('checked', response
                            .productPolicyInformation
                            .is_non_owned_auto == 1).prop('disabled', true);
                        $('#commercialAddlInsd').prop('checked', response
                            .productPolicyInformation
                            .is_addl_insd == 1).prop('disabled', true);
                        $('#commercialAutoSubrWvd').prop('checked', response
                            .productPolicyInformation
                            .is_subr_wvd == 1).prop('disabled', true);
                        $('#biPerPerson').val(response.productPolicyInformation
                            .bi_per_person).attr('readonly', true);
                        $('#biPerAccident').val(response.productPolicyInformation
                            .bi_per_accident).attr('readonly', true);
                        $('#combineUnit').val(response.productPolicyInformation
                            .combined_single_unit).attr('readonly', true);
                        $('#propertyDamage').val(response.productPolicyInformation
                            .property_damage).attr('readonly', true)
                        if (response.policyAdditionalValues.length > 0) {
                            response.policyAdditionalValues.forEach(function(limit) {
                                // Create a new row div
                                var newRow = $('<div class="row mb-2"></div>');

                                var nameDiv = $('<div class="col-6"></div>');
                                var nameLabel = $(
                                    '<label class="form-label" for="blankLimits">' +
                                    limit.name + '</label>');
                                var nameInput = $(
                                    '<input type="text" class="form-control" id="blankLimits" name="newBlankLimits[]" readOnly>'
                                );
                                nameInput.val(limit
                                    .name); // Set the value of the input
                                nameDiv.append(nameLabel,
                                    nameInput); // Append label and input to the div

                                // Create a div for the limit value
                                var valueDiv = $('<div class="col-6"></div>');
                                var valueLabel = $(
                                    '<label class="form-label" for="blankValue">Blank Value</label>'
                                );
                                var valueInput = $(
                                    '<div class="input-group"></div>');
                                var valueInputField = $(
                                    '<input type="text" class="form-control input-mask text-left" data-inputmask="\'alias\': \'numeric\', \'groupSeparator\': \',\', \'digits\': 2, \'digitsOptional\': false, \'prefix\': \'$ \', \'placeholder\': \'0\'" inputmode="decimal" style="text-align: right;" id="blankValue" name="newBlankValue[]" readOnly>'
                                );
                                valueInputField.val(limit
                                    .value); // Set the value of the input
                                // var addButton = $(
                                //     '<button class="btn btn-outline-success addMore" type="button" id="addMore">+</button>'
                                // );
                                valueInput.append(valueInputField,

                                ); // Append input field and add button to the input group
                                valueDiv.append(valueLabel,
                                    valueInput
                                ); // Append label and input group to the div

                                // Append the name and value divs to the new row
                                newRow.append(nameDiv, valueDiv);

                                // Insert the dynamically created input fields above the effective date inputs
                                var effectiveDateRow = $(
                                        '#commercialAutoEffectiveDate')
                                    .closest('.row');
                                effectiveDateRow.before(newRow);

                                // Remove any input fields with no data
                                $('#commercialAutoForm input[type="text"]').each(
                                    function() {
                                        if ($(this).val() === '') {
                                            $(this).closest('.row')
                                                .remove(); // Remove the parent row if the input has no value
                                        }
                                    });
                            });
                        }
                        $('#file').attr('hidden', true);
                        $('#commercialAutoEffectiveDate').val(response.policy_detail
                            .effective_date).attr('readonly', true);
                        $('#commercialAutoExpirationDate').val(response.policy_detail
                                .expiration_date)
                            .attr('readonly', true);
                        $('.commercialAutoPolicyActionButton').attr('hidden', true);
                        $('#commercialAutoPolicyForm').modal('show');
                    }
                    if (response.product.product == 'Business Owners') {
                        $('#businessOwnersNumber').val(response.policy_detail.policy_number)
                            .attr('readonly', true);
                        $('#businessOwnersInsuredInput').val(response.lead
                                .company_name)
                            .attr('readonly', true);
                        $('#businessOwnersMarketInput').val(response.policy_detail.market)
                            .prop(
                                'disabled', true);
                        $('#businessOwnersCarrierInput').val(response.policy_detail.carrier)
                            .prop(
                                'disabled', true);
                        $('#businessOwnersPaymentTermInput').val(response.paymentInformation
                            .payment_term).prop(
                            'disabled', true);
                        $('#businessOwnersAddlInsd').prop('checked', response
                            .productPolicyInformation
                            .is_addl_insd == 1).prop('disabled', true);
                        $('#businessOwnersSubrWvd').prop('checked', response
                            .productPolicyInformation
                            .is_subr_wvd == 1).prop('disabled', true);
                        if (response.policyAdditionalValues.length > 0) {
                            response.policyAdditionalValues.forEach(function(limit) {
                                var newRow = $('<div class="row mb-2"></div>');

                                var nameDiv = $('<div class="col-6"></div>');
                                var nameLabel = $(
                                    '<label class="form-label" for="blankLimits">' +
                                    limit.name + '</label>');
                                var nameInput = $(
                                    '<input type="text" class="form-control" id="blankLimits" name="newBlankLimits[]" readOnly>'
                                );
                                nameInput.val(limit
                                    .name); // Set the value of the input
                                nameDiv.append(nameLabel,
                                    nameInput); // Append label and input to the div

                                // Create a div for the limit value
                                var valueDiv = $('<div class="col-6"></div>');
                                var valueLabel = $(
                                    '<label class="form-label" for="blankValue">Blank Value</label>'
                                );
                                var valueInput = $(
                                    '<div class="input-group"></div>');
                                var valueInputField = $(
                                    '<input type="text" class="form-control input-mask text-left" data-inputmask="\'alias\': \'numeric\', \'groupSeparator\': \',\', \'digits\': 2, \'digitsOptional\': false, \'prefix\': \'$ \', \'placeholder\': \'0\'" inputmode="decimal" style="text-align: right;" id="blankValue" name="newBlankValue[]" readOnly>'
                                );
                                valueInputField.val(limit
                                    .value); // Set the value of the input
                                // var addButton = $(
                                //     '<button class="btn btn-outline-success addMore" type="button" id="addMore">+</button>'
                                // );
                                valueInput.append(valueInputField,

                                ); // Append input field and add button to the input group
                                valueDiv.append(valueLabel,
                                    valueInput
                                ); // Append label and input group to the div

                                // Append the name and value divs to the new row
                                newRow.append(nameDiv, valueDiv);

                                // Insert the dynamically created input fields above the effective date inputs
                                var effectiveDateRow = $(
                                        '#businessOwnersEffectiveDate')
                                    .closest('.row');
                                effectiveDateRow.before(newRow);

                                // Remove any input fields with no data
                                $('#businessOwnersPolicyForm input[type="text"]')
                                    .each(
                                        function() {
                                            if ($(this).val() === '') {
                                                $(this).closest('.row')
                                                    .remove(); // Remove the parent row if the input has no value
                                            }
                                        });
                            });
                        }

                        $('#businessOwnersEffectiveDate').val(response.policy_detail
                            .effective_date).attr('readonly', true);
                        $('#businessOwnersExpirationDate').val(response.policy_detail
                            .expiration_date).attr('readonly', true);
                        $('.businessOwnersPolicyFile').attr('hidden', true);
                        $('.businessOwnersPolicyActionButton').attr('hidden', true);
                        $('#businessOwnersPolicyFormModal').modal('show');
                    }
                    if (response.product.product == 'Tools Equipment') {

                        $('#toolsEquipmentPolicyNumber').val(response.policy_detail
                                .policy_number)
                            .attr('readonly', true);
                        $('#toolsEquipmentInsuredInput').val(response.lead
                                .company_name)
                            .attr('readonly', true);
                        $('#toolsEquipmentMarketInput').val(response.policy_detail.market)
                            .prop(
                                'disabled', true);
                        $('#toolsEquipmentCarrierInput').val(response.policy_detail.carrier)
                            .prop(
                                'disabled', true);
                        $('#toolsEquipmentPaymentTermInput').val(response.paymentInformation
                            .payment_term).prop(
                            'disabled', true);
                        $('#toolsEquipmentAddlInsd').prop('checked', response
                            .productPolicyInformation
                            .is_addl_insd == 1).prop('disabled', true);
                        $('#toolsEquipmentSubrWvd').prop('checked', response
                            .productPolicyInformation
                            .is_subr_wvd == 1).prop('disabled', true);
                        if (response.policyAdditionalValues.length > 0) {
                            response.policyAdditionalValues.forEach(function(limit) {
                                var newRow = $('<div class="row mb-2"></div>');

                                var nameDiv = $('<div class="col-6"></div>');
                                var nameLabel = $(
                                    '<label class="form-label" for="blankLimits">' +
                                    limit.name + '</label>');
                                var nameInput = $(
                                    '<input type="text" class="form-control" id="blankLimits" name="newBlankLimits[]" readOnly>'
                                );
                                nameInput.val(limit
                                    .name); // Set the value of the input
                                nameDiv.append(nameLabel,
                                    nameInput); // Append label and input to the div

                                // Create a div for the limit value
                                var valueDiv = $('<div class="col-6"></div>');
                                var valueLabel = $(
                                    '<label class="form-label" for="blankValue">Blank Value</label>'
                                );
                                var valueInput = $(
                                    '<div class="input-group"></div>');
                                var valueInputField = $(
                                    '<input type="text" class="form-control input-mask text-left" data-inputmask="\'alias\': \'numeric\', \'groupSeparator\': \',\', \'digits\': 2, \'digitsOptional\': false, \'prefix\': \'$ \', \'placeholder\': \'0\'" inputmode="decimal" style="text-align: right;" id="blankValue" name="newBlankValue[]" readOnly>'
                                );
                                valueInputField.val(limit
                                    .value); // Set the value of the input
                                // var addButton = $(
                                //     '<button class="btn btn-outline-success addMore" type="button" id="addMore">+</button>'
                                // );
                                valueInput.append(valueInputField,

                                ); // Append input field and add button to the input group
                                valueDiv.append(valueLabel,
                                    valueInput
                                ); // Append label and input group to the div

                                // Append the name and value divs to the new row
                                newRow.append(nameDiv, valueDiv);

                                // Insert the dynamically created input fields above the effective date inputs
                                var effectiveDateRow = $(
                                        '#toolsEquipmentEffectiveDate')
                                    .closest('.row');
                                effectiveDateRow.before(newRow);

                                // Remove any input fields with no data
                                $('#toolsEquipmentForm input[type="text"]')
                                    .each(
                                        function() {
                                            if ($(this).val() === '') {
                                                $(this).closest('.row')
                                                    .remove(); // Remove the parent row if the input has no value
                                            }
                                        });
                            });
                        }
                        $('#toolsEquipmentEffectiveDate').val(response.policy_detail
                            .effective_date).attr('readonly', true);
                        $('#toolsEquipmentExpirationDate').val(response.policy_detail
                            .expiration_date).attr('readonly', true);
                        $('.toolsEquipmentPolicyFormFile').attr('hidden', true);
                        $('.toolsEquipmentPolicyFornActionButton').attr('hidden', true);
                        $('#toolsEquipmentPolicyFormModal').modal('show');
                    }
                    if (response.product.product == 'Excess Liability') {
                        $('#excessInsuranceNumber').val(response.policy_detail
                                .policy_number)
                            .attr('readonly', true);
                        $('#excessInsuranceInsuredInput').val(response.lead
                                .company_name)
                            .attr('readonly', true);
                        $('#excessInsuranceMarketInput').val(response.policy_detail.market)
                            .prop(
                                'disabled', true);
                        $('#excessInsuranceCarrierInput').val(response.policy_detail
                                .carrier)
                            .prop(
                                'disabled', true);
                        $('#excessInsurancePaymentTermInput').val(response
                            .paymentInformation
                            .payment_term).prop(
                            'disabled', true);
                        $('#excessInsuranceUmbrellaLiabl').prop('checked', response
                            .productPolicyInformation
                            .is_umbrella_liability == 1).prop('disabled', true);
                        $('#excessInsuranceExcessLiability').prop('checked', response
                            .productPolicyInformation
                            .is_excess_liability == 1).prop('disabled', true);
                        $('#excessInsuranceOccur').prop('checked', response
                            .productPolicyInformation
                            .is_occur == 1).prop('disabled', true);
                        $('#excessInsuranceClaimsMade').prop('checked', response
                            .productPolicyInformation
                            .is_claims_made == 1).prop('disabled', true);
                        $('#excessInsuranceDed').prop('checked', response
                            .productPolicyInformation
                            .is_ded == 1).prop('disabled', true);
                        $('#excessInsuranceRetention').prop('checked', response
                            .productPolicyInformation
                            .is_retention == 1).prop('disabled', true);
                        $('#excessInsuranceAddlInsd').prop('checked', response
                            .productPolicyInformation
                            .is_addl_insd == 1).prop('disabled', true);
                        $('#excessInsuranceSubrWvd').prop('checked', response
                            .productPolicyInformation
                            .is_subr_wvd == 1).prop('disabled', true);
                        $('#excessInsuranceEachOccurrence').val(response
                                .productPolicyInformation
                                .each_occurrence)
                            .attr('readonly', true);
                        $('#excessInsuranceAggregate').val(response
                                .productPolicyInformation
                                .aggregate)
                            .attr('readonly', true);
                        if (response.policyAdditionalValues.length > 0) {
                            response.policyAdditionalValues.forEach(function(limit) {
                                var newRow = $('<div class="row mb-2"></div>');

                                var nameDiv = $('<div class="col-6"></div>');
                                var nameLabel = $(
                                    '<label class="form-label" for="blankLimits">' +
                                    limit.name + '</label>');
                                var nameInput = $(
                                    '<input type="text" class="form-control" id="blankLimits" name="newBlankLimits[]" readOnly>'
                                );
                                nameInput.val(limit
                                    .name); // Set the value of the input
                                nameDiv.append(nameLabel,
                                    nameInput); // Append label and input to the div

                                // Create a div for the limit value
                                var valueDiv = $('<div class="col-6"></div>');
                                var valueLabel = $(
                                    '<label class="form-label" for="blankValue">Blank Value</label>'
                                );
                                var valueInput = $(
                                    '<div class="input-group"></div>');
                                var valueInputField = $(
                                    '<input type="text" class="form-control input-mask text-left" data-inputmask="\'alias\': \'numeric\', \'groupSeparator\': \',\', \'digits\': 2, \'digitsOptional\': false, \'prefix\': \'$ \', \'placeholder\': \'0\'" inputmode="decimal" style="text-align: right;" id="blankValue" name="newBlankValue[]" readOnly>'
                                );
                                valueInputField.val(limit
                                    .value); // Set the value of the input
                                // var addButton = $(
                                //     '<button class="btn btn-outline-success addMore" type="button" id="addMore">+</button>'
                                // );
                                valueInput.append(valueInputField,

                                ); // Append input field and add button to the input group
                                valueDiv.append(valueLabel,
                                    valueInput
                                ); // Append label and input group to the div

                                // Append the name and value divs to the new row
                                newRow.append(nameDiv, valueDiv);

                                // Insert the dynamically created input fields above the effective date inputs
                                var effectiveDateRow = $(
                                        '#excessInsuranceEffectiveDate')
                                    .closest('.row');
                                effectiveDateRow.before(newRow);

                                // Remove any input fields with no data
                                $('#excessInsurancePolicyForm input[type="text"]')
                                    .each(
                                        function() {
                                            if ($(this).val() === '') {
                                                $(this).closest('.row')
                                                    .remove(); // Remove the parent row if the input has no value
                                            }
                                        });
                            });
                        }
                        $('#excessInsuranceEffectiveDate').val(response.policy_detail
                            .effective_date).attr('readonly', true);
                        $('#excessInsuranceExpirationDate').val(response.policy_detail
                            .expiration_date).attr('readonly', true);
                        $('.excessInsruancePolicyFormFile').attr('hidden', true);
                        $('.excessInsurancePolicyFormActionButton').attr('hidden', true);
                        $('#excessInsurancePolicyFormModal').modal('show');
                    }
                    if (response.product.product == 'Workers Compensation') {
                        $('#workersCompensationPolicyNumber').val(response.policy_detail
                                .policy_number)
                            .attr('readonly', true);
                        $('#workersCompensationInsuredInput').val(response.lead
                                .company_name)
                            .attr('readonly', true);
                        $('#workersCompensationMarketInput').val(response.policy_detail
                                .market)
                            .prop(
                                'disabled', true);
                        $('#workersCompensationCarrierInput').val(response.policy_detail
                                .carrier)
                            .prop(
                                'disabled', true);
                        $('#workersCompensationPaymentTermInput').val(response
                            .paymentInformation
                            .payment_term).prop(
                            'disabled', true);
                        $('#workersCompSubrWvd').prop('checked', response
                            .productPolicyInformation
                            .is_subr_wvd == 1).prop('disabled', true);
                        $('#workersPerstatute').prop('checked', response
                            .productPolicyInformation
                            .is_per_statute == 1).prop('disabled', true);
                        $('#elEachAccident').val(response.productPolicyInformation
                                .el_each_accident)
                            .attr('readonly', true);
                        $('#elDiseasePolicyLimit').val(response.productPolicyInformation
                                .el_disease_policy_limit)
                            .attr('readonly', true);
                        $('#elDiseaseEachEmployee').val(response.productPolicyInformation
                                .el_disease_each_employee)
                            .attr('readonly', true);
                        if (response.policyAdditionalValues.length > 0) {
                            response.policyAdditionalValues.forEach(function(limit) {
                                var newRow = $('<div class="row mb-2"></div>');

                                var nameDiv = $('<div class="col-6"></div>');
                                var nameLabel = $(
                                    '<label class="form-label" for="blankLimits">' +
                                    limit.name + '</label>');
                                var nameInput = $(
                                    '<input type="text" class="form-control" id="blankLimits" name="newBlankLimits[]" readOnly>'
                                );
                                nameInput.val(limit
                                    .name); // Set the value of the input
                                nameDiv.append(nameLabel,
                                    nameInput); // Append label and input to the div

                                // Create a div for the limit value
                                var valueDiv = $('<div class="col-6"></div>');
                                var valueLabel = $(
                                    '<label class="form-label" for="blankValue">Blank Value</label>'
                                );
                                var valueInput = $(
                                    '<div class="input-group"></div>');
                                var valueInputField = $(
                                    '<input type="text" class="form-control input-mask text-left" data-inputmask="\'alias\': \'numeric\', \'groupSeparator\': \',\', \'digits\': 2, \'digitsOptional\': false, \'prefix\': \'$ \', \'placeholder\': \'0\'" inputmode="decimal" style="text-align: right;" id="blankValue" name="newBlankValue[]" readOnly>'
                                );
                                valueInputField.val(limit
                                    .value); // Set the value of the input
                                // var addButton = $(
                                //     '<button class="btn btn-outline-success addMore" type="button" id="addMore">+</button>'
                                // );
                                valueInput.append(valueInputField,

                                ); // Append input field and add button to the input group
                                valueDiv.append(valueLabel,
                                    valueInput
                                ); // Append label and input group to the div

                                // Append the name and value divs to the new row
                                newRow.append(nameDiv, valueDiv);

                                // Insert the dynamically created input fields above the effective date inputs
                                var effectiveDateRow = $(
                                        '#workersCompensationEffectiveDate')
                                    .closest('.row');
                                effectiveDateRow.before(newRow);

                                // Remove any input fields with no data
                                $('#workersCompensationForm input[type="text"]')
                                    .each(
                                        function() {
                                            if ($(this).val() === '') {
                                                $(this).closest('.row')
                                                    .remove(); // Remove the parent row if the input has no value
                                            }
                                        });
                            });
                        }
                        $('#workersCompensationEffectiveDate').val(response.policy_detail
                            .effective_date).attr('readonly', true);
                        $('#workersCompensationExpirationDate').val(response.policy_detail
                            .expiration_date).attr('readonly', true);
                        $('.workersCompensationPolicyFormFile').attr('hidden', true);
                        $('.workersCompensationPolicyActionButton').attr('hidden', true);
                        $('#workersCompensationModalForm').modal('show');
                    }
                    if (response.product.product == 'Builders Risk') {
                        $('#buildersRiskPolicyNumber').val(response.policy_detail
                                .policy_number)
                            .attr('readonly', true);
                        $('#buildersRiskInsuredInput').val(response.lead
                                .company_name)
                            .attr('readonly', true);
                        $('#buildersRiskMarketInput').val(response.policy_detail
                                .market)
                            .prop(
                                'disabled', true);
                        $('#buildersRiskCarrierInput').val(response.policy_detail
                                .carrier)
                            .prop(
                                'disabled', true);
                        $('#buildersRiskPaymentTermInput').val(response
                            .paymentInformation
                            .payment_term).prop(
                            'disabled', true);
                        $('#buildersRiskAddlInsd').prop('checked', response
                            .productPolicyInformation
                            .is_addl_insd == 1).prop('disabled', true);
                        $('#buildersRiskSubrWvd').prop('checked', response
                            .productPolicyInformation
                            .is_subr_wvd == 1).prop('disabled', true);
                        if (response.policyAdditionalValues.length > 0) {
                            response.policyAdditionalValues.forEach(function(limit) {
                                var newRow = $('<div class="row mb-2"></div>');

                                var nameDiv = $('<div class="col-6"></div>');
                                var nameLabel = $(
                                    '<label class="form-label" for="blankLimits">' +
                                    limit.name + '</label>');
                                var nameInput = $(
                                    '<input type="text" class="form-control" id="blankLimits" name="newBlankLimits[]" readOnly>'
                                );
                                nameInput.val(limit
                                    .name); // Set the value of the input
                                nameDiv.append(nameLabel,
                                    nameInput); // Append label and input to the div

                                // Create a div for the limit value
                                var valueDiv = $('<div class="col-6"></div>');
                                var valueLabel = $(
                                    '<label class="form-label" for="blankValue">Blank Value</label>'
                                );
                                var valueInput = $(
                                    '<div class="input-group"></div>');
                                var valueInputField = $(
                                    '<input type="text" class="form-control input-mask text-left" data-inputmask="\'alias\': \'numeric\', \'groupSeparator\': \',\', \'digits\': 2, \'digitsOptional\': false, \'prefix\': \'$ \', \'placeholder\': \'0\'" inputmode="decimal" style="text-align: right;" id="blankValue" name="newBlankValue[]" readOnly>'
                                );
                                valueInputField.val(limit
                                    .value); // Set the value of the input
                                // var addButton = $(
                                //     '<button class="btn btn-outline-success addMore" type="button" id="addMore">+</button>'
                                // );
                                valueInput.append(valueInputField,

                                ); // Append input field and add button to the input group
                                valueDiv.append(valueLabel,
                                    valueInput
                                ); // Append label and input group to the div

                                // Append the name and value divs to the new row
                                newRow.append(nameDiv, valueDiv);

                                // Insert the dynamically created input fields above the effective date inputs
                                var effectiveDateRow = $(
                                        '#buildersRiskEffectiveDate')
                                    .closest('.row');
                                effectiveDateRow.before(newRow);

                                // Remove any input fields with no data
                                $('#buildersRiskForm input[type="text"]')
                                    .each(
                                        function() {
                                            if ($(this).val() === '') {
                                                $(this).closest('.row')
                                                    .remove(); // Remove the parent row if the input has no value
                                            }
                                        });
                            });
                        }
                        $('#buildersRiskEffectiveDate').val(response.policy_detail
                            .effective_date).attr('readonly', true);
                        $('#buildersRiskExpirationDate').val(response.policy_detail
                            .expiration_date).attr('readonly', true);
                        $('.buildersRiskPolicyFormFile').attr('hidden', true);
                        $('.buildersRiskPolicyActionButton').attr('hidden', true);
                        $('#buildersRiskPolicyFormModal').modal('show');
                    }
                }
            });
        });

        $(document).on('click', '.uploadPolicyFileButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');

            $.ajax({
                url: "{{ route('get-policy-information') }}",
                type: "POST",
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response);
                    $('#policyId').val(response.policy_detail.id);
                    if (response.medias == null) {
                        $('#uploadPolicyFile').modal('show');
                    } else {
                        addPoliciesFile(response.medias);
                        $('#uploadPolicyFile').modal('show');

                    }


                }
            })
        });


    });

    $(document).on('click', '.auditInformationButton', function(e) {
        var id = $(this).attr('id');
        console.log('id');
        $('#hiddenPolicyId').val(id);
        $('#auditInformationModal').modal('show');
    });

    $(document).on('click', '.cancelButton', function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        $('#cancelleationPolicyId').val(id);
        $('#policyCancellationModal').modal('show');
    });

    $(document).on('click', '.intentCancelButton', function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        var url = "/cancellation/cancellation-report";
        $.ajax({
            url: "/cancellation/cancellation-report/" + id + '/edit',
            type: "GET",
            data: {
                id: id
            },
            success: function(response) {
                if (response.status == 'success') {
                    if (response.data.policyDetail.status == 'Intent') {
                        $('#isIntent').prop('checked', true);
                        $('#intent').val('1');
                        $('input[name="reinstatedDate"]').attr('hidden', false);
                        $('input[name="reinstatedEligibilityDate"]').attr('hidden', false);
                        $('#reinstatedDateLabel').attr('hidden', false);
                        $('#reinstatedEligibilityDateLabel').attr('hidden', false);
                    } else {
                        $('#isIntent').prop('checked', false);
                        $('#intent').val('0');
                        $('input[name="reinstatedDate"]').attr('hidden', true);
                        $('input[name="reinstatedEligibilityDate"]').attr('hidden', true);
                        $('#reinstatedDateLabel').attr('hidden', true);
                        $('#reinstatedEligibilityDateLabel').attr('hidden', true);
                    }
                    $('#typeOfCancellationDropdown').val(response.data.cancellationReport
                        .type_of_cancellation);
                    $('#reinstatedDate').val(response.data.cancellationReport.reinstated_date);
                    $('#reinstatedEligibilityDate').val(response.data.cancellationReport
                        .reinstated_eligibility_date);
                    $('#agentRemakrs').val(response.data.cancellationReport.agent_remarks);
                    $('#recoveryAction').val(response.data.cancellationReport.recovery_action);
                    $('#cancelleationPolicyId').val(response.data.cancellationReport
                        .policy_details_id);
                    $('#action').val('edit');
                    $('#policyCancellationModal').modal('show');
                } else {
                    swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            }
        });
    });

    $(document).on('click', '.editButton', function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        $.ajax({
            url: "{{ route('get-policy-information') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function(response) {
                console.log(response);
                if (response.product.product == 'General Liability') {
                    $('#glPolicyNumber').val(response.policy_detail.policy_number);
                    $('#glInsuredInput').val(response.lead.company_name);
                    $('#glMarketInput').val(response.policy_detail.market);
                    $('#carriersInput').val(response.policy_detail.carrier);
                    $('#glPaymentTermInput').val(response.paymentInformation
                        .payment_term);
                    $('#commercialGl').prop('checked', response.productPolicyInformation
                        .is_commercial_gl == 1);
                    $('#claimsMade').prop('checked', response.productPolicyInformation
                        .is_claims_made == 1);
                    $('#occur').prop('checked', response.productPolicyInformation
                        .is_occur == 1);
                    $('#glSubrWvd').prop('checked', response.productPolicyInformation
                        .is_subr_wvd == 1);
                    $('#policy').prop('checked', response.productPolicyInformation
                        .is_policy == 1);
                    $('#project').prop('checked', response.productPolicyInformation
                        .is_project == 1);
                    $('#loc').prop('checked', response.productPolicyInformation
                        .is_loc == 1);
                    $('#eachOccurence').val(response.productPolicyInformation
                        .each_occurence);
                    $('#rentedDmg').val(response.productPolicyInformation
                        .damage_to_rented);
                    $('#medExp').val(response.productPolicyInformation
                        .medical_expenses);
                    $('#perAdvInjury').val(response.productPolicyInformation
                        .per_adv_injury);
                    $('#genAggregate').val(response.productPolicyInformation
                        .product_comp);
                    $('#comp').val(response.productPolicyInformation
                        .gen_aggregate);
                    $('#glEffectiveDate').val(response.policy_detail.effective_date);
                    $('#expirationDate').val(response.policy_detail
                        .expiration_date);
                    $('#glHiddenPolicyId').val(response.policy_detail.id);
                    $('#attachedFileLabel').attr('hidden', true);
                    $('#attachedFiles').attr('hidden', true);
                    $('#generalLiabilityAction').val('edit');
                    $('#statusDropdownLabel');
                    $('#statusDropdowm');
                    $('#saveGeneralLiabilitiesPolicyForm');
                    $('#generalLiabilitiesPolicyForm').modal('show');
                }
                if (response.product.product == 'Commercial Auto') {
                    $('#commerciarlAutoPolicyNumber').val(response.policy_detail.policy_number);
                    $('#commercialAutoInsuredInput').val(response.lead.company_name);
                    $('#commercialAutoMarketInput').val(response.policy_detail.market);
                    $('#commercialAutoCarrierInput').val(response.policy_detail.carrier);
                    $('#commercialAutoPaymentTermInput').val(response.paymentInformation
                        .payment_term);
                    $('#anyAuto').prop('checked', response.productPolicyInformation
                        .is_any_auto == 1);
                    $('#ownedAuto').prop('checked', response.productPolicyInformation
                        .is_owned_auto == 1);
                    $('#scheduledAuto').prop('checked', response
                        .productPolicyInformation
                        .is_scheduled_auto == 1);
                    $('#hiredAutos').prop('checked', response
                        .productPolicyInformation
                        .is_hired_auto == 1);
                    $('#nonOwned').prop('checked', response
                        .productPolicyInformation
                        .is_non_owned_auto == 1);
                    $('#commercialAddlInsd').prop('checked', response
                        .productPolicyInformation
                        .is_addl_insd == 1);
                    $('#commercialAutoSubrWvd').prop('checked', response
                        .productPolicyInformation
                        .is_subr_wvd == 1);
                    $('#biPerPerson').val(response.productPolicyInformation
                        .bi_per_person)
                    $('#biPerAccident').val(response.productPolicyInformation
                        .bi_per_accident);
                    $('#combineUnit').val(response.productPolicyInformation
                        .combined_single_unit);
                    $('#propertyDamage').val(response.productPolicyInformation
                        .property_damage)

                    if (response.policyAdditionalValues.length > 0) {
                        response.policyAdditionalValues.forEach(function(limit) {
                            // Create a new row div
                            var newRow = $('<div class="row mb-2"></div>');

                            var nameDiv = $('<div class="col-6"></div>');
                            var nameLabel = $(
                                '<label class="form-label">Blank Limits</label>');
                            var nameInput = $(
                                '<input type="text" class="form-control" name="newBlankLimits[]">'
                            );
                            nameInput.val(limit.name); // Set the value of the input
                            nameDiv.append(nameLabel,
                                nameInput); // Append label and input to the div

                            // Create a div for the limit value
                            var valueDiv = $('<div class="col-6"></div>');
                            var valueLabel = $(
                                '<label class="form-label">Blank Value</label>');
                            var valueInput = $('<div class="input-group"></div>');
                            var valueInputField = $(
                                '<input type="text" class="form-control input-mask text-left" data-inputmask="\'alias\': \'numeric\', \'groupSeparator\': \',\', \'digits\': 2, \'digitsOptional\': false, \'prefix\': \'$ \', \'placeholder\': \'0\'" inputmode="decimal" name="newBlankValue[]" style="text-align: right;">'
                            );
                            valueInputField.val(limit.value); // Set the value of the input
                            var addButton = $(
                                '<button class="btn btn-outline-success addMore" type="button">+</button>'
                            );
                            var deleteButton = $(
                                '<button class="btn btn-outline-danger deleteRow" type="button">-</button>'
                            );

                            valueInput.append(valueInputField, addButton,
                                deleteButton
                            ); // Append input field and buttons to the input group
                            valueDiv.append(valueLabel,
                                valueInput); // Append label and input group to the div

                            // Append the name and value divs to the new row
                            newRow.append(nameDiv, valueDiv);

                            // Insert the dynamically created input fields above the effective date inputs
                            var effectiveDateRow = $('#commercialAutoEffectiveDate')
                                .closest('.row');
                            effectiveDateRow.before(newRow);

                            $('#commercialAutoForm input[type="text"]').each(
                                function() {
                                    if ($(this).val() === '') {
                                        $(this).closest('.row')
                                            .remove(); // Remove the parent row if the input has no value
                                    }
                                }
                            );

                            // Re-initialize input masks for new inputs
                            $('.input-mask').inputmask({
                                'alias': 'numeric',
                                'groupSeparator': ',',
                                'digits': 2,
                                'digitsOptional': false,
                                'prefix': '$ ',
                                'placeholder': '0'
                            });

                        });
                    }

                    $('#commercialFileDiv').attr('hidden', true);
                    $('#commercialAutoEffectiveDate').val(response.policy_detail
                        .effective_date);
                    $('#commercialAutoExpirationDate').val(response.policy_detail
                        .expiration_date);
                    $('#commercialAutoHiddenPolicyid').val(response.policy_detail.id);
                    $('.commercialAutoPolicyActionButton').val('update');
                    $('#commercialAutoPolicyForm').modal('show');
                }
                if (response.product.product == 'Business Owners') {
                    $('#businessOwnersNumber').val(response.policy_detail.policy_number);
                    $('#businessOwnersInsuredInput').val(response.lead
                        .company_name);
                    $('#businessOwnersMarketInput').val(response.policy_detail.market);
                    $('#businessOwnersCarrierInput').val(response.policy_detail.carrier);
                    $('#businessOwnersPaymentTermInput').val(response.paymentInformation
                        .payment_term);
                    $('#businessOwnersAddlInsd').prop('checked', response
                        .productPolicyInformation
                        .is_addl_insd == 1);
                    $('#businessOwnersSubrWvd').prop('checked', response
                        .productPolicyInformation
                        .is_subr_wvd == 1);
                    if (response.policyAdditionalValues.length > 0) {
                        response.policyAdditionalValues.forEach(function(limit) {
                            var newRow = $('<div class="row mb-2"></div>');

                            var nameDiv = $('<div class="col-6"></div>');
                            var nameLabel = $(
                                '<label class="form-label" for="blankLimits">' +
                                limit.name + '</label>');
                            var nameInput = $(
                                '<input type="text" class="form-control" id="blankLimits" name="newBlankLimits[]" >'
                            );
                            nameInput.val(limit
                                .name); // Set the value of the input
                            nameDiv.append(nameLabel,
                                nameInput); // Append label and input to the div

                            // Create a div for the limit value
                            var valueDiv = $('<div class="col-6"></div>');
                            var valueLabel = $(
                                '<label class="form-label" for="blankValue">Blank Value</label>'
                            );
                            var valueInput = $(
                                '<div class="input-group"></div>');
                            var valueInputField = $(
                                '<input type="text" class="form-control input-mask text-left" data-inputmask="\'alias\': \'numeric\', \'groupSeparator\': \',\', \'digits\': 2, \'digitsOptional\': false, \'prefix\': \'$ \', \'placeholder\': \'0\'" inputmode="decimal" style="text-align: right;" id="blankValue" name="newBlankValue[]">'
                            );
                            valueInputField.val(limit
                                .value);
                            var addButton = $(
                                '<button class="btn btn-outline-success addMore" type="button">+</button>'
                            );
                            var deleteButton = $(
                                '<button class="btn btn-outline-danger deleteRow" type="button">-</button>'
                            );
                            // Set the value of the input
                            // var addButton = $(
                            //     '<button class="btn btn-outline-success addMore" type="button" id="addMore">+</button>'
                            // );
                            valueInput.append(valueInputField, addButton,
                                deleteButton
                            ); // Append input field and add button to the input group
                            valueDiv.append(valueLabel,
                                valueInput
                            ); // Append label and input group to the div

                            // Append the name and value divs to the new row
                            newRow.append(nameDiv, valueDiv);

                            // Insert the dynamically created input fields above the effective date inputs
                            var effectiveDateRow = $(
                                    '#businessOwnersEffectiveDate')
                                .closest('.row');
                            effectiveDateRow.before(newRow);

                            // Remove any input fields with no data
                            $('#businessOwnersPolicyForm input[type="text"]')
                                .each(
                                    function() {
                                        if ($(this).val() === '') {
                                            $(this).closest('.row')
                                                .remove(); // Remove the parent row if the input has no value
                                        }
                                    }
                                );

                            // Re-initialize input masks for new inputs
                            $('.input-mask').inputmask({
                                'alias': 'numeric',
                                'groupSeparator': ',',
                                'digits': 2,
                                'digitsOptional': false,
                                'prefix': '$ ',
                                'placeholder': '0'
                            });
                        });
                    }
                    $('#businessOwnersEffectiveDate').val(response.policy_detail
                        .effective_date);
                    $('#businessOwnersExpirationDate').val(response.policy_detail
                        .expiration_date);
                    $('#businessOwnersPolicyId').val(response.policy_detail.id);
                    $('#businessOwnersFileDiv').attr('hidden', true);
                    $('.businessOwnersPolicyActionButton').val('Update');
                    $('#businessOwnersPolicyFormModal').modal('show');
                }
                if (response.product.product == 'Tools Equipment') {

                    $('#toolsEquipmentPolicyNumber').val(response.policy_detail
                        .policy_number);
                    $('#toolsEquipmentInsuredInput').val(response.lead
                        .company_name);
                    $('#toolsEquipmentMarketInput').val(response.policy_detail.market);
                    $('#toolsEquipmentCarrierInput').val(response.policy_detail.carrier);
                    $('#toolsEquipmentPaymentTermInput').val(response.paymentInformation
                        .payment_term);
                    $('#toolsEquipmentAddlInsd').prop('checked', response
                        .productPolicyInformation
                        .is_addl_insd == 1);
                    $('#toolsEquipmentSubrWvd').prop('checked', response
                        .productPolicyInformation
                        .is_subr_wvd == 1);
                    if (response.policyAdditionalValues.length > 0) {
                        response.policyAdditionalValues.forEach(function(limit) {
                            var newRow = $('<div class="row mb-2"></div>');

                            var nameDiv = $('<div class="col-6"></div>');
                            var nameLabel = $(
                                '<label class="form-label" for="blankLimits">' +
                                limit.name + '</label>');
                            var nameInput = $(
                                '<input type="text" class="form-control" id="blankLimits" name="newBlankLimits[]" >'
                            );
                            nameInput.val(limit
                                .name); // Set the value of the input
                            nameDiv.append(nameLabel,
                                nameInput); // Append label and input to the div

                            // Create a div for the limit value
                            var valueDiv = $('<div class="col-6"></div>');
                            var valueLabel = $(
                                '<label class="form-label" for="blankValue">Blank Value</label>'
                            );
                            var valueInput = $(
                                '<div class="input-group"></div>');
                            var valueInputField = $(
                                '<input type="text" class="form-control input-mask text-left" data-inputmask="\'alias\': \'numeric\', \'groupSeparator\': \',\', \'digits\': 2, \'digitsOptional\': false, \'prefix\': \'$ \', \'placeholder\': \'0\'" inputmode="decimal" style="text-align: right;" id="blankValue" name="newBlankValue[]" >'
                            );
                            valueInputField.val(limit
                                .value); // Set the value of the input
                            // var addButton = $(
                            //     '<button class="btn btn-outline-success addMore" type="button" id="addMore">+</button>'
                            // );

                            var addButton = $(
                                '<button class="btn btn-outline-success addMore" type="button">+</button>'
                            );
                            var deleteButton = $(
                                '<button class="btn btn-outline-danger deleteRow" type="button">-</button>'
                            );


                            valueInput.append(valueInputField, addButton,
                                deleteButton

                            ); // Append input field and add button to the input group
                            valueDiv.append(valueLabel,
                                valueInput
                            ); // Append label and input group to the div

                            // Append the name and value divs to the new row
                            newRow.append(nameDiv, valueDiv);

                            // Insert the dynamically created input fields above the effective date inputs
                            var effectiveDateRow = $(
                                    '#toolsEquipmentEffectiveDate')
                                .closest('.row');
                            effectiveDateRow.before(newRow);

                            // Remove any input fields with no data
                            $('#toolsEquipmentForm input[type="text"]')
                                .each(
                                    function() {
                                        if ($(this).val() === '') {
                                            $(this).closest('.row')
                                                .remove(); // Remove the parent row if the input has no value
                                        }
                                    }
                                );

                            // Re-initialize input masks for new inputs
                            $('.input-mask').inputmask({
                                'alias': 'numeric',
                                'groupSeparator': ',',
                                'digits': 2,
                                'digitsOptional': false,
                                'prefix': '$ ',
                                'placeholder': '0'
                            });

                        });
                    }
                    $('#toolsEquipmentEffectiveDate').val(response.policy_detail
                        .effective_date);
                    $('#toolsEquipmentExpirationDate').val(response.policy_detail
                        .expiration_date);
                    $('#toolsEquipmentHiddenPolicyId').val(response.policy_detail.id);
                    $('#toolsEquipmentFileDiv').attr('hidden', true);
                    $('.toolsEquipmentPolicyFornActionButton').val('Update');
                    $('#toolsEquipmentPolicyFormModal').modal('show');
                }
                if (response.product.product == 'Excess Liability') {
                    $('#excessInsuranceNumber').val(response.policy_detail
                        .policy_number);
                    $('#excessInsuranceInsuredInput').val(response.lead
                        .company_name);
                    $('#excessInsuranceMarketInput').val(response.policy_detail.market);
                    $('#excessInsuranceCarrierInput').val(response.policy_detail
                        .carrier);
                    $('#excessInsurancePaymentTermInput').val(response
                        .paymentInformation
                        .payment_term);
                    $('#excessInsuranceUmbrellaLiabl').prop('checked', response
                        .productPolicyInformation
                        .is_umbrella_liability == 1);
                    $('#excessInsuranceExcessLiability').prop('checked', response
                        .productPolicyInformation
                        .is_excess_liability == 1);
                    $('#excessInsuranceOccur').prop('checked', response
                        .productPolicyInformation
                        .is_occur == 1);
                    $('#excessInsuranceClaimsMade').prop('checked', response
                        .productPolicyInformation
                        .is_claims_made == 1);
                    $('#excessInsuranceDed').prop('checked', response
                        .productPolicyInformation
                        .is_ded == 1);
                    $('#excessInsuranceRetention').prop('checked', response
                        .productPolicyInformation
                        .is_retention == 1);
                    $('#excessInsuranceAddlInsd').prop('checked', response
                        .productPolicyInformation
                        .is_addl_insd == 1);
                    $('#excessInsuranceSubrWvd').prop('checked', response
                        .productPolicyInformation
                        .is_subr_wvd == 1);
                    $('#excessInsuranceEachOccurrence').val(response
                        .productPolicyInformation
                        .each_occurrence);
                    $('#excessInsuranceAggregate').val(response
                        .productPolicyInformation
                        .aggregate);
                    if (response.policyAdditionalValues.length > 0) {
                        response.policyAdditionalValues.forEach(function(limit) {
                            var newRow = $('<div class="row mb-2"></div>');

                            var nameDiv = $('<div class="col-6"></div>');
                            var nameLabel = $(
                                '<label class="form-label" for="blankLimits">' +
                                limit.name + '</label>');
                            var nameInput = $(
                                '<input type="text" class="form-control" id="blankLimits" name="newBlankLimits[]" >'
                            );
                            nameInput.val(limit
                                .name); // Set the value of the input
                            nameDiv.append(nameLabel,
                                nameInput); // Append label and input to the div

                            // Create a div for the limit value
                            var valueDiv = $('<div class="col-6"></div>');
                            var valueLabel = $(
                                '<label class="form-label" for="blankValue">Blank Value</label>'
                            );
                            var valueInput = $(
                                '<div class="input-group"></div>');
                            var valueInputField = $(
                                '<input type="text" class="form-control input-mask text-left" data-inputmask="\'alias\': \'numeric\', \'groupSeparator\': \',\', \'digits\': 2, \'digitsOptional\': false, \'prefix\': \'$ \', \'placeholder\': \'0\'" inputmode="decimal" style="text-align: right;" id="blankValue" name="newBlankValue[]">'
                            );

                            var addButton = $(
                                '<button class="btn btn-outline-success addMore" type="button">+</button>'
                            );
                            var deleteButton = $(
                                '<button class="btn btn-outline-danger deleteRow" type="button">-</button>'
                            );
                            valueInputField.val(limit
                                .value); // Set the value of the input
                            // var addButton = $(
                            //     '<button class="btn btn-outline-success addMore" type="button" id="addMore">+</button>'
                            // );
                            valueInput.append(valueInputField, addButton, deleteButton

                            ); // Append input field and add button to the input group
                            valueDiv.append(valueLabel,
                                valueInput
                            ); // Append label and input group to the div

                            // Append the name and value divs to the new row
                            newRow.append(nameDiv, valueDiv);

                            // Insert the dynamically created input fields above the effective date inputs
                            var effectiveDateRow = $(
                                    '#excessInsuranceEffectiveDate')
                                .closest('.row');
                            effectiveDateRow.before(newRow);

                            // Remove any input fields with no data
                            $('#excessInsurancePolicyForm input[type="text"]')
                                .each(
                                    function() {
                                        if ($(this).val() === '') {
                                            $(this).closest('.row')
                                                .remove(); // Remove the parent row if the input has no value
                                        }
                                    }
                                );
                        });
                    }
                    $('#excessInsuranceEffectiveDate').val(response.policy_detail
                        .effective_date);
                    $('#excessInsuranceExpirationDate').val(response.policy_detail
                        .expiration_date);
                    $('#excessLiabilityHiddenPolicyId').val(response.policy_detail.id);
                    $('.excessInsruancePolicyFormFile').attr('hidden', true);
                    $('.excessInsurancePolicyFormActionButton').val('Update');
                    $('#excessInsurancePolicyFormModal').modal('show');
                }
                if (response.product.product == 'Workers Compensation') {
                    $('#workersCompensationPolicyNumber').val(response.policy_detail
                        .policy_number);
                    $('#workersCompensationInsuredInput').val(response.lead
                        .company_name);
                    $('#workersCompensationMarketInput').val(response.policy_detail
                        .market);
                    $('#workersCompensationCarrierInput').val(response.policy_detail
                        .carrier);
                    $('#workersCompensationPaymentTermInput').val(response
                        .paymentInformation
                        .payment_term);
                    $('#workersCompSubrWvd').prop('checked', response
                        .productPolicyInformation
                        .is_subr_wvd == 1);
                    $('#workersPerstatute').prop('checked', response
                        .productPolicyInformation
                        .is_per_statute == 1);
                    $('#elEachAccident').val(response.productPolicyInformation
                        .el_each_accident);
                    $('#elDiseasePolicyLimit').val(response.productPolicyInformation
                        .el_disease_policy_limit);
                    $('#elDiseaseEachEmployee').val(response.productPolicyInformation
                        .el_disease_each_employee);
                    if (response.policyAdditionalValues.length > 0) {
                        response.policyAdditionalValues.forEach(function(limit) {
                            var newRow = $('<div class="row mb-2"></div>');

                            var nameDiv = $('<div class="col-6"></div>');
                            var nameLabel = $(
                                '<label class="form-label" for="blankLimits">' +
                                limit.name + '</label>');
                            var nameInput = $(
                                '<input type="text" class="form-control" id="blankLimits" name="newBlankLimits[]" >'
                            );
                            nameInput.val(limit
                                .name); // Set the value of the input
                            nameDiv.append(nameLabel,
                                nameInput); // Append label and input to the div

                            // Create a div for the limit value
                            var valueDiv = $('<div class="col-6"></div>');
                            var valueLabel = $(
                                '<label class="form-label" for="blankValue">Blank Value</label>'
                            );
                            var valueInput = $(
                                '<div class="input-group"></div>');
                            var valueInputField = $(
                                '<input type="text" class="form-control input-mask text-left" data-inputmask="\'alias\': \'numeric\', \'groupSeparator\': \',\', \'digits\': 2, \'digitsOptional\': false, \'prefix\': \'$ \', \'placeholder\': \'0\'" inputmode="decimal" style="text-align: right;" id="blankValue" name="newBlankValue[]" >'
                            );

                            var addButton = $(
                                '<button class="btn btn-outline-success addMore" type="button">+</button>'
                            );
                            var deleteButton = $(
                                '<button class="btn btn-outline-danger deleteRow" type="button">-</button>'
                            );
                            valueInputField.val(limit
                                .value); // Set the value of the input
                            // var addButton = $(
                            //     '<button class="btn btn-outline-success addMore" type="button" id="addMore">+</button>'
                            // );
                            valueInput.append(valueInputField, addButton, deleteButton

                            ); // Append input field and add button to the input group
                            valueDiv.append(valueLabel,
                                valueInput
                            ); // Append label and input group to the div

                            // Append the name and value divs to the new row
                            newRow.append(nameDiv, valueDiv);

                            // Insert the dynamically created input fields above the effective date inputs
                            var effectiveDateRow = $(
                                    '#workersCompensationEffectiveDate')
                                .closest('.row');
                            effectiveDateRow.before(newRow);

                            // Remove any input fields with no data
                            $('#workersCompensationForm input[type="text"]')
                                .each(
                                    function() {
                                        if ($(this).val() === '') {
                                            $(this).closest('.row')
                                                .remove(); // Remove the parent row if the input has no value
                                        }
                                    });
                        });
                    }
                    $('#workersCompensationEffectiveDate').val(response.policy_detail
                        .effective_date);
                    $('#workersCompensationExpirationDate').val(response.policy_detail
                        .expiration_date);
                    $('#workersCompensationHiddenPolicyId').val(response.policy_detail.id);
                    $('.workersCompensationPolicyFormFile').attr('hidden', true);
                    $('.workersCompensationPolicyActionButton').val('Update');
                    $('#workersCompensationModalForm').modal('show');
                }
                if (response.product.product == 'Builders Risk') {
                    $('#buildersRiskPolicyNumber').val(response.policy_detail
                        .policy_number);
                    $('#buildersRiskInsuredInput').val(response.lead
                        .company_name);
                    $('#buildersRiskMarketInput').val(response.policy_detail
                        .market);
                    $('#buildersRiskCarrierInput').val(response.policy_detail
                        .carrier);
                    $('#buildersRiskPaymentTermInput').val(response
                        .paymentInformation
                        .payment_term);
                    $('#buildersRiskAddlInsd').prop('checked', response
                        .productPolicyInformation
                        .is_addl_insd == 1);
                    $('#buildersRiskSubrWvd').prop('checked', response
                        .productPolicyInformation
                        .is_subr_wvd == 1);
                    if (response.policyAdditionalValues.length > 0) {
                        response.policyAdditionalValues.forEach(function(limit) {
                            var newRow = $('<div class="row mb-2"></div>');

                            var nameDiv = $('<div class="col-6"></div>');
                            var nameLabel = $(
                                '<label class="form-label" for="blankLimits">' +
                                limit.name + '</label>');
                            var nameInput = $(
                                '<input type="text" class="form-control" id="blankLimits" name="newBlankLimits[]" >'
                            );
                            nameInput.val(limit
                                .name); // Set the value of the input
                            nameDiv.append(nameLabel,
                                nameInput); // Append label and input to the div

                            // Create a div for the limit value
                            var valueDiv = $('<div class="col-6"></div>');
                            var valueLabel = $(
                                '<label class="form-label" for="blankValue">Blank Value</label>'
                            );
                            var valueInput = $(
                                '<div class="input-group"></div>');
                            var valueInputField = $(
                                '<input type="text" class="form-control input-mask text-left" data-inputmask="\'alias\': \'numeric\', \'groupSeparator\': \',\', \'digits\': 2, \'digitsOptional\': false, \'prefix\': \'$ \', \'placeholder\': \'0\'" inputmode="decimal" style="text-align: right;" id="blankValue" name="newBlankValue[]" >'
                            );
                            var addButton = $(
                                '<button class="btn btn-outline-success addMore" type="button">+</button>'
                            );
                            var deleteButton = $(
                                '<button class="btn btn-outline-danger deleteRow" type="button">-</button>'
                            );
                            valueInputField.val(limit
                                .value); // Set the value of the input
                            // var addButton = $(
                            //     '<button class="btn btn-outline-success addMore" type="button" id="addMore">+</button>'
                            // );
                            valueInput.append(valueInputField, addButton, deleteButton

                            ); // Append input field and add button to the input group
                            valueDiv.append(valueLabel,
                                valueInput
                            ); // Append label and input group to the div

                            // Append the name and value divs to the new row
                            newRow.append(nameDiv, valueDiv);

                            // Insert the dynamically created input fields above the effective date inputs
                            var effectiveDateRow = $(
                                    '#buildersRiskEffectiveDate')
                                .closest('.row');
                            effectiveDateRow.before(newRow);

                            // Remove any input fields with no data
                            $('#buildersRiskForm input[type="text"]')
                                .each(
                                    function() {
                                        if ($(this).val() === '') {
                                            $(this).closest('.row')
                                                .remove(); // Remove the parent row if the input has no value
                                        }
                                    });
                        });
                    }
                    $('#buildersRiskEffectiveDate').val(response.policy_detail
                        .effective_date);
                    $('#buildersRiskExpirationDate').val(response.policy_detail
                        .expiration_date);
                    $('#buildersRiskHiddenPolicyId').val(response.policy_detail.id);
                    $('.buildersRiskPolicyFormFile').attr('hidden', true);
                    $('.buildersRiskPolicyActionButton').val('Update');
                    $('#buildersRiskPolicyFormModal').modal('show');
                }
            }
        });
    });
</script>
