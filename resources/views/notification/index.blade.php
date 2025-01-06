@extends('admin.admin_master')
@section('admin')
    <div class="page-content pt-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card"
                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); border-radius: 10px; overflow: hidden;">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#notification" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Notification</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#task" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Task</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#calendar" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Calendar</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="notification" role="tabpanel">
                                    @include('notification.notification-list')
                                </div>
                                <div class="tab-pane " id="task" role="tabpanel">
                                    @include('notification.task', [
                                        'userProfiles' => $userProfiles,
                                    ])
                                </div>
                                <div class="tab-pane " id="calendar" role="tabpanel">
                                    <div class="card">
                                        <div class="card-body">
                                            <button class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#addeventModal">Add Event</button>
                                            </button>
                                        </div>
                                    </div>
                                    <div id="sampleCalendar"></div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="addeventModal" tabindex="-1" aria-labelledby="addeventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addeventModalLabel">Add Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="eventForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="title">Event Title</label>
                                    <input type="text" class="form-control" id="title" name="title">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="taskName">Date</label>
                                    <input type="date" class="form-control" id="date" name="date">
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="taskName">Description</label>
                                    <textarea type="text" rows='5' class="form-control" id="description" name="description">
                            </textarea>
                                </div>

                            </div>
                        </div>

                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary ladda-button"
                            data-style="expand-right">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var calendarEvents = []; // Declare calendarEvents as global variable
            getActivityLog();

            function getActivityLog() {
                $.ajax({
                    url: "{{ route('get-activity-log') }}",
                    method: "GET",
                    success: function(data) {
                        console.log(data);

                        // Build the calendarEvents array
                        calendarEvents = data.data.map(event => {
                            var eventName = event.status + ' ' + 'task status';
                            return {
                                id: event.id,
                                name: event.name,
                                date: event.date,
                                description: event.description, // Event description (optional)
                                type: event.type,
                                everyYear: false,
                                color: event.color,
                            };
                        });
                        // // Call the function to initialize the calendar after data is received and processed
                        initializeCalendar(calendarEvents);
                    },
                    error: function(err) {

                        console.log(err);
                    }
                });
            }

            function initializeCalendar(calendarEvents) {
                $("#sampleCalendar").evoCalendar({
                    language: 'en',
                    theme: 'Royal Navy',
                    getActiveEvent: true,
                    todayHighlight: true,
                    calendarEvents: calendarEvents, // Use the dynamically built array
                });
            }

            $('#eventForm').on('submit', function(e) {
                e.preventDefault();
                var title = $('#title').val();
                var date = $('#date').val();
                var description = $('#description').val();
                var laddaEventButton = Ladda.create($('#eventForm button[type="submit"]')[0]);
                laddaEventButton.start();
                $.ajax({
                    url: "{{ route('activity-log.store') }}",
                    method: "POST",
                    data: {
                        title: title,
                        date: date,
                        description: description,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Event has been saved',
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                laddaEventButton.stop();
                                $('#addeventModal').modal('hide');
                                // $('#eventForm')[0].reset();
                                // getActivityLog();
                                location.reload();
                            }
                        });


                    },
                    error: function(err) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Something went wrong',
                            icon: 'error'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                laddaEventButton.stop();
                                console.log(err);
                            }
                        });
                    }
                });
            })
        })
    </script>
@endsection
