@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <div class="card"
                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="card "
                                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-truncate font-size-14 mb-2">Quoted Products</p>
                                                    <h4 class="mb-2">{{ $quotedProductCount }}</h4>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-success rounded-3">
                                                        <i class="ri-file-edit-line font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end cardbody -->
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-info text-white-50"
                                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-truncate font-size-14 mb-2" style="color: white">Quoting
                                                        Product
                                                    </p>
                                                    <h4 class="mb-2" style="color: white">{{ $quotationdProductCount }}
                                                    </h4>
                                                </div>
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-light text-primary rounded-3">
                                                        <i class="ri-umbrella-line font-size-24"
                                                            style="color: #17a2b8;"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end cardbody -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="card"
                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <h4 class="card-title mb-4">List of Appointed Leads</h4>
                            <table id="appointedLeadsTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        {{-- <th>Tel Num</th> --}}
                                        {{-- <th>Class Code</th> --}}
                                        {{-- <th>State Abbr</th>
                                        <th>Application Taken By:</th>
                                        <th>Action</th> --}}
                                        {{-- <th>Disposition</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupedProducts as $company => $groupedProduct)
                                        <tr>
                                            <td><strong><b>{{ $company }}</b></strong></td>
                                            <td><strong><b>Product</b></strong></td>
                                            <td><strong><b>Telemarketer</b></strong></td>
                                            <td><strong><b>Status</b></strong></td>
                                            <td><strong><b>Action</b></strong></td>
                                        </tr>
                                        @foreach ($groupedProduct as $product)
                                            <tr>
                                                <td></td>
                                                <td>{{ $product['product']->product }}</td>
                                                <td>{{ $product['telemarketer'] }}</td>
                                                <td>
                                                    @if ($product['product']->status == 1)
                                                        <span class="badge bg-success">Quoted</span>
                                                    @else
                                                        <span class="badge bg-warning">Quoting</span>
                                                    @endif
                                                </td>
                                                <td><button class="viewButton btn btn-info btn-sm"
                                                        id={{ $product['product']->id }}><i
                                                            class="ri-eye-line"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card"
                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <table id="productQuotedView" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <th>Company Name</th>
                                    <th>Product</th>
                                    {{-- <th>Broker Assistant</th> --}}
                                    <th>Action</th>
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
            $('#productQuotedView').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get-broker-product') }}",
                columns: [{
                        data: 'company_name',
                        name: 'company_name'
                    },
                    // {
                    //     data: '',
                    //     name: 'tel_num'
                    // },
                    {
                        data: 'product',
                        name: 'product'
                    },
                    // {
                    //     data: 'brokerAssistant',
                    //     name: 'brokerAssistant'
                    // },
                    {
                        data: 'viewButton',
                        name: 'viewButton'
                    }

                ]
            })

            $(document).on('click', '#productQuotedView .viewButton, #appointedLeadsTable .viewButton', function() {
                var productId = $(this).attr('id');
                console.log('test this code');
                $.ajax({
                    url: "{{ route('lead-profile') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data: {
                        productId: productId
                    },
                    success: function(data) {
                        window.location.href =
                            `{{ url('quoatation/lead-profile-view/${data.productId}') }}`;
                    }
                })
            })
        })
    </script>
@endsection
