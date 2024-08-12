@php
    use App\Models\UserProfile;
    use App\Models\QuotationProduct;
@endphp

<style>
    .message-box {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 15px;
        background-color: #f9f9f9;
    }

    .message-box .sender-icon {
        margin-right: 10px;
    }

    .message-box .message-date {
        font-size: 0.9rem;
        color: #888;
    }
</style>
<div class="row">
    <div class="col-4">
        <div class="row ">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        Recent Activity
                    </div>
                    <div class="row">
                        @foreach ($leads->recentLeadHistories as $history)
                            @php
                                $changes = json_decode($history->changes);
                            @endphp
                            @if (isset($changes->assigned_at))
                                <div class="d-flex align-items-start mb-1">
                                    <i class="ri-list-check mr-1" style="font-size: 12px;"></i>
                                    <div class="ml-2" style="margin-left: 0.5rem;">
                                        <p class="mb-0 text-muted" style="font-size: 12px;">Assigned to:
                                            {{ $history->userProfile->fullName() }}.</p>
                                        <span class="cd-date"
                                            style="font-size: 11px;">{{ \Carbon\Carbon::parse($changes->assigned_at)->format('M-j-Y g:iA') }}</span>
                                    </div>
                                </div>
                            @elseif(isset($changes->reassigned_at))
                                <div class="d-flex align-items-start mb-1">
                                    <i class="ri-list-check mr-1" style="font-size: 12px;"></i>
                                    <div class="ml-2" style="margin-left: 0.5rem;">
                                        <p class="mb-0 text-muted" style="font-size: 12px;">Reassigned to:
                                            {{ $history->userProfile->fullName() }}.</p>
                                        <span class="cd-date"
                                            style="font-size: 11px;">{{ \Carbon\Carbon::parse($changes->reassigned_at)->format('M-j-Y g:iA') }}</span>
                                    </div>
                                </div>
                            @elseif(isset($changes->old_owner_name))
                                @php
                                    $product = QuotationProduct::find($changes->product_id);
                                @endphp
                                <div class="d-flex align-items-start mb-1">
                                    <i class="ri-list-check mr-1" style="font-size: 12px;"></i>
                                    <div class="ml-2" style="margin-left: 0.5rem;">
                                        <p class="mb-0 text-muted" style="font-size: 12px;">{{ $product->product }}
                                            Reassigned to:
                                            {{ $changes->new_owner_name }}.</p>
                                        <span class="cd-date"
                                            style="font-size: 11px;">{{ \Carbon\Carbon::parse($history->created_at)->format('M-j-Y g:iA') }}</span>
                                    </div>
                                </div>
                            @elseif (isset($changes->appointed_by))
                                <div class="d-flex align-items-start mb-1">
                                    <i class="ri-list-check mr-1" style="font-size: 12px;"></i>
                                    <div class="ml-2" style="margin-left: 0.5rem;">
                                        <p class="mb-0 text-muted" style="font-size: 12px;">Application Taken by:
                                            {{ $history->userProfile->fullName() }}.</p>
                                        <span class="cd-date"
                                            style="font-size: 11px;">{{ \Carbon\Carbon::parse($changes->appointed_by)->format('M-j-Y g:iA') }}</span>
                                    </div>
                                </div>
                            @elseif(isset($changes->assign_appointed_at))
                                @php
                                    $product = $history->getProductByProductId($changes->product_id);
                                @endphp
                                <div class="d-flex align-items-start mb-1">
                                    <i class="ri-list-check mr-1" style="font-size: 12px;"></i>
                                    <div class="ml-2" style="margin-left: 0.5rem;">
                                        <p class="mb-0 text-muted" style="font-size: 12px;">{{ $product->product }} Has
                                            Been
                                            assigned to:
                                            {{ $history->userProfile->fullName() }}.</p>
                                        <span class="cd-date"
                                            style="font-size: 11px;">{{ \Carbon\Carbon::parse($changes->assign_appointed_at)->format('M-j-Y g:iA') }}</span>
                                    </div>
                                </div>
                            @elseif(isset($changes->type) && $changes->type == 'renewal_reminder')
                                <div class="d-flex align-items-start mb-1">
                                    <i class="ri-list-check mr-1" style="font-size: 12px;"></i>
                                    <div class="ml-2" style="margin-left: 0.5rem;">
                                        <p class="mb-0 text-muted" style="font-size: 12px;">Renewal Reminder Sent By:
                                            {{ $history->userProfile->fullName() }}.</p>
                                        <span class="text-primary font-weight-bold"
                                            style="font-size: 11px;">{{ \Carbon\Carbon::parse($changes->sent_date)->format('M j, Y g:i A') }}</span>
                                    </div>
                                </div>
                            @elseif(isset($changes->changes) && $changes->type == 'general-information-update')
                                <div class="d-flex align-items-start mb-1">
                                    <i class="ri-list-check mr-1" style="font-size: 12px;"></i>
                                    <div class="ml-2" style="margin-left: 0.5rem;">
                                        <p class="mb-0 text-muted" style="font-size: 12px;">General Information Updated
                                            By:
                                            {{ $history->userProfile->fullName() }}.</p>
                                        <span class="cd-date"
                                            style="font-size: 11px;">{{ \Carbon\Carbon::parse($changes->sent_out_date)->format('M-j-Y g:iA') }}</span>
                                    </div>
                                </div>
                            @elseif(isset($changes->changes) && $changes->type == 'general-liabilities-update')
                                <div class="d-flex align-items-start mb-1">
                                    <i class="ri-list-check mr-1" style="font-size: 12px;"></i>
                                    <div class="ml-2" style="margin-left: 0.5rem;">
                                        <p class="mb-0 text-muted" style="font-size: 12px;">General Liability Updated
                                            By:
                                            {{ $history->userProfile->fullName() }}.</p>
                                        <span class="cd-date"
                                            style="font-size: 11px;">{{ \Carbon\Carbon::parse($changes->sent_out_date)->format('M-j-Y g:iA') }}</span>
                                    </div>
                                </div>
                            @elseif(isset($changes->changes) && $changes->type == 'workers-compensation-update')
                                <div class="d-flex align-items-start mb-1">
                                    <i class="ri-list-check mr-1" style="font-size: 12px;"></i>
                                    <div class="ml-2" style="margin-left: 0.5rem;">
                                        <p class="mb-0 text-muted" style="font-size: 12px;">Workers Compensation
                                            Updated
                                            By:
                                            {{ $history->userProfile->fullName() }}.</p>
                                        <span class="cd-date"
                                            style="font-size: 11px;">{{ \Carbon\Carbon::parse($changes->sent_out_date)->format('M-j-Y g:iA') }}</span>
                                    </div>
                                </div>
                            @elseif(isset($changes->changes) && $changes->type == 'commercial-auto-update')
                                <div class="d-flex align-items-start mb-1">
                                    <i class="ri-list-check mr-1" style="font-size: 12px;"></i>
                                    <div class="ml-2" style="margin-left: 0.5rem;">
                                        <p class="mb-0 text-muted" style="font-size: 12px;">Commercial Auto Updated
                                            By:
                                            {{ $history->userProfile->fullName() }}.</p>
                                        <span class="cd-date"
                                            style="font-size: 11px;">{{ \Carbon\Carbon::parse($changes->sent_out_date)->format('M-j-Y g:iA') }}</span>
                                    </div>
                                </div>
                            @elseif(isset($changes->changes) && $changes->type == 'excess-liability-update')
                                <div class="d-flex align-items-start mb-1">
                                    <i class="ri-list-check mr-1" style="font-size: 12px;"></i>
                                    <div class="ml-2" style="margin-left: 0.5rem;">
                                        <p class="mb-0 text-muted" style="font-size: 12px;">Excess Liability Updated
                                            By:
                                            {{ $history->userProfile->fullName() }}.</p>
                                        <span class="cd-date"
                                            style="font-size: 11px;">{{ \Carbon\Carbon::parse($changes->sent_out_date)->format('M-j-Y g:iA') }}</span>
                                    </div>
                                </div>
                            @elseif(isset($changes->changes) && $changes->type == 'tools-equipment-update')
                                <div class="d-flex align-items-start mb-1">
                                    <i class="ri-list-check mr-1" style="font-size: 12px;"></i>
                                    <div class="ml-2" style="margin-left: 0.5rem;">
                                        <p class="mb-0 text-muted" style="font-size: 12px;">Tools Equipment Updated
                                            By:
                                            {{ $history->userProfile->fullName() }}.</p>
                                        <span class="cd-date"
                                            style="font-size: 11px;">{{ \Carbon\Carbon::parse($changes->sent_out_date)->format('M-j-Y g:iA') }}</span>
                                    </div>
                                </div>
                            @elseif(isset($changes->changes) && $changes->type == 'builders-risk-update')
                                <div class="d-flex align-items-start mb-1">
                                    <i class="ri-list-check mr-1" style="font-size: 12px;"></i>
                                    <div class="ml-2" style="margin-left: 0.5rem;">
                                        <p class="mb-0 text-muted" style="font-size: 12px;">Builders Risk Updated By:
                                            {{ $history->userProfile->fullName() }}.</p>
                                        <span class="cd-date"
                                            style="font-size: 11px;">{{ \Carbon\Carbon::parse($changes->sent_out_date)->format('M-j-Y g:iA') }}</span>
                                    </div>
                                </div>
                            @elseif(isset($changes->changes) && $changes->type == 'business-owners-policy-update')
                                <div class="d-flex align-items-start mb-1">
                                    <i class="ri-list-check mr-1" style="font-size: 12px;"></i>
                                    <div class="ml-2" style="margin-left: 0.5rem;">
                                        <p class="mb-0 text-muted" style="font-size: 12px;">Business Owners Policy
                                            Updated
                                            By:
                                            {{ $history->userProfile->fullName() }}.</p>
                                        <span class="cd-date"
                                            style="font-size: 11px;">{{ \Carbon\Carbon::parse($changes->sent_out_date)->format('M-j-Y g:iA') }}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <h6 style="font-size: 12px;">Recent Notes</h6>
                    </div>
                    @foreach ($leads->recentNotes as $note)
                        <div class="row mb-1">
                            <div class="message-box d-flex align-items-start">
                                <div class="sender-icon mr-2">
                                    @php
                                        $userProfileFilePath = UserProfile::find($note->user_profile_id)->media
                                            ->filepath;
                                    @endphp
                                    <img src="{{ asset($userProfileFilePath) }}" class="me-1 mt-0 rounded-circle"
                                        style="width: 20px; height: 20px;" alt="user-pic">
                                </div>
                                <div>
                                    <h6 style="font-size: 10px; margin-bottom: 0.2rem;">{{ $note->title }}</h6>
                                    <p class="mb-0 text-muted" style="font-size: 10px;">{{ $note->description }}</p>
                                    <span class="message-date"
                                        style="font-size: 9px; color: #6c757d;">{{ \Carbon\Carbon::parse($note->created_at)->format('M-j-Y g:iA') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-8">
        <div class="row mb2">
            <div class="col-12">
                <div class="card"
                    style="padding: 10px; background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                    <div class="card-body" style="padding: 10px;">
                        <table id="policySummaryList"
                            class="table table-bordered dt-responsive nowrap policySummaryList"
                            style="border-collapse: collapse; width: 100%; font-size: 12px;">
                            <thead style="background-color: #f0f0f0; font-size: 12px;">
                                <tr>
                                    <th style="padding: 5px;">Effective Date</th>
                                    <th style="padding: 5px;">Policy Number</th>
                                    <th style="padding: 5px;">Product</th>
                                    <th style="padding: 5px;">Market</th>
                                    <th style="padding: 5px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Your table data here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
    Dropzone.autoDiscover = false;
    var policyDropzone;
    $(document).ready(function() {
        var id = {{ $leadId }};
        $('.policySummaryList').DataTable({
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
                {
                    data: 'market',
                    name: 'market'
                },
                // {
                //     data: 'total_cost',
                //     name: 'total_cost'
                // },
                {
                    data: 'policyStatus',
                    name: 'policyStatus'
                },
                // {
                //     data: 'action',
                //     name: 'action',
                // }
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
                        $('#commercialAutoInsuredInput').val(response.general_information
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
        })
    });
</script>
