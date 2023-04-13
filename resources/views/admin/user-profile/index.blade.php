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
                        ADD POSITION</a>
                        {{-- <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a> --}}
                </div>
                <h4 class="card-title mb-4">Positions</h4>
                <div class="table-responsive">
                    <table id="position-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>name</th>
                                <th>ID Number</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Department</th>
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
                    {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('last_name', 'Last Name') !!}
                    {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('id_num', 'ID Number') !!}
                    {!! Form::text('id_num', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('position_id', 'Select Designation', ['class' => 'form-label']) !!}
                    <div class="input-group">
                    {!! Form::select('position_id', $positions->pluck('name', 'id'), null, ['class' => 'form-control']) !!}
                    <button class="btn btn-outline-secondary" type="button" id="position_id_dropdown" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                    {{-- <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="position_id_dropdown">
                        @foreach($positions as $position)
                            <li><a class="dropdown-item" href="#" data-value="{{ $position->id }}">{{ $position->name }}</a></li>
                        @endforeach
                    </ul> --}}
                    </div>
                </div>
                {{-- <div class="form-group">
                    {!! Form::label('status', 'Status') !!}
                    {!! Form::select('status', [1 => 'Active', 0 => 'Inactive'], null, ['class' => 'form-control']) !!}
                </div> --}}
                <div class="form-group">
                    {!! Form::label('department_id', 'Department') !!}
                    {!! Form::select('department_id', $departments->pluck('name', 'id'), null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('account_id', 'Account') !!}
                    {!! Form::select('account_id', $accounts->pluck('name', 'id'), null, ['class' => 'form-control']) !!}
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


@endsection