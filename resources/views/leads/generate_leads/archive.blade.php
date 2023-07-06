@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered dt-responsive nowrap" id="dataTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Company Name</th>
                                <th>Tel Number</th>
                                <th>State abbr</th>
                                <th>Class Code</th>
                                <th>Website Originated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="restoreLead" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                <b>Confirmation</b>
                 </h5>
            </div>
            <div class="modal-body">
                <p id="modalParagraph">Are you sure you want to restore this lead</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" name="restoreLeadButton" id="restoreLeadButton">Restore</button>
            </div>
        </div>
    </div>
</div>

<script>
 $(document).ready(function(){
    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('leads.archive') }}",
        columns: [
                {data: 'company_name', name: 'company_name'},
                {data: 'tel_num', name: 'tel_num'},
                {data: 'state_abbr', name: 'state_abbr'},
                {data: 'class_code', name: 'class_code'},
                {data: 'website_originated', name: 'website_originated'},
                {data: 'restore', name:'restore'},
    ]
    });
    
    var leadsId
    
    $(document).on('click', '.btn-outline-primary', function(e){
        e.preventDefault();
        leadsId = $(this).attr('id');
        var leadsName = $(this).attr('company_name');
        $('#modalParagraph').val(leadsName);
        $('#restoreLead').modal('show');
        console.log(leadsId);
    });

    $('#restoreLeadButton').on('click', function(e){
       e.preventDefault();
       $.ajax({
        type: 'POST',
        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
        url: leadsId + "/restore",
        success:function(response){
                    Swal.fire({
                        title: 'Success',
                        text: 'The leads are succesfully restored',
                        icon: 'success'
                    }).then(function(){
                        $('#restoreLead').modal('hide');
                        location.reload();
                    });
                },
                error: function(xhr){
                    var errorMessage = 'An Error Occured';
                    if(xhr.responseJSON && xhr.responseJSON.error){
                           errorMessage = xhr.responseJSON.error;
                    }
                    Swal.fire({
                        title: 'Error',
                        text: 'Encounterd some error',
                        icon: 'error'
                    });
                }
       });
    });
    
});
  

</script>
@endsection