<div class="modal fade" id="uploadRequiredAuditFileModal" tabindex="-1" aria-labelledby="uploadRequiredAuditFileModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadRequiredAuditFileTitle">Upload Required File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="auditRequiredFileForm" enctype="multipart/form-data"
                    class="dropzone mt-4 border-dashed" action="{{ route('required-audit-file.store') }}">
                    @csrf
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" value="" id="hidden_id">
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    Dropzone.autoDiscover = false;
    var uploadRequiredFileDropzone;
    $(document).ready(function() {
        uploadRequiredFileDropzone = new Dropzone("#auditRequiredFileForm", {
            clickable: true,
            init: function() {
                this.on("sending", function(file, xhr, formData) {
                    // Get the value from the hidden input
                    var hiddenId = $('#hidden_id').val();
                    // Append it to the FormData object
                    formData.append("hidden_id", hiddenId);
                });
                this.on("removedfile", function(file, formData) {
                    var id = file.id;
                    var url = "{{ route('delete-invoice') }}"
                    // Get the value from the hidden input
                    var hiddenId = $('#hidden_id').val();
                    Swal.fire({
                        title: 'Confirm File Removal',
                        text: 'Are you sure you want to remove this file?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, remove it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url, // Replace with your delete file route
                                method: "POST",
                                data: {
                                    id: id,
                                    hiddenId: hiddenId,
                                    _token: "{{ csrf_token() }}"
                                },
                                dataType: "json",
                                success: function(response) {
                                    console.log(response);
                                },
                                error: function(xhr, textStatus,
                                    errorThrown) {
                                    console.error(textStatus);
                                }
                            });
                        } else {
                            Swal.fire(
                                'Cancelled',
                                'Your file is safe :)',
                                'error'
                            )
                        }
                    })

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
            addRemoveLinks: true,
            timeout: 5000,
            success: function(file, response) {
                console.log(response);
            },
            error: function(file, response) {
                return false;
            }
        });

        $('#uploadRequiredAuditFileModal').on('hidden.bs.modal', function() {
            var auditRequiredFileForm = $('#auditRequiredFileForm')[0];
            auditRequiredFileForm.reset();
            $('#auditRequiredFileForm').empty();
        });

    });
</script>
