<div class="modal fade" id="taskSchedulerModal" tabindex="-1" aria-labelledby="taskSchedulerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskSchedulerModalLabel">Task Scheduler</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="taskScheduleForm">
                @csrf
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-4">
                            <label for="taskDescription" class="form-label">Assign To</label>
                            <select class="form-select" id="taskAssignTo" name="taskAssignTo">
                                <option selected>Choose...</option>
                                @foreach ($userProfiles as $userProfile)
                                    <option value="{{ $userProfile->id }}">
                                        {{ $userProfile->firstname . ' ' . $userProfile->lastname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="taskStatus" class="form-label">Status</label>
                            <select name="taskStatus" class="form-select" id="taskStatus">
                                <option selected>Choose...</option>
                                <option value="Pending" selected>Pending</option>
                                <option value="Ongoing">Ongoing</option>
                                <option value="Remove">Remove</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="taskDate" class="form-label">Task Date</label>
                            <input type="date" class="form-control" id="taskDate" name="taskDate">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="taskDescription" class="form-label">Task Description</label>
                            <textarea class="form-control" id="taskDescription" name="taskDescription" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" value={{ $leadId }} name="leadId">
                <input type="hidden" name="taskScheduleId" id="taskScheduleId">
                <div class="modal-footer">
                    <input type="hidden" name="taskScheduleAction" id="taskScheduleAction">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

    });
</script>
