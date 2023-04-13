@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">


<!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0"></h4>
                </div>
            </div>
        </div>

<!-- end page title -->
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="dropdown float-end">
                    <a href="{{ route('admin.departments.create') }}" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPositionModal" id="create_record">
                        ADD POSITION</a>
                        {{-- <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a> --}}
                </div>
                <h4 class="card-title mb-4">Departments</h4>
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Updated At</th>
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
</div>

    </div>
</div>
</div>

{{-- start of modal for creation and edition--}}
<div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="dataModalLabel">Add Position</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="dataModalForm">
              @csrf
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
              </div>
              <input type="hidden" name="action" id="action" value="add">
              <input type="hidden" name="hidden_id" id="hidden_id" />
           
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" name="action_button" id="action_button" value="Add" class="btn btn-primary">
          </div>
        </form>
        </div>
      </div>
    </div>
</div>
{{-- end of modal --}}




<script>
    // DATA TABLE
    $(document).ready(function() {
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.departments.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'created_at_formatted', name: 'created_at', searchable:false},
                {data: 'updated_at_formatted', name: 'updated_at', searchable:false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
          
           
        });
    });


     // configuring of modal for creating
     $('#create_record').on('click', function(event){
        $('.modal-title').text('Add New Record');
        // $('#name').val(data.result.name);
        $('#action_button').val('Add');
        $('#action').val('Add');
        $('#dataModal').modal('show');
    })


    $('#dataModalForm').on('submit', function(event){
        event.preventDefault();
        var action_url = ' ';

        if($('#action').val() == 'Add')
        {
            action_url = "{{ route('admin.departments.store') }}"
        }

        var name = $('#name').val();

        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
            url: action_url,
            data:$(this).serialize(),
            success: function(response) {
                $('#dataModal').modal('hide');
                location.reload();
            },
            error: function(response){
                var errors = response.responseJSON;
                console.log(errors);
               
            }
        });

    })

</script>

@endsection