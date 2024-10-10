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
{{-- @if ($actionButtons == true)
    <div class="row mb-4">
        <div class="col-md-6">
            <button type="button" class="editCommercialAuto btn btn-primary"
                value="{{ $generalInformation->lead->id }}"><i class="ri-edit-line"></i>
                Edit</button>
        </div>
    </div>
@endif --}}
<div class="row-title">
    <div class="card-title">
        <h5>Commercial Auto Profile</h5>
    </div>
    @if ($actionButtons == true)
        <button type="button" class="editCommercialAuto btn btn-light btn-sm waves-effect waves-light"
            value="{{ $generalInformation->lead->id }}">
            <i class="ri-edit-line"></i> Edit
        </button>
    @endif
</div>

<div class="row">
    <div class="col-md-12">
        <div class="title-card">
            <i class="ri-clipboard-line title-icon"></i>
            <span>Commercial Auto Information</span>
        </div>
        <div class="data-section">
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Fein Number:</span>
                    <span class="data-value"> {{ $generalInformation->commercialAuto->fein }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Social Service Number:</span>
                    <span class="data-value">{{ $generalInformation->commercialAuto->ssn }}</span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Garage Address:</span>
                    <span class="data-value">{{ $generalInformation->commercialAuto->garage_address }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="title-card">
    <i class="ri-car-line title-icon"></i>
    <span>Vehicles</span>
</div>
<div class="row mb-4">

    @foreach ($generalInformation->commercialAuto->vehicleInformation as $index => $vehicle)
        <div class="col-md-6">
            <div class="vehicle-card">
                <div class="vehicle-title">Vehicle Information #{{ $index + 1 }}</div>
                <div class="vehicle-info">
                    <div class="row">
                        <div class="col-6">
                            <b>Year:</b> {{ $vehicle->year }}
                        </div>
                        <div class="col-6">
                            <b>Make:</b> {{ $vehicle->make }}
                        </div>
                    </div>
                </div>

                <div class="vehicle-info">
                    <div class="row">
                        <div class="col-6">
                            <b>Model:</b> {{ $vehicle->model }}
                        </div>
                        <div class="col-6">
                            <b>VIN Number:</b> {{ $vehicle->vin }}
                        </div>
                    </div>
                </div>

                <div class="vehicle-info">
                    <div class="row">
                        <div class="col-6">
                            <b>Radius Mileage:</b> {{ $vehicle->radius_miles }}
                        </div>
                        <div class="col-6">
                            <b>Cost of New Vehicle:</b> {{ $vehicle->cost_new_vehicle }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>
<hr>

<div class="title-card">
    <i class="ri-account-circle-line title-icon"></i>
    <span>Drivers</span>
</div>

<div class="row">
    <div class="row mb-4">
        @foreach ($generalInformation->commercialAuto->driverInformation as $index => $driver)
            <div class="col-md-6">
                <div class="driver-card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <h4 class="driver-title">Driver Information #{{ $index + 1 }}</h4>
                        </div>

                        <div class="driver-info">
                            <b>Full Name:</b> {{ $driver->fullname }}
                        </div>

                        <div class="driver-info">
                            <b>Date of Birth:</b> {{ $driver->date_of_birth }}
                        </div>

                        <div class="driver-info">
                            <b>Marital Status:</b> {{ $driver->marital_status }}
                        </div>

                        @if ($driver->marital_status == 'married')
                            <div class="driver-info">
                                <b>Spouse Name:</b> {{ $driver->driverSpouse->spouse_fullname }}
                            </div>
                        @endif

                        <div class="driver-info">
                            <b>Number of Years Driving:</b> {{ $driver->years_of_experience }}
                        </div>

                        <div class="driver-info">
                            <b>Drivers License Number:</b> {{ $driver->driver_license_number }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<hr>

@if ($generalInformation->commercialAuto->commercialAutoSupplemental)
    <div class="row">
        <div class="title-card">
            <i class="ri-car-washing-line title-icon"></i>
            <span>Commercial Auto Supplemental Questionare</span>
        </div>
        <div class="data-section">
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Vehicle Maintance Program in Operation:</span>
                    <span
                        class="data-value">{{ $generalInformation->commercialAuto->commercialAutoSupplemental->vehicle_maintenance_program == 1 ? 'Yes' : 'No' }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Vehicle Customized, altered or have special equipment:</span>
                    <span
                        class="data-value">{{ $generalInformation->commercialAuto->commercialAutoSupplemental->is_vehicle_customized ? 'Yes' : 'No' }}</span>
                </div>
            </div>
            <div class="inline-data">
                @if (
                    $generalInformation->commercialAuto->commercialAutoSupplemental->vehicle_maintenance_program ||
                        $generalInformation->commercialAuto->commercialAutoSupplemental->is_vehicle_customized)

                    @if ($generalInformation->commercialAuto->commercialAutoSupplemental->vehicle_maintenance_program)
                        <div class="col-6">
                            <span class="data-label">Description:</span>
                            <span class="data-value">
                                {{ $generalInformation->commercialAuto->commercialAutoSupplemental->vehicle_maintenace_description }}</span>
                        </div>
                    @endif
                    @if ($generalInformation->commercialAuto->commercialAutoSupplemental->is_vehicle_customized)
                        <div class="col-6">
                            <span class="data-label">Description:</span>
                            <span
                                class="data-value">{{ $generalInformation->commercialAuto->commercialAutoSupplemental->vehicle_customized_description }}</span>
                        </div>
                    @endif
                @endif
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Vehicles owned by the prospect:</span>
                    <span
                        class="data-value">{{ $generalInformation->commercialAuto->commercialAutoSupplemental->is_vehicle_owned_by_prospect ? 'Yes' : 'No' }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Policy coverage been declined, canceled or non renewed 3 years
                        prior:</span>
                    <span
                        class="data-value">{{ $generalInformation->commercialAuto->commercialAutoSupplemental->declined_canceled_nonrenew_policy ? 'Yes' : 'No' }}</span>
                </div>
            </div>
            <div class="inline-data">
                <div class="col-6">
                    <span class="data-label">Prospect had losses in the past 4 years:</span>
                    <span
                        class="data-value">{{ $generalInformation->commercialAuto->commercialAutoSupplemental->prospect_loss ? 'Yes' : 'No' }}</span>
                </div>
                <div class="col-6">
                    <span class="data-label">Owned vehicles used for towing special equipment:</span>
                    <span
                        class="data-value">{{ $generalInformation->commercialAuto->commercialAutoSupplemental->vehicle_use_for_towing ? 'Yes' : 'No' }}</span>
                </div>
            </div>
        </div>

    </div>
    <hr>
@endif

@if ($generalInformation->lead->commercialAutoExpirationProduct)
    <div class="row">
        <div class="col-md-12">
            <div class="title-card">
                <i class="ri-calendar-event-line title-icon"></i>
                <span>Previous Commercial Auto</span>
            </div>
            <div class="data-section">
                <div class="inline-data">
                    <div class="col-6">
                        <span class="data-label">Expiration of Commercial Auto:</span>
                        <span class="data-value">
                            {{ $generalInformation->lead->commercialAutoExpirationProduct->expiration_date }}</span>
                    </div>
                    <div class="col-6">
                        <span class="data-label">Prior Carrier:</span>
                        <span
                            class="data-value">{{ $generalInformation->lead->commercialAutoExpirationProduct->prior_carrier }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif



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
</script>
