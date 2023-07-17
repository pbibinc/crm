<div class="tab-pane" id="excess-liability-1" role="tabpanel">

    <div class="row mb-3">
        <div class="col-6">
            <label for="" class="form-label">Excess Limits</label>
            <select name="" id="" class="form-select">
                <option value=1000000>$1,000,000</option>
                <option value=2000000>$2,000,000</option>
                <option value=3000000>$3,000,000</option>
                <option value=4000000>$4,000,000</option>
                <option value=5000000>$5,000,000</option>
                <option value=6000000>$6,000,000</option>
                <option value=7000000>$7,000,000</option>
                <option value=8000000>$8,000,000</option>
                <option value=9000000>$9,000,000</option>
                <option value=10000000>$10,000,000</option>
            </select>
        </div>
        <div class="col-6">
            <label for="" class="form-label">Excess Effective Date</label>
            <input type="date" class="form-control" name="excessEffectiveDate" id="excessEffectiveDate" placeholder="Date of Birth">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-4">
            <label for="" class="form-label">Insurance Carrier</label>
            <input type="text" class="form-control" name="insuranceCarrier" id="insuranceCarrier" placeholder="">
        </div>
        <div class="col-4">
            <label for="" class="form-label">Policy No./ Quote No.</label>
            <input type="text" class="form-control" name="policyNumber" id="policyNumber" placeholder="">
        </div>
        <div class="col-4">
            <label for="" class="form-label">Policy Premium</label>
            <input class="form-control input-mask text-left" name="policyPremium" id="policyPremium" onkeypress="return event.charCode >= 48 && event.charCode <= 57" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col-6">
            <label for="" class="form-label">General Libiality Effective Date</label>
            <input type="date" class="form-control" name="generalLiabilityEffectiveDate" id="generalLiabilityEffectiveDate" placeholder="Date of Birth">
        </div>
        <div class="col-6">
            <label for="" class="form-label">General Liability Expiration Date</label>
            <input type="date" class="form-control" name="generalLiabilityExpirationDate" id="generalLiabilityExpirationDate" placeholder="">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <label for="" class="form-label">Call Back</label>
            <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="excessLiabilityCallback">
        </div>
        <div class="col-6">
            <label for="" class="form-label">Cross Sell</label>
            <input class="form-control" type="text" id="excessLiabilityCrossSell" placeholder="Cross Sell">
        </div>
    </div>

    <div class="row">
        <label class="form-label">Remarks</label>
        <div>
           <textarea name="" id="remarks"  rows="5" class="form-control"></textarea>
        </div>
    </div>

</div>

<script>
    $(document).ready(function(){
        $('#generalLiabilityEffectiveDate').on('change', function(){
            var effectiveDate = $(this).val();

             // Convert the effective date string to a Date object
            var effectiveDateObj = new Date(effectiveDate);

            // Calculate the expiration date by adding one year to the effective date
            var expirationDateObj = new Date(effectiveDateObj.getFullYear() + 1, effectiveDateObj.getMonth(), effectiveDateObj.getDate());
            
             // Format the expiration date as "YYYY-MM-DD" for setting the input value
             var expirationDate = expirationDateObj.toISOString().split('T')[0]
       
            // Set the expiration date input value
            $('#generalLiabilityExpirationDate').val(expirationDate);

        });
    })
</script>