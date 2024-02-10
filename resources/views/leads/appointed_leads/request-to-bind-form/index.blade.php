<div class="modal fade bs-example-modal-center" id="requestToBindModal" tabindex="-1" role="dialog"
    aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestToBindModalTitle">Upload Request To Bind Files</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="rtbForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <input type="file" class="form-control" id="files" name="files[]" multiple>
                        </div>
                    </div>

                    <input type="hidden" id="id" name="id" value="{{ $quoteProduct->id }}">
            </div>

            <div class="modal-footer">
                <input type="submit" name="sendRequesToBindFile" id="sendRequesToBindFile" value="Submit"
                    class="btn btn-success">
                <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#sendRequesToBindFile').on('click', function(e) {
            e.preventDefault();
            var formData = new FormData($('#rtbForm')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                url: "{{ route('product-save-media') }}",
                method: "POST",
                data: formData,
                // dataType: "json",
                contentType: false,
                // cache: false,
                processData: false,
                success: function(data) {
                    $.ajax({
                        url: "{{ route('change-quotation-status') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        },
                        method: "POST",
                        data: {
                            status: 6,
                            id: {!! json_encode($quoteProduct->id) !!}
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
                },
                error: function(e) {
                    console.log(e);
                    Swal.fire({
                        title: 'Error',
                        text: 'Something went wrong',
                        icon: 'error'
                    });
                }
            });
        });
    });
</script>
