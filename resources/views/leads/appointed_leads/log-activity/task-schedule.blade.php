<div class="row">

    <table id="taskScheduleTable" class="table table-bordered dt-responsive nowrap taskScheduleTable"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>Description</th>
                <th>Status</th>
                <th>Assigned To</th>
                <th>Assigned By</th>
                <th>Date Schedule</th>
            </tr>
        </thead>
    </table>
</div>

<script>
    $(document).ready(function() {
        var leadId = "{{ $leads->id }}";
        console.dir(leadId);
        $('.taskScheduleTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('get-task-scheduler-list') }}",
                method: 'POST',
                async: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    leadId: leadId
                }
            },
            columns: [{
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'assigned_to',
                    name: 'assigned_to'
                },
                {
                    data: 'assigned_by',
                    name: 'assigned_by'
                },
                {
                    data: 'date_schedule',
                    name: 'date_schedule'
                }
            ],
        });
    });
</script>
