 {{-- General Information Tab --}}

 <div class="tab-pane" id="progress-seller-details">
     <form>
         <div class="row">
             <div class="col-lg-6">
                 <div class="mb-3">
                     <label class="form-label" for="progress-basicpill-firstname-input">First name</label>
                     <input type="text" class="form-control" id="firstName">
                 </div>
             </div>
             <div class="col-lg-6">
                 <div class="mb-3">
                     <label class="form-label" for="progress-basicpill-lastname-input">Last name</label>
                     <input type="text" class="form-control" id="lastName">
                 </div>
             </div>
         </div>
         <div class="row mb-3">

             <div class="col-lg-6">
                 <label class="form-label" for="progress-basicpill-firstname-input">Job Position</label>
                 <input type="text" class="form-control" name="jobPosition" id="jobPosition">
             </div>

         </div>

         <div class="row mb-3">

             <div class="col-6">
                 <label for="" class="form-label">Zipcode</label>
                 <select name="" id="zipcode" class="form-select">

                     <option value="">

                     </option>
                 </select>
             </div>

             <div class="col-6">
                 <label class="form-label" for="progress-basicpill-firstname-input">State</label>
                 <input type="text" class="form-control" name="stateInput" id="stateInput" disabled>
             </div>

         </div>

         <div class="row mb-3">
             <div class="col-6">
                 <label class="form-label" for="progress-basicpill-firstname-input">City</label>
                 <select name="" id="cities" class="form-select">
                     <option value=""></option>
                 </select>

             </div>

             <div class="col-6">
                 <label class="form-label" for="progress-basicpill-firstname-input">Address</label>
                 <input type="text" class="form-control" name="address" id="address">
             </div>

         </div>

         <div class="row">

             <div class="col-lg-6">
                 <div class="mb-3">
                     <label class="form-label" for="progress-basicpill-phoneno-input">Tel Num</label>
                     <input type="text" class="form-control" name="telNum" id="telNum" disabled>
                 </div>
             </div>

             <div class="col-lg-6">
                 <div class="mb-3">
                     <label class="form-label" for="progress-basicpill-phoneno-input">Alternative Phone
                         Number</label>
                     <input type="text" class="form-control" name="altNumber" id="altNumber"
                         placeholder="alternative number">
                 </div>
             </div>

         </div>

         <div class="row">

             <div class="col-lg-6">
                 <div class="mb-3">
                     <label class="form-label" for="progress-basicpill-phoneno-input">Fax</label>
                     <input id="fax" name="fax" class="form-control input-mask"
                         data-inputmask="'mask': '9-999999999'" inputmode="text">
                 </div>
             </div>

             <div class="col-lg-6">
                 <div class="mb-3">
                     <label class="form-label" for="progress-basicpill-email-input">Email</label>
                     <input type="email" class="form-control" id="email" placeholder="email">
                 </div>
             </div>

         </div>

         <div class="row">
             <div class="col-lg-6">
                 <div class="mb-3">
                     <label class="form-label" for="progress-basicpill-phoneno-input">Full Employee</label>
                     <input class="form-control" type="number" value="10" id="fullTimeEmployee"
                         onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                 </div>
             </div>

             <div class="col-lg-6">
                 <div class="mb-3">
                     <label class="form-label" for="progress-basicpill-email-input">Part Time Employee</label>
                     <input class="form-control" type="number" value="10" id="partTimeEmployee"
                         onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                 </div>
             </div>
         </div>

         <div class="row">
             <div class="col-lg-6">
                 <div class="mb-3">
                     <label class="form-label" for="progress-basicpill-phoneno-input">Gross Receipt</label>
                     <input class="form-control input-mask text-left" id="grossReceipt"
                         onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                         data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
                 </div>
             </div>
             <div class="col-lg-6">
                 <div class="mb-3">
                     <label class="form-label" for="progress-basicpill-email-input">Employee Pay Roll</label>
                     <input class="form-control input-mask text-left" id="employeePayRoll"
                         onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                         data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
                 </div>
             </div>
         </div>

         <div class="row mb-3">
             <div class="col-6">
                 <label for="" class="form-label">Sub Out/1099</label>
                 <input class="form-control input-mask text-left" id="subout"
                     onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                     data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
             </div>
             <div class="col-6">
                 <label for="" class="form-label">Owners Payroll</label>
                 <input class="form-control input-mask text-left" id="ownersPayroll"
                     onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                     data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
             </div>

         </div>

         <div class="row">
             <div class="d-none" id="subContractDiv">
                 <label for="" class="form-label">List all trades and or work that you subcontract</label>
                 <textarea required class="form-control" rows="5" name="subcontractDescription" id="subcontractDescription"></textarea>
             </div>
         </div>

     </form>
 </div>

 <style>
     .select2-drop,
     .select2-dropdown {
         z-index: 9999999;
     }
 </style>

 <script>
     var leadsId = null;
     $(document).on('click', '[id^="companyLink"]', function(event) {
         event.preventDefault();
         var rowId = $(this).data('id');
         var stateAbbr = $(this).data('state');
         var dropDown = $('select[data-row="' + rowId + '"]');
         var selectedDisposition = dropDown.val();
         var telNum = $(this).data('telnum');
         $('#telNum').val(telNum);
         $('#transactionLogModal').modal('show');
         leadsId = $(this).data('id');
         var companyName = $(this).data('name');
         $('#stateInput').val(stateAbbr);
         // $('#cities').select2({
         //     placeholder: 'Select an option',
         //     drodownparent: $('#leadsDataModal')
         // });
         $('#myExtraLargeModalLabel').text(companyName);
         $.ajax({
             url: "{{ route('filter-cities') }}",
             type: 'GET',
             data: {
                 id: leadsId,
                 disposition: selectedDisposition,
                 stateAbbr: stateAbbr
             },
             success: function(response) {
                 var cities = response.cities.map(function(item) {
                     return item.city;
                 });

                 var zipcode = response.zipcode.map(function(item) {
                     return item.zipcode;
                 });

                 varSelectZipcode = $('#zipcode');
                 var select = $('#cities');
                 select.empty();


                 cities.forEach(function(item) {
                     select.append('<option value="' + item + '">' + item + '</option>');
                 });

                 zipcode.forEach(function(item) {
                     varSelectZipcode.append('<option value="' + item + '">' + item +
                         '</option>');
                 });

                 //   $.each(cities, function(key, value) {
                 //     select.append('<option value="'+value+'">'+value+'</option>');
                 //  });

             },
             error: function(xhr) {
                 console.log(xhr.responseText);
             }
         });

         $('#zipcode').on('change', function() {
             var zipcode = $(this).val();
             $.ajax({
                 url: "{{ route('filter-cities') }}",
                 type: 'GET',
                 data: {
                     zipcode: zipcode
                 },
                 success: function(response) {
                     var city = response.cities;
                     var select = $('#cities');
                     select.val(city).trigger('change');
                 },
                 error: function(xhr) {
                     console.log(xhr.responseText);
                 }
             });
         });

         $('#cities').on('change', function() {
             var city = $(this).val();
             $.ajax({
                 url: "{{ route('filter-cities') }}",
                 type: 'GET',
                 data: {
                     city: city
                 },
                 success: function(response) {
                     var zipcode = response.zipcode;
                     var select = $('#zipcode');
                     select.val(zipcode).trigger('change');
                 },
                 error: function(xhr) {
                     console.log(xhr.responseText);
                 }
             });
         });

         $('#subout').on('keyup', function() {
             $('#subContractDiv').removeClass('d-none');
         });
         var suboutItem = parseInt(localStorage.getItem('subout'));
         if (suboutItem != 0) {
             $('#subContractDiv').removeClass('d-none');
         }

         if (leadsId == localStorage.getItem('id')) {
             $('#firstName').val(localStorage.getItem('firstName'));
             $('#lastName').val(localStorage.getItem('lastName'));
             $('#jobPosition').val(localStorage.getItem('jobPosition'));
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
             $('#subout').val(localStorage.getItem('subout'));
             $('#subcontractDescription').val(localStorage.getItem('subcontractDescription'));
             $('#ownersPayroll').val(localStorage.getItem('ownersPayroll'));
         } else {
             $('#firstName').val('');
             $('#lastName').val('');
             $('#jobPosition').val('');
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
             $('#subout').val('');
             $('#subcontractDescription').val('');
             $('#ownersPayroll').val('');
         }

         $('#leadsDataModal').on('hidden.bs.modal', function() {
             var formValues = {
                 id: leadsId,
                 firstName: $('#firstName').val(),
                 lastName: $('#lastName').val(),
                 jobPosition: $('#jobPosition').val(),
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
                 multipleStateWork: $('#multipleStateWork').val(),
                 subout: $('#subout').val(),
                 subcontractDescription: $('#subcontractDescription').val(),
                 ownersPayroll: $('#ownersPayroll').val()
             };
             if (formValues.firstName || !formValues.lastName || !formValues.jobPosition) {
                 $.each(formValues, function(key, value) {
                     localStorage.setItem(key, value);
                 });
             }
         });

         $('#nextButton').on('click', function() {
             var formValues = {
                 id: leadsId,
                 firstName: $('#firstName').val(),
                 lastName: $('#lastName').val(),
                 jobPosition: $('#jobPosition').val(),
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
                 multipleStateWork: $('#multipleStateWork').val(),
                 subout: $('#subout').val(),
                 subcontractDescription: $('#subcontractDescription').val(),
                 ownersPayroll: $('#ownersPayroll').val()
             };
             if (formValues.firstName || !formValues.lastName || !formValues.jobPosition) {
                 $.each(formValues, function(key, value) {
                     localStorage.setItem(key, value);
                 });
             }
         });

     });
 </script>
