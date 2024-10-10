@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="card" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                    <div class="card-body">
                        <table id="brokerTable" class="table table-bordered dt-responsive nowrap brokerTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead style="background-color: #f0f0f0;">
                                <th>Full Name</th>
                                <th>Position</th>
                                <th>Agent</th>
                                <th>Action</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- start of modal for creation of market --}}
    <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataModalLabel">Assign Agents</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="dataModalForm">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                            <div class="invalid-feedback" id="nameError"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="agent" class="form-label">Agents</label>
                            <select class="select2 form-control select2-multiple" id="agent" name="agent[]"
                                data-placeholder="Choosee..." multiple="multiple">
                                @foreach ($userProfiles as $userProfile)
                                    <option value="{{ $userProfile->id }}">{{ $userProfile->fullName() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="action" id="action" value="add">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
                        <input type="submit" name="action_button" id="action_button" value="Add"
                            class="btn btn-primary ladda-button" data-style="expand-right">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.brokerTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('get-broker-handle-list') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                },
                columns: [{
                        data: 'fullName',
                        name: 'fullName'
                    },
                    {
                        data: 'position',
                        name: 'position'
                    },
                    {
                        data: 'agents',
                        name: 'agents'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });

            $('#agent').select2({
                dropdownParent: $('#dataModal'),
            });

            $(document).on('click', '.edit', function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('broker-handle.edit', ['broker_handle' => 'your_broker_handle']) }}"
                        .replace('your_broker_handle', id),
                    method: 'get',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        var fullname = data.userProfile.firstname + ' ' + data.userProfile
                            .lastname;
                        $('#name').val(fullname);
                        $('#agent').val(data.brokerHandle.map(handle => handle
                            .agent_userprofile_id)).trigger(
                            'change');
                        $('#hidden_id').val(id);
                        $('#dataModal').modal('show');
                        // $('#action_button').val('Update');
                        // $('#action').val('edit');
                    }
                });
            });

            $('#dataModalForm').on('submit', function(e) {
                e.preventDefault();
                var button = $('#action_button')
                var laddaButton = Ladda.create(button[0]);
                laddaButton.start();
                $.ajax({
                    url: "{{ route('assign-agent-to-broker.store') }}",
                    method: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(data) {
                        laddaButton.stop();
                        Swal.fire({
                            title: 'Success',
                            text: data.success,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        }).then(function() {
                            $('#dataModalForm')[0].reset();
                            $('#dataModal').modal('hide');
                            $('.brokerTable').DataTable().ajax.reload();
                        });
                    },
                    error: function(data) {
                        laddaButton.stop();
                        var errors = data.responseJSON.errors;
                        if (errors) {
                            if (errors.name) {
                                $('#name').addClass('is-invalid');
                                $('#nameError').html(errors.name);
                            }
                        }
                    }
                });
            });

        });
    </script>
@endsection
