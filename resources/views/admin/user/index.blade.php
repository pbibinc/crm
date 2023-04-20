@extends('admin.admin_master')
@section('admin')


<div class="page-content">
  <div class="container-fluid">

<!-- start page title -->
  <div class="row">
    <div class="col-12">
     <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0"></h4>

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
                        <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#dataModal" id="create_record">
                            ADD USER</a>

                    </div>

                    <h4 class="card-title mb-4">Users</h4>

                    <div class="table-responsive">
                        <table id="usersTable" class="table table-centered mb-0 align-middle table-hover table-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th style="width: 120px;">Action</th>
                                </tr>
                            </thead><!-- end thead -->
                            <tbody >
{{--                                @foreach ($users as $user)--}}
{{--                                <tr>--}}
{{--                                    <td><h6 class="mb-0">{{ $user->id }}</h6></td>--}}
{{--                                    <td>{{ $user->name }}</td>--}}
{{--                                    <td>{{ $user->email }}</td>--}}
{{--                                    <td>{{ $user->username }}</td>--}}
{{--                                    <td>{{ $user->role->name }}</td>--}}
{{--                                    <td>{{ $user->created_at }}</td>--}}
{{--                                    <td>{{ $user->updated_at }}</td>--}}
{{--                                    <td>--}}
{{--                                        @can('update', $user)--}}
{{--                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#assignRoleModal" data-user-id="{{ $user->id }} " data-role-id="{{ $user->role_id }}"><i class="ri-user-follow-fill"></i></button>--}}
{{--                                        @endcan--}}
{{--                                        @can('delete', $user)--}}
{{--                                        <button class="btn btn-danger"><i class="ri-delete-bin-line"></i></button>--}}
{{--                                        @endcan--}}
{{--                                </tr>--}}

{{--                                @endforeach--}}

                            </td>

                            </tbody ><!-- end tbody -->
                        </table> <!-- end table -->
                    </div>
                </div><!-- end card -->
            </div><!-- end card -->

          </div>
<!-- end col -->

 </div>
<!-- end row -->
</div>
{{--@include('admin.user.edit', ['user' => $user, 'roles' => $roles])--}}
  </div>

{{--start of modal for creation of user--}}
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
              <div class="form-group">
                {!! Form::label('name', 'Name') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Name']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('username', 'UserName') !!}
                {!! Form::text('username', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'UserName']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('email', 'Email') !!}
                {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Email']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('password', 'Password') !!}
                {!! Form::password('password', ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Password']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('password_confirmation', 'Password Confirmation') !!}
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Password Confirmation']) !!}
                @error('password_confirmation')
                <div class="alert alert-danger">{{$errors->first('password_confirmation')}}</div>
                @enderror
            </div>

            <div class="form-group">
                {!! Form::label('role_id', 'Roles') !!}
                {!! Form::select('role_id', $roles->pluck('name', 'id'), null, ['class' => 'form-control']) !!}
            </div>
              {{-- <input type="hidden" name="action" id="action" value="add">
              <input type="hidden" name="hidden_id" id="hidden_id" /> --}}

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
{{--end of modal--}}


{{-- start of modal for updating--}}
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

{{-- start of deletion of modal --}}
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" >
                <h5 class="modal-title"><b>Confirmation</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove this data?.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" name="ok_button" id="ok_button">gege</button>
            </div>
        </div>
    </div>
</div>
{{-- end of deletion of modal --}}

<script>

    // DATA TABLE
    $(document).ready(function() {
        $('#usersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.users.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'role_name', name: 'role_name'},
                {data: 'email', name: 'email'},
                {data: 'username', name: 'username'},
                {data: 'created_at_formatted', name: 'created_at', searchable:false},
                {data: 'updated_at_formatted', name: 'updated_at', searchable:false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });

    $(document).on('click', '.edit', function(event){
        event.preventDefault();
        var id = $(this).attr('id');
        $('#form_result').html
        $.ajax({
            url: "/admin/departments/"+id+"/edit",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType:"json",
            success:function(data){
                $('#name').val(data.result.name);
                $('#hidden_id').val(id);
                $('.modal-title').text('Edit Record');
                $('#action_button').val('Update');
                $('#action').val('Update');
                $('#dataModal').modal('show');
            },
            error: function(data){
                var errors = data.responseJSON;
                console.log(errors);
            }

        })

    })


     $('#dataModalForm').on('submit', function(event){
        event.preventDefault();
        console.log($(this).serialize());
        $.ajax({
        type: 'POST',
        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('admin.users.store') }}",
        data:$(this).serialize(),
        success: function(response){
            if(response.errors)
                {
                    var errors = response.errors;
                    $.each(errors, function(key, value){
                     $('#' + key).addClass('is-invalid');
                     $('#' + key + '_error').html(value);
                    });
                }
                else
                {
                  // handle success message
                  alert(response.success);
                  $('#dataModal').modal('hide');
                  location.reload();
                  // reload the form or redirect to a new page
                }
                // $('#dataModal').modal('hide');
                // location.reload();
        },
        error:function(xhr, status, error)
             {
                 console.log(xhr);
                 console.log(status);
                 console.log(error);
             }
      });

     })

    //script for deletion
    var UserId
    $(document).on('click', '.delete', function(){
        console.log('test')
        UserId = $(this).attr('id');
        console.log(UserId);
        $('#confirmModal').modal('show');
    })



    //script for sending delete
    $('#ok_button').click(function(){
        $.ajax({
            url:"/admin/users/" +UserId,
            type:"DELETE",
            beforeSend:function(){
                $('#ok_button').text('Deleting.....');
            },
            success:function($data)
            {
                setTimeout(() => {
                    $('#confirmModal').modal('hide');
                    location.reload();
                }, 1000);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.status);
                console.log('Error: ' + textStatus + ' - ' + errorThrown);
            }
        });
    });




</script>

</div>
@endsection
