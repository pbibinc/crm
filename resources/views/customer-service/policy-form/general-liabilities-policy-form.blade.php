<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="generalLiabilitiesPolicyForm">
    <div class="modal-dialog modal-dialog-centered modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">General Liabilities Policy Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-6">
                        <label class="form-label" for="policyNumber">Policy Number</label>
                        <input type="text" class="form-control" id="policyNumber" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="insuredInput">Insured</label>
                        <input type="text" class="form-control" id="insuredInput" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <label class="form-label" for="carriersInput">Carriers</label>
                        <input type="text" class="form-control" id="carriersInput" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="insurerInput">Insurer</label>
                        <input type="text" class="form-control" id="insurerInput" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label class="form-label">Commercial GL</label>
                        <div class="square-switch">
                            <input type="checkbox" id="commercialGl" switch="info">
                            <label for="commercialGl" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                    <div class="col-3">
                        <label class="form-label">Claims Made</label>
                        <div class="square-switch">
                            <input type="checkbox" id="claimsMade" switch="info">
                            <label for="claimsMade" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                    <div class="col-3">
                        <label class="form-label">Occur</label>
                        <div class="square-switch">
                            <input type="checkbox" id="occur" switch="info">
                            <label for="occur" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                    <div class="col-3">
                        <label class="form-label">Policy</label>
                        <div class="square-switch">
                            <input type="checkbox" id="policy" switch="info">
                            <label for="policy" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3">
                        <label class="form-label">Project</label>
                        <div class="square-switch">
                            <input type="checkbox" id="project" switch="info">
                            <label for="project" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                    <div class="col-3">
                        <label class="form-label">Loc</label>
                        <div class="square-switch">
                            <input type="checkbox" id="loc" switch="info">
                            <label for="loc" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                    <div class="col-3">
                        <label class="form-label">Addl Insd</label>
                        <div class="square-switch">
                            <input type="checkbox" id="addlInsd" switch="info">
                            <label for="addlInsd" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                    <div class="col-3">
                        <label class="form-label">Subr Wvd</label>
                        <div class="square-switch">
                            <input type="checkbox" id="subrWvd" switch="info">
                            <label for="subrWvd" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <label class="form-label" for="eachOccurence">Each Occurence</label>
                        <input type="text" class="form-control" id="eachOccurence">
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="rentedDmg">DMG To Rented</label>
                        <input type="text" class="form-control" id="rentedDmg">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <label class="form-label" for="medExp">Med Exp</label>
                        <input type="text" class="form-control" id="medExp">
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="perAdvInjury">Per & Adv Injury</label>
                        <input type="text" class="form-control" id="perAdvInjury">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <label class="form-label" for="genAggregate">Gen Aggregate</label>
                        <input type="text" class="form-control" id="genAggregate">
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="medExp">Comp/OP</label>
                        <input type="text" class="form-control" id="comp">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <label class="form-label" for="effectiveDate">Effective Date</label>
                        <input class="form-control" type="date" value="2011-08-19" id="effectiveDate">
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="expirationDate">Expiration Date</label>
                        <input class="form-control" type="date" value="2011-08-19" id="expirationDate">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label class="form-label" for="expirationDate">Attached File <i
                                class="ri-attachment-line"></i></label>
                        <input type="file" class="form-control" id="attachedFile">
                    </div>
                </div>
                <input type="hidden" id="hiddenInputId">
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-success waves-effect waves-light saveGeneralLiabilitiesPolicyForm"
                    id="saveGeneralLiabilitiesPolicyForm" type="submit">Save</button>
                <button type="button" class="btn btn-secondary waves-effect waves-light"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#effectiveDate').on('change', function() {
            var effectiveDate = new Date($(this).val());
            var expirationDate = new Date(effectiveDate);

            expirationDate.setFullYear(effectiveDate.getFullYear() + 1);

            var formattedExpirationDate = expirationDate.toISOString().split('T')[0];

            $('#expirationDate').val(formattedExpirationDate);
        });
        $('#saveGeneralLiabilitiesPolicyForm').on('click', function(e) {
            e.preventDefault();
            var formData = {
                policyNumber: $('#policyNumber').val(),
                insured: $('#insuredInput').val(),
                carriers: $('#carriersInput').val(),
                insurer: $('#insurerInput').val(),
                commercialGl: $('#commercialGl').prop('checked'),
                claimsMade: $('#claimsMade').prop('checked'),
                occur: $('#occur').prop('checked'),
                policy: $('#policy').prop('checked'),
                project: $('#project').prop('checked'),
                loc: $('#loc').prop('checked'),
                addlInsdL: $('#addlInsd').prop('checked'),
                subrWvd: $('#subrWvd').prop('checked'),
                eachOccurence: $('#eachOccurence').val(),
                rentedDmg: $('#rentedDmg').val(),
                eachOccurence: $('#eachOccurence').val(),
                rentedDmg: $('#rentedDmg').val(),
                medExp: $('#medExp').val(),
                perAdvInjury: $('#perAdvInjury').val(),
                genAggregate: $('#genAggregate').val(),
                comp: $('#comp').val(),
                effectiveDate: $('#effectiveDate').val(),
                expirationDate: $('#expirationDate').val(),
                attachedFile: $('#attachedFile').val(),
            };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('binding.save-general-liabilities-policy') }}",
                data: formData,
                dataType: "json",
                success: function(data) {
                    alert(data.success);
                }
            })
        });
    });
</script>
