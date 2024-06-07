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
    <div class="row mb-4">
        <div class="col-md-6">
            <button type="button" class="editExcessLiability btn btn-primary"
                value="{{ $generalInformation->lead->id }}"><i class="ri-edit-line"></i>
                Edit</button>
        </div>
    </div>
@endif
<div class="row mb-4">
    <div class="col-5 title-card">
        <i class="ri-shield-star-line title-icon"></i>
        <h4 class="card-title mb-0" style="color: #ffffff">Excess Liability Information</h4>
    </div>
</div>
<div class="row mb-4">
    <div class="col-6">
        <b>Excess Liability:</b>
        {{ $generalInformation->excessLiability->excess_limit }}
    </div>
    <div class="col-6">
        <b>Excess Effective Date:</b>
        {{ \Carbon\Carbon::parse($generalInformation->excessLiability->excess_date)->format('M-j-Y') }}
    </div>
</div>
<div class="row mb-4">
    <div class="col-4">
        <b>Insurance Carrier:</b>
        {{ $generalInformation->excessLiability->insurance_carrier }}
    </div>
    <div class="col-4">
        <b>Policy No:</b>
        {{ $generalInformation->excessLiability->policy_number }}
    </div>
    <div class="col-4">
        <b>Policy Premium:</b>
        {{ $generalInformation->excessLiability->policy_premium }}
    </div>
</div>
<div class="row mb-4">
    <div class="col-6">
        <b>General Libiality Effective Date:</b>
        {{ \Carbon\Carbon::parse($generalInformation->excessLiability->general_liability_effective_date)->format('M-j-Y') }}
    </div>
    <div class="col-6">
        <b>General Liability Expiration Date:</b>
        {{ \Carbon\Carbon::parse($generalInformation->excessLiability->general_liability_expiration_date)->format('M-j-Y') }}
    </div>
</div>
