<div class="tab-pane" id="commercial-auto-1" role="tabpanel">
    <div class="row mb-3">
        <div class="col-6">
            <label for="" class="form-label">FEIN#</label>
            <input type="text" class="form-control" name="fein" id="fein" placeholder="FEIN">
        </div>
        <div class="col-6">
            <label for="">SSN#</label>
            <input type="text" class="form-control" name="ssn" id="ssn" placeholder="SSN">
        </div>
    </div>
    <div class="row">
     <div>
        <label for="" class="from-label">Vehicle Information</label>
        <div class="card border border-primary">
            <div class="card-header bg-transparent border-primary">
                <button class="btn btn-success" id="addVehicleInformationButton"><i class="mdi mdi-car-2-plus"></i></button>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-6">
                        <label for="" class="form-label">Year</label>
                        <input type="text" class="form-control" name="carYear" id="carYear" placeholder="Year">
                    </div>
                    <div class="col-6">
                        <label for="" class="form-label">Make</label>
                        <input type="text" class="form-control" name="carMake" id="carMake" placeholder="Make">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <label for="" class="form-label">Model</label>
                        <input type="text" class="form-control" name="carModel" id="carModel" placeholder="Model">
                    </div>
                    <div class="col-6">
                        <label for="" class="form-label">VIN</label>
                        <input type="text" class="form-control" name="vin" id="vin" placeholder="VIN">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <label for="" class="form-label">Radius/Mileage</label>
                        <input type="text" class="form-control" name="radius" id="radius" placeholder="Radius">
                    </div>
                    <div class="col-6">
                        <label for="" class="form-label">Cost of New Vehicle</label>
                        <input type="text" class="form-control" name="vehicleCost" id="vehicleCost" placeholder="vehicle cost">
                    </div>
                </div>
            </div>
         </div>
     </div>
    </div>

    <div id="additionalVehicleinformation">

    </div>

    <div class="row mb-3">
        <div>
          <label for="garageAddress">Garage Address</label>
          <input type="text" class="form-control" name="garageAddress" id="garageAddress" placeholder=" ">
        </div>
    </div>

    <div class="row mb-3">
        <div>
            <label class="form-label" for="progress-basicpill-phoneno-input">Number of Driver to be insured</label>
            <input class="form-control" type="number" value="0" id="numberOfDriverToBeInsured" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
        </div>
    </div>

    <div id="additionalDriverInformation">

    </div>

    <div class="row mb-3">

        <div class="col-6">
            <label for="" class="col-form-label">Expiration of Auto</label>
            <input type="date" class="form-control" name="expirationAuto" id="expirationAuto" placeholder="Date of Birth">
        </div>

        <div class="col-6">
            <label for=" "  class="col-form-label">Prior Carrier</label>
            <input type="text" class="form-control" name="commercialAutoPriorCarrier" id="commercialAutoPriorCarrier">
        </div>

    </div>
    
    <div class="row mb-3">

        <div class="col-6">
            <label for="" class="form-label">Have Losses</label>
            <input class="form-control percentageInputEmployee" type="number" value="10" id="yearOfLossesInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
        </div>

        <div class="col-6">
            <label for="" class="form-label">Amount of Claims</label>
            <input class="form-control input-mask text-left"  id="amountOfClaimsInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-6">
            <label for="" class="form-label">Callback Date and Time</label>
        </div>
        <div class="col-6">
        <label for="" class="form-label">Cross Sale</label>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="commercialAutoCallback">
        </div>
        <div class="col-6">
            <input class="form-control" type="text" id="commercialAutoCallbackCrossSell" placeholder="Cross Sell">
        </div>
    </div>

    <div class="row mb-3">
        <label class="form-label">Remarks</label>
        <div>
           <textarea name="" id="remarks"  rows="5" class="form-control"></textarea>
        </div>
    </div>
    <input type="hidden" id="callBackDateHiddenInput" name="callBackDateHiddenInput" value=3>
    <input type="hidden" id="haveLossesHiddenInput" name="haveLossesHiddenInput" value=3>

</div>

<script>
    $(document).ready(function(){
        var vehicleInformationCard = `<div class="row">
   <div>
     <label for="" class="from-label">Vehicle Information</label>
     <div class="card border border-primary">
        <div class="card-header bg-transparent border-primary">
            <button class="btn btn-danger float-right removeAddedVehicleInformationButton" id="removeAddedVehicleInformation"><i class="mdi mdi-car-2-plus"></i></button>
            <button class="btn btn-success float-right addVehicleInformationButton" id="addVehicleInformationButton"><i class="mdi mdi-car-2-plus"></i></button>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-6">
                    <label for="" class="form-label">Year</label>
                    <input type="text" class="form-control" name="year" id="year" placeholder="Year">
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Make</label>
                    <input type="text" class="form-control" name="make" id="make" placeholder="Make">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-6">
                    <label for="" class="form-label">Model</label>
                    <input type="text" class="form-control" name="model" id="model" placeholder="Model">
                </div>
                <div class="col-6">
                    <label for="" class="form-label">VIN</label>
                    <input type="text" class="form-control" name="vin" id="vin" placeholder="VIN">
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="" class="form-label">Radius/Mileage</label>
                    <input type="text" class="form-control" name="radius" id="radius" placeholder="Radius">
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Cost of New Vehicle</label>
                    <input type="text" class="form-control" name="vehicleCost" id="vehicleCost" placeholder="vehicle cost">
                </div>
            </div>
        </div>
     </div>
    </div>
   </div>`;

        $('#addVehicleInformationButton').on('click', function(){
            $('#additionalVehicleinformation').append(vehicleInformationCard);
        });

        $(document).on('click', '.removeAddedVehicleInformationButton', function(){
            $(this).closest('.row').remove();
        });

        $(document).on('click', '.addVehicleInformationButton', function(){
            $('#additionalVehicleinformation').append(vehicleInformationCard);
        });

        $('#numberOfDriverToBeInsured').on('change', function(){
            var numberOfDriverToBeInsured = $(this).val();
            var driverInformationCard = `
            <div class="row">
                <label for="" class="form-label">Driver Information</label>
                <div class="card border border-primary">
                    <div class="card-header bg-transparent border-primary">
                        <button class="btn btn-danger float-right removeAddedDriverInformationButton" id="removeAddedDriverInformation"><i class="mdi mdi-car-2-plus"></i></button>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="" class="form-label">First Name</label>
                                <input type="text" class="form-control" name="firstName" id="firstName" placeholder="First Name">
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" name="dateOfBirth" id="dateOfBirth" placeholder="Date of Birth">
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label">Martial Status</label>
                                <select class="form-select">
                                    <option value=1>Single</option>
                                    <option value=2>Married</option>
                                    <option value=3>Divorced</option>
                                    <option value=4>Widowed</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="form-label">Driver License Number</label>
                                <input type="text" class="form-control" name="driverLicenseNumber" id="driverLicenseNumber" placeholder="Driver License Number">
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label">Years of driving experience</label>
                                <input type="text" class="form-control" name="yearsDrivingExperience" id="yearsDrivingExperience" placeholder="">
                            </div>
                        </div>
            </div>`;
            for(var i = 0; i < numberOfDriverToBeInsured; i++){
                $('#additionalDriverInformation').append(driverInformationCard);
            }
        });     

        $(document).on('click', '.removeAddedDriverInformationButton', function(){
            $(this).closest('.row').remove();
        });



    })
</script>