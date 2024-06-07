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
            <button type="button" class="editGeneralLiabilitiesButton btn btn-primary"
                value="{{ $generalLiabilities->generalInformation->lead->id }}"><i class="ri-edit-line"></i>
                Edit</button>
        </div>
    </div>
@endif
<div class="row">
    <div class="col-6">
        <div class="row">
            <div class="col-10 title-card">
                <i class="ri-hammer-line title-icon"></i> <!-- An example icon; adjust as necessary -->
                <h4 class="card-title mb-0" style="color: #ffffff">Class Codes</h4>
                <!-- mb-0 removes default margin at the bottom -->
            </div>
        </div>
        <div class="row mb-4">
            @foreach ($generalLiabilities->classCodes as $classCode)
                <div class="col-6">
                    {{ $classCode->classCodeLead->name }}
                </div>
                <div class="col-6">
                    {{ $classCode->percentage }}%
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-6">
        <div class="row">
            <div class="col-10 title-card">
                <i class="ri-map-pin-line title-icon"></i> <!-- An example icon; adjust as necessary -->
                <h4 class="card-title mb-0" style="color: #ffffff">Multiple State Work</h4>
                <!-- mb-0 removes default margin at the bottom -->
            </div>
        </div>

        <div class="row mb-4">
            @foreach ($generalLiabilities->multiStates as $multiState)
                <div class="col-6">
                    {{ $multiState->state }}
                </div>
                <div class="col-6">
                    {{ $multiState->percentage }}%
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="row">
    <hr>
</div>
<div class="row">
    <div class="col-6">
        <div class="row">
            <div class="col-10 title-card">
                <i class="ri-briefcase-line title-icon"></i> <!-- An example icon; adjust as necessary -->
                <h4 class="card-title mb-0" style="color: #ffffff">Business Description</h4>
                <!-- mb-0 removes default margin at the bottom -->
            </div>
        </div>
        <div class="row">
            <p>{{ $generalLiabilities->business_description }}</p>
        </div>
    </div>
    <div class="col-6">
        <div class="row">
            <div class="col-10 title-card">
                <i class="ri-building-4-line title-icon"></i> <!-- An example icon; adjust as necessary -->
                <h4 class="card-title mb-0" style="color: #ffffff">Recreational Facilities</h4>
                <!-- mb-0 removes default margin at the bottom -->
            </div>
        </div>
        <div class="row">
            @foreach ($generalLiabilities->generalLiabilityFacilities as $generalLiabilityFacility)
                <div class="col-auto">
                    <!-- Use Bootstrap's grid: 'col-md-4' to have 3 cards per row on medium to large screens. Adjust as needed. -->
                    <button class="btn btn-info">{{ $generalLiabilityFacility->recreationalFacilities->name }}</button>
                </div>
            @endforeach
        </div>
    </div>
</div>


<div class="row">
    <hr>
</div>

<div class="row">
    <div class="col-5 title-card">
        <i class="ri-umbrella-line title-icon"></i> <!-- An example icon; adjust as necessary -->
        <h4 class="card-title mb-0" style="color: #ffffff">General Liability Information</h4>
        <!-- mb-0 removes default margin at the bottom -->
    </div>

</div>
<div class="row mb-3">
    <div class="col-6">
        <b>Residential:</b>
        {{ $generalLiabilities->residential }}%
    </div>
    <div class="col-6">
        <b>Commercial</b>
        {{ $generalLiabilities->commercial }}%
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <b>New Construction:</b>
        {{ $generalLiabilities->new_construction }}%
    </div>
    <div class="col-6">
        <b>Repair</b>
        {{ $generalLiabilities->repair }}%
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <b>Self Performing Roofing:</b>
        {{ $generalLiabilities->self_perform_roofing ? 'Yes' : 'No' }}
    </div>
    <div class="col-6">
        <b>Concrete Foundation Work:</b>
        {{ $generalLiabilities->concrete_foundation_work ? 'Yes' : 'No' }}
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <b>Perform Track Work:</b>
        {{ $generalLiabilities->perform_track_work ? 'Yes' : 'No' }}
    </div>
    <div class="col-6">
        <b>Perform Condo Town House:</b>
        {{ $generalLiabilities->is_condo_townhouse ? 'Yes' : 'No' }}
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <b>Perform Multi Dweling:</b>
        {{ $generalLiabilities->perform_multi_dwelling ? 'Yes' : 'No' }}
    </div>
    <div class="col-6">
        <b>Bussiness Entity:</b>
        {{ $generalLiabilities->business_entity }}
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <b>Years in Business:</b>
        {{ $generalLiabilities->years_in_business }} years
    </div>
    <div class="col-6">
        <b>Years in Professional:</b>
        {{ $generalLiabilities->years_in_professional }} years
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <b>Largest Project:</b>
        {{ $generalLiabilities->largest_project }}
    </div>
    <div class="col-6">
        <b>Largest Project Amount:</b>
        {{ $generalLiabilities->largest_project_amount }}
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <b>Contact License:</b>
        {{ $generalLiabilities->contract_license }}
    </div>
    <div class="col-6">
        <b>Contact License Name:</b>
        {{ $generalLiabilities->contract_license_name }}
    </div>
</div>
<div class="row mb-2">
    <div class="col-6">
        <b>Is your office home:</b>
        {{ $generalLiabilities->is_office_home ? 'Yes' : 'No' }}
    </div>
</div>
<div class="row">
    <hr>
</div>
<div class="row">
    <div class="col-5 title-card">
        <i class="ri-hand-heart-line title-icon"></i> <!-- An example icon; adjust as necessary -->
        <h4 class="card-title mb-0" style="color: #ffffff">Subcontract Information</h4>
        <!-- mb-0 removes default margin at the bottom -->
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <b>blasting operation:</b>
        {{ $generalLiabilities->subcontractor->blasting_operation ? 'Yes' : 'No' }}
    </div>
    <div class="col-6">
        <b>hazardous waste:</b>
        {{ $generalLiabilities->subcontractor->hazardous_waste ? 'Yes' : 'No' }}
    </div>
</div>
<div class="row mb-3">

    <div class="col-6">
        <b>asbestos mold:</b>
        {{ $generalLiabilities->subcontractor->asbestos_mold ? 'Yes' : 'No' }}
    </div>
    <div class="col-6">
        <b>above three stories height:</b>
        {{ $generalLiabilities->subcontractor->three_stories_height ? 'Yes' : 'No' }}
    </div>
</div>
<div class="row">
    <hr>
</div>
<div class="row">
    <div class="col-5 title-card">
        <i class="ri-calendar-event-line title-icon"></i> <!-- An example icon; adjust as necessary -->
        <h4 class="card-title mb-0" style="color: #ffffff">Previous General Liability</h4>
        <!-- mb-0 removes default margin at the bottom -->
    </div>
</div>
<div class="row mb-4">
    <div class="col-6">
        <b>Expiration of General Liability:</b>
        {{ $generalLiabilities->expiration_of_general_liabilities }}
    </div>
    <div class="col-6">
        <b>Policy Premium:</b>
        {{ $generalLiabilities->policy_premium }}
    </div>
</div>

<div class="row">
    <hr>
</div>

<div class="row">
    <div class="col-5 title-card">
        <i class="ri-price-tag-3-line title-icon"></i> <!-- An example icon; adjust as necessary -->
        <h4 class="card-title mb-0" style="color: #ffffff">Coverage Limit</h4>
        <!-- mb-0 removes default margin at the bottom -->
    </div>
</div>
<div class="row mb-3">
    <div class="col-6">
        <b>Limit:</b>
        {{ $generalLiabilities->coverageLimit->limit }}
    </div>
    <div class="col-6">
        <b>Medical:</b>
        {{ $generalLiabilities->coverageLimit->medical }}
    </div>
</div>
<div class="row mb-4">
    <div class="col-6">
        <b>Limit:</b>
        {{ $generalLiabilities->coverageLimit->fire_damage }}
    </div>
    <div class="col-6">
        <b>Medical:</b>
        {{ $generalLiabilities->coverageLimit->deductible }}
    </div>
</div>
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
