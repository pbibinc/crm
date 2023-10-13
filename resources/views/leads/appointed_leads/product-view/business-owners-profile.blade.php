<style>
    .title-card {
    background-color: #656565; /* Bootstrap primary color */
    padding: 10px 15px;
    border-radius: 5px;
    color: #ffffff;;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

.title-icon {
    margin-right: 10px;
}
</style>
<div class="row mb-4">
    <div class="col-5 title-card">
        <i class="ri-suitcase-line title-icon"></i> <!-- An example icon; adjust as necessary -->
        <h4 class="card-title mb-0" style="color: #ffffff">Business Owners Information</h4> <!-- mb-0 removes default margin at the bottom -->
    </div>
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
<div class="row"><hr></div>


<div class="row mb-4">
    <div class="col-5 title-card">
        <i class="ri-building-2-line title-icon"></i> <!-- An example icon; adjust as necessary -->
        <h4 class="card-title mb-0" style="color: #ffffff">Major Structure Information</h4> <!-- mb-0 removes default margin at the bottom -->
    </div>
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

<div class="row"><hr></div>

<div class="row mb-4">
    <div class="col-5 title-card">
        <i class="ri-calendar-event-line title-icon"></i> <!-- An example icon; adjust as necessary -->
        <h4 class="card-title mb-0" style="color: #ffffff">Previous Business Owners Policy</h4> <!-- mb-0 removes default margin at the bottom -->
    </div>
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

