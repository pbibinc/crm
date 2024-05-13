@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">

                </div>
                <div class="col-2">

                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('export-payment-list') }}" id="accountingForChargedForm">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label for="startExportDate">Start Date</label>
                                        <input class="form-control" type="date" value="{{ date('Y-m-d') }}"
                                            id="startExportDate" name="startExportDate">
                                    </div>
                                    <div class="col-6">
                                        <label for="endExrportDate">End Date</label>
                                        <input class="form-control" type="date" value="{{ date('Y-m-d') }}"
                                            id="endExrportDate" name="endExportDate">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <button class="btn btn-success" id="exportButton" type="submit">Export</button>
                                    </div>
                                    <div class="col-4">

                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <table id="accountsCharged" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Product</th>
                                            <th>Company Name</th>
                                            <th>Payment Method</th>
                                            <th>Amount</th>
                                            <th>Compliance</th>
                                            <th>Type</th>
                                            <th>Charged By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.accounting.accounts-for-charged.edit')
            {{-- @include('admin.accounting.accounts-for-charged.file-edit') --}}

            <div class="modal fade" id="fileEditModal" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="fileEditModalTitle">Payment Form</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="fileEditForm" enctype="multipart/form-data"
                                class="dropzone mt-4 border-dashed" action="{{ route('upload-invoice') }}">
                                @csrf
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" value="" id="hidden_id">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        Dropzone.autoDiscover = false;
        var myDropzone;
        $(document).ready(function() {
            $('#accountsCharged').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('payment-for-charged') }}",
                columns: [{
                        data: 'charged_date',
                        name: 'charged_date'
                    },
                    {
                        data: 'product_name',
                        name: 'product_name'
                    }, {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method'
                    },
                    {
                        data: 'amount_to_charged',
                        name: 'amount_to_charged'
                    },
                    {
                        data: 'compliance',
                        name: 'compliance'
                    },
                    {
                        data: 'payment_type',
                        name: 'payment_type'
                    },
                    {
                        data: 'charged_by',
                        name: 'charged_by'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                "order": [
                    [0, "desc"]
                ]
            });

            $(document).on('click', '.editPaymentButton', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var paymentType = $(this).data('payment-type');
                $.ajax({
                    url: "{{ route('payment-charged.edit') }}",
                    method: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#invoiceNumber').val(data.paymentCharged.invoice_number);
                        $('#paymentChargedId').val(data.paymentCharged.id);
                        $('#paymentType').val(paymentType);
                        $('#modalForm').modal('show');
                        // console.log(data);
                    }
                })
            });

            myDropzone = new Dropzone("#fileEditForm", {
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

            $('#fileEditModal').on('hide.bs.modal', function() {
                $(".dropzone .dz-preview").remove(); // This removes file previews from the DOM
                myDropzone.files.length = 0;
            });

            $(document).on('click', '.editFilePaymentButton', function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    },
                    url: "{{ route('get-invoice-media') }}",
                    method: 'POST',
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        // $('#viewInvoiceModal').modal('show');
                        // $('#viewInvoiceModalBody').html(data);
                        // console.log(data);
                        $('#hidden_id').val(id);
                        addExistingFiles(data.media);
                        $('#fileEditModal').modal('show');
                    }
                });
            });

            // $('#accountingForChargedForm').submit(function(e) {
            //     e.preventDefault();
            //     $.ajax({
            //         headers: {
            //             'X-CSRF-TOKEN': "{{ csrf_token() }}"
            //         },
            //         url: "{{ route('export-payment-list') }}",
            //         method: "GET",
            //         data: $(this).serialize(),
            //         dataType: "json",
            //         success: function(data) {
            //             Swal.fire({
            //                 icon: 'success',
            //                 title: 'Success!',
            //                 text: 'Payment has been updated!',
            //             }).then((result) => {
            //                 if (result.isConfirmed) {
            //                     $('#modalForm').modal('hide');
            //                     $('#accountsCharged').DataTable().ajax.reload();
            //                 }
            //             })
            //         }
            //     })
            // });

        });
    </script>
@endsection
