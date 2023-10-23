@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-5">
                    <div class="card"
                        style=" box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="card"
                                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-truncate font-size-14 mb-2">Product For Follow Up</p>
                                                    <h4 class="mb-2">{{ $followupProductCount }}</h4>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <i class="ri-file-edit-line font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-info text-white-50"
                                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-truncate font-size-14 mb-2" style="color: white">Pending
                                                        Product</p>
                                                    <h4 class="mb-2" style="color: white">{{ $pendingProductCount }}</h4>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <i class="ri-umbrella-line font-size-24"
                                                            style="color: #17a2b8;"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-7">
                    <div class="card"
                        style=" box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <table id="assignPendingLeadsTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <th>Product</th>
                                    <th>Company Name</th>
                                    <th>Status</th>
                                    <th>Sent Out Date</th>
                                    <th></th>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="card"
                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <table id="getConfimedProductTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <th>Product</th>
                                    <th>Company Name</th>
                                    {{-- <th>Status</th> --}}
                                    {{-- <th>Sent Out Date</th>
                                <th></th> --}}
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

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

            $('#getConfimedProductTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get-confirmed-product') }}",
                columns: [{
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    // {data: 'status', name: 'status'},
                    // {data: 'sent_out_date', name: 'sent_out_date'},
                    // {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
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
        });
    </script>
@endsection
