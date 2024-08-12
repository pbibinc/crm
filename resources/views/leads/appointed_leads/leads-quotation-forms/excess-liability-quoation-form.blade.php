<style>
    .input-error {
        border: 1px solid red;
        /* or background-color: #ffcccc; for a red background */
    }
</style>


<div class="row mb-2">
    <div class="col-6 title-card">
        <h4 class="card-title mb-0" style="color: #ffffff">Excess Liability Quotattions</h4>
    </div>
    <div class="d-flex justify-content-between">
        <div>

        </div>
        <div>
            <button class="btn btn-success createRecord" id="create_record" data-product='Excess_Liability'> ADD
                QUOTE</button>

            @if ($quoteProduct->status == 2)
                <button href="#" class="btn btn-primary" id="sendQuoteButton">SEND QUOTE</button>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <table id="excessLiabilitytable" class="table table-bordered dt-responsive nowrap"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>Market</th>
                <th>Full Payment</th>
                <th>Down Payment</th>
                <th>Monthly Payment</th>
                <th>Broker Fee</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="modal fade " id="addQuoteModalExcess_Liability" tabindex="-1" aria-labelledby="addQuoteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuoteModalLabel">Add Quotation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="quotationFormExcess_Liability" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="marketDropdownExcess_Liability">Market</label>
                            <select name="marketDropdown" id="marketDropdownExcess_Liability" class="form-select">
                                <option value="">Select Market</option>
                                @foreach ($quationMarket as $market)
                                    <option value={{ $market->id }}>{{ $market->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="quoteNoExcess_Liability" class="form-label">Policy No/Quote No:</label>
                            <input type="text" class="form-control" id="quoteNoExcess_Liability" name="quoteNo"
                                required autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="premium">Premium</label>
                            <input type="text" class="form-control calculateInput input-mask text-left"
                                id="premiumExcess_Liability" name="premium"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="endorsementsExcess_Liability">Endorsements</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="endorsementsExcess_Liability" name="endorsements"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="policyFeeExcess_Liability">Policy Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="policyFeeExcess_Liability" name="policyFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="inspectionFeeExcess_Liability">Inspection Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="inspectionFeeExcess_Liability" name="inspectionFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="stampingFeeExcess_Liability">Stamping Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="stampingFeeExcess_Liability" name="stampingFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="surplusLinesTaxExcess_Liability">Surplus lines Tax</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="surplusLinesTaxExcess_Liability" name="surplusLinesTax"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="placementFeeExcess_Liability">Placement Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="placementFeeExcess_Liability" name="placementFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="brokerFeeExcess_Liability">Broker Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="brokerFeeExcess_Liability" name="brokerFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="miscellaneousFeeExcess_Liability">Miscellaneous Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="miscellaneousFeeExcess_Liability" name="miscellaneousFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="fullPaymentExcess_Liability" class="form-label">Full Payment</label>
                            <input type="text" class="form-control input-mask text-left"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" id="fullPaymentExcess_Liability"
                                name="fullPayment" required readonly>
                        </div>
                        <div class="col-6">
                            <label for="downPaymentExcess_Liability" class="form-label">Down Payment</label>
                            <input type="text" class="form-control input-mask text-left"
                                id="downPaymentExcess_Liability" name="downPayment"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="monthlyPaymentExcess_Liability" class="form-label">Monthly Payment</label>
                            <input type="text" class="form-control input-mask text-left"
                                id="monthlyPaymentExcess_Liability" name="monthlyPayment"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="numberOfPaymentExcess_Liability" class="form-label">Number of
                                Paymment</label>
                            <input type="number" class="form-control" id="numberOfPaymentExcess_Liability"
                                name="numberOfPayment">
                        </div>

                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="effectiveDateExcess_Liability">Effective Date</label>
                            <input type="date" class="form-control" id="effectiveDateExcess_Liability"
                                name="effectiveDate" required>
                        </div>
                    </div>

                    <div class="row">
                        <div>
                            <label for="medias" id="mediaLabelId">Attached File</label>
                            <input type="file" class="form-control" name="photos[]" id="medias" multiple />
                        </div>
                    </div>
                    <input type="hidden" name="action" id="actionExcess_Liability" value="add">
                    <input type="hidden" name="product_hidden_id" id="product_hidden_idExcess_Liability" />
                    <input type="hidden" name="productId" id="productIdExcess_Liability"
                        value="{{ $quoteProduct->id }}">
                    <input type="hidden" name="recommended" id="recommended_hiddenExcess_Liability"
                        value="0" />
                    <input type="hidden" name="currentMarketId" id="currentMarketIdExcess_Liability">
                    <input type="hidden" name="sender" id="senderExcess_Liability" value="marketSpecialist">
                    <input type="hidden" name="renewalQuote" id="renewalQuoteExcess_Liability" value="false">

            </div>
            <div class="modal-footer d-flex justify-content-between">
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" class="form-check-input" id="reccomendedExcess_Liability" checked="">
                    <label class="form-check-label" for="reccomended">Reccomend this Quote</label>
                </div>
                <div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="action_button" id="action_button" value="Add"
                        class="btn btn-primary">
                </div>
            </div>
            </form>
        </div>
    </div>
</div>


<script>
    // Dropzone.autoDiscover = false;
    // var myDropzone;
    $(document).ready(function() {

        var id = {{ $quoteProduct->id }};
        $('#excessLiabilitytable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                url: "{{ route('get-general-liabilities-quotation-table') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                }
            },
            columns: [{
                    data: 'market_name',
                    name: 'market_name'
                },
                {
                    data: 'full_payment',
                    name: 'full_payment'
                },
                {
                    data: 'down_payment',
                    name: 'down_payment'
                },
                {
                    data: 'monthly_payment',
                    name: 'monthly_payment'
                },
                {
                    data: 'broker_fee',
                    name: 'broker_fee'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                }
            ]
        });

        $('#addQuoteModalExcess_Liability').on('hidden.bs.modal', function() {
            $('#quotationForm select').val('');
            $('#quotationForm input[type="text"], #quotationForm textarea')
                .val('');
            $('#quotationForm input[type="file"]').val('');
            $('#quotationForm .input-mask').trigger('input');
        });

        //send quote button functionalities
        $('#sendQuoteButton').on('click', function() {
            var id = {{ $quoteProduct->id }};
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to send this quote to the client',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, send it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('send-quotation-product') }}",
                        method: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(response) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Quotation Comparison has been sent',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                console.log('test this code');
                                location.reload();
                            });
                        }
                    });
                }
            });
        });

    });
</script>
