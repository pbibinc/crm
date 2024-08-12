@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-4">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Accountability Form</h2>
                            {{-- <p class="card-title-desc">Parsley is a javascript form validation
                            library. It helps you provide your users with feedback on their form
                            submission before sending it to your server.</p> --}}

                            <form method="POST" id="formAccountability">
                                @csrf
                                <div class="mb-3">
                                    <label>Name of User</label>
                                    <input type="text" class="form-control" name="user_name" id="user_name" required
                                        placeholder="Type user" autocomplete="off" />
                                </div>

                                <div class="mb-3 d-flex justify-content-between">
                                    <h4 class="card-title">Item 1</h4>
                                    <button type="button"
                                        class="add_record_btn btn btn-success waves-effect waves-light">Add Record
                                        +</button>
                                </div>

                                <div class="mb-3">
                                    <label>SN:</label>
                                    <div>
                                        <input type="text" class="form-control" name="sn1" id="sn1" required
                                            placeholder="Serial No." autocomplete="off" />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Description:</label>
                                    <div>
                                        <textarea class="form-control" rows="5" name="description1" id="description1" placeholder="E.g: Jabra Biz 2300"
                                            required></textarea>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Qty:</label>
                                    <div>
                                        <input type="text" class="form-control" name="qty1" id="qty1" required
                                            placeholder="1-99" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Unit Price:</label>
                                    <div>
                                        <input type="text" class="form-control" name="unit_price1" id="unit_price1"
                                            required placeholder="₱ 999" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Amount:</label>
                                    <div>
                                        <input type="text" class="form-control" name="amount1" id="amount1" required
                                            placeholder="₱ 999" autocomplete="off" />
                                    </div>
                                </div>

                                <div id="addRecordDiv"></div>
                                <div class="mb-0">
                                    <div>
                                        <button type="submit" name="generate_record_btn"
                                            class="btn btn-primary waves-effect waves-light me-1">Generate Record</button>
                                        {{-- <button type="reset" name="download_record_btn" class="btn btn-info waves-effect">
                                        Download
                                    </button> --}}
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>

        </div>
    </div>

    <script>
        let counter = 2;
        $(".add_record_btn").click(function(e) {
            e.preventDefault();

            // Generate a unique ID based on the current timestamp
            const uniqueId = counter++;

            // Create the new form elements using template literals
            const newFormElements = `
                <div class="mb-3 d-flex justify-content-between">
                    <h4 class="card-title">Item ${uniqueId}</h4>
                </div>

                <div class="mb-3">
                    <label>SN:</label>
                    <div>
                        <input type="text" class="form-control" name="sn${uniqueId}" id="sn${uniqueId}" required placeholder="Serial No." autocomplete="off"/>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Description:</label>
                    <div>
                        <textarea class="form-control" rows="5" name="description${uniqueId}" id="description${uniqueId}" placeholder="E.g: Jabra Biz 2300" required></textarea>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Qty:</label>
                    <div>
                        <input type="text" class="form-control" name="qty${uniqueId}" id="qty${uniqueId}" required placeholder="1-99" autocomplete="off"/>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Unit Price:</label>
                    <div>
                        <input type="text" class="form-control" name="unit_price${uniqueId}" id="unit_price${uniqueId}" required placeholder="₱ 999" autocomplete="off"/>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Amount:</label>
                    <div>
                        <input type="text" class="form-control" name="amount${uniqueId}" id="amount${uniqueId}" required placeholder="₱ 999" autocomplete="off"/>
                    </div>
                </div>
        `;

            // Append the new form elements to the container
            $("#addRecordDiv").append(newFormElements);
        });


        $("#formAccountability").on("submit", function() {

            // Create an empty object to store form data
            const formData = {
                user_name: $('#user_name').val(),
                records: []
            };

            // Loop through the form elements and add their ID and value to the formData array
            for (let i = 1; i < counter; i++) {
                let recordData = {
                    [`sn${i}`]: $(`#sn${i}`).val(),
                    [`description${i}`]: $(`#description${i}`).val(),
                    [`qty${i}`]: $(`#qty${i}`).val(),
                    [`unit_price${i}`]: $(`#unit_price${i}`).val(),
                    [`amount${i}`]: $(`#amount${i}`).val(),
                };

                formData.records.push(recordData);
            }

            // Convert formData object to a JSON string
            const formDataJson = JSON.stringify(formData);

            // Send the form data using AJAX
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('hrforms.accountability-form-generate-pdf') }}",
                type: 'POST',
                data: formDataJson,
                success: function(response) {
                    if (response.success && response.pdf_base64) {
                        // Convert the base64-encoded PDF content to a Blob
                        const binaryPdf = atob(response.pdf_base64);
                        const len = binaryPdf.length;
                        const buffer = new ArrayBuffer(len);
                        const view = new Uint8Array(buffer);
                        for (let i = 0; i < len; i++) {
                            view[i] = binaryPdf.charCodeAt(i);
                        }
                        const blob = new Blob([view], {
                            type: 'application/pdf'
                        });

                        // Create an object URL for the Blob and redirect to it
                        const objectUrl = URL.createObjectURL(blob);
                        window.location.href = objectUrl;
                    } else {
                        // Handle errors or unexpected response from your Laravel application
                        console.error('Error: Something went wrong.');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors from your Laravel application
                    console.error('Error:', error);
                }
            });
        });
    </script>
@endsection
