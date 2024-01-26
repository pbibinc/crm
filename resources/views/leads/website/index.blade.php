@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-end">
                                <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#dataModal"
                                    id="create_record">
                                    ADD WEBSITE</a>
                            </div>
                            <h2 class="card-title mb-4"><b>Website</b></h2>
                            <div>
                                <table id="websiteTable"class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            {{-- <th>Created_at</th>
                                            <th>Updated_at</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- start of modal for creation of user --}}
            <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="dataModalLabel">Add Website</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="dataModalForm">
                            <div class="modal-body">

                                @csrf
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Name">
                                    <div class="invalid-feedback" id="nameError"></div>
                                </div>

                                <input type="hidden" name="action" id="action" value="add">
                                <input type="hidden" name="hidden_id" id="hidden_id" />

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" name="action_button" id="action_button" value="Add"
                                    class="btn btn-primary ladda-button" data-style="expand-right">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#websiteTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('website.index') }}",
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    // {
                    //     data: 'created_at_formatted',
                    //     name: 'created_at_formatted'
                    // },
                    // {
                    //     data: 'updated_at_formatted',
                    //     name: 'updated_at_formatted'
                    // },
                    {
                        data: 'action_button',
                        name: 'action_button'
                    }
                ]
            });
            $('#dataModalForm').on('submit', function(event) {
                event.preventDefault();
                var button = $('#action_button');
                var actionButton = $('#action').val();
                var id = $('#hidden_id').val();
                var laddaButton = Ladda.create(button[0]);
                laddaButton.start();
                if (actionButton == 'edit') {
                    $.ajax({
                        url: "/website/" + id,
                        method: "PUT",
                        data: $(this).serialize(),
                        success: function(response) {
                            laddaButton.stop();
                            Swal.fire({
                                title: 'Success!',
                                text: 'Website has been updated!',
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#dataModal').modal('hide');
                                    location.reload();
                                }
                            })
                        },
                        error: function(error) {
                            laddaButton.stop();
                            Swal.fire({
                                title: 'Error!',
                                text: 'Website has not been updated!',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            })

                        }
                    })
                } else {
                    $.ajax({
                        url: "{{ route('website.store') }}",
                        method: "POST",
                        data: $(this).serialize(),
                        success: function(response) {
                            laddaButton.stop();
                            Swal.fire({
                                title: 'Success!',
                                text: 'Website has been added!',
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#dataModal').modal('hide');
                                    location.reload();
                                }
                            })
                        },
                        error: function(error) {
                            laddaButton.stop();
                            Swal.fire({
                                title: 'Error!',
                                text: 'Website has not been added!',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            })

                        }
                    })
                }
            });
            $(document).on('click', '.btnEdit', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "/website/" + id + "/edit",
                    dataType: "json",
                    success: function(html) {
                        $('#name').val(html.data.name);
                        $('#hidden_id').val(html.data.id);
                        $('#dataModalLabel').text("Edit Website");
                        $('#action_button').val("Update");
                        $('#action').val("edit");
                        $('#dataModal').modal('show');
                    }
                })
            });
            $(document).on('click', '.btnDelete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/website/" + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: "DELETE",
                            success: function(response) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Website has been deleted!',
                                    icon: 'success',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                })
                            },
                            error: function(error) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Website has not been deleted!',
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                })

                            }
                        })
                    }
                })
            });
        });
    </script>
@endsection
