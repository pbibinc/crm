<table id="auditInformationTable" class="table table-bordered dt-responsive nowrap"
    style="border-collapse: collapse; border-spacing: 0; width: 100%; font-size: 13px;">
    <thead style="background-color: #f0f0f0; font-size: 12px;">
        <tr>
            <th style="padding: 7px;">Policy</th>
            <th style="padding: 7px;">Product</th>
            <th style="padding: 7px;">Audit Letter</th>
            <th style="padding: 7px;">Status</th>
            <th style="padding: 7px;">Audit By</th>
            <th style="padding: 7px;"></th>
        </tr>
    </thead>

</table>

@include('customer-service.audit.upload-required-file-modal')

<script>
    $(document).ready(function() {
        $('#auditInformationTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-audit-information-table') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    leadId: {{ $leadId }}
                }
            },
            columns: [{
                    data: 'policy_number',
                    name: 'policy_number'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'audit_letter_file',
                    name: 'audit_letter_file'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'processed_by_fullname',
                    name: 'processed_by_fullname'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });
    });

    $(document).on('click', '.editAuditInformation', function() {
        var id = $(this).attr('id');
        var url = `{{ route('audit.edit', ':id') }}`.replace(':id', id);
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#auditInformationStatus').val(response.data.status);
                $('#hiddenPolicyId').val(response.data.policy_details_id);
                $('#hiddenAuditId').val(response.data.id);
                $('#colFileInput').attr('hidden', true);
                $('#audit_action_button').val('Edit');
                $('#auditInformationModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // handle errors
            }
        });
    });

    function deleteAuditInformation(id) {
        $.ajax({
            url: `{{ route('audit.destroy', ':id') }}`.replace(':id', id),
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Audit Information Deleted Successfully!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // handle errors
            }
        });
    }

    $(document).on('click', '.deleteAuditInformation', function() {
        var id = $(this).attr('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this Audit Information!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteAuditInformation(id);
            }
        });

    });

    function addExistingAuditInformationFile(files) {
        files.forEach(file => {
            var mockFile = {
                id: file.id,
                name: file.basename,
                size: parseInt(file.size),
                type: file.type,
                status: Dropzone.ADDED,
                url: file.filepath // URL to the file's location
            };
            uploadRequiredFileDropzone.emit("addedfile", mockFile);
            // myDropzone.emit("thumbnail", mockFile, file.filepath); // If you have thumbnails
            uploadRequiredFileDropzone.emit("complete", mockFile);
        });
    };

    $(document).on('click', '.uploadAuditInformationFile', function() {
        var id = $(this).attr('id');
        $('#hidden_id').val(id);

        $.ajax({
            url: `{{ route('required-audit-file.edit', ':id') }}`.replace(':id', id),
            method: 'GET',
            success: function(response) {
                if (response.data.length > 0) {
                    console.log('test');
                    addExistingAuditInformationFile(response.data);
                    $('#uploadRequiredAuditFileModal').modal('show');
                } else {
                    $('#uploadRequiredAuditFileModal').modal('show');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // handle errors
            }
        });

    });
</script>
