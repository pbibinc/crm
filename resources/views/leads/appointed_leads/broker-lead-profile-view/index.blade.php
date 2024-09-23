@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">

            @include('leads.appointed_leads.request-to-bind-form.index', [
                'quoteProduct' => $leads->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
                    $product->product,
                    $leads->quoteLead->QuoteInformation->id),
            ])


            <div class="modal fade" id="resendRTBModal" tabindex="-1" aria-labelledby="addQuoteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="fileViewingModalTitle">File Upload</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" class="dropzone mt-4 border-dashed" id="resendRTBDropzone"
                                enctype="multipart/form-data">
                            </form>
                            <input type="hidden" id="mediaIds" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="changeStatusButton" class="btn btn-success">Resend</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div>
                    @include(
                        'leads.appointed_leads.broker-lead-profile-view.header-profile-section',
                        compact('leads', 'localTime', 'product'))
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3">

                    <div class="card"
                        style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 8px;">
                        <div class="card-body" style="text-align: center;">
                            <h6 style="margin-bottom: 10px;">Change Status:</h6>
                            <div class="form-group" style="margin-bottom: 10px;">
                                <select class="form-control select2-search-disable" id="statusSelect"
                                    style="border: 1px solid #ccc; border-radius: 4px; padding: 6px;">
                                    @if ($product->status == 3 || $product->status == 4 || $product->status == 5)
                                        <option value="3" @if ($product->status == 3) selected @endif>
                                            Pending
                                        </option>
                                        <option value="4" @if ($product->status == 4) selected @endif>
                                            Follow
                                            Up</option>
                                        <option value="5" @if ($product->status == 5) selected @endif>
                                            Declined</option>
                                    @endif
                                    @if ($product->status == 11)
                                        <option value="11" @if ($product->status == 11) selected @endif>
                                            Bound</option>
                                    @endif
                                    @if ($product->status == 9)
                                        <option value="9" @if ($product->status == 9) selected @endif>
                                            Make A Payment</option>
                                    @endif
                                    @if ($product->status == 10 || $product->status == 6)
                                        <option value="6" @if ($product->status == 6) selected @endif>
                                            Request To Bind</option>
                                        <option value="10" @if ($product->status == 10) selected @endif>
                                            Payment Approved</option>
                                    @endif
                                    @if ($product->status == 13)
                                        <option value="13" @if ($product->status == 13) selected @endif>
                                            Payment Declined</option>
                                    @endif
                                    @if ($product->status == 14)
                                        <option value="14" @if ($product->status == 14) selected @endif>
                                            Binding Declined</option>
                                        <option value="15" @if ($product->status == 15) selected @endif>
                                            Resend RTB</option>
                                    @endif
                                    @if ($product->status == 15)
                                        <option value="15" @if ($product->status == 15) selected @endif>
                                            Resend RTB</option>
                                    @endif
                                    @if ($product->status == 22)
                                        <option value="22" @if ($product->status == 22) selected @endif>
                                            Pending</option>
                                    @endif
                                    @if ($product->status == 12)
                                        <option value="22" @if ($product->status == 12) selected @endif>
                                            Binding</option>
                                    @endif
                                </select>
                            </div>
                            @if (
                                $product->status == 14 ||
                                    $product->status == 10 ||
                                    $product->status == 6 ||
                                    $product->status == 15 ||
                                    $product->status == 3 ||
                                    $product->status == 4 ||
                                    $product->status == 5)
                                <button type="button" class="btn btn-success waves-effect waves-light"
                                    style="padding: 6px 12px; font-size: 14px;" id="saveStatusButton">Submit</button>
                            @endif
                        </div>
                    </div>
                    @if ($product->status == 4)
                        <div class="card"
                            style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 8px;">
                            <div class="card-body" style="text-align: center;">
                                <h6 style="margin-bottom: 10px;">Callback Date:</h6>
                                <div class="form-group" style="margin-bottom: 10px;">
                                    <input type="datetime-local" class="form-control mb-2" id="callBackDateTime">
                                    <input type="hidden" name="" id="callBackId">
                                    <button class="btn btn-success waves-effect waves-light"
                                        id="saveCallbackDate">Submit</button>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="card"
                        style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <div class="row mb-2">
                                <h6 style="font-size: 14px;">Contact Information</h6>
                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <strong style="font-size: 12px;">Email Address:</strong>
                                    <br>
                                    <strong
                                        style="font-size: 12px;">{{ $leads->GeneralInformation->email_address }}</strong>
                                </div>
                                <div class="col-6">
                                    <strong style="font-size: 12px;">Tel Num:</strong>
                                    <br>
                                    <strong style="font-size: 12px;">{{ $leads->tel_num }}</strong>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <strong style="font-size: 12px;">Alt Num:</strong>
                                <br>
                                <strong
                                    style="font-size: 12px;">{{ $leads->GeneralInformation->alt_num ? $leads->GeneralInformation->alt_num : $leads->tel_num }}</strong>
                            </div>

                            <div class="row">
                                <hr style="margin: 5px 0;">
                            </div>
                            <div class="row mb-2">
                                <h6 style="font-size: 14px;">Location Details</h6>
                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <strong style="font-size: 12px;">Location:</strong>
                                    <br>
                                    <strong
                                        style="font-size: 12px;">{{ $usAddress->city . ', ' . $usAddress->state }}</strong>
                                </div>

                                <div class="col-6">
                                    <strong style="font-size: 12px;">Local Time:</strong>
                                    <br>
                                    <strong style="font-size: 12px;">{{ $localTime->format('M-d-Y g:iA') }}</strong>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <strong style="font-size: 12px;">Address:</strong>
                                    <br>
                                    <strong style="font-size: 12px;">{{ $leads->GeneralInformation->address }}</strong>
                                </div>
                            </div>
                            <div class="row">
                                <hr style="margin: 5px 0;">
                            </div>
                            <div class="row mb-2">
                                <h6 style="font-size: 14px;">Company Information</h6>
                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <strong style="font-size: 12px;">Full Time Employee:</strong>
                                    <br>
                                    <strong
                                        style="font-size: 12px;">{{ $leads->GeneralInformation->full_time_employee }}</strong>
                                </div>
                                <div class="col-6">
                                    <strong style="font-size: 12px;">Part Time Employee:</strong>
                                    <br>
                                    <strong
                                        style="font-size: 12px;">{{ $leads->GeneralInformation->part_time_employee }}</strong>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <strong style="font-size: 12px;">Owners Payroll:</strong>
                                    <br>
                                    <strong
                                        style="font-size: 12px;">${{ number_format($leads->GeneralInformation->owners_payroll, 2, '.', ',') }}</strong>
                                </div>
                                <div class="col-6">
                                    <strong style="font-size: 12px;">Employee Payroll:</strong>
                                    <br>
                                    <strong
                                        style="font-size: 12px;">${{ number_format($leads->GeneralInformation->employee_payroll, 2, '.', ',') }}</strong>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <strong style="font-size: 12px;">Gross Receipt:</strong>
                                    <br>
                                    <strong
                                        style="font-size: 12px;">${{ number_format($leads->GeneralInformation->gross_receipt, 2, '.', ',') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-sm-9">

                    <div class="tab-content text-muted">
                        <div class="tab-pane fade show active" id="summary" role="tabpanel">
                            @include('leads.appointed_leads.apptaker-leads-view.profile-summary', [
                                'leads' => $leads,
                                'leadId' => $leads->id,
                                'carriers' => $carriers,
                                'markets' => $markets,
                                'templates' => $templates,
                            ])
                        </div>

                        <div class="tab-pane fade show" id="product" role="tabpanel">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    <ul class="nav nav-pills nav-justified" role="tablistProduct">
                                        @foreach ($products as $key => $productKey)
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link navProfile {{ $key === 0 ? 'active' : '' }}"
                                                    data-bs-toggle="tab"
                                                    href="#{{ str_replace(' ', '', $productKey->product) }}"
                                                    role="tab"
                                                    id="{{ str_replace(' ', '', $productKey->product) }}Button"
                                                    style="white-space: nowrap;">
                                                    {{ $productKey->product }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content p-3 text-muted">
                                        @foreach ($products as $key => $productKey)
                                            <div class="tab-pane fade show  {{ $key === 0 ? 'show active' : '' }}"
                                                id="{{ str_replace(' ', '', $productKey->product) }}" role="tabpanel">
                                                @includeWhen(
                                                    $productKey->product == 'General Liability',
                                                    'leads.appointed_leads.product-view.general-liability-profile',
                                                    [
                                                        'generalLiabilities' =>
                                                            $leads->generalInformation->generalLiabilities,
                                                        'actionButtons' => true,
                                                    ]
                                                )
                                                @includeWhen(
                                                    $productKey->product == 'Workers Compensation',
                                                    'leads.appointed_leads.product-view.workers-comp-profile',
                                                    [
                                                        'generalInformation' => $leads->generalInformation,
                                                        'actionButtons' => true,
                                                    ]
                                                )
                                                @includeWhen(
                                                    $productKey->product == 'Commercial Auto',
                                                    'leads.appointed_leads.product-view.commercial-auto-profile',
                                                    [
                                                        'generalInformation' => $leads->generalInformation,
                                                        'actionButtons' => true,
                                                    ]
                                                )
                                                @includeWhen(
                                                    $productKey->product == 'Excess Liability',
                                                    'leads.appointed_leads.product-view.excess-liability-profile',
                                                    [
                                                        'generalInformation' => $leads->generalInformation,
                                                        'actionButtons' => true,
                                                    ]
                                                )
                                                @includeWhen(
                                                    $productKey->product == 'Tools Equipment',
                                                    'leads.appointed_leads.product-view.tools-equipment-profile',
                                                    [
                                                        'generalInformation' => $leads->generalInformation,
                                                        'actionButtons' => true,
                                                    ]
                                                )
                                                @includeWhen(
                                                    $productKey->product == 'Builders Risk',
                                                    'leads.appointed_leads.product-view.builders-risk-profile',
                                                    [
                                                        'generalInformation' => $leads->generalInformation,
                                                        'actionButtons' => true,
                                                    ]
                                                )
                                                @includeWhen(
                                                    $productKey->product == 'Business Owners',
                                                    'leads.appointed_leads.product-view.business-owners-profile',
                                                    [
                                                        'generalInformation' => $leads->generalInformation,
                                                        'actionButtons' => true,
                                                    ]
                                                )
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="activityLog" role="tabpanel">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    @include('leads.appointed_leads.log-activity.activity-log', [
                                        'generalInformation' => $leads->generalInformation,
                                    ])
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="messages" role="tabpanel">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    @include('leads.appointed_leads.log-activity.notes-log', [
                                        'generalInformation' => $leads->generalInformation,
                                    ])
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="quotation" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    @include(
                                        'leads.appointed_leads.broker-quotation-forms.quoation-form',
                                        [
                                            'generalInformation' => $generalInformation,
                                            'quationMarket' => $quationMarket,
                                            'quoteProduct' => $leads->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
                                                $product->product,
                                                $leads->quoteLead->QuoteInformation->id),
                                            'complianceOfficer' => $complianceOfficer,
                                        ]
                                    )
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="accounting" role="tabpanel">

                            <div class="row mb-2">
                                <div class="card"
                                    style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                    <div class="card-body">
                                        @include(
                                            'leads.appointed_leads.accounting-tab.appointed-accounting-tab',
                                            [
                                                'generalInformation' => $leads->generalInformation,
                                                'selectedQuotes' => $selectedQuotes,
                                                'complianceOfficer' => $complianceOfficer,
                                                'policyDetailId' => null,
                                            ]
                                        )
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="card"
                                    style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                    <div class="card-body">
                                        @include(
                                            'customer-service.financing.finance-agreement.financing-table',
                                            [
                                                'leadId' => $leads->id,
                                            ]
                                        )
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="tab-pane fade show" id="financingAgreement" role="tabpanel">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    @include(
                                        'customer-service.financing.finance-agreement.financing-table',
                                        [
                                            'leadId' => $leads->id,
                                        ]
                                    )
                                </div>
                            </div>
                        </div> --}}

                        <div class="tab-pane fade show" id="bindingDocs" role="tabpanel">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    @include('customer-service.binding-docs-pfa.index', [
                                        'generalInformation' => $generalInformation,
                                        'product' => $product,
                                        'leadId' => $generalInformation->lead->id,
                                    ])
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="emails" role="tabpanel">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    @include('email.client-emails-table', [
                                        'leadId' => $leads->id,
                                    ])
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="policyList" role="tabpanel">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                <div class="card-body">
                                    @include('customer-service.policy.policy-lead-table-list', [
                                        'leadId' => $leads->id,
                                        'carriers' => $carriers,
                                        'markets' => $markets,
                                        'templates' => $templates,
                                    ])
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('leads.appointed_leads.broker-forms.make-payment-form', compact('complianceOfficer')) --}}
    <script>
        $(document).ready(function() {

            Dropzone.autoDiscover = false;

            var myDropzone;
            var dropzoneElement = document.querySelector("#resendRTBDropzone");

            if (dropzoneElement) {
                myDropzone = new Dropzone("#resendRTBDropzone", {
                    url: "{{ route('upload-file-binding-docs') }}",
                    method: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    autoProcessQueue: true,
                    clickable: true,
                    addRemoveLinks: true,
                    maxFiles: 10,
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
                                        var downloadLink = document
                                            .createElement("a");
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
                            formData.append('hiddenId', {!! json_encode($product->id) !!})
                        });
                        this.on('removedfile', function(file) {
                            $.ajax({
                                url: "{{ route('delete-binding-docs') }}",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr(
                                            'content')
                                },
                                method: "POST",
                                data: {
                                    id: file.id
                                },
                                success: function() {
                                    // Optional: Handle success
                                },
                                error: function() {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Something went wrong',
                                        icon: 'error'
                                    });
                                }
                            });
                        });
                    }
                });
            } else {
                console.error("Dropzone element not found");
            }

            function addExistingFiles(files) {
                files.forEach(file => {
                    var mockFile = {
                        id: file.id,
                        name: file.basename,
                        size: parseInt(file.size),
                        type: file.type,
                        status: Dropzone.ADDED,
                        url: file.filepath // URL to the file's location
                    };
                    myDropzone.emit("addedfile", mockFile);
                    // myDropzone.emit("thumbnail", mockFile, file.filepath); // If you have thumbnails
                    myDropzone.emit("complete", mockFile);
                });
            };

            $('#fileViewingModal').on('hide.bs.modal', function() {
                $(".dropzone .dz-preview").remove(); // This removes file previews from the DOM
                myDropzone.files.length = 0;
            });

            $('#saveStatusButton').on('click', function() {
                var status = $('#statusSelect').val();

                if (status == 6) {
                    $('#requestToBindModal').modal('show');
                } else if (status == 15) {
                    $.ajax({
                        url: "{{ route('get-binding-docs') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: "POST",
                        data: {
                            id: {!! json_encode($product->id) !!}
                        },
                        success: function(data) {
                            addExistingFiles(data);
                            $('#resendRTBModal').modal('show');
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error',
                                text: 'Something went wrong',
                                icon: 'error'
                            });
                        }

                    })
                } else {
                    $.ajax({
                        url: "{{ route('change-quotation-status') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: "POST",
                        data: {
                            status: status,
                            id: {!! json_encode($product->id) !!}
                        },
                        success: function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'has been saved',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
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
                }
            });

            $('#sendFollowUpEmail').on('click', function() {
                var id = {!! json_encode($product->id) !!};
                var button = $('.ladda-button');
                var laddaButton = Ladda.create(button[0]);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to send the quotation email?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, send it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        laddaButton.start();
                        $.ajax({
                            url: "{{ route('send-follow-up-email') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            method: "POST",
                            data: {
                                id: id
                            },
                            success: function() {
                                laddaButton.stop();

                                Swal.fire({
                                    title: 'Success',
                                    text: 'Email has been sent',
                                    icon: 'success'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
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
                    }

                });

            });

            $('#saveCallbackDate').on('click', function() {
                var callbackDateTime = $('#callBackDateTime').val();
                var callBackId = $('#callBackId').val();
                var callBackUrl = callBackId ? `/quoatation/quotation-callback/${callBackId}` :
                    "{{ route('quotation-callback.store') }}";
                var method = callBackId ? 'PUT' : 'POST';
                $.ajax({
                    url: callBackUrl,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: method,
                    data: {
                        callbackDateTime: callbackDateTime,
                        id: {!! json_encode($product->id) !!}
                    },
                    success: function() {
                        Swal.fire({
                            title: 'Success',
                            text: 'Callback Date has been saved',
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // location.reload();
                            }
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Something went wrong',
                            icon: 'error'
                        });
                    }
                });

            });

            var id = {!! json_encode($product->id) !!};
            var url = `/quoatation/quotation-callback/${id}/edit`;
            $.ajax({
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "GET",
                data: {
                    id: {!! json_encode($product->id) !!}
                },
                success: function(response) {
                    $('#callBackId').val(response.quotationCallback.id);
                    $('#callBackDateTime').val(response.quotationCallback.date_time);
                },
                error: function(response) {
                    console.log(response);
                }
            });

            $('#changeStatusButton').on('click', function() {
                $.ajax({
                    url: "{{ route('resend-rtb') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data: {
                        id: {!! json_encode($product->id) !!},
                        status: 15,
                    },
                    success: function() {
                        Swal.fire({
                            title: 'Success',
                            text: 'has been saved',
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
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
            });

        });
    </script>
@endsection
