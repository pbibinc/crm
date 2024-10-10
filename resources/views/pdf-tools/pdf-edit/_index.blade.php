@extends('admin.admin_master')
@section('admin')
    <style>
        .pdfSpinner {
            width: 50px;
            padding: 8px;
            aspect-ratio: 1;
            border-radius: 50%;
            background: #25b09b;
            --_m:
                conic-gradient(#0000 10%, #000),
                linear-gradient(#000 0 0) content-box;
            -webkit-mask: var(--_m);
            mask: var(--_m);
            -webkit-mask-composite: source-out;
            mask-composite: subtract;
            animation: l3 1s infinite linear;
        }

        @keyframes l3 {
            to {
                transform: rotate(1turn)
            }
        }

        .pdf-thumbnail {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .pdf-card:hover .pdf-thumbnail {
            transform: scale(1.05);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .pdf-card:hover .btn-primary {
            background-color: #25b09b;
            border-color: #25b09b;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">

    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                {{-- User Files Uploader --}}
                <div class="card">
                    <div class="card-body" id="pdfUserFilesUploader">
                        <h4 class="card-title">Upload your files</h4>
                        <p class="card-title-desc">Drag your pdf on the box below. <mark>Max size: 30mb</mark> <mark>Max
                                file per upload: 5</mark></p>
                        <form class="dropzone mt-4 dz-clickable" style="border-style:dashed;" id="pdfUploader"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="dz-message needsclick">
                                <div class="mb-3">
                                    <i class="display-4 text-muted ri-upload-cloud-2-line"></i>
                                </div>
                                <h4>Drop your file here or click to upload. The files will be displayed on Browse files
                                    section.
                                </h4>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- Template Files Uploader --}}
                <div class="card">
                    <div class="card-body" id="pdfTemplateFilesUploader">
                        <h4 class="card-title">Upload Templates</h4>
                        <p class="card-title-desc">Upload your templates here. <mark>Max size: 30mb</mark> <mark>Max file
                                per upload:
                                5</mark></p>
                        <form class="dropzone mt-4 dz-clickable" style="border-style:dashed;" id="templateUploader"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="dz-message needsclick">
                                <div class="mb-3">
                                    <i class="display-4 text-muted ri-upload-cloud-2-line"></i>
                                </div>
                                <h4>Drop your file here or click to upload. The files will be displayed on Browse templates
                                    section.
                                </h4>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body" id="templatesContainer" style="overflow-y: auto;">
                        <h4 class="card-title">Browse Templates</h4>
                        <p class="card-title-desc">Browse templates below to edit.</p>
                        {{-- Template Files Cards --}}
                        @if (count($template_files) > 0)
                            <div class="d-flex justify-content-start gap-2">
                                @foreach ($template_files as $template_file)
                                    <div class="card" style="width: 18rem;">
                                        {{-- <canvas id="pdf-thumbnail-{{ $template_file->id }}"
                                            class="card-img-top pdf-thumbnail" style="width: 100%;"></canvas> --}}
                                        <div class="card-body">
                                            <h4 class="card-title">{{ $template_file->template_name }}</h4>
                                            {{-- <p class="card-text">Some quick example text to build on the card title and make
                                                up the bulk of the card's content.</p> --}}
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><em>Upload Date:
                                                    {{ Carbon\Carbon::parse($template_file->created_at)->format('M-j-Y g:iA') }}</em>
                                            </li>
                                            <li class="list-group-item"><em>Uploaded By:
                                                    {{ $template_file->uploadedBy->firstname . ' ' . $template_file->uploadedBy->lastname }}</em>
                                            </li>
                                        </ul>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ asset($template_file->media->filepath) }}" data-fancybox
                                                    data-type="iframe" class="btn btn-primary">Open PDF</a>
                                                <button type="button"
                                                    class="btn btn-danger waves-effect waves-light">Delete
                                                    File</button>
                                            </div>
                                            <input type="hidden" id="filepathval-{{ $template_file->id }}"
                                                value="{{ asset($template_file->media->filepath) }}" class="filepathval" />
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-warning" role="alert">
                                    No files uploaded yet.
                                </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body" id="customUploadContainer" style="overflow-y: auto;">
                    <h4 class="card-title">Browse files</h4>
                    <p class="card-title-desc">Browse your uploaded files below to edit.</p>
                    {{-- User Files Card --}}
                    @if (count($user_files) > 0)
                        <div class="d-flex justify-content-start gap-2">
                            @foreach ($user_files as $user_file)
                                <div class="card userFileCard" id="${response.file.document_id}" style="width: 18rem;">
                                    <div class="card-body">
                                        <h4 class="card-title file-name">Filename: {{ $user_file->filename }}</h4>
                                        <h6 class="card-subtitle font-14 text-muted file-upload-date">Upload Date:
                                            {{ Carbon\Carbon::parse($user_file->created_at)->format('M-j-Y g:iA') }}
                                        </h6>
                                    </div>
                                    {{-- <canvas id="pdf-thumbnail-{{ $user_file->id }}" class="card-img-top pdf-thumbnail"
                                        style="width: 100%;"></canvas> --}}
                                    <div class="card-body text-center">
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ asset($user_file->filepath) }}" data-fancybox data-type="iframe"
                                                class="btn btn-primary">Open PDF</a>
                                            <button type="button" class="btn btn-danger waves-effect waves-light">Delete
                                                File</button>
                                        </div>
                                    </div>
                                    <input type="hidden" id="filepathval-{{ $user_file->id }}"
                                        value="{{ asset($user_file->filepath) }}" class="filepathval" />
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning" role="alert">
                            No files uploaded yet.
                        </div>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-body" id="pdfEditor" style="display:none;"></div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.8.335/pdf.min.js"></script>
    {{-- PDF JS --}}
    <script>
        $(document).ready(function() {
            // Loop through all the hidden inputs with class 'filepathval' to load PDF thumbnails
            $('.filepathval').each(function() {
                var filePath = $(this).val();
                var fileId = $(this).attr('id').split('-')[1]; // Extract the file ID from the input ID

                // Fetch the canvas element by the dynamically generated ID
                var canvas = document.getElementById(`pdf-thumbnail-${fileId}`);

                // Ensure canvas exists before processing
                if (canvas) {
                    var context = canvas.getContext('2d');

                    // Load PDF using PDF.js
                    pdfjsLib.getDocument(filePath).promise.then(function(pdfDoc) {
                        // Fetch the first page
                        pdfDoc.getPage(1).then(function(page) {
                            var viewport = page.getViewport({
                                scale: 1.5
                            }); // Adjust scale for a better quality thumbnail

                            // Set canvas dimensions based on the viewport
                            canvas.height = viewport.height;
                            canvas.width = viewport.width;

                            // Prepare render context
                            var renderContext = {
                                canvasContext: context,
                                viewport: viewport
                            };

                            // Render the page into the canvas
                            page.render(renderContext).promise.then(function() {
                                console.log(
                                    `Rendered thumbnail for file ID: ${fileId}`);
                            });
                        });
                    }).catch(function(error) {
                        console.error(`Error rendering PDF for file ID: ${fileId}`, error);
                    });
                }
            });
        });
    </script>
    {{-- Fancybox --}}
    <script>
        // Initialize FancyBox with afterShow callback
        $('[data-fancybox]').fancybox({
            iframe: {
                css: {
                    width: '100%',
                    height: '100%'
                }
            },
            afterShow: function(instance, current) {
                // Add a custom button dynamically
                var fileEditBtn =
                    '<button type="button" class="btn btn-primary waves-effect waves-light edit-file" style="position:absolute; bottom:20px; left:50%; transform:translateX(-50%); padding:10px 20px;">Edit File to Editor <i class="ri-arrow-right-line align-middle ms-2"></i></button>';

                // Append the button to FancyBox's content
                $('.fancybox-content').append(fileEditBtn);

                // Add event listener to the button
                $('.edit-file').each(function() {
                    $(this).on('click', function() {

                    });
                });
            }
        });
    </script>
    {{-- Dropzone --}}
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            // PDF User Files Uploader
            var userFilesDropzone = new Dropzone("#pdfUserFilesUploader", {
                url: "{{ route('pdf-users-files.store') }}",
                clickable: true,
                acceptedFiles: "application/pdf",
                maxFiles: 5,
                maxFilesize: 30,
                uploadMultiple: false,
                paramName: 'file',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                init: function() {
                    this.on("success", function(file, response) {
                        console.log(response);

                        if (response.status === 'success') {
                            // Clear the Dropzone form
                            userFilesDropzone.removeAllFiles();

                            // Append the new file to the customUploadContainer
                            var uploadedFileHTML = `
                                <div class="card userFileCard" id="${response.file.document_id}" style="width: 18rem;">
                                    <div class="card-body">
                                        <h4 class="card-title">Filename: ${response.file.filename}</h4>
                                        <h6 class="card-subtitle font-14 text-muted">Upload Date: ${response.file.upload_date}</h6>
                                    </div>
                                    <canvas id="pdf-thumbnail-${file.upload.uuid}" class="card-img-top pdf-thumbnail" style="width: 100%;"></canvas>
                                    <div class="card-body text-center">
                                        <div class="d-flex justify-content-between">
                                            <a href="${response.file.filepath}" data-fancybox data-type="iframe" class="btn btn-primary">Open PDF</a>
                                            <button type="button" class="btn btn-danger waves-effect waves-light">Delete File</button>
                                        </div>
                                    </div>
                                </div>
                            `;

                            $("#customUploadContainer .d-flex").prepend(uploadedFileHTML);

                            // Render PDF thumbnail using PDF.js
                            var pdfUrl = response.file.filepath;
                            pdfjsLib.getDocument(pdfUrl).promise.then(function(pdfDoc) {
                                pdfDoc.getPage(1).then(function(page) {
                                    var canvas = document.getElementById(
                                        `pdf-thumbnail-${file.upload.uuid}`);
                                    var context = canvas.getContext('2d');
                                    var viewport = page.getViewport({
                                        scale: 0.3
                                    });

                                    canvas.height = viewport.height;
                                    canvas.width = viewport.width;

                                    var renderContext = {
                                        canvasContext: context,
                                        viewport: viewport
                                    };

                                    page.render(renderContext);
                                });
                            });
                        }
                    });
                    this.on("error", function(file, errorMessage) {
                        alert("Error uploading file: " + (errorMessage.message || JSON
                            .stringify(errorMessage)));
                    });
                }
            });

            // Tempalte Files Uploader
            var templateFilesDropzone = new Dropzone("#pdfTemplateFilesUploader", {
                url: "{{ route('pdf-template-files.store') }}",
                clickable: true,
                acceptedFiles: "application/pdf",
                maxFiles: 5,
                maxFilesize: 30,
                uploadMultiple: false,
                paramName: 'file',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                init: function() {
                    this.on("success", function(file, response) {
                        console.log(response);

                        if (response.status === 'success') {
                            // Clear the Dropzone form
                            templateFilesDropzone.removeAllFiles();

                            var uploadedFileHTML = `
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                        <h4 class="card-title">Filename: ${response.file.filename}</h4>
                                        <h6 class="card-subtitle font-14 text-muted">Upload Date: ${response.file.upload_date}</h6>
                                    </div>
                                    <canvas id="pdf-thumbnail-${file.upload.uuid}" class="card-img-top pdf-thumbnail" style="width: 100%;"></canvas>
                                    <div class="card-body text-center">
                                        <div class="d-flex justify-content-between">
                                            <a href="${response.file.filepath}" data-fancybox data-type="iframe" class="btn btn-primary">Open PDF</a>
                                            <button type="button" class="btn btn-danger waves-effect waves-light">Delete File</button>
                                        </div>
                                    </div>
                                </div>
                            `;

                            $("#templatesContainer .d-flex").prepend(uploadedFileHTML);

                            // Render PDF thumbnail using PDF.js
                            var pdfUrl = response.file.filepath;
                            pdfjsLib.getDocument(pdfUrl).promise.then(function(pdfDoc) {
                                pdfDoc.getPage(1).then(function(page) {
                                    var canvas = document.getElementById(
                                        `pdf-thumbnail-${file.upload.uuid}`);
                                    var context = canvas.getContext('2d');
                                    var viewport = page.getViewport({
                                        scale: 0.3
                                    });

                                    canvas.height = viewport.height;
                                    canvas.width = viewport.width;

                                    var renderContext = {
                                        canvasContext: context,
                                        viewport: viewport
                                    };

                                    page.render(renderContext);
                                });
                            });
                        }
                    });
                    this.on("error", function(file, errorMessage) {
                        alert("Error uploading file: " + (errorMessage.message || JSON
                            .stringify(errorMessage)));
                    });
                }
            });

            // Function to load the PDF Editor with the created link
            // function loadPDFEditor(documentId) {
            //     $.ajax({
            //         url: "{{ route('create-pdf-link') }}",
            //         type: "POST",
            //         data: {
            //             _token: "{{ csrf_token() }}",
            //             documentId: documentId
            //         },
            //         success: function(response) {
            //             console.log(response);
            //             if (response.data.link) {
            //                 $('#pdfEditor').html('<iframe src="' + response.data.link +
            //                     '" width="1600" height="1200" frameborder="0" allowfullscreen></iframe>'
            //                 );
            //             } else {
            //                 console.error("Error: " + response.error);
            //                 alert("Error: " + response.error);
            //             }
            //         },
            //         error: function(error) {
            //             console.error("Failed to load PDF editor:", error);
            //             alert("Failed to load PDF editor: " + error.responseText);
            //         }
            //     });
            // }
        });
    </script>
@endsection
