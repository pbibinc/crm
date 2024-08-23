<style>
    .input-error {
        border: 1px solid red;
        /* or background-color: #ffcccc; for a red background */
    }
</style>


<div class="row mb-2">
    <div class="col-6 title-card">
        <h4 class="card-title mb-0" style="color: #ffffff">General Liablity Quotattions</h4>
    </div>
    <div class="d-flex justify-content-between">
        <div>

        </div>
        <div>
            <button class="btn btn-success createRecord" id="create_record_{{ $productForm }}"
                data-product='General_Liability' data-bs-target="#addQuoteModal_{{ $formId }}"> ADD
                QUOTE</button>

            @if ($quoteProduct->status == 2)
                <button href="#" class="btn btn-primary" id="sendQuoteButton">SEND QUOTE</button>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <table id="qoutation-table" class="table table-bordered dt-responsive nowrap"
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

<div class="modal fade " id="addQuoteModal_{{ $productForm }}" tabindex="-1" aria-labelledby="addQuoteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuoteModalLabel">Add Quotation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quotationForm{{ $productForm }}" enctype="multipart/form-data">
                <div class="modal-body">

                    @csrf
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="marketDropdownGeneral_Liability">Market</label>
                            <select name="marketDropdown" id="marketDropdownGeneral_Liability" class="form-select">
                                <option value="">Select Market</option>
                                @foreach ($quationMarket as $market)
                                    <option value={{ $market->id }}>{{ $market->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="quoteNoGeneral_Liability" class="form-label">Policy No/Quote No:</label>
                            <input type="text" class="form-control" id="quoteNoGeneral_Liability" name="quoteNo"
                                required autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="premium{{ $productForm }}">Premium</label>
                            <input type="text"
                                class="form-control calculateInput{{ $productForm }} input-mask text-left"
                                id="premium{{ $productForm }}" name="premium"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="endorsements{{ $productForm }}">Endorsements</label>
                            <input type="text"
                                class="form-control input-mask text-left calculateInput{{ $productForm }}"
                                id="endorsements{{ $productForm }}" name="endorsements"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="policyFee{{ $productForm }}">Policy Fee</label>
                            <input type="text"
                                class="form-control input-mask text-left calculateInput{{ $productForm }}"
                                id="policyFee{{ $productForm }}" name="policyFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="inspectionFe{{ $productForm }}">Inspection Fee</label>
                            <input type="text"
                                class="form-control input-mask text-left calculateInput{{ $productForm }}"
                                id="inspectionFee{{ $productForm }}" name="inspectionFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="stampingFee{{ $productForm }}">Stamping Fee</label>
                            <input type="text"
                                class="form-control input-mask text-left calculateInput{{ $productForm }}"
                                id="stampingFee{{ $productForm }}" name="stampingFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="surplusLinesTa{{ $productForm }}">Surplus lines Tax</label>
                            <input type="text"
                                class="form-control input-mask text-left calculateInput{{ $productForm }}"
                                id="surplusLinesTax{{ $productForm }}" name="surplusLinesTax"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="placementFee{{ $productForm }}">Placement Fee</label>
                            <input type="text"
                                class="form-control input-mask text-left calculateInput{{ $productForm }}"
                                id="placementFee{{ $productForm }}" name="placementFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="brokerFee{{ $productForm }}">Broker Fee</label>
                            <input type="text"
                                class="form-control input-mask text-left calculateInput{{ $productForm }}"
                                id="brokerFee{{ $productForm }}" name="brokerFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="miscellaneousFee{{ $productForm }}">Miscellaneous Fee</label>
                            <input type="text"
                                class="form-control input-mask text-left calculateInput{{ $productForm }}"
                                id="miscellaneousFee{{ $productForm }}" name="miscellaneousFee"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="fullPayment{{ $productForm }}" class="form-label">Full Payment</label>
                            <input type="text" class="form-control input-mask text-left"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" id="fullPayment{{ $productForm }}"
                                name="fullPayment" required readonly>
                        </div>
                        <div class="col-6">
                            <label for="downPayment{{ $productForm }}" class="form-label">Down Payment</label>
                            <input type="text" class="form-control input-mask text-left"
                                id="downPayment{{ $productForm }}" name="downPayment"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="monthlyPayment{{ $productForm }}" class="form-label">Monthly
                                Payment</label>
                            <input type="text" class="form-control input-mask text-left"
                                id="monthlyPayment{{ $productForm }}" name="monthlyPayment"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="numberOfPayment{{ $productForm }}" class="form-label">Number of
                                Paymment</label>
                            <input type="number" class="form-control" id="numberOfPayment{{ $productForm }}"
                                name="numberOfPayment">
                        </div>

                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="effectiveDate{{ $productForm }}">Effective Date</label>
                            <input type="date" class="form-control" id="effectiveDate{{ $productForm }}"
                                name="effectiveDate" required>
                        </div>
                    </div>

                    <div class="row">
                        <div>
                            <label for="medias" id="mediaLabelId">Attached File</label>
                            <input type="file" class="form-control" name="photos[]" id="medias" multiple />
                        </div>
                    </div>
                    <input type="hidden" name="action" id="action{{ $productForm }}" value="add">
                    <input type="hidden" name="product_hidden_id" id="product_hidden_id{{ $productForm }}" />
                    <input type="hidden" name="productId" id="productId{{ $productForm }}"
                        value="{{ $quoteProduct->id }}">
                    <input type="hidden" name="recommended" id="recommended_hidden{{ $productForm }}"
                        value="0" />
                    <input type="hidden" name="currentMarketId" id="currentMarketId{{ $productForm }}">
                    <input type="hidden" name="sender" id="sender{{ $productForm }}" value="marketSpecialist">
                    <input type="hidden" name="renewalQuote" id="renewalQuote{{ $productForm }}" value="false">

                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" class="form-check-input" id="reccomended{{ $productForm }}"
                            checked="">
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
        $('#qoutation-table').DataTable({
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


        $('#addQuoteModalGeneral_Liability').on('hidden.bs.modal', function() {
            $('#quotationForm select').val('');
            $('#quotationForm input[type="text"], #quotationForm textarea')
                .val('');

            $('#quotationForm input[type="file"]').val('');
            $('#quotationForm .input-mask').trigger('input');
        });

        var formId = @json($formId);
        var product = @json($productForm);

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

        function calculateFullPayment(product) {
            let premium = parseCurrency($(`#premium${product}`).val()) || 0;
            let endorsements = parseCurrency($(`#endorsements${product}`).val()) || 0;
            let policyFee = parseCurrency($(`#policyFee${product}`).val()) || 0;
            let inspectionFee = parseCurrency($(`#inspectionFee${product}`).val()) || 0;
            let stampingFee = parseCurrency($(`#stampingFee${product}`).val()) || 0;
            let suplusLinesTax = parseCurrency($(`#suplusLinesTax${product}`).val()) || 0;
            let placementFee = parseCurrency($(`#placementFee${product}`).val()) || 0;
            let brokerFee = parseCurrency($(`#brokerFee${product}`).val()) || 0;
            let miscellaneousFee = parseCurrency($(`#miscellaneousFee${product}`).val()) || 0;

            let fullPayment = premium + endorsements + policyFee + inspectionFee + stampingFee +
                suplusLinesTax +
                placementFee + brokerFee + miscellaneousFee;
            $(`#fullPayment${product}`).val('$ ' + fullPayment.toFixed(2).replace(/\d(?=(\d{3})+\.)/g,
                '$&,'));
        };

    });
</script>
