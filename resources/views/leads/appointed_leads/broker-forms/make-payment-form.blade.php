<div class="modal fade bs-example-modal-center" id="makePaymentModal" tabindex="-1" role="dialog"
    aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="makePaymentModalTitle">Make A Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="makePaymentForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="paymentType">Payment Type</label>
                            <select name="paymentType" id="paymentType" class="form-control">
                                <option value="">Select Payment Type</option>
                                <option value="Endorsement">Endorsement</option>
                                <option value="Audit">Audit</option>
                                <option value="Monthly Payment">Monthly Payment</option>
                                <option value="Direct New">Direct New</option>
                                <option value="Direct Renewals">Direct Renewals</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="insuranceCompliance">Insurance Compliance By:</label>
                            <select name="insuranceCompliance" id="insuranceCompliance" class="form-control">
                                <option value="">Select Compliance Officer</option>
                                @foreach ($complianceOfficer as $officer)
                                    <option value="{{ $officer->fullName() }}">{{ $officer->fullName() }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="market">Market</label>
                            <input type="text" name="market" id="market" class="form-control" disabled>
                        </div>
                        <div class="col-6">
                            <label for="quoteNo">Quote No/App No/Policy No:</label>
                            <input type="text" class="form-control" id="quoteNumber" name="quoteNumber" required
                                required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="insuredName">Insured First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" required>
                        </div>
                        <div class="col-6">
                            <label for="insuredName">Insured Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="companyName">DBA</label>
                            <input type="text" name="companyName" id="companyName" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label for="emailAddress">Email Address</label>
                            <input type="text" class="form-control" id="emailAddress" name="emailAddress" required>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-6">
                            <label for="effectiveDate">Effective Date</label>
                            <input type="date" class="form-control" id="makePaymentEffectiveDate"
                                name="makePaymentEffectiveDate" required>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="paymentMethod">Payment Method</label>
                            <select name="paymentMethod" id="paymentMethod" class="form-control">
                                <option value="">Select Payment Method</option>
                                <option value="PIF">PIF</option>
                                <option value="Low down">Low down</option>
                                <option value="Split PIF">Split PIF</option>
                                <option value="Split low down">Split low down</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="cardType">Card Type</label>
                            <select name="cardType" id="cardType" class="form-control">
                                <option value="">Select Card Type</option>
                                <option value="Visa">Visa</option>
                                <option value="Master Card">Master Card</option>
                                <option value="American Express">American Express</option>
                                <option value="Discover">Discover</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">

                        </div>
                        <div class="col-6">
                            <label for="otherCardType" id="otherCardTypeLabel" hidden>Input Card Type</label>
                            <input type="text" name="otherCardType" class="form-control" id="otherCardType"
                                hidden>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="totalPremium">Total Premium</label>
                            <input type="text" class="form-control" id="totalPremium" name="totalPremium"
                                disabled>
                        </div>
                        <div class="col-6">
                            <label for="brokerFeeAmount">Broker Fee</label>
                            <input type="text" class="form-control" id="brokerFeeAmount" name="brokerFeeAmount"
                                disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="chargedAmount">Amount To Be Charged</label>
                            <input type="text" class="form-control input-mask text-left" id="chargedAmount"
                                name="chargedAmount"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="note">Note</label>
                            <textarea name="note" id="note" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>

                    <input type="hidden" id="quoteComparisonId" name="quoteComparisonId">
                    <input type="hidden" id="leadsId" name="leadsId">
                    <input type="hidden" id="generalInformationId" name="generalInformationId">
                    <input type="hidden" name="paymentInformationId" id="paymentInformationId">

            </div>
            <div class="modal-footer">
                <input type="submit" name="savePaymentInformation" id="savePaymentInformation"
                    value="Request A Payment" class="btn btn-success ladda-button" data-style="expand-right">
                <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script>
    $(document).ready(function() {
        $('#cardType').on('change', function() {
            if ($(this).val() == 'Other') {
                $('#otherCardType').attr('hidden', false);
                $('#otherCardTypeLabel').attr('hidden', false);
            } else {
                $('#otherCardType').attr('hidden', true);
                $('#otherCardTypeLabel').attr('hidden', true);
            }
        })

        $('#makePaymentForm').on('submit', function(e) {
            e.preventDefault();
            var button = $('#savePaymentInformation');
            var laddaButton = Ladda.create(button[0]);
            laddaButton.start();
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                url: "{{ route('save-payment-information') }}",
                data: $(this).serialize(),
                success: function(response) {
                    laddaButton.stop();
                    Swal.fire({
                        title: 'Success',
                        text: 'Payment Information Saved Successfully',
                        icon: 'success'
                    }).then(function() {
                        $('#makePaymentModal').modal('hide');
                        location.reload();
                    });
                },
                error: function(jqXHR, xhr, status, error) {
                    laddaButton.stop();
                    Swal.fire({
                        title: 'Error',
                        text: 'Something Went Wrong',
                        icon: 'error'
                    });
                }

            })
        })
    });
</script>