<style>
    .title-card {
        background-color: #656565;
        /* Bootstrap primary color */
        padding: 10px 15px;
        border-radius: 5px;
        color: #ffffff;
        ;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }

    .title-icon {
        margin-right: 10px;
    }
</style>
@if ($actionButtons == true)
    <div class="row">
        <div class="row mb-4">
            <div class="col-md-6">
                <button type="button" class="editWorkersCompensation btn btn-primary"
                    value="{{ $generalInformation->lead->id }}"><i class="ri-edit-line"></i>
                    Edit</button>
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-6">

        <div class="row">
            <div class="col-10 title-card">
                <i class=" ri-user-2-line title-icon"></i> <!-- An example icon; adjust as necessary -->
                <h4 class="card-title mb-0" style="color: #ffffff">Employee's Designations</h4>
                <!-- mb-0 removes default margin at the bottom -->
            </div>

        </div>
        @foreach ($generalInformation->workersCompensation->classCodePerEmployee as $data)
            <div class="row">
                <div class="col-6">
                    <b>{{ $data->employee_description }}</b>
                </div>
                <div class="col-6">
                    {{ $data->number_of_employee }}
                </div>
            </div>
        @endforeach
    </div>

    <div class="col-6">
        <div class="row">
            <div class="col-10 title-card">
                <i class="ri-pencil-line title-icon"></i> <!-- An example icon; adjust as necessary -->
                <h4 class="card-title mb-0" style="color: #ffffff">Specific Employee Description</h4>
                <!-- mb-0 removes default margin at the bottom -->
            </div>
        </div>
        <div class="row mb-4">
            <div class="">
                {{ $generalInformation->workersCompensation->specific_employee_description }}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <hr>
</div>

<div class="row">
    <div class="col-5 title-card">
        <i class="ri-team-line title-icon"></i> <!-- An example icon; adjust as necessary -->
        <h4 class="card-title mb-0" style="color: #ffffff">Workers Compensation Information</h4>
        <!-- mb-0 removes default margin at the bottom -->
    </div>
</div>
<div class="row mb-2">
    <div class="col-6">
        <b>Fein Number:</b>
        {{ $generalInformation->workersCompensation->fein_number }}
    </div>
    <div class="col-6">
        <b>Social Service Number:</b>
        {{ $generalInformation->workersCompensation->ssin_number }}
    </div>
</div>
<div class="row mb-4">
    <div class="col-6">
        <b>Owners Payroll Included:</b>
        {{ $generalInformation->workersCompensation->is_owners_payroll_included ? 'Yes' : 'No' }}
    </div>
    <div class="col-6">
        <b>Payroll Amount:</b>
        ${{ number_format($generalInformation->workersCompensation->payroll_amount, 2) }}
    </div>
</div>
<div class="row">
    <hr>
</div>


<div class="row">
    <div class="col-5 title-card">
        <i class="ri-coupon-line title-icon"></i> <!-- An example icon; adjust as necessary -->
        <h4 class="card-title mb-0" style="color: #ffffff">Workers Policy Amount</h4>
        <!-- mb-0 removes default margin at the bottom -->
    </div>
</div>
<div class="row mb-2">
    <div class="col-6">
        <b>Workers Amount:</b>
        ${{ number_format($generalInformation->workersCompensation->workers_compensation_amount, 2) }}
    </div>
    <div class="col-6">
        <b>Policy Limit:</b>
        ${{ number_format($generalInformation->workersCompensation->policy_limit, 2) }}
    </div>
</div>
<div class="row mb-4">
    <div class="col-6">
        <b>Each Accident:</b>
        ${{ number_format($generalInformation->workersCompensation->each_accident, 2) }}
    </div>
    <div class="col-6">
        <b>Each Employee:</b>
        ${{ number_format($generalInformation->workersCompensation->each_employee, 2) }}
    </div>
</div>

<div class="row">
    <hr>
</div>

<div class="row">
    <div class="col-5 title-card">
        <i class="ri-calendar-event-line title-icon"></i> <!-- An example icon; adjust as necessary -->
        <h4 class="card-title mb-0" style="color: #ffffff">Previous Workers Policy</h4>
        <!-- mb-0 removes default margin at the bottom -->
    </div>
</div>
<div class="row mb-4">
    <div class="col-6">
        <b>Expiration of Workers Compensation:</b>
        {{ $generalInformation->workersCompensation->expiration }}
    </div>
    <div class="col-6">
        <b>Prior Carries:</b>
        {{ $generalInformation->workersCompensation->expiration }}
    </div>
</div>


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
    });
</script>
