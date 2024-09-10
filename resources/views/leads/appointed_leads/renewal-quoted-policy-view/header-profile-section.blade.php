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
            <div style="font-size: 14px;">
                <h5 style="margin-bottom: 5px;">
                    {{ $leads->GeneralInformation->firstname . ' ' . $leads->GeneralInformation->lastname }}</h5>
                <div>{{ $leads->GeneralInformation->job_position }}</div>
                <div>{{ $leads->company_name }}</div>
                <div>{{ $leads->GeneralInformation->email_address }}</div>
                <div><b>{{ $leads->tel_num }}</b></div>
            </div>
            <div>

            </div>

            {{-- <div class="card wider-card"
                style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 10px;">
                <div class="card-body" style="text-align: center;">
                    <h6 style="margin-bottom: 10px;">Change Status:</h6>
                    <div class="form-group" style="margin-bottom: 10px;">
                        {{ $product->status }}
                        <select class="form-control select2-search-disable" id="statusSelect"
                            style="border: 1px solid #ccc; border-radius: 4px; padding: 6px;">
                            @if ($product->status == 3 || $product->status == 4 || $product->status == 5)
                                <option value="3" @if ($product->status == 3) selected @endif>
                                    Pending
                                </option>
                                <option value="4" @if ($product->status == 4) selected @endif>
                                    Follow
                                    Up</option>
                                <option value="5" @if ($product->status == 5) selected @endif>
                                    Declined</option>
                            @endif
                            @if ($product->status == 11)
                                <option value="11" @if ($product->status == 11) selected @endif>
                                    Bound</option>
                            @endif
                            @if ($product->status == 8)
                                <option value="8" @if ($product->status == 8) selected @endif>
                                    Issued</option>
                            @endif
                            @if ($product->status == 9)
                                <option value="9" @if ($product->status == 9) selected @endif>
                                    Make A Payment</option>
                            @endif
                            @if ($product->status == 17 || $product->status == 10)
                                <option value="17" @if ($product->status == 17) selected @endif>
                                    Request To Bind</option>
                                <option value="10" @if ($product->status == 10) selected @endif>
                                    Payment Approved</option>
                            @endif
                            @if ($product->status == 13)
                                <option value="13" @if ($product->status == 13) selected @endif>
                                    Payment Declined</option>
                            @endif
                            @if ($product->status == 14)
                                <option value="14" @if ($product->status == 14) selected @endif>
                                    Binding Declined</option>
                                <option value="18" @if ($product->status == 18) selected @endif>
                                    Resend RTB</option>
                            @endif
                            @if ($product->status == 18)
                                <option value="18" @if ($product->status == 18) selected @endif>
                                    Resend RTB</option>
                            @endif
                            @if ($product->status == 19)
                                <option value="19" @if ($product->status == 19) selected @endif>
                                    Binding</option>
                            @endif
                            @if ($product->status == 20)
                                <option value="20" @if ($product->status == 20) selected @endif>
                                    Bound</option>
                            @endif
                            @if ($product->status == 12)
                                <option value="12" @if ($product->status == 12) selected @endif>
                                    Binding</option>
                            @endif
                            @if ($product->status == 23)
                                <option value="23" @if ($product->status == 23) selected @endif>
                                    Declined Binding</option>
                                <option value="18" @if ($product->status == 18) selected @endif>
                                    Resend RTB</option>
                            @endif
                        </select>
                    </div>
                    @if ($product->status !== 13 && $product->status !== 9)
                        <button type="button" class="btn btn-success waves-effect waves-light"
                            style="padding: 6px 12px; font-size: 14px;" id="saveStatusButton">Submit</button>
                    @endif

                </div>

            </div> --}}

            <div class="d-flex">
                <div class="mr-2" style="margin-right: .5rem">
                    <button class="btn btn-outline-primary btn-sm btnEdit" id="editGeneralInformationButton"
                        name="edit" type="button">EDIT</button>
                </div>
                <div class="mr-2" style="margin-right: .5rem">
                    <button class="btn btn-outline-success btn-sm addProductButton" id="addProductButton"
                        name="addProduct" type="button">ADD PRODUCT</button>
                </div>
            </div>
        </div>

        <ul class="nav nav-tabs nav-tabs-custom nav-justified mb-0" role="tablist" style="margin-top: 0.5rem;">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#summary" role="tab"
                    style="padding: 5px 10px; font-size: 14px;">
                    Summary
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#product" role="tab"
                    style="padding: 5px 10px; font-size: 14px;">
                    {{ $product->product }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#activityLog" role="tab"
                    style="padding: 5px 10px; font-size: 14px;">
                    History Log
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#quotation" role="tab"
                    style="padding: 5px 10px; font-size: 14px;">
                    Quotation
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab" style="padding: 5px 10px;">
                    <h6><i class="ri-file-edit-line"></i></h6>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#accounting" role="tab" style="padding: 5px 10px;">
                    <h6><i class="ri-hand-coin-line"></i></h6>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#financingAgreement" role="tab"
                    style="padding: 5px 10px;">
                    <h6><i class="ri-file-shield-2-line"></i></h6>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#bindingDocs" role="tab" style="padding: 5px 10px;">
                    <h6>binding docs</h6>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#emails" role="tab" style="padding: 5px 10px;">
                    <h6><i class="ri-mail-send-line"></i></h6>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#policyList" role="tab" style="padding: 5px 10px;">
                    <h6><i class="ri-folders-line"></i></h6>
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
