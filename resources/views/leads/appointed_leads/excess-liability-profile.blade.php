<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">Excess Liability Information</h4>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Excess Liability:</b>
                {{ $generalInformation->excessLiability->excess_limit}}
            </div>
            <div class="col-6">
                <b>Excess Effective Date:</b>
                {{ \Carbon\Carbon::parse($generalInformation->excessLiability->excess_date)->format('M-j-Y')  }}
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-4">
                <b>Insurance Carrier:</b>
                {{ $generalInformation->excessLiability->insurance_carrier}}
            </div>
            <div class="col-4">
                <b>Policy No:</b>
                {{  $generalInformation->excessLiability->policy_number }}
            </div>
            <div class="col-4">
                <b>Policy Premium:</b>
                {{  $generalInformation->excessLiability->policy_premium }}
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>General Libiality Effective Date:</b>
                {{ \Carbon\Carbon::parse($generalInformation->excessLiability->general_liability_effective_date)->format('M-j-Y') }}
            </div>
            <div class="col-6">
                <b>General Liability Expiration Date:</b>
                {{ \Carbon\Carbon::parse($generalInformation->excessLiability->general_liability_expiration_date)->format('M-j-Y')  }}
            </div>
        </div>
    </div>
</div>
