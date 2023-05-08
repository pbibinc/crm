@extends('admin.admin_master')
@section('admin')

<div class="page-content pt-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('leads.import') }}" method="POST" id="import-form" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" class="form-control" required>
                            <br>
                            <div class="d-inline-block">
                                <button class="btn btn-primary" id="import">Import User Data</button>
                            </div>
                            <button class="buttonload">
                                <i class="fa fa-circle-o-notch fa-spin"></i>Loading
                              </button>
                            {{-- <div class="spinner-border text-dark m-1 d-inline-block align-middle" id="preloader" role="status">
                                <span class="sr-only">Loading...</span>
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive nowrap" id="dataTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Company Name</th>
                                        <th>Tel Number</th>
                                        <th>State abbr</th>
                                        <th>Website Originated</th>
                                        <th>Disposition Name</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // DATA TABLE
    $(document).ready(function() {
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('leads') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'company_name', name: 'company_name'},
                {data: 'tel_num', name: 'tel_num'},
                {data: 'state_abbr', name: 'state_abbr'},
                {data: 'website_originated', name: 'website_originated'},
                {data: 'disposition_name', name: 'disposition_name'},
                {data: 'created_at_formatted', name: 'created_at', searchable:false},
                {data: 'updated_at_formatted', name: 'updated_at', searchable:false},
                // {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });

    // $(document).ready(function() {
    //     $("#import-form").on("submit", function(e) {
    //         e.preventDefault();

    //         // Get form data
    //         var formData = new FormData(this);

    //         $.ajax({
    //             url: "{{ route('leads.import') }}",
    //             type: "POST",
    //             data: formData,
    //             contentType: false,
    //             processData: false,
    //             beforeSend: function() {
    //                 // Show preloader
    //                 $("#preloader").removeClass("d-none");

    //                 // Disable the button to prevent multiple submissions
    //                 $("#import").prop("disabled", true);
    //             },
    //             success: function(response) {
    //                 // Handle success
    //                 console.log(response);
    //             },
    //             error: function(xhr, status, error) {
    //                 // Handle error
    //                 console.error(xhr, status, error);
    //             },
    //             complete: function() {
    //                 // Hide preloader
    //                 $("#preloader").addClass("d-none");

    //                 // Enable the button
    //                 $("#import").prop("disabled", false);
    //             }
    //         });
    //     });
    // });

</script>
@endsection
