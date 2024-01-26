<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="commercialAutoPolicyForm">
    <div class="modal-dialog modal-dialog-centered modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Commercial Auto Policy Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="commercialAutoForm">
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="policyNumber">Policy Number</label>
                            <input type="text" class="form-control" id="policyNumber">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="insuredInput">Insured</label>
                            <input type="text" class="form-control" id="insuredInput">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="carriersInput">Carriers</label>
                            <input type="text" class="form-control" id="carriersInput">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="insurerInput">Insurer</label>
                            <input type="text" class="form-control" id="insurerInput">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3">
                            <label class="form-label">Any Auto</label>
                            <div class="square-switch">
                                <input type="checkbox" id="anyAuto" switch="info">
                                <label for="anyAuto" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                        <div class="col-3">
                            <label class="form-label">Owned Autos Only</label>
                            <div class="square-switch">
                                <input type="checkbox" id="ownedAuto" switch="info">
                                <label for="ownedAuto" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                        <div class="col-3">
                            <label class="form-label">Scheduled Auto</label>
                            <div class="square-switch">
                                <input type="checkbox" id="scheduledAuto" switch="info">
                                <label for="scheduledAuto" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                        <div class="col-3">
                            <label class="form-label">Hired Autos Only</label>
                            <div class="square-switch">
                                <input type="checkbox" id="hiredAutos" switch="info">
                                <label for="hiredAutos" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-4">
                            <label class="form-label">Non-Owned Autos</label>
                            <div class="square-switch">
                                <input type="checkbox" id="nonOwned" switch="info">
                                <label for="nonOwned" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Addl Insd:</label>
                            <div class="square-switch">
                                <input type="checkbox" id="addlInsd" switch="info">
                                <label for="addlInsd" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Subr Wvd:</label>
                            <div class="square-switch">
                                <input type="checkbox" id="subrWvd" switch="info">
                                <label for="subrWvd" data-on-label="Yes" data-off-label="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="biPerPerson">BI per Person</label>
                            <input type="text" class="form-control" id="biPerPerson">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="biPerAccident">BI per accident</label>
                            <input type="text" class="form-control" id="biPerAccident">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="combineUnit">Combine S Unit</label>
                            <input type="text" class="form-control" id="combineUnit">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="combineUnit">Property Damage</label>
                            <input type="text" class="form-control" id="combineUnit">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="blankLimits">Blank Limits</label>
                            <input type="text" class="form-control" id="blankLimits">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="blankValue">Blank Value</label>
                            <input type="text" class="form-control" id="blankValue">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label" for="commercialAutoEffectiveDate">Effective Date</label>
                            <input class="form-control" type="date" value="2011-08-19"
                                id="commercialAutoEffectiveDate">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="expirationDate">Expiration Date</label>
                            <input class="form-control" type="date" value="2011-08-19"
                                id="commercialAutoExpirationDate">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" value="Add"
                    class="btn btn-primary ladda-button" data-style="expand-right">
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('#commercialAutoEffectiveDate').on('change', function() {
            var effectiveDate = new Date($(this).val());
            var expirationDate = new Date(effectiveDate);

            expirationDate.setFullYear(effectiveDate.getFullYear() + 1);
            var formattedExpirationDate = expirationDate.toISOString().split('T')[0];
            $('#commercialAutoExpirationDate').val(formattedExpirationDate);
        });

        $('#commercialAutoForm').on('submit', function(e) {
            e.preventDefault();
            console.log($(this).serialize());
        });
    });
</script>
