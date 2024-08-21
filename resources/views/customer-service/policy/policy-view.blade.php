<div class="card">
    <div class="card-body">
        <table id="dataTable" class="table table-bordered dt-responsive nowrap bound-list-data-table"
            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <th>Policy Number</th>
                <th>Product</th>
                <th>Insurer</th>
                <th>Carrier</th>
                <th>Status</th>
                <th>Action</th>
            </thead>
        </table>
    </div>

    @include('customer-service.policy.renewal-form')
    @include('customer-service.policy.cancellation-report-modal')
</div>


<script>
    $(document).ready(function() {
        var id = {{ $id }};
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                url: "{{ route('get-policy-list') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                }
            },
            columns: [{
                    data: 'policy_number',
                    name: 'policy_number'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'market',
                    name: 'market'
                },
                {
                    data: 'carrier',
                    name: 'carrier'
                },
                {
                    data: 'status',
                    name: 'status'
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        })

        $(document).on('click', '.viewButton', function() {
            var id = $(this).attr('id');
            $.ajax({
                url: "{{ route('get-policy-details') }}",
                data: {
                    id: id
                },
                method: "POST",
                success: function(data) {
                    console.log(data);
                }
            })
        })

        $(document).on('click', '.')

        $(document).on('click', '.cancelButton', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $('#policyId').val(id);
            $('#policyCancellationModal').modal('show');

        })

        $(document).on('click', '.renewQuoteButton', function(e) {
            e.preventDefault();
            var quoteId = $(this).attr('data-quoteId');
            $.ajax({
                url: "{{ route('edit-quotation-comparison') }}",
                data: {
                    id: quoteId
                },
                method: "POST",
                success: function(response) {
                    var url = `{{ asset('${response.media.filepath}') }}`;
                    var filename = response.data.basename;
                    console.log(response);
                    //pricing breakdown inputs
                    $('#premium').val(response.pricingBreakdown.premium);
                    $('#endorsements').val(response.pricingBreakdown.endorsements);
                    $('#policyFee').val(response.pricingBreakdown.policy_fee);
                    $('#inspectionFee').val(response.pricingBreakdown.inspection_fee);
                    $('#stampingFee').val(response.pricingBreakdown.stamping_fee);
                    $('#suplusLinesTax').val(response.pricingBreakdown.surplus_lines_tax);
                    $('#placementFee').val(response.pricingBreakdown.placement_fee);
                    $('#miscellaneousFee').val(response.pricingBreakdown.miscellaneous_fee);

                    //quote comparison inputs
                    $('#market').val(String(response.market.name));
                    $('#fullPayment').val(response.data.full_payment);
                    $('#downPayment').val(response.data.down_payment);
                    $('#monthlyPayment').val(response.data.monthly_payment);
                    $('#numberOfPayment').val(response.data.number_of_payments);
                    $('#brokerFee').val(response.data.broker_fee);
                    $('#product_hidden_id').val(response.data.id);
                    $('#productId').val(response.data.quotation_product_id);
                    $('#quoteNo').val(response.data.quote_no);
                    $('#currentMarketId').val(response.data.quotation_market_id);
                    $('#effectiveDate').val(response.data.effective_date);

                    $('#medias').hide();
                    $('#mediaLabelId').hide();
                    $('#action_button').val('Update');
                    if (response.data.recommended == 1) {
                        $('#reccomended').prop('checked', true);
                        $('#recommended_hidden').val(1);
                    } else {
                        $('#reccomended').prop('checked', false);
                        $('#recommended_hidden').val(0);
                    }
                    $('#renewalDataModal').modal('show');
                }
            })

        })

        $('#isIntent').on('change', function() {
            if ($(this).is(':checked')) {
                $('#intent').val('1');
                $('input[name="reinstatedDate"]').attr('hidden', false);
                $('input[name="reinstatedEligibilityDate"]').attr('hidden', false);
                $('#reinstatedDateLabel').attr('hidden', false);
                $('#reinstatedEligibilityDateLabel').attr('hidden', false);
            } else {
                $('#intent').val('0');
                $('input[name="reinstatedDate"]').attr('hidden', true);
                $('input[name="reinstatedEligibilityDate"]').attr('hidden', true);
                $('#reinstatedDateLabel').attr('hidden', true);
                $('#reinstatedEligibilityDateLabel').attr('hidden', true);

            }
        })

        // $('#cancellationForm').on('submit', function(e) {
        //     e.preventDefault();
        //     var form = $(this);
        //     $.ajax({
        //         url: "{{ route('cancellation-report.index') }}",
        //         method: "POST",
        //         data: form.serialize(),
        //         success: function(data) {
        //             Swal.fire({
        //                 icon: 'success',
        //                 title: 'Success',
        //                 text: 'Policy has been cancelled!',
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     $('#dataTable').DataTable().ajax.reload();
        //                     $('#policyCancellationModal').modal('hide');
        //                 }
        //             })
        //         },
        //         error: function(data) {
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: 'Error',
        //                 text: 'Something went wrong!',
        //             })
        //         }
        //     })
        // })


    })
</script>
