<div class="tab-pane" id="commercial-auto-1" role="tabpanel">
    <div class="row mb-3">
        <div class="col-6">
            <label for="" class="form-label">FEIN#</label>
            <input id="feinCommercialAuto" class="form-control input-mask" data-inputmask="'mask': '99-9999999'" inputmode="text" hidden>
            <input id="feinCommercialAutoDisbale" value="12345.67"  class="form-control input-mask" data-inputmask="'mask': '99-9999999'" inputmode="text" disabled hidden>
        </div>
        <div class="col-6">
            <label for="">SSN#</label>
            <input id="ssnCommercialAuto" class="form-control input-mask" data-inputmask="'mask': '999-99-9999'" inputmode="text">
            <input id="ssnCommercialAutoDisable" class="form-control input-mask" data-inputmask="'mask': '999-99-9999'" inputmode="text" disabled>
        </div>
    </div>
    <div class="row">
     <div>
        <label for="" class="from-label"><h6>Vehicle Information</h6></label>
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
    <div class="row">
        <label for="" class="form-label"><h6>Supplemental Questions:</h6></label>
    </div>
    <div class="row mb-3">

        <div class="col-6">
            <label for="" class="form-label">Is there A vehicle Maintenance Program in Operation</label>
            <div class="square-switch">
                <input type="checkbox" id="vehicleMaintenanceOperation" switch="info"/>
                <label for="vehicleMaintenanceOperation" data-on-label="Yes" data-off-label="No"></label>
            </div>
        </div>

        <div class="col-6">
            <label for="" class="form-label">Are any vehicles customized, altered or have special equipment?</label>
            <div class="square-switch">
                <input type="checkbox" id="vehicleCuztomized" switch="info"/>
                <label for="vehicleCuztomized" data-on-label="Yes" data-off-label="No"></label>
            </div>
        </div>
        
    </div>

    <div class="row" id="supplementalDesriptionDiv">
        <div class="col-6" id="vehicleMaintenanceCol">
            <textarea name="vehicleMaintenanceDescription" id="vehicleMaintenance" cols="60" rows="5" hidden></textarea>
        </div>
        <div class="col-6" id="vehicleCustomiezedCol">
            <textarea name="vehicleCustomizedDesciption" id="vehicleCustomizedDesciption" cols="60" rows="5" hidden></textarea>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <label for="" class="form-label">Are any vehicles owned by the prospect not to be scheduled on this application?</label>
            <div class="square-switch">
                <input type="checkbox" id="vehicleOwnedProspect" switch="info"/>
                <label for="vehicleOwnedProspect" data-on-label="Yes" data-off-label="No"></label>
            </div> 
        </div>
        <div class="col-6">
            <label for="" class="form-label">Has any policy or coverage been declined, canceled or non-renewed during the prior 3 years?</label>
            <div class="square-switch">
                <input type="checkbox" id="nonRenewedCancelled" switch="info"/>
                <label for="nonRenewedCancelled" data-on-label="Yes" data-off-label="No"></label>
            </div>
        </div>
    </div>

    <div class="row mb-3">
       
        <div class="col-6">
            <label for="" class="form-label">Has the prospect had any losses in the past 4 years?</label>
            <div class="square-switch">
                <input type="checkbox" id="prospectLoss" switch="info"/>
                <label for="prospectLoss" data-on-label="Yes" data-off-label="No"></label>
            </div>
        </div>
        <div class="col-6">
            <label for="" class="form-label">Are owned vehicles used for towing special equipment?</label>
            <div class="square-switch">
                <input type="checkbox" id="usedForTowing" switch="info"/>
                <label for="usedForTowing" data-on-label="Yes" data-off-label="No"></label>
            </div>
        </div>
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
            <div class="square-switch">
                <input type="checkbox" id="haveLossCommercialAuto" switch="info"/>
                <label for="haveLossCommercialAuto" data-on-label="Yes" data-off-label="No"></label>
            </div>
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

    <div class="modal fade bs-example-modal-lg" id="haveLossModalCommercialAuto" tabindex="-1" aria-labelledby="haveLossModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="haveLossModalCommercialAutoLabel">Have Losses Questionare</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row mb-3">
                        <div class="col-12">
                            <select name="" id="dataOptionDropdownCommercialAuto" class="form-select">
                                <option value="1">MM/YEAR</option>
                                <option value="2">DD/MM/YEAR</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">

                      <div class="col-6">
                        <label for="" class="form-label">Number of Year</label>
                      </div>  

                      <div class="col-6">
                        <label for="" class="form-label">Amount of Claims</label>
                      </div>

                    </div>

                    <div class="row">
                        <div class="col-6">
                            <input class="form-control" type="date" value="2011-08-19" id="monthDayYearCommercialAuto" hidden>
                            <input class="form-control" type="month" value="2020-03" id="monthDateYearCommercialAuto" hidden>
                            <input type="hidden" name="commercialAutoHiddenInput" id="commercialAutoHiddenInput" value=3>
                        </div>
                        <div class="col-6">
                            <input class="form-control input-mask text-left"  id="amountOfClaims" onkeypress="return event.charCode >= 48 && event.charCode <= 57" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveHaveLossWorkersComp">Submit</button>
                </div>
                

            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function(){
        var vehicleInformationCard = `<div class="row">
   <div>
     <label for="" class="from-label"><h6>Vehicle Information</h6></label>
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

        $('#dataOptionDropdownCommercialAuto').on('change', function(){
            if($(this).val() == 1){
                $('#monthDateYearCommercialAuto').removeAttr('hidden');
                $('#monthDayYearCommercialAuto').attr('hidden', true);
            }
            if($(this).val() == 2){
                $('#monthDayYearCommercialAuto').removeAttr('hidden');
                $('#monthDateYearCommercialAuto').attr('hidden', true);
            }
        });


        $('#addVehicleInformationButton').on('click', function(){
            $('#additionalVehicleinformation').append(vehicleInformationCard);
        });

        $(document).on('click', '.removeAddedVehicleInformationButton', function(){
            $(this).closest('.row').remove();
        });

        $(document).on('click', '.addVehicleInformationButton', function(){
            $('#additionalVehicleinformation').append(vehicleInformationCard);
        });

        
        if(localStorage.getItem('fein') == null){
            $('#feinCommercialAuto').removeAttr('hidden');
            $('#feinCommercialAutoDisbale').attr('hidden', true);
        }else{
            $('#feinCommercialAuto').attr('hidden', true);
            $('#feinCommercialAutoDisbale').removeAttr('hidden');
        }

        $('#feinCommercialAutoDisbale').val(localStorage.getItem('fein'));

        if(localStorage.getItem('ssn') == null){
            $('#ssnCommercialAuto').removeAttr('hidden');
            $('#ssnCommercialAutoDisable').attr('hidden', true);
        }else{
            $('#ssnCommercialAuto').attr('hidden', true);
            $('#ssnCommercialAutoDisable').removeAttr('hidden');
        }

        $('#vehicleMaintenanceOperation').on('change', function(){
            if($(this).is(':checked')){
                // $('#supplementalDesriptionDiv').removeAttr('hidden');
                // $('#vehicleMaintenanceCol').removeAttr('hidden');
                $('#vehicleMaintenance').removeAttr('hidden');
            }else{
                // $('#supplementalDesriptionDiv').attr('hidden', true);
                // $('#vehicleMaintenanceCol').attr('hidden', true);
                $('#vehicleMaintenance').attr('hidden', true);
            }
        });

        $('#vehicleCuztomized').on('change', function(){
            if($(this).is(':checked')){
                // $('#supplementalDesriptionDiv').removeAttr('hidden');
                // $('#vehicleCustomiezedCol').removeAttr('hidden');
                // $('#vehicleMaintenanceCol').removeAttr('hidden');
                $('#vehicleCustomizedDesciption').removeAttr('hidden');
            }else{
                // $('#supplementalDesriptionDiv').attr('hidden', true);
                // $('#vehicleCustomiezedCol').attr('hidden', true);
                $('#vehicleCustomizedDesciption').attr('hidden', true);
            }
        });

        $('#ssnCommercialAutoDisable').val(localStorage.getItem('ssn'));
        
        $('#haveLossCommercialAuto').on('change', function(){
            if($(this).is(':checked')){
                $('#haveLossModalCommercialAuto').modal('show');
            }else{
                
            }
        });
       
        $('#numberOfDriverToBeInsured').on('change', function(){
            var numberOfDriverToBeInsured = $(this).val();
            var driverInformationCard = `
            <div class="row">
                <label for="" class="form-label"><h6>Driver Information</h6></label>
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
                                <label for="" class="form-label">Marital Status</label>
                                <select class="form-select maritalStatusDropdown">
                                    <option value=0 selected>Choose...</option>
                                    <option value=1>Single</option>
                                    <option value=2>Married</option>
                                    <option value=3>Divorced</option>
                                    <option value=4>Widowed</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2 spouseDiv">
                        
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
        
        $(document).on('change', '.maritalStatusDropdown', function(){
            var spouseDiv = $(this).closest('.card-body').find('.spouseDiv');
           if($(this).val() == 2){
            spouseDiv.empty().append(`
                <div class="col-6">
                </div>
                <div class="col-6">
                      <label for="" class="form-label">Spouse Name</label>
                      <input type="text" class="form-control" name="spouseName" id="spouseName" placeholder="Spouse Name">
                 </div>
                `);
           }else{
                spouseDiv.empty();
           }
        });

    })
</script>