@extends('admin.admin_master')
@section('admin')

<div class="page-content">

    <style>
        #preloader-row .custom-loader {
            /* Start Center Items on Table */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 10px;
            /* End Center Items on Table */
            width:50px;
            height:12px;
            background: 
                radial-gradient(circle closest-side,#0170A8 90%,#0000) 0%   50%,
                radial-gradient(circle closest-side,#0170A8 90%,#0000) 50%  50%,
                radial-gradient(circle closest-side,#0170A8 90%,#0000) 100% 50%;
            background-size:calc(100%/3) 100%;
            background-repeat: no-repeat;
            animation:d7 1s infinite linear;
        }
        @keyframes d7 {
            33%{background-size:calc(100%/3) 0%  ,calc(100%/3) 100%,calc(100%/3) 100%}
            50%{background-size:calc(100%/3) 100%,calc(100%/3) 0%  ,calc(100%/3) 100%}
            66%{background-size:calc(100%/3) 100%,calc(100%/3) 100%,calc(100%/3) 0%  }
        }
    </style>

    <div id="calendar"></div>

</div>
<!-- End Page-content -->

<!-- Add the evo-calendar.js for.. obviously, functionality! -->


<script>

    var calendarEvents = []; // Declare calendarEvents as global variable

    $.ajax({
        url: "{{ route('hrforms.birthday-calendar-get-birthdays') }}", // Your API route
        method: "GET",
        success: function(data) {
            // Build the calendarEvents array
            calendarEvents = data.map(event => {
                return {
                    id: event.id,
                    name: event.name,
                    date: event.date,
                    description: `Today is the birthday of ${event.name}! Wish him a happy birthday!`, // Event description (optional)
                    type: event.type,
                    everyYear: event.everyYear
                };
            });
            // Call the function to initialize the calendar after data is received and processed
            initializeCalendar(calendarEvents);
        },
        error: function(err) {
            // Handle error here
            console.log(err);
        }
    });
    
    function initializeCalendar(calendarEvents) {
        $("#calendar").evoCalendar({
            language: 'en',
            theme: 'Royal Navy',
            getActiveEvent: true,
            todayHighlight: true,
            calendarEvents: calendarEvents,  // Use the dynamically built array
        });
    }
</script>
@endsection