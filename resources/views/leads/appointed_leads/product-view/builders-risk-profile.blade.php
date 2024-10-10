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
        <h5>Builders Risk Profile</h5>
    </div>
    @if ($actionButtons == true)
        <button type="button" class="editBuildersRisk btn btn-light btn-sm waves-effect waves-light"
            value="{{ $generalInformation->lead->id }}">
            <i class="ri-edit-line"></i> Edit
        </button>
    @endif
</div>

<div class="row">
    <div class="col-md-12">
        <div class="title-card">
            <i class="ri-community-line title-icon"></i>
            <span>Builders Risk Informations</span>
        </div>
        <div class="data-section">
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Property Address:</span>
                    <span class="data-value">{{ $generalInformation->buildersRisk->property_address }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Value of Structure:</span>
                    <span class="data-value">{{ $generalInformation->buildersRisk->value_of_structure }}</span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Value of Work:</span>
                    <span class="data-value">{{ $generalInformation->buildersRisk->value_of_work }}</span>
                </div>
                <div class="col-6">
                    @if ($generalInformation->buildersRisk->has_project_started)
                        <span class="data-label">Project Started::</span>
                        <span class="data-value">
                            {{ $generalInformation->buildersRisk->has_project_started ? 'Yes' : 'No' }}</span>
                    @else
                        <span class="data-label">Project Started:</span>
                        <span class="data-value">
                            {{ \Carbon\Carbon::parse($generalInformation->buildersRisk->project_started_date)->format('M-j-Y') }}</span>
                    @endif
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Construction Type:</span>
                    <span class="data-value">{{ $generalInformation->buildersRisk->construction_type }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Protection Class:</span>
                    <span class="data-value"> {{ $generalInformation->buildersRisk->protection_class }}</span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Square Footage:</span>
                    <span class="data-value">{{ $generalInformation->buildersRisk->square_footage }}m²</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Floor Number:</span>
                    <span class="data-value">{{ $generalInformation->buildersRisk->number_floors }}</span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Number of Dwelling:</span>
                    <span class="data-value"> {{ $generalInformation->buildersRisk->number_dwelling }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Security:</span>
                    <span class="data-value"> {{ $generalInformation->buildersRisk->jobsite_security }}</span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Distance to Fire Hydrant:</span>
                    <span class="data-value"> {{ $generalInformation->buildersRisk->firehydrant_distance }}km</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Distance to Fire Station:</span>
                    <span class="data-value"> {{ $generalInformation->buildersRisk->firestation_distance }}km</span>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

@if ($generalInformation->buildersRisk->construction_status == 2)
    <div class="row">
        <div class="col-md-12">
            <div class="title-card">
                <i class="ri-hammer-line title-icon"></i>
                <span>Rennovation</span>
            </div>
            <div class="data-section">
                <div class="inline-data">
                    <div class="col-6">
                        <span class="data-label">Last Year Roofing Update:</span>
                        <span class="data-value">
                            {{ $generalInformation->buildersRisk->renovation->last_update_roofing }}</span>
                    </div>
                    <div class="col-6">
                        <span class="data-label">Last Year Heating Update:</span>
                        <span class="data-value">
                            {{ $generalInformation->buildersRisk->renovation->last_update_heating }}</span>
                    </div>
                </div>
                <div class="inline-data">
                    <div class="col-6">
                        <span class="data-label">Last Year Plumbing Update:</span>
                        <span class="data-value">
                            {{ $generalInformation->buildersRisk->renovation->last_update_plumbing }}</span>
                    </div>
                    <div class="col-6">
                        <span class="data-label">Last Year Electrical Update:</span>
                        <span class="data-value">
                            {{ $generalInformation->buildersRisk->renovation->last_update_electrical }}</span>
                    </div>
                </div>
                <div class="inline-data">
                    <div class="col-6">
                        <span class="data-label">Last Year Plumbing Update:</span>
                        <span class="data-value">
                            {{ $generalInformation->buildersRisk->renovation->last_update_plumbing }}</span>
                    </div>
                    <div class="col-6">
                        <span class="data-label">Last Year Electrical Update:</span>
                        <span class="data-value">
                            {{ $generalInformation->buildersRisk->renovation->last_update_electrical }}</span>
                    </div>
                </div>
                <div class="inline-data">
                    <div class="col-6">
                        <span class="data-label">Last Year Plumbing Update:</span>
                        <span class="data-value">
                            {{ $generalInformation->buildersRisk->renovation->last_update_plumbing }}</span>
                    </div>
                    <div class="col-6">
                        <span class="data-label">Last Year Electrical Update:</span>
                        <span class="data-value">
                            {{ $generalInformation->buildersRisk->renovation->last_update_electrical }}</span>
                    </div>
                </div>
                <div class="inline-data">
                    <div class="col-6">
                        <span class="data-label">Structure Will be Occupied:</span>
                        <span class="data-value">
                            {{ $generalInformation->buildersRisk->renovation->stucture_occupied }}</span>
                    </div>
                    <div class="col-6">
                        <span class="data-label">Structure Built:</span>
                        <span class="data-value">
                            {{ $generalInformation->buildersRisk->renovation->structure_built }}</span>
                    </div>
                </div>
                <div class="inline-data">
                    <div class="col-6">
                        <span class="data-label">Structure Will be Occupied:</span>
                        <span class="data-value">
                            {{ $generalInformation->buildersRisk->renovation->description }}</span>
                    </div>
                    <div class="col-6">
                        <span class="data-label">Complete Operation Description</span>
                        <span class="data-value">
                            {{ $generalInformation->buildersRisk->renovation->description_operation }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-md-12">
            <div class="title-card">
                <i class="ri-hammer-line title-icon"></i>
                <span>New Construction Description</span>
            </div>
            <div class="data-section">
                {{ $generalInformation->buildersRisk->newConstruction->description_operation }}
            </div>
        </div>
    </div>
@endif
<hr>


@if ($generalInformation->lead->buildersRiskExpirationProduct)
    <div class="row">
        <div class="col-md-12">
            <div class="title-card">
                <i class="ri-calendar-event-line title-icon"></i>
                <span>Previous Builders Risk Policy</span>
            </div>
            <div class="data-section">
                <div class="inline-data">
                    <div class="col-6">
                        <span class="data-label">Expiration of Builders Risk:</span>
                        <span class="data-value">
                            {{ \Carbon\Carbon::parse($generalInformation->lead->buildersRiskExpirationProduct->expiration_date)->format('M-j-Y') }}</span>
                    </div>
                    <div class="col-6">
                        <span class="data-label">Prior Carrier:</span>
                        <span
                            class="data-value">{{ $generalInformation->lead->buildersRiskExpirationProduct->prior_carrier }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
    $(document).ready(function() {
        $('.editBuildersRisk').on('click', function(e) {
            e.preventDefault();
            var leadId = $(this).val();
            var url = "{{ env('APP_FORM_URL') }}";
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
            window.open(`${url}builders-risk-form/edit`, "s_blank",
                "width=1000,height=849")
        });
    });
</script>
