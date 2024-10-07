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
        <h5>General Liability Profile</h5>
    </div>
    @if ($actionButtons == true)
        <button type="button" class="editGeneralLiabilitiesButton btn btn-light btn-sm waves-effect waves-light"
            value="{{ $generalLiabilities->generalInformation->lead->id }}">
            <i class="ri-edit-line"></i> Edit
        </button>
    @endif
</div>


<div class="row">
    <div class="col-md-6">
        <div class="title-card">
            <i class="ri-hammer-line title-icon"></i>
            <span>Class Codes</span>
        </div>
        <div class="data-section">
            @foreach ($generalLiabilities->classCodes as $classCode)
                <div class="row">
                    <div class="col-6"><span class="data-label">{{ $classCode->classCodeLead->name }}</span></div>
                    <div class="col-6"><span class="data-value">{{ $classCode->percentage }}%</span></div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-md-6">
        <div class="title-card">
            <i class="ri-map-pin-line title-icon"></i>
            <span>Multiple State Work</span>
        </div>
        <div class="data-section">
            @foreach ($generalLiabilities->multiStates as $multiState)
                <div class="row">
                    <div class="col-6"><span class="data-label">{{ $multiState->state }}</span></div>
                    <div class="col-6"><span class="data-value">{{ $multiState->percentage }}%</span></div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-6">
        <div class="title-card">
            <i class="ri-briefcase-line title-icon"></i>
            <span>Business Description</span>
        </div>
        <div class="data-section">
            <p>{{ $generalLiabilities->business_description }}</p>
        </div>
    </div>

    <div class="col-md-6">
        <div class="title-card">
            <i class="ri-building-4-line title-icon"></i>
            <span>Recreational Facilities</span>
        </div>
        <div class="data-section">
            @foreach ($generalLiabilities->generalLiabilityFacilities as $facility)
                <button class="btn btn-info btn-sm">{{ $facility->recreationalFacilities->name }}</button>
            @endforeach
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-12">
        <div class="title-card">
            <i class="ri-hand-heart-line title-icon"></i>
            <span>Subcontract Information</span>
        </div>
        <div class="data-section">
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Blasting Operation:</span>
                    <span
                        class="data-value">{{ $generalLiabilities->subcontractor->blasting_operation ? 'Yes' : 'No' }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Hazardous Waste:</span>
                    <span
                        class="data-value">{{ $generalLiabilities->subcontractor->hazardous_waste ? 'Yes' : 'No' }}</span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">asbestos mold:</span>
                    <span
                        class="data-value">{{ $generalLiabilities->subcontractor->asbestos_mold ? 'Yes' : 'No' }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">above three stories height:</span>
                    <span
                        class="data-value">{{ $generalLiabilities->subcontractor->three_stories_height ? 'Yes' : 'No' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-12">
        <div class="title-card">
            <i class="ri-calendar-event-line title-icon"></i>
            <span>Previous General Liability</span>
        </div>
        <div class="data-section">
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Expiration of General Liability:</span>
                    <span class="data-value">{{ $generalLiabilities->expiration_of_general_liabilities }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Policy Premium:</span>
                    <span class="data-value">{{ $generalLiabilities->policy_premium }}</span>
                </div>
            </div>

        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-12">
        <div class="title-card">
            <i class="ri-price-tag-3-line title-icon"></i>
            <span> Coverage Limit</span>
        </div>
        <div class="data-section">
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Limit:</span>
                    <span class="data-value">{{ $generalLiabilities->coverageLimit->limit }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Medical:</span>
                    <span class="data-value">{{ $generalLiabilities->coverageLimit->medical }}</span>
                </div>
            </div>

            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Fire Damage:</span>
                    <span class="data-value">{{ $generalLiabilities->coverageLimit->fire_damage }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Deductible:</span>
                    <span class="data-value">{{ $generalLiabilities->coverageLimit->deductible }}</span>
                </div>
            </div>

        </div>
    </div>
</div>

<hr>

<!-- More sections as needed -->
<script>
    $(document).ready(function() {
        $('.editGeneralLiabilitiesButton').on('click', function(e) {
            var url = "{{ env('APP_FORM_URL') }}";
            var id = $(this).val();

            $.ajax({
                url: "{{ route('list-lead-id') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                method: 'POST',
                data: {
                    leadId: id
                },
            });
            window.open(`${url}general-liabilities-form/edit`, "s_blank",
                "width=1000,height=849");

        })
    })
</script>
