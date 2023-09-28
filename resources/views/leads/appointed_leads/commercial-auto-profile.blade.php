<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">Commercial Auto Information</h4>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Fein Number:</b>
                {{ $generalInformation->commercialAuto->fein}}
            </div>
            <div class="col-6">
                <b>Social Service Number:</b>
                {{  $generalInformation->commercialAuto->ssn }}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <b>Garage Address</b>
                {{  $generalInformation->commercialAuto->garage_address }}
            </div>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">Vehicle</h4>
        </div>
        <div class="row mb-4">
            @foreach ($generalInformation->commercialAuto->vehicleInformation as $vehicle)
            <div class="col-6 mb-4">
                <div class="card border border-primary">
                    <div class="card-body">
                        <div class="row mb-4">
                            <h4 class="card-title">Vehicle Information</h4>
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
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">Drivers</h4>
        </div>
        <div class="row mb-4">
            @foreach ($generalInformation->commercialAuto->driverInformation as $driver)
            <div class="col-6 mb-4">
                <div class="card border border-primary">
                    <div class="card-body">
                        <div class="row mb-4">
                            <h4 class="card-title">Driver Information</h4>
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
                        @if($driver->marital_status == 'married')
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
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">Commercial Auto Supplemental Questionare</h4>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Vehicle Maintance Program in Operation:</b>
                {{ $generalInformation->commercialAuto->commercialAutoSupplemental->vehicle_maintenance_program == 1 ? 'Yes' : 'No'}}
            </div>
            <div class="col-6">
                <b>Vehicle Customized, altered or have special equipment:</b>
                {{ $generalInformation->commercialAuto->commercialAutoSupplemental->is_vehicle_customized ? 'Yes' : 'No'}}
            </div>
        </div>
        @if ($generalInformation->commercialAuto->commercialAutoSupplemental->vehicle_maintenance_program || $generalInformation->commercialAuto->commercialAutoSupplemental->is_vehicle_customized)
        <div class="row mb-4">
            @if ($generalInformation->commercialAuto->commercialAutoSupplemental->vehicle_maintenance_program )
            <div class="col-6">
                <b>Description:</b>
                {{ $generalInformation->commercialAuto->commercialAutoSupplemental->vehicle_maintenace_description}}
            </div>
            @endif
            @if ($generalInformation->commercialAuto->commercialAutoSupplemental->is_vehicle_customized)
            <div class="col-6">
                <b>Description:</b>
                {{ $generalInformation->commercialAuto->commercialAutoSupplemental->vehicle_customized_description}}
            </div>
            @endif
        </div>
        @endif
        <div class="row mb-4">
            <div class="col-6">
                <b>Vehicles owned by the prospect:</b>
                {{ $generalInformation->commercialAuto->commercialAutoSupplemental->is_vehicle_owned_by_prospect ? 'Yes' : 'No'}}
            </div>
            <div class="col-6">
                <b>Policy coverage been declined, canceled or non renewed 3 years prior:</b>
                {{ $generalInformation->commercialAuto->commercialAutoSupplemental->declined_canceled_nonrenew_policy ? 'Yes' : 'No'}}
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Prospect had losses in the past 4 years:</b>
                {{ $generalInformation->commercialAuto->commercialAutoSupplemental->prospect_loss ? 'Yes' : 'No'}}
            </div>
            <div class="col-6">
                <b>Owned vehicles used for towing special equipment:</b>
                {{ $generalInformation->commercialAuto->commercialAutoSupplemental->vehicle_use_for_towing ? 'Yes' : 'No'}}
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <h4 class="card-title">Previous Commercial Auto Policy</h4>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <b>Expiration of Commercial Auto:</b>
                {{ $generalInformation->lead->commercialAutoExpirationProduct->expiration_date }}
            </div>
            <div class="col-6">
                <b>Prior Carrier:</b>
                {{$generalInformation->lead->commercialAutoExpirationProduct->prior_carrier }}
            </div>
        </div>
    </div>
</div>
