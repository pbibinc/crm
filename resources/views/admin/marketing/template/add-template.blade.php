@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Card for Unlayer Editor -->
                    <div class="card shadow">
                        <div class="card-body">
                            <div id='content' style='height: 700px;'></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 mt-4 mt-lg-0">
                    <!-- Template Name Input -->
                    <div class="mb-3">
                        <label for="templateName" class="form-label">Template Name:</label>
                        <input type="text" class="form-control" id="templateName" placeholder="Enter template name">
                    </div>
                    <!-- Save Button -->
                    <div>
                        <button class="btn btn-success w-100" id="saveTemplateButton">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            var output = unlayer.init({
                id: 'content',
                displayMode: 'email',
                projectId: 220982,
                safeHtml: true,
                tools: {
                    form: {
                        properties: {
                            "name": "first_name",
                            "type": "text",
                            "label": "First Name",
                            "placeholder_text": "Enter first name here",
                            "show_label": true,
                            "required": true
                        },
                    }
                }
            });

            $('#saveTemplateButton').click(function() {
                var templateName = $('#templateName').val();
                unlayer.exportHtml(function(data) {
                    var designJson = JSON.stringify(data.design);
                    $.ajax({
                        url: "{{ route('admin.marketingtemplate.store') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "templateName": templateName,
                            "design": designJson,
                            "html": `"${data.html}"`,
                            "type": "added"
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Template has been saved successfully!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        },
                        error: function(response) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong!',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                });
            });

        })
    </script>
@endsection
