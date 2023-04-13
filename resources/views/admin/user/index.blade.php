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
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                     
                    </div>
            
                    <h4 class="card-title mb-4">Users</h4>
            
                    <div class="table-responsive">
                        <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th style="width: 120px;">Action</th> 
                                </tr>
                            </thead><!-- end thead -->
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td><h6 class="mb-0">{{ $user->id }}</h6></td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->role->name }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td> 
                                        @can('update', $user)
                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#assignRoleModal" data-user-id="{{ $user->id }} " data-role-id="{{ $user->role_id }}"><i class="ri-user-follow-fill"></i></button>
                                        @endcan
                                        @can('delete', $user)
                                        <button class="btn btn-danger"><i class="ri-delete-bin-line"></i></button>
                                        @endcan
                                </tr>
                               
                                @endforeach
                               
                            </td>
                       
                            </tbody><!-- end tbody -->
                        </table> <!-- end table -->
                    </div>
                </div><!-- end card -->
            </div><!-- end card -->
            
          </div>
<!-- end col -->

 </div>
<!-- end row -->
</div>
@include('admin.user.edit', ['user' => $user, 'roles' => $roles])
  </div>
 
</div>  
@endsection