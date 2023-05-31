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
                    <a href="{{ route('admin.user-profiles.create') }}" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#dataModal" id="create_record">
                        ADD USERPROFILE</a>
                        {{-- <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a> --}}
                </div>
                <h4 class="card-title mb-4">USER PROFILES</h4>
                <div>
                    <table id="user-profiles-table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>American Name</th>
                                <th>ID Number</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Department</th>
                                <th>Account</th>
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
                <div class="form-group">
                    {!! Form::label('first_name', 'First Name') !!}
                    {!! Form::text('first_name', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('last_name', 'Last Name') !!}
                    {!! Form::text('last_name', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('american_surname', 'American Surname') !!}
                    {!! Form::text('american_surname', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('id_num', 'ID Number') !!}
                    {!! Form::text('id_num', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('skype_profile', 'Skype Profile') !!}
                    {!! Form::text('skype_profile', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('streams_number', 'Streams Number') !!}
                    {!! Form::text('streams_number', null, ['class' => 'form-control', 'autocomplete' => 'off', 'data-parsley-minlength' => 11, 'data-parsley-maxlength' => 11]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('position_id', 'Select Designation', ['class' => 'form-label']) !!}
                    <div class="input-group">
                    {!! Form::select('position_id', $positions->pluck('name', 'id'), null, ['class' => 'form-control']) !!}
                    {{-- <button class="btn btn-outline-secondary" type="button" id="position_id_dropdown" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-chevron-down"></i></button> --}}
                    {{-- <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="position_id_dropdown">
                        @foreach($positions as $position)
                            <li><a class="dropdown-item" href="#" data-value="{{ $position->id }}">{{ $position->name }}</a></li>
                        @endforeach
                    </ul> --}}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('is_active', 'Status') !!}
                    {!! Form::select('is_active', [1 => 'Active', 0 => 'Inactive'], null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('department_id', 'Department') !!}
                    {!! Form::select('department_id', $departments->pluck('name', 'id'), null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('account_id', 'Account') !!}
                    {!! Form::select('account_id', $accounts->pluck('name', 'id'), null, ['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                  <label for="media">Users Image</label>
                    <input type="file" class="form-control" id="media" name="media">
                </div>

                {{-- <input type="text" class="form-control" id="name" name="name" required> --}}
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

{{-- start of contact modal --}}
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header" >
          <h5 class="modal-title"><b>Confirmation</b></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" name="ok_button" id="ok_button">Submit</button>
        </div>
      </div>
    </div>
  </div>
{{-- end of deletion of modal --}}

<script>

 //DATA TABLE
$(function() {
    $('#user-profiles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{  route('admin.user-profiles.index')  }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'full_name', name: 'full_name' },
            { data: 'american_name', name: 'american_name' },
            { data: 'id_num', name: 'id_num' },
            { data: 'position_name', name: 'position_name' },
            { data: 'is_active', name: 'is_active', render: function (data, type, full, meta) {
                var statusClass = data == 1 ? 'active' : 'inactive';
                return '<span class="' + statusClass + '">' + (data == 1 ? 'Active' : 'Inactive') + '</span>';
            }},
            { data: 'department_name', name: 'department_name' },
            { data: 'user_name', name: 'user_name' },
            { data: 'created_at_formatted', name: 'created_at' },
            { data: 'updated_at_formatted', name: 'updated_at' },
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
        $('#datanModal').modal('show');
    })



// script of sending modal form
    $('#dataModalForm').on('submit', function(event){
        event.preventDefault();

        var form = $(this).parsley();
        var formElement = this;
        form.on('form:validate', function(){
          if(form.isValid()){
            var formData = new FormData(formElement);
            formData.append('media', $('#media')[0].files[0]);

            var action_url = '';

            if($('#action').val() == 'Add'){
                action_url = "{{ route('admin.user-profiles.store') }}"
             }else if($('#action').val() == 'Update'){
                action_url = "{{ route('admin.user-profiles.update') }}"
             }
             $.ajax({
                  type: 'POST',
                  headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                  url: action_url,
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function(response){
                    console.log(response);
                  
                    if (response.error) {
                         var errorMessage = response.error;
                         Swal.fire({
                              title: 'Error',
                              text: errorMessage,
                              icon: 'error'
                           }).then(function() {
                              $('#dataModal').modal('hide');
                              location.reload();
                             });
                     } else {
                           // handle success message
                         Swal.fire({
                              title: 'Success',
                              text: response.success,
                              icon: 'success'
                         }).then(function() {
                             $('#dataModal').modal('hide');
                             location.reload();
                          });
                       }
                  },
                  error:function(xhr, status, error)
                  {
                    console.log(xhr.responseText); // Log the response text to the console
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    Swal.fire({
                       title: 'Error',
                       text: 'An error occurred. Please try again later.',
                       icon: 'error'
                     }).then(function(){
                      $('#dataModal').modal('hide');
                      location.reload();
                     });
                  }
               });
            }
        })
    })


    //script for deletion
   var user_profile_id
   $(document).on('click', '.delete', function(){
    user_profile_id = $(this).attr('id');
    $('#confirmModal').modal('show');
   })



    //script for sending delete
   $('#ok_button').click(function(){
    $.ajax({
        url:"/admin/user-profiles/" +user_profile_id,
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

   $(document).on('click', '.contact', function(event){
        event.preventDefault();
        $('#contactModal').modal('show');
    
    })

    $(document).ready(function(){
        $('#dataModalForm').parsley();
        $('#dataModal').on('hidden.bs.modal', function(e){
          $('#dataModalForm')[0].reset();
        });
    });

    $('#account_id').prepend($('<option>', { 
             value: '',
             text : 'Select account', 
             selected: true, 
             disabled: true 
          }));
          $('#position_id').prepend($('<option>', { 
             value: '',
             text : 'Select position', 
             selected: true, 
             disabled: true 
          }));
          $('#department_id').prepend($('<option>', { 
             value: '',
             text : 'Select department', 
             selected: true, 
             disabled: true 
          }));
          $('#is_active').prepend($('<option>', { 
             value: '',
             text : 'Select status', 
             selected: true, 
             disabled: true 
          }));

    // script for configuring edit modal
    $(document).on('click', '.edit', function(event){
        event.preventDefault();
        var id = $(this).attr('id');
        
        $.ajax({
          url: "/admin/user-profiles/"+id+"/edit",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          dataType:"json",
          success:function(data){
        //   console.log(data.accountsSelected);
          $('#first_name').val(data.result.firstname);
          $('#last_name').val(data.result.lastname);
          $('#american_surname').val(data.result.american_surname);
          $('#id_num').val(data.result.id_num);
          $('#position_id').val(data.result.position_id);
          $('#is_active').val(data.result.is_active);
          $('#department_id').val(data.result.department_id);
          $('#account_id').val(data.result.user_id);
          $('#streams_number').val(data.result.streams_number);
          $('#skype_profile').val(data.result.skype_profile);
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



</script>




@endsection
