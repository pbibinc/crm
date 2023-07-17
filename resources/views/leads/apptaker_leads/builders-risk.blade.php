<div class="tab-pane" id="builders-risk-1" role="tabpanel">
    <form action="">
        <div class="row mb-3">
            <div class="col-6">
                <label for="" class="form-label">Property Address</label>
                <input type="text" class="form-control" name="propertyAddress" id="propertyAddress" placeholder="">
            </div>
            <div class="col-6">
                <label for="" class="form-label">Value of Existing Structure</label>
                <input type="text" class="form-control" name="existingStructureValue" id="existingStructureValue" placeholder="">
            </div>
        </div>
    
        <div class="row mb-3">
            <div class="col-6">
                <label for="" class="form-label">Value of work being performed</label>
                <input type="text" class="form-control" name="performedWorkValue" id="performedWorkValue" placeholder="">
            </div>
        </div>
    
        <div class="row mb-3">
    
            <div class="col-6">
                <label for="" class="form-label">Has the project Started</label>
                <select name="projectStartedDropdown" id="projectStartedDropdown" class="form-select">
                    <option value=""></option>
                    <option value=1>Yes</option>
                    <option value=0>No</option>
                </select>
            </div>
    
            <div class="col-6">
                <label for="" class="form-label">New Construction or Renovation</label>
                <select name="projectCompletedDropdown" id="projectCompletedDropdown" class="form-select">
                    <option value=""></option>
                    <option value=1>New Construction</option>
                    <option value=2>Renovation</option>
                </select>
            </div>
    
        </div>


        <div id="constructionNew">
            <div class="row">
                <div>
                    <label for="" class="form-label">Complete descriptions of operations for the project:</label>
                    <textarea name="newConstruction" id="newConstruction" rows="5" class="form-control"></textarea>
                </div>
            </div>
        </div>
    
        <div id="renovation">
            <div class="row mb-3">
                <div>
                    <label for="" class="form-label">Description of property Use Prior to construction</label>
                    <textarea name="proepertyDescriptionRenovation" id="proepertyDescriptionRenovation" rows="5" class="form-control"></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <label for="" class="form-label">Last Update to Roofing Year</label>
                    <input type="text" class="form-control" name="roofingLastUpdate" id="roofingLastUpdate" placeholder="">
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Last Update to Heating Year</label>
                    <input type="text" name="heatingLastUpdate" id="heatingLastUpdate"  class="form-control">
                </div>
            </div>

            <div class="row mb-3">

                <div class="col-6">
                    <label for="" class="form-label">Last Update to Plumbing Year</label>
                    <input type="text" name="plumbingLastUpdate" id="plumbingLastUpdate"  class="form-control">
                </div>

                <div class="col-6">
                    <label for="" class="form-label">Last Update to Electrical Year</label>
                    <input type="text" name="electricalLastUpdate" id="electricalLastUpdate"  class="form-control">
                </div>

            </div>

            <div class="row mb-3">
                <div>
                    <label for="" class="form-label">Will the Structure be Occupied During the Remodel/Renovation?</label>
                    <textarea name="occupiedStructureRemodel" id="occupiedStructureRemodel" rows="5" class="form-control"></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div>
                    <label for="" class="form-label">When was the structure built?</label>
                    <input type="text" name="structureBuilt" id="structureBuilt"  class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div>
                    <label for="" class="form-label">Complete description of operations for the projects?</label>
                    <input type="text" name="operationDescription" id="operationDescription" class="form-control">
                </div>
            </div>

        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label for="" class="form-label">Construction Type?</label>
                <select name="constructionType" id="constructionType" class="form-select">
                    <option value=""></option>
                    <option value=1>Frame</option>
                    <option value=2>Joisted Masonry</option>
                    <option value=3>Non-Combustible</option>
                    <option value=4>Masonry Non-Combustible</option>
                    <option value=5>Modified Fire Resestive</option>
                    <option value=6>Fire Resestive</option>
                </select>
            </div>
            <div class="col-6">
                <label for="" class="form-label">Protection Class</label>
                <select name="protectionClassDropdown" id="protectionClassDropdown" class="form-select">
                    <option value=""></option>
                    <option value=1>1</option>
                    <option value=2>2</option>
                    <option value=3>3</option>
                    <option value=4>4</option>
                    <option value=5>5</option>
                    <option value=6>6</option>
                    <option value=7>7</option>
                    <option value=8>8</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label for="" class="form-label">Square Footage</label>
                <input type="text" name="squareFootage" id="squareFootage" class="form-control">
            </div>
            <div class="col-6">
                <label for="" class="form-label">Number of Stories</label>
                <input type="text" name="numberOfStories" id="numberOfStories" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label for="" class="form-label">Number of Units Dwelling</label>
                <input type="text" name="numberOfUnits" id="numberOfUnits" class="form-control">
            </div>
            <div class="col-6">
                <label for="" class="form-label">Jobsite Security</label>
                <select name="jobsiteSecuritDropdown" id="jobsiteSecuritDropdown" class="form-select">
                    <option value=""></option>
                    <option value="Alarm">Alarm</option>
                    <option value="CCTV/Security Camera">CCTV/Security Camera</option>
                    <option value="Fenced">Fenced</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label for="" class="form-label">Distance to Nearest Fire Hydrant</label>
                <input type="text" name="fireHydrantDistance" id="fireHydrantDistance" class="form-control">
            </div>

            <div class="col-6">
                <label for="" class="form-label">Distance to Nearest Fire Station</label>
                <input type="text" name="fireStationDistance" id="fireStationDistance" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label for="" class="col-form-label">Expiration of Builders Risk</label>
                <input type="date" class="form-control" name="buildersExpiration" id="buildersExpiration" placeholder="Date of Birth">
            </div>
            <div class="col-6">
                <label for=" "  class="col-form-label">Prior Carrier</label>
            <input type="text" class="form-control" name="buildersPriorCarrier" id="buildersPriorCarrier">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label for="" class="form-label">Builder Risk Amount</label>
                <input class="form-control input-mask text-left"   name="builderRiskAmount" id="builderRiskAmount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
            </div>
        </div>

        <div class="row mb-3">

            <div class="col-6">
                <label for="" class="form-label">Have Losses</label>
                <div class="square-switch">
                    <input type="checkbox" id="haveLossBuilderRisk" switch="info"/>
                    <label for="haveLossBuilderRisk" data-on-label="Yes" data-off-label="No"></label>
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
                <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="callback">
            </div>
            <div class="col-6">
                <input class="form-control" type="text" id="callbackCrossSell" placeholder="Cross Sell">
            </div>
        </div>
    
        <div class="row mb-3">
            <label class="form-label">Remarks</label>
            <div>
               <textarea name="" id="remarks"  rows="5" class="form-control"></textarea>
            </div>
        </div>
        <input type="hidden" id="callBackDateHiddenInput" name="callBackDateHiddenInput" value=6>
        <input type="hidden" id="haveLossesHiddenInput" name="haveLossesHiddenInput" value=6>
    </form>

    {{-- model for losses in builders risk --}}
    <div class="modal fade bs-example-modal-lg" id="haveLossModalBuildersRisk" tabindex="-1" aria-labelledby="haveLossModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="haveLossModalBuildersRiskLabel">Have Losses Questionare</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row mb-3">
                        <div class="col-12">
                            <select name="" id="dataOptionDropdownBuildersRisk" class="form-select">
                                <option value="">choose...</option>
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
                            <input class="form-control" type="date" value="2011-08-19" id="monthDayYearBuildersRisk" hidden>
                            <input class="form-control" type="month" value="2020-03" id="monthDateYearBuildersRisk" hidden>
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
    $(document).ready(function() {
        $('#renovation').hide();
        $('#constructionNew').hide();

        //Code for project started dropdown
        $('#projectCompletedDropdown').change(function(e) {
            e.preventDefault();
            if ($(this).val() == 1) {
                $('#constructionNew').show();
                $('#renovation').hide();
            } else if ($(this).val() == 2) {
                $('#constructionNew').hide();
                $('#renovation').show();
            } else {
                $('#constructionNew').hide();
                $('#renovation').hide();
            }
        });
        

        //Code for have losses modal
        $('#haveLossBuilderRisk').on('change', function(){
            if ($(this).is(':checked')) {
                $('#haveLossModalBuildersRisk').modal('show');
            } else {
                $('#haveLossModalBuildersRisk').modal('hide');
            }
        });
        
        //Code for have losses date and day dropdown
        $('#dataOptionDropdownBuildersRisk').on('change', function(){
            if($(this).val() == 1){
                $('#monthDateYearBuildersRisk').removeAttr('hidden');
                $('#monthDayYearBuilderRisk').attr('hidden', true);
            }
            if($(this).val() == 2){
                $('#monthDayYearBuildersRisk').removeAttr('hidden');
                $('#monthDateYearBuildersRisk').attr('hidden', true);
            }
        });

    });
</script>