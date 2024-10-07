<style>
    .message-box {
        max-width: 70%;
        clear: both;
    }

    .message-box.sender {
        margin-left: auto;
        background-color: #DCF8C6;

        /* Green */
        color: black;
        border-radius: 10px 0px 10px 10px !important;
    }

    .message-box.receiver {
        background-color: #f1f1f1;
        color: black;
        padding: 10px;
        border-radius: 0px 10px 10px 10px !important;
    }

    .message-box.receiver.danger {
        background-color: #f8d7da;
        color: black;
        padding: 10px;
        border-radius: 0px 10px 10px 10px !important;
    }

    .message-timestamp {
        font-size: 0.8rem;
        text-align: right;
    }

    .message-info {
        font-size: 0.8rem;
        margin-top: 5px;
    }

    .sender-info {
        text-align: right;
    }

    .message-box.sender.danger {
        margin-left: auto;
        background-color: #f8d7da;
        color: black;
        border-radius: 10px 0px 10px 10px !important;

    }
</style>

<div class="row">
    <table id="requestToBind" class="table table-bordered dt-responsive nowrap requestToBind"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="" style="background-color: #f0f0f0;">
            <th>Company Name</th>
            <th>Product</th>
            <th>Status</th>
            <th>Action</th>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<div class="modal fade" id="resendRTBModal" tabindex="-1" aria-labelledby="addQuoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileViewingModalTitle">File Upload</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" class="dropzone mt-4 border-dashed" id="resendRTBDropzoneBrokerLead"
                    enctype="multipart/form-data">
                </form>
                <input type="hidden" id="mediaIds" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="changeStatusButton" class="btn btn-success">Resend</button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {

        $('.requestToBind').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get-broker-request-to-bind') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                }
            },
            columns: [{
                    data: 'companyName',
                    name: 'companyName'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });


        // $(document).on('click', '.resendBindButton', function() {
        //     var id = $(this).attr('id');
        //     $.ajax({
        //         url: "{{ route('get-binding-docs') }}",
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         method: "POST",
        //         data: {
        //             id: id
        //         },
        //         success: function(data) {
        //             addExistingFiles(data);
        //             $('#resendRTBModal').modal('show');
        //         },
        //         error: function() {
        //             Swal.fire({
        //                 title: 'Error',
        //                 text: 'Something went wrong',
        //                 icon: 'error'
        //             });
        //         }
        //     });
        // });

    });
</script>
