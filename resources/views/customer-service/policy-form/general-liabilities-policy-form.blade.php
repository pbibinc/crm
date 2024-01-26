<div class="modal fade" tabindex="-1" aria-labelledby="generalLiabilitiesPolicyForm" aria-hidden="true"
    id="generalLiabilitiesPolicyForm">
    <div class="modal-dialog modal-dialog-centered modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">General Liabilities Policy Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="generalLiabilitiesForm" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="policyNumber">Policy Number</label>
                                <input type="text" class="form-control" id="policyNumber" name="policyNumber"
                                    required>
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="insuredInput">Insured</label>
                                <input type="text" class="form-control" id="insuredInput" name="insuredInput"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="carriersInput">Carriers</label>
                                <input type="text" class="form-control" id="carriersInput" name="carriersInput"
                                    required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="insurerInput">Insurer</label>
                                <input type="text" class="form-control" id="insurerInput" name="insurerInput"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="paymentMethod">Payment Method</label>
                                <select class="form-select" aria-label="Default select example" id="paymentModeInput"
                                    name="paymentModeInput">
                                    <option selected="">Open this select menu</option>
                                    <option value="PIF">PIF</option>
                                    <option value="Low down">Low down</option>
                                    <option value="Split PIF">Split PIF</option>
                                    <option value="Split low down">Split low down</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label">Commercial GL</label>
                                <div class="square-switch">
                                    <input type="checkbox" id="commercialGl" switch="info" name="commercialGl">
                                    <label for="commercialGl" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label">Claims Made</label>
                                <div class="square-switch">
                                    <input type="checkbox" id="claimsMade" switch="info" name="claimsMade">
                                    <label for="claimsMade" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label">Occur</label>
                                <div class="square-switch">
                                    <input type="checkbox" id="occur" switch="info" name="occur">
                                    <label for="occur" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label">Policy</label>
                                <div class="square-switch">
                                    <input type="checkbox" id="policy" switch="info" name="policy">
                                    <label for="policy" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label">Project</label>
                                <div class="square-switch">
                                    <input type="checkbox" id="project" switch="info" name="project">
                                    <label for="project" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>

                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label">Loc</label>
                                <div class="square-switch">
                                    <input type="checkbox" id="loc" switch="info" name="loc">
                                    <label for="loc" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label">Addl Insd</label>
                                <div class="square-switch">
                                    <input type="checkbox" id="addlInsd" switch="info" name="addlInsd">
                                    <label for="addlInsd" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>

                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label">Subr Wvd</label>
                                <div class="square-switch">
                                    <input type="checkbox" id="subrWvd" switch="info" name="subrWvd">
                                    <label for="subrWvd" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="eachOccurence">Each Occurence</label>
                                <input type="text" class="form-control" id="eachOccurence" name="eachOccurence">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="rentedDmg">DMG To Rented</label>
                                <input type="text" class="form-control" id="rentedDmg" name="rentedDmg">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="medExp">Med Exp</label>
                                <input type="text" class="form-control" id="medExp" name="medExp">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="perAdvInjury">Per & Adv Injury</label>
                                <input type="text" class="form-control" id="perAdvInjury" name="perAdvInjury">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="genAggregate">Gen Aggregate</label>
                                <input type="text" class="form-control" id="genAggregate" name="genAggregate">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="medExp">Comp/OP</label>
                                <input type="text" class="form-control" id="comp" name="comp">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="effectiveDate">Effective Date</label>
                                <input class="form-control" type="date" value="2011-08-19" id="effectiveDate"
                                    name="effectiveDate">
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="expirationDate">Expiration Date</label>
                                <input class="form-control" type="date" value="2011-08-19" id="expirationDate"
                                    name="expirationDate">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="expirationDate">Attached File <i
                                        class="ri-attachment-line"></i></label>
                                <input type="file" class="form-control" id="attachedFile" name="attachedFile">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="statusDropdowm">Status</label>
                                <select class="form-select" aria-label="Default select example" id="statusDropdowm"
                                    name="statusDropdowm">
                                    <option selected="">Open this select menu</option>
                                    <option value="Cancelled">Cancelled</option>
                                    <option value="Declined">Declined</option>
                                    <option value="Endorsing">Endorsing</option>
                                    <option value="Issued">Issued</option>
                                    <option value="Notice Of Cancellation">Notice Of Cancellation</option>
                                    <option value="Renewal Issued">Renewal Issued</option>
                                    <option value="Renewal Notice of Cancellation">Renewal Notice of Cancellation
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="hiddenInputId" name="hiddenInputId">
                </div>
                <div class="modal-footer">
                    <input type="submit" name="saveGeneralLiabilitiesPolicyForm"
                        id="saveGeneralLiabilitiesPolicyForm" value="Save" class="btn btn-success ladda-button"
                        data-style="expand-right">
                    <button type="button" class="btn btn-secondary waves-effect waves-light"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </form>
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
        $('#generalLiabilitiesForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            // formData.append('media', $('#attachedFile')[0].files[0]);
            $.ajax({
                url: "{{ route('binding.save-general-liabilities-policy') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false,
                dataType: "json",
                success: function(data) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'General Liabilities Policy Form has been saved.',
                        icon: 'success',
                    }).then(function() {
                        $('#generalLiabilitiesPolicyForm').modal('hide');
                        $('.getConfimedProductTable').DataTable().ajax.reload();
                    });
                },
                error: function(data) {
                    alert('error');
                }
            });
        });
    });
</script>
