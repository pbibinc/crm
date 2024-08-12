<style>
    .input-error {
        border: 1px solid red;
        /* or background-color: #ffcccc; for a red background */
    }
</style>


<div class="row mb-2">
    <div class="col-6 title-card">
        <h4 class="card-title mb-0" style="color: #ffffff">Tools Equipment Quotattions</h4>
    </div>
    <div class="d-flex justify-content-between">
        <div>

        </div>
        <div>
            <button class="btn btn-success createRecord" id="create_record" data-product='Tools_Equipment'> ADD
                QUOTE</button>

            @if ($quoteProduct->status == 2)
                <button href="#" class="btn btn-primary" id="sendQuoteButton">SEND QUOTE</button>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <table id="toolsEquipmentTable" class="table table-bordered dt-responsive nowrap"
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

<div class="modal fade " id="addQuoteModalTools_Equipment" tabindex="-1" aria-labelledby="addQuoteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuoteModalLabel">Add Quotation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="quotationFormTools_Equipment" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="marketDropdownTools_Equipment">Market</label>
                            <select name="marketDropdown" id="marketDropdownTools_Equipment" class="form-select">
                                <option value="">Select Market</option>
                                @foreach ($quationMarket as $market)
                                    <option value={{ $market->id }}>{{ $market->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="quoteNoTools_Equipment" class="form-label">Policy No/Quote No:</label>
                            <input type="text" class="form-control" id="quoteNoTools_Equipment" name="quoteNo"
                                required autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="premium">Premium</label>
                            <input type="text" class="form-control calculateInput input-mask text-left"
                                id="premiumTools_Equipment" name="premium"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="endorsementsTools_Equipment">Endorsements</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="endorsementsTools_Equipment" name="endorsements"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="policyFeeTools_Equipment">Policy Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="policyFeeTools_Equipment" name="policyFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="inspectionFeeTools_Equipment">Inspection Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="inspectionFeeTools_Equipment" name="inspectionFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="stampingFeeTools_Equipment">Stamping Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="stampingFeeTools_Equipment" name="stampingFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="surplusLinesTaxTools_Equipment">Surplus lines Tax</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="surplusLinesTaxTools_Equipment" name="surplusLinesTax"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="placementFeeTools_Equipment">Placement Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="placementFeeTools_Equipment" name="placementFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="brokerFeeTools_Equipment">Broker Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="brokerFeeTools_Equipment" name="brokerFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="miscellaneousFeeTools_Equipment">Miscellaneous Fee</label>
                            <input type="text" class="form-control input-mask text-left calculateInput"
                                id="miscellaneousFeeTools_Equipment" name="miscellaneousFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="fullPaymentTools_Equipment" class="form-label">Full Payment</label>
                            <input type="text" class="form-control input-mask text-left"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" id="fullPaymentTools_Equipment"
                                name="fullPayment" required readonly>
                        </div>
                        <div class="col-6">
                            <label for="downPaymentTools_Equipment" class="form-label">Down Payment</label>
                            <input type="text" class="form-control input-mask text-left"
                                id="downPaymentTools_Equipment" name="downPayment"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="monthlyPaymentTools_Equipment" class="form-label">Monthly Payment</label>
                            <input type="text" class="form-control input-mask text-left"
                                id="monthlyPaymentTools_Equipment" name="monthlyPayment"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="numberOfPaymentTools_Equipment" class="form-label">Number of
                                Paymment</label>
                            <input type="number" class="form-control" id="numberOfPaymentTools_Equipment"
                                name="numberOfPayment">
                        </div>

                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="effectiveDateTools_Equipment">Effective Date</label>
                            <input type="date" class="form-control" id="effectiveDateTools_Equipment"
                                name="effectiveDate" required>
                        </div>
                    </div>

                    <div class="row">
                        <div>
                            <label for="medias" id="mediaLabelId">Attached File</label>
                            <input type="file" class="form-control" name="photos[]" id="medias" multiple />
                        </div>
                    </div>
                    <input type="hidden" name="action" id="actionTools_Equipment" value="add">
                    <input type="hidden" name="product_hidden_id" id="product_hidden_idTools_Equipment" />
                    <input type="hidden" name="productId" id="productIdTools_Equipment"
                        value="{{ $quoteProduct->id }}">
                    <input type="hidden" name="recommended" id="recommended_hiddenTools_Equipment"
                        value="0" />
                    <input type="hidden" name="currentMarketId" id="currentMarketIdTools_Equipment">
                    <input type="hidden" name="sender" id="senderTools_Equipment" value="marketSpecialist">
                    <input type="hidden" name="renewalQuote" id="renewalQuoteTools_Equipment" value="false">

            </div>
            <div class="modal-footer d-flex justify-content-between">
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" class="form-check-input" id="reccomendedTools_Equipment" checked="">
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
        $('#toolsEquipmentTable').DataTable({
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

        $('#addQuoteModalTools_Equipment').on('hidden.bs.modal', function() {
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
