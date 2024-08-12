<style>
    .wider-card {
        width: 100%;
        /* Set width to 100% to make it wider */
        max-width: 350px;
        /* Adjust the max-width as needed */
    }
</style>
<div class="card"
    style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h4>{{ $leads->GeneralInformation->firstname . ' ' . $leads->GeneralInformation->lastname }}</h4>
                <div class="">
                    {{ $leads->GeneralInformation->job_position }}
                </div>
                <div class="">
                    {{ $leads->company_name }}
                </div>
                <div class="">
                    {{ $leads->GeneralInformation->email_address }}
                </div>
                <div>
                    <b>{{ $leads->tel_num }}</b>
                </div>
            </div>


            <div></div>

            <div class="d-flex">
                <div class="mr-2" style="margin-right: .5rem">
                    <button class="btn btn-outline-primary waves-effect waves-light btn-lg btnEdit"
                        id="editGeneralInformationButton" name="edit" type="button">EDIT</button>
                </div>
                <div class="mr-2" style="margin-right: .5rem">
                    <button
                        class="btn btn-outline-success waves-effect waves-light
                        btn-lg addProductButton"
                        id="addProductButton" name="addProduct" type="button">ADD PRODUCT</button>

                </div>
            </div>
        </div>

        <ul class="nav nav-tabs nav-tabs-custom nav-justified mb-0" role="tablist" style="margin-top: 1rem">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#summary" role="tab">
                    <span class="d-none d-sm-block d-flex align-items-center justify-content-center">
                        Summary
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#product" role="tab">
                    <span class="d-none d-sm-block d-flex align-items-center justify-content-center">
                        {{ $product->product }} Information
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#activityLog" role="tab">
                    <span class="d-none d-sm-block d-flex align-items-center justify-content-center">History Log</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#quotation" role="tab">
                    <span class="d-none d-sm-block d-flex align-items-center justify-content-center">Quotation</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab">
                    <h5><i class="ri-file-edit-line"></i></h5>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#accounting" role="tab">
                    <h5><i class="ri-hand-coin-line"></i></h5>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#financingAgreement" role="tab">
                    <h5><i class="ri-file-shield-2-line"></i></h5>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#bindingDocs" role="tab">
                    <h5>binding docs</h5>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#emails" role="tab">
                    <h5><i class="ri-mail-send-line"></i></h5>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#policyList" role="tab">
                    <h5><i class="ri-folders-line"></i></h5>
                </a>
            </li>
        </ul>
    </div>
</div>
<script>
    $(document).ready(function() {
        Dropzone.autoDiscover = false;
        var myDropzone;
        var dropzoneElement = document.querySelector("#resendRTBDropzone");

        if (dropzoneElement) {
            myDropzone = new Dropzone("#resendRTBDropzone", {
                url: "{{ route('upload-file-binding-docs') }}",
                method: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                autoProcessQueue: true,
                clickable: true,
                addRemoveLinks: true,
                maxFiles: 10,
                init: function() {
                    this.on("addedfile", function(file) {
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
                                    var downloadLink = document
                                        .createElement("a");
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
                    this.on('sending', function(file, xhr, formData) {
                        formData.append('hiddenId', {!! json_encode($product->id) !!})
                    });
                    this.on('removedfile', function(file) {
                        $.ajax({
                            url: "{{ route('delete-binding-docs') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            method: "POST",
                            data: {
                                id: file.id
                            },
                            success: function() {
                                // Optional: Handle success
                            },
                            error: function() {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Something went wrong',
                                    icon: 'error'
                                });
                            }
                        });
                    });
                }
            });
        } else {
            console.error("Dropzone element not found");
        }

        function addExistingFiles(files) {
            files.forEach(file => {
                var mockFile = {
                    id: file.id,
                    name: file.basename,
                    size: parseInt(file.size),
                    type: file.type,
                    status: Dropzone.ADDED,
                    url: file.filepath // URL to the file's location
                };
                myDropzone.emit("addedfile", mockFile);
                // myDropzone.emit("thumbnail", mockFile, file.filepath); // If you have thumbnails
                myDropzone.emit("complete", mockFile);
            });
        };

        $('#addProductButton').on('click', function() {
            var url = "{{ env('APP_FORM_URL') }}";
            var id = "{{ $leads->id }}";
            $.ajax({
                url: "{{ route('list-lead-id') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                method: 'POST',
                data: {
                    leadId: id,
                },
            });
            window.open(`${url}add-product-form`, "s_blank",
                "width=1000,height=849");
        });

        $('#saveStatusButton').on('click', function() {
            var status = $('#statusSelect').val();
            if (status == 17) {
                $('#requestToBindModal').modal('show');
            } else if (status == 18) {
                $.ajax({
                    url: "{{ route('get-binding-docs') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data: {
                        id: {!! json_encode($product->id) !!}
                    },
                    success: function(data) {
                        addExistingFiles(data);
                        $('#resendRTBModal').modal('show');
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Something went wrong',
                            icon: 'error'
                        });
                    }
                })
            } else {
                $.ajax({
                    url: "{{ route('change-quotation-status') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data: {
                        status: status,
                        id: {!! json_encode($product->id) !!}
                    },
                    success: function() {
                        Swal.fire({
                            title: 'Success',
                            text: 'has been saved',
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Something went wrong',
                            icon: 'error'
                        });
                    }
                })
            }

        });

        $('#changeStatusButton').on('click', function() {
            $.ajax({
                url: "{{ route('resend-rtb') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                data: {
                    id: {!! json_encode($product->id) !!},
                    status: 18,
                },
                success: function() {
                    Swal.fire({
                        title: 'Success',
                        text: 'has been saved',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Something went wrong',
                        icon: 'error'
                    });
                }
            })
        });

    });
</script>
