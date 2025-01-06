<div class="row">
    <div class="col-4">
        <div class="card"
            style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 8px;">
            <div class="card-header">
                <h5>Pending</h5>
            </div>
            <div class="card-body">
                <div id="pendingTask"></div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card"
            style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 8px;">
            <div class="card-header">
                <h5>Ongoing</h5>
            </div>
            <div class="card-body">
                <div id="ongoingTask"></div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card"
            style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 8px;">
            <div class="card-header">
                <h5>Completed</h5>
            </div>
            <div class="card-body">
                <div id="completedTask"></div>
            </div>
        </div>
    </div>
</div>
@include('notification.task-modal', [
    'userProfiles' => $userProfiles,
]);
<script>
    $(document).ready(function() {
        getTaskList('pending', pendingTask);
        getTaskList('ongoing', ongoingTask);
        getTaskList('completed', completedTask);
        $('#taskScheduleForm').on('submit', function(e) {
            e.preventDefault();
            var taskScheduleSubmit = $('#taskScheduleSubmit');
            var laddaButton = Ladda.create(taskScheduleSubmit[0]);
            laddaButton.start();
            $.ajax({
                url: "{{ route('task-scheduler.update', ':id') }}".replace(':id', $(
                        '#taskScheduleId')
                    .val()),
                method: 'PUT',
                data: $('#taskScheduleForm').serialize(),
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Task has been scheduled',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#taskSchedulerModal').modal('hide');
                            getTaskList('pending', pendingTask);
                            getTaskList('ongoing', ongoingTask);
                            getTaskList('completed', completedTask);
                            laddaButton.stop();
                        }
                    });
                },
                error: function(xhr, status, error) {
                    laddaButton.stop();
                    Swal.fire({
                        title: 'Error!',
                        text: 'Task has not been scheduled',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }
            });
        });

        // Helper function to format the date
        function formatDate(dateString) {
            var options = {
                weekday: 'long',

                month: 'short',
                day: 'numeric'
            };
            var date = new Date(dateString);
            return date.toLocaleDateString('en-US', options);
        }

        function getDueDateColor(dateString) {
            var currentDate = new Date();
            var taskDate = new Date(dateString);
            var timeDiff = taskDate - currentDate;
            var dayDiff = timeDiff / (1000 * 60 * 60 * 24); // Convert milliseconds to days

            if (dayDiff < 0) {
                // Overdue tasks (in the past)
                return 'bg-danger';
            } else if (dayDiff <= 7) {
                // Due soon (within the next 7 days)
                return 'bg-success';
            } else {
                // Tasks that are farther out
                return 'bg-info';
            }
        }

        var assetUrl = "{{ asset('') }}";
        var baseUrl = "{{ url('/') }}";

        function renderPagination(response, divId, status) {

            var paginationContainer = $(divId).next('.pagination-container');
            if (paginationContainer.length === 0) {
                paginationContainer = $('<div></div>').addClass('pagination-container mt-3');
                $(divId).after(paginationContainer);
            }

            paginationContainer.empty();

            var paginationHtml =
                `<nav aria-label="Page navigation"><ul class="pagination justify-content-center">`;

            // Loop through links and render each
            response.data.links.forEach(link => {
                if (link.url === null) {
                    // Render disabled button for null URLs
                    paginationHtml += `<li class="page-item disabled">
                <span class="page-link">${link.label}</span>
            </li>`;
                } else if (link.active) {
                    // Render active page
                    paginationHtml += `<li class="page-item active">
                <span class="page-link">${link.label}</span>
            </li>`;
                } else {
                    // Render clickable page links
                    paginationHtml += `<li class="page-item">
                <a class="page-link" href="#" data-url="${link.url}">${link.label}</a>
            </li>`;
                }
            });

            paginationHtml += `</ul></nav>`;
            paginationContainer.html(paginationHtml);
            $(divId).after(paginationContainer);

            // Bind click events to pagination links
            $('.pagination a').on('click', function(e) {
                e.preventDefault();
                var url = $(this).data('url'); // Get URL from data attribute
                if (url) {
                    var page = url.split('page=')[1];
                    getTaskList(status, divId, page); // Fetch tasks for the selected page
                }
            });
        }

        function getTaskList(status, divId, page = 1) {
            $.ajax({
                url: "{{ route('get-task-by-status') }}", // Ensure this is your route for getting the tasks
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    status: status,
                    page: page
                },
                success: function(response) {
                    // Assuming 'tasks' is the array of task objects returned in the response
                    var tasks = response.data;

                    // Clear the existing task list
                    $(divId).empty();

                    tasks.data.forEach(function(task) {
                        // Create the main task item div
                        var taskItem = $('<div></div>')
                            .addClass(
                                'list-group-item d-flex justify-content-between align-items-center'
                            );

                        // Task content with checkbox, task name, and assignee circle
                        var taskContent = $('<div></div>')
                            .addClass('d-flex align-items-center')
                            // Checkbox
                            .append($('<input>')
                                .addClass('form-check-input me-2 taskScheduler-box')
                                .attr('type', 'checkbox')
                                .attr('value', task.id)
                            )

                            // Assignee circle (representing user with initials or placeholder)
                            .append(
                                $('<img>')
                                .addClass('rounded-circle')
                                .css({
                                    width: '25px', // Small circle size
                                    height: '25px', // Small circle size
                                    marginRight: '10px',
                                    objectFit: 'cover' // Ensures the image fits properly inside the circle
                                })
                                .attr('src', task.assigned_by.media ?
                                    assetUrl + task.assigned_by.media.filepath :
                                    assetUrl +
                                    'path/to/default-avatar.jpg' // Fallback to default avatar
                                )
                            )
                            .append($('<span></span>').text(task.description));

                        // Color coding for the due date badge
                        var dueDateColor = getDueDateColor(task.date_schedule);

                        var taskDueDate = $('<span></span>')
                            .addClass('badge rounded-pill')
                            .addClass(dueDateColor) // Set color based on date
                            .text(formatDate(task
                                .date_schedule
                            )); // Use a helper function to format the date


                        // Add the task status with color coding

                        var taskAction = $('<a></a>')
                            .addClass('')
                            .text('...')
                            .attr('id', task.leads_id)
                            .attr('href', `${baseUrl}/appointed-list/${task.leads_id}`);

                        // Append task content and due date badge to the task item
                        taskItem.append(taskContent, taskDueDate);

                        // Append the task item to the task list
                        $(divId).append(taskItem);
                    });

                    // Render pagination
                    renderPagination(response, divId, status);
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred while fetching the task list: ", error);
                }
            });
        }

        $(document).on('click', '.taskScheduler-box', function(e) {
            e.preventDefault();
            var id = $(this).val();

            $.ajax({
                url: "{{ route('task-scheduler.edit', ':id') }}".replace(':id',
                    id), // Fix the replacement for the ID
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    console.log(response);

                    // Populate modal fields with the response data
                    $('#taskAssignTo').val(response.data.assigned_to);
                    $('#taskStatus').val(response.data.status);
                    let taskDate = new Date(response.data
                        .date_schedule); // Convert to a Date object

                    // Adjust for timezone offset
                    let localDate = new Date(taskDate.getTime() + Math.abs(taskDate
                        .getTimezoneOffset() * 60000));
                    // Format to YYYY-MM-DD
                    let formattedDate = localDate.toISOString().split('T')[0];
                    $('#taskDate').val(formattedDate);
                    $('#taskSchedulerStatus').val(response.data.status);
                    $('#taskDescription').val(response.data.description);
                    $('#taskScheduleId').val(response.data.id);
                    $('#leadId').val(response.data.leads_id);
                    $('#taskScheduleAction').val('update');
                    $('#taskSchedulerModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: ", error);
                }
            });
        });

    });
</script>
