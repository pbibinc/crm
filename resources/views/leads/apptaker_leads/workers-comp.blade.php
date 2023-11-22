<div class="tab-pane" id="worker-comp-1" role="tabpanel">
    <form action="">

        <div class="row">

            <div class="col-6">
                <label for="" class="form-label">Gross Receipt</label>
            </div>



        </div>

        <div class="row">

            <div class="col-6">
                <input class="form-control input-mask text-left" value="12345.67" id="grossReceiptExcessLiability"
                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                    disabled>
            </div>


        </div>

        <div class="row mt-2">

            <div class="col-6">
                <label for="" class="form-label">Total Employee</label>
            </div>

            <div class="col-6">
                <label for="" class="form-label">Sub Out/1099</label>
            </div>

        </div>

        <div class="row mb-3">
            <div class="col-6">
                <input class="form-control" type="number" value="10" id="numberOfEmployee" readonly>
            </div>
            <div class="col-6">
                <input class="form-control" name="" id="subOut" type="text" placeholder="Sub Out/1099">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-8">
                <label>Employee Description</label>
                <input class="form-control" type="text" placeholder="Employee Functionality"
                    id="EmployeeFunctionality">
            </div>

            <div class="col-4">
                <label>Number of Employee</label>
                <input class="form-control percentageInputEmployee" type="number" value="10"
                    id="numberOfEmployeePerClasscode" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
            </div>

        </div>

        <div id="addtionalClasssCodePerEmployeeInput">
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label class="form-label">Owners Payroll</label>
                <select name="ownersPayrollIncluded" class="form-select" id="ownersPayrollIncluded">
                    <option value="1">Excluded</option>
                    <option value="2">Included</option>
                </select>
            </div>
            <div class="col-6">
                <label>Employee Payroll</label>
                <input class="form-control" type="text" id="payrollWorkersComp" disabled>
            </div>
        </div>

        <div class="row mb-3">
            <label class="form-label">Specific Description of Employees </label>
            <div>
                <textarea name="" id="employeeSpecificDescription" rows="5" class="form-control"></textarea>
            </div>
        </div>

        <div class="row mb-3">

            <div class="col-6">
                <label class="form-label">FEIN#</label>
                <input id="fein" class="form-control input-mask" data-inputmask="'mask': '99-9999999'"
                    inputmode="text">
            </div>

            <div class="col-6">
                <label class="form-label">SSN#</label>
                <input id="ssn" class="form-control input-mask" data-inputmask="'mask': '999-99-9999'"
                    inputmode="text">
            </div>

        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label for="">Expiration of WC:</label>
                <input class="form-control" type="date" value="2011-08-19T13:45:00" id="workersCompExpirationInput">
            </div>
            <div class="col-6">
                <label for="">Prior Carrier</label>
                <input class="form-control" type="text" id="workersCompPriorCarrierInput"
                    placeholder="Prior Carrier">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label for="">Workers Comp Amount</label>
                <input class="form-control input-mask text-left" id="workersCompAmountInput"
                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                    data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
            </div>
            <div class="col-6">

            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <label for="">Have Losses?</label>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <div class="square-switch">
                    <input type="checkbox" id="haveLossWorkersComp" switch="info" />
                    <label for="haveLossWorkersComp" data-on-label="Yes" data-off-label="No"></label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div>
                <label for="" class="form-label">Policy Limit</label>
                <select name="" id="workersCompLimitDropdown" class="form-select">
                    <option value=""></option>
                    <option value=300000>$300,000</option>
                    <option value=500000>$500,000</option>
                    <option value=1000000>$1,000,000</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">

            <div class="col-6">
                <label for="" class="form-label">Each Accident</label>
                <select name="" id="eachAccidentAmountDropdown" class="form-select">
                    <option value=""></option>
                    <option value=300000>$300,000</option>
                    <option value=500000>$500,000</option>
                    <option value=1000000>$1,000,000</option>
                </select>
            </div>

            <div class="col-6">
                <label for="" class="form-label">Each Employee</label>
                <select name="" id="eachEmployeeAmountDropdown" class="form-select">
                    <option value=""></option>
                    <option value=300000>$300,000</option>
                    <option value=500000>$500,000</option>
                    <option value=1000000>$1,000,000</option>
                </select>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-6">
                <label for="" class="form-label">Callback Date and Time</label>
            </div>
            <div class="col-6">
                <label for="" class="form-label">Cross Sale</label>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00"
                    id="commercialAutoCallback">
            </div>
            <div class="col-6">
                <input class="form-control" type="text" id="workersCompCallbackCrossSell"
                    placeholder="Cross Sell">

            </div>
        </div>

        <div class="row mb-3">
            <label class="form-label">Remarks</label>
            <div>
                <textarea name="" id="remarks" rows="5" class="form-control"></textarea>
            </div>
        </div>
        <input type="hidden" id="callBackDateHiddenInput" name="callBackDateHiddenInput" value=4>
    </form>


    <div class="modal fade bs-example-modal-lg" id="haveLossModalWorkersComp" tabindex="-1"
        aria-labelledby="haveLossModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="haveLossModalWorkersCompLabel">Have Losses Questionare</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row mb-3">
                        <div class="col-12">
                            <select name="" id="dataOptionDropdownWorkersComp" class="form-select">
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
                            <input class="form-control" type="date" value="2011-08-19"
                                id="monthDayYearWorkersComp" hidden>
                            <input class="form-control" type="month" value="2020-03" id="monthDateYearWorkersComp"
                                hidden>
                            <input type="hidden" name="workersCompHiddenInput" id="workersCompHiddenInput" value=2>
                        </div>
                        <div class="col-6">
                            <input class="form-control input-mask text-left" id="amountOfClaims"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
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
        var numberOfEmployee = parseInt(localStorage.getItem('fullTimeEmployee')) + parseInt(localStorage
            .getItem('partTimeEmployee'));
        var classCodePerEmployeeContainer = document.getElementById('classCodePerEmployeeDiv');
        $('#grossReceiptExcessLiability').val(localStorage.getItem('grossReceipt'));
        $('#employeePayrollExcessLiability').val(localStorage.getItem('employeePayroll'));
        $('#numberOfEmployee').val(numberOfEmployee);

        // $('#numberOfEmployeePerClasscode').on('change', function(){
        //     var numberOfEmployeePerClasscode = $(this).val();
        //     var numberOfEmployee = $('#numberOfEmployee').val();
        //     if(numberOfEmployeePerClasscode > numberOfEmployee){
        //         alert('Number of employee per classcode must not be greater than the total number of employee');
        //         var clonedForm = classCodePerEmployeeContainer.firstElementChild.cloneNode(true);
        //         classCodePerEmployeeContainer.appendChild(clonedForm);
        //     }
        // });
        // $('#numberOfEmployeePerClasscode').on('input', function(){
        //     var inputValue = parseInt($(this).val());
        //     if(isNaN(inputValue)){
        //         inputValue = 0;
        //     }

        //     while(inputValue < numberOfEmployee){
        //         var clonedForm = classCodePerEmployeeContainer.firstElementChild.cloneNode(true);
        //         classCodePerEmployeeContainer.appendChild(clonedForm);
        //         inputValue++;
        //     }
        // });

        var employeePayroll = parseFloat(localStorage.getItem('employeePayRoll') ? localStorage.getItem(
            'employeePayRoll').replace(/[^\d. -]/g, '') : '');
        var ownersPayroll = parseFloat(localStorage.getItem('ownersPayroll') ? localStorage.getItem(
            'ownersPayroll').replace(/[^\d. -]/g, '') : '');
        var totalPayroll = employeePayroll + ownersPayroll;
        var formattedPayroll = totalPayroll.toLocaleString('en-US', {
            style: 'currency',
            currency: 'USD'
        });
        var formattedEmployeePayroll = employeePayroll.toLocaleString('en-US', {
            style: 'currency',
            currency: 'USD'
        });

        $('#payrollWorkersComp').val(employeePayroll);

        $('#saveHaveLossWorkersComp').on('click', function() {
            console.log($('#workersCompHiddenInput').val());
            console.log('button for subittion of have loss workers comp');
        });

        $('#haveLossWorkersComp').on('change', function() {
            if ($(this).is(':checked')) {
                $('#haveLossModalWorkersComp').modal('show');
            } else {

            }
        });

        $(document).on('change', '#ownersPayrollIncluded', function() {
            var payrollWorkersComp = $('#payrollWorkersComp');
            if ($(this).val() == 1) {
                payrollWorkersComp.val(formattedEmployeePayroll);
            } else {
                payrollWorkersComp.val(formattedPayroll);
            }
        });

        $('#dataOptionDropdownWorkersComp').on('change', function() {
            if ($(this).val() == 1) {
                $('#monthDateYearWorkersComp').removeAttr('hidden');
                $('#monthDayYearWorkersComp').attr('hidden', true);
            }
            if ($(this).val() == 2) {
                $('#monthDayYearWorkersComp').removeAttr('hidden');
                $('#monthDateYearWorkersComp').attr('hidden', true);
            }
        });

        $('#fein').on('input', function(e) {
            var feinValue = $(this).val();
            localStorage.setItem('fein', feinValue);
        });


        $('#ssn').on('input', function(e) {
            var ssnValue = $(this).val();
            localStorage.setItem('ssn', ssnValue);
        });

        $('#fein').val(localStorage.getItem('fein'));
        $('#ssn').val(localStorage.getItem('ssn'));

        function calculateEmployeeSum() {
            var sum = 0;
            $('.percentageInputEmployee').each(function() {
                sum += parseInt($(this).val());
            });
            return sum;
        }

        function addNewInput() {
            $('#addtionalClasssCodePerEmployeeInput').append(`
                <div class="row mb-3">
                    <div class="col-8">
                      <label class="form-label">Employee Description</label>
                      <input class="form-control" type="text" placeholder="Employee Functionality" id="EmployeeFunctionality">
                    </div>
                    <div class="col-3">
                        <label class="form-label">Number of Employee</label>
                        <input class="form-control percentageInputEmployee" type="number" value="10" id="numberOfEmployeePerClasscode" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>
                    <div class="col-1">
                      <button class="btn btn-danger remove-input-employee mt-4" style="margin-left: 10px;">Remove</button>
                    </div>
                </div>
            `);
        }

        $(document).on('click', '.remove-input-employee', function() {
            $(this).closest('.row').remove();
        });

        $(document).on('change', '.percentageInputEmployee', function() {
            if (calculateEmployeeSum() < numberOfEmployee) {
                addNewInput();
            } else {
                alert(
                    'Number of employee per classcode must not be greater than the total number of employee'
                );
            }
        });

        //create a appending script if the input variable on numberOfEmployeePerClasscode is not equal to the numberOfEmployee

        // for(var i = 0; i < numberOfEmployee; i++){
        //     var clonedForm = classCodePerEmployeeContainer.firstElementChild.cloneNode(true);
        //     classCodePerEmployeeContainer.appendChild(clonedForm);
        // }

    });
</script>
