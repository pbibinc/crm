<div class="modal fade" id="renewalDataModal" tabindex="-1" aria-labelledby="renewalDataModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="renewalDataModalTitle">Renewal Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="renewQuoteForm">
                @csrf
                <div class="modal-body">

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="marketDropdown">Market</label>
                            <input type="text" name="market" id="market" class="form-control">
                        </div>
                        <div class="col-6">
                            <label for="quoteNo" class="form-label">Policy No/Quote No:</label>
                            <input type="text" class="form-control" id="quoteNo" name="quoteNo" required>
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="premium">Premium</label>
                            <input type="text" class="form-control calculateInput input-mask text-left"
                                id="premium" name="premium"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="endorsements">Endorsements</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="endorsements" name="endorsements"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="policyFee">Policy Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="policyFee" name="policyFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="inspectionFee">Inspection Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="inspectionFee" name="inspectionFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="stampingFee">Stamping Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="stampingFee" name="stampingFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="surplusLinesTax">Surplus lines Tax</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="surplusLinesTax" name="surplusLinesTax"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="placementFee">Placement Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="placementFee" name="placementFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="brokerFee">Broker Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="brokerFee" name="brokerFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="miscellaneousFee">Miscellaneous Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="miscellaneousFee" name="miscellaneousFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="fullPayment" class="form-label">Full Payment</label>
                            <input type="text" class="form-control input-mask text-left"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" id="fullPayment" name="fullPayment"
                                required readonly>
                        </div>
                        <div class="col-6">
                            <label for="downPayment" class="form-label">Down Payment</label>
                            <input type="text" class="form-control input-mask text-left" id="downPayment"
                                name="downPayment"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="monthlyPayment" class="form-label">Monthly Payment</label>
                            <input type="text" class="form-control input-mask text-left" id="monthlyPayment"
                                name="monthlyPayment"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="numberOfPayment" class="form-label">Number of Paymment</label>
                            <input type="number" class="form-control" id="numberOfPayment" name="numberOfPayment">
                        </div>

                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="effectiveDate">Effective Date</label>
                            <input type="date" class="form-control" id="effectiveDate" name="effectiveDate"
                                required>
                        </div>
                    </div>

                    <div class="row">
                        <div>
                            <label for="medias" id="mediaLabelId">Attached File</label>
                            <input type="file" class="form-control" name="photos[]" id="medias" multiple />
                        </div>
                    </div>
                    {{-- <input type="hidden" name="action" id="action" value="add">
                    <input type="hidden" name="product_hidden_id" id="product_hidden_id" />
                    <input type="hidden" name="productId" id="productId" value="{{ $quoteProduct->id }}">
                    <input type="hidden" name="recommended" id="recommended_hidden" value="0" />
                    <input type="hidden" name="currentMarketId" id="currentMarketId">
                    <input type="hidden" name="sender" id="sender" value="marketSpecialist"> --}}


                </div>
                <div class="modal-footer">

                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="policyCancellationModal" tabindex="-1" aria-labelledby="policyCancellationModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="policyCancellationModalTitle">Cancellation Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="cancellationForm">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="typeOfCancellationDropdown">Type of Cancellation:</label>
                            <select name="typeOfCancellationDropdown" id="typeOfCancellationDropdown"
                                class="form-select">
                                <option value="">Select Type of Cancellation</option>
                                <option value="Requested by Customer">Requested by Customer</option>
                                <option value="Non-Payment">Non-Payment</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="">Is Intent:</label>
                            <div class="form-check form-switch mb-3" dir="ltr">
                                <input type="checkbox" class="form-check-input" id="isIntent">

                            </div>
                        </div>

                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="" id="reinstatedDateLabel" hidden>Reinstated Date</label>
                            <input type="date" class="form-control" name="reinstatedDate" hidden>
                        </div>
                        <div class="col-6">
                            <label for="" id="reinstatedEligibilityDateLabel" hidden>Reinstated Eligibility
                                Date</label>
                            <input type="date" class="form-control" name="reinstatedEligibilityDate" hidden>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="">Agent Remarks:</label>
                        <div>
                            <textarea name="agentRemakrs" id="agentRemakrs" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <label for="">Recovery Action:</label>
                        <div>
                            <textarea name="recoveryAction" id="recoveryAction" cols="30" rows="5" class="form-control"></textarea>
                        </div>

                    </div>
                    <input type="hidden" name="policyId" id="policyId">
                    <input type="hidden" name="intent" id="intent">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-success waves-effect waves-light" id=""
                        value="Submit">
            </form>
        </div>
    </div>
</div>
