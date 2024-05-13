@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow">
                        <div class="card-body">
                            <div id='edit-content' style='height:700px;'></div>
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
            $('#templateName').val("{{ $template->name }}");
            var id = "{{ $template->id }}";
            const editor = unlayer.createEditor({
                id: 'edit-content',
                displayMode: 'email',
                projectId: 220982,
                safeHtml: true,
            });

            var designJson = @json($template->design);
            if ("{{ $template->type }}" == "imported") {
                var parsedDesign = JSON.parse(designJson);
                editor.loadDesign(JSON.parse(parsedDesign));
            } else {
                editor.loadDesign(JSON.parse(designJson));
            }

            unlayer.addEventListener('design:updated', function(updates) {});
            $('#saveTemplateButton').on('click', function() {
                var templateName = $('#templateName').val();
                editor.exportHtml(function(data) {

                    // console.log('design', data.design);
                    var designJson = JSON.stringify(data.design);
                    // var htmlJson = JSON.data.html);
                    $.ajax({
                        url: `/admin/marketing/template/${id}`,
                        type: "PUT",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "templateName": templateName,
                            "design": designJson,
                            "html": `"${data.html}"`,
                            "id": id
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Template has been saved successfully!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                location.reload();
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
                editor.saveDesign(function(design) {
                    // var designJson = JSON.stringify(design);
                    // console.log(designJson);
                    // $.ajax({
                    //     url: `/admin/marketing/template/${id}`,
                    //     type: "PUT",
                    //     data: {
                    //         "_token": "{{ csrf_token() }}",
                    //         "templateName": templateName,
                    //         "design": designJson,
                    //         "id": id
                    //     },
                    //     success: function(response) {
                    //         Swal.fire({
                    //             title: 'Success!',
                    //             text: 'Template has been saved successfully!',
                    //             icon: 'success',
                    //             confirmButtonText: 'OK'
                    //         }).then((result) => {
                    //             location.reload();
                    //         });
                    //     },
                    //     error: function(response) {
                    //         Swal.fire({
                    //             title: 'Error!',
                    //             text: 'Something went wrong!',
                    //             icon: 'error',
                    //             confirmButtonText: 'OK'
                    //         });
                    //     }
                    // });
                });
            });
        });
    </script>
@endsection
