@extends('admin.admin_master')
@section('admin')
    <style>
        /* Define the grid container */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            grid-gap: 20px;
            position: relative;
            /* Ensures the spinner can be centered inside */
            height: 300px;
            /* Define the height for the grid container */
        }

        /* Ensure the cards take full width of the grid item */
        .file-card {
            width: 100%;
        }

        /* Hover effect for cards */
        .file-card:hover {
            transform: scale(1.02);
            transition: transform 0.2s ease-in-out;
        }

        /* Center the spinner within its container */
        .spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
            /* Ensure the spinner is centered within full width */
            position: absolute;
            top: 0;
            left: 0;
            transform: translate(0, 0);
            /* Reset transformation since we centered it using Flexbox */
        }

        .spin-icon {
            font-size: 2em;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        /* Adjust Dropzone styling */
        .dropzone {
            border: 2px dashed #007bff;
            border-radius: 5px;
            background: #f9f9f9;
            padding: 30px;
            text-align: center;
        }

        .dz-message {
            font-size: 1.2em;
            color: #6c757d;
        }

        .dz-progress {
            width: 100%;
            height: 6px;
            background-color: #e6e6e6;
            margin-top: 10px;
            position: relative;
        }

        .dz-upload {
            display: block;
            height: 100%;
            background-color: #007bff;
            transition: width 0.3s ease;
            width: 0;
        }

        .dz-error-message {
            color: red;
            font-size: 12px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                {{-- User Files Uploader --}}
                <div class="card">
                    <div class="card-body" id="fileUploader">
                        <h4 class="card-title">Upload your files</h4>
                        <p class="card-title-desc">Drag your pdf on the box below. <mark>Max size: 30mb</mark> <mark>Max
                                file per upload: 5</mark></p>
                        <form class="dropzone mt-4 dz-clickable" id="fileUploaderForm" enctype="multipart/form-data">
                            @csrf
                            <div class="dz-message">
                                <div class="mb-3">
                                    <i class="display-4 text-muted ri-upload-cloud-2-line"></i>
                                </div>
                                <h4>Drop your file here or click to upload.</h4>
                            </div>

                            <div class="dz-preview dz-file-preview" style="display:none;">
                                <div class="dz-details">
                                    <div class="dz-filename"><span data-dz-name></span></div>
                                    <div class="dz-size" data-dz-size></div>
                                </div>
                                <div class="dz-progress">
                                    <span class="dz-upload" data-dz-uploadprogress></span>
                                </div>
                                <div class="dz-error-message"><span data-dz-errormessage></span></div>
                            </div>

                            <div class="d-flex align-items-center justify-content-center gap-2 mb-4">
                                <label class="m-0">Tags:</label>
                                <select class="form-control select2" name="tags[]" id="tags" multiple="multiple"
                                    style="width: 50%"></select>
                                <i class="ri ri-information-fill" style="font-size: 1.5em;" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-original-title="Please put meaningful tags as it will be used to identify the file."></i>
                            </div>
                        </form>
                        <div class="d-flex align-items-center justify-content-center">
                            <button type="button" id="uploadBtn" class="btn btn-primary ladda-button mt-4"
                                data-style="expand-right">Upload
                                Files</button>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-body" id="fileContainer" style="overflow-y: auto;">
                        <h4 class="card-title">Browse Files</h4>
                        <p class="card-title-desc">Browse files below to edit.</p>
                        <!-- Message Status for displaying alerts -->
                        <!-- File Lists Grid -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda-themeless.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/spin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.min.js"></script>
    {{-- Fancybox --}}
    <script>
        // Initialize FancyBox with afterShow callback
        $('[data-fancybox]').fancybox({
            toolbar: true,
            smallBtn: false,
            iframe: {
                // Set the dimensions to a percentage of the viewport
                css: {
                    width: '80%',
                    height: '90%'
                }
            },
            buttons: [
                'zoom',
                'download',
                'close'
            ],
            responsive: {
                0: {
                    iframe: {
                        css: {
                            width: '100%',
                            height: '100%'
                        }
                    }
                },
                768: {
                    iframe: {
                        css: {
                            width: '80%',
                            height: '90%'
                        }
                    }
                }
            }
        });
    </script>
    {{-- Dropzone & Ajax Functionality --}}
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            var laddaButton = Ladda.create(document.querySelector('#uploadBtn'));
            // Initialize Select2
            $('#tags').select2({
                placeholder: "Type your tags here...",
                allowClear: true,
                tags: true
            });
            // PDF User Files Uploader
            var fileUploaderDz = new Dropzone("#fileUploader", {
                url: "{{ route('pdf-file.store') }}",
                clickable: true,
                autoProcessQueue: false,
                acceptedFiles: "application/pdf",
                maxFiles: 5,
                maxFilesize: 30,
                uploadMultiple: false,
                paramName: 'file',
                previewsContainer: '.dz-file-preview',
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                init: function() {
                    var myDropzone = this;
                    // Hide .dz-message when a file is added
                    this.on("addedfile", function() {
                        $('.dz-message').hide(); // Hide the message
                        $('.dz-preview').show(); // Hide the message
                    });
                    // Show .dz-message again if no files are left
                    this.on("removedfile", function() {
                        if (myDropzone.files.length === 0) {
                            $('.dz-message').show(); // Show the message again
                            $('.dz-preview').hide(); // Show the message again
                        }
                    });
                    this.on("uploadprogress", function(file, progress, bytesSent) {
                        console.log(`Progress: ${progress}% for ${file.name}`);
                        var progressElement = file.previewElement.querySelector(".dz-upload");
                        if (progressElement) {
                            progressElement.style.width = progress +
                                "%"; // Update the width of the progress bar
                        }
                    });
                    // Trigger file upload manually when the button is clicked
                    $('#uploadBtn').on('click', function(e) {
                        e.preventDefault();
                        // Ensure files have been added to the queue
                        if (myDropzone.getQueuedFiles().length > 0) {
                            laddaButton.start();
                            var selectedTags = $("#tags").val();
                            var tagValues = selectedTags.map(tag => tag);
                            myDropzone.on("sending", function(file, xhr, formData) {
                                formData.append('tags', JSON.stringify(tagValues));
                            });
                            myDropzone.processQueue(); // Manually trigger the file upload
                        } else {
                            alert('Please select a file to upload.');
                        }
                    });
                    this.on("success", function(file, response) {
                        $('#fileSpinner').hide();
                        laddaButton.stop();
                        if (response.status === 'success') {
                            fileUploaderDz.removeAllFiles(true);
                            $("#tags").val(null).trigger("change");
                            fetchDocuments();
                        }
                    });
                    this.on("error", function(file, errorMessage) {
                        $('#fileSpinner').hide();
                        laddaButton.stop();
                        $("#tags").val(null).trigger("change");
                        alert("Error uploading file: " + (errorMessage.message || JSON
                            .stringify(errorMessage)));
                    });
                },

            });
            // Initial fetch of documents
            fetchDocuments();
            // Delete File function
            $(document).on('click', '.delete-btn', async function(e) {
                var id = $(this).data('id');
                if (!id) {
                    alert('Something went wrong. Please refresh the page.');
                    return;
                }
                if (confirm('Are you sure you want to delete this file?')) {
                    var cardSpinnerDiv = `
                        <div class="spinner bg-secondary" id="cardSpinnerDiv" style="opacity: 0.5;">
                            <i class="ri-loader-line spin-icon" id="cardSpinner" style="display:block;"></i>
                        </div>
                    `;
                    $(`#file-card-${id}`).append(cardSpinnerDiv);
                    try {
                        const response = await $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            url: "{{ route('pdf-file.delete') }}",
                            type: 'DELETE',
                            data: {
                                documentId: id
                            },
                        });
                        $(`#file-card-${id} #cardSpinnerDiv`).remove();
                        if (response.status === 'success') {
                            // fetchDocuments();
                            $(`#file-card-${id}`).remove();
                            alert(response.message || 'File deleted successfully');
                        } else {
                            alert(response.message || 'Failed to delete the file');
                        }
                    } catch (error) {
                        $(`#file-card-${id} #cardSpinnerDiv`).remove();
                        alert('Error deleting the file. Please try again.');
                    }
                }
            });
            // Download File function
            $(document).on('click', '.download-btn', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                if (!id) {
                    alert('Something went wrong. Please refresh the page.');
                    return;
                }
                if (confirm("You want to download this file?")) {
                    var laddaDownloadBtn = Ladda.create(this);
                    laddaDownloadBtn.start();
                    try {
                        fetch("{{ route('pdf-file.download') }}" + "?documentId=" + encodeURIComponent(
                                id), {
                                method: 'GET'
                            })
                            .then(function(response) {
                                if (response.ok) {
                                    return response.blob();
                                } else {
                                    throw new Error('Network response was not ok.');
                                }
                            })
                            .then(function(blob) {
                                var url = window.URL.createObjectURL(blob);
                                var a = document.createElement('a');
                                a.href = url;
                                a.download = id + '.pdf';
                                document.body.appendChild(a);
                                a.click();
                                a.remove();
                                window.URL.revokeObjectURL(url);
                            })
                            .catch(function(error) {
                                alert('Error downloading the file. Please try again.');
                            })
                            .finally(function() {
                                laddaDownloadBtn.stop();
                            });
                    } catch (error) {
                        laddaDownloadBtn.stop();
                        alert('Error downloading the file. Please try again.');
                    }
                }
            });
        });

        // Fetch list of documents
        async function fetchDocuments() {
            var fileContainer = $("#fileContainer");
            fileContainer.find('.spinner').remove();
            fileContainer.append(`
                <div class="spinner bg-white" style="opacity:1;">
                    <i class="ri-loader-line spin-icon" id="fileSpinner" style="display:block;"></i>
                </div>
            `);
            try {
                const response = await $.ajax({
                    url: "{{ route('pdf-file.fetch') }}",
                    type: 'GET',
                });
                fileContainer.find(".file-lists").remove(); // Remove old file list
                if (response.status === 'success') {
                    const files = response.documentLinks;
                    if (files.length > 0) {
                        fileContainer.find("#msgStatus").remove();
                        fileContainer.append(`<div class="file-lists grid-container"></div>`);
                        $.each(files, function(index, file) {
                            let tagValues = '';
                            if (file.document.tagNames.length > 0) {
                                tagValues += `<p class="m-0">Tags: </p>`;
                                tagValues += file.document.tagNames.map(tag => {
                                    return `<span class="badge bg-primary">${tag}</span>`;
                                }).join(' ');
                            }

                            const fileHtml = `
                                <div class="card file-card" id="file-card-${file.document.id}">
                                    <div class="card-body gap-8">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">${file.document.filename}</h4>
                                            <div class="dropdown float-end">
                                                <a href="#" class="dropdown-toggle arrow-none card-drop"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="${file.link.data.link}" data-fancybox data-type="iframe"
                                                        class="dropdown-item">
                                                        <i class="ri-edit-box-line align-middle me-2"></i> Edit PDF
                                                    </a>
                                                    <button type="button" data-id="${file.document.id}"
                                                        class="dropdown-item delete-btn">
                                                        <i class="ri-delete-bin-2-line align-middle me-2"></i> Delete File
                                                    </button>
                                                    <button type="button" data-id="${file.document.id}"
                                                        class="dropdown-item ladda-button download-btn" data-style="expand-right">
                                                        <i class="ri-download-2-line align-middle me-2"></i> Download File
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-start align-items-center gap-2">
                                            ${tagValues}
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <img src="{{ asset('backend/assets/images/pdf-placeholder.png') }}" class="img-fluid"
                                                width="150" height="150" alt="PDF Placeholder">
                                        </div>
                                    </div>
                                </div>
                            `;

                            $('.file-lists').append(fileHtml);
                        });
                    } else {
                        fileContainer.append(`<div id="msgStatus"></div>`);
                        $('#msgStatus').html(`<div class="alert alert-warning">No files found.</div>`);
                    }
                } else {
                    alert('Failed to fetch documents. Please reload the page.');
                }
            } catch (error) {
                console.log(error);
            } finally {
                // Remove the spinner
                fileContainer.find('.spinner').remove();
            }
        }
    </script>
@endsection
