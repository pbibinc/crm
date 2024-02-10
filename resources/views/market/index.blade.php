@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card"
                    style=" box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#dataModal" id="create_record">
                                ADD MARKET</a>
                        </div>
                        <h4 class="card-title mb-4">List of Market</h4>
                        <table id="dataTable" class="table table-bordered dt-responsive nowrap dataTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Products</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- start of modal for creation of market --}}
            <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="dataModalLabel">Add Market</h5>
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
                                <div class="form-group mb-3">
                                    <label for="product" class="form-label">Product</label>
                                    <select class="select2 form-control select2-multiple" id="product" name="product"
                                        data-placeholder="Choosee..." multiple="multiple">
                                        {{-- <option value="">Select Product</option> --}}
                                        <option value="General Liability">General Liability</option>
                                        <option value="Workers Compensation">Workers Compensation</option>
                                        <option value="Commercial Auto">Commercial Auto</option>
                                        <option value="Tools Equipment">Tools Equipment</option>
                                        <option value="Excess Liability">Excess Liability</option>
                                        <option value="Builders Risk">Builders Risk</option>
                                        <option value="Business Owners Policy">Business Owners Policy</option>
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
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('market-list.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'products',
                        name: 'products'
                    },
                    {
                        data: 'action_button',
                        name: 'action_button',
                    }
                ]
            });

            $('#product').select2({
                dropdownParent: $('#dataModal'),
            });

            $('#dataModal').on('submit', function(e) {
                e.preventDefault();
                var id = $('#hidden_id').val();
                var action = $('#action').val();
                var name = $('#name').val();
                var button = $('#action_button');
                var laddaButton = Ladda.create(button[0]);
                laddaButton.start();
                if (action == 'add') {
                    $.ajax({
                        url: "{{ route('market-list.store') }}",
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            name: name,
                            products: $('#product').val(),
                        },
                        dataType: "json",
                        success: function(data) {

                            laddaButton.stop();
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Market has been saved',
                                showConfirmButton: true,
                                timer: 1500
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#dataModalForm')[0].reset();
                                    $('#dataModal').modal('hide');
                                    $('#dataTable').DataTable().ajax.reload();
                                }
                            })
                        },
                        error: function(data) {
                            laddaButton.stop();
                            Swal.fire({
                                position: 'center',
                                icon: 'warning',
                                title: 'Err',
                                showConfirmButton: true,
                                timer: 1500
                            })
                        }
                    });
                } else {
                    $.ajax({
                        url: "/market-list/" + id,
                        method: "PUT",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            name: name,
                            products: $('#product').val(),
                        },
                        dataType: "json",
                        success: function(data) {

                            laddaButton.stop();
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Market has been saved',
                                showConfirmButton: true,
                                timer: 1500
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#dataModalForm')[0].reset();
                                    $('#dataModal').modal('hide');
                                    $('#dataTable').DataTable().ajax.reload();
                                }
                            })
                        },
                        error: function(data) {
                            laddaButton.stop();
                            Swal.fire({
                                position: 'center',
                                icon: 'warning',
                                title: 'Err',
                                showConfirmButton: ture,
                                timer: 1500
                            })
                        }
                    })
                }
            });

            $(document).on('click', '.btnEdit', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "/market-list/" + id + "/edit",
                    dataType: "json",
                    success: function(html) {

                        // Clear previous selections in the select field
                        $('#product').val(null).trigger('change');

                        // Set the selected options based on the data received
                        var selectedProducts = html.products.map(function(product) {
                            return product.name;
                        });
                        $('#product').val(selectedProducts).trigger('change');
                        $('#name').val(html.data.name);

                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("Edit Market");
                        $('#action_button').val("Edit");
                        $('#action').val("edit");
                        $('#dataModal').modal('show');
                    }
                })
            });

            $(document).on('click', '.btnDelete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this market?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#277da1',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/market-list/" + id,
                            method: "DELETE",
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(data) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Market has been deleted',
                                    showConfirmButton: true,
                                    timer: 1500
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                })
                            }
                        })
                    }
                })
            });
        })
    </script>
@endsection
