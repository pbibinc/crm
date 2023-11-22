@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <table id="appointedLeadsTable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead style="background-color: #f0f0f0;">
                                <tr>
                                    <th>Company Name</th>
                                    <th>Tel Num</th>
                                    <th>Class Code</th>
                                    <th>State Abbr</th>
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
    <script>
        $(document).ready(function() {
            $('#appointedLeadsTable').DataTable({
                processing: true,
                serverSide: true,
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
                        data: 'class_code',
                        name: 'class_code'
                    },
                    {
                        data: 'state_abbr',
                        name: 'state_abbr'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            })

        })
    </script>
@endsection
