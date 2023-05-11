@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <form action="{{ route('leads.import') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="file" class="form-control">
                                        <br>
                                        <button class="btn btn-primary">Import Leads Data</button>
                                    </form>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="card bg-info text-white-50">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h5 class="mb-4 text-white"><i class="mdi mdi-account-hard-hat me-3"></i>New Leads</h5>
                                                            <h2 class="text-white ml-auto">{{$newLeadsCount}}</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="card bg-info text-white-50">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h5 class="mb-4 text-white"><i class="mdi mdi-headset me-3"></i>Assign Leads</h5>
                                                            <h2 class="text-white ml-auto">{{$assignLeadsCount}}</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header float-end">
                                <div class="float-end">
{{--                                    <a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPositionModal" id="create_record">--}}
{{--                                        ADD LEADS</a>--}}
                                </div>
                            </div>
                            <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered dt-responsive nowrap" id="dataTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Company Name</th>
                                                <th>Tel Number</th>
                                                <th>State abbr</th>
                                                <th>Website Originated</th>
                                                <th>Status</th>
                                                <th>Imported at</th>
{{--                                                <th>Updated at</th>--}}
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

            {{-- start of modal for creation and edition--}}
{{--            <div class="modal fade" id="addPositionModal" tabindex="-1" aria-labelledby="addPositionModalLabel" aria-hidden="true">--}}
{{--                <div class="modal-dialog modal-dialog-centered" role="document">--}}
{{--                    <div class="modal-content">--}}
{{--                        <div class="modal-header">--}}
{{--                            <h5 class="modal-title" id="addPositionModalLabel">Add Position</h5>--}}
{{--                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                        </div>--}}
{{--                        <div class="modal-body">--}}
{{--                            <form id="positionForm">--}}
{{--                                @csrf--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label for="name" class="form-label">Name</label>--}}
{{--                                    <input type="text" class="form-control" id="name" name="name" required>--}}
{{--                                </div>--}}
{{--                                <input type="hidden" name="action" id="action" value="add">--}}
{{--                                <input type="hidden" name="hidden_id" id="hidden_id" />--}}

{{--                        </div>--}}
{{--                        <div class="modal-footer">--}}
{{--                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
{{--                            <input type="submit" name="action_button" id="action_button" value="Add" class="btn btn-primary">--}}
{{--                        </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        {{-- end of modal --}}


    </div>
<script>
    // DATA TABLE
    $(document).ready(function() {
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('leads') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'company_name', name: 'company_name'},
                {data: 'tel_num', name: 'tel_num'},
                {data: 'state_abbr', name: 'state_abbr'},
                {data: 'website_originated', name: 'website_originated'},
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, row) {
                        switch (data){
                            case 1: return 'New Leads';
                            case 2:
                                if (row.user_profile && row.user_profile.firstname) {
                                    let firstNameInitial = row.user_profile.firstname.charAt(0).toUpperCase();
                                    return 'Assign to ' + row.user_profile.position.name + ' ' + firstNameInitial + '. ' + row.user_profile.american_surname;
                                } else {
                                    return ''; // Handle the case when user_profile or firstname is null
                                }
                            case 3: return ''
                        }
                    }
                },
                {data: 'created_at_formatted', name: 'created_at', searchable:false},
                // {data: 'updated_at_formatted', name: 'updated_at', searchable:false},
                // {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>
@endsection
