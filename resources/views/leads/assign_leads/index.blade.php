@extends('admin.admin_master')
@section('admin')

    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
{{--                            <form action="{{ route('leads.import') }}" method="POST" enctype="multipart/form-data">--}}
{{--                                @csrf--}}
{{--                                <input type="file" name="file" class="form-control">--}}
{{--                                <br>--}}
{{--                                <button class="btn btn-primary">Import User Data</button>--}}
{{--                            </form>--}}
                            <label class="form-label">Single Select</label>
                            <select class="form-control select2">
                                @foreach($userProfiles as $userProfile)
                                    <option>{{$userProfile->firstname . " " . $userProfile->american_surname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered dt-responsive nowrap" id="dataTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th><button type="button" class="btn btn-info waves-effect waves-light">Assign Lead</button></th>
                                        <th>ID</th>
                                        <th>Company Name</th>
                                        <th>Tel Number</th>
                                        <th>State abbr</th>
                                        <th>Website Originated</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
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

    <script>
        // DATA TABLE
        $(document).ready(function() {
            $('.select2').select2();
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('assign') }}",
                columns: [
                    {data: 'checkbox', name: 'checkbox',  searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'company_name', name: 'company_name'},
                    {data: 'tel_num', name: 'tel_num'},
                    {data: 'state_abbr', name: 'state_abbr'},
                    {data: 'website', name: 'website'},
                    {data: 'created_at_formatted', name: 'created_at', searchable:false},
                    {data: 'updated_at_formatted', name: 'updated_at', searchable:false},
                    // {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
            // $('.select2').select2();
        });


    </script>

@endsection
