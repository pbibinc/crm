@extends('admin.admin_master')
@section('admin')
<div class="page-content pt-6">
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">List of Appointed Leads</h4>
                    <table id="appointedLeadsTable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Company Name</th>
                                <th>Tel Num</th>
                                <th>Class Code</th>
                                <th>State Abbr</th>
                                <th>Application Taken By:</th>
                                <th>Action</th>
                                {{-- <th>Disposition</th> --}}
                            </tr>
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
        $('#appointedLeadsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('appointed-leads') }}",
            columns: [
                {data: 'company_name', name: 'company_name'},
                {data: 'tel_num', name: 'tel_num'},
                {data: 'class_code', name: 'class_code'},
                {data: 'state_abbr', name: 'state_abbr'},
                {data: 'current_user', name: 'current_user'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
                // {data: 'disposition', name: 'disposition'},
            ]
      })

      $('#appointedLeadsTable').on('click', '.edit', function() {
        var leadId = $(this).attr('id');
        $.ajax({
            url: "{{ route('lead-profile') }}",
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "POST",
            data: {leadId:leadId},
            success: function(){
                window.location.href = "{{ url('quoataion/lead-profile-view') }}";
            }
        })
      })

     })

   </script>
@endsection
