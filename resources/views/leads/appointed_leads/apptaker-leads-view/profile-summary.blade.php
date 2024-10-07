@php
    use App\Models\UserProfile;
    use App\Models\QuotationProduct;

    function getBackgroundColor($index)
    {
        $colors = [
            'linear-gradient(to right, #e0f7fa, #b2ebf2)', // Light Blue to Light Teal
            'linear-gradient(to right, #ffe0b2, #ffccbc)', // Soft Peach to Light Coral
            'linear-gradient(to right, #e1bee7, #f8bbd0)', // Lavender to Soft Pink
            'linear-gradient(to right, #c8e6c9, #a5d6a7)', // Light Mint to Pale Green
            'linear-gradient(to right, #fff9c4, #fff59d)', // Soft Yellow to Light Lemon
            'linear-gradient(to right, #ffe0b2, #ffcc80)', // Pale Orange to Light Apricot
            'linear-gradient(to right, #bbdefb, #b3e5fc)', // Soft Sky Blue to Light Cyan
        ];
        return $colors[$index % count($colors)]; // Cycle through colors
    }

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
        <div class="row">
            <div class="card shadow-lg  bg-white rounded">
                <div class="card-body">
                    <div class="row mb-3">
                        Recent Activity
                        <hr>
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
            <div class="card shadow-lg mb-5 bg-white rounded">
                <div class="card-body">
                    <div class="row mb-2">
                        <h6 style="font-size: 12px;">Recent Notes</h6>
                        <hr>

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

        <div class="row">
            <div class="col-12">
                {{-- @include('leads.task-scheduler.taskscheduler-list') --}}
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Recent Task Schedule</h5>
                        <button class="btn btn-primary btn-sm addTaskButton" id="addTaskButton" name="addTask"
                            type="button">ADD TASK</button>
                    </div>
                    <div id="task-list" class="list-group list-group-flush">
                        <!-- Task items will be dynamically loaded here -->
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg mb-5 bg-white rounded"
                    style="padding: 10px; background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                    <div class="card-body" style="padding: 10px;">
                        <div class="row">
                            <h6 class="card-title">Policies</h6>
                            <hr>
                        </div>
                        <div class="row">
                            @foreach ($activePolicies as $index => $policy)
                                <!-- Bootstrap column for three cards per row -->
                                <div class="col-md-4 mb-3">
                                    <!-- Card with dynamic background color -->
                                    <div class="card shadow-sm rounded border-0 position-relative"
                                        style="background: {{ getBackgroundColor($index) }};">
                                        <!-- Three Dots Dropdown -->
                                        <div class="dropdown position-absolute top-0 end-0 m-2">
                                            <a href="#" class="text-secondary" id="dropdownMenuLink"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="dripicons-dots-3"></i>
                                                <!-- Bootstrap Icons for three dots -->
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuLink">
                                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                                <li><a class="dropdown-item" href="#">Delete</a></li>
                                            </ul>
                                        </div>
                                        <!-- Card Body -->
                                        <div class="card-body">
                                            <a href="{{ asset($policy->medias->filepath) }}" target="_blank"><i
                                                    class="dripicons-document-new fs-2 text-secondary mb-2"></i></a>
                                            <!-- File Icon -->
                                            <h6 class="fw-bold">{{ $policy->policy_number }}</h6>
                                            <p class="fw-bold mb-1" style="font-size: 14px;">
                                                {{ \App\Models\QuotationProduct::find($policy->quotation_product_id)->product }}
                                            </p>
                                            <small class="text-muted">Expiration on
                                                {{ date('d M, Y', strtotime($policy->expiration_date)) }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{-- <div class="col-3">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                    <div class="card-body p-1">
                        <div class="row">

                        </div>
                        <div>
                            @foreach ($activePolicies as $policy)
                                <div class="alert alert-primary d-flex justify-content-between align-items-center py-1 px-2 mb-1"
                                    role="alert" style="font-size: 0.75rem;">
                                    <span class="text-truncate">{{ $policy->policy_number }}</span>
                                    <!-- Truncated text for compact display -->

                                    <div class="dropdown ms-auto">
                                        <a href="#" class="text-secondary small" id="dropdownMenuLink"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="dripicons-dots-3"></i> <!-- Three dots icon -->
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end"
                                            aria-labelledby="dropdownMenuLink">
                                            <li><a class="dropdown-item" href="#">Action 1</a></li>
                                            <li><a class="dropdown-item" href="#">Action 2</a></li>
                                            <li><a class="dropdown-item" href="#">Action 3</a></li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <table id="policySummaryList"
                            class="table table-bordered dt-responsive nowrap policySummaryList"
                            style="border-collapse: collapse; width: 100%; font-size: 12px;">
                            <thead style="background-color: #f0f0f0; font-size: 12px;">
                                <tr>
                                    <th style="padding: 5px;">Policy Number</th>
                                    <th style="padding: 5px;">Product</th>
                                    <th style="padding: 5px;">Market</th>
                                    <th style="padding: 5px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Your table data here -->
                            </tbody>
                        </table> --}}

</div>
@include('leads.task-scheduler.taskscheduler-modal', [
    'leadId' => $leads->id,
    'userProfiles' => $userProfiles,
]);

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
                url: "{{ route('client-active-policy-list') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                }
            },
            columns: [{
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
        });

        $('#taskScheduleForm').on('submit', function(e) {
            var taskScheduleAction = $('#taskScheduleAction').val();
            var taskSchedulerUrl = taskScheduleAction == 'update' ?
                "{{ route('task-scheduler.update', ':id') }}".replace(':id', $('#taskScheduleId')
                    .val()) :
                "{{ route('task-scheduler.store') }}";
            e.preventDefault();
            var taskScheduleMethod = taskScheduleAction == 'update' ? 'PUT' : 'POST';
            $.ajax({
                url: taskSchedulerUrl,
                method: taskScheduleMethod,
                data: $('#taskScheduleForm').serialize(),
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Task has been scheduled',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#taskSchedulerModal').modal('hide');
                            getTaskList();
                        }
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Task has not been scheduled',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }
            });
        });

        // Helper function to format the dat
        function formatDate(dateString) {
            var options = {
                weekday: 'long',

                month: 'short',
                day: 'numeric'
            };
            var date = new Date(dateString);
            return date.toLocaleDateString('en-US', options);
        }

        // Helper function to determine due date color
        function getDueDateColor(dateString) {
            var currentDate = new Date();
            var taskDate = new Date(dateString);
            var timeDiff = taskDate - currentDate;
            var dayDiff = timeDiff / (1000 * 60 * 60 * 24); // Convert milliseconds to days

            if (dayDiff < 0) {
                // Overdue tasks (in the past)
                return 'bg-danger';
            } else if (dayDiff <= 7) {
                // Due soon (within the next 7 days)
                return 'bg-success';
            } else {
                // Tasks that are farther out
                return 'bg-info';
            }
        }

        // Function to get the appropriate color based on the task's status
        function getStatusColor(status) {
            switch (status.toLowerCase()) {
                case 'pending':
                case 'ongoing':
                    return 'bg-warning'; // Yellow for pending and ongoing
                case 'completed':
                    return 'bg-success'; // Green for completed
                default:
                    return 'bg-secondary'; // Default to grey if no status matches
            }
        }
        var assetUrl = "{{ asset('') }}";

        function getTaskList() {
            $.ajax({
                url: "{{ route('get-task-scheduler') }}", // Ensure this is your route for getting the tasks
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "_token": "{{ csrf_token() }}", // CSRF token for Laravel
                    leadId: {{ $leadId }} // Assuming $leadId is defined in the Blade template
                },
                success: function(response) {
                    // Assuming 'tasks' is the array of task objects returned in the response
                    var tasks = response.data;

                    console.log(tasks);

                    // Clear the existing task list
                    $('#task-list').empty();

                    // Loop through each task and create the HTML structure
                    // tasks.forEach(function(task) {
                    //     var taskItem = $('<div></div>')
                    //         .addClass(
                    //             'list-group-item d-flex justify-content-between align-items-center'
                    //         );

                    //     // Task content with checkbox and task name
                    //     var taskContent = $('<div></div>')
                    //         .addClass('d-flex align-items-center')
                    //         .append($('<input>')
                    //             .addClass('form-check-input me-2')
                    //             .attr('type', 'checkbox')
                    //             .attr('value', task.id)
                    //         ) // Assuming task ID is used in the checkbox value
                    //         .append($('<span></span>').text(task.description));

                    //     // Badge for the task due date
                    //     var taskDueDate = $('<span></span>')
                    //         .addClass('badge bg-info rounded-pill')
                    //         .text(task
                    //             .date_schedule
                    //         ); // Assuming 'due_date' is a readable date string

                    //     // Append task content and due date badge to the task item
                    //     taskItem.append(taskContent, taskDueDate);

                    //     // Append the task item to the task list
                    //     $('#task-list').append(taskItem);
                    // });

                    tasks.forEach(function(task) {
                        // Create the main task item div
                        var taskItem = $('<div></div>')
                            .addClass(
                                'list-group-item d-flex justify-content-between align-items-center'
                            );

                        // Task content with checkbox, task name, and assignee circle
                        var taskContent = $('<div></div>')
                            .addClass('d-flex align-items-center')
                            // Checkbox
                            .append($('<input>')
                                .addClass('form-check-input me-2 taskScheduler-box')
                                .attr('type', 'checkbox')
                                .attr('value', task.id)
                            )
                            // Assignee circle (representing user with initials or placeholder)
                            .append(
                                $('<img>')
                                .addClass('rounded-circle')
                                .css({
                                    width: '25px', // Small circle size
                                    height: '25px', // Small circle size
                                    marginRight: '10px',
                                    objectFit: 'cover' // Ensures the image fits properly inside the circle
                                })
                                .attr('src', task.assigned_to.media ?
                                    assetUrl + task.assigned_to.media.filepath :
                                    assetUrl +
                                    'path/to/default-avatar.jpg' // Fallback to default avatar
                                )
                            )
                            .append($('<span></span>').text(task.description));

                        // Color coding for the due date badge
                        var dueDateColor = getDueDateColor(task.date_schedule);

                        var taskDueDate = $('<span></span>')
                            .addClass('badge rounded-pill')
                            .addClass(dueDateColor) // Set color based on date
                            .text(formatDate(task
                                .date_schedule
                            )); // Use a helper function to format the date


                        // Add the task status with color coding
                        var statusColor = getStatusColor(task.status);
                        var taskStatus = $('<span></span>')
                            .addClass('badge rounded-pill me-2')
                            .addClass(statusColor) // Set the color of the status badge
                            .text(task
                                .status
                            ); // Display task status (Pending, Ongoing, Completed)

                        // Append task content and due date badge to the task item
                        taskItem.append(taskContent, taskStatus, taskDueDate);

                        // Append the task item to the task list
                        $('#task-list').append(taskItem);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred while fetching the task list: ", error);
                }
            });
        }

        getTaskList();
    });

    $(document).on('click', '.addTaskButton', function() {
        $('#taskSchedulerModal').modal('show');
    });

    $(document).on('click', '.taskScheduler-box', function(e) {
        e.preventDefault();
        var id = $(this).val();

        $.ajax({
            url: "{{ route('task-scheduler.edit', ':id') }}".replace(':id',
                id), // Fix the replacement for the ID
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success: function(response) {
                console.log(response);

                // Populate modal fields with the response data
                $('#taskAssignTo').val(response.data.assigned_to);
                $('#taskStatus').val(response.data.status);
                let taskDate = new Date(response.data.date_schedule); // Convert to a Date object
                let formattedDate = taskDate.toISOString().split('T')[0]; // Format to YYYY-MM-DD
                $('#taskDate').val(formattedDate);
                $('#taskSchedulerStatus').val(response.data.status);
                $('#taskDescription').val(response.data.description);
                $('#taskScheduleId').val(response.data.id);
                $('#taskScheduleAction').val('update');
                $('#taskSchedulerModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("An error occurred: ", error);
            }
        });
    });
</script>
