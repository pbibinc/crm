@extends('admin.admin_master')
@section('admin')

<style>
    .loader {
        display: inline-block;
        width: 24px;
        height: 24px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #3498db;
        border-radius: 50%;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    .large-textarea {
        width: 100%;
        height: 500px;
    }
</style>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Company Handbook</h4>
                        <p class="card-title-desc">Here you can edit the company handbook anytime.</p>
                        <form id="companyHandbookForm">
                            @csrf
                            <textarea id="elm1" name="description" class="large-textarea">{!! $result->description ?? "" !!}</textarea>

                            <div class="mt-3">
                                <button type="submit" name="save_record_btn" class="btn btn-primary waves-effect waves-light me-1">Save Record</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<script>


    $("#companyHandbookForm").on("submit", function (e) {
        e.preventDefault();

        var saveButton = $('button[name="save_record_btn"]');
        var originalSaveButtonContent = saveButton.html();

        // Send the form data using AJAX
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('hrforms.company-handbook-save-or-update') }}",
            type: 'POST',
            data: {
                description: tinymce.get('elm1').getContent(),
                _token: $('input[name="_token"]').val(),
            },
            beforeSend: function () {
                saveButton.html('<div class="loader"></div>');
            },
            success: function (response) {
                console.log(response.incomingfields);
                saveButton.html(originalSaveButtonContent);
            },
            error: function (xhr, status, error) {
                // Handle errors from your Laravel application
                console.error('Error:', error);
                saveButton.html(originalSaveButtonContent);
            }
        });
    });

</script>

@endsection