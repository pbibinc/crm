@extends('admin.admin_master')
@section('admin')
<style>
    ul.error-list {
        list-style: none!important;
        margin: 0;
        padding: 0;
    }
</style>

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

                    <div>
                        <table id="usersTable"class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Name', 'autocomplete' => 'off']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('username', 'UserName') !!}
                {!! Form::text('username', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'UserName', 'autocomplete' => 'off']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('email', 'Email') !!}
                {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Email', 'autocomplete' => 'off']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('password', 'Password') !!}
                {!! Form::password('password', ['id' => 'pass2', 'class' => 'form-control', 'required' => 'required', 'placeholder' => 'Password']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('password_confirmation', 'Password Confirmation') !!}
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'required' => 'required', 'data-parsley-equalto' => '#pass2', 'placeholder' => 'Password Confirmation']) !!}
                <span class="text-danger error-text" id="errorPassword"></span>
            </div>

            <div class="form-group">
                {!! Form::label('role_id', 'Roles') !!}
                {!! Form::select('role_id', $roles->pluck('name', 'id'), null, ['class' => 'form-control']) !!}

            </div>
                <input type="hidden" name="action" id="action" value="add">
                <input type="hidden" name="hidden_id" id="hidden_id" />
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



    // configuring of modal for creating
    $('#create_record').on('click', function(event){
        $('.modal-title').text('Add New Record');
        // $('#name').val(data.result.name);
        $('#action_button').val('Add');
        $('#action').val('Add');
        $('#dataModal').modal('show');
    })

    // script for configuring edit modal
    $(document).on('click', '.edit', function(event){
        event.preventDefault();
        var id = $(this).attr('id');
        $('#form_result').html
        $.ajax({
            url: "/admin/users/"+id+"/edit",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType:"json",
            success:function(data){
                $('#name').val(data.result.name);
                $('#username').val(data.result.username);
                $('#email').val(data.result.email);
                $('#role_id').val(data.result.role_id);
                $('#hidden_id').val(id);
                $('.modal-title').text('Edit Record');
                $('#action_button').val('Update');
                $('#action').val('Update');
                $('#dataModal').modal('show');
                $('#password, #password_confirmation').css('display', 'none');
                $('#errorPassword').css('display', 'none');
                var passwordLabel = $('label[for="password"]');
                var passwordConfirmationLabel = $('label[for="password_confirmation"]');
                $('#password, #password_confirmation').removeAttr('required');
                passwordLabel.hide();
                passwordConfirmationLabel.hide();
            },
            error: function(data){
                var errors = data.responseJSON;
                console.log(errors);
            }

        })

    })

    //script for submission of form
    $('#dataModalForm').on('submit', function(event){
        event.preventDefault();
        var action_url = '';

        if($('#action').val() == 'Add')
        {
            action_url = "{{ route('admin.users.store') }}"
        }
        if($('#action').val() == 'Update')
        {
            action_url = "{{ route('admin.users.update') }}"
        }

        var name = $('#name').val();
        //form sending on creationg
        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
            url: action_url,
            data:$(this).serialize(),
            success: function(response) {
                $('#dataModal').modal('hide');
                location.reload();
            },
            error: function(xhr){
                var errors = xhr.responseJSON.errors;
                var errorHtml = '<ul>';
            
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

    $(document).ready(function() {
        $("#dataModal").on('hidden.bs.modal', function(){
            var form = document.querySelector('#dataModalForm');
            form.reset();
            $('#password, #password_confirmation').css('display', 'block');
            $('#errorPassword').html('').removeClass('error-text');
            var passwordLabel = $('label[for="password"]');
            var passwordConfirmationLabel = $('label[for="password_confirmation"]');
            $('#password, #password_confirmation').attr('required', 'required');
            passwordLabel.show();
            passwordConfirmationLabel.show();
            $('#action_button').val('Add');
            $('#action').val('add');
            $('.modal-title').text('Add New Record');
        });
    });

    $(document).ready(function(){
        $('#dataModalForm').parsley();
    });

    //script for saving
    // $('#dataModalForm').on('submit', function(event){
    //     event.preventDefault();
    //     console.log($(this).serialize());
    //     $.ajax({
    //          type: 'POST',
    //          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //          url: "{{ route('admin.users.store') }}",
    //          data:$(this).serialize(),
    //       success: function(response){
            
    //          alert(response.success);
    //             $('#dataModal').modal('hide');
    //            location.reload();
             
    //      },
    //      error: function (xhr, status, error) {
    //             var errors = xhr.responseJSON.errors;
    //     }
    
    //    });

    // });







</script>

</div>
@endsection
