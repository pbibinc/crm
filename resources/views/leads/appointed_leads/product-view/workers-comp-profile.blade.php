<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <h4 class="card-title">Employee's Designations</h4>
                </div>
                @foreach ($generalInformation->workersCompensation->classCodePerEmployee as $data)
                <div class="row mb-4">
                    <div class="col-6">
                        <b>{{ $data->employee_description }}</b>
                    </div>
                    <div class="col-6">
                        {{ $data->number_of_employee }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <h4 class="card-title">Specific Employee Description</h4>
                </div>
                <div class="row mb-4">
                    <div class="">
                        {{ $generalInformation->workersCompensation->specific_employee_description }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">Workers Compensation Information</h4>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Fein Number:</b>
                {{ $generalInformation->workersCompensation->fein_number}}
            </div>
            <div class="col-6">
                <b>Social Service Number:</b>
                {{ $generalInformation->workersCompensation->ssin_number}}
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Owners Payroll Included:</b>
                {{ $generalInformation->workersCompensation->is_owners_payroll_included ? 'Yes' : 'No'}}
            </div>
            <div class="col-6">
                <b>Payroll Amount:</b>
                ${{ number_format($generalInformation->workersCompensation->payroll_amount, 2)}}
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">Workers Policy Amount</h4>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Workers Amount:</b>
                ${{ number_format($generalInformation->workersCompensation->workers_compensation_amount, 2)}}
            </div>
            <div class="col-6">
                <b>Policy Limit:</b>
                ${{ number_format($generalInformation->workersCompensation->policy_limit, 2)}}
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Each Accident:</b>
                ${{ number_format($generalInformation->workersCompensation->each_accident, 2)}}
            </div>
            <div class="col-6">
                <b>Each Employee:</b>
                ${{ number_format($generalInformation->workersCompensation->each_employee, 2)}}
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">Previous Workers Policy</h4>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Expiration of Workers Compensation:</b>
                {{ $generalInformation->workersCompensation->expiration}}
            </div>
            <div class="col-6">
                <b>Prior Carries:</b>
                {{ $generalInformation->workersCompensation->expiration}}
            </div>
        </div>
    </div>
</div>
