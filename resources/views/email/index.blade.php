<div class="row mb-2">
    <div class="d-flex justify-content-between">
        <div>

        </div>
        <div>
            <button class="btn btn-success" id="addScheduleButton">
                ADD SCHEDULED EMAIL
            </button>
        </div>
    </div>
</div>

<table id="emailDataTable" class="table table-bordered dt-responsive nowrap emailDataTable"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr style="background-color: #f0f0f0;">
            <th>Product</th>
            <th>Receiver Email</th>
            <th>Status</th>
            <th>Type</th>
            <th>Sent Out Date</th>
        </tr>
    </thead>
</table>

<div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addScheduleModalTitle">Email Scheduler</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-6">
                        <label for="">Templates</label>
                        <div>
                            <select name="" id="templateDropdown" class="form-select">
                                <option value="">Select...</option>
                                @foreach ($templates as $template)
                                    <option id="template" value={{ $template->id }}>{{ $template->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="">Sent Out Date</label>
                        <div>
                            <input type="datetime-local" name="dateTime" id="dateTime" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitSchedule">Submit</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#emailDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ route('get-messages') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    productId: "{{ $productId }}"
                }
            },
            "columns": [{
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'receiver_email',
                    name: 'receiver_email'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'sending_date',
                    name: 'sending_date'
                }
            ]
        });

        $('#addScheduleButton').on('click', function() {
            $('#addScheduleModal').modal('show');
        });
        var selectedTemplateName = '';
        $('#templateDropdown').change(function() {
            selectedTemplateName = $(this).find(":selected").text();
        });

        $('#submitSchedule').on('click', function() {
            var dataTime = $('#dateTime').val();
            var templateId = $('#templateDropdown').val();
            var type = $('#template option:selected').text();
            console.log(selectedTemplateName);
            $.ajax({
                url: "{{ route('messages.store') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    productId: "{{ $productId }}",
                    dateTime: dataTime,
                    templateId: templateId,
                    type: selectedTemplateName
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Email has been scheduled successfully!',
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
    });
</script>
