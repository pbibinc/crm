<div class="card shadow-lg p-3 mb-5 bg-white rounded">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Payments</h4>
        <button class="btn btn-success" id="addScheduleButton">
            ADD SCHEDULED EMAIL
        </button>
    </div>
    <div class="card-body">
        <table id="emailDataTable" class="table table-bordered dt-responsive nowrap emailDataTable"
            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr style="background-color: #f0f0f0;">
                    <th>Product</th>
                    <th>Receiver Email</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Sent Out Date</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addScheduleModalTitle">Email Scheduler</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="emailScheduleForm">
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
                                <input type="datetime-local" name="dateTime" id="emailScheduleDateTime"
                                    class="form-control">
                                <input type="hidden" id="hiddenMessageId" name="hiddenMessageId">
                                <input type="hidden" name="action" id="action">
                            </div>
                        </div>
                    </div>
                    <div class="row" id="emailStatusDivRow" hidden>
                        <div class="col-6">
                            <label for="">Status</label>
                            <select name="" id="emailStatusDropdown" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="sent">Sent</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary ladda-button" data-style="expand-right"
                        id="submitEmailSchedule">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#emailDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ route('get-clients-emails') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: "{{ $leadId }}"
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
                    data: 'email_status',
                    name: 'email_status'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'formatted_sent_out_date',
                    name: 'formatted_sent_out_date'
                },
                {
                    data: 'action',
                    name: 'action'
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

        $('#submitEmailSchedule').on('click', function() {
            var action = $('#action').val();
            var messageId = $('#hiddenMessageId').val();
            var url = action == 'edit' ? "{{ route('messages.update', ':id') }}".replace(':id',
                    messageId) :
                "{{ route('messages.store') }}";
            var method = action == 'edit' ? 'PUT' : 'POST';
            var dataTime = $('#emailScheduleDateTime').val();
            var templateId = $('#templateDropdown').val();
            var type = $('#template option:selected').text();
            var emailStatusDropdown = $('#emailStatusDropdown').val();
            var submitEmailSchedule = $('#submitEmailSchedule');
            var laddaButton = Ladda.create(submitEmailSchedule[0]);
            laddaButton.start();
            $.ajax({
                url: url,
                type: method,
                data: {
                    _token: "{{ csrf_token() }}",
                    productId: null,
                    dateTime: dataTime,
                    templateId: templateId,
                    type: selectedTemplateName,
                    emailStatusDropdown: emailStatusDropdown,
                },
                success: function(response) {
                    laddaButton.stop();
                    Swal.fire({
                        title: 'Success!',
                        text: 'Email has been scheduled successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {

                        $('#addScheduleModal').modal('hide');
                        $('#emailDataTable').DataTable().ajax.reload();
                    });
                },
                error: function(response) {
                    laddaButton.stop();
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        $('#addScheduleModal').on('hidden.bs.modal', function() {
            $('#templateDropdown').val('');
            $('#emailScheduleDateTime').val('');
            $('#emailStatusDivRow').attr('hidden', true);
        });

        $(document).on('click', '.editScheduledEmail', function() {
            var id = $(this).attr('id');
            $.ajax({
                url: "{{ route('messages.edit', ':id') }}".replace(':id', id),
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    $('#action').val('edit');
                    $('#hiddenMessageId').val(response.message.id);
                    $('#templateDropdown').val(response.message.template_id);
                    $('#emailScheduleDateTime').val(response.message.sending_date);
                    $('#emailStatusDivRow').attr('hidden', false);
                    $('#addScheduleModal').modal('show');
                }
            })
        });

    });
</script>
