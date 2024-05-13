<div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPositionModalLabel">Import Templates</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div>
                        <label for="">Template Name</label>
                        <input type="text" class="form-control" id="templateName">
                    </div>
                </div>
                <div class="row mb-3">
                    <div>
                        <label for="">Json Code</label>
                        <textarea name="" class="form-control" cols="30" rows="10" id="design"></textarea>
                    </div>
                    <div>
                        <label for="">Html Code</label>
                        <textarea name="" class="form-control" cols="30" rows="10" id="htmlCode"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="button" name="saveImportTemplate" id="saveImportTemplate" value="Add"
                    class="btn btn-primary">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(e) {
        $('#saveImportTemplate').on('click', function() {
            var designJson = JSON.stringify($('#design').val());
            var templateName = $('#templateName').val();
            $.ajax({
                url: "{{ route('admin.marketingtemplate.store') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "templateName": templateName,
                    "design": designJson,
                    "html": $('#htmlCode').val(),
                    "type": "imported"
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Template has been saved successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        location.reload();
                    });
                },
                error: function(response) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
