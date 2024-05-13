@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col text-end mb-3">
                            <a href="/admin/marketing/add-template" type="button"
                                class="btn btn-success waves-effect waves-light" id="addTemplate">
                                ADD TEMPLATE</a>
                            <a type="button" class="btn btn-info waves-effect waves-light" id="importTemplate">
                                IMPORT TEMPLATE</a>
                        </div>
                    </div>
                    <div class="row">
                        <table id="dataTable" class="table table-bordered dt-responsive nowrap dataTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="" style="background-color: #f0f0f0;">
                                <th>Template Name</th>
                                <th>Created By</th>
                                <th>Date Created</th>
                                <th></th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            @include('admin.marketing.template.import-template')

        </div>
    </div>

    <script>
        $(document).ready(function() {
            var token = '{{ csrf_token() }}';
            $('.dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.marketingget-template-list') }}",
                    type: "POST",

                },
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'createdBy',
                        name: 'createdBy'
                    },
                    {
                        data: 'createdDate',
                        name: 'createdDate'
                    },
                    {
                        data: 'editTemplate',
                        name: 'editTemplate'
                    },
                ],

            });

            $(document).on('click', '.editButton', function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                window.location.href = `/admin/marketing/template/${id}/edit`;
                // $.ajax({
                //     type: "GET",
                //     url: "/admin/marketing/template/" + id + "/edit",
                //     error: function(response) {
                //         Swal.fire({
                //             icon: 'error',
                //             title: 'Oops...',
                //             text: 'Something went wrong!',
                //         });
                //     },
                // });
            });


            $('#saveTemplateButton').on('click', function(e) {
                e.preventDefault();
                unlayer.saveDesign(function(design) {
                    var jsonDesign = JSON.stringify(design);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.marketingtemplate.store') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            design: jsonDesign
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                alert('Template saved successfully');
                            } else {
                                alert('Template not saved');
                            }
                        }

                    })
                });
            });

            $('#importTemplate').on('click', function(e) {
                e.preventDefault();
                $('#dataModal').modal('show');
            });

        });
    </script>
@endsection
