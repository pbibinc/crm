<div class="tab-pane" id="business-owner-1" role="tabpanel">

    <div class="row mb-3">
        <div>
            <label for="" class="form-label"> Property Address</label>
            <textarea name="" id="addressProperty" rows="5" class="form-control"></textarea>
        </div>
    </div>

    <div class="row mb-3">

        <div class="col-6">
            <label for="" class="form-label">Loss Payee Infromation</label>
            <input type="text" id="lossPayeeInformation" name="lossPayeeInformation" class="form-control">
        </div>
        
        <div class="col-6">
            <label for="" class="form-label">Building Industry</label>
            <select name="" id="" class="form-select">
                <option value=""></option>
                <option value=1>Apartment and Condo Assoc</option>
                <option value=2>Auto Repair/Service and Car Washes</option>
                <option value=3>Contractor and Landscaper</option>
                <option value=4>Grocery, Convenience Store</option>
                <option value=5>Gas Station</option>
                <option value=6>Offices</option>
                <option value=7>Restaurants and Hotels</option>
                <option value=8>Retail Stores</option>
                <option value=9>Service Providers</option>
                <option value=10>Whole Salers</option>
            </select>
        </div>

    </div>

    <div class="row mb-3">

        <div class="col-6">
            <label for="" class="form-label">Occupancy (Who owns the building?)</label>
            <select name="occuppancyDropdown" id="occuppancyDropdown" class="form-select">
                <option value=""></option>
                <option value=1>Apartments and Condo Assoc</option>
                <option value=2>Auto Repair/Service and Car Washes</option>
                <option value=3>Contractors and Landscapers</option>
                <option value=4>Grocery, Convenience Store</option>
                <option value=5>Gas Station</option>
                <option value=6>Offices</option>
                <option value=7>Restaurants and Hotels</option>
                <option value=8>Retail Stores</option>
                <option value=9>Service Providers</option>
                <option value=10>Whole Salers</option>
            </select>
        </div>

        <div class="col-6">
            <label for="" class="form-label">Value of Cost of the Building</label>
            <input class="form-control input-mask text-left"  id="buildingCost" onkeypress="return event.charCode >= 48 && event.charCode <= 57" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
        </div>

    </div>

    <div class="row mb-3">
        <div class="col-6">
            <label for="" class="form-label">What is the business property limit</label>
        <input class="form-control input-mask text-left"  id="propertyLimit" onkeypress="return event.charCode >= 48 && event.charCode <= 57" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
        </div>
    </div>

    <div class="row mb-3">
        <div>
            <label for="" class="form-label">Building Construction Type</label>
            <select name="buildingConstructionTypeDropdown" id="buildingConstructionTypeDropdown" class="form-select">
                <option value=""></option>
                <option value=1>Frame</option>
                <option value=2>Joisted Masonry</option>
                <option value=3>Non-Combustible</option>
                <option value=4>Masonry Non-Combustible</option>
                <option value=5>Modified Fire Resistive</option>
                <option value=6>Fire Resistive</option>
            </select>
        </div>
    </div>

    <div class="row mb-3">

        <div class="col-6">
            <label for="" class="form-label">Year Built</label>
            <input type="text" id="yearBuilt" name="yearBuilt" class="form-control">
        </div>

        <div class="col-6">
            <label for="" class="form-label">Number of Stories</label>
            <input type="text" id="numberOfStories" name="numberOfStories" class="form-control">
        </div>

    </div>

    <div class="row mb-3">
        <div class="col-6">
            <label for="" class="form-label">Square Footage</label>
            <input type="text" id="squareFootage" name="squareFootage" class="form-control">
        </div>
    </div>

    <div class="row mb-3">

        <div class="col-6">
            <label for="" class="form-label">Automatic Sprinkler System</label>
            <input type="text" id="automaticSprinklerSystem" name="automaticSprinklerSystem" class="form-control">
        </div>

        <div class="col-6">
            <label for="" class="form-label">Automatic Fire Alarm</label>
            <input type="text" id="automaticFireAlarm" name="automaticFireAlarm" class="form-control">
        </div>

    </div>

    <div class="row mb-3">
            
            <div class="col-6">
                <label for="" class="form-label">Distance to Nearest Fire Hydrant</label>
                <input type="text" id="nearestFireHydrant" name="nearestFireHydrant" class="form-control">
            </div>
    
            <div class="col-6">
                <label for="" class="form-label">Distance to Nearest Fire Station</label>
                <input type="text" id="nereastFireStation" name="nereastFireStation" class="form-control">
            </div>
    </div>

    <div class="row mb-3">
        <div>
            <label for="" class="form-label">Automatic Commercial Cooking Extinguishing System</label>
           <select name="automaticCookingExtinguishSystemDropdown" id="automaticCookingExtinguishSystemDropdown" class="form-select">
              <option value=""></option>
              <option value=0>No</option>
              <option value=1>Yes</option>
           </select>
        </div>
    </div>

    <div class="row mb-3">

        <div class="col-6">
            <label for="" class="form-label"> Automatic Burglar Alarm</label>
            <select name="automaticBurglarAlarmDropdown" id="automaticBurglarAlarmDropdown" class="form-select">
                <option value=""></option>
                <option value=0>None</option>
                <option value=1>Central or Police Station</option>
                <option value=2>Outside Siren Only</option>
            </select>
        </div>

        <div class="col-6">
            <label for="" class="form-label">Security Camera</label>
            <select name="" id="" class="form-select">
                <option value=""></option>
                <option value=0>No</option>
                <option value=1>Yes</option>
            </select>
        </div>

    </div>

    <div class="row mb-3">

        <div class="col-6">
            <label for="" class="form-label">Last Update to Roofing Year</label>
            <input type="text" id="roofingYearBop" name="roofingYearBop" class="form-control">
        </div>

        <div class="col-6">
            <label for="" class="form-label">Last Update to Heating Year</label>
            <input type="text" name="heatingYearBop" id="heatingYearBop" class="form-control">
        </div>

    </div>

    <div class="row mb-3">

        <div class="col-6">
            <label for="" class="form-label">Last Update to Plumbing Year</label>
            <input type="text" name="plumbingYearBop" id="plumbingYearBop" class="form-control">
        </div>

        <div class="col-6">
            <label for="" class="form-label">Last Update to Electrical Year</label>
            <input type="text" name="electricalYearBop" id="electricalYearBop" class="form-control">
        </div>

    </div>

    <div class="row mb-3">
        <div class="col-6">
            <label for="" class="col-form-label">Expiration of Business Owners Policy</label>
            <input type="date" class="form-control" name="expirationBop" id="expirationBop" placeholder="Date of Birth">
        </div>

        <div class="col-6">
            <label for=" "  class="col-form-label">Prior Carrier</label>
            <input type="text" class="form-control" name="businessOwnerPriorCarrier" id="businessOwnerPriorCarrier">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <label for="">Amount of Business Owners Policy</label>
                <input class="form-control input-mask text-left"  id="workersCompAmountInput" onkeypress="return event.charCode >= 48 && event.charCode <= 57" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <label for="" class="form-label">Have Losses</label>
            <div class="square-switch">
                <input type="checkbox" id="haveLossBusinessOwner" switch="info"/>
                <label for="haveLossBusinessOwner" data-on-label="Yes" data-off-label="No"></label>
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
    <input type="hidden" id="callBackDateHiddenInput" name="callBackDateHiddenInput" value=7>
    <input type="hidden" id="haveLossesHiddenInput" name="haveLossesHiddenInput" value=7>

    <div class="modal fade bs-example-modal-lg" id="haveLossModalBusinessOwner" tabindex="-1" aria-labelledby="haveLossModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="haveLossModalBusinessOwnerLabel">Have Losses Questionare</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row mb-3">
                        <div class="col-12">
                            <select name="" id="dataOptionDropdownBusinessOwner" class="form-select">
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
                            <input class="form-control" type="date" value="2011-08-19" id="monthDayYearBusinessOwner" hidden>
                            <input class="form-control" type="month" value="2020-03" id="monthDateYearBusinessOwner" hidden>
                            <input type="hidden" name="businessOwnerHiddenInput" id="businessOwnerHiddenInput" value=7>
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

        // code for have loss modal
        $('#haveLossBusinessOwner').change(function(){
            if($(this).prop('checked')){
                $('#haveLossModalBusinessOwner').modal('show');
            }
            else{
                $('#haveLossModalBusinessOwner').modal('hide');
            }
        });


        $('#dataOptionDropdownBusinessOwner').change(function(){
            if($(this).val() == 1){
                $('#monthDateYearBusinessOwner').removeAttr('hidden');
                $('#monthDayYearBusinessOwner').attr('hidden', true);
            }
            else if($(this).val() == 2){
                $('#monthDayYearBusinessOwner').removeAttr('hidden');
                $('#monthDateYearBusinessOwner').attr('hidden', true);
            }
        });


 
    });
</script>