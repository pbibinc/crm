@extends('admin.admin_master')@section('admin')
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
                        <div class="row">
                            <div class="col text-right">
                                <button class="btn btn-primary" id="editGeneralInformationButton">Edit</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="card-content">
                                    <div class="row d-flex text-center">
                                        <div>
                                            <h4>{{ $generalInformation->firstname . ' ' . $generalInformation->lastname }}
                                            </h4>
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


                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="row">
                    <div class="col-4">
                    </div>
                    <div class="col-4">
                        <div class="card"
                            style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 10px;">
                            <div class="card-body" style="text-align: center;">
                                <h6 style="margin-bottom: 10px;">Change Status:</h6>
                                <div class="form-group" style="margin-bottom: 10px;">
                                    {{ $product->status }}
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
                                        @if ($product->status == 8)
                                            <option value="8" @if ($product->status == 8) selected @endif>
                                                Issued</option>
                                        @endif
                                        @if ($product->status == 9)
                                            <option value="9" @if ($product->status == 9) selected @endif>
                                                Make A Payment</option>
                                        @endif
                                        @if ($product->status == 17 || $product->status == 10)
                                            <option value="17" @if ($product->status == 17) selected @endif>
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
                                            <option value="18" @if ($product->status == 18) selected @endif>
                                                Resend RTB</option>
                                        @endif
                                        @if ($product->status == 18)
                                            <option value="18" @if ($product->status == 18) selected @endif>
                                                Resend RTB</option>
                                        @endif
                                        @if ($product->status == 19)
                                            <option value="19" @if ($product->status == 19) selected @endif>
                                                Binding</option>
                                        @endif
                                        @if ($product->status == 20)
                                            <option value="20" @if ($product->status == 20) selected @endif>
                                                Bound</option>
                                        @endif
                                        @if ($product->status == 12)
                                            <option value="12" @if ($product->status == 12) selected @endif>
                                                Binding</option>
                                        @endif
                                    </select>
                                </div>
                                @if ($product->status !== 13 && $product->status !== 9)
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        style="padding: 6px 12px; font-size: 14px;"
                                        id="saveStatusButton">Submit</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-4"></div>
                </div>
                <div class="card"
                    style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist" style="margin-top: 0px">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#product" role="tab">
                                <span class="d-none d-sm-block d-flex align-items-center justify-content-center"><i
                                        class=" ri-shopping-cart-2-line"></i> Product</span>
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
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#emails" role="tab">
                                <span class="d-none d-sm-block"><i class="ri-mail-fill"></i> Emails</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#policyList" role="tab">
                                <span class="d-none d-sm-block"><i class="ri-mail-fill"></i> Policy List</span>
                            </a>
                        </li>
                    </ul>

                    <div class="card-body">
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane fade show active" id="product" role="tabpanel">
                                <div class="row">

                                    @if ($product->product == 'General Liability')
                                        {{-- <div class="tab-pane active" id="generalLiabilites" role="tabpanel"> --}}
                                        @include(
                                            'leads.appointed_leads.product-view.general-liability-profile',
                                            [
                                                'generalLiabilities' => $generalLiabilities,
                                                'actionButtons' => false,
                                            ]
                                        )
                                        {{-- </div> --}}
                                    @endif
                                    @if ($product->product == 'Workers Compensation')
                                        {{-- <div class="tab-pane" id="workersCompensation" role="tabpanel"> --}}
                                        @include(
                                            'leads.appointed_leads.product-view.workers-comp-profile',
                                            [
                                                'generalInformation' => $generalInformation,
                                                'actionButtons' => false,
                                            ]
                                        )
                                        {{-- </div> --}}
                                    @endif
                                    @if ($product->product == 'Commercial Auto')
                                        {{-- <div class="tab-pane" id="commercialAuto" role="tabpanel"> --}}
                                        @include(
                                            'leads.appointed_leads.product-view.commercial-auto-profile',
                                            [
                                                'generalInformation' => $generalInformation,
                                                'actionButtons' => false,
                                            ]
                                        )
                                        {{-- </div> --}}
                                    @endif
                                    @if ($product->product == 'Excess Liability')
                                        {{-- <div class="tab-pane" id="excessLiabiliy" role="tabpanel"> --}}
                                        @include(
                                            'leads.appointed_leads.product-view.excess-liability-profile',
                                            [
                                                'generalInformation' => $generalInformation,
                                                'actionButtons' => false,
                                            ]
                                        )
                                        {{-- </div> --}}
                                    @endif
                                    @if ($product->product == 'Tools Equipment')
                                        {{-- <div class="tab-pane" id="toolsEquipment" role="tabpanel"> --}}
                                        @include(
                                            'leads.appointed_leads.product-view.tools-equipment-profile',
                                            [
                                                'generalInformation' => $generalInformation,
                                                'actionButtons' => false,
                                            ]
                                        )
                                        {{-- </div> --}}
                                    @endif
                                    @if ($product->product == 'Builders Risk')
                                        {{-- <div class="tab-pane" id="buildersRisk" role="tabpanel"> --}}
                                        @include(
                                            'leads.appointed_leads.product-view.builders-risk-profile',
                                            [
                                                'generalInformation' => $generalInformation,
                                                'actionButtons' => false,
                                            ]
                                        )
                                        {{-- </div> --}}
                                    @endif
                                    @if ($product->product == 'Business Owners')
                                        {{-- <div class="tab-pane" id="bop" role="tabpanel"> --}}
                                        @include(
                                            'leads.appointed_leads.product-view.business-owners-profile',
                                            [
                                                'generalInformation' => $generalInformation,
                                                'actionButtons' => false,
                                            ]
                                        )
                                        {{-- </div> --}}
                                    @endif

                                </div>
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
                                @include('leads.appointed_leads.quoted-renewal-policy-form/forms', [
                                    'product' => $product,
                                    'generalInformation' => $generalInformation,
                                    'quationMarket' => $quationMarket,
                                    'complianceOfficer' => $complianceOfficer,
                                ])
                            </div>
                            <div class="tab-pane" id="emails" role="tabpanel">
                                @include('email.index', [
                                    'productId' => $product->id,
                                    'templates' => $templates,
                                ])
                            </div>
                            <div class="tab-pane" id="policyList" role="tabpanel">
                                @include('customer-service.policy.policy-lead-table-list', [
                                    'productId' => $product->id,
                                    'templates' => $templates,
                                    'leadId' => $lead->id,
                                    'carriers' => $carriers,
                                    'markets' => $markets,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('leads.appointed_leads.request-to-bind-form.renewal-request-to-bind-form', [
            'quoteProduct' => $lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
                $product->product,
                $lead->quoteLead->QuoteInformation->id),
        ])

    </div>
</div>


<script>
    $(document).ready(function() {
        $('.quotation-form').hide()
        var target = '#generalLiabilitiesQuoationForm';
        $(target).show();
        $('.navProfile').on('click', function() {
            $('.quotation-form').hide()
            target = $(this).attr('href');
            if (target == '#generalLiabilites') {
                $('#generalLiabilitiesQuoationForm').show();
            } else if (target == '#workersCompensation') {
                $('#workersCompensationForm').show();
            } else if (target == '#commercialAuto') {
                $('#commercialAutoForm').show();
            } else if (target == '#excessLiabiliy') {
                $('#excessLiabilityForm').show();
            } else if (target == '#toolsEquipment') {
                $('#toolsEquipmentForm').show();
            } else if (target == '#buildersRisk') {
                $('#buildersRiskForm').show();
            } else if (target == '#bop') {
                $('#businessOwnersPolicyForm').show();
            }
        });

        $('#editGeneralInformationButton').on('click', function() {
            var url = "{{ env('APP_FORM_URL') }}";
            var id = "{{ $lead->id }}";
            var productId = "{{ $product->id }}"
            $.ajax({
                url: "{{ route('list-lead-id') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                method: 'POST',
                data: {
                    leadId: id,
                    productId: productId,

                },
            });
            window.open(`${url}general-information-form/edit`, "s_blank",
                "width=1000,height=849");

        });

        $('#saveStatusButton').on('click', function() {
            var status = $('#statusSelect').val();
            if (status == 17) {
                $('#requestToBindModal').modal('show');
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

    });
</script>
@endsection
