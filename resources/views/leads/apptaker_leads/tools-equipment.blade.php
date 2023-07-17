<div class="tab-pane" id="tools-equipment-1" role="tabpanel">
    <form action="">
        <div class="row mb-3">
            <div class="col-6">
                <label for="" class="form-label">Miscellaneous Tools Amount</label>
                <input class="form-control input-mask text-left" value="12345.67"  id="toolsAmountInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
            </div>
            <div class="col-6">
                <label for="" class="form-label">Rented/Leased Equipment Amount</label>
                <input class="form-control input-mask text-left" value="12345.67"  id="rentedEquipmentAmountInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
            </div>
          
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label for="" class="form-label">Scheduled Equipment</label>
                <input class="form-control input-mask text-left" value="12345.67"  id="scheduledEquipmentInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
            </div>
        </div>

        <div class="row">
            <div>
                <label for="" class="form-label">Tools and Equipment</label>
                <div class="card border border-primary">
                    <div class="card-header bg-transparent border-primary">
                        <button class="btn btn-success" id="addToolsInformationButton"><i class="mdi mdi-toolbox"></i></button>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="" class="form-label">Equipment Type</label>
                                <select name=" " id="equipmentTypeDropdown" class="form-select">
                                    <option value=""></option>
                                    <option value=1>Light/Medium Equipment</option>
                                    <option value=2>Heavy Equipment</option>
                                </select>
                            </div>
                            <div class="col-6" id="equipmentTypeDiv">
                                <label for="" class="form-label" id="equipmentHeavyTypeLabel" hidden>Heavy Equipment</label>
                                <select name="" id="equipmentHeavyTypeDropdown" class="form-select equipmentHeavyTypeDropdown" hidden>
                                    <option value=""></option>
                                    <option value="Backhoe">Backhoe</option>
                                    <option value="Crane">Crane</option>
                                    <option value="Forklift">Forklift</option>
                                    <option value="Excavator">Excavator</option>
                                    <option value="Loader">Loader</option>
                                    <option value="Scaffholding Scaffholding(Above 50k)">Scaffholding(Above 50k)</option>
                                    <option value="Wood Chippers">Wood Chippers</option>
                                    <option value="Other">Other</option>
                                </select>

                                <label for="" class="form-label" id="equipmentTypeLabel" hidden>Light/Medium Equipment</label>
                                <select name="" id="equipmentLightTypeDropdown" class="form-select equipmentLightTypeDropdown" hidden>
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
                                    <option value="Scaffholding(Under 50k)">Scaffholding(Under 50k)</option>
                                    <option value="Skid Steer">Skid Steer</option>
                                    <option value="Spayer">Spayer</option>
                                    <option value="Trailer">Trailer</option>
                                    <option value="Other">Other</option>
                                </select>
                                
                            </div>
                         
                        </div>
                        <div class="row">
                            <div class="col-6">

                            </div>
                            <div class="col-6">
                                <textarea name="lightToolTypeEqupmentDesciption" id="lightToolTypeEqupmentDesciption" cols="60" rows="5" hidden></textarea>
                                <textarea name="heavyToolTypeEquipmentDescription" id="heavyToolTypeEquipmentDescription" cols="60" rows="5" hidden></textarea>
                            </div>
                        </div>
                        
                        <div class="row mb-2">
                    
                            <div class="col-6">
                                <label for="" class="form-label">Year</label>
                                <input type="text" class="form-control" name="toolYear" id="tollYear" placeholder="Year">
                            </div>

                            <div class="col-6">
                                <label for="" class="form-label">Make</label>
                                <input type="text" class="form-control" name="toolMake" id="toolMake" placeholder="Make">
                           </div>
                           
                        </div>
    
                        <div class="row mb-2">
                          
                           <div class="col-6">
                                <label for="" class="form-label">Model</label>
                                <input type="text" class="form-control" name="toolModel" id="toolModel" placeholder="Model">
                           </div>

                           <div class="col-6">
                              <label for="" class="form-label">Serial Number/Identification Number</label>
                              <input type="text" class="form-control" name="toolSerialNumber" id="toolSerialNumber" placeholder="Serial Number">
                           </div>

                        </div>
    
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="" class="form-label">Value</label>
                                <input type="text" class="form-control" name="toolValue" id="toolValue" placeholder="Value">
                            </div>

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
                    <option value="500-1000">$500</option>
                    <option value="1000">$1,000</option>
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
                <div class="square-switch">
                    <input type="checkbox" id="haveLossToolEquipment" switch="info"/>
                    <label for="haveLossToolEquipment" data-on-label="Yes" data-off-label="No"></label>
                </div>
            </div>
            <div class="col-6">
               
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

    <div class="modal fade bs-example-modal-lg" id="haveLossModalToolsEquipment" tabindex="-1" aria-labelledby="haveLossModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="haveLossModalToolsEquipmentLabel">Have Losses Questionare</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row mb-3">
                        <div class="col-12">
                            <select name="" id="dataOptionDropdownToolEquipment" class="form-select">
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
                            <input class="form-control" type="date" value="2011-08-19" id="monthDayYearToolsEquipment" hidden>
                            <input class="form-control" type="month" value="2020-03" id="monthDateYearToolsEquipment" hidden>
                            <input type="hidden" name="toolsEquipmentHiddenInput" id="toolsEquipmentHiddenInput" value=5>
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

        var addtionalToolEquipmentDescription = `
        <div class="col-6"></div>
        <div class="col-6">
           <textarea name="" cols="60" rows="5" class="lightToolTypeEqupmentDesciption" hidden></textarea>
           <textarea name="" cols="60" rows="5" class="heavyToolTypeEquipmentDescription" hidden></textarea>
        </div>
        `;

        var additionalVehicleInformation = `
        <div class="row mb-3">
            <div>
                <label for="" class="form-label">Tools and Equipment</label>
                <div class="card border border-primary">
                    <div class="card-header bg-transparent border-primary">
                        <button class="btn btn-danger removeToolsInformationButton" id="removeToolsInformationButton"><i class="mdi mdi-toolbox"></i></button>
                        <button class="btn btn-success addToolsInformationButton" id="addToolsInformationButton"><i class="mdi mdi-toolbox"></i></button>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="" class="form-label">Equipment Type</label>
                                <select name=" " id="equipmentTypeDropdown" class="form-select equipmentTypeDropdown">
                                    <option value=""></option>
                                    <option value=1>Light/Medium Equipment</option>
                                    <option value=2>Heavy Equipment</option>
                                </select>
                            </div>
                            <div class="col-6" id="equipmentTypeDiv">
                                <label for="" class="form-label" id="equipmentHeavyTypeLabel" hidden>Heavy Equipment</label>
                                <select name="" id="" class="form-select heavyToolTypeEquipmentDropdown" hidden>
                                    <option value=""></option>
                                    <option value="Backhoe">Backhoe</option>
                                    <option value="Crane">Crane</option>
                                    <option value="Forklift">Forklift</option>
                                    <option value="Excavator">Excavator</option>
                                    <option value="Loader">Loader</option>
                                    <option value="Scaffholding Scaffholding(Above 50k)">Scaffholding(Above 50k)</option>
                                    <option value="Wood Chippers">Wood Chippers</option>
                                    <option value="Other">Other</option>
                                </select>

                                <label for="" class="form-label" id="equipmentTypeLabel" hidden>Light/Medium Equipment</label>
                                <select name="" id="" class="form-select lightToolTypeEqupmentDropdown" hidden>
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
                                    <option value="Scaffholding(Under 50k)">Scaffholding(Under 50k)</option>
                                    <option value="Skid Steer">Skid Steer</option>
                                    <option value="Spayer">Spayer</option>
                                    <option value="Trailer">Trailer</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                         
                        </div>

                        <div class="row toolEquipmentDescriptionDiv">
                            <div class="col-6"></div>
                            <div class="col-6">
                              <textarea name="" cols="60" rows="5" class="lightToolTypeEqupmentDesciption" hidden></textarea>
                              <textarea name="" cols="60" rows="5" class="heavyToolTypeEquipmentDescription" hidden></textarea>
                            </div>
                        </div>
                        
                        <div class="row mb-2">
                    
                            <div class="col-6">
                                <label for="" class="form-label">Year</label>
                                <input type="text" class="form-control" name="toolYear" id="tollYear" placeholder="Year">
                            </div>

                            <div class="col-6">
                                <label for="" class="form-label">Make</label>
                                <input type="text" class="form-control" name="toolMake" id="toolMake" placeholder="Make">
                           </div>
                           
                        </div>
    
                        <div class="row mb-2">
                          
                           <div class="col-6">
                                <label for="" class="form-label">Model</label>
                                <input type="text" class="form-control" name="toolModel" id="toolModel" placeholder="Model">
                           </div>

                           <div class="col-6">
                              <label for="" class="form-label">Serial Number/Identification Number</label>
                              <input type="text" class="form-control" name="toolSerialNumber" id="toolSerialNumber" placeholder="Serial Number">
                           </div>

                        </div>
    
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="" class="form-label">Value</label>
                                <input type="text" class="form-control" name="toolValue" id="toolValue" placeholder="Value">
                            </div>

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
        $('#haveLossToolEquipment').on('change', function(){
            if($(this).is(':checked')){
                $('#haveLossModalToolsEquipment').modal('show');
            }else{

            }
        });

        $('#dataOptionDropdownToolEquipment').on('change', function(){
            if($(this).val() == 1){
                $('#monthDayYearToolsEquipment').removeAttr('hidden');
                $('#monthDateYearToolsEquipment').attr('hidden', true);
            }else if($(this).val() == 2){
                $('#monthDayYearToolsEquipment').attr('hidden', true);
                $('#monthDateYearToolsEquipment').removeAttr('hidden');
            }
        });

        $('#equipmentTypeDropdown').on('change', function(e){
            e.preventDefault();
            if($(this).val() == 2){
                $('#equipmentHeavyTypeDropdown').removeAttr('hidden');
                $('#equipmentHeavyTypeLabel').removeAttr('hidden');
                $('#equipmentLightTypeDropdown').attr('hidden', true);
                $('#equipmentTypeLabel').attr('hidden', true);
            }else if($(this).val() == 1){
                $('#equipmentHeavyTypeDropdown').attr('hidden', true);
                $('#equipmentHeavyTypeLabel').attr('hidden', true);
                $('#equipmentLightTypeDropdown').removeAttr('hidden');
                $('#equipmentTypeLabel').removeAttr('hidden');
            }else{
                $(this).closest('.row').find('#equipmentHeavyTypeDropdown').attr('hidden', true);
                $(this).closest('.row').find('#equipmentHeavyTypeLabel').attr('hidden', true);
                $(this).closest('.row').find('#equipmentLightTypeDropdown').attr('hidden', true);
                $(this).closest('.row').find('#equipmentTypeLabel').attr('hidden', true);
            }
        });

        $('#equipmentHeavyTypeDropdown').on('change', function(e){
            e.preventDefault();
            if($(this).val() == 'Other'){
                $('#heavyToolTypeEquipmentDescription').removeAttr('hidden');
            }else{
                $('#heavyToolTypeEquipmentDescription').attr('hidden', true);
            }
        })
        
        $(document).on('change', '.heavyToolTypeEquipmentDropdown', function(e){
            e.preventDefault();
            var toolEquipmentHeavyDescriptionDiv = $(this).closest('.card-body').find('.toolEquipmentDescriptionDiv .heavyToolTypeEquipmentDescription');
            if($(this).val() == 'Other'){
                toolEquipmentHeavyDescriptionDiv.removeAttr('hidden');
            }else{
                toolEquipmentHeavyDescriptionDiv.attr('hidden', true);
            }
        });

        $('#equipmentLightTypeDropdown').on('change', function(e){
            e.preventDefault();
            if($(this).val() == 'Other'){
                $('#lightToolTypeEqupmentDesciption').removeAttr('hidden');
            }else{
                $('#lightToolTypeEqupmentDesciption').attr('hidden', true);
            }
        })
             
        $(document).on('change', '.lightToolTypeEqupmentDropdown', function(e){
            e.preventDefault();
            var toolEquipmentLightDescriptionDiv = $(this).closest('.card-body').find('.toolEquipmentDescriptionDiv .lightToolTypeEqupmentDesciption');
            if($(this).val() == 'Other'){
                toolEquipmentLightDescriptionDiv.removeAttr('hidden');
            }else{
                toolEquipmentLightDescriptionDiv.attr('hidden', true);
            }
        });

        $(document).on('change', '.equipmentTypeDropdown', function(e){
            e.preventDefault();
            if($(this).val() == 2){
                $(this).closest('.row').find('.heavyToolTypeEquipmentDropdown').removeAttr('hidden');
                $(this).closest('.row').find('#equipmentHeavyTypeLabel').removeAttr('hidden');
                $(this).closest('.row').find('.lightToolTypeEqupmentDropdown').attr('hidden', true);
                $(this).closest('.row').find('#equipmentTypeLabel').attr('hidden', true);
            }else if($(this).val() == 1){
                $(this).closest('.row').find('.heavyToolTypeEquipmentDropdown').attr('hidden', true);
                $(this).closest('.row').find('#equipmentHeavyTypeLabel').attr('hidden', true);
                $(this).closest('.row').find('.lightToolTypeEqupmentDropdown').removeAttr('hidden');
                $(this).closest('.row').find('#equipmentTypeLabel').removeAttr('hidden');
            }else{
                $(this).closest('.row').find('.heavyToolTypeEquipmentDropdown').attr('hidden', true);
                $(this).closest('.row').find('#equipmentHeavyTypeLabel').attr('hidden', true);
                $(this).closest('.row').find('.lightToolTypeEqupmentDropdown').attr('hidden', true);
                $(this).closest('.row').find('#equipmentTypeLabel').attr('hidden', true);
            }
        });

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