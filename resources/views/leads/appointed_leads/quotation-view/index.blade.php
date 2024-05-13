@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card"
                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#forQuoteProduct" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">For Quote Product</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#quotedProduct" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Quoted Product</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#brokerProduct" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Broker Assist</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#binding" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Binding</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="forQuoteProduct" role="tabpanel">
                                @include(
                                    'leads.appointed_leads.quotation-view.for-quote-product-view',
                                    compact(
                                        'products',
                                        'groupedProducts',
                                        'quotedProductCount',
                                        'quotationdProductCount',
                                        'quotationProduct'))
                            </div>
                            <div class="tab-pane" id="quotedProduct" role="tabpanel">
                                @include(
                                    'leads.appointed_leads.quotation-view.quoted-product-view',
                                    compact(
                                        'products',
                                        'groupedProducts',
                                        'quotedProductCount',
                                        'quotationdProductCount',
                                        'quotationProduct'))
                            </div>
                            <div class="tab-pane" id="brokerProduct" role="tabpanel">
                                @include(
                                    'leads.appointed_leads.quotation-view.broker-quoted-product-view',
                                    compact(
                                        'products',
                                        'groupedProducts',
                                        'quotedProductCount',
                                        'quotationdProductCount',
                                        'quotationProduct'))
                            </div>
                            <div class="tab-pane" id="binding" role="tabpanel">
                                @include(
                                    'leads.appointed_leads.quotation-view.binding-quoted-product-view',
                                    compact(
                                        'products',
                                        'groupedProducts',
                                        'quotedProductCount',
                                        'quotationdProductCount',
                                        'quotationProduct'))
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#productQuotedView').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get-broker-product') }}",
                columns: [{
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'brokerAssistant',
                        name: 'brokerAssistant'
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    var status = data.status;
                    if (status == 1) {
                        $(row).css('background-color', '#f0f0f0');
                    } else if (status == 2) {
                        $(row).css('background-color', '#f0f0f0');
                    } else if (status == 3) {
                        // $(row).addClass('table-warning');
                    } else if (status == 4) {
                        // $(row).addClass('table-warning');
                    } else if (status == 5) {
                        $(row).css('background-color', '#f0f0f0');
                    } else if (status == 6) {
                        $(row).addClass('table-primary');
                    } else if (status == 8) {
                        $(row).addClass('table-success');
                    } else if (status == 9) {
                        $(row).addClass('table-warning');
                    } else if (status == 10) {
                        $(row).addClass('table-warning');
                    } else if (status == 11) {
                        $(row).addClass('table-primary');
                    } else if (status == 12) {
                        $(row).addClass('table-primary');
                    }
                }
            })

            // $(document).on('click', '#productQuotedView .viewButton, #appointedLeadsTable .viewButton', function() {
            //     var productId = $(this).attr('id');
            //     console.log('test this code');
            //     $.ajax({
            //         url: "{{ route('lead-profile') }}",
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         method: "POST",
            //         data: {
            //             productId: productId
            //         },
            //         success: function(data) {
            //             window.location.href =
            //                 `{{ url('quoatation/lead-profile-view/${data.productId}') }}`;
            //         }
            //     })
            // })
        })
    </script>
@endsection
