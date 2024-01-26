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
            {{--        <div class="col-xl-3 col-lg-4 col-sm-6 mb-2"> --}}
            {{--            <div class="p-3"> --}}
            {{--                <p>A warning message, with a function attached to the "Confirm"-button...</p> --}}
            {{--                <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-warning">Click me</button> --}}
            {{--            </div> --}}
            {{--        </div> --}}


            <!-- end page title -->


            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-end">
                                @can('create', App\Model\Position::class)
                                    <a href="" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#addPositionModal" id="create_record">
                                        ADD POSITION</a>
                                @endcan
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                            </div>
                            <h4 class="card-title mb-4">Positions</h4>
                            <div>
                                <table id="position-table" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
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

    {{-- start of modal for creation and edition --}}
    <div class="modal fade" id="addPositionModal" tabindex="-1" aria-labelledby="addPositionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPositionModalLabel">Add Position</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="positionForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
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

    {{-- start of deletion of modal --}}
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Confirmation</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove this data?.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" name="ok_button" id="ok_button">gege</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end of deletion of modal --}}

    <script>
        // DATA TABLE
        $(document).ready(function() {
            $('#position-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.positions.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'created_at_formatted',
                        name: 'created_at',
                        searchable: false
                    },
                    {
                        data: 'updated_at_formatted',
                        name: 'updated_at',
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });



        // configuring of modal for creating
        $('#create_record').on('click', function(event) {
            $('.modal-title').text('Add New Record');
            // $('#name').val(data.result.name);
            $('#action_button').val('Add');
            $('#action').val('Add');
            $('#addPositionModal').modal('show');
        })



        // script for configuring edit modal
        $(document).on('click', '.edit', function(event) {
            event.preventDefault();
            var id = $(this).attr('id');
            $('#form_result').html
            $.ajax({
                url: "/admin/positions/" + id + "/edit",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                success: function(data) {
                    $('#name').val(data.result.name);
                    $('#hidden_id').val(id);
                    $('.modal-title').text('Edit Record');
                    $('#action_button').val('Update');
                    $('#action').val('Update');
                    $('#addPositionModal').modal('show');
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    console.log(errors);
                }

            })

        })

        //script for deletion
        var position_id
        $(document).on('click', '.delete', function() {
            position_id = $(this).attr('id');
            $('#confirmModal').modal('show');
        })


        //script for sending delete
        $('#ok_button').click(function() {
            $.ajax({
                url: "/admin/positions/" + position_id,
                type: "DELETE",
                beforeSend: function() {
                    $('#ok_button').text('Deleting.....');
                },
                success: function($data) {
                    setTimeout(() => {
                        $('#confirmModal').modal('hide');
                        location.reload();
                    }, 1000);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.status);
                    console.log('Error: ' + textStatus + ' - ' + errorThrown);
                }
            });
        });



        //script for submission of form
        $('#positionForm').on('submit', function(event) {
            event.preventDefault();
            var action_url = '';

            if ($('#action').val() == 'Add') {
                action_url = "{{ route('admin.positions.store') }}"
            }
            if ($('#action').val() == 'Update') {
                action_url = "{{ route('admin.positions.update') }}"
            }

            var name = $('#name').val();


            //form sending on creationg
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: action_url,
                data: $(this).serialize(),
                success: function(response) {
                    $('#addPositionModal').modal('hide');
                    location.reload();
                },
                error: function(response) {
                    var errors = response.responseJSON;
                    console.log(errors);

                }
            });

        })
    </script>

    <!-- Sweet Alerts js -->
    {{-- <script src="{{asset('backennd/assets/libs/sweetalert2/sweetalert2.min.js')}}"></script> --}}
    {{-- <script src="{{asset('backend/assets/js/pages/sweet-alerts.init.js')}}"></script> --}}
    {{-- <script src="assets/js/app.js"></script> --}}
@endsection
