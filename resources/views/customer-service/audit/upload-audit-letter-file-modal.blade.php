<div class="modal fade" id="uploaddAuditLetterFileModal" tabindex="-1" aria-labelledby="uploaddAuditLetterFileModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploaddAuditLetterFileModalTitle">Upload Audit Letter File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="auditLetterFileForm" enctype="multipart/form-data"
                    class="dropzone mt-4 border-dashed" action="{{ route('upload-audit-letter') }}">
                    @csrf
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" value="" id="hidden_id">
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var uploaddAuditLetterFileDropzone;
    $(document).ready(function() {
        uploaddAuditLetterFileDropzone = new Dropzone('#auditLetterFileForm', {
            clickable: true,
            addRemoveLinks: false,
            init: function() {
                this.on("sending", function(file, xhr, formData) {
                    // Get the value from the hidden input
                    var hiddenId = $('#hidden_id').val();
                    // Append it to the FormData object
                    formData.append("hidden_id", hiddenId);
                });
                this.on('addedfile', function(file) {
                    file.previewElement.addEventListener("click", function() {
                        var url = "{{ env('APP_FORM_LINK') }}";
                        var fileUrl = url + file.url;
                        Swal.fire({
                            title: 'File Options',
                            text: 'Choose an action for the file',
                            showDenyButton: true,
                            confirmButtonText: `Download`,
                            denyButtonText: `View`,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var downloadLink = document.createElement(
                                    "a");
                                downloadLink.href = fileUrl;
                                downloadLink.download = file.name;
                                document.body.appendChild(downloadLink);
                                downloadLink.click();
                                document.body.removeChild(downloadLink);
                            } else if (result.isDenied) {
                                window.open(fileUrl, '_blank');
                            }
                        });
                    });
                });
            },
            renameFile: function(file) {
                var dt = new Date();
                var date = dt.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit'
                }).replace(/\//g, '-');
                var time = dt.getTime();
                var name = file.name;
                var ext = name.substring(name.lastIndexOf('.')); // gets the file extension
                var newName = date + '_' + time + '_' + name.replace(ext, '') +
                    ext; // prepend date and timestamp before the name, and keep the extension at the end
                return newName;
            },
            timeout: 5000,
            success: function(file, response) {
                console.log(response);
            },
            error: function(file, response) {
                return false;
            }
        });

        $('#uploaddAuditLetterFileModal').on('hidden.bs.modal', function() {
            var auditLetterFileForm = $('#auditLetterFileForm')[0];
            auditLetterFileForm.reset();
            $('#auditLetterFileForm').empty();
        });
    });
</script>
