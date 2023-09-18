@extends('admin.admin_master')
@section('admin')
<style>
    .permission-badge {
    margin-right: 5px;  /* adjust as needed */
    margin-bottom: 5px; /* adjust as needed */
}
</style>
<div class="page-content pt-6">
    <div class="container-fluid">
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <h4 class="card-title mb-4"> LIST OF APPOINTED LEADS</h4>
                        </div>

                        <div class="row">
                            <div class="col-6">

                            </div>
                        </div>
                        <table id="assignAppointedLeadsTable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Company Name</th>
                                    <th>State</th>
                                    <th>Products</th>
                                    <th>Telemarketer</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-6">
                                <label for="filterBy" class="form-label">Market Specialist:</label>
                                <select class="form-select">
                                    @foreach ($quoters as $quoter)
                                    <option value="{{ $quoter->id }}">{{ $quoter->fullAmericanName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="filterBy" class="form-label">Agents:</label>
                                <select class="form-select">
                                    @foreach ($userProfiles as $userProfile)
                                    <option value="{{ $userProfile->id }}">{{ $userProfile->fullAmericanName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-6">
                                <button type="button" id="assignAppointedLead" class="btn btn-primary waves-effect waves-light " data-bs-toggle="tooltip" data-bs-placement="top" title="Button to assign checked Leads to a selected user">Assign Lead</button>
                            </div>
                            <div class="col-6">
                                <button type="button" id="assignLead" class="btn btn-primary waves-effect waves-light " data-bs-toggle="tooltip" data-bs-placement="top" title="Button to assign checked Leads to a selected user">Assign Lead</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function (){
        $('#assignAppointedLeadsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('assign-appointed-lead') }}",
            columns: [
                {data: 'company_name', name: 'company_name'},
                {data: 'state_abbr', name: 'state_abbr'},
                {data: 'products', name: 'products'},
                {data: 'current_user', name: 'current_user'},
            ]
        })
    })
</script>
@endsection
