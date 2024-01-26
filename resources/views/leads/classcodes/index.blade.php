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
                                <a href="" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#addClasscodeModal" id="addClasscodeType">
                                    ADD CLASSCODE</a>
                                {{-- <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a> --}}
                            </div>
                            <h4 class="card-title mb-4">Classcodes</h4>
                            <div class="table-responsive">
                                <table id="data-table" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Classcode Name</th>
                                            <th>Classcode</th>
                                            <th>Classcode Description</th>
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
    </div>

    {{-- start of modal for creation and edition --}}
    <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataModalLabel">Add Classcode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="dataModalForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Classcode Name</label>
                            <input type="text" class="form-control" id="classcode_name" name="classcode_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Classcode (Optional)</label>
                            <input type="text" class="form-control" id="classcode" name="classcode">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Classcode Description (Optional)</label>
                            <textarea class="form-control" style="resize:none;" rows="4" cols="50" id="classcode_descriptions"
                                name="classcode_descriptions"></textarea>
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
                    <p>Are you sure you want to remove this data?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" name="ok_button" id="ok_button">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end of deletion of modal --}}

    <script>
        // Initialize Yajra DT
        $(document).ready(function() {
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('classcodes.index') }}",
                columns: [{
                        data: "id"
                    },
                    {
                        data: "classcode_name"
                    },
                    {
                        data: "classcode"
                    },
                    {
                        data: "classcode_descriptions"
                    },
                    {
                        data: "created_at_formatted"
                    },
                    {
                        data: "updated_at_formatted"
                    },
                    {
                        data: "action",
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });

        // configuring of modal for adding new entry
        $("#addClasscodeType").on("click", function() {
            $(".modal-title").text("Add New Record");
            $("#action_button").val("Add");
            $("#action").val("Add");
            $("#dataModal").modal("show");
        });

        // When submitting form
        $("#dataModalForm").on("submit", function(event) {
            event.preventDefault();

            // Get submit button value
            var action_url = '';
            if ($("#action").val() == "Add") {
                action_url = "{{ route('classcodes.store') }}";
            }
            if ($("#action").val() == "Update") {
                action_url = "{{ route('classcodes.update') }}";
            }

            // Serialize form data as an array
            var formDataArray = $("#dataModalForm").serializeArray();

            // Convert formDataArray into an object
            var formDataObject = {};
            $.each(formDataArray, function(index, item) {
                formDataObject[item.name] = item.value;
            });

            console.log(formDataArray);

            // POST Request using $.post()
            $.post(action_url, formDataObject, function() {
                $("#dataModal").modal("hide");
                location.reload();
            }).fail(function(response) {
                var errors = $.parseJSON(response.responseText);
                console.log(errors);
            });
        });
        // end submitting new entry

        // script for configuring edit modal
        $(document).on('click', '.edit', function(event) {
            event.preventDefault();
            var id = $(this).attr('id');
            console.log(id);
            $('#form_result').html;
            $.ajax({
                url: "/leads/classcodes/" + id + "/edit",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                dataType: "json",
                success: function(data) {
                    $('#classcode_name').val(data.result.classcode_name);
                    $('#classcode').val(data.result.classcode);
                    $('#classcode_descriptions').val(data.result.classcode_descriptions);
                    $('#hidden_id').val(id);
                    $('.modal-title').text('Edit Record');
                    $('#action_button').val('Update');
                    $('#action').val('Update');
                    $('#dataModal').modal('show');
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            })
        })

        //script for deletion
        var classcode_id
        $(document).on('click', '.delete', function() {
            // console.log('test');
            classcode_id = $(this).attr('id');
            $('#confirmModal').modal('show');
        });

        //script for sending delete
        $('#ok_button').click(function() {
            $.ajax({
                type: 'DELETE',
                url: "/leads/classcodes/" + classcode_id,
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
    </script>
@endsection
