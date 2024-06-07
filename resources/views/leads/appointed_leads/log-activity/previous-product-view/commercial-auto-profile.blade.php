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
            <button type="button" class="editCommercialAuto btn btn-primary"
                value="{{ $generalInformation->lead->id }}"><i class="ri-edit-line"></i>
                Edit</button>
        </div>
    </div>
@endif
<div class="row">
    <div class="col-5 title-card">
        <i class="ri-clipboard-line title-icon"></i>
        <h4 class="card-title mb-0" style="color: #ffffff">Commercial Auto Information</h4>
    </div>
</div>
<div class="row mb-2">
    <div class="col-6">
        <b>Fein Number:</b>
        {{ $generalInformation->commercialAuto->fein }}
    </div>
    <div class="col-6">
        <b>Social Service Number:</b>
        {{ $generalInformation->commercialAuto->ssn }}
    </div>
</div>
<div class="row mb-4">
    <div class="col-6">
        <b>Garage Address</b>
        {{ $generalInformation->commercialAuto->garage_address }}
    </div>
</div>

<div class="row">
    <hr>
</div>

<div class="row mb-4">
    <div class="col-5 title-card">
        <i class="ri-car-line title-icon"></i>
        <h4 class="card-title mb-0" style="color: #ffffff">Vehicles</h4>
    </div>
</div>
<div class="row mb-4">
    @foreach ($generalInformation->commercialAuto->vehicleInformation as $index => $vehicle)
        <div class="col-6">
            <div class="card border border-primary">
                <div class="card-body">
                    <div class="row mb-4">
                        <h4 class="card-title d-flex align-items-center">Vehicle Information #{{ $index + 1 }}</h4>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6">
                            <b>year:</b>
                            {{ $vehicle->year }}
                        </div>
                        <div class="col-6">
                            <b>model:</b>
                            {{ $vehicle->make }}
                        </div>

                    </div>
                    <div class="row mb-4">
                        <div class="col-6">
                            <b>model:</b>
                            {{ $vehicle->model }}
                        </div>
                        <div class="col-6">
                            <b>vin number:</b>
                            {{ $vehicle->vin }}
                        </div>

                    </div>
                    <div class="row mb-4">
                        <div class="col-6">
                            <b>radius mileage:</b>
                            {{ $vehicle->radius_miles }}
                        </div>
                        <div class="col-6">
                            <b>cost of new vehicle:</b>
                            {{ $vehicle->cost_new_vehicle }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>

<div class="row">
    <hr>
</div>
<div class="row mb-4">
    <div class="col-5 title-card">
        <i class="ri-account-circle-line title-icon"></i>
        <h4 class="card-title mb-0" style="color: #ffffff">Drivers</h4>
    </div>
</div>

<div class="row mb-4">
    @foreach ($generalInformation->commercialAuto->driverInformation as $index => $driver)
        <div class="col-6 ">
            <div class="card border border-primary">
                <div class="card-body">
                    <div class="row mb-4">
                        <h4 class="card-title d-flex align-items-center">Driver Information #{{ $index + 1 }}</h4>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <b>Full Name:</b>
                            {{ $driver->fullname }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <b>Date of Birth:</b>
                            {{ $driver->date_of_birth }}
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <b>Marital Status:</b>
                            {{ $driver->marital_status }}
                        </div>
                    </div>
                    @if ($driver->marital_status == 'married')
                        <div class="row mb-4">
                            <div class="col-12">
                                <b>Spouse Name:</b>
                                {{ $driver->driverSpouse->spouse_fullname }}
                            </div>
                        </div>
                    @endif
                    <div class="row mb-4">
                        <div class="col-12">
                            <b>Number of Years Driving:</b>
                            {{ $driver->years_of_experience }}
                        </div>

                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <b>Drivers License Number:</b>
                            {{ $driver->driver_license_number }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="row">
    <hr>
</div>

<div class="row mb-4">
    <div class="col-5 title-card">
        <i class="ri-car-washing-line title-icon"></i>
        <h4 class="card-title mb-0" style="color: #ffffff">Commercial Auto Supplemental Questionare</h4>
    </div>
</div>
<div class="row mb-4">
    <div class="col-6">
        <b>Vehicle Maintance Program in Operation:</b>
        {{ $generalInformation->commercialAuto->commercialAutoSupplemental->vehicle_maintenance_program == 1 ? 'Yes' : 'No' }}
    </div>
    <div class="col-6">
        <b>Vehicle Customized, altered or have special equipment:</b>
        {{ $generalInformation->commercialAuto->commercialAutoSupplemental->is_vehicle_customized ? 'Yes' : 'No' }}
    </div>
</div>
@if (
    $generalInformation->commercialAuto->commercialAutoSupplemental->vehicle_maintenance_program ||
        $generalInformation->commercialAuto->commercialAutoSupplemental->is_vehicle_customized)
    <div class="row mb-4">
        @if ($generalInformation->commercialAuto->commercialAutoSupplemental->vehicle_maintenance_program)
            <div class="col-6">
                <b>Description:</b>
                {{ $generalInformation->commercialAuto->commercialAutoSupplemental->vehicle_maintenace_description }}
            </div>
        @endif
        @if ($generalInformation->commercialAuto->commercialAutoSupplemental->is_vehicle_customized)
            <div class="col-6">
                <b>Description:</b>
                {{ $generalInformation->commercialAuto->commercialAutoSupplemental->vehicle_customized_description }}
            </div>
        @endif
    </div>
@endif
<div class="row mb-4">
    <div class="col-6">
        <b>Vehicles owned by the prospect:</b>
        {{ $generalInformation->commercialAuto->commercialAutoSupplemental->is_vehicle_owned_by_prospect ? 'Yes' : 'No' }}
    </div>
    <div class="col-6">
        <b>Policy coverage been declined, canceled or non renewed 3 years prior:</b>
        {{ $generalInformation->commercialAuto->commercialAutoSupplemental->declined_canceled_nonrenew_policy ? 'Yes' : 'No' }}
    </div>
</div>
<div class="row mb-4">
    <div class="col-6">
        <b>Prospect had losses in the past 4 years:</b>
        {{ $generalInformation->commercialAuto->commercialAutoSupplemental->prospect_loss ? 'Yes' : 'No' }}
    </div>
    <div class="col-6">
        <b>Owned vehicles used for towing special equipment:</b>
        {{ $generalInformation->commercialAuto->commercialAutoSupplemental->vehicle_use_for_towing ? 'Yes' : 'No' }}
    </div>
</div>
<div class="row">
    <hr>
</div>


<div class="row mb-4">
    <div class="col-5 title-card">
        <i class="ri-calendar-event-line title-icon"></i> <!-- An example icon; adjust as necessary -->
        <h4 class="card-title mb-0" style="color: #ffffff">Previous Commercial Auto Policy</h4>
        <!-- mb-0 removes default margin at the bottom -->
    </div>
</div>
<div class="row mb-4">
    <div class="col-6">
        <b>Expiration of Commercial Auto:</b>
        {{ $generalInformation->lead->commercialAutoExpirationProduct->expiration_date }}
    </div>
    <div class="col-6">
        <b>Prior Carrier:</b>
        {{ $generalInformation->lead->commercialAutoExpirationProduct->prior_carrier }}
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.editCommercialAuto').on('click', function() {
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
            window.open(`${url}commercial-auto-form/edit`, "s_blank",
                "width=1000,height=849")
        });
    });
</script> j
