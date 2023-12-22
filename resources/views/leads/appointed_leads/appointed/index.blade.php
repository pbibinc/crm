@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Appointed List</h4>
                            <table id="appointedLeadsTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead style="background-color: #f0f0f0;">
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Tel Num</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Appointed Leads To Call Back</h4>
                            <table id="appointedCallback" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead style="background-color: #f0f0f0;">
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Callback Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#appointedLeadsTable').DataTable({
                processing: true,
                serverSide: true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                ajax: {
                    url: "{{ route('appointed-list') }}"
                },
                columns: [{
                        data: 'company_name_action',
                        name: 'company_name_action'
                    },
                    {
                        data: 'tel_num',
                        name: 'tel_num'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
            $('#appointedCallback').DataTable({
                processing: true,
                serverSide: true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                ajax: {
                    url: "{{ route('leads-appointed-callback') }}"
                },
                columns: [{
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'date_formatted',
                        name: 'date_formatted'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },

                ]
            });

        })
    </script>
@endsection
