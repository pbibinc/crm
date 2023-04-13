@extends('admin.admin_master')
@section('admin')



<div class="page-content">
 <div class="container-fluid">

<!-- start page title -->
<div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
          <h4 class="mb-sm-0">

          </h4>
            {{-- <div class="page-title-right">
             <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Upcube</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
             </ol>
                </div> --}}
       </div>
      </div>            
</div>
<!-- end page title -->
<div class="row">
  <div class="row">
     <div class="col-xl-12"> 
      <div class="card">
        <div class="card-body">
            <div class="dropdown float-end">
              @can('create', App\Model\Permission::class)
              <a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                ADD PERMISSION</a>
              @endcan
              
                {{-- <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical"></i>
                </a> --}}
            </div>
    
            <h4 class="card-title mb-4">Permissions</h4>
    
            <div class="table-responsive">
                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            {{-- <th>Status</th> --}}
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th style="width: 120px;">Action</th> 
                        </tr>
                    </thead><!-- end thead -->
                    <tbody>
                        @foreach ($permissions as $permission)
                        <tr>
                            <td><h6 class="mb-0">{{ $permission->id }}</h6></td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->created_at }}</td>
                            <td>{{ $permission->updated_at }}</td>
                            <td> 
                                <div class="row">
                                    <div class="col-5">
                                      @can('update', $permission)
                                      <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#updatePermissionModal" data-permission-id="{{ $permission->id }} " data-permission-name="{{$permission->name}}"> <i class="ri-edit-box-line"></i></button>
                                      @endcan
                                    </div>
    
                                    <div class="col-4 ml-0">
                                      @can('delete', $permission)
                                      <form 
                                      action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                      method="POST"
                                      >
                                      @csrf
                                      @method('DELETE')
                                          <button class="btn btn-danger" onclick="return confirmDelete()" type="submit"><i class="ri-delete-bin-line"></i></button>
                                      </form>
                                      @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @include('admin.permission.edit', ['permission' => $permission])
                    </tbody><!-- end tbody -->
                </table> <!-- end table -->
            </div>
     </div><!-- end card -->
  </div><!-- end card -->
  {{-- START OF MODAL --}}
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addPermissionModalLabel">Add Permission</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addPermissionForm">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id ="submitBtn" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- End of Modal --}}
</div>
   
  <script>
    
  $(document).ready(function() {
  $('#submitBtn').click(function(e) {
    e.preventDefault(); // prevent form from submitting
    var name = $('#name').val();
    $.ajax({
      url: '{{ route("admin.permissions.store") }}', // updated URL
      type: 'POST',
      data: {name: name, _token: '{{ csrf_token() }}'},
      success: function(response) {
        // handle success
        $('#addPermissionModal').modal('hide'); // close modal
        location.reload();
      },
      error: function(xhr, status, error) {
        // handle error
        console.log(xhr.responseText);
      }
    });
  });
 });
function confirmDelete() {
    return confirm("Are you sure you want to delete this permission?");
  }
</script>
@endsection