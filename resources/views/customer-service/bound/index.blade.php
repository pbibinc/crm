<div class="row">
    <table id="boundProductTable" class="table table-bordered dt-responsive nowrap boundProductTable"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead style="background-color: #f0f0f0;">
            <th>Policy Number</th>
            <th>Product</th>
            <th>Company Name</th>
            <th>Total Cost</th>
            <th>Effective Date</th>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

@include('customer-service.policy-form.commercial-auto-policy-form', compact('carriers', 'markets'))
@include('customer-service.policy-form.general-liabilities-policy-form', compact('carriers', 'markets'))
@include('customer-service.policy-form.workers-compensation-policy-form', compact('carriers', 'markets'))
@include('customer-service.policy-form.tools-equipment-policy-form', compact('carriers', 'markets'))
@include('customer-service.policy-form.business-owners-policy-form', compact('carriers', 'markets'))
@include('customer-service.policy-form.builders-risk-policy-form', compact('carriers', 'markets'))
@include('customer-service.policy-form.excess-insurance-liability-form', compact('carriers', 'markets'))
<script>
    $(document).ready(function() {
        var token = '{{ csrf_token() }}';
        $('.boundProductTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('bound-list') }}",
                type: "POST",

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
                    data: 'company_name',
                    name: 'company_name'
                },
                {
                    data: 'policy_total_cost',
                    name: 'policy_total_cost'
                },
                {
                    data: 'effective_date',
                    name: 'effective_date'
                }

            ],
            language: {
                emptyTable: "No data available in the table"
            },
            initComplete: function(settings, json) {
                if (json.recordsTotal === 0) {
                    $('.boundProductTable').parent().hide();
                }
            }
        });

        $(document).on('click', '.showPolicyForm', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            var product = $(this).attr('data-product');
            var type = $(this).attr('type');
            $.ajax({
                url: "{{ route('get-bound-information') }}",
                type: "POST",
                data: {
                    id: id,
                    type: type
                },
                success: function(response) {
                    console.log(response);
                    if (response.product.product == 'General Liability') {
                        $('#glInsuredInput').val(response.lead.company_name);
                        $('#glPolicyNumber').val(response.selectedQuote.quote_no);
                        $('#glPaymentTermInput').val(response.paymentInformation
                            .payment_term);
                        $('#glHiddenInputId').val(response.product.id);
                        $('#hiddenQuoteId').val(response.selectedQuote.id);
                        $('#glMarketInput').val(response.marketName.name);
                        $('#generalLiabilitiesPolicyForm').modal('show');
                    }
                    if (response.product.product == 'Commercial Auto') {
                        $('#commercialAutoInsuredInput').val(response.lead.company_name);
                        $('#commerciarlAutoPolicyNumber').val(response.selectedQuote
                            .quote_no);
                        $('#commercialAutoPaymentTermInput').val(response.paymentInformation
                            .payment_term);
                        $('#commercialAutoHiddenInputId').val(response.product.id);
                        $('#commercialAutoHiddenQuoteId').val(response.selectedQuote.id);
                        $('#commercialAutoMarketInput').val(response.marketName.name);
                        $('#commercialAutoPolicyForm').modal('show');
                    }
                    if (response.product.product == 'Workers Compensation') {
                        $('#workersCompensationPolicyNumber').val(response.selectedQuote
                            .quote_no);
                        $('#workersCompensationInsuredInput').val(response.lead
                            .company_name);
                        $('#workersCompensationMarketInput').val(response.marketName
                            .name);
                        $('#workersCompensationPaymentTermInput').val(response
                            .paymentInformation
                            .payment_term);
                        $('#workersCompensationHiddenInputId').val(response.product.id);
                        $('#workersCompensationHiddenQuoteId').val(response.selectedQuote
                            .id);
                        $('#workersCompensationModalForm').modal(
                            'show');
                    }
                    if (response.product.product == 'Tools Equipment') {
                        $('#toolsEquipmentPolicyNumber').val(response.selectedQuote
                            .quote_no);
                        $('#toolsEquipmentInsuredInput').val(response.lead.company_name);
                        $('#toolsEquipmentMarketInput').val(response.marketName.name);
                        $('#toolsEquipmentPaymentTermInput').val(response.paymentInformation
                            .payment_term);
                        $('#toolsEquipmentHiddenInputId').val(response.product.id);
                        $('#toolsEquipmentHiddenQuoteId').val(response.selectedQuote
                            .id);
                        $('#toolsEquipmentPolicyFormModal').modal('show');
                    }
                    if (response.product.product == 'Business Owners') {
                        $('#businessOwnersNumber').val(response.selectedQuote
                            .quote_no);
                        $('#businessOwnersInsuredInput').val(response.lead.company_name);
                        $('#businessOwnersMarketInput').val(response.marketName.name);
                        $('#businessOwnersPaymentTermInput').val(response.paymentInformation
                            .payment_term);
                        $('#businessOwnersHiddenInputId').val(response.product.id);
                        $('#businessOwnersHiddenQuoteId').val(response.selectedQuote
                            .id);
                        $('#businessOwnersPolicyFormModal').modal('show');
                    }
                    if (response.product.product == 'Builders Risk') {
                        $('#buildersRiskPolicyNumber').val(response.selectedQuote
                            .quote_no);
                        $('#buildersRiskInsuredInput').val(response.lead.company_name);
                        $('#buildersRiskMarketInput').val(response.marketName.name);
                        $('#buildersRiskPaymentTermInput').val(response.paymentInformation
                            .payment_term);
                        $('#buildersRiskHiddenInputId').val(response.product.id);
                        $('#buildersRiskHiddenQuoteId').val(response.selectedQuote
                            .id);
                        $('#buildersRiskPolicyFormModal').modal('show');
                    }
                    if (response.product.product == 'Excess Liability') {
                        $('#excessInsuranceNumber').val(response.selectedQuote
                            .quote_no);
                        $('#excessInsuranceInsuredInput').val(response.lead.company_name);
                        $('#excessInsuranceMarketInput').val(response.marketName.name);
                        $('#excessInsurancePaymentTermInput').val(response
                            .paymentInformation
                            .payment_term);
                        $('#excessInsuranceHiddenInputId').val(response.product.id);
                        $('#excessInsuranceHiddenQuoteId').val(response.selectedQuote
                            .id);
                        $('#excessInsurancePolicyFormModal').modal('show');
                    }
                }
            });
        });
    })
</script>
