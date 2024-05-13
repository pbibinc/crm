<div class="modal fade " id="editSelectedQuoteModal" tabindex="-1" aria-labelledby="editQuoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuoteModalLabel">Edit Quote</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="selectedQuoteForm" enctype="multipart/form-data">
                <div class="modal-body">

                    @csrf
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="selectedMarketDropdown">Market</label>
                            <select name="selectedMarketDropdown" id="selectedMarketDropdown" class="form-select">
                                <option value="">Select Market</option>
                                @foreach ($quationMarket as $market)
                                    <option value={{ $market->id }}>{{ $market->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="selectedQuoteNo" class="form-label">Policy No/Quote No:</label>
                            <input type="text" class="form-control" id="selectedQuoteNo" name="selectedQuoteNo"
                                required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="selectedPremium">premium</label>
                            <input type="text" class="form-control calculateInput input-mask text-left"
                                id="selectedPremium" name="selectedPremium"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="selectedEndorsements">endorsements</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="selectedEndorsements" name="selectedEndorsements"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="selectedPolicyFee">Policy Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="selectedPolicyFee" name="selectedPolicyFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="selectedInspectionFee">Inspection Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="selectedInspectionFee" name="selectedInspectionFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="selectedStampingFee">Stamping Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="selectedStampingFee" name="selectedStampingFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="selectedSurplusLinesTax">Surplus lines Tax</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="selectedSurplusLinesTax" name="selectedSurplusLinesTax"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="selectedPlacementFee">Placement Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="selectedPlacementFee" name="selectedPlacementFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="selectedBrokerFee">Broker Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="selectedBrokerFee" name="selectedBrokerFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="selectedMiscellaneousFee">Miscellaneous Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="selectedMiscellaneousFee" name="selectedMiscellaneousFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="selectedFullPayment" class="form-label">Full Payment</label>
                            <input type="text" class="form-control input-mask text-left"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" id="selectedFullPayment"
                                name="selectedFullPayment" required readonly>
                        </div>
                        <div class="col-6">
                            <label for="selectedDownPayment" class="form-label">Down Payment</label>
                            <input type="text" class="form-control input-mask text-left" id="selectedDownPayment"
                                name="selectedDownPayment"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="selectedMonthlyPayment" class="form-label">Monthly Payment</label>
                            <input type="text" class="form-control input-mask text-left"
                                id="selectedMonthlyPayment" name="selectedMonthlyPayment"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="selectedNumberOfPayment" class="form-label">Number of Paymment</label>
                            <input type="number" class="form-control" id="selectedNumberOfPayment"
                                name="selectedNumberOfPayment">
                        </div>

                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="selectedEffectiveDate">Effective Date</label>
                            <input type="date" class="form-control" id="selectedEffectiveDate"
                                name="selectedEffectiveDate" required>
                        </div>
                    </div>

                    <div class="row">
                        <div>
                            <label for="medias" id="mediaLabelId">Attached File</label>
                            <input type="file" class="form-control" name="photos[]" id="medias" multiple />
                        </div>
                    </div>
                    <input type="hidden" name="selectedQuoteAction" id="selectedQuoteAction" value="add">
                    <input type="hidden" name="selectedProduct_hidden_id" id="selectedProduct_hidden_id" />
                    <input type="hidden" name="selectedProductId" id="selectedProductId"
                        value="{{ $quoteProduct->id }}">
                    <input type="hidden" name="selectedRecommended" id="selectedRecommended_hidden"
                        value="0" />
                    <input type="hidden" name="selectedCurrentMarketId" id="selectedCurrentMarketId">
                    <input type="hidden" name="selectedSender" id="selectedSender" value="marketSpecialist">
                    <input type="hidden" name="selectedselectedRenewalQuote" id="selectedselectedRenewalQuote"
                        value="false">

                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" class="form-check-input" id="reccomended" checked="">
                        <label class="form-check-label" for="reccomended">Reccomend this Quote</label>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" name="selectedQuoteAction_button" id="selectedQuoteAction_button"
                            value="Add" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#selectedQuoteForm').on('submit', function(e) {
            e.preventDefault();
            var id = "{{ $selectedQuoteId }}";
            var baseUrl = "{{ url('quoatation/selected-quote') }}";
            var url = `${baseUrl}/${id}`;
            var formData = new FormData(this);
            formData.append('selectedQuoteId', id);
            $.ajax({
                url: "{{ route('update-selected-quote') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                processData: false, // Prevent jQuery from processing the data
                contentType: false,
                data: formData,
                dataType: "json",
                success: function(response) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Quotation Comparison has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        $('#editSelectedQuoteModal').modal('hide');
                        location.reload();
                    });
                },
                error: function(data) {
                    var errors = data.responseJSON.errors;
                    console.log(data);
                    if (data.status == 422) {
                        Swal.fire({
                            title: 'Error',
                            text: data.responseJSON.error,
                            icon: 'error'
                        });
                        $('#marketDropdown').addClass('input-error');
                    }
                    if (errors) {
                        $.each(errors, function(key, value) {
                            $('#' + key).addClass('input-error');
                            $('#' + key + '_error').html(value);
                        });
                    }
                }
            });
        })

        //function for parsing
        function parseCurrency(num) {
            if (num === undefined || num === null || num.trim() === "") {
                return 0;
            }
            return parseFloat(num.replace(/[^0-9-.]/g, ''));
        }

        //calculate total premium
        function calculateFullPayment() {
            let premium = parseCurrency($('#selectedPremium').val()) || 0;
            let endorsements = parseCurrency($('#selectedEndorsements').val()) || 0;
            let policyFee = parseCurrency($('#selectedPolicyFee').val()) || 0;
            let inspectionFee = parseCurrency($('#selectedInspectionFee').val()) || 0;
            let stampingFee = parseCurrency($('#selectedStampingFee').val()) || 0;
            let suplusLinesTax = parseCurrency($('#selectedSurplusLinesTax').val()) || 0;
            let placementFee = parseCurrency($('#selectedPlacementFee').val()) || 0;
            let brokerFee = parseCurrency($('#selectedBrokerFee').val()) || 0;
            let miscellaneousFee = parseCurrency($('#selectedMiscellaneousFee').val()) || 0;

            let fullPayment = premium + endorsements + policyFee + inspectionFee + stampingFee +
                suplusLinesTax +
                placementFee + brokerFee + miscellaneousFee;
            $('#selectedFullPayment').val('$ ' + fullPayment.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        }

        $('.calculateInput').on('input', function() {
            calculateFullPayment();
        });


    });
</script>
