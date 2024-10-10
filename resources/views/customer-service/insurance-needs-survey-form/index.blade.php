@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Insurance Needs Survey Form</h4>
                        <table id="insurance-needs-form-data-table" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead style="background-color: #f0f0f0;">
                                <th>Company Name</th>
                                <th>Client Name</th>
                                <th>Email Address</th>
                                <th>Contact Number</th>
                                <th>Trades Selected</th>
                                <th>UTM Sources</th>
                                <th>Requested Products</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                        </table>
                    </div>
                    {{-- start of modal for editing --}}
                    <div class="modal fade bs-example-modal-center" id="editStatusModal" tabindex="-1"
                        aria-labelledby="editStatusModalLabel" aria-hidden="true" data-id="">
                        <div class="modal-dialog modal-dialog-centered modal-xl" role="form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editStatusModalTitle">Edit Insurance Needs Survey Form
                                        Status</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="insuranceNeedsFormEditStatus" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="PUT">
                                        <div class="row mb-3">
                                            <label for="status">Insurance Needs Survey Form Status</label>
                                            <div class="col-6">
                                                <select name="status" id="status" class="form-control">
                                                    <option value="">Select Status</option>
                                                    <option value="Pending">Pending</option>
                                                    <option value="Processing">Processing</option>
                                                    <option value="Declined">Declined</option>
                                                    <option value="Completed">Completed</option>
                                                </select>
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" name="updateInsuranceNeedsFormStatus"
                                        id="updateInsuranceNeedsFormStatus" value="Update"
                                        class="btn btn-success ladda-button" data-style="expand-right">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#insurance-needs-form-data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{ route('insurance-needs-survey-form-list') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                    }
                },
                columns: [{
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'client_name',
                        name: 'client_name'
                    },
                    {
                        data: 'email_address',
                        name: 'email_address'
                    },
                    {
                        data: 'contact_number',
                        name: 'contact_number'
                    },
                    {
                        data: 'trades_selected',
                        name: 'trades_selected'
                    },
                    {
                        data: 'utm_sources',
                        name: 'utm_sources'
                    },
                    {
                        data: 'file_report',
                        name: 'file_report'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
            });

            $(document).on("click", ".edit", function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                $('#editStatusModal').modal('show');
                $('.modal-title').text('Edit Insurance Needs Survey Form Status');
                $('#editStatusModal').attr('data-id', id);
                reloadModal();
            });

            function reloadModal() {
                $('#insuranceNeedsFormEditStatus')[0].reset();
            }

            $(document).on("submit", "#insuranceNeedsFormEditStatus", function(e) {
                e.preventDefault();
                var id = $('#editStatusModal').attr('data-id');
                var formData = new FormData(this);
                formData.append('_method', 'PUT');

                $.ajax({
                    url: `{{ route('insurance-needs-survey-form.update', ':id') }}`.replace(':id',
                        id),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(response) {
                        $('#editStatusModal').modal('hide');
                        $('#insurance-needs-form-data-table').DataTable().ajax.reload();
                        alert(response.result);
                        reloadModal();
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                });
            });

            $('#editStatusModal').on('hidden.bs.modal', function() {
                reloadModal();
            });
        });
    </script>
@endsection
