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
                        <h4 class="card-title">OCR PDF

                            <i class="ri ri-information-fill" style="font-size: 1.5em;" data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                data-bs-original-title="The content of the PDF is scanned, and data extraction occurs based on the keywords provided in the values."></i>
                        </h4>

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

                            <div class="d-flex align-items-center gap-1">
                                <label class="m-0">Keywords:</label>
                                <select class="form-control select2" name="keywords[]" multiple="multiple"
                                    style="width: 100%"></select>
                                <i class="ri ri-information-fill" style="font-size: 1.5em;" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-original-title="Key-value pairs used for data
                                    extraction. A key acts as an identifier for the extracted data. A value is a keyword
                                    used for searching data within the PDF. Ex: {'givenName':'Given
                                    Name','address1':'Address 1','city':'City'}"></i>
                            </div>

                            <button type="button" id="uploadBtn" class="btn btn-primary mt-4 cursor-pointer">Upload and
                                Convert</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body" id="resultContainer" style="overflow-y: auto;">
                        <h4 class="card-title">Results</h4>
                        <p class="card-title-desc">Check the results below.</p>

                        <!-- Message Status for displaying alerts -->
                        <div id="msgStatus"></div>

                        <!-- Results Grid -->
                        <div class="results grid-container">
                            <!-- Spinner -->
                            <div class="spinner">
                                <i class="ri-loader-line spin-icon" id="fileSpinner" style="display:none;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- Fancybox --}}
    <script>
        // Initialize FancyBox with afterShow callback
        $('[data-fancybox]').fancybox({
            iframe: {
                css: {
                    width: '100%',
                    height: '100%'
                }
            }
        });
    </script>
    {{-- Dropzone & Ajax Functionality --}}
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                placeholder: "Select an option",
                allowClear: true,
                tags: true
            });

            // PDF User Files Uploader
            var fileUploaderDz = new Dropzone("#fileUploader", {
                url: "{{ route('ocr-pdf.store') }}",
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
                            $('#fileSpinner').show(); // Show spinner

                            // Retrieve the selected tags from Select2 (as an array of values)
                            var selectedKeywords = $('.select2').val();

                            // Ensure it's only an array of values
                            var keywordValues = selectedKeywords.map(keyword => keyword);

                            // Append tags to Dropzone's form data
                            myDropzone.on("sending", function(file, xhr, formData) {
                                // Pass tags as an array without keys (only values)
                                formData.append('keywords', JSON.stringify(
                                    keywordValues));

                            });
                            myDropzone.processQueue(); // Manually trigger the file upload
                        } else {
                            alert('Please select a file to upload.');
                        }
                    });
                    this.on("success", function(file, response) {
                        $('#fileSpinner').hide();
                        if (response.status === 'success') {
                            fileUploaderDz.removeAllFiles(true);
                            fetchDocuments();
                        }
                    });
                    this.on("error", function(file, errorMessage) {
                        $('#fileSpinner').hide();
                        alert("Error uploading file: " + (errorMessage.message || JSON
                            .stringify(errorMessage)));
                    });
                },

            });
        });
    </script>
@endsection
