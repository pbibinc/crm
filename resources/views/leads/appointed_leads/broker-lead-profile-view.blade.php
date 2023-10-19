@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">

                    <div class="card bg-info"
                        style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <h5 style="color:white"><i class="mdi mdi-account-hard-hat me-2"></i>{{ $lead->company_name }}
                            </h5>
                        </div>
                    </div>
                    <div class="card"
                        style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <div class="row d-flex text-center">
                                <div>
                                    <h4>{{ $generalInformation->firstname . ' ' . $generalInformation->lastname }}</h4>
                                    {{ $generalInformation->job_position }}
                                </div>
                            </div>
                            <div class="row">
                                <hr>
                            </div>

                            <div class="row mb-3">
                                <h5>Contact Information</h5>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <strong>Email Address:</strong>
                                    <br>
                                    <strong>{{ $generalInformation->email_address }}</strong>
                                </div>
                                <div class="col-6">
                                    <strong>Tel Num:</strong>
                                    <br>
                                    <strong> {{ $lead->tel_num }}</strong>
                                </div>
                            </div>
                            <div class="row">
                                <strong>Alt Num:</strong>
                                <br>
                                <strong>{{ $generalInformation->alt_num ? $generalInformation->alt_num : $lead->tel_num }}</strong>
                            </div>

                            <div class="row">
                                <hr>
                            </div>
                            <div class="row mb-3">
                                <h5>Location Details</h5>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <strong>Location:</strong>
                                    <br>
                                    <strong>{{ $usAddress->city . ', ' . $usAddress->state }}</strong>
                                </div>

                                <div class="col-6">
                                    <strong>Local Time:</strong>
                                    <br>
                                    <strong>{{ $localTime->format('M-d-Y g:iA') }}</strong>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <strong>Address:</strong>
                                    <br>
                                    <strong>{{ $generalInformation->address }}</strong>
                                </div>
                            </div>
                            <div class="row">
                                <hr>
                            </div>
                            <div class="row mb-3">
                                <h5>Company Information</h5>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <strong>Full Time Employee:</strong>
                                    <br>
                                    <strong>{{ $generalInformation->full_time_employee }}</strong>
                                </div>
                                <div class="col-6">
                                    <strong>Part Time Employee:</strong>
                                    <br>
                                    <strong>{{ $generalInformation->part_time_employee }}</strong>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <strong>Owners Payroll:</strong>
                                    <br>
                                    <strong>${{ number_format($generalInformation->owners_payroll, 2, '.', ',') }}</strong>
                                </div>
                                <div class="col-6">
                                    <strong>Employee Payroll:</strong>
                                    <br>
                                    <strong>${{ number_format($generalInformation->employee_payroll, 2, '.', ',') }}</strong>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <strong>Gross Receipt:</strong>
                                    <br>
                                    <strong>${{ number_format($generalInformation->gross_receipt, 2, '.', ',') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-8">
                    <div class="row">
                        <div class="col-4">
                            @if ($product->status == 4)
                                <div class="card"
                                    style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 10px;"
                                    id="callbackDateTimeDate">
                                    <div class="card-body" style="text-align: center;">
                                        <h6 style="margin-bottom: 10px;">Callback Date Time:</h6>
                                        <input class="form-control" type="datetime-local"
                                            value="{{ old('callBackDateTime', $product->callback_date ?? $localTime) }}"
                                            id="callBackDateTime" style="margin-bottom: 10px;">
                                        <div class="text-center">
                                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                                style="padding: 6px 12px; font-size: 14px;"
                                                id="saveCallbackDate">Save</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-4">
                            <div class="card"
                                style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 10px;">
                                <div class="card-body" style="text-align: center;">
                                    <h6 style="margin-bottom: 10px;">Change Status:</h6>
                                    <div class="form-group" style="margin-bottom: 10px;">
                                        <select class="form-control select2-search-disable" id="statusSelect"
                                            style="border: 1px solid #ccc; border-radius: 4px; padding: 6px;">
                                            <option value="3" @if ($product->status == 3) selected @endif>Pending
                                            </option>
                                            <option value="4" @if ($product->status == 4) selected @endif>Follow
                                                Up</option>
                                            <option value="6" @if ($product->status == 6) selected @endif>
                                                Completed</option>
                                            <option value="5" @if ($product->status == 5) selected @endif>
                                                Declined</option>
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        style="padding: 6px 12px; font-size: 14px;" id="saveStatusButton">Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            @if ($product->status == 4)
                                <div class="card"
                                    style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 10px;">
                                    <div class="card-body" style="text-align: center;">
                                        <h6 style="margin-bottom: 10px;">Send a follow up email:</h6>
                                        <button type="button"
                                            class="btn btn-lg btn-primary waves-effect waves-light sendingFolowUpEmailButton ladda-button"
                                            id="sendFollowUpEmail" data-style="expand-right"> <i
                                                class=" ri-mail-send-line"></i> </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card"
                        style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <ul class="nav nav-tabs nav-justified nav-separated" role="tablist" style="margin-top: 0px">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#product" role="tab">
                                    <span class="d-none d-sm-block d-flex align-items-center justify-content-center">
                                        @if ($product->product == 'General Liabilities')
                                            <i class="ri-umbrella-fill"></i> General Liabilities
                                        @endif
                                        @if ($product->product == 'Workers Compensation')
                                            <i class="ri-admin-fill"></i> Workers Compensation
                                        @endif
                                        @if ($product->product == 'Commercial Auto')
                                            <i class="ri-car-fill"></i>Commercial Auto
                                        @endif
                                        @if ($product->product == 'Excess Liability')
                                            <i class=" ri-hand-coin-fill"></i> Excess Liability
                                        @endif
                                        @if ($product->product == 'Tools Equipment')
                                            <i class="ri-tools-fill"></i> Tools Equipment
                                        @endif
                                        @if ($product->product == 'Builders Risk')
                                            <i class="ri-building-fill"></i> Builders Risk
                                        @endif
                                        @if ($product->product == 'Business Owners')
                                            <i class="ri-suitcase-fill"></i> Business Owners
                                        @endif
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#activityLog" role="tab">
                                    <span class="d-none d-sm-block d-flex align-items-center justify-content-center"><i
                                            class=" ri-git-merge-line"></i> History Log</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab">
                                    <span class="d-none d-sm-block"><i class="ri-file-edit-line"></i> Notes</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#quotation" role="tab">
                                    <span class="d-none d-sm-block"><i class="fas fa-cog"></i> Quotation</span>
                                </a>
                            </li>
                        </ul>
                        <div class="card-body">
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane fade show active" id="product" role="tabpanel">

                                    @if ($product->product == 'General Liabilities')
                                        <div>
                                            @include(
                                                'leads.appointed_leads.product-view.general-liability-profile',
                                                ['generalLiabilities' => $generalLiabilities]
                                            )
                                        </div>
                                    @endif
                                    @if ($product->product == 'Workers Compensation')
                                        <div>
                                            @include(
                                                'leads.appointed_leads.product-view.workers-comp-profile',
                                                ['generalInformation' => $generalInformation]
                                            )
                                        </div>
                                    @endif
                                    @if ($product->product == 'Commercial Auto')
                                        <div>
                                            @include(
                                                'leads.appointed_leads.product-view.commercial-auto-profile',
                                                ['generalInformation' => $generalInformation]
                                            )
                                        </div>
                                    @endif
                                    @if ($product->product == 'Excess Liability')
                                        <div>
                                            @include(
                                                'leads.appointed_leads.product-view.excess-liability-profile',
                                                ['generalInformation' => $generalInformation]
                                            )
                                        </div>
                                    @endif
                                    @if ($product->product == 'Tools Equipment')
                                        <div>
                                            @include(
                                                'leads.appointed_leads.product-view.tools-equipment-profile',
                                                ['generalInformation' => $generalInformation]
                                            )
                                        </div>
                                    @endif
                                    @if ($product->product == 'Builders Risk')
                                        <div>
                                            @include(
                                                'leads.appointed_leads.product-view.builders-risk-profile',
                                                ['generalInformation' => $generalInformation]
                                            )
                                        </div>
                                    @endif
                                    @if ($product->product == 'Business Owners')
                                        <div>
                                            @include(
                                                'leads.appointed_leads.product-view.business-owners-profile',
                                                ['generalInformation' => $generalInformation]
                                            )
                                        </div>
                                    @endif

                                </div>
                                <div class="tab-pane" id="activityLog" role="tabpanel">
                                    @include('leads.appointed_leads.log-activity.activity-log', [
                                        'generalInformation' => $generalInformation,
                                    ])
                                </div>

                                <div class="tab-pane" id="messages" role="tabpanel">
                                    @include('leads.appointed_leads.log-activity.notes-log', [
                                        'generalInformation' => $generalInformation,
                                    ])
                                </div>
                                <div class="tab-pane" id="quotation" role="tabpanel">
                                    <div class="quotation-form" id="generalLiabilitiesQuoationForm" role="tabpanel">
                                        @if ($product->product == 'General Liabilities')
                                            @include(
                                                'leads.appointed_leads.broker-quotation-forms.quoation-form',
                                                [
                                                    'generalInformation' => $generalInformation,
                                                    'quationMarket' => $quationMarket,
                                                    'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
                                                        'General Liabilities',
                                                        $lead->quoteLead->QuoteInformation->id),
                                                ]
                                            )
                                        @endif
                                    </div>

                                    <div class="quotation-form" id="workersCompensationForm" role="tabpanel">
                                        @if ($product->product == 'Workers Compensation')
                                            @include(
                                                'leads.appointed_leads.broker-quotation-forms.workers-compensation-quoation-form',
                                                [
                                                    'generalInformation' => $generalInformation,
                                                    'quationMarket' => $quationMarket,
                                                    'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
                                                        'Workers Compensation',
                                                        $lead->quoteLead->QuoteInformation->id),
                                                ]
                                            )
                                        @endif
                                    </div>

                                    <div class="quotation-form" id="commercialAutoForm" role="tabpanel">
                                        @if ($product->product == 'Commercial Auto')
                                            @include(
                                                'leads.appointed_leads.broker-quotation-forms.commercial-auto-quoation-form',
                                                [
                                                    'generalInformation' => $generalInformation,
                                                    'quationMarket' => $quationMarket,
                                                    'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
                                                        'Commercial Auto',
                                                        $lead->quoteLead->QuoteInformation->id),
                                                ]
                                            )
                                        @endif
                                    </div>

                                    <div class="quotation-form" id="excessLiabilityForm" role="tabpanel">
                                        @if ($product->product == 'Excess Liability')
                                            @include(
                                                'leads.appointed_leads.broker-quotation-forms.excess-liability-quoation-form',
                                                [
                                                    'generalInformation' => $generalInformation,
                                                    'quationMarket' => $quationMarket,
                                                    'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
                                                        'Excess Liability',
                                                        $lead->quoteLead->QuoteInformation->id),
                                                ]
                                            )
                                        @endif
                                    </div>
                                    <div class="quotation-form" id="toolsEquipmentForm" role="tabpanel">
                                        @if ($product->product == 'Tools Equipment')
                                            @include(
                                                'leads.appointed_leads.broker-quotation-forms.tools-equipment-quoation-form',
                                                [
                                                    'generalInformation' => $generalInformation,
                                                    'quationMarket' => $quationMarket,
                                                    'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
                                                        'Tools Equipment',
                                                        $lead->quoteLead->QuoteInformation->id),
                                                ]
                                            )
                                        @endif
                                    </div>
                                    <div class="quotation-form" id="buildersRiskForm" role="tabpanel">
                                        @if ($product->product == 'Builders Risk')
                                            @include(
                                                'leads.appointed_leads.broker-quotation-forms.builders-risk-quoation-form',
                                                [
                                                    'generalInformation' => $generalInformation,
                                                    'quationMarket' => $quationMarket,
                                                    'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
                                                        'Builders Risk',
                                                        $lead->quoteLead->QuoteInformation->id),
                                                ]
                                            )
                                        @endif
                                    </div>
                                    <div class="quotation-form" id="businessOwnersPolicyForm" role="tabpanel">
                                        @if ($product->product == 'Business Owners')
                                            @include(
                                                'leads.appointed_leads.broker-quotation-forms.business-owners-quoation-form',
                                                [
                                                    'generalInformation' => $generalInformation,
                                                    'quationMarket' => $quationMarket,
                                                    'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
                                                        'Business Owners',
                                                        $lead->quoteLead->QuoteInformation->id),
                                                ]
                                            )
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            // var product ={!! json_encode($product->product) !!};
            // if(product == 'General Liabilties'){
            //     $('#brokerGeneralLiabilites').show();
            // }else if(product == 'Workers Compensation'){
            //     $('#brokerWorkersCompensation').show();
            // }else if(product == 'Commercial Auto'){
            //     $('#brokerCommercialAuto').show();
            // }else if(product == 'Tools Equipment'){
            //     $('#brokerToolsEquipment').show();
            // }else if(product == 'Excess Liability'){
            //     $('#brokerExcessLiabiliy').show();
            // }else if(product == 'Builders Risk'){
            //     $('#brokerBuildersRisk').show();
            // }else if(product == 'Business Owners'){
            //     $('#brokerBop').show();
            // }

            $('#saveStatusButton').on('click', function() {
                var status = $('#statusSelect').val();

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
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                $.ajax({
                    url: "{{ route('set-callback-date') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
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
