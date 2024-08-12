<div class="row">
    <table id="bindingDocsTable" class="table table-bordered dt-responsive nowrap"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>File Name</th>
                <th>File</th>
                <th>Date Attached</th>
                <th>Action</th>
                {{-- <th>Attached By</th> --}}
            </tr>
        </thead>
    </table>
</div>

<div class="modal fade" id="fileUploadModal" tabindex="-1" aria-labelledby="fileUploadModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileUploadModalTitle">Upload File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="" id="bindDocsFileButton">
                        @csrf
                        <input type="file" class="form-control" id="bindingFile" name="bindingFile[]" multiple>
                        <input type="hidden" id="hiddenId" name="hiddenId">

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-outline-primary waves-effect waves-light" id=""
                    value="Upload">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#bindingDocsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('binding-docs') }}",
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: "{{ $leadId }}"
                }
            },
            columns: [{
                    data: 'basename',
                    name: 'basename'
                },
                {
                    data: 'filepath',
                    name: 'filepath',
                    render: function(data, type, row) {
                        var url = "{{ env('APP_FORM_LINK') }}";
                        var link = url + data;
                        return `<a href="${link}" target="_blank">Preview</a>`;
                    }
                },
                {
                    data: 'date_attached',
                    name: 'date_attached'
                },
                {
                    data: 'action',
                    name: 'action'
                }
                // {
                //     data: 'attached_by',
                //     name: 'attached_by'
                // },
            ],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            },
            "order": [
                [0, "desc"]
            ],
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excel',
                    className: 'btn btn-outline-primary btn-sm me-2',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-outline-primary btn-sm me-2',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'print',
                    className: 'btn btn-outline-primary btn-sm me-2',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
            ],
        });

        $(document).on('click', '.bindDocsButtonUpload', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $('#hiddenId').val(id);
            $('#fileUploadModal').modal('show');
        });

        $('#bindDocsFileButton').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('upload-file-binding-docs') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#bindingDocsTable').DataTable().ajax.reload();
                    $('#fileUploadModal').modal('hide');
                }
            });
        });

        $(document).on('click', '.delete', function() {
            var id = $(this).attr('id');
            var productId = $(this).attr('data-productId');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#556ee6',
                cancelButtonColor: '#f46a6a',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete-binding-docs') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: "POST",
                        data: {
                            id: id,
                            productId: productId
                        },
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'File has been deleted!',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#bindingDocsTable').DataTable().ajax
                                        .reload();
                                }
                            })
                        },
                        error: function(data) {
                            console.log(data);
                        }

                    })
                }
            })


        });

    })
</script>
