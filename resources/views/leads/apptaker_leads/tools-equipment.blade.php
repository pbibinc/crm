<div class="tab-pane" id="tools-equipment-1" role="tabpanel">
    <form action="">
        <div class="row mb-3">
            <div class="col-6">
                <label for="" class="form-label">Miscellaneous Tools Amount ($1,500 in value and under)</label>
                <input class="form-control" type="text" id="toolsAmountInput">
            </div>
            <div class="col-6">
                <label for="" class="form-label">Rented/Leased Equipment Amount</label>
                <input class="form-control input-mask text-left" value="12345.67"  id="rentedEquipmentAmountInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
            </div>
          
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label for="" class="form-label">Scheduled Equipment</label>
                <input class="form-control" type="text" id="scheduledEquipmentInput">
            </div>
        </div>

        <div class="row">
            <div>
                <label for="" class="form-label">Vehicle Information</label>
                <div class="card border border-primary">
                    <div class="card-header bg-transparent border-primary">
                        <button class="btn btn-success" id="addToolsInformationButton"><i class="mdi mdi-toolbox"></i></button>
                    </div>
                    <div class="card-body">
                        
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="" class="form-label">Equipment Type</label>
                                <select name="" id="equipmentType" class="form-select">
                                    <option value=""></option>
                                    <option value="Boom lift">Boom lift</option>
                                    <option value="Compact Tract Loader">Compact Tract Loader</option>
                                    <option value="fork lift">Fork lift</option>
                                    <option value="Generator">Generator</option>
                                    <option value="Jack Hammer">Jack Hammer</option>
                                    <option value="Lawn Mower">Lawn Mower</option>
                                    <option value="Mini Excavator">Mini Excavator</option>
                                    <option value="Mini Loader">Mini Loader</option>
                                    <option value="Scaff Loading">Scaff Loading</option>
                                    <option value="Scaffholding">Scaffholding(50k)</option>
                                    <option value="Skid Steer">Skid Steer</option>
                                    <option value="Spayer">Spayer</option>
                                    <option value="Trailer">Trailer</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label">Year</label>
                                <input type="text" class="form-control" name="toolYear" id="tollYear" placeholder="Year">
                            </div>
                        </div>
    
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="" class="form-label">Make</label>
                                <input type="text" class="form-control" name="toolMake" id="toolMake" placeholder="Make">
                           </div>
                           <div class="col-6">
                                <label for="" class="form-label">Model</label>
                                <input type="text" class="form-control" name="toolModel" id="toolModel" placeholder="Model">
                           </div>
                        </div>
    
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="" class="form-label">Serial Number/Identification Number</label>
                                <input type="text" class="form-control" name="toolSerialNumber" id="toolSerialNumber" placeholder="Serial Number">
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label">Value</label>
                                <input type="text" class="form-control" name="toolValue" id="toolValue" placeholder="Value">
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="form-label">Year Acquired</label>
                                <input class="form-control" type="number" min="1900" max="2099" placeholder="Year" id="yearAcquired">                      
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>

        <div id="additionalVehiclInformationDiv"></div>

        <div class="row mb-3">
            <div>
                <label for="" class="form-label">Deductible Amount</label>
                <select name="" id="deductibleAmount" class="form-select">
                    <option value=""></option>
                    <option value="500-1000">$500 - $1,000</option>
                    <option value="2500">$2,500</option>
                    <option value="5000">$5,000</option>
                    <option value="10000">$10,000</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label for="" class="col-form-label">Expiration of IM</label>
                <input type="date" class="form-control" name="expirationIm" id="expirationIm" placeholder="Date of Birth">
            </div>
            <div class="col-6">
                <label for=" "  class="col-form-label">Prior Carrier</label>
                <input type="text" class="form-control" name="toolsEquipmentPriorCarrier" id="toolsEquipmentPriorCarrier">
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
        <input type="hidden" id="haveLossesHiddenInput" name="haveLossesHiddenInput" value=5>

        <div class="row mb-3">
            <div class="col-6">
                <label for="" class="form-label">Call Back</label>
                <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="toolsEquipmentCallback">
            </div>
            <div class="col-6">
                <label for="" class="form-label">Cross Sell</label>
                <input class="form-control" type="text" id="toolsEquipmentCrossSell" placeholder="Cross Sell">
            </div>
        </div>

        <div class="row">
            <label class="form-label">Remarks</label>
            <div>
                <textarea name="" id="remarks"  rows="5" class="form-control"></textarea>
             </div>
        </div>

        <input type="hidden" id="callBackDateHiddenInput" name="callBackDateHiddenInput" value=5>
    </form>
</div>

<script>
    $(document).ready(function(){
        var additionalVehicleInformation = `
        <div class="row mb-3">
            <div>
                <label for="" class="form-label">Vehicle Information</label>
                <div class="card border border-primary">
                    <div class="card-header bg-transparent border-primary">
                        <button class="btn btn-danger removeToolsInformationButton" id="removeToolsInformationButton"><i class="mdi mdi-toolbox"></i></button>
                        <button class="btn btn-success addToolsInformationButton" id="addToolsInformationButton"><i class="mdi mdi-toolbox"></i></button>
                    </div>
                    <div class="card-body">
                        
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="" class="form-label">Equipment Type</label>
                                <select name="" id="equipmentType" class="form-select">
                                    <option value=""></option>
                                    <option value="Boom lift">Boom lift</option>
                                    <option value="Compact Tract Loader">Compact Tract Loader</option>
                                    <option value="fork lift">Fork lift</option>
                                    <option value="Generator">Generator</option>
                                    <option value="Jack Hammer">Jack Hammer</option>
                                    <option value="Lawn Mower">Lawn Mower</option>
                                    <option value="Mini Excavator">Mini Excavator</option>
                                    <option value="Mini Loader">Mini Loader</option>
                                    <option value="Scaff Loading">Scaff Loading</option>
                                    <option value="Scaffholding">Scaffholding(50k)</option>
                                    <option value="Skid Steer">Skid Steer</option>
                                    <option value="Spayer">Spayer</option>
                                    <option value="Trailer">Trailer</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label">Year</label>
                                <input type="text" class="form-control" name="toolYear" id="tollYear" placeholder="Year">
                            </div>
                        </div>
    
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="" class="form-label">Make</label>
                                <input type="text" class="form-control" name="toolMake" id="toolMake" placeholder="Make">
                           </div>
                           <div class="col-6">
                                <label for="" class="form-label">Model</label>
                                <input type="text" class="form-control" name="toolModel" id="toolModel" placeholder="Model">
                           </div>
                        </div>
    
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="" class="form-label">Serial Number/Identification Number</label>
                                <input type="text" class="form-control" name="toolSerialNumber" id="toolSerialNumber" placeholder="Serial Number">
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label">Value</label>
                                <input type="text" class="form-control" name="toolValue" id="toolValue" placeholder="Value">
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="form-label">Year Acquired</label>
                                <input class="form-control" type="number" min="1900" max="2099" placeholder="Year" id="yearAcquired">                      
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>
        `;

        $('#addToolsInformationButton').on('click', function(e){
            e.preventDefault();
           $('#additionalVehiclInformationDiv').append(additionalVehicleInformation);
        });

        $('#additionalVehiclInformationDiv').on('click', '.removeToolsInformationButton', function(e){
            e.preventDefault();
            $(this).closest('.row').remove();
        });

       $(document).on('click', '.addToolsInformationButton', function(e){
            e.preventDefault();
            $('#additionalVehiclInformationDiv').append(additionalVehicleInformation);
        });

    })
</script>