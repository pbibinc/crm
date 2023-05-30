 {{--General Information Tab--}}
 <div class="tab-content twitter-bs-wizard-tab-content">
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
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="progress-basicpill-firstname-input">Job Position</label>
                        <input type="text" class="form-control" name="jobPosition" id="jobPosition">
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="progress-basicpill-phoneno-input">Phone</label>
                        <input type="text" class="form-control" name="phoneNumber" id="phoneNumber">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="progress-basicpill-phoneno-input">Alternative Phone Number</label>
                        <input type="text" class="form-control" name="altNumber" id="altNumber">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="progress-basicpill-phoneno-input">Fax</label>
                        <input type="text" class="form-control" name="fax" id="fax">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="progress-basicpill-email-input">Email</label>
                        <input type="email" class="form-control" id="email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="progress-basicpill-phoneno-input">Full Employee</label>
                        <input class="form-control" type="number" value="10" id="fullTimeEmployee" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="progress-basicpill-email-input">Part Time Employee</label>
                        <input class="form-control" type="number" value="10" id="partTimeEmployee" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="progress-basicpill-phoneno-input">Gross Receipt</label>
                        <input class="form-control input-mask text-left"  id="grossReceipt" onkeypress="return event.charCode >= 48 && event.charCode <= 57" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="progress-basicpill-email-input">Employee Pay Roll</label>
                        <input class="form-control input-mask text-left"  id="employeePayRoll" onkeypress="return event.charCode >= 48 && event.charCode <= 57" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
                    </div>
                </div>
            </div>

        </form>
    </div>
    <script>
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

    </script>