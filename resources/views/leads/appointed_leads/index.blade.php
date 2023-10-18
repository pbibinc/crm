@extends('admin.admin_master')
@section('admin')
<div class="page-content pt-6">
    <div class="container-fluid">
        <div class="col-10">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">List of Appointed Leads</h4>
                    <table id="appointedLeadsTable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                            @foreach($groupedProducts as $company => $groupedProduct)
                            <tr>
                                <td><strong><b>{{ $company }}</b></strong></td>
                                <td><strong><b>Product</b></strong></td>
                                <td><strong><b>Telemarketer</b></strong></td>
                                <td><strong><b>Action</b></strong></td>
                            </tr>
                            @foreach ($groupedProduct as $product )
                            <tr>
                                <td></td>
                                <td>{{ $product['product']->product }}</td>
                                <td>{{ $product['telemarketer'] }}</td>
                                <td><button class="viewButton btn btn-info btn-sm" id={{ $product['product']->id }} ><i class="ri-eye-line" ></i></button></td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
   </div>

   <script>
     $(document).ready(function (){
        // $('#appointedLeadsTable').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: "{{ route('appointed-leads') }}",
        //     columns: [
        //         {data: 'company_name', name: 'company_name'},
        //         {data: 'tel_num', name: 'tel_num'},
        //         {data: 'class_code', name: 'class_code'},
        //         {data: 'state_abbr', name: 'state_abbr'},
        //         {data: 'current_user', name: 'current_user'},
        //         {data: 'action', name: 'action', orderable: false, searchable: false}
        //         // {data: 'disposition', name: 'disposition'},
        //     ]
        // })

      $('#appointedLeadsTable').on('click', '.viewButton', function() {
        var productId = $(this).attr('id');
        $.ajax({
            url: "{{ route('lead-profile') }}",
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "POST",
            data: {productId:productId},
            success: function(data){
                window.location.href = `{{ url('quoatation/lead-profile-view/${data.productId}') }}`;
            }
        })
      })
     })

   </script>
@endsection
