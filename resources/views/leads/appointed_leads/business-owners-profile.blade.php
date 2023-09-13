<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">Business Owners Information</h4>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Property Address:</b>
                {{ $generalInformation->businessOwners->property_address }}
            </div>
            <div class="col-6">
                <b>Loss Payee:</b>
                {{ $generalInformation->businessOwners->loss_payee_information }}
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Building Industry:</b>
                {{ $generalInformation->businessOwners->building_industry }}
            </div>
            <div class="col-6">
                <b>Occupancy:</b>
                {{ $generalInformation->businessOwners->occupancy }}
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Building Cost:</b>
                {{ $generalInformation->businessOwners->building_cost }}
            </div>
            <div class="col-6">
                <b>Construction Type:</b>
                {{ $generalInformation->businessOwners->business_property_limit }}
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Year Built:</b>
                {{ $generalInformation->businessOwners->year_built }}
            </div>
            <div class="col-6">
                <b>Square Footage:</b>
                {{ $generalInformation->businessOwners->square_footage }}
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Number of Floors:</b>
                {{ $generalInformation->businessOwners->floor_number }}
            </div>
            <div class="col-6">
                <b>Automatic Sprinkler System:</b>
                {{ $generalInformation->businessOwners->automatic_sprinkler_system }}
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Automatic Fire Alarm:</b>
                {{ $generalInformation->businessOwners->automatic_fire_alarm }}
            </div>
            <div class="col-6">
                <b>Commercial Cooking System:</b>
                {{ $generalInformation->businessOwners->commercial_coocking_system }}
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Nearest Fire Hydrant:</b>
                {{ $generalInformation->businessOwners->nereast_fire_hydrant }}
            </div>
            <div class="col-6">
                <b>Nearest Fire Station:</b>
                {{ $generalInformation->businessOwners->nearest_fire_station }}
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Automatic Bulgar Alarm:</b>
                {{ $generalInformation->businessOwners->automatic_bulgar_alarm }}
            </div>
            <div class="col-6">
                <b>Security Camera:</b>
                {{ $generalInformation->businessOwners->security_camera }}
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Amount Policy:</b>
                {{ $generalInformation->businessOwners->amount_policy }}
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">Business Owners Information</h4>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Last Year Roofing Update:</b>
                {{ $generalInformation->businessOwners->last_update_roofing }}
            </div>
            <div class="col-6">
                <b>Last Year Heating Update:</b>
                {{ $generalInformation->businessOwners->last_update_heating }}
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Last Year Plumbing Update:</b>
                {{ $generalInformation->businessOwners->last_update_plumbing }}
            </div>
            <div class="col-6">
                <b>Last Year Electrical Update:</b>
                {{ $generalInformation->businessOwners->last_update_electrical }}
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">Builders Risk Previous Information</h4>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Expiration of Builders Risk:</b>
                {{ \Carbon\Carbon::parse($generalInformation->lead->businessOwnersExpirationProduct->expiration_date)->format('M-j-Y') }}
            </div>
            <div class="col-6">
                <b>Prior Carrier:</b>
                {{ $generalInformation->lead->businessOwnersExpirationProduct->prior_carrier }}
            </div>
        </div>
    </div>
</div>
