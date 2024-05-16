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
                                    <a class="nav-link active" data-bs-toggle="tab" href="#products" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Products</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#compliance" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Compliance</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#followup" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">For Follow Up</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#makePayment" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">Make A Payment</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#requestToBind" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                        <span class="d-none d-sm-block">Request To Bind</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#handledProduct" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                        <span class="d-none d-sm-block">Handled Product</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="products" role="tabpanel">
                                    @include('leads.broker_leads.pending-product-view')
                                </div>
                                <div class="tab-pane" id="compliance" role="tabpanel">
                                    @include('leads.broker_leads.compliance-product-view')
                                </div>
                                <div class="tab-pane" id="followup" role="tabpanel">
                                    @include('leads.broker_leads.for-follow-up-product-view')
                                </div>
                                <div class="tab-pane" id="makePayment" role="tabpanel">
                                    @include('leads.broker_leads.make-a-payment-list-view')
                                </div>
                                <div class="tab-pane" id="requestToBind" role="tabpanel">
                                    @include('leads.broker_leads.request-to-bind-product-view')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#assignPendingLeadsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('get-pending-product') }}"
                },
                columns: [{
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'sent_out_date',
                        name: 'sent_out_date'
                    },
                    {
                        data: 'statusColor',
                        name: 'statusColor'
                    },
                    {
                        data: 'viewButton',
                        name: 'viewButton'
                    }
                ],
                order: [
                    [2, 'desc']
                ],
                // language: {
                //     emptyTable: "No data available in the table"
                // },
                // initComplete: function(settings, json) {
                //     if (json.recordsTotal === 0) {
                //         // Handle the case when there's no data (e.g., show a message)
                //         console.log("No data available.");
                //     }
                // }
                // createdRow: function (row, data, dataIndex) {
                //     if (data.status == 3) {
                //       $(row).css({
                //         'background-color': '#fff1da',   // Soft background color for visibility
                //         'border': 'solid #e89a3d',   // Bold border for emphasis
                //         'border-radius': '5px'
                //       }); // Adjust the color as you see fit.
                //     }
                // },
            });

            $('.getConfimedProductTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('get-confirmed-product') }}"
                },
                columns: [{
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'viewButton',
                        name: 'viewButton'
                    }
                    // {data: 'status', name: 'status'},
                    // {data: 'sent_out_date', name: 'sent_out_date'},
                    // {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                createdRow: function(row, data, dataIndex) {
                    var status = data.status;
                    if (status == 11) {
                        $(row).addClass('table-success');
                    } else if (status == 6 || status == 15) {
                        $(row).addClass('table-warning');
                    } else if (status == 13 || status == 14) {
                        $(row).addClass('table-danger');
                    }
                }
                // language: {
                //     emptyTable: "No data available in the table"
                // },
                // initComplete: function(settings, json) {
                //     if (json.recordsTotal === 0) {
                //         // Handle the case when there's no data (e.g., show a message)
                //         console.log("No data available.");
                //     }
                // }
            })

            $('#assignPendingLeadsTable').on('click', '.viewButton', function() {
                $id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('quoted-product-profile') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data: {
                        id: $id
                    },
                    success: function(data) {
                        window.location.href =
                            `{{ url('quoatation/broker-profile-view/${data.leadId}/${data.generalInformationId}/${data.productId}') }}`;
                    }
                })
            });

            $('.getConfimedProductTable').on('click', '.viewButton', function() {
                $id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('quoted-product-profile') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data: {
                        id: $id
                    },
                    success: function(data) {
                        window.location.href =
                            `{{ url('quoatation/broker-profile-view/${data.leadId}/${data.generalInformationId}/${data.productId}') }}`;
                    }
                })
            });
        });
    </script>
@endsection
