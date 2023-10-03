<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">Builders Risk Information</h4>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Property Address:</b>
                {{ $generalInformation->buildersRisk->property_address }}
            </div>
            <div class="col-6">
                <div class="col-6">
                    <b>Value of Structure:</b>
                    {{ $generalInformation->buildersRisk->value_of_structure }}
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Value of Work:</b>
                {{ $generalInformation->buildersRisk->value_of_work }}
            </div>
            <div class="col-6">
                @if ($generalInformation->buildersRisk->has_project_started)
                <b>Project Started:</b>
                {{ $generalInformation->buildersRisk->has_project_started ? 'Yes' : 'No' }}
                @else
                <b>Project Started at:</b>
                {{ \Carbon\Carbon::parse($generalInformation->buildersRisk->project_started_date)->format('M-j-Y') }}
                @endif
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Construction Type:</b>
                {{ $generalInformation->buildersRisk->construction_type }}
            </div>
            <div class="col-6">
                <div class="col-6">
                    <b>Protection Class:</b>
                    {{ $generalInformation->buildersRisk->protection_class }}
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Square Footage</b>
                {{ $generalInformation->buildersRisk->square_footage }}m²
            </div>
            <div class="col-6">
                <div class="col-6">
                    <b>Floor Number:</b>
                    {{ $generalInformation->buildersRisk->number_floors }}
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Number of Dwelling</b>
                {{ $generalInformation->buildersRisk->number_dwelling }}
            </div>
            <div class="col-6">
                <div class="col-6">
                    <b>Security:</b>
                    {{ $generalInformation->buildersRisk->jobsite_security }}
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Distance to Fire Hydrant:</b>
                {{ $generalInformation->buildersRisk->firehydrant_distance }}km
            </div>
            <div class="col-6">
                <div class="col-6">
                    <b>Distance to Fire Station:</b>
                    {{ $generalInformation->buildersRisk->firestation_distance }}km
                </div>
            </div>
        </div>
    </div>
</div>
@if ($generalInformation->buildersRisk->construction_status == 2)
<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">Rennovation</h4>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Last Year Roofing Update:</b>
                {{ $generalInformation->buildersRisk->renovation->last_update_roofing }}
            </div>
            <div class="col-6">
                <b>Last Year Heating Update:</b>
                {{ $generalInformation->buildersRisk->renovation->last_update_heating }}
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Last Year Plumbing Update:</b>
                {{ $generalInformation->buildersRisk->renovation->last_update_plumbing }}
            </div>
            <div class="col-6">
                <b>Last Year Electrical Update:</b>
                {{ $generalInformation->buildersRisk->renovation->last_update_electrical }}
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Structure Will be Occupied:</b>
                {{ $generalInformation->buildersRisk->renovation->stucture_occupied }}
            </div>
            <div class="col-6">
                <b>Structure Built:</b>
                {{ $generalInformation->buildersRisk->renovation->structure_built }}
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <h4 class="card-title">Rennovation Description</h4>
                </div>
                <div class="row mb-4">
                    <div>
                        {{ $generalInformation->buildersRisk->renovation->description }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <h4 class="card-title">Complete Operation Description</h4>
                </div>
                <div class="row mb-4">
                    <div>
                        {{ $generalInformation->buildersRisk->renovation->description_operation }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@else
<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">New Construction Description</h4>
        </div>
        <div class="row mb-4">
            <div>
                {{ $generalInformation->buildersRisk->newConstruction->description_operation}}
            </div>
        </div>
    </div>
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">Builders Risk Previous Information</h4>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Expiration of Builders Risk:</b>
                {{ \Carbon\Carbon::parse($generalInformation->lead->buildersRiskExpirationProduct->expiration_date)->format('M-j-Y') }}
            </div>
            <div class="col-6">
                <b>Prior Carrier:</b>
                {{ $generalInformation->lead->buildersRiskExpirationProduct->prior_carrier }}
            </div>
        </div>
    </div>
</div>


