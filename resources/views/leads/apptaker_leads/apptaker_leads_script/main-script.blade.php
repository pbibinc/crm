{{-- //scripts for forms etc--}}
<script src="{{asset('backend/assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/twitter-bootstrap-wizard/prettify.js')}}"></script>
<script src="{{asset('backend/assets/js/pages/form-wizard.init.js')}}"></script>
<script src="{{asset('backend/assets/js/pages/form-mask.init.js')}}"></script>
<script src="{{asset('backend/assets/libs/inputmask/jquery.inputmask.min.js')}}"></script>


<script>
    $(document).ready(function (){
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('apptaker-leads') }}",
                data:function (d) {
                    d.website_originated = $('#websiteOriginatedDropdown').val()
                }
            },
            columns: [
                {data: 'company_name_action', name: 'company_name_action'},
                {data: 'tel_num', name: 'tel_num'},
                {data: 'class_code', name: 'class_code'},
                {data: 'state_abbr', name: 'state_abbr'},
                {data: 'dispositions', name:'dispositions'},
                // {data: 'website_originated', name: 'website_originated', searchable:false},

            ]
        });

        // scripts for reloading and configuring the dropdowns filters
        $('#websiteOriginatedDropdown').on('change', function () {
            $('#datatable').DataTable().ajax.reload();
        });

        $('#timezoneDropdown').on('change', function() {
            var timezone = $(this).val();
            $('#datatable').DataTable().ajax.url("{{ route('apptaker-leads') }}?timezone=" + timezone).load();
        });



        var leadsId = null;
        $(document).on('click', '#companyLink', function(event){
            event.preventDefault();
            leadsId = $(this).data('id');
            var companyName = $(this).data('name');
            $('#myExtraLargeModalLabel').text(companyName);
            if(leadsId == localStorage.getItem('id')){
                $('#firstName').val(localStorage.getItem('firstName'));
                $('#lastName').val(localStorage.getItem('lastName'));
                $('#jobPosition').val(localStorage.getItem('jobPosition'));
                $('#phoneNumber').val(localStorage.getItem('phoneNumber'));
                $('#altNumber').val(localStorage.getItem('altNumber'));
                $('#fax').val(localStorage.getItem('fax'));
                $('#email').val(localStorage.getItem('email'));
                $('#fullTimeEmployee').val(localStorage.getItem('fullTimeEmployee'));
                $('#partTimeEmployee').val(localStorage.getItem('partTimeEmployee'));
                $('#grossReceipt').val(localStorage.getItem('grossReceipt'));
                $('#employeePayRoll').val(localStorage.getItem('employeePayRoll'));
                $('#residential').val(localStorage.getItem('residential'));
                $('#commercial').val(localStorage.getItem('commercial'));
                $('#newConstruction').val(localStorage.getItem('newConstruction'));
                $('#repair').val(localStorage.getItem('repair'));
                $('#businessDescription').val(localStorage.getItem('businessDescription'));
            } else{
                $('#firstName').val('');
                $('#lastName').val('');
                $('#jobPosition').val('');
                $('#phoneNumber').val('');
                $('#altNumber').val('');
                $('#fax').val('');
                $('#email').val('');
                $('#fullTimeEmployee').val('');
                $('#partTimeEmployee').val('');
                $('#grossReceipt').val('');
                $('#employeePayRoll').val('');
                $('#residential').val('');
                $('#commercial').val('');
                $('#newConstruction').val('');
                $('#repair').val('');
                $('#businessDescription').val('');
            }
            $('#leadsDataModal').modal('show');
        });

        $('#leadsDataModal').on('hidden.bs.modal', function(){
                var formValues = {
                    id:  leadsId,
                    firstName: $('#firstName').val(),
                    lastName: $('#lastName').val(),
                    jobPosition: $('#jobPosition').val(),
                    phoneNumber: $('#phoneNumber').val(),
                    altNumber: $('#altNumber').val(),
                    fax: $('#fax').val(),
                    email: $('#email').val(),
                    fullTimeEmployee: $('#fullTimeEmployee').val(),
                    partTimeEmployee: $('#partTimeEmployee').val(),
                    grossReceipt: $('#grossReceipt').val(),
                    employeePayRoll: $('#employeePayRoll').val(),
                    residential: $('#residential').val(),
                    commercial: $('#commercial').val(),
                    newConstruction: $('#newConstruction').val(),
                    repair: $('#repair').val(),
                    businessDescription: $('#businessDescription').val(),
                    multipleStateWork: $('#multipleStateWork').val()
                };
        if(localStorage.getItem('firstName') == '' || localStorage.getItem('lastName') == '' || localStorage.getItem('jobPosition') == ''){
            $.each(formValues, function(key, value) {
                localStorage.setItem(key, value);
            });
        }
        });

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

        // if ($('#nextButton').is(':disabled')) {
        //     // Replace the Next button with the Submit button
        //     console.log('this test the disable');
        //     $('#nextButtonContainer').hide();
        //     $('#submitButton').parent().show();
        // }



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


        // Remove Row button click event
        $(document).on('click', '.removeRowButton', function() {
            $(this).closest('tr').remove();
            recalculatePercentages();
        });

        $('#progress-bank-detail').on('click', function(){
            console.log('this test the progress-bank-detail');
            var activeStep = $('.nav-link.active').attr('href');
            if(activeStep == '#progress-bank-detail'){
                $('#nextButtonContainer').hide();
                $('#submitButtonContainer').show();
            }
            if(activeStep == '#progress-company-document'){
                $('#nextButtonContainer').show();
                $('#submitButtonContainer').hide();
            }
            if(activeStep == '#progress-company-document'){
                $('#nextButtonContainer').show();
                $('#submitButtonContainer').hide();
            }
        });
        $('#progress-bank-detail').on('click', function(){
            console.log('this test the progress-bank-detail');
            var activeStep = $('.nav-link.active').attr('href');
            if(activeStep == '#progress-bank-detail'){
                $('#nextButtonContainer').hide();
                $('#submitButtonContainer').show();
            }
            if(activeStep == '#progress-company-document'){
                $('#nextButtonContainer').show();
                $('#submitButtonContainer').hide();
            }
            if(activeStep == '#progress-company-document'){
                $('#nextButtonContainer').show();
                $('#submitButtonContainer').hide();
            }
        });

        $('#progress-bank-detail').on('click', function(){
            console.log('this test the progress-bank-detail');
            var activeStep = $('.nav-link.active').attr('href');
            if(activeStep == '#progress-bank-detail'){
                $('#nextButtonContainer').hide();
                $('#submitButtonContainer').show();
            }
            if(activeStep == '#progress-company-document'){
                $('#nextButtonContainer').show();
                $('#submitButtonContainer').hide();
            }
            if(activeStep == '#progress-company-document'){
                $('#nextButtonContainer').show();
                $('#submitButtonContainer').hide();
            }
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



        // Form submission event
        $('#dataModalForm').on('submit', function(e) {
            e.preventDefault();


            // if (totalPercentage !== 100) {
            //     alert('Total percentage should be 100%. Please adjust the percentages.');
            //     return;
            // }

            // Perform form submission
            // Uncomment the following line when you are ready to submit the form
            // $(this).unbind('submit').submit();
        });

        $('#dataModal').on('submit', function (e) {
            e.preventDefault();
        });


        $('#dataModal').on('hidden.bs.modal', function() {
            var formData = $('#dataModalForm').serializeArray();
            var dataObject = {};

            $.each(formData, function(index, field){
                dataObject[field.name]  = field.value;
            });
            localStorage.setItem('formData', JSON.stringify(dataObject));

            var dynamicRowQuantity = rowCounter - 1;

            if(dynamicRowQuantity >= 1){
                $('#dynamicAddRemove tbody tr').slice(dynamicRowQuantity).remove();
            }else{
                console.log(dynamicRowQuantity);
            }

            // $('#dynamicAddRemove tbody').empty();
        });




    });
</script>