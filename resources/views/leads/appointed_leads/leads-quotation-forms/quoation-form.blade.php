<style>
    .input-error {
        border: 1px solid red;
        /* or background-color: #ffcccc; for a red background */
    }
</style>

@php
    $productIds = [];
    foreach ($products as $product) {
        $productIds[] = $product->id;
    }
@endphp

<div class="card shadow-lg p-3 mb-5 bg-white rounded">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="">
            <button class="btn btn-success btn-sm createRecord" id="create_record_" data-product=''
                data-bs-target="#addQuoteModal_{{ $formId }}">ADD QUOTE</button>

            {{-- @if ($quoteProduct->status == 2)
                <button class="btn btn-primary btn-sm" id="sendQuoteButton">SEND QUOTE</button>
            @endif --}}
        </div>
        <div class="row">
            <div class="col-6">
                <label for="product" class="form-label">Product</label>
                <select name="product" id="tableProductDropdown" class="form-select form-select-sm">
                    <option value="">Select Product</option>
                    @foreach ($productsDropdown as $product)
                        <option value="{{ $product }}">{{ $product }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label for="Status" class="form-label">Filter By Status</label>
                <select name="status" id="tableStatusDropdown" class="form-select form-select-sm">
                    <option value="New Quote">New Quote</option>
                    <option value="Old Quote">Old Quote</option>
                </select>
            </div>

        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <table id="qoutation-table" class="table table-bordered dt-responsive nowrap no-vertical-border"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>Quote No/Policy No</th>
                        <th>Product</th>
                        <th>Market</th>
                        <th>Full Payment</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
{{-- <div class="row mb-2">
    <div class="d-flex justify-content-between align-items-center">
        <div class="">
            <button class="btn btn-success btn-sm createRecord" id="create_record_" data-product=''
                data-bs-target="#addQuoteModal_{{ $formId }}">ADD QUOTE</button>

            @if ($quoteProduct->status == 2)
                <button class="btn btn-primary btn-sm" id="sendQuoteButton">SEND QUOTE</button>
            @endif
        </div>
        <div class="row">
            <div class="col-6">
                <label for="product" class="form-label">Product</label>
                <select name="product" id="tableProductDropdown" class="form-select form-select-sm">
                    <option value="">Select Product</option>
                    @foreach ($productsDropdown as $product)
                        <option value="{{ $product }}">{{ $product }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label for="Status" class="form-label">Filter By Status</label>
                <select name="status" id="tableStatusDropdown" class="form-select form-select-sm">
                    <option value="New Quote">New Quote</option>
                    <option value="Old Quote">Old Quote</option>
                </select>
            </div>

        </div>
    </div>
</div> --}}



<div class="modal fade " id="addQuoteModal" tabindex="-1" aria-labelledby="addQuoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuoteModalLabel">Add Quotation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quotationForm" enctype="multipart/form-data">
                <div class="modal-body">

                    @csrf
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="marketDropdown">Market</label>
                            <select name="marketDropdown" id="marketDropdown" class="form-select">
                                <option value="">Select Market</option>
                                @foreach ($quationMarket as $market)
                                    <option value={{ $market->id }}>{{ $market->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="quoteNo" class="form-label">Policy No/Quote No:</label>
                            <input type="text" class="form-control" id="quoteNo" name="quoteNo" required
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="product">Product</label>
                            <select name="productDropdown" id="productDropdown" class="form-select">
                                <option value="">Select Product</option>
                                @foreach ($productsDropdown as $product)
                                    <option value="{{ $product }}">{{ $product }}</option>
                                @endforeach
                            </select>
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
                            <label for="inspectionFe">Inspection Fee</label>
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
                            <label for="surplusLinesTa">Surplus lines Tax</label>
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
                            <label for="monthlyPayment" class="form-label">Monthly
                                Payment</label>
                            <input type="text" class="form-control input-mask text-left" id="monthlyPayment"
                                name="monthlyPayment"
                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"
                                inputmode="decimal" style="text-align: right;" required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <label for="numberOfPayment" class="form-label">Number of
                                Paymment</label>
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
                    <input type="hidden" name="action" id="action" value="add">
                    <input type="hidden" name="product_hidden_id" id="product_hidden_id" />
                    <input type="hidden" name="productId" id="productId">
                    <input type="hidden" name="recommended" id="recommended_hidden" value="0" />
                    <input type="hidden" name="currentMarketId" id="currentMarketId">
                    <input type="hidden" name="sender" id="sender" value="marketSpecialist">
                    <input type="hidden" name="renewalQuote" id="renewalQuote" value="false">

                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" class="form-check-input" id="reccomended" checked="">
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
{{-- @include('leads.appointed_leads.broker-forms.make-payment-form', compact('complianceOfficer')) --}}

<script>
    Dropzone.autoDiscover = false;
    var myDropzone;
    $(document).ready(function() {
        var ids = @json($productIds);
        $('#qoutation-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                url: "{{ route('get-quote-list-table') }}",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.ids = ids;
                    d.product = $('#tableProductDropdown').val();
                    d.status = $('#tableStatusDropdown').val();

                },
                method: 'POST'
            },
            columns: [{
                    data: 'quote_no',
                    name: 'quote_no'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'market_name',
                    name: 'market_name'
                },
                {
                    data: 'full_payment',
                    name: 'full_payment'
                },
                {
                    data: 'new_quotation_status',
                    name: 'new_quotation_status'
                },
                {
                    data: 'formatted_created_At',
                    name: 'formatted_created_At'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                }
            ]
        });

        $('#tableProductDropdown, #tableStatusDropdown').on('change', function() {
            $('#qoutation-table').DataTable()
                .ajax
                .reload();
        });


        $('#addQuoteModal').on('hidden.bs.modal', function() {
            $('#quotationForm select').val('');
            $('#productDropdown').attr('disabled', false);
            $('#quotationForm input[type="text"], #quotationForm textarea')
                .val('');

            $('#quotationForm input[type="file"]').val('');
            $('#quotationForm .input-mask').trigger('input');
        });

        var formId = @json($formId);
        var product = @json($productForm);

        //send quote button functionalities
        // $('#sendQuoteButton').on('click', function() {

        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: 'You are about to send this quote to the client',
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonText: 'Yes, send it!',
        //         cancelButtonText: 'No, keep it'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 url: "{{ route('send-quotation-product') }}",
        //                 method: "POST",
        //                 data: {
        //                     id: id,
        //                     _token: "{{ csrf_token() }}"
        //                 },
        //                 dataType: "json",
        //                 success: function(response) {
        //                     Swal.fire({
        //                         position: 'center',
        //                         icon: 'success',
        //                         title: 'Quotation Comparison has been sent',
        //                         showConfirmButton: false,
        //                         timer: 1500
        //                     }).then(() => {
        //                         console.log('test this code');
        //                         location.reload();
        //                     });
        //                 }
        //             });
        //         }
        //     });
        // });

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
