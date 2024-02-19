@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="card"
                            style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">

                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#request-to-bind" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Request To Bind</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#bound" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Bound</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#incompleteBinding" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">Incomplete Binding</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#policyList" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                        <span class="d-none d-sm-block">New Policies</span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="request-to-bind" role="tabpanel">
                                    @include('customer-service.binding.request-to-bind-view')
                                </div>
                                <div class="tab-pane" id="bound" role="tabpanel">
                                    <p class="mb-0">
                                        @include(
                                            'customer-service.bound.index',
                                            compact('carriers', 'markets'))
                                    </p>
                                </div>
                                <div class="tab-pane" id="incompleteBinding" role="incompleteBinding">
                                    <p class="mb-0">
                                        @include('customer-service.incomplete-binding.index')
                                    </p>
                                </div>
                                <div class="tab-pane" id="policyList" role="policyList">
                                    <p class="mb-0">
                                        @include('customer-service.policy.new-policy-list')
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

            </div>




            @include('customer-service.binding.view-binding-information')
        </div>
    </div>
    <script>
        Dropzone.autoDiscover = false;
        var myDropzone;






        // $(document).on('click', '.viewBindingButton', function(e) {
        //     e.preventDefault();
        //     var id = $(this).attr('id');
        //     var quote = $(this).attr('data-quote');
        //     var quoteData = quote ? JSON.parse(quote) : '{}';

        //     var paymentInformation = $(this).attr('data-paymentInformation');
        //     var payementInformationData = paymentInformation ? JSON.parse(paymentInformation) : '{}';

        //     var lead = $(this).attr('data-lead');
        //     var leadData = lead ? JSON.parse(lead) : '{}';

        //     var paymentCharged = $(this).attr('data-paymentCharged');
        //     var paymentChargedData = paymentCharged ? JSON.parse(paymentCharged) : '{}';

        //     var generalInformation = $(this).attr('data-generalInformation');
        //     var generalInformationData = generalInformation ? JSON.parse(generalInformation) : '{}';

        //     var media = $(this).attr('data-media');
        //     var mediaData = media ? JSON.parse(media) : '{}';

        //     var marketName = $(this).attr('data-marketName');
        //     var product = $(this).attr('data-product');
        //     var name = $(this).attr('data-userProfileName');
        //     var status = $(this).attr('data-status');

        //     $('#companyName').text(leadData.company_name);
        //     $('#insuredName').text(generalInformationData.firstname + ' ' + generalInformationData.lastname);
        //     $('#state').text(leadData.state_abbr);
        //     $('#market').text(marketName);
        //     $('#product').text(product);
        //     $('#totalPolicyCost').text(quoteData.full_payment);
        //     $('#policyNum').text(quoteData.quote_no);
        //     $('#bindingEffectiveDate').text(quoteData.effective_date);
        //     $('#paymentType').text(payementInformationData.payment_type);
        //     $('#paymentApprovedBy').text(name);
        //     $('#inovoiceNumber').text(paymentChargedData.invoice_number);
        //     $('#paymentAprrovedDate').text(paymentChargedData.charged_date);
        //     $('#hiddenId').val(id);
        //     addExistingFiles(mediaData);
        //     if (status == 11) {
        //         $('#boundButton').hide();
        //         $('#declinedButton').hide();
        //     } else if (status == 6) {
        //         $('#boundButton').show();
        //         $('#declinedButton').show();
        //     };
        //     $('#declinedLeadId').val(leadData.id);
        //     $('#declinedHiddenProductId').val(id);
        //     $('#declinedHiddenTitle').val('Declined Binding for' + ' ' + product);
        //     $('#dataModal').modal('show');
        // });

        $('#declinedButton').on('click', function(e) {
            e.preventDefault();
            $('#declinedBindingModal').modal('show');
            $('#dataModal').modal('hide');
        })
    </script>
@endsection
