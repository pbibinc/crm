@extends('admin.admin_master')
@section('admin')
<div class="page-content pt-6">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                    <div class="card-body">
                        <table id="getConfimedProductTable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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

$(document).ready(function(){
    $('#getConfimedProductTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('get-confirmed-product') }}",
        columns: [
            {data: 'product', name: 'product'},
            {data: 'company_name', name: 'company_name'},
            // {data: 'status', name: 'status'},
            // {data: 'sent_out_date', name: 'sent_out_date'},
            // {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    })
})
</script>
@endsection
