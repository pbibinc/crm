@extends('admin.admin_master')
@section('admin')
<div class="page-content pt-6">
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <table id="assignPendingLeadsTable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>

                            <th>Product</th>
                            <th>Company Name</th>
                            <th>Sent Out Date</th>
                            <th></th>

                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function (){
        $('#assignPendingLeadsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                    url: "{{ route('get-pending-product') }}"
                },
            columns:[
                {data: 'product', name: 'product'},
                {data: 'company_name', name: 'company_name'},
                {data: 'sent_out_date', name: 'sent_out_date'},
                {data: 'viewButton', name: 'viewButton'}
            ]
        });

        $('#assignPendingLeadsTable').on('click', '.viewButton', function(){
            $id = $(this).attr('id');
            $.ajax({
                url: "{{ route('quoted-product-profile') }}",
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                method: "POST",
                data: {id:$id},
                success: function(data){
                    window.location.href = `{{ url('quoatation/broker-profile-view/${data.leadId}/${data.generalInformationId}/${data.productId}') }}`;
                }
            })
        });
    });
</script>
@endsection
