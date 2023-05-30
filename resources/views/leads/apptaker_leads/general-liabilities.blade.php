  {{--General Liabilities Tab--}}
<div class="tab-pane active" id="general-liability-1" role="tabpanel">
    <div class="row">
        <div class="mb-3">
            <label>Business Description</label>
            <div>
                <textarea required class="form-control" id="businessDescription" rows="5"></textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <label class="form-label">Residential</label>
            <input id="residential" type="text" value="50" name="residential">
        </div>
        <div class="col-6">
            <label class="form-label">Commercial</label>
            <input id="commercial" type="text" value="50" name="commercial">
        </div>
    </div>
    <br>


    <div class="row">
        <div class="col-6">
            <label class="form-label">New Contruction</label>
            <input id="newConstruction" type="text" value="50" name="newConstruction">
        </div>
        <div class="col-6">
            <label class="form-label">Repair</label>
            <input id="repair" type="text" value="50" name="repair">
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-6">
            <label class="form-label">Multiple State Work</label>
        </div>
        <div class="col-6">
            <label class="form-label">Self Performing Roofing</label>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="square-switch">
                <input type="checkbox" id="multipleStateWork" switch="info"/>
                <label for="multipleStateWork" data-on-label="Yes" data-off-label="No"></label>
            </div>
        </div>

        <div class="col-6">
            <div class="square-switch">
                <input type="checkbox" id="roofing" switch="info"/>
                <label for="roofing" data-on-label="Yes" data-off-label="No"></label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <label class="form-label">Concrete Foundation Work</label>
        </div>
        <div class="col-6">
            <label class="form-label">Do you Perform Tract work?</label>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="square-switch">
                <input type="checkbox" id="concreteFoundation" switch="info"/>
                <label for="concreteFoundation" data-on-label="Yes" data-off-label="No"></label>
            </div>
        </div>
        <div class="col-6">
            <div class="square-switch">
                <input type="checkbox" id="trackWork" switch="info"/>
                <label for="trackWork" data-on-label="Yes" data-off-label="No"></label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <label class="form-label">Do you do any work for condominium</label>
        </div>
        <div class="col-6">
            <label class="form-label">Will you perform any new/remodeling work in multi-dwelling residences?</label>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="square-switch">
                <input type="checkbox" id="condoTownHouse" switch="info"/>
                <label for="condoTownHouse" data-on-label="Yes" data-off-label="No"></label>
            </div>
        </div>
        <div class="col-6">
            <div class="square-switch">
                <input type="checkbox" id="square-switch3" switch="info"/>
                <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
            </div>
        </div>
    </div>


     {{-- start of modal for adding multiple statework--}}
     <div class="modal fade bs-example-modal-lg" id="dataModal" tabindex="-1" aria-labelledby="dataModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataModalLabel">Mutiple State</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="dataModalForm">
                        @csrf
                        <div class="mb-3">
                            <div class="form-group">
                                <table class="table table-bordered" id="dynamicAddRemove">
                                    <tr>
                                        <th>States</th>
                                        <th>Percentage</th>
                                        <th>Action</th>
                                    </tr>

                                    <tr>
                                        <td>  <select name="statesDropdown[0][state]" id="statesDropdown" class="form-control" >
                                                <option value="">Select a timezone</option>
                                                <option value="">ALL</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state }}">{{ $state }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input class="form-control" type="number" value="42" id="stateWorkPercentage" name="statePercentage[0][percentage]">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <button id="addRowButton" class="btn btn-primary">Add Row</button>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <input type="hidden" name="action" id="action" value="add">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="action_button" id="action_button" id='#stateWorkPercentage' value="Submit" class="btn btn-primary">
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){


        
        $('#residential, #commercial').TouchSpin({
            min: 0,
            max: 100,
            step: 1,
            decimals: 0,
            boostat: 5,
            maxboostedstep: 10,
            postfix: '%'
        });


        $('#newConstruction, #repair').TouchSpin({
            min: 0,
            max: 100,
            step: 1,
            decimals: 0,
            boostat: 5,
            maxboostedstep: 10,
            postfix: '%'
        });



        $('#residential').on('change', function(){
           var value1 =  parseInt($(this).val()) || 0;
            var value2 = 100 - value1;

            $('#commercial').val(value2);
        });
        $('#commercial').on('change', function(){
            var value2 =  parseInt($(this).val()) || 0;
            var value1 = 100 - value2;

            $('#residential').val(value1);
        });

        $('#newConstruction').on('change', function(){
           var value1 = parseInt($(this).val()) || 0;
           var value2 = 100 - value1;

           $('#repair').val(value2);
        });


        $('#repair').on('change', function(){
            var value2 = parseInt($(this).val()) || 0;
            var value1 = 100 - value2;

            $('#newConstruction').val(value1);
        });

        $('#multipleStateWork').on('change', function(){
            if($(this).is(':checked')){
               $('#dataModal').modal('show');
            }else{

            }

        });


        var rowCounter = 1;
        var maxPercentage = 100;

        // Function to recalculate total percentage
        function recalculatePercentages() {
            var totalPercentage = 0;

            $('.percentageInput').each(function() {
                var percentage = parseInt($(this).val()) || 0;
                totalPercentage += percentage;
            });

            $('#totalPercentage').text(totalPercentage);
        }


          // Add Row button click event
      $('#addRowButton').on('click', function() {
            var totalPercentage = parseInt($('#totalPercentage').text()) || 0;
            var remainingPercentage = maxPercentage - totalPercentage;
            // if (remainingPercentage <= 0) {
            //     alert('Total percentage has reached 100%. Cannot add more rows.');
            //     return;
            // }

            var newRow = `
            <tr id="row${rowCounter}" class="dynamic-row">
                <td>
                    <select name="statesDropdown[${rowCounter}][state]" class="form-control statesDropdown">
                        <option value="">Select a state</option>
                        <option value="ALL">ALL</option>
                        @foreach ($states as $state)
                        <option value="{{ $state }}">{{ $state }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                  <div class="input-group">
                    <input class="form-control percentageInput" type="number" value="0" name="statePercentage[${rowCounter}][percentage]">
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                  </div>
               </td>
                <td>
                    <button class="btn btn-danger removeRowButton">Remove</button>
                </td>
            </tr>
        `;

            $('#dynamicAddRemove tbody').append(newRow);
            rowCounter++;

            recalculatePercentages();

        });

    //event for showing the multiple state work
    $('#dataModal').on('show.bs.modal', function(){
            var storedData = localStorage.getItem('formData');
            var formData = JSON.parse(storedData);
            var propertyNames = Object.keys(formData);

            var rowProperties = propertyNames.filter(function(propertyName) {
                return propertyName.startsWith('statesDropdown[') && propertyName.endsWith('][state]');
            });

            var rowCount = rowCounter;
                var newRow = `
            <tr id="row${rowCounter}" class="dynamic-row">
                <td>
                    <select name="statesDropdown[${rowCounter}][state]" class="form-control statesDropdown">
                        <option value="">Select a state</option>
                        <option value="ALL">ALL</option>
                        @foreach ($states as $state)
                <option value="{{ $state }}">{{ $state }}</option>
                        @endforeach
                </select>
            </td>
            <td>
              <div class="input-group">
                <input class="form-control percentageInput" type="number" value="0" name="statePercentage[${rowCounter}][percentage]">
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                  </div>
               </td>
                <td>
                    <button class="btn btn-danger removeRowButton">Remove</button>
                </td>
            </tr>
        `;

          // Remove Row button click event
          $(document).on('click', '.removeRowButton', function() {
            $(this).closest('tr').remove();
            recalculatePercentages();
        });

        
              console.log(rowCount);
            if(rowCount >= 1) {
                for (var i = 1; i <= rowCount; i++) {
                    $('#dynamicAddRemove tbody').append(newRow);
                }
            }


            for (var i = 0; i <= rowCount; i++) {
                var state = formData[`statesDropdown[${i}][state]`];
                var percentage = formData[`statePercentage[${i}][percentage]`];



                if (state || percentage) {
                    $('[name="statesDropdown[' + i + '][state]"]').val(state);
                    $('[name="statePercentage[' + i + '][percentage]"]').val(percentage);

                }
            }
        });
    });
    

</script>
{{-- End General Liabilities Tab--}}