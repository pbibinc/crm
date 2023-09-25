@extends('admin.admin_master')
@section('admin')
<div class="page-content pt-6">
    <div class="container-fluid">
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <h4 class="card-title mb-4">LIST OF QUOTED LEADS</h4>
                        </div>
                        <table id="assignQoutedLeadsTable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    {{-- <th>Company Name</th> --}}
                                    {{-- <th>State</th> --}}
                                    <th>Product</th>
                                    {{-- <th>Market Specialist</th> --}}
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

<script>
    $(document).ready( function () {
        $('#assignQoutedLeadsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('broker-leads.assigned-quoted-leads') }}",
            },
            columns: [
                // {data: 'company_name', name: 'company_name'},
                // {data: 'state', name: 'state'},
                {data: 'product', name: 'product'},
                // {data: 'market_specialist', name: 'market_specialist'},
            ]
        });
    });
</script>
@endsection
