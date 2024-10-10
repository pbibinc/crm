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

    .inline-data .col-6 {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .inline-data .col-4 {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .vehicle-card {
        border: 1px solid #3C9BE1;
        background-color: #E3F2FD;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
    }

    .vehicle-title {
        color: #0D47A1;
        font-weight: bold;
    }

    .vehicle-info {
        margin-bottom: 10px;
    }

    .driver-card {
        border: 1px solid #42A5F5;
        background-color: #E3F2FD;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .driver-title {
        color: #1565C0;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .driver-info {
        margin-bottom: 10px;
        font-size: 14px;
    }

    .driver-info b {
        color: #333;
    }

    .driver-card .card-body {
        padding: 10px;
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
<div class="row-title">
    <div class="card-title">
        <h5>Excess Liability Profile</h5>
    </div>
    @if ($actionButtons == true)
        <button type="button" class="editExcessLiability btn btn-light btn-sm waves-effect waves-light"
            value="{{ $generalInformation->lead->id }}"><i class="ri-edit-line"></i> Edit</button>
    @endif

</div>
<div class="row">
    <div class="col-md-12">
        <div class="title-card">
            <i class="ri-shield-star-line title-icon"></i>
            <span>Excess Liability Information</span>
        </div>
        <div class="data-section">
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Insurance Carrier:</span>
                    <span class="data-value"> {{ $generalInformation->excessLiability->insurance_carrier }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Excess Effective Date:</span>
                    <span class="data-value">
                        {{ \Carbon\Carbon::parse($generalInformation->excessLiability->excess_date)->format('M-j-Y') }}</span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-4">
                    <span class="data-label">Excess Liability:</span>
                    <span class="data-value">{{ $generalInformation->excessLiability->excess_limit }}</span>
                </div>
                <div class="col-4">
                    <span class="data-label">Policy No:</span>
                    <span class="data-value">{{ $generalInformation->excessLiability->policy_number }}</span>
                </div>
                <div class="col-4">
                    <span class="data-label">Policy Premium:</span>
                    <span class="data-value"> {{ $generalInformation->excessLiability->policy_premium }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
{{-- <div class="row">
    <div class="col-md-12">
        <div class="title-card">
            <i class="ri-hammer-line title-icon"></i>
            <span>Previous General Liability</span>
        </div>
        <div class="data-section">
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">General Libiality Effective Date:</span>
                    <span class="data-value">
                        {{ \Carbon\Carbon::parse($generalInformation->excessLiability->general_liability_effective_date)->format('M-j-Y') }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">General Liability Expiration Date:</span>
                    <span class="data-value">
                        {{ \Carbon\Carbon::parse($generalInformation->excessLiability->general_liability_expiration_date)->format('M-j-Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<script>
    $(document).ready(function() {
        $('.editExcessLiability').on('click', function() {
            var url = "{{ env('APP_FORM_URL') }}";
            var leadId = $(this).val();
            $.ajax({
                url: "{{ route('list-lead-id') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                method: 'POST',
                data: {
                    leadId: leadId
                },
            });
            window.open(`${url}excess-liability-form/edit`, "s_blank",
                "width=1000,height=849")
        });
    });
</script>
