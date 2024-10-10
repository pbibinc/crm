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
                            <label for="paymentTypeLabel">Payment Type</label>
                            <select name="paymentType" id="paymentType" class="form-control">
                                <option value="">Select Payment Type</option>
                                <option value="Endorsement">Endorsement</option>
                                <option value="Audit">Audit</option>
                                <option value="CCN">CCN</option>
                                <option value="Reinstate">Reinstate</option>
                                <option value="Monthly Payment">Monthly Payment</option>
                                <option value="Direct New">Direct New</option>
                                <option value="Direct Renewals">Direct Renewals</option>
                            </select>
                        </div>
                        <div class="col-6" id="insuranceComplianceByDiv">
                            <label for="insuranceCompliance">Broker:</label>
                            <select name="insuranceCompliance" id="insuranceCompliance" class="form-control">
                                <option value="">Select Broker</option>
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
                    <div class="row mb-5" id="effectiveDateDiv">
                        <div class="col-6">
                            <label for="effectiveDate">Effective Date</label>
                            <input type="date" class="form-control" id="makePaymentEffectiveDate"
                                name="makePaymentEffectiveDate" required>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-6" id="paymentTermDiv">
                            <label for="paymentTerm">Payment Term</label>
                            <select name="paymentTerm" id="paymentTerm" class="form-control">
                                <option value="">Select Payment Method</option>
                                <option value="PIF">PIF</option>
                                <option value="Low down">Low down</option>
                                <option value="Split PIF">Split PIF</option>
                                <option value="Split low down">Split low down</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="paymentMethod">Payment Method</label>
                            <select name="paymentMethod" id="paymentMethodMakePayment" class="form-control">
                                <option value="">Select Payment Method</option>
                                <option value="Checking">Checking</option>
                                <option value="Credit Card">Credit Card</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="cardType" id="cardTypeLabel" hidden>Card Type</label>
                            <select name="cardType" id="cardType" class="form-control" hidden>
                                <option value="">Select Card Type</option>
                                <option value="Visa">Visa</option>
                                <option value="Master Card">Master Card</option>
                                <option value="American Express">American Express</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="otherCard" id="otherCardLabel" hidden>Input Card Type</label>
                            <input type="text" name="otherCard" class="form-control" id="otherCard" hidden>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">

                        </div>
                        <div class="col-6">

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6" id="totaltPremiumDiv">
                            <label for="totalPremium">Total Premium</label>
                            <input type="text" class="form-control" id="totalPremium" name="totalPremium"
                                disabled>
                        </div>
                        <div class="col-6" id="brokerFeeDiv">
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
                    <input type="hidden" name="statusInput" id="statusInput">
                    <input type="hidden" name="quotationProductId" id="quotationProductId">
                    <input type="hidden" name="selectedQuoteId" id="selectedQuoteId">
                    <input type="hidden" name="policyDetailId" id="policyDetailId">
                    <input type="hidden" name="paymentInformationAction" id="paymentInformationAction">
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
        $('#paymentType').on('change', function() {
            var paymentType = $(this).val();

            // Use the correct variable `paymentType` inside the condition
            if (paymentType == 'Monthly Payment' || paymentType == 'Audit') {
                $('#totaltPremiumDiv').attr('hidden', true);
                $('#brokerFeeDiv').attr('hidden', true);
                $('#paymentTermDiv').attr('hidden', true);
                $('#effectiveDateDiv').attr('hidden', true);
                $('#insuranceComplianceByDiv').attr('hidden', true);
                $('#insuranceCompliance').attr('required', false);
                $('#paymentTerm').attr('required', false);
                $('#makePaymentEffectiveDate').attr('required', false);
                $('#totalPremium').val('required', false);
                $('#brokerFeeAmount').val('required', false);
                $('#insuranceCompliance').val('');
                $('#paymentTerm').val('');
            } else {
                $('#totaltPremiumDiv').attr('hidden', false);
                $('#brokerFeeDiv').attr('hidden', false);
                $('#paymentTermDiv').attr('hidden', false);
                $('#effectiveDateDiv').attr('hidden', false);
                $('#insuranceComplianceByDiv').attr('hidden', false);
            }
        });

        $('#selectedQuoteDropdown').on('change', function() {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('selected-quote.edit', ':id') }}".replace(':id', id),
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response);
                    $('#quotationProductId').val(response.quotationProductId);
                    $('#selectedQuoteId').val(response.data.id);
                    $('#market').val(response.market.name);
                    $('#quoteNumber').val(response.data.quote_no);
                    $('#quoteComparisonId').val(response.data.id);

                    $('#paymentTerm').val('PIF');
                },
                error: function(jqXHR, xhr, status, error) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Something Went Wrong',
                        icon: 'error'
                    });
                }
            });
        });

        $('#cardType').on('change', function() {
            if ($(this).val() == 'Other') {
                $('#otherCardLabel').attr('hidden', false);
                $('#otherCard').attr('hidden', false);
            } else {
                $('#otherCardLabel').attr('hidden', true);
                $('#otherCard').attr('hidden', true);
            }
        });

        $('#paymentMethodMakePayment').on('change', function() {
            if ($(this).val() == 'Credit Card') {
                $('#cardTypeLabel').attr('hidden', false);
                $('#cardType').attr('hidden', false);
            } else {
                $('#cardType').attr('hidden', true);
                $('#cardTypeLabel').attr('hidden', true);
                $('#otherCardLabel').attr('hidden', true);
                $('#otherCard').attr('hidden', true);
            }
        });

        $('#makePaymentForm').on('submit', function(e) {
            e.preventDefault();

            var button = $('#savePaymentInformation');
            var status = $('#statusInput').val();
            var productId = $('#quotationProductId').val();
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
                    if (status == 13) {
                        $.ajax({
                            type: "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            url: "{{ route('change-quotation-status') }}",
                            data: {
                                id: productId,
                                status: 16,
                            },
                            success: function(response) {
                                laddaButton.stop();
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Payment Information Re Send Successfully',
                                    icon: 'success'
                                }).then(function() {
                                    $('#makePaymentModal').modal(
                                        'hide');
                                    $('#accountingTable').DataTable()
                                        .ajax.reload();
                                    // location.reload();
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
                    } else {
                        laddaButton.stop();
                        Swal.fire({
                            title: 'Success',
                            text: 'Payment Information Saved Successfully',
                            icon: 'success'
                        }).then(function() {
                            $('#makePaymentModal').modal('hide');
                            location.reload();
                        });
                    }

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
        });

        $('#makePaymentModal').on('hide-bs-modal', function() {
            $('#makePaymentForm').trigger('reset');
        });

        // $('#savePaymentInformation').on('click', function() {
        //     console.log('clicked');
        // });

    });
</script>
