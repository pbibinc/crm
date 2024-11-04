<style>
    .row-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .title-card {
        background-color: #4E5D6C;
        /* Darker shade for a more modern look */
        padding: 8px 15px;
        border-radius: 4px;
        color: #ffffff;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        font-size: 16px;
        /* Slightly larger font size for headings */
    }

    .title-icon {
        font-size: 18px;
        /* Larger icons for better visibility */
        margin-right: 8px;
    }

    .data-section {
        padding: 5px 15px;
        /* Reduced padding for compactness */
        background-color: #F7F7F7;
        /* Light grey background for data sections */
        border-left: 5px solid #4E5D6C;
        /* Accent border matching title cards */
        margin-bottom: 10px;
    }

    .data-label {
        font-weight: bold;
        color: #333333;
        /* Darker text for better readability */
        display: block;
        /* Ensure label is on its own line */
    }

    .data-value {
        margin-left: 5px;
        font-size: 14px;
        /* Smaller font size for data values */
    }

    .inline-data {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .inline-data .col-md-6 {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .btn-sm {
        padding: 4px 8px;
        margin-top: 5px;
        margin-bottom: 5px;
    }

    hr {
        margin-top: 20px;
        margin-bottom: 20px;
        border-top: 1px solid #DDD;
        /* Lighter line for subtlety */
    }
</style>
@php
    $workersCompensationProduct = $generalInformation->lead->quoteLead->QuoteInformation->QuotationProduct->getQuotationProductByProduct(
        'Workers Compensation',
        $generalInformation->lead->quoteLead->QuoteInformation->id,
    );
@endphp
<div class="row-title">
    <div class="card-title d-flex align-items-center">
        <h5 class="mb-0 me-2">Workers Compensation Profile</h5>
        @if ($workersCompensationProduct->status == 5)
            <span class="badge bg-danger align-middle">Declined</span>
        @endif
    </div>
    <div>
        @if ($actionButtons == true)
            <button type="button" class="editWorkersCompensation btn btn-light btn-sm waves-effect waves-light"
                value="{{ $generalInformation->lead->id }}"><i class="ri-edit-line"></i>
                Edit</button>
        @endif
        @if ($workersCompensationProduct->status == 29)
            <button type="button"
                class="sendAppointedWorkersCompForQuotation btn btn-success btn-sm waves-effect waves-light"
                value="{{ $workersCompensationProduct->id }}">
                <i class="ri-task-line"></i> Send For Quotation</button>
        @elseif($workersCompensationProduct->status == 5)
            <button type="button"
                class="sendAppointedWorkersCompForQuotation btn btn-warning btn-sm waves-effect waves-light"
                value="{{ $workersCompensationProduct->id }}">Resend For Quotation</button>
        @endif
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="title-card">
            <i class="ri-user-2-line title-icon"></i>
            <span">Employee's Designations</span>
        </div>
        <div class="data-section">
            @foreach ($generalInformation->workersCompensation->classCodePerEmployee as $data)
                <div class="row">
                    <div class="col-6">
                        <span class="data-label">{{ $data->employee_description }}</span>
                    </div>
                    <div class="col-6">
                        <span class="data-value">
                            {{ $data->number_of_employee }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-6">
        <div class="title-card">
            <i class="ri-team-line title-icon"></i>
            <span">Workers Compensation Information</span>
        </div>
    </div>
    <div class="col-md-12">
        <div class="data-section">
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Fein Number:</span>
                    <span class="data-value">
                        {{ $generalInformation->workersCompensation->fein_number }}
                    </span>
                </div>
                <div class="col-6">
                    <span class="data-label">Social Service Number:</span>
                    <span class="data-value">
                        {{ $generalInformation->workersCompensation->ssin_number }}
                    </span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Owners Payroll Included:</span>
                    <span class="data-value">
                        {{ $generalInformation->workersCompensation->is_owners_payroll_included ? 'Yes' : 'No' }}
                    </span>
                </div>
                <div class="col-6">
                    <span class="data-label">Payroll Amount:</span>
                    <span class="data-value">
                        ${{ number_format($generalInformation->workersCompensation->payroll_amount, 2) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-6">
        <div class="title-card">
            <i class="ri-coupon-line title-icon"></i>
            <span">Workers Policy Amount</span>
        </div>
    </div>
    <div class="col-md-12">
        <div class="data-section">
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Workers Amount:</span>
                    <span class="data-value">
                        ${{ number_format($generalInformation->workersCompensation->workers_compensation_amount, 2) }}
                    </span>
                </div>
                <div class="col-6">
                    <span class="data-label">Policy Limit:</span>
                    <span class="data-value">
                        ${{ number_format($generalInformation->workersCompensation->policy_limit, 2) }}
                    </span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Each Accident:</span>
                    <span class="data-value">
                        ${{ number_format($generalInformation->workersCompensation->each_accident, 2) }}
                    </span>
                </div>
                <div class="col-6">
                    <span class="data-label">Each Employee:</span>
                    <span class="data-value">
                        ${{ number_format($generalInformation->workersCompensation->each_employee, 2) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-md-6">
        <div class="title-card">
            <i class="ri-calendar-event-line title-icon"></i>
            <span">Previous Workers Policy</span>
        </div>
    </div>
    <div class="col-md-12">

        <div class="data-section">
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Expiration of Workers Compensation:</span>
                    <span class="data-value">
                        {{ $generalInformation->workersCompensation->expiration }}
                    </span>
                </div>
                <div class="col-6">
                    <span class="data-label">Prior Carries:</span>
                    <span class="data-value">
                        {{ $generalInformation->workersCompensation->expiration }}
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>
<hr>

<script>
    $(document).ready(function() {
        $('.editWorkersCompensation').on('click', function() {
            var url = "{{ env('APP_FORM_URL') }}";
            var id = $(this).val();
            $.ajax({
                url: "{{ route('list-lead-id') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                method: "POST",
                data: {
                    leadId: id
                },
            });
            window.open(`${url}workers-compensation-form/edit`, "s_blank",
                "width=1000,height=849")
        });

        $('.sendAppointedWorkersCompForQuotation').on('click', function(e) {
            var id = $(this).val();
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to send this product for quotation',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('change-appointed-product-status') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        data: {
                            id: id,
                            status: 7
                        },
                        success: function(data) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Product Request For Quotation',
                                icon: 'success'
                            }).then((result) => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        });

    });
</script>
